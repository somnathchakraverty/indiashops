<?php

namespace indiashopps\Providers;

use indiashopps\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'indiashopps\Model' => 'indiashopps\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('has-access', function (User $user, $permission) {
            $permissions = $user->getPermissions();

            if (in_array($permission, $permissions)) {
                return true;
            }
            return false;
        });

        Gate::before(function (User $user, $ability, $perimission = '') {
            if ($ability == 'has-access' && $user->needsPermission($perimission)) {
                return true;
            }
        });
    }
}
