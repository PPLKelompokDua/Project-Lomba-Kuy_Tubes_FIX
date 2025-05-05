<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\User;
use App\Models\SavedCompetition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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
        $competition = Competition::with(['organizer'])->findOrFail($id);
        
        // Temporarily disable strict authorization for development/testing
        // This allows us to view all competitions regardless of status or user role
        
        // In production, we would re-enable these checks:
        /*
        // For non-authenticated users, only show competitions with 'open' status
        if (!Auth::check() && $competition->status !== 'open') {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the user is authorized to view this competition
        if (Auth::check() && !Auth::user()->isAdmin() && 
            !Auth::user()->isOrganizer() && 
            $competition->status !== 'open') {
            abort(403, 'Unauthorized action.');
        }
        
        // If organizer, check if they are the owner
        if (Auth::check() && Auth::user()->isOrganizer() && 
            $competition->organizer_id !== Auth::id() && 
            !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        */
        
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
    /**
     * Find random potential team members for a competition
     * Returns a list of random users with the 'user' role who could be teammates
     * Allows filtering by category to find members with relevant experience
     */
    public function findRandomMembers(string $id, Request $request)
    {
        $competition = Competition::findOrFail($id);
        $category = $request->input('category');
        
        // Get unique categories from competitions table for the filter dropdown
        $categories = Competition::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->toArray();
        
        // Get random users with role 'user' (students) excluding the current user
        $query = User::where('role', 'user')
            ->where('id', '!=', Auth::id());
        
        // If category filter is applied, filter users who have participated in competitions of that category
        if ($category) {
            // Find users who have participated in competitions of this category using DB query
            $userIds = \DB::table('users')
                ->join('registrations', 'users.id', '=', 'registrations.user_id')
                ->join('competitions', 'registrations.competition_id', '=', 'competitions.id')
                ->where('competitions.category', $category)
                ->distinct()
                ->pluck('users.id')
                ->toArray();
            
            // Filter the query to only include those users
            if (!empty($userIds)) {
                $query->whereIn('id', $userIds);
            } else {
                // If no users found with the selected category, still return some users
                // but mark that no exact matches were found
                session()->flash('info', "Tidak ada anggota yang pernah berpartisipasi dalam lomba kategori '$category'. Menampilkan anggota acak.");
            }
        }
        
        $randomUsers = $query->inRandomOrder()
            ->limit(9) // Menggunakan limit 9 sesuai dengan implementasi terbaru
            ->get();
        
        // Add debug info for development
        $debugInfo = [
            'total_competitions' => Competition::count(),
            'competitions_with_categories' => Competition::whereNotNull('category')->where('category', '!=', '')->count(),
            'available_categories' => $categories,
            'total_users' => User::where('role', 'user')->count(),
            'selected_category' => $category,
            'found_users_count' => $randomUsers->count(),
        ];
        
        return view('competitions.random_members', [
            'competition' => $competition,
            'randomUsers' => $randomUsers,
            'categories' => $categories,
            'selectedCategory' => $category,
            'debug' => $debugInfo
        ]);
    }
    
    /**
     * Display list of competitions for exploration with filtering options
     */
    
    public function explore(Request $request)
    {
        $query = Competition::query();

        $query->where('registration_deadline', '>=', now());

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan hadiah
        if ($request->filled('prize_range')) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw('REGEXP_REPLACE(prize, "[^0-9]", "") IS NOT NULL');

                if ($request->prize_range === 'lt1') {
                    $q->whereRaw('CAST(REGEXP_REPLACE(prize, "[^0-9]", "") AS UNSIGNED) < 1000000');
                } elseif ($request->prize_range === '1to2') {
                    $q->whereRaw('CAST(REGEXP_REPLACE(prize, "[^0-9]", "") AS UNSIGNED) BETWEEN 1000000 AND 2000000');
                } elseif ($request->prize_range === 'gt2') {
                    $q->whereRaw('CAST(REGEXP_REPLACE(prize, "[^0-9]", "") AS UNSIGNED) > 2000000');
                }
            });
        }

        // Filter berdasarkan search keyword
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan bookmark
        if ($request->filled('bookmark') && auth()->check()) {
            $savedIds = auth()->user()->savedCompetitions()->pluck('competition_id');
            $query->whereIn('id', $savedIds);
        }

        // 🔥 Sort logic
        if ($request->filled('sort')) {
            if ($request->sort == 'deadline') {
                $query->orderBy('deadline', 'asc');
            } elseif ($request->sort == 'prize') {
                $query->orderByRaw('CAST(REGEXP_REPLACE(prize, "[^0-9]", "") AS UNSIGNED) DESC');
            } else {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Ambil semua kategori unik untuk dropdown
        $categories = Competition::select('category')->distinct()->pluck('category');

        $competitions = $query->latest()->paginate(12)->withQueryString();

        return view('competitions.explore', [
            'competitions' => $competitions,
            'categories' => $categories,
        ]);
    }
    // Definisi index() kedua dihapus untuk menghindari redeclaration error
    // Sudah ada definisi index() di awal controller

    // Definisi show() kedua dihapus untuk menghindari redeclaration error
    // Sudah ada definisi show() di awal controller yang menggunakan string $id

    // Method ini telah digantikan oleh implementasi findRandomMembers di atas
    // dengan fitur filter berdasarkan kategori
    /* public function randomMembers(Competition $competition)
    {
        $randomUsers = User::where('role', 'user') // ambil user mahasiswa saja
                            ->inRandomOrder()
                            ->limit(9)
                            ->get();
        return view('competitions.random_members', compact('competition', 'randomUsers'));
    } */

    public function save(Competition $competition)
    {
        SavedCompetition::firstOrCreate([
            'user_id' => Auth::id(),
            'competition_id' => $competition->id,
        ]);
    
        return back()->with('success', 'Lomba telah disimpan ke bookmark.');
    }

    public function saved()
    {
        $savedCompetitions = SavedCompetition::with('competition')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    
        return view('competitions.saved', compact('savedCompetitions'));
    }
    
    public function unsave(Competition $competition)
    {
        SavedCompetition::where('user_id', Auth::id())
            ->where('competition_id', $competition->id)
            ->delete();
    
        return back()->with('success', 'Lomba berhasil dihapus dari bookmark.');
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->query('query', '');

        $results = Competition::where('title', 'like', "%{$query}%")
                        ->orWhere('category', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->limit(10)
                        ->pluck('title');

        return response()->json($results);
    }
}
