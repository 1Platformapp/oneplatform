<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Voucher as Voucherr;

class Voucher extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $voucher;

    public function __construct(Voucherr $voucher)
    {
        $this->voucher = $voucher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('pages.email.voucher')
        ->subject('1Platform discount voucher - Get '.$this->voucher->percent_off.' % off your subscription with us')
        ->with([
            'voucher' => $this->voucher
        ]);
    }
}
