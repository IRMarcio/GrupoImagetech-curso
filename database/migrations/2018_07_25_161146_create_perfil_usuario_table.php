<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilUsuarioTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('principal');
            $table->boolean('ativo')->default(true);
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('perfil_id');

            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->foreign('perfil_id')->references('id')->on('perfil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil_usuario');
    }
}
