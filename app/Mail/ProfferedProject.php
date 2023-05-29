<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;
use App\Models\UserChat;

class ProfferedProject extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $customer;
    public $chat;
    public $type;

    public function __construct($type, User $user, User $customer, UserChat $chat = null)
    {
        $this->user = $user;
        $this->customer = $customer;
        $this->chat = $chat;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->type == 'create'){

            return $this->view('pages.email.proffer-project-email')
            ->subject($this->user->name." has added a project for you on 1 Platform")
            ->with([
                'user' => $this->user,
                'customer' => $this->customer,
                'chat' => $this->chat,
            ]);
        }
    }
}
