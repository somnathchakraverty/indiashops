<?php

namespace indiashopps\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use indiashopps\User;

class WithdrawRequestSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $withdrawal_amount;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param $withdrawal_amount
     */
    public function __construct(User $user, $withdrawal_amount)
    {
        $this->user              = $user;
        $this->withdrawal_amount = $withdrawal_amount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from(env('MAIL_USERNAME'), 'Admin')
             ->to('mitul.mehra@manyainternational.com')
             ->cc('astha@indiashopps.com')
             ->subject('Withdrawal Request on IndiaShopps');

        return $this->view('emails.cashback.withdrawal')->with([
            'user'   => $this->user,
            'amount' => $this->withdrawal_amount
        ]);
    }
}
