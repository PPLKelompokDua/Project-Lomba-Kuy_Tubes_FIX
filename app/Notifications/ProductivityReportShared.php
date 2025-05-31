<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Team;

class ProductivityReportShared extends Notification implements ShouldQueue
{
    use Queueable;

    protected $team;
    protected $pdfPath;
    protected $feedback;

    /**
     * Create a new notification instance.
     */
    public function __construct(Team $team, string $pdfPath, string $feedback)
    {
        $this->team = $team;
        $this->pdfPath = $pdfPath;
        $this->feedback = $feedback;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Team Productivity Report Shared')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('The team leader has shared a productivity report for ' . $this->team->name)
            ->line('Feedback from team leader:')
            ->line($this->feedback)
            ->attach($this->pdfPath, [
                'as' => 'team-productivity-report.pdf',
                'mime' => 'application/pdf',
            ])
            ->action('View Team Dashboard', url('/teams/' . $this->team->id))
            ->line('Thank you for using LombaKuy!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'team_id' => $this->team->id,
            'team_name' => $this->team->name,
            'feedback' => $this->feedback,
            'type' => 'productivity_report'
        ];
    }
} 