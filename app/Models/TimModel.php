<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimModel extends Model
{
    protected $table = 'tim';

    protected $fillable = [
        'name',
    ];


    public function feedback(){
        return $this->hasMany(FeedbackTim::class, 'tim_id');
    }
}
