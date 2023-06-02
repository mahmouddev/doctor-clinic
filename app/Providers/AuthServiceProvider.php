<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

    ];


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->registerPolicies();
        //Gate::define('show-statistics',[\App\Policies\StatisticPolicy::class,'viewAny']);
        //Gate::define('create-notifications',[\App\Policies\AdditionalPermissionPolicy::class,'create_notifications']);

    }
}
