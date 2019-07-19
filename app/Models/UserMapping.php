<?php

namespace indiashopps\Models;

use Illuminate\Database\Eloquent\Model;

class UserMapping extends Model
{
    const EXTENDED_PERMISSIONS = [
        'cashback.users',
        'cashback.purchase.orders',
    ];

    public $fillable = ['permissions'];

    const PERMISSIONS = [
        'cashback.earnings'        => 'Cashback Earnings',
        'cashback.claim.detail'    => 'Claim Detail',
        'cashback.purchase.orders' => 'Create Purchase Order',
        'purchase.approve'         => 'Approve Purchase Order',
        /*'cashback.withdraw'      => 'Withdraw',*/
        'cashback.users'           => 'Modify Users',
        'cashback.users.create'    => 'Create Users',
        'cashback.missing'         => 'Missing Cashback',
        'cashback.missing.claim'   => 'Missing Cashback Claim',
        'cashback.settings'        => 'Profile Setting',
    ];

    public $timestamps = false;

    public function getPermissions()
    {
        return (array)json_decode($this->permissions);
    }
}
