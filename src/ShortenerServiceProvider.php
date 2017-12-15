<?php

namespace Sharelov\Shortener;

use Illuminate\Support\ServiceProvider;

class ShortenerServiceProvider extends ServiceProvider
{
    /**
     * Register any other events for your application.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/shortener.php' => config_path('shortener.php'),
        ], 'config');
        
        $this->publishes([
            __DIR__.'/migrations/create_shortener_table.php.stub' => database_path('migrations/'
                                                                         .date('Y_m_d_his', time())
                                                                         .'_create_'
                                                                         .'shortener'
                                                                         .'_table.php'),
        ], 'migrations');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Config/shortener.php',
            'shortener'
        );
        $this->app->bind(
            'Shortener',
            'Sharelov\Shortener\ShortenerService'
        );
        $this->app->make(
            'Sharelov\Shortener\Controllers\ShortLinksController'
        );
    }
}
