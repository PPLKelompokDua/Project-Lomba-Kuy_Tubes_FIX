<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom-kolom yang boleh diisi secara mass-assignment
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',             // Tambahan kolom role (user/admin)
        'profile_image',
    ];

    /**
     * Kolom-kolom yang ingin disembunyikan saat serialisasi
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast untuk tipe data tertentu
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ======================
    // === RELASI MODEL ====
    // ======================


    
    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
