<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;
use App\Models\StripeSubscription;

class CancelSubscription extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $stripeSubscription;
    public $action;

    public function __construct(StripeSubscription $stripeSubscription, $action = '')
    {
        $this->stripeSubscription = $stripeSubscription;
        $this->action = $action;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->action == 'subscriber'){

            return $this->view('pages.email.cancel-subscription')
            ->subject('You have successfully unsubscribed '.$this->stripeSubscription->user->name)
            ->with([
                'subscription' => $this->stripeSubscription,
                'action' => $this->action,
            ]);
        }else if($this->action == 'artist'){

            return $this->view('pages.email.cancel-subscription')
            ->subject($this->stripeSubscription->customer->name.' has unsubscribed from your website')
            ->with([
                'subscription' => $this->stripeSubscription,
                'action' => $this->action,
            ]);
        }
    }
}
