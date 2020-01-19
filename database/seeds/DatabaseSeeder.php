<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EstadoSeeder::class);
        $this->call(MunicipioSeeder::class);
        $this->call(TipoRotaSeeder::class);
        $this->call(ConfiguracaoSeeder::class);
        $this->call(SituacaoUsuarioSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(RotaSeeder::class);
    }
}
