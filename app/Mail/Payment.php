<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\StripeCheckout;

class Payment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $stripeCheckout;
    public $type;

    public function __construct(StripeCheckout $checkout, $type)
    {
        $this->stripeCheckout = $checkout;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->type == 'failed'){
            return $this->view('pages.email.payment-failed-retry')
            ->subject("Your payment to ".$this->stripeCheckout->user->name.' has failed')
            ->with([
                'stripeCheckout' => $this->stripeCheckout,
            ]);
        }
    }
}
