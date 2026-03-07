<?php

namespace App\Console;

use App\Console\Commands\ProcessInactiveUsersCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ProcessInactiveUsersCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
{
    $schedule->command('users:process-inactive')
        ->daily()
        ->withoutOverlapping();
}
}