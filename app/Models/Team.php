<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Competition; // Pastikan ini diimpor

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'leader_id',
        'competition_id',
        'status_team',
        // HAPUS BARIS-BARIS DI BAWAH INI JIKA MEREKA BUKAN KOLOM DI TABEL 'teams' KAMU!
        // Mereka umumnya adalah properti dari model Competition, bukan Team.
        // 'competition_name', 
        // 'category', 
        // 'deadline', 
        // 'location', 
        // 'description', 
    ];

    // Relasi ke User (Leader)
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    // Relasi ke Competition
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    // Relasi ke TeamMember (jika ada) - untuk semua anggota
    public function members()
    {
        return $this->belongsToMany(User::class, 'team_members', 'team_id', 'user_id')->withPivot('status');
    }

    // Relasi untuk anggota yang diterima
    public function acceptedMembers()
    {
        return $this->belongsToMany(User::class, 'team_members', 'team_id', 'user_id')
                    ->wherePivot('status', 'accepted')
                    ->withPivot('status');
    }

    // Relasi ke Feedbacks
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}