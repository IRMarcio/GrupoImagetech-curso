<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 200);
            $table->boolean('ativo')->default(true);

            $table->unsignedInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidade');

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
        Schema::dropIfExists('secao');
    }
}
