<?php

use Illuminate\Database\Seeder;
use App\Models\SituacaoUsuario;

class SituacaoUsuarioSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(__DIR__ . '/data/situacaousuario.json');
        $registros = json_decode($json, true);

        foreach ($registros as $registro) {
            $achou = SituacaoUsuario::where('descricao', $registro['descricao'])->first();
            if (!$achou) {
                SituacaoUsuario::create($registro);
            }
        }
    }
}
