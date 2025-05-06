<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;
use App\Models\SavedCompetition;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CompetitionController extends Controller
{
    
    public function explore(Request $request)
    {
        $query = Competition::query();

        $query->where('deadline', '>=', now());

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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competitions = \App\Models\Competition::latest()->paginate(12); // 12 item per page
        return view('competitions.explore', compact('competitions')); 
    }

    // 🆕 Lihat detail kompetisi
    public function show(Competition $competition)
    {
        return view('competitions.show', compact('competition'));
    }

    // 🆕 Cari anggota tim random
    public function randomMembers(Competition $competition)
    {
        $randomUsers = User::where('role', 'user') // ambil user mahasiswa saja
                            ->inRandomOrder()
                            ->limit(9)
                            ->get();
        return view('competitions.random_members', compact('competition', 'randomUsers'));
    }

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
}
