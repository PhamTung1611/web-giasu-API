<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HTMLMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($htmlContent)
    {
        $this->htmlContent = $htmlContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'GS7 thông báo',
        );
    }

    public function build()
    {
        return $this->view('emails.sendmailhtml')->with([
            'htmlContent' => $this->htmlContent,
        ])->subject('Subject of the Email');
    }
}
