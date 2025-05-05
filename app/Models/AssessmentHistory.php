<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentHistory extends Model
{
    use HasFactory;

    // Jika nama tabel tidak mengikuti konvensi Laravel (misalnya 'assessment_histories'),
    // Anda bisa menambahkannya di sini (jika diperlukan)
    // protected $table = 'assessment_histories';

    // Kolom yang boleh diisi oleh Eloquent
    protected $fillable = [
        'user_id',
        'assessment_data',
        'personality_type',
        'preferred_role',
    ];

    // Mendefinisikan hubungan dengan User
    public function user()
    {
        return $this->belongsTo(User::class); // Setiap AssessmentHistory milik satu User
    }

    protected $casts = [
        'assessment_data' => 'array',
    ];
    
    // public function getPersonalityTypeAttribute()
    // {
    //     return $this->assessment_data['personality_type'] ?? '-';
    // }
    
    // public function getPreferredRoleAttribute()
    // {
    //     return $this->assessment_data['preferred_role'] ?? '-';
    // }

    // Jika Anda ingin menonaktifkan pengelolaan timestamps (misalnya, jika tidak ada kolom created_at dan updated_at)
    // public $timestamps = false;
}