<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Team;
use App\Models\User;
use App\Models\TeamMember;
use App\Models\Message;
use App\Models\Notification;
use App\Notifications\InvitationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    /**
     * Display a listing of the invitations.
     */
    public function index()
    {
        $authUser = Auth::user();

        $teams = $authUser->ledTeams;

        $receivedInvitations = $authUser->receivedInvitations()
            ->with(['team', 'sender'])
            ->orderBy('created_at', 'desc')
            ->get();

        $sentInvitations = $authUser->sentInvitations()
            ->with(['team', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();

        $defaultUserId = request('user_id');
        $defaultTeamId = request('team_id');
        $defaultCompetitionId = request('competition_id');

        return view('invitations.index', [
            'receivedInvitations' => $receivedInvitations,
            'sentInvitations' => $sentInvitations,
            'teams' => $teams,
            'defaultUserId' => $defaultUserId,
            'defaultTeamId' => $defaultTeamId,
            'defaultCompetitionId' => $defaultCompetitionId,
        ]);
    }

    /**
     * Search users for invitation (AJAX).
     */
    public function searchUsers(Request $request)
    {
        // Handle both GET and POST requests
        if ($request->isMethod('post')) {
            $data = $request->json()->all();
            $query = $data['query'] ?? '';
            $teamId = $data['team_id'] ?? null;
            $userId = $data['user_id'] ?? null;
            $random = $data['random'] ?? false;
        } else {
            $query = $request->input('query');
            $teamId = $request->input('team_id');
            $userId = $request->input('user_id');
            $random = $request->input('random', false);
        }

        $usersQuery = User::where('id', '!=', Auth::id())
            ->where('role', 'user'); // Filter hanya role 'user'

        if ($query) {
            $usersQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%");
            });
        }

        // If team_id is provided, exclude users who are already in the team
        if ($teamId) {
            $usersQuery->whereNotIn('id', function ($subQuery) use ($teamId) {
                $subQuery->select('user_id')
                    ->from('team_members')
                    ->where('team_id', $teamId)
                    ->where('status', 'accepted');
            });
        }

        // If user_id is provided (for preselecting), fetch that specific user
        if ($userId) {
            $usersQuery->where('id', $userId);
        }

        // If random is true, get random users
        if ($random) {
            $usersQuery->inRandomOrder()->limit(3); // Limit to 3 random users
        } else {
            $usersQuery->limit(5); // Limit results for performance
        }

        $users = $usersQuery->get(['id', 'name', 'email', 'profile_image']);

        return response()->json($users);
    }

    /**
     * Show the form for creating a new invitation.
     */
    public function create(Request $request)
    {
        $teamId = $request->input('team_id');
        
        // Get the team if provided
        $team = null;
        if ($teamId) {
            $team = Team::findOrFail($teamId);
            
            // Check if the authenticated user is the team leader
            if ($team->leader_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Only team leaders can send invitations.');
            }
        } else {
            // Get teams where user is a leader
            $teams = Auth::user()->ledTeams;
            if ($teams->isEmpty()) {
                return redirect()->route('teams.create')->with('info', 'You need to create a team first before sending invitations.');
            }
        }
        
        // Get potential users to invite (exclude users who are already in the team)
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
            'users' => $users
        ]);
    }

    /**
     * Store a newly created invitation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'team_id' => 'required|exists:teams,id',
        ]);
        
        $exists = Invitation::where('sender_id', Auth::id())
            ->where('receiver_id', $request->user_id)
            ->where('team_id', $request->team_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already invited this user to this team.');
        }

        $team = Team::find($request->team_id);
        $invitation = Invitation::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->user_id,
            'status' => 'pending',
            'team_id'     => $request->team_id,
            'status'      => 'pending',
        ]);

        $team = Team::findOrFail($request->team_id);

        // Cegah jika status tim "finished"
        if ($team->status_team === 'finished') {
            return back()->with('error', 'Cannot send invitations to a finished team.');
        }

        // Bikin notifikasi manual:
        Notification::create([
            'user_id'       => $request->user_id,
            'invitation_id' => $invitation->id,
            'type' => 'invitation',
            'message'       => Auth::user()->name
                            . ' invited you to join the team '
                            . $team->name,
            'link' => route('invitations.index', [
                'team_id' => $request->team_id,
                'user_id' => $request->receiver_id,
            ]),             
            'is_read'       => false,
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

        // Tambahkan user ke team_members
        $exists = \App\Models\TeamMember::where('team_id', $invitation->team_id)
            ->where('user_id', $invitation->receiver_id)
            ->exists();

        if (! $exists) {
            \App\Models\TeamMember::create([
                'team_id' => $invitation->team_id,
                'user_id' => $invitation->receiver_id,
                'status' => 'accepted',
            ]);
        }

        // Accept invitation
        $invitation->status = 'accepted';
        $invitation->save();

        // Notifikasi ke pengundang
        Notification::create([
            'user_id'       => $invitation->sender_id,
            'invitation_id' => $invitation->id,
            'type'          => 'invitation',
            'message'       => auth()->user()->name . ' has accepted your team invitation: ' . $invitation->team->name,
            'link'          => route('invitations.index'),
            'is_read'       => false,
        ]);

        return redirect()->route('invitations.index')->with('success', 'Invitation accepted and joined the team.');
    }

    public function decline($id)
    {
        $invitation = Invitation::where('id', $id)
            ->where('receiver_id', Auth::id())
            ->firstOrFail();

        $invitation->status = 'declined';
        $invitation->save();

        // Decline invitation
        $invitation->status = 'declined';
        $invitation->save();

        // Notifikasi ke pengundang
        Notification::create([
            'user_id'       => $invitation->sender_id,
            'invitation_id' => $invitation->id,
            'type'          => 'invitation',
            'message'       => auth()->user()->name . ' menolak undangan timmu: ' . $invitation->team->name,
            'link'          => route('invitations.index'),
            'is_read'       => false,
        ]);

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