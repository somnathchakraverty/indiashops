<?php

namespace indiashopps\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use indiashopps\Events\WithdrawalStatusChanged;
use indiashopps\Models\Cashback\UserWithdrawal;

class UpdatePendingWithdrawal
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  WithdrawalStatusChanged $event
     * @return void
     */
    public function handle(WithdrawalStatusChanged $event)
    {
        UserWithdrawal::resetPendingAmount($event->user_id);
    }
}
