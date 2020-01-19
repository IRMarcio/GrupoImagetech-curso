<?php

namespace App\Models;

class Menu extends BaseModel
{

    protected $table = 'menu';

    protected $fillable = [
        'descricao',
        'slug',
        'url',
        'menu_id',
        'tipo_menu',
        'ordem',
        'icone'
    ];

    /**
     * Retorna os menus ligados a este.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function filhos()
    {
        return $this->hasMany(Menu::class, 'menu_id');
    }
}
