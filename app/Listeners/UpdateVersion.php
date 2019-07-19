<?php

namespace indiashopps\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class UpdateVersion
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        $version = frontEndVersion();
        $version = $version + 1;

        Storage::disk('local')->put('indiashopps_version', $version);
    }
}
