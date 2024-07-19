<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RespondenSurveyAnnounceFirst extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data["survey_title"],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // dd($this->data);
        return new Content(
            markdown: 'emails.responden.survey-announce-first',
            with: [
                'email' => $this->data["email"],
                'name' => $this->data["name"],
                'unique_code' => $this->data["unique_code"],
                'uuid' => $this->data["uuid"],
                // 'survey_id' => $this->data["survey_id"],
                'end_at' => $this->data["end_at"],
                'mailer_narration' => $this->data["mailer_narration"],
                // 'survey_title' => $this->data["survey_title"],
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
