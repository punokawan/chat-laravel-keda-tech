<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // call passport:routes() here
        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }

        // Mandatory to define Scope
        Passport::tokensCan([
            'Staff' => 'Add/Edit/Delete ',
            'Customer' => 'customer'
        ]);

        Passport::setDefaultScope([
            'Customer'
        ]);
    }
}
