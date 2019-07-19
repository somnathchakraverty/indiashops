<?php

namespace indiashopps\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use indiashopps\Console\Commands\CategoryProducts;
use indiashopps\Console\Commands\CouponJsonCommand;
use indiashopps\Console\Commands\HeaderJson;
use indiashopps\Console\Commands\HomeJsonCommand;
use indiashopps\Console\Commands\ImageHandler;
use indiashopps\Console\Commands\Sitemap;
use indiashopps\Console\Commands\Slim;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Sitemap::class,
        Slim::class,
        ImageHandler::class,
        HomeJsonCommand::class,
        HeaderJson::class,
        CategoryProducts::class,
        CouponJsonCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('generate:comparative_deals')->dailyAt("07:00");
        $schedule->command('generate:coupon_json')->dailyAt("07:00");
        $schedule->command('fcm:add_tokens_to_topic')->hourly();
        $schedule->command('facebook:publish_post')->hourly();
        $schedule->command('generate:home_json')->cron("* */4 * * *");
        $schedule->command('generate:header_json')->cron("* */4 * * *");
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
