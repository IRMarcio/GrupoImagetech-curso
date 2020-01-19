<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\ExcluirRegistrosTemporariosVencidos as ExcluirRegistrosTemporariosVencidosService;

class ExcluirRegistrosTemporariosVencidos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ExcluirRegistrosTemporariosVencidosService
     */
    private $excluirRegistrosTemporariosVencidosService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->excluirRegistrosTemporariosVencidosService = app(ExcluirRegistrosTemporariosVencidosService::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->excluirRegistrosTemporariosVencidosService->excluir();
    }
}
