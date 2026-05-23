<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    // Create a public variable to hold the React form data
    public array $contactData;

    /**
     * Create a new message instance.
     */
    public function __construct(array $contactData)
    {
        // When the API route creates this mail, it saves the data here
        $this->contactData = $contactData;
    }

    /**
     * Get the message envelope (The Subject Line).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Portfolio Inquiry: ' . $this->contactData['name'],
        );
    }

    /**
     * Get the message content definition (The HTML Body).
     */
    public function content(): Content
    {
        return new Content(
            // Change 'view.name' to point to our new folder and file!
            view: 'emails.contact',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}