<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class MailModel extends Mailable
{
    public $mailData;

    // A
    public function __construct($mailData) {
        $this->mailData = $mailData;
    }

    // B
    public function envelope() {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            subject: 'PASSWORD RECOVERY',
        );
    }
    
    // C
    public function content() {
        return new Content(
            view: 'email.mail',
        );
    }

}
