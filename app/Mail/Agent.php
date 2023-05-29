<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;
use App\Models\UserChat;

class Agent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $chat;

    public function __construct(UserChat $chat = null)
    {
        $this->chat = $chat;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('pages.email.agent-new-message')
        ->subject($this->chat->sender->name." has sent you a message on 1Platform")
        ->with([
            'chat' => $this->chat,
        ]);
    }
}
