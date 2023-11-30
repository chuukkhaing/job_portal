<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiptEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $invoice_attach = $this->invoice;
        return $this->subject('Point Order Receipt From Infinity Careers')
                    ->view('mail.email_receipt')
                    ->attach(getS3File('receipt',$invoice_attach->receipt), [
                        'as' => $invoice_attach->receipt,
                        'mime' => 'application/pdf',
                    ]);
    }
}
