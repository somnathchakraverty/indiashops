<?php

namespace indiashopps\Models\Cashback;

use indiashopps\AndUser;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table      = 'tb_tickets';
    protected $primaryKey = 'ticket_id';
    public    $timestamps = false;

    const DEFAULT_STATUS = 'open';
    const CLOSED         = 'closed';
    const ANSWERED       = 'answered';

    public function comments()
    {
        return $this->hasMany(TicketComment::class, 'ticket_id', 'ticket_id');
    }

    public function user()
    {
        return $this->hasOne(AndUser::class, 'id', 'user_id');
    }

    public static function getUserTickets()
    {
        $query = self::query();

        return $query->whereUserId(\Auth::user()->id)->orderBy('ticket_id', "DESC")->paginate(10);
    }

    public function click()
    {
        return $this->hasOne(AffiliateClick::class, 'click_id', 'click_id');
    }

    /**
     * @return VendorSetting
     */
    public function setting()
    {
        return $this->hasOne(VendorSetting::class, 'vendor_id', 'vendor_id');
    }

    /**
     * @return VendorPayout
     */
    public function payout()
    {
        return $this->hasOne(VendorPayout::class, 'vendor_id', 'vendor_id');
    }

    public function getUserCashback()
    {
        return $this->setting->getUserCashback($this->payout, $this);
    }
}
