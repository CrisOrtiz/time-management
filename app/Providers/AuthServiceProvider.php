<?php

namespace App\Providers;

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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view_collection_menu', function () {
            $urlParts = explode('/', url()->current());
            if ($urlParts[3] === 'collection' && count($urlParts) > 4) {
                return true;
            }
            return false;
        });

        Gate::define('view_main_menu', function () {
            $urlParts = explode('/', url()->current());
            if ($urlParts[3] !== 'collection' || ($urlParts[3] === 'collection' && count($urlParts) === 4)) {
                return true;
            }
            return false;
        });
    }
}
