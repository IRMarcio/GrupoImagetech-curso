<?php

namespace App\Jobs;

use App\Services\TratarSessoesInvalidas as TratarSessoesInvalidasService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 *
 * Trata as sessões que estão inválidas, 
 * tempo(time) da última atividade do usuário + tempo máximo da sessão seja maior que o tempo atual
 * (last_activity + tempo_maximo_sessao) > time()
 *
 * @package App\Jobs
 */
class TratarSessoesInvalidas implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TratarSessoesInvalidasService
     */
    private $tratarSessoesInvalidasService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->tratarSessoesInvalidasService = app(TratarSessoesInvalidasService::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->tratarSessoesInvalidasService->tratar();
    }

}
