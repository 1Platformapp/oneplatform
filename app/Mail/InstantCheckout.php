<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\StripeCheckout;
use App\Models\CustomerBasket;

class InstantCheckout extends Mailable
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

            return $this->view('pages.email.basket-buyer-email')
            ->subject("Instant Checkout Buyer")
            ->with([
                'checkout'       => $this->checkout,
                'customer'       => $this->checkout->customer,
                'user'           => $this->checkout->user,
                'customerBasket' => [(object) CustomerBasket::all()->first()],
                'currency'       => 'USD',
                'currencySymbol' => '$',
                'commonMethods'  => new \App\Http\Controllers\CommonMethods(),
            ]);
        }else if($this->mode == 'seller'){

            return $this->view('pages.email.instant-checkout-seller')
            ->subject("You have a sale on 1Platform")
            ->with([
                'checkout' => $this->checkout,
            ]);
        }else if($this->mode == 'admin'){

            return $this->view('pages.email.instant-checkout-admin')
            ->subject("We have a new print-on-demand item sale")
            ->with([
                'checkout' => $this->checkout,
            ]);
        }
    }
}
