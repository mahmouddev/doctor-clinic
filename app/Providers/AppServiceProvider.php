<?php

namespace App\Providers;

use View;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        //URL::forceScheme('https');

        try{
            $settings = (new \App\Helpers\SettingsHelper)->getAllSettings();
            View::share('settings', $settings);
        }catch(\Exception $e){
          //dd($e->getMessage());  
        }

    }
}
