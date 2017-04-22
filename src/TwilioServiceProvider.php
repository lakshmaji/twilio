<?php 

namespace Lakshmaji\Twilio;

use Illuminate\Support\ServiceProvider;

/**
 * Twilio - ServicePrivider to support integration with Laravel framework 
 *
 * @package  Twilio
 * @version  1.2.2
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
     * @return   Twilio
     * @version  1.2.2
     * @author   lakshmaji 
     */
    public function register()
    {
        if (method_exists(\Illuminate\Foundation\Application::class, 'singleton')) {
            $this->app->singleton('twilio', function($app) {
                return new Twilio;
            });
        } else {
            $this->app['twilio'] = $this->app->share(function($app) {
                return new Twilio;
            });
        }
        // $this->app['twilio'] = $this->app->share(function($app) {
        //     return new Twilio;
        // });
    }
}
// end of TwilioServiceProvider class
// end of file TwilioServiceProvider 

