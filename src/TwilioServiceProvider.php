<?php namespace Lakshmajim\Twilio;

use Illuminate\Support\ServiceProvider;

/**
 * Twilio - ServicePrivider to support integration with Laravel framework 
 *
 * @package  Twilio
 * @version  1.0.0
 * @author   lakshmaji 
 */ 

class TwilioServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['twilio'] = $this->app->share(function($app) {
            return new Twilio;
        });
    }
}
// end of TwilioServiceProvider class
// end of file TwilioServiceProvider 

