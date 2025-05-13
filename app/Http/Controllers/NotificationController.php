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
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }
        $notification->update(['is_read' => true]);
        return redirect()->route('invitations.show', $notification->invitation_id);
    }
    public function readAndRedirect(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->is_read = true;
        $notification->save();

        // Redirect sesuai jenis notifikasi
        switch ($notification->type) {
            case 'reminder':
                return redirect()->to($notification->link ?? route('competitions.show', $notification->invitation_id));
            case 'message':
                return redirect()->route('invitations.show', $notification->invitation_id); // ke chat
            case 'invitation':
            default:
                return redirect()->route('invitations.index'); // ke halaman daftar undangan
        }
    }
    

}