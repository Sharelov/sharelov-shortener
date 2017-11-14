<?php 

namespace Sharelov\Shortener;

use Illuminate\Support\ServiceProvider;

class ShortenerServiceProvider extends ServiceProvider{

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/shortener.php' => config_path('shortener.php'),
        ],'config');
        $this->publishes([
            __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');
    }
    /**
    * Register the service provider.
    *
    * @return void
    */

    public function register ()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Config/shortener.php', 'shortener'
        );
        $this->app->bind(
            'Shortener','Sharelov\Shortener\ShortenerService'
        );
        $this->app->make( 
            'Sharelov\Shortener\Controllers\LinksController' 
        ); 
    }
}
