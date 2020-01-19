<?php

use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadoSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(__DIR__ . '/data/estados.json');
        $registros = json_decode($json, true);

        foreach ($registros as $registro) {
            $achou = Estado::where('uf', $registro['uf'])->first();
            if (!$achou) {
                Estado::create($registro);
            }
        }
    }
}
