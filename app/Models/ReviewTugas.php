<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewTugas extends Model
{
    use HasFactory;

    // 👇 BARIS INI WAJIB kalau nama model ≠ nama tabel
    protected $table = 'tugas';

    protected $fillable = [
        'title',
        'status_id',
        'description',
        'start_date',
        'end_date'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
