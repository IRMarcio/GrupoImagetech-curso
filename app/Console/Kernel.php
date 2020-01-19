<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\LimparUploadsTemp;
use App\Jobs\ExcluirRegistrosTemporariosVencidos;
use App\Jobs\TratarSessoesInvalidas;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Geral
        $schedule->job(new TratarSessoesInvalidas)->everyMinute();
        $schedule->job(new LimparUploadsTemp)->monthly()->at('00:00');
        $schedule->job(new ExcluirRegistrosTemporariosVencidos)->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
