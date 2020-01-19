<?php

use Illuminate\Database\Seeder;
use App\Models\Estado;
use App\Models\Municipio;

class MunicipioSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cidades = File::allFiles(__DIR__ . '/data/cidades');
        $total = Estado::all()->pluck('id', 'uf')->count();
        $estados = Estado::all()->pluck('id', 'uf')->toArray();
        $this->command->getOutput()->progressStart($total);
        foreach ($cidades as $cidadeFile) {
            $this->command->getOutput()->progressAdvance();
            try {
                $json = File::get($cidadeFile);
                $registros = json_decode($json, true);

                $uf = str_replace('.json', '', $cidadeFile->getRelativePathname());

                if (isset($estados[$uf])) {
                    $totalCidades = Municipio::where('uf_id', $estados[$uf])->count();
                    if ($totalCidades) {
                        foreach ($registros as $registro) {
                            $achou = Municipio::where('descricao', $registro['descricao'])->where('uf_id', $estados[$uf])->first();
                            if (!$achou) {
                                $registro['uf_id'] = $estados[$uf];

                                Municipio::create($registro);
                            }
                        }
                    } else {
                        foreach ($registros as &$registro) {
                            $registro['uf_id'] = $estados[$uf];
                            $registro['created_at'] = now(config('app.timezone'));
                            $registro['updated_at'] = now(config('app.timezone'));

                            if (app()->runningUnitTests()) {
                                Municipio::create($registro);
                            }
                        }

                        if (!app()->runningUnitTests()) {
                            Municipio::insert($registros);
                        }
                    }
                }
            }
            catch (Exception $e) {
                dd("Erro ao rodar seeder de municipios: " . $e->getMessage());
            }
        }
        $this->command->getOutput()->progressFinish();
    }
}
