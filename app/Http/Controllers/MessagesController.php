<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Invitation;
use App\Models\Invitations;
use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request, $invitationId)
    {
        $request->validate(['content' => 'required']);
        $invitation = Invitations::findOrFail($invitationId);

        Messages::create([
            'invitation_id' => $invitation->id,
            'sender_id' => Auth::id(),
            'content' => $request->content
        ]);

        return back()->with('success', 'Message sent!');
    }
}

