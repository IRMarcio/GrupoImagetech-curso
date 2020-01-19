<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->string('nome');
            $table->float('valor_mensalidade', 16, 2)->nullable();
            $table->float('valor_matricula', 16, 2)->nullable();
            $table->integer('duracao')->comments('Tempo de Duração do curso');
            $table->longText('descricao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->json('tipo_periodo_id')->nullable();
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
        Schema::dropIfExists('cursos');
    }
}
