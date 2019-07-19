<?php

namespace indiashopps\Models\Cashback;

use Illuminate\Database\Eloquent\Model;

class VendorSetting extends Model
{
    protected $table      = 'tb_vendor_settings';
    protected $primaryKey = 'vendor_id';

    public function getName()
    {
        if (!empty($this->vendor_id)) {
            return config('vendor.name.' . $this->vendor_id);
        }

        return "NA";
    }

    public function getUserCashback( VendorPayout $vendor, Ticket $claim )
    {
        if( strtolower($vendor->payout_type) == 'flat' )
        {
            $amount = $vendor->payout_amount;
        }
        else
        {
            $amount = (($claim->order_amount * $vendor->payout_amount) / 100 );
        }

        if(!empty($amount))
        {
            return (($amount * $this->cashback_user_percent) / 100);
        }

        return 0;
    }

}
