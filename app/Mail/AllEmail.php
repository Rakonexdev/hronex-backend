<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AllEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subject;
    public $body;

    public function __construct($user, $subject, $body)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.AllEmail')
                    ->subject($subject)
                    ->subject($body);
    }
}
