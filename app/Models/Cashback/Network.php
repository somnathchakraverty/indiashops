<?php

namespace indiashopps\Models\Cashback;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    protected $table      = 'tb_network';
    protected $primaryKey = 'network_id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function statuses()
    {
        return $this->hasMany(NetworkStatus::class, 'network_id', 'network_id');
    }
}
