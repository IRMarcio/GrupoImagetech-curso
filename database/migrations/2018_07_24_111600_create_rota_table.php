<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRotaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rota', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 150);
            $table->string('descricao_get', 150)->nullable();
            $table->string('descricao_post', 150)->nullable();
            $table->string('rota', 150);
            $table->unsignedInteger('tipo_rota_id');
            $table->char('acesso_liberado')->default('N');
            $table->char('desenv')->default('N');

            $table->foreign('tipo_rota_id')->references('id')->on('tipo_rota');
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
        Schema::dropIfExists('rota');
    }
}
