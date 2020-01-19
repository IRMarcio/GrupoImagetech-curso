<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentroDistribuicaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centro_distribuicao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 150)->nullable();
            $table->boolean('ativo')->default(true);
            $table->string('responsavel', 200)->nullable();
            $table->boolean('matriz')->default(false);
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
        Schema::dropIfExists('centro_distribuicao');
    }
}
