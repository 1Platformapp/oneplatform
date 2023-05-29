<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User as RealUser;

class User extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $mode;

    public function __construct($mode, RealUser $user)
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
        if($this->mode == 'inactive'){

            return $this->view('pages.email.user-inactive')
            ->subject($this->user->name.", grow your fanbase on 1Platform")
            ->with([
                'user' => $this->user,
            ]);
        }
        if($this->mode == 'crowdfunderInactive'){

            return $this->view('pages.email.user-crowdfunder-inactive')
            ->subject("Complete your project fundraiser on 1Platform")
            ->with([
                'user' => $this->user,
            ]);
        }
        if($this->mode == 'noCrowdfunderMonth'){

            return $this->view('pages.email.user-no-crowdfunder-month')
            ->subject("Create a free crowdfunder on 1Platform")
            ->with([
                'user' => $this->user,
            ]);
        }
        if($this->mode == 'emailVerified'){

            return $this->view('pages.email.user-email-verified')
            ->subject($this->user->name.", What can you do on 1Platform?")
            ->with([
                'user' => $this->user,
            ]);
        }
        if($this->mode == 'noCrowdfunderWeek'){

            return $this->view('pages.email.user-no-crowdfunder-week')
            ->subject("Get your next album made with a free crowdfunder")
            ->with([
                'user' => $this->user,
            ]);
        }
        if($this->mode == 'emailVerification'){

            return $this->view('pages.email.user-email-verification')
            ->subject("Verify your email on 1Platform")
            ->with([
                'user' => $this->user,
            ]);
        }
        if($this->mode == 'initiateVetting'){

            return $this->view('pages.email.user-initiate-vetting')
            ->subject("Thankyou for taking interest in 1Platform")
            ->with([
                'user' => $this->user,
            ]);
        }
        if($this->mode == 'registrationRequest'){

            return $this->view('pages.email.user-registration-request')
            ->subject("1Platform new registration request")
            ->with([
                'user' => $this->user,
            ]);
        }
        if($this->mode == 'licenseVerification'){

            return $this->view('pages.email.license-verification')
            ->subject($this->user->name." requires your verification to sell music licenses")
            ->with([
                'user' => $this->user,
            ]);
        }
    }
}
