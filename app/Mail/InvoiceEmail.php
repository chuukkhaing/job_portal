<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceEmail extends Mailable
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
        return $this->subject('Point Order Invoice From Infinity Careers')
                    ->view('mail.email')
                    ->attach(getS3File('invoice',$invoice_attach->file_name), [
                        'as' => $invoice_attach->file_name,
                        'mime' => 'application/pdf',
                    ]);
    }
}
