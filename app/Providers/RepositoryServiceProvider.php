<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\UserRepository::class,            \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoleRepository::class,            \App\Repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PatientRepository::class,         \App\Repositories\PatientRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AppointmentRepository::class,     \App\Repositories\AppointmentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PrescriptionRepository::class,    \App\Repositories\PrescriptionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\InvoiceRepository::class,         \App\Repositories\InvoiceRepositoryEloquent::class);

        //:end-bindings:
    }
}
