<?php

namespace Tugumuda\Helpers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /*$this->loadViewsFrom(__DIR__.'/views', 'timezones');
		$this->publishes([
	        __DIR__.'/views' => base_path('resources/views/tugumuda_helpers/timezones'),
	    ]);*/
		$config = include __DIR__.'/../config/config.php';

		$this->publishes([
			__DIR__.'/../assets' => $config['assets_path']
		]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*include __DIR__.'/routes.php';
		$this->app->make('Tugumuda\Helpers\HelpersController');*/
		$this->registerBootstrapFormBuilder();
		$this->registerFormatter();
		$this->registerConverter();
		$this->registerFpdf();

		$this->app->alias('BSForm', 'Tugumuda\Helpers\BootstrapFormBuilder');
		$this->app->alias('TMFormatter', 'Tugumuda\Helpers\Formatter');
        $this->app->alias('TMConverter', 'Tugumuda\Helpers\Converter');
        $this->app->alias('TMFPDF', 'Tugumuda\Helpers\FPDF');
    }

	/**
	 * Register the Bootstrap Form Helper instance.
	 *
	 * @return void
	 */
	protected function registerBootstrapFormBuilder()
	{
		$this->app->singleton('BSForm', function ($app) {
            return new BootstrapFormBuilder($app['html'], $app['url'], $app['session.store']->getToken(), $app['session.store']);
        });
	}

	/**
	 * Register the Formatter instance.
	 *
	 * @return void
	 */
	protected function registerFormatter()
	{
		$this->app->singleton('TMFormatter', function ($app) {
            return new Formatter();
        });
	}

	/**
	 * Register the Converter instance.
	 *
	 * @return void
	 */
	protected function registerConverter()
	{
		$this->app->singleton('TMConverter', function ($app) {
            return new Converter();
        });
	}

	/**
	 * Register the FPDF instance.
	 *
	 * @return void
	 */
	protected function registerFpdf()
	{
		$this->app->singleton('TMFPDF', function ($app) {
            return new FPDF();
        });
	}

	/**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['BSForm', 'TMFormatter', 'TMConverter', 'TMFPDF'];
    }

}
