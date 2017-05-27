<?php
namespace Iwanli\Wxxcx;

use Illuminate\Support\ServiceProvider;

class WxxcxServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $config_file = __DIR__ . '/../config/config.php';

        $this->mergeConfigFrom($config_file, 'wxxcx');

        $this->publishes([
            $config_file => config_path('wxxcx.php')
        ], 'wxxcx');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('wxxcx', function ()
        {
            return new Wxxcx();
        });

        $this->app->alias('wxxcx', Wxxcx::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['wxxcx', Wxxcx::class];
    }
}
