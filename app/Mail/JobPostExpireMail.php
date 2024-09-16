<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobPostExpireMail extends Mailable
{
    use Queueable, SerializesModels;
    public $jobpost;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobpost)
    {
        $this->jobpost = $jobpost;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $job_post = $this->jobpost;
        return $this->subject('Your Job ('.$job_post->job_title.') will expire in next 7 Days')
                    ->view('employer.mail.job_post_expire', compact('job_post'));
    }
}
