<?php

namespace indiashopps\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use indiashopps\Events\CompanyCreated;
use indiashopps\Events\CorporateUserCreated;
use indiashopps\Events\WithdrawalStatusChanged;
use indiashopps\Listeners\AdminUserMapping;
use indiashopps\Listeners\ClearRedisCache;
use indiashopps\Listeners\CreateUserMapping;
use indiashopps\Listeners\SaveCompanyDetails;
use indiashopps\Listeners\UpdatePendingWithdrawal;
use indiashopps\Listeners\UpdateVersion;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'indiashopps\Events\HomepageJsonGenerated' => [
            ClearRedisCache::class,
            UpdateVersion::class,
        ],
        WithdrawalStatusChanged::class             => [
            UpdatePendingWithdrawal::class
        ],
        CorporateUserCreated::class                => [
            CreateUserMapping::class
        ],
        CompanyCreated::class                      => [
            SaveCompanyDetails::class,
            AdminUserMapping::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
