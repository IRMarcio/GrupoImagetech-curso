<?php

namespace App\Jobs;

use App\Models\Arquivo;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 *
 * Em algumas partes do sistema existe o upload de arquivos. Esses arquivos são criados na tabela de arquivos e ficam
 * sem associação a nenhum conteúdo até  o usuário decidir salvar o formulário que ele está fazendo upload.
 * Caso o usuário feche o browser sem salvar o formulário, estes arquivos ficarão órfãos.
 *
 * Essa classe limpa estes arquivos que sobraram.
 *
 * @package App\Jobs
 */
class LimparUploadsTemp implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $arquivos = Arquivo::whereNull('model')->get();
        foreach ($arquivos as $arquivo) {
            $arquivo->delete();
        }
    }

}
