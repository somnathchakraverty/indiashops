<?php

namespace indiashopps\Models\Cashback;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UserWithdrawal extends Model
{
    protected $table      = 'tb_user_withdrawals';
    protected $primaryKey = 'withdrawal_id';

    public static function getPendingAmount($user_id = 0)
    {
        if (auth()->check()) {
            $user_id = auth()->user()->id;
        }

        $cache_id = self::getUserCacheId($user_id);

        $amount = Cache::rememberForever($cache_id, function () use($user_id) {

            $withdrawal = UserWithdrawal::select([\DB::raw('SUM(amount) as total')])
                                        ->where('status', 'NOT LIKE', 'rejected')
                                        ->whereUserId($user_id)
                                        ->groupBy('amount')
                                        ->first();
            if (!is_null($withdrawal)) {
                return $withdrawal->total;
            }

            return 0;
        });

        return $amount;
    }

    public static function resetPendingAmount($user_id)
    {
        Cache::forget(self::getUserCacheId($user_id));

        self::getPendingAmount($user_id);
    }

    public static function getUserCacheId($user_id)
    {
        $cache_id = 'pending_withdrawal_amount_' . $user_id;
        return $cache_id;
    }
}
