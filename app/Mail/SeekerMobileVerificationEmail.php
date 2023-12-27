<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SeekerMobileVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $seeker;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($seeker)
    {
        $this->seeker = $seeker;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Activate Your Infinity Careers Account')
                    ->view('seeker.verify.verifyMobileEmail');
    }
}
