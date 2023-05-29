<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\User;
use App\Models\AgentContact as agentContactt;

class AgentContact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $agentContact;
    public $data;
    public $action;
    public $agent;

    public function __construct(User $agent = null, agentContactt $agentContact = null, $data = [], $action = '')
    {
        $this->contact = $agentContact;
        $this->data = $data;
        $this->action = $action;
        $this->agent = $agent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->action == 'create'){

            return $this->view('pages.email.agent-add-contact')
            ->subject('You have been invited to signup at 1platform')
            ->with([
                'data' => $this->data,
                'contact' => $this->contact,
                'agent' => $this->agent,
                'action' => 'create',
            ]);
        }else if($this->action == 'approved-for-agent'){

            return $this->view('pages.email.agent-contact-approved')
            ->subject($this->contact->contactUser->name.' has approved the agreement with your agency')
            ->attach(public_path('agent-agreements/'.$this->contact->agreement_pdf))
            ->with([
                'contact' => $this->contact,
                'agent' => $this->agent,
                'recipient' => 'agent',
            ]);
        }else if($this->action == 'approved-for-contact'){

            return $this->view('pages.email.agent-contact-approved')
            ->subject($this->agent->name.' will now be your agent at 1platform')
            ->attach(public_path('agent-agreements/'.$this->contact->agreement_pdf))
            ->with([
                'contact' => $this->contact,
                'agent' => $this->agent,
                'recipient' => 'contact',
            ]);
        }else if($this->action == 'update'){

            return $this->view('pages.email.agent-update-contact')
            ->subject('Your reviewed agreement with '.$this->agent->name.' needs your approval')
            ->with([
                'contact' => $this->contact,
                'agent' => $this->agent,
                'data' => $this->data,
            ]);
        }else if($this->action == 'questionnaire'){

            return $this->view('pages.email.agent-add-contact')
            ->subject($this->agent->name.' has sent a questionnaire for you')
            ->with([
                'contact' => $this->contact,
                'agent' => $this->agent,
                'action' => 'questionnaire',
            ]);
        }else if($this->action == 'agent-form-updated'){

            return $this->view('pages.email.agent-form-updated')
            ->subject($this->data['sender'].' has updated the network information form')
            ->with([
                'contact' => $this->contact,
                'data' => $this->data,
            ]);
        }
        
    }
}
