<?php

namespace indiashopps\Models\Cashback;

use Carbon\Carbon;
use indiashopps\AndUser;
use Illuminate\Database\Eloquent\Model;

class AffiliateClick extends Model
{
    public    $timestamps = false;
    protected $table      = 'tb_clicks';
    protected $primaryKey = 'click_id';

    const STORE_OBJECT        = 'store';
    const COUPON_OBJECT       = 'coupon';
    const CB_DASHBOARD_OBJECT = 'cb_dashboard';
    const STORE_ID            = 223;

    public function user()
    {
        return $this->belongsTo(AndUser::class, 'id', 'user_id');
    }

    public function network()
    {
        return $this->belongsTo(Network::class, 'network_id', 'network_id');
    }

    public static function getMissingClicks()
    {
        if (\Auth::check()) {

            $query  = self::query();
            $clicks = $query->select([\DB::raw('tb_clicks.click_id clicked_id'), 'tb_clicks.vendor_id', 'click_time'])
                            ->leftJoin('tb_user_cashback', 'tb_user_cashback.click_id', '=', 'tb_clicks.click_id')
                            ->where('tb_clicks.user_id', \Auth::user()->id)
                            ->whereNull('user_cbid')
                            ->where('click_time', '<', Carbon::now()->subHours(72)->toDateTimeString())
                            ->where('click_time', '>', Carbon::now()->subDays(21)->toDateTimeString())
                            ->orderBy('tb_clicks.click_id', 'DESC')
                            ->get();

            return collect($clicks)->groupBy('vendor_id');
        } else {
            return false;
        }
    }
}
