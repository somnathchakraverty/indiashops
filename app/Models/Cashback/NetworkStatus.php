<?php

namespace indiashopps\Models\Cashback;

use Illuminate\Database\Eloquent\Model;

class NetworkStatus extends Model
{
    protected $table = 'tb_network_status';

    public static function getStatus(NetworkTransaction $transaction)
    {
        $query = self::query();

        $status = $query->whereNetworkId($transaction->network_id)
                        ->where('network_status', "LIKE", $transaction->status)
                        ->first();

        if (is_null($status)) {
            throw new \Exception('Invalid Network Status');
        } else {
            return $status->convert_status;
        }
    }
}
