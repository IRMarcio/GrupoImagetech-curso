<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentroCursoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centro_cursos', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('centro_distribuicao_id');
            $table->foreign('centro_distribuicao_id')->references('id')->on('centro_distribuicao');

            $table->unsignedInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('cursos');

            $table->unsignedInteger('tipo_periodo_id');
            $table->foreign('tipo_periodo_id')->references('id')->on('tipo_periodos');

            $table->integer('quantidade_vagas');

            $table->date('data_inicio')->nullable()->comments('A data de Início do Curso Cadastrado Marca o Ano Letivo do mesmo');

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
        Schema::dropIfExists('centro_cursos');
    }
}
