<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'due_date',
        'blocker_reason'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'due_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'completed_at' => 'datetime',
        'blocked_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Get the user that the task is assigned to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set task status to completed
     */
    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->completed_at = Carbon::now();
        $this->last_activity_at = Carbon::now();
        $this->save();
        
        return $this;
    }

    /**
     * Set task status to in_progress
     */
    public function markAsInProgress()
    {
        $this->status = 'in_progress';
        $this->last_activity_at = Carbon::now();
        $this->save();
        
        return $this;
    }

    /**
     * Set task status to blocked
     */
    public function markAsBlocked($reason = null)
    {
        $this->status = 'blocked';
        $this->blocked_at = Carbon::now();
        $this->last_activity_at = Carbon::now();
        
        if ($reason) {
            $this->blocker_reason = $reason;
        }
        
        $this->save();
        
        return $this;
    }

    /**
     * Set task status to pending
     */
    public function markAsPending()
    {
        $this->status = 'pending';
        $this->last_activity_at = Carbon::now();
        $this->save();
        
        return $this;
    }

    /**
     * Assign task to a user
     */
    public function assignTo($userId)
    {
        $this->user_id = $userId;
        $this->last_activity_at = Carbon::now();
        $this->save();
        
        return $this;
    }

    /**
     * Set task due date
     */
    public function setDueDate($date)
    {
        $this->due_date = $date;
        $this->last_activity_at = Carbon::now();
        $this->save();
        
        return $this;
    }
    
    /**
     * Check if task is overdue
     */
    public function isOverdue()
    {
        return $this->due_date && Carbon::now()->gt($this->due_date) && $this->status != 'completed';
    }
    
    /**
     * Get days until/since due date
     * Positive number means days until due date
     * Negative number means days overdue
     */
    public function daysUntilDue()
    {
        if (!$this->due_date) {
            return null;
        }
        
        return Carbon::now()->diffInDays($this->due_date, false);
    }
    
    /**
     * Get the days this task has been in its current status
     */
    public function daysInCurrentStatus()
    {
        $referenceDate = null;
        
        switch ($this->status) {
            case 'completed':
                $referenceDate = $this->completed_at;
                break;
            case 'blocked':
                $referenceDate = $this->blocked_at;
                break;
            default:
                $referenceDate = $this->last_activity_at ?? $this->updated_at;
                break;
        }
        
        return $referenceDate ? Carbon::now()->diffInDays($referenceDate) : 0;
    }
}