<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;

class ThankYou extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name;
    public $sender;
    public $emailMessage;

    public function __construct(User $sender, $name, $emailMessage)
    {
        $this->sender = $sender;
        $this->name = $name;
        $this->emailMessage = $emailMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('pages.email.thank-you')
        ->subject("Message from ".$this->sender->name." on 1Platform")
        ->with([
            'sender' => $this->sender,
            'name' => $this->name,
            'emailMessage' => $this->emailMessage,
        ]);
    }
}
