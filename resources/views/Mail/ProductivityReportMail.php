<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductivityReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $message;
    public $pdf;

    public function __construct($data, $message, $pdf)
    {
        $this->data = $data;
        $this->message = $message;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Productivity Report - ' . date('Y-m-d'))
                    ->view('emails.report')
                    ->attachData($this->pdf->output(), "report.pdf", [
                        'mime' => 'application/pdf',
                    ]);
    }
}

