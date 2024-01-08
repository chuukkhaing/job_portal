<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobApplyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $recommended_jobs;
    public $jobApply;

    public function __construct($recommended_jobs, $jobApply)
    {
        $this->recommended_jobs = $recommended_jobs;
        $this->jobApply = $jobApply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $job_apply = $this->jobApply;
        return $this->subject('Application for '.$job_apply->JobPost->job_title.' have been Submitted ')
                    ->view('seeker.mail.job_apply_mail');
    }
}
