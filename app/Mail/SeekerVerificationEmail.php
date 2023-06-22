<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SeekerVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $seeker;

    public function __construct($seeker)
    {
        $this->seeker = $seeker;
    }

    public function build()
    {
        return $this->view('seeker.verifyEmail');
    }
}
