<?php

namespace App\Console;

use App\Console\Commands\Catalog\SaveRemoteImagesCommand;
use App\Console\Commands\Catalog\Seed\SeedCatalogCategoriesCommand;
use App\Console\Commands\Catalog\Seed\SeedCatalogDetailsCommand;
use App\Console\Commands\User\Auth\CreateUserCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CreateUserCommand::class,
        SeedCatalogCategoriesCommand::class,
        SeedCatalogDetailsCommand::class,
        SaveRemoteImagesCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
