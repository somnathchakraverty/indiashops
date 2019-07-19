<?php

namespace indiashopps\Models\Cashback;

use Illuminate\Database\Eloquent\Model;

class VendorPayout extends Model
{
    protected $table      = 'tb_vendor_payouts';
    protected $primaryKey = 'cbmid';
    public    $timestamps = false;
}
