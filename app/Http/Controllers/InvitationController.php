<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Team;
use App\Models\User;
use App\Models\TeamMember;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    /**
     * Display a listing of the invitations.
     */
    public function index(Request $request)
    {
        $authUser = Auth::user();

        // Harus ada team_id
        $teamId = $request->input('team_id');
        if (!$teamId) {
            return redirect()->back()->with('error', 'Team ID is required.');
        }

        // Harus valid team
        $team = Team::findOrFail($teamId);

        if ($team->leader_id !== $authUser->id) {
            return redirect()->route('teams.index')->with('error', 'You are not the leader of this team.');
        }

        $users = User::where('id', '!=', $authUser->id)->get();

        $receivedInvitations = $authUser->receivedInvitations()
            ->with(['team', 'sender'])
            ->orderBy('created_at', 'desc')
            ->get();

        $sentInvitations = $authUser->sentInvitations()
            ->with(['team', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('invitations.index', [
            'users' => $users,
            'receivedInvitations' => $receivedInvitations,
            'sentInvitations' => $sentInvitations,
            'team' => $team,
            'selectedUserId' => $request->input('user_id')
        ]);
    }


    /**
     * Show the form for creating a new invitation.
     */
    public function create(Request $request)
    {
        $teamId = $request->input('team_id');
        $selectedUserId = $request->input('user_id'); // Tambahan ini

        $team = null;
        if ($teamId) {
            $team = Team::findOrFail($teamId);

            if ($team->leader_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Only team leaders can send invitations.');
            }
        } else {
            $teams = Auth::user()->ledTeams;
            if ($teams->isEmpty()) {
                return redirect()->route('teams.create')->with('info', 'You need to create a team first before sending invitations.');
            }
        }

        $users = User::whereNotIn('id', function($query) use ($teamId) {
                $query->select('user_id')
                    ->from('team_members')
                    ->where('team_id', $teamId)
                    ->where('status', 'accepted');
            })
            ->where('id', '!=', Auth::id())
            ->get();

        return view('invitations.create', [
            'team' => $team,
            'teams' => $teams ?? [],
            'users' => $users,
            'selectedUserId' => $selectedUserId // <-- Ini penting
        ]);
    }
    /**
     * Store a newly created invitation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        
        $exists = Invitation::where('sender_id', Auth::id())
            ->where('receiver_id', $request->user_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already invited this user.');
        }


        Invitation::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->user_id,
            'team_id' => $request->team_id,
            'status' => 'pending',
        ]);
    
        return redirect()->route('invitations.index')->with('success', 'Invitation sent!');
    }

    /**
     * Display the specified invitation.
     */
    public function show(Invitation $invitation)
    {
        // Check if the authenticated user is the receiver or sender of the invitation
        if ($invitation->receiver_id !== Auth::id() && $invitation->sender_id !== Auth::id()) {
            return redirect()->route('invitations.index')->with('error', 'You are not authorized to view this invitation.');
        }
        
        // Load relationships
        $invitation->load(['sender', 'receiver', 'messages']);
        
        return view('invitations.show', [
            'invitation' => $invitation
        ]);
    }

    /**
     * Accept an invitation.
     */
    public function accept($id)
{
    $invitation = Invitation::where('id', $id)
        ->where('receiver_id', Auth::id())
        ->firstOrFail();

    $invitation->status = 'accepted';
    $invitation->save();

    TeamMember::updateOrCreate([
        'team_id' => $invitation->team_id,
        'user_id' => $invitation->receiver_id
    ], [
        'status' => 'accepted'
    ]);

    return redirect()->route('invitations.index')->with('success', 'Invitation accepted.');
}

public function decline($id)
{
    $invitation = Invitation::where('id', $id)
        ->where('receiver_id', Auth::id())
        ->firstOrFail();

    $invitation->status = 'declined';
    $invitation->save();

    return redirect()->route('invitations.index')->with('info', 'Invitation declined.');
}
    /**
     * Cancel an invitation (for team leaders).
     */
    public function cancel(Invitation $invitation)
    {
        // Check if the authenticated user is the sender of the invitation
        if ($invitation->sender_id !== Auth::id()) {
            return redirect()->route('invitations.index')->with('error', 'You are not authorized to cancel this invitation.');
        }
        
        // Check if the invitation is pending
        if ($invitation->status !== 'pending') {
            return redirect()->route('invitations.index')->with('error', 'This invitation has already been processed.');
        }
        
        // Delete the invitation
        $invitation->delete();
        
        return redirect()->route('invitations.index')->with('success', 'Invitation cancelled successfully.');
    }
    
    /**
     * Track the status of invitations for a team.
     */
    public function trackTeamInvitations(Team $team)
    {
        // Check if the authenticated user is the team leader
        if ($team->leader_id !== Auth::id()) {
            return redirect()->route('teams.index')->with('error', 'You are not authorized to view invitations for this team.');
        }
        
        // Get all invitations for the team with sender and receiver info
        $invitations = $team->invitations()
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('invitations.team', [
            'team' => $team,
            'invitations' => $invitations
        ]);
    }
}