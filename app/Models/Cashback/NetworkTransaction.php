<?php

namespace indiashopps\Models\Cashback;

use Illuminate\Database\Eloquent\Model;

class NetworkTransaction extends Model
{
    protected $table      = 'tb_network_transactions';
    protected $primaryKey = 'netrid';

    public function getStatus()
    {
        return NetworkStatus::getStatus($this);
    }

    public function network()
    {
        return $this->belongsTo(Network::class, 'network_id', 'network_id');
    }
}
