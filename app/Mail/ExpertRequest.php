<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;

class ExpertRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $mode;

    public function __construct($mode, User $user)
    {
        $this->user = $user;
        $this->mode = $mode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->mode == 'sent'){

            return $this->view('pages.email.expert-request-sent')
            ->subject($this->user->name." Requested To Be An Agent On 1platform")
            ->with([
                'user' => $this->user,
            ]);
        }
        if($this->mode == 'approved'){

            return $this->view('pages.email.expert-request-approved')
            ->subject("1platform Has Approved Your Request To Be An Agent")
            ->with([
                'user' => $this->user,
            ]);
        }
        if($this->mode == 'rejected'){

            return $this->view('pages.email.expert-request-rejected')
            ->subject("You Are On Our Waiting List Of Agents")
            ->with([
                'user' => $this->user,
            ]);
        }
    }
}
