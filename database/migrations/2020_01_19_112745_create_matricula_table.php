<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatriculaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('centro_cursos_id');
            $table->unsignedInteger('alunos_id');
            $table->unsignedInteger('centro_distribuicao_id');


            $table->boolean('ativo');
            $table->tinyInteger('status')->comments('Em Andamento, Trancada, Abandonado,Finalizada');

            $table->foreign('centro_cursos_id')->references('id')->on('centro_cursos');
            $table->foreign('alunos_id')->references('id')->on('alunos');
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
        Schema::dropIfExists('matriculas');
    }
}
