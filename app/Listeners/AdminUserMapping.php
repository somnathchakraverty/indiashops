<?php

namespace indiashopps\Listeners;

use indiashopps\Models\UserMapping;

class AdminUserMapping
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
        $mapping = new UserMapping;

        $mapping->user_id     = $event->user->id;
        $mapping->permissions = json_encode([]);
        $mapping->user_type   = 'admin';
        $mapping->save();

        \Log::info("Admin User Mapping Create for user_id: " . $event->user->id);
    }
}
