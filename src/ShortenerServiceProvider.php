<?php

namespace Sharelov\Shortener;

use Illuminate\Support\ServiceProvider;

class ShortenerServiceProvider extends ServiceProvider
{
    /**
     * Register any other events for your application.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/shortener.php' => config_path('shortener.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/create_shortener_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_shortener_table.php'),
            __DIR__.'/../database/migrations/update_shortener_table_add_hits_count.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_update_shortener_table_add_hits_count.php'),
        ], 'migrations');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/shortener.php', 'shortener');

        $this->app->bind('Shortener', ShortenerService::class);

        $this->app->make(
            'Sharelov\Shortener\Controllers\ShortLinksController'
        );
    }
}
