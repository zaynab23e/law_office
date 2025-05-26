<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SessionReminderMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function build()
    {
        return $this->subject('جلسة مجدولة غدًا')
                    ->view('emails.session_reminder')
                    ->with(['session' => $this->session]);
    }
    


}
