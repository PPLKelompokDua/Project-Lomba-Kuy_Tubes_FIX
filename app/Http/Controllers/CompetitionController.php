<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;
use App\Models\SavedCompetition;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CompetitionController extends Controller
{
    
    public function explore(Request $request)
    {
        $query = Competition::query();
    
        // Filter kategori (jika ada)
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
    
        // Ambil semua kategori unik untuk dropdown
        $categories = Competition::select('category')->distinct()->pluck('category');
    
        // Filter hadiah (range) dengan parsing ke angka
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

        // filter bookmark
        if (request('bookmark') && auth()->check()) {
            $savedIds = auth()->user()->savedCompetitions()->pluck('competition_id');
            $query->whereIn('id', $savedIds);
        }

        $competitions = $query->paginate(12)->withQueryString();
    
        $competitions = $query->latest()->paginate(12)->appends($request->query());
    
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
}
