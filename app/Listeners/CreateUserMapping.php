<?php

namespace indiashopps\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use indiashopps\Events\CorporateUserCreated;
use indiashopps\Models\UserMapping;

class CreateUserMapping
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
    public function handle(CorporateUserCreated $event)
    {
        $mapping = new UserMapping;

        $mapping->user_id     = $event->user_id;
        $mapping->permissions = (is_array($event->permissions)) ? json_encode($event->permissions) : json_encode([]);
        $mapping->user_type   = 'user';
        $mapping->save();

        \Log::info("User Mapping Create for user_id: " . $event->user_id);
    }
}
