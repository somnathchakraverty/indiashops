<?php

namespace indiashopps\Providers;

use Monolog\Logger;
use Monolog\Handler\SlackHandler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if( env('APP_ENV') != 'local' )
        {
            $this->app['request']->server->set('HTTPS', true);
        }
        
        $this->slackErrorLogging();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() { }

    public function slackErrorLogging()
    {
        $level = Logger::NOTICE;

        $channel = '#dev-log-errors';
        if (env('APP_ENV') == 'uat') {
            $channel = '#uat-log-errors';
        } else {
            if (env('APP_ENV') == 'production') {
                $channel = '#production-log-errors';
                $level   = Logger::WARNING;
            } else {
                if (env('APP_ENV') == 'staging') {
                    $channel = '#staging-log-errors';
                } else {
                    if (env('APP_ENV') == 'local') {
                        $channel = '#local_errors';
                    }
                }
            }
        }

        \Log::getMonolog()->pushHandler(new SlackHandler(env('SLACK_TOKEN'), $channel, 'Alert', true, null, $level,
            true, true, true));
    }
}