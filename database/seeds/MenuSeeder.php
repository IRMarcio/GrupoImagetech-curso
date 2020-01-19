<?php

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(__DIR__ . '/data/menu.json');
        $registros = json_decode($json, true);

        $this->criarMenu($registros);
    }

    private function criarMenu($registros, $menu = null)
    {
        foreach ($registros as $registro) {
            $registro['menu_id'] = null;

            if (!is_null($menu)) {
                $registro['menu_id'] = $menu->id;
            }

            $achou = Menu::where('slug', $registro['slug'])->first();
            if (!$achou) {
                if (isset($registro['filhos'])) {
                    $filhos = $registro['filhos'];
                    unset($registro['filhos']);
                }

                $menuCriado = Menu::create($registro);
                if (isset($filhos)) {
                    $this->criarMenu($filhos, $menuCriado);
                }
            }
        }
    }
}
