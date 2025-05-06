<?php
namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // (opsional) halaman full notifications
    public function index()
    {
        $unread = Notification::where('user_id', Auth::id())
                      ->where('is_read', false)
                      ->orderBy('created_at','desc')
                      ->get();

        return view('notifications.index', compact('unread'));
    }

    // tandai satu notifikasi sebagai read
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }
        $notification->update(['is_read' => true]);
        return redirect()->route('invitations.show', $notification->invitation_id);
    }
    public function readAndRedirect(Notification $notification)
    {
        if ($notification->notifiable_id !== auth()->id()) {
            abort(403);
        }
    
        $notification->is_read = true;
        $notification->save();
    
        // Redirect ke halaman undangan
        return redirect()->route('invitations.index', ['team_id' => $notification->data['team_id'] ?? null]);
    }
    

}
