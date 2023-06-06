<?php

namespace Bobanum\Revamp;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Bobanum\Revamp\Console\RevampCommand;

class RevampServiceProvider extends ServiceProvider implements DeferrableProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        if ($this->app->runningInConsole()) {
            $this->commands($this->provides());
        }
        $this->publishes([
            __DIR__ . '/config.php' => config_path('revamp.php'),
        ], 'config');
        return;
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [
            Console\RevampCommand::class,
            Console\RevampBackCommand::class,
            Console\RevampRefreshCommand::class,
        ];
    }
}
