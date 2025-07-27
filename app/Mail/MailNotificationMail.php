<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $sub;

    public function __construct($details, $subject)
    {
        $this->details = $details;
        $this->sub = $subject;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->sub,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.mail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
