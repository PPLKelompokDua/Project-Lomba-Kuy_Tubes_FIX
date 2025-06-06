<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCompetitions = Competition::count();
        $totalOrganizers = User::where('role', 'organizer')->count();

        // Ambil semua lomba dan relasi user (organizer)
        $competitions = Competition::with('organizer')->latest()->paginate(10);

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCompetitions',
            'totalOrganizers',
            'competitions'
        ));
    }
}
