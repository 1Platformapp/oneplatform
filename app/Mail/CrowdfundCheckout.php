<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\StripeCheckout;

class CrowdfundCheckout extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $checkout;
    public $mode;

    public function __construct($mode, StripeCheckout $checkout)
    {
        $this->checkout = $checkout;
        $this->mode = $mode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->mode == 'buyer'){

            return $this->view('pages.email.crowdfund-checkout-buyer')
            ->subject("You sent a contribution on 1Platform")
            ->with([
                'checkout' => $this->checkout,
            ]);
        }
        if($this->mode == 'seller'){

            return $this->view('pages.email.crowdfund-checkout-seller')
            ->subject("You have received funds on 1Platform")
            ->with([
                'checkout' => $this->checkout,
            ]);
        }
    }
}
