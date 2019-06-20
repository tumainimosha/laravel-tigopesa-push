<?php

namespace Tumainimosha\TigopesaPush;

use Illuminate\Support\ServiceProvider;

class TigopesaPushServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tigopesa-push.php', 'laravel-tigopesa-push');
        $this->publishThings();
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'LaravelTigopesaPush');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register facade
        $this->app->singleton('tigopesa-push', function () {
            $service = new TigopesaPush;

            $service->setUsername(config('tigopesa-push.username'))
                ->setPassword(config('tigopesa-push.password'))
                ->setBillerMsisdn(config('tigopesa-push.biller_msisdn'))
                ->setTokenUrl(config('tigopesa-push.token_url'))
                ->setBillPayUrl(config('tigopesa-push.bill_pay_url'));

            return $service;
        });
    }

    public function publishThings()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/tigopesa-push.php' => config_path('tigopesa-push.php'),
            ], 'config');
        }
    }
}
