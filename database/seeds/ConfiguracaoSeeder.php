<?php

use Illuminate\Database\Seeder;
use App\Models\Configuracao;


class ConfiguracaoSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configuracoes = Configuracao::first();
        if (is_null($configuracoes)) {
            Configuracao::create([]);
        }
    }
}
