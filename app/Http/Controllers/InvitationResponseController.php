<?php

namespace App\Http\Controllers;

use App\Models\Invitations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationResponseController extends Controller

{
    public function respond($id, $response)
    {
        $invitation = Invitations::where('receiver_id', Auth::id())->findOrFail($id);

        if (!in_array($response, ['accepted', 'declined'])) {
            abort(400);
        }

        $invitation->update(['status' => $response]);

        return redirect()->route('invitations.index')->with('success', "Invitation $response.");
    }
}