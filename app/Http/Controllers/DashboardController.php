<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'organizer') {
            return redirect()->route('organizer.dashboard');
        }

        // For regular users
        return view('dashboard', [
            'user' => $user,
            'team' => $user->team,
            'invitations' => $user->team->invitations
                ->with('sender')
                ->where('status', 'pending')
                ->get()
        ]);
    }
}
