<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployerResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user_name;
    public $reseturl;

    public function __construct($user_name, $reseturl)
    {
        $this->user_name = $user_name;
        $this->reseturl  = $reseturl;
    }

    public function build()
    {
        return $this->view('employer.verify.reset-mail');
    }
}
