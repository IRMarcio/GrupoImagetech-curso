<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\UnidadeController;
use App\Http\Requests\SalvarCursoRequest;
use App\Models\Curso;
use Illuminate\Database\Seeder;
use function MongoDB\BSON\toJSON;


class CursoSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $json = File::get(__DIR__.'/data/cursos.json');
        $registros = json_decode($json, true);
        $salvar = new SalvarCursoRequest();
        $controller = app()->make(CursoController::class);

        foreach ($registros as $registro) {

            $achou = Curso::where('nome', $registro['nome'])->first();
            if (!$achou) {
                $controller->callAction('salvar', [$salvar->merge($registro)]);
            }
        }
    }
}
