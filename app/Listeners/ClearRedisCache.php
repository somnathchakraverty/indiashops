<?php

namespace indiashopps\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class ClearRedisCache
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()   { }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        $home_index = "*home*";
        $redis      = Cache::getRedis();
        $keys       = $redis->keys($home_index);
        $prefix     = Cache::getPrefix();

        foreach ($keys as $key) {
            $key = str_replace($prefix, "", $key);
            Cache::forget($key);
        }
    }
}
