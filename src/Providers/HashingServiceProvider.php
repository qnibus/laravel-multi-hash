<?php

namespace Qnibus\LaravelMultiHash\Providers;

use Qnibus\LaravelMultiHash\Hashing\JasyptHasher;
use Qnibus\LaravelMultiHash\Hashing\Md5Hasher;
use Qnibus\LaravelMultiHash\Hashing\Sha256Hasher;
use Qnibus\LaravelMultiHash\Hashing\Sha512Hasher;
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
            ->extend('sha256', function (Application $app) {
                return new Sha256Hasher($app['config']->get('hashing.sha256'));
            })
            ->extend('sha512', function (Application $app) {
                return new Sha512Hasher($app['config']->get('hashing.sha512'));
            })
            ->extend('jasypt', function (Application $app) {
                return new JasyptHasher($app['config']->get('hashing.jasypt'));
            })
            ->extend('md5', function () {
                return new Md5Hasher();
            });
    }
}
