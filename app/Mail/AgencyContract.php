<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;
use App\Models\AgencyContract as AgencyContractModel;

class AgencyContract extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $contract;

    public function __construct(AgencyContractModel $contract, User $recipient, $action)
    {
        $this->contract = $contract;
        $this->recipient = $recipient;
        $this->action = $action;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->action == 'contract-created'){

            return $this->view('pages.email.contract-created')
            ->subject("New agency contract")
            ->with([
                'contract' => $this->contract,
                'recipient' => $this->recipient,
                'action' => $this->action
            ]);
        }
    }
}
