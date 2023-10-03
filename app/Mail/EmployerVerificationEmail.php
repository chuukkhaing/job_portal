<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployerVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $employer;

    public function __construct($employer)
    {
        $this->employer = $employer;
    }

    public function build()
    {
        return $this->subject('Activate Your Infinity Careers Employer Account')
                    ->view('employer.verify.verifyEmail');
    }
}
