<?php

use App\Models\TipoPeriodo;
use Illuminate\Database\Seeder;

class TipoPeriodoSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(__DIR__ . '/data/tipoperiodo.json');
        $registros = json_decode($json, true);

        foreach ($registros as $registro) {
            $achou = TipoPeriodo::where('descricao', $registro['descricao'])->first();
            if (!$achou) {
                TipoPeriodo::create($registro);
            }
        }
    }
}
