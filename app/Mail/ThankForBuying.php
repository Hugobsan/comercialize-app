<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ThankForBuying extends Mailable
{
    use Queueable, SerializesModels;

    public $sale;

    /**
     * Create a new message instance.
     */
    public function __construct($sale)
    {
        $this->sale = $sale;
    }

    public function build()
    {
        //view('emails.thank_for_buying', ['sale' => $this->sale]);

        return $this->subject('Obrigado por comprar conosco')
            ->markdown('emails.thank_for_buying')
            ->with([
                'sale' => $this->sale,
            ]);
    }
}
