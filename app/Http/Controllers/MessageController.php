<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the user's messages.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get unique conversation users (people who the user has exchanged messages with)
        $conversationUsers = User::whereIn('id', function($query) use ($user) {
                $query->select('sender_id')
                    ->from('messages')
                    ->where('receiver_id', $user->id)
                    ->union(
                        $query->newQuery()
                            ->select('receiver_id')
                            ->from('messages')
                            ->where('sender_id', $user->id)
                    );
            })
            ->get();
        
        // For displaying the most recent message with each user
        $recentMessages = [];
        foreach ($conversationUsers as $conversationUser) {
            $recentMessages[$conversationUser->id] = Message::where(function($query) use ($user, $conversationUser) {
                    $query->where('sender_id', $user->id)
                        ->where('receiver_id', $conversationUser->id);
                })
                ->orWhere(function($query) use ($user, $conversationUser) {
                    $query->where('sender_id', $conversationUser->id)
                        ->where('receiver_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->first();
        }
        
        return view('messages.index', [
            'conversationUsers' => $conversationUsers,
            'recentMessages' => $recentMessages
        ]);
    }

    /**
     * Show conversation between users.
     */
    public function conversation(User $user)
    {
        $currentUser = Auth::user();
        
        // Get messages between the two users
        $messages = Message::where(function($query) use ($currentUser, $user) {
                $query->where('sender_id', $currentUser->id)
                    ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($currentUser, $user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $currentUser->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Mark all messages from the other user as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $currentUser->id)
            ->where('read', false)
            ->update(['read' => true]);
        
        // Check if there's an invitation between these users
        $invitation = Invitation::where(function($query) use ($currentUser, $user) {
                $query->where('sender_id', $currentUser->id)
                    ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($currentUser, $user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $currentUser->id);
            })
            ->latest()
            ->first();
        
        return view('messages.conversation', [
            'otherUser' => $user,
            'messages' => $messages,
            'invitation' => $invitation
        ]);
    }

    /**
     * Send a message to another user.
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
            'invitation_id' => 'nullable|exists:invitations,id',
        ]);
        
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'invitation_id' => $validated['invitation_id'] ?? null,
            'content' => $validated['content'],
            'read' => false,
        ]);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        
        return redirect()->back()->with('success', 'Message sent successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'invitation_id' => 'required|exists:invitations,id',
            'content' => 'required|string|max:1000',
        ]);

        $invitation = \App\Models\Invitation::findOrFail($request->invitation_id);

    // Tentukan receiver (lawan bicara)
        $receiverId = Auth::id() === $invitation->sender_id
            ? $invitation->receiver_id
            : $invitation->sender_id;

        \App\Models\Message::create([
            'invitation_id' => $invitation->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Message sent!');
    }


    
    /**
     * View messages for a specific invitation.
     */
    public function invitationMessages(Invitation $invitation)
    {
        // Check if the authenticated user is related to this invitation
        if ($invitation->sender_id !== Auth::id() && $invitation->receiver_id !== Auth::id()) {
            return redirect()->route('invitations.index')->with('error', 'You are not authorized to view these messages.');
        }
        
        // Get the other user (not the authenticated user)
        $otherUser = ($invitation->sender_id === Auth::id()) 
            ? $invitation->receiver 
            : $invitation->sender;
        
        // Get messages for this invitation
        $messages = $invitation->messages()->orderBy('created_at', 'asc')->get();
        
        // Mark all messages from the other user as read
        Message::where('invitation_id', $invitation->id)
            ->where('sender_id', $otherUser->id)
            ->where('receiver_id', Auth::id())
            ->where('read', false)
            ->update(['read' => true]);
        
        return view('messages.invitation', [
            'invitation' => $invitation,
            'otherUser' => $otherUser,
            'messages' => $messages
        ]);
    }
}