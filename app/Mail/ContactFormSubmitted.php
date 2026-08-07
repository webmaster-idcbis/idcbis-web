<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array{nombre: string, email: string, asunto: string, mensaje: string}  $data
     */
    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        $subject = 'Contacto web: '.$this->data['asunto'];

        return new Envelope(
            subject: $subject,
            replyTo: [$this->data['email']],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form-submitted',
        );
    }
}
