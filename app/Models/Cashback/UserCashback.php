<?php

namespace indiashopps\Models\Cashback;

use Illuminate\Database\Eloquent\Model;
use indiashopps\AndUser;

class UserCashback extends Model
{
    protected $table      = 'tb_user_cashback';
    protected $primaryKey = 'user_cbid';
    const STATUS_PENDING            = 'pending';
    const STATUS_APPROVED           = 'approved';
    const MINIMUM_WITHDRAWAL_AMOUNT = 250;

    public function user()
    {
        return $this->belongsTo(AndUser::class, 'id', 'user_id');
    }

    public function network()
    {
        return $this->belongsTo(Network::class, 'network_id', 'network_id');
    }

    public function click()
    {
        return $this->belongsTo(AffiliateClick::class, 'click_id', 'click_id');
    }

    public function transaction()
    {
        return $this->belongsTo(NetworkTransaction::class, 'transaction_id', 'transaction_id');
    }
}
