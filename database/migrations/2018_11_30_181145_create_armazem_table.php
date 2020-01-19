<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArmazemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('armazem', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 150)->nullable();
            $table->boolean('ativo')->default(true);
            $table->string('responsavel', 200)->nullable();

            $table->unsignedInteger('centro_distribuicao_id');
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
        Schema::dropIfExists('armazem');
    }
}
