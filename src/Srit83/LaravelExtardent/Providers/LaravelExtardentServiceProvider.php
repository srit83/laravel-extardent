<?php namespace Srit83\LaravelExtardent\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelExtardentServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    public function boot() {
        $this->package('srit83/laravel-extardent');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('extardent');
	}

}
