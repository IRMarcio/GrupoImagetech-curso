<?php

use App\Models\TipoRota;
use Illuminate\Database\Seeder;

class TipoRotaSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(__DIR__ . '/data/tiporota.json');
        $registros = json_decode($json, true);

        foreach ($registros as $registro) {
            $achou = TipoRota::where('descricao', $registro['descricao'])->first();
            if (!$achou) {
                TipoRota::create($registro);
            }
        }
    }
}
