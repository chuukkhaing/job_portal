<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SeekerResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $first_name;
    public $last_name;
    public $reseturl;

    public function __construct($first_name, $last_name, $reseturl)
    {
        $this->first_name = $first_name;
        $this->last_name  = $last_name;
        $this->reseturl   = $reseturl;
    }

    public function build()
    {
        return $this->subject('Reset Your Infinity Careers Password')
                    ->view('seeker.verify.reset-mail');
    }
}
