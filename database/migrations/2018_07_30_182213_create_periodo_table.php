<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->longText('descricao');
            $table->boolean('sustentavel')->default(true);
            $table->string('unidade_fornecimento', 255);

            $table->unsignedInteger('tipo_periodo_id')->nullable();
            $table->foreign('tipo_periodo_id')->references('id')->on('tipo_periodos');

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
        Schema::dropIfExists('periodos');
    }
}
