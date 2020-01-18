<?php

namespace Hsntngr\JetMail;

use Hsntngr\JetMail\Commands\JetMailMakeCommand;
use Illuminate\Support\ServiceProvider;

class JetMailServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                JetMailMakeCommand::class
            ]);
        }

        $this->publishes([
            __DIR__.'/config/jetmail.php' => config_path('jetmail.php'),
        ],'config');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('jetmailer', JetMail::class);
    }
}
