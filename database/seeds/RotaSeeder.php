<?php

use App\Models\Rota;
use App\Models\TipoRota;
use Illuminate\Database\Seeder;

class RotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(__DIR__ . '/data/rotas.json');
        $registros = json_decode($json, true);


        foreach ($registros as $registro) {
            $tipo = TipoRota::where('descricao', $registro['tipo_rota_id'])->first();
            if (!$tipo) {
                dd('O tipo da rota (' . $registro['tipo_rota_id'] . ') não existe no banco.');
            }
            $registro['tipo_rota_id'] = $tipo->id;


            $achou = Rota::where('rota', $registro['rota'])->first();
            if (!$achou) {
                    Rota::create($registro);
            } else {
                $achou->update($registro);
            }
        }
    }
}
