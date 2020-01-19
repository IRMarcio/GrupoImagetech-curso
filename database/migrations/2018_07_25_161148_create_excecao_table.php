<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcecaoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excecao', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('excecao');
            $table->unsignedInteger('perfil_usuario_id');
            $table->unsignedInteger('rota_id');

            $table->foreign('perfil_usuario_id')->references('id')->on('perfil_usuario');
            $table->foreign('rota_id')->references('id')->on('rota');
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
        Schema::dropIfExists('excecao');
    }
}
