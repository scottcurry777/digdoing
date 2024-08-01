<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;

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
		If (env('APP_ENV') !== 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }
		
        Builder::defaultStringLength(191);
    }
}
