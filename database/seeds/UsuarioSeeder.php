<?php

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(__DIR__ . '/data/usuarios.json');
        $registros = json_decode($json, true);

        foreach ($registros as $registro) {
            $achou = Usuario::where('cpf', $registro['cpf'])->first();
            if (!$achou) {
                $usuario = Usuario::create($registro);
            }
        }
    }
}
