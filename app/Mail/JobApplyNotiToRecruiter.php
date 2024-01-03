<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobApplyNotiToRecruiter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $jobApply;

    public function __construct($jobApply)
    {
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
        return $this->subject('New Job Application for '.$job_apply->JobPost->job_title)
                    ->view('employer.mail.recruiter_noti_for_job_apply');
    }
}
