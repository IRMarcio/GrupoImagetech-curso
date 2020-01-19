<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEndAlocacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('end_alocacao', function (Blueprint $table) {
            $table->increments('id');

            $table->string('area', 2);
            $table->string('rua', 2);
            $table->string('modulo', 3);
            $table->string('nivel', 2);
            $table->string('vao');

            //campo responsavel por analizar a capacidade por produto de espaço ocupado pelo vão;
            $table->integer('produtos')->nullable();
            //campo responsavel por analizar a quantidade de caixas  de produtos armazenados;
            $table->integer('caixas')->nullable();
            //campo responsavel por analizar a quantidade  de paletes de produtos armazenados;
            $table->integer('paletes')->nullable();

            $table->unsignedInteger('centro_distribuicao_id')->nullable();
            $table->foreign('centro_distribuicao_id')->references('id')->on('centro_distribuicao');

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
        Schema::dropIfExists('end_alocacao');
    }
}
