<?php

use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UnidadeController;
use App\Models\Perfil;
use App\Models\Unidade;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PerfilSeeder extends Seeder
{
    /**
     * @var Faker
     */
    private $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    public function run()
    {

        $app = app();
        $controller = $app->make(PerfilController::class);

        Perfil::create($perfil);

    }

    function getPerfil(): array
    {
        return [
            "nome" => "Perfil Administrativo São paulo",
            "ativo" => "1",
            "unidade_id"
        ];
    }


}
