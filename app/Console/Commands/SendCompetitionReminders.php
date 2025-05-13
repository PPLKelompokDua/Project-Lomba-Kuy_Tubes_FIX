<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Competition;
use App\Models\Notification;
use Illuminate\Support\Carbon;

class SendCompetitionReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send deadline reminders for saved competitions (H-7, H-3, H-1)';

    public function handle()
    {

        \Log::info("📅 Reminder job started at " . now());
        $daysBeforeList = [7, 3, 1];

        foreach ($daysBeforeList as $daysBefore) {
            $targetDate = Carbon::now()->addDays($daysBefore)->toDateString();

            $competitions = Competition::whereDate('deadline', $targetDate)->get();

            foreach ($competitions as $competition) {
                $savedUsers = $competition->savedByUsers;

                foreach ($savedUsers as $user) {
                    $alreadySent = Notification::where('user_id', $user->id)
                        ->where('competition_id', $competition->id)
                        ->where('type', 'reminder')
                        ->where('message', 'like', "%H-{$daysBefore}%")
                        ->where('is_read', false)
                        ->exists();

                    if ($alreadySent) {
                        continue; // Notifikasi H-1/H-3/H-7 sudah ada dan belum dibaca
                    }

                    Notification::create([
                        'user_id' => $user->id,
                        'competition_id' => $competition->id, // ✅ pakai yang benar sekarang
                        'type' => 'reminder',
                        'message' => "📢 Reminder: '{$competition->title}' deadline in H-{$daysBefore} (" . Carbon::parse($competition->deadline)->format('d M Y') . ")",
                        'is_read' => false,
                        'link' => route('competitions.show', $competition->id),
                    ]);
                }
            }
        }

        $this->info('Deadline reminders sent successfully.');
    }
}
