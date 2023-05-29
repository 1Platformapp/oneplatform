<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;

class AgentContactRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $agent;
    public $user;

    public function __construct(User $agent = null, User $user = null)
    {
        $this->agent = $agent;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('pages.email.agent-contact-request')
            ->subject($this->user->name.' has requested to join your network agency')
            ->with([
                'user' => $this->user,
                'agent' => $this->agent,
            ]);
        
    }
}
