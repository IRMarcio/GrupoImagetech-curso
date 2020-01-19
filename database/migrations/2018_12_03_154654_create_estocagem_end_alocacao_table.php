<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstocagemEndAlocacaoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estocagem_end_alocacao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('end_alocacao_id');
            $table->unsignedInteger('estocagem_id');
            $table->integer('ativo')->default(1);

            //$table->foreign('end_alocacao_id')->references('id')->on('end_alocacao');
            //$table->foreign('estocagem_id')->references('id')->on('estocagem');
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
        Schema::dropIfExists('estocagem_end_alocacao');
    }
}
