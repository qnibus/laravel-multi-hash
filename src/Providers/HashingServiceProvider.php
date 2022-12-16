<?php

namespace Qnibus\LaravelJasyptHash\Providers;

use App\Hashing\JasyptHasher;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class HashingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/jasypt.php', 'hashing'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/jasypt.php' => config_path('jasypt.php')
        ], 'jasypt-config');

        $this->app['hash']
            ->extend('jasypt', function (Application $app) {
                return new JasyptHasher($app['config']->get('hashing.jasypt'));
            });
    }
}
