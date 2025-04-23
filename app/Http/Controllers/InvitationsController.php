<?php

namespace App\Http\Controllers;

use App\Models\Invitations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationsController extends Controller
{
    // Show invitation form & sent invitations

    public function index()
{
    $currentUserId = Auth::id();


    $users = \App\Models\User::where('id', '!=', $currentUserId)
        ->where('team_id', Auth::user()->team_id?? null)
        ->get();

    $invitations = Invitations::where('sender_id', $currentUserId)
        ->with('receiver')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('invitations.index', compact('users', 'invitations'));
}

// Send new invitation
public function send(Request $request)
{
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
    ]);

    Invitations::create([
        'team_id' => Auth::user()->team_id ?? null,
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id,
        'status' => 'pending',
    ]);

    return redirect()->route('invitations.index')->with('success', 'Invitation sent!');
}

public function show($id)
{
    $invitation = Invitations::with(['receiver', 'messages.sender'])->findOrFail($id);
    return view('invitations.show', compact('invitation'));
}

}
