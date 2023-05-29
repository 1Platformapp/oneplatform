<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;

class Chart extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $mode;
    public $rank;

    public function __construct($mode, User $user, $rank = null)
    {
        if($rank){
            $rank = (int) $rank;
            $ends = array('th','st','nd','rd','th','th','th','th','th','th');
            if (($rank %100) >= 11 && ($rank%100) <= 13)
               $this->rank = $rank. 'th';
            else
               $this->rank = $rank. $ends[$rank % 10];
        }

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
        if($this->mode == 'winner'){

            return $this->view('pages.email.chart-winner')
            ->subject("Well done ".$this->user->name.", you're 1Platform Chart winner!")
            ->with([
                'user' => $this->user,
            ]);
        }
        if($this->mode == 'finished'){

            return $this->view('pages.email.chart-finished')
            ->subject("This weeks 1Platform Chart results!")
            ->with([
                'user' => $this->user,
                'rank' => $this->rank,
            ]);
        }
        if($this->mode == 'listed'){

            return $this->view('pages.email.chart-listed')
            ->subject("You have entered 1Platform Chart")
            ->with([
                'user' => $this->user,
            ]);
        }
    }
}
