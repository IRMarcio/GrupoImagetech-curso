<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoMatriculaCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_matricula_curso', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('matricula_id');
            $table->unsignedInteger('centro_curso_id');
            $table->unsignedInteger('aluno_id');
            $table->integer('status_anterior')->nullble();
            $table->integer('status_atual')->nullble();

            $table->foreign('matricula_id')->references('id')->on('matriculas');
            $table->foreign('centro_curso_id')->references('id')->on('centro_cursos');
            $table->foreign('aluno_id')->references('id')->on('alunos');
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
        Schema::dropIfExists('historico_matricula_curso');
    }
}
