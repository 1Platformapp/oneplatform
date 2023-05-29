<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;
use App\Models\UserCampaign as UserCampaign;

class ProjectUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $campaign;
    public $mode;

    public function __construct($mode, User $user, UserCampaign $campaign)
    {
        $this->user = $user;
        $this->campaign = $campaign;
        $this->mode = $mode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->mode == 'isLive'){

            return $this->view('pages.email.user-crowdfunder-launched')
            ->subject("Your project is now live on 1Platform")
            ->with([
                'user' => $this->user,
                'campaign' => $this->campaign,
            ]);
        }
        if($this->mode == 'reachedGoal'){

            return $this->view('pages.email.project-reached-goal')
            ->subject("This Project was successful on 1Platform")
            ->with([
                'user' => $this->user,
                'campaign' => $this->campaign,
            ]);
        }
        if($this->mode == 'nearlyEnding'){

            return $this->view('pages.email.project-nearly-ending')
            ->subject("The project you supported on 1Platform is nearly ending")
            ->with([
                'user' => $this->user,
                'campaign' => $this->campaign,
            ]);
        }
        if($this->mode == 'nearlyOver'){

            return $this->view('pages.email.project-nearly-over')
            ->subject("Your Project on 1Platform has almost ended, extend it now!")
            ->with([
                'user' => $this->user,
                'campaign' => $this->campaign,
            ]);
        }
        if($this->mode == 'overUnsuccessful'){

            return $this->view('pages.email.project-over-and-unsuccessful')
            ->subject("Your Project on 1Platform has ended")
            ->with([
                'user' => $this->user,
                'campaign' => $this->campaign,
            ]);
        }
        if($this->mode == 'overSuccessful'){

            return $this->view('pages.email.project-over-and-successful')
            ->subject($this->user->name." Well Done! your project was successful on 1Platform")
            ->with([
                'user' => $this->user,
                'campaign' => $this->campaign,
            ]);
        }
    }
}
