<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * RegistrationController manages all registration-related functionality.
     * Access control is handled via route middleware.
     */

    /**
     * Display a listing of the registrations.
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            // Admins can see all registrations
            $registrations = Registration::with(['competition', 'user'])->latest()->paginate(10);
            return view('registrations.index', compact('registrations'));
        } elseif (Auth::user()->isOrganizer()) {
            // Organizers can see registrations for their competitions
            $registrations = Registration::whereHas('competition', function ($query) {
                $query->where('organizer_id', Auth::id());
            })->with(['competition', 'user'])->latest()->paginate(10);
            return view('registrations.index', compact('registrations'));
        } else {
            // Students/users can see their own registrations
            $registrations = Auth::user()->registrations()->with('competition')->latest()->paginate(10);
            return view('registrations.index', compact('registrations'));
        }
    }

    /**
     * Show the form for creating a new registration.
     */
    public function create(Request $request)
    {
        $competitionId = $request->input('competition_id');
        $competition = Competition::findOrFail($competitionId);
        
        // Check if competition is open for registration
        if ($competition->status !== 'open' || $competition->registration_deadline < now()) {
            return redirect()->route('competitions.public')
                ->with('error', 'Registration for this competition is closed.');
        }

        // Check if the user is already registered
        $existingRegistration = Registration::where('user_id', Auth::id())
            ->where('competition_id', $competitionId)
            ->first();
            
        if ($existingRegistration) {
            return redirect()->route('registrations.show', $existingRegistration->id)
                ->with('info', 'You are already registered for this competition.');
        }
        
        // Check if the competition has reached maximum participants
        if ($competition->max_participants) {
            $participantCount = $competition->registrations()->where('status', 'approved')->count();
            if ($participantCount >= $competition->max_participants) {
                return redirect()->route('competitions.public')
                    ->with('error', 'This competition has reached its maximum number of participants.');
            }
        }
        
        return view('registrations.create', compact('competition'));
    }

    /**
     * Store a newly created registration in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'notes' => 'nullable|string',
            'additional_data' => 'nullable|array',
        ]);

        $competition = Competition::findOrFail($validated['competition_id']);
        
        // Check if competition is open for registration
        if ($competition->status !== 'open' || $competition->registration_deadline < now()) {
            return redirect()->route('competitions.public')
                ->with('error', 'Registration for this competition is closed.');
        }
        
        // Check if the user is already registered
        $existingRegistration = Registration::where('user_id', Auth::id())
            ->where('competition_id', $validated['competition_id'])
            ->first();
            
        if ($existingRegistration) {
            return redirect()->route('registrations.show', $existingRegistration->id)
                ->with('info', 'You are already registered for this competition.');
        }
        
        // Check if the competition has reached maximum participants
        if ($competition->max_participants) {
            $participantCount = $competition->registrations()->where('status', 'approved')->count();
            if ($participantCount >= $competition->max_participants) {
                return redirect()->route('competitions.public')
                    ->with('error', 'This competition has reached its maximum number of participants.');
            }
        }
        
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';
        
        $registration = Registration::create($validated);
        
        return redirect()->route('registrations.show', $registration->id)
            ->with('success', 'Registration submitted successfully. Please wait for approval.');
    }

    /**
     * Display the specified registration.
     */
    public function show(string $id)
    {
        $registration = Registration::with(['competition', 'user'])->findOrFail($id);
        
        // Check if the user is authorized to view this registration
        $this->authorizeRegistrationAccess($registration);
        
        return view('registrations.show', compact('registration'));
    }

    /**
     * Show the form for editing the specified registration.
     */
    public function edit(string $id)
    {
        $registration = Registration::with('competition')->findOrFail($id);
        
        // Only allow editing if the registration belongs to the current user
        // and the registration is still pending and the deadline hasn't passed
        if ($registration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($registration->status !== 'pending') {
            return redirect()->route('registrations.show', $registration->id)
                ->with('error', 'You cannot edit a registration that has been processed.');
        }
        
        if ($registration->competition->registration_deadline < now()) {
            return redirect()->route('registrations.show', $registration->id)
                ->with('error', 'The registration deadline has passed.');
        }
        
        return view('registrations.edit', compact('registration'));
    }

    /**
     * Update the specified registration in storage.
     */
    public function update(Request $request, string $id)
    {
        $registration = Registration::findOrFail($id);
        
        // Check if the user is authorized to update this registration
        $this->authorizeRegistrationAccess($registration);
        
        if (Auth::user()->isAdmin() || 
            (Auth::user()->isOrganizer() && $registration->competition->organizer_id == Auth::id())) {
            // Admin or organizer is updating the registration status
            $validated = $request->validate([
                'status' => 'required|in:pending,approved,rejected',
                'notes' => 'nullable|string',
            ]);
            
            if ($validated['status'] === 'approved') {
                $validated['approved_at'] = now();
                $validated['rejected_at'] = null;
            } elseif ($validated['status'] === 'rejected') {
                $validated['rejected_at'] = now();
                $validated['approved_at'] = null;
            }
            
            $registration->update($validated);
            
            return redirect()->route('registrations.show', $registration->id)
                ->with('success', 'Registration status updated successfully.');
            
        } else {
            // Student/user is updating their registration details
            if ($registration->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
            
            if ($registration->status !== 'pending') {
                return redirect()->route('registrations.show', $registration->id)
                    ->with('error', 'You cannot edit a registration that has been processed.');
            }
            
            if ($registration->competition->registration_deadline < now()) {
                return redirect()->route('registrations.show', $registration->id)
                    ->with('error', 'The registration deadline has passed.');
            }
            
            $validated = $request->validate([
                'notes' => 'nullable|string',
                'additional_data' => 'nullable|array',
            ]);
            
            $registration->update($validated);
            
            return redirect()->route('registrations.show', $registration->id)
                ->with('success', 'Registration updated successfully.');
        }
    }

    /**
     * Remove the specified registration from storage.
     */
    public function destroy(string $id)
    {
        $registration = Registration::findOrFail($id);
        
        // Check if the user is authorized to delete this registration
        if ($registration->user_id !== Auth::id() && 
            !Auth::user()->isAdmin() && 
            !(Auth::user()->isOrganizer() && $registration->competition->organizer_id == Auth::id())) {
            abort(403, 'Unauthorized action.');
        }
        
        // Students can only cancel their registration if it's still pending
        // and the registration deadline hasn't passed
        if (Auth::user()->isStudent() && 
            ($registration->status !== 'pending' || 
             $registration->competition->registration_deadline < now())) {
            return redirect()->route('registrations.show', $registration->id)
                ->with('error', 'You cannot cancel this registration.');
        }
        
        $registration->delete();
        
        return redirect()->route('registrations.index')
            ->with('success', 'Registration canceled successfully.');
    }
    
    /**
     * Approve a registration.
     */
    public function approve(string $id)
    {
        $registration = Registration::findOrFail($id);
        
        // Only admin or the competition organizer can approve registrations
        if (!Auth::user()->isAdmin() && 
            !(Auth::user()->isOrganizer() && $registration->competition->organizer_id == Auth::id())) {
            abort(403, 'Unauthorized action.');
        }
        
        $registration->update([
            'status' => 'approved',
            'approved_at' => now(),
            'rejected_at' => null,
        ]);
        
        return redirect()->route('registrations.show', $registration->id)
            ->with('success', 'Registration approved successfully.');
    }
    
    /**
     * Reject a registration.
     */
    public function reject(string $id)
    {
        $registration = Registration::findOrFail($id);
        
        // Only admin or the competition organizer can reject registrations
        if (!Auth::user()->isAdmin() && 
            !(Auth::user()->isOrganizer() && $registration->competition->organizer_id == Auth::id())) {
            abort(403, 'Unauthorized action.');
        }
        
        $registration->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'approved_at' => null,
        ]);
        
        return redirect()->route('registrations.show', $registration->id)
            ->with('success', 'Registration rejected successfully.');
    }
    
    /**
     * Check if the user is authorized to access this registration.
     */
    private function authorizeRegistrationAccess(Registration $registration)
    {
        if (Auth::user()->isAdmin()) {
            return true; // Admins can access all registrations
        }
        
        if (Auth::user()->isOrganizer() && $registration->competition->organizer_id == Auth::id()) {
            return true; // Organizers can access registrations for their competitions
        }
        
        if ($registration->user_id === Auth::id()) {
            return true; // Users can access their own registrations
        }
        
        abort(403, 'Unauthorized action.');
    }
}
