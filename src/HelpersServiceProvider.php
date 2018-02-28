<?php

namespace Tugumuda\Helpers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'timezones');
		$this->publishes([
	        __DIR__.'/views' => base_path('resources/views/tugumuda_helpers/timezones'),
	    ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';
		$this->app->make('Tugumuda\Helpers\HelpersController');
    }
}
