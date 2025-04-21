<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CompetitionController extends Controller
{
    /**
     * CompetitionController manages all competition-related functionality.
     * Access control is handled via route middleware.
     */

    /**
     * Display a listing of the competitions for the authenticated organizer.
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            // Admins can see all competitions with organizer info
            $competitions = Competition::with('organizer')->latest()->paginate(10);
            return view('competitions.index', compact('competitions'));
        } elseif (Auth::user()->isOrganizer()) {
            // Organizers can see only their competitions
            $competitions = Auth::user()->organizedCompetitions()->latest()->paginate(10);
            return view('competitions.index', compact('competitions'));
        } else {
            // Students/users see public available competitions
            return redirect()->route('competitions.public');
        }
    }

    /**
     * Display public listing of available competitions for students
     */
    public function public()
    {
        $competitions = Competition::where('status', 'open')
            ->where('registration_deadline', '>=', now())
            ->latest()
            ->paginate(12);
        
        return view('competitions.public', compact('competitions'));
    }

    /**
     * Show the form for creating a new competition.
     */
    public function create()
    {
        return view('competitions.create');
    }

    /**
     * Store a newly created competition in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'registration_deadline' => 'required|date|before:start_date',
            'max_participants' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048', // 2MB max
            'external_registration_link' => 'required|url',
            'status' => ['required', Rule::in(['open', 'closed', 'completed'])],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('competitions', 'public');
            $validated['image'] = $path;
        }

        $validated['organizer_id'] = Auth::id();
        
        Competition::create($validated);
        
        return redirect()->route('competitions.index')
            ->with('success', 'Competition created successfully.');
    }

    /**
     * Display the specified competition.
     */
    public function show(string $id)
    {
        $competition = Competition::with(['organizer', 'registrations.user'])->findOrFail($id);
        
        // Check if the user is authorized to view this competition
        if (!Auth::user()->isAdmin() && 
            !Auth::user()->isOrganizer() && 
            $competition->status !== 'open') {
            abort(403, 'Unauthorized action.');
        }
        
        // If organizer, check if they are the owner
        if (Auth::user()->isOrganizer() && 
            $competition->organizer_id !== Auth::id() && 
            !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('competitions.show', compact('competition'));
    }

    /**
     * Show the form for editing the specified competition.
     */
    public function edit(string $id)
    {
        $competition = Competition::findOrFail($id);
        
        // Only allow the organizer who created the competition or an admin to edit it
        if ($competition->organizer_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('competitions.edit', compact('competition'));
    }

    /**
     * Update the specified competition in storage.
     */
    public function update(Request $request, string $id)
    {
        $competition = Competition::findOrFail($id);
        
        // Only allow the organizer who created the competition or an admin to update it
        if ($competition->organizer_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'registration_deadline' => 'required|date|before:start_date',
            'max_participants' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048', // 2MB max
            'external_registration_link' => 'required|url',
            'status' => ['required', Rule::in(['open', 'closed', 'completed'])],
        ]);
        
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($competition->image) {
                Storage::disk('public')->delete($competition->image);
            }
            
            $path = $request->file('image')->store('competitions', 'public');
            $validated['image'] = $path;
        }
        
        $competition->update($validated);
        
        return redirect()->route('competitions.show', $competition->id)
            ->with('success', 'Competition updated successfully.');
    }

    /**
     * Remove the specified competition from storage.
     */
    public function destroy(string $id)
    {
        $competition = Competition::findOrFail($id);
        
        // Only allow the organizer who created the competition or an admin to delete it
        if ($competition->organizer_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Delete the competition image if it exists
        if ($competition->image) {
            Storage::disk('public')->delete($competition->image);
        }
        
        $competition->delete();
        
        return redirect()->route('competitions.index')
            ->with('success', 'Competition deleted successfully.');
    }
    
    /**
     * Find random potential team members for a competition
     * Returns a list of random users with the 'user' role who could be teammates
     */
    public function findRandomMembers(string $id)
    {
        $competition = Competition::findOrFail($id);
        
        // Get random users with role 'user' (students) excluding the current user
        // Limit to 5 random users for display purposes
        $randomUsers = User::where('role', 'user')
            ->where('id', '!=', Auth::id())
            ->inRandomOrder()
            ->limit(5)
            ->get(['id', 'name', 'email']);
            
        return view('competitions.random_members', [
            'competition' => $competition,
            'randomUsers' => $randomUsers
        ]);
    }
}
