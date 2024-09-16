<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobAlertNotification extends Notification
{
    use Queueable;
    private $data;
    private $job_alert;
    private $jobPost;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $job_alert, $jobPost)
    {
        $this->data = $data;
        $this->job_alert = $job_alert;
        $this->jobPost = $jobPost;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Perfect Opportunities Awaits!')
            ->markdown('mail.job_alert', [
                'job_alert' => $this->job_alert,
                'jobPost' => $this->jobPost,
                'seeker' => $notifiable
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase()
    {
        $data =  [
            'message'=> $this->data,
        ];
        return $data;

    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
