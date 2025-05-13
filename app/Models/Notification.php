<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Competition;

class Notification extends Model
{
    protected $fillable = [
      'user_id', 'invitation_id', 'message', 'is_read', 'type', 'competition_id', 'link'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function competition()
  {
      return $this->belongsTo(Competition::class, 'invitation_id'); // digunakan juga oleh reminder
  }
}