<?php

namespace indiashopps\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use indiashopps\Models\Company;

class SaveCompanyDetails
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
        $company = new Company;
        $data    = collect($event->data);
        $user    = $event->user;

        $company->company_name   = $data->get('company_name');
        $company->contact_name   = $data->get('name');
        $company->contact_email  = $data->get('email');
        $company->contact_number = $data->get('mobile');
        $company->address        = $data->get('address');
        $company->gst            = $data->get('gst');

        $company->save();

        $user->company_id = $company->id;

        $user->save();

        \Log::info("New Company Created.. Company ID: " . $company->id);
    }
}
