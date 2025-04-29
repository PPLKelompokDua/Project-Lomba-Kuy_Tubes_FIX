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

         // Count competitions the user is registered in
         $registeredCompetitions = $user->teams()
         ->where('status', 'accepted')
         ->with('competition')
         ->get()
         ->pluck('competition')
         ->unique('id');
     
     // Get all competitions
     $allCompetitions = Competition::count();
     
     // Count events
     $events = Event::count();
     
     // Count forum posts
     $forumPosts = ForumPost::count();
     
     // Get registered competitions details
     $userCompetitionsList = $user->teams()
         ->where('status', 'accepted')
         ->with('competition')
         ->get()
         ->map(function($team) {
             return $team->competition;
         })
         ->unique('id');
     
     // Get pending invitations (received)
     $pendingInvitations = $user->receivedInvitations()
         ->where('status', 'pending')
         ->with(['team', 'sender'])
         ->get();
     
     return view('dashboard', [
         'user' => $user,
         'registeredCompetitionsCount' => $registeredCompetitions->count(),
         'allCompetitionsCount' => $allCompetitions,
         'eventsCount' => $events,
         'forumPostsCount' => $forumPosts,
         'userCompetitionsList' => $userCompetitionsList,
         'pendingInvitations' => $pendingInvitations
     ]);
    }

    /**
     * Display team management page for the current user.
     */
    public function manageTeams()
    {
        $user = Auth::user();
        
        // Get teams led by the user
        $ledTeams = $user->ledTeams()->with(['competition', 'members'])->get();
        
        // Get teams the user is a member of (but not leading)
        $memberTeams = $user->teams()
            ->wherePivot('status', 'accepted')
            ->whereNotIn('teams.leader_id', [$user->id])
            ->with(['competition', 'leader'])
            ->get();
        
        return view('dashboard.teams', [
            'user' => $user,
            'ledTeams' => $ledTeams,
            'memberTeams' => $memberTeams
        ]);
    }
    
    /**
     * Display invitation management page for the current user.
     */
    public function manageInvitations()
    {
        $user = Auth::user();
        
        // Get received invitations for the user with team and sender details
        $receivedInvitations = $user->receivedInvitations()
            ->with(['team', 'sender'])
            ->latest()
            ->get();
        
        // Get sent invitations by the user with team and receiver details
        $sentInvitations = $user->sentInvitations()
            ->with(['team', 'receiver'])
            ->latest()
            ->get();
        
        // Get the teams led by the user (for sending new invitations)
        $ledTeams = $user->ledTeams()->with('competition')->get();
        
        return view('dashboard.invitations', [
            'user' => $user,
            'receivedInvitations' => $receivedInvitations,
            'sentInvitations' => $sentInvitations,
            'ledTeams' => $ledTeams
        ]);
    }
}

    

