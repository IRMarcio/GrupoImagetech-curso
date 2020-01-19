<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEndArmazemCdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('end_armazem_cd', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('centro_distribuicao_id')->nullable(true);
            $table->foreign('centro_distribuicao_id')->references('id')->on('centro_distribuicao');

            $table->unsignedInteger('armazem_id')->nullable(true);
            $table->foreign('armazem_id')->references('id')->on('armazem');

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
        Schema::dropIfExists('end_armazem_cd');
    }
}
