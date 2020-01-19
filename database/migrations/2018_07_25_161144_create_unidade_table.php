<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidade', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 150)->nullable();
            $table->boolean('ativo')->default(true);
            $table->string('telefone', 15)->nullable();
            $table->string('fax', 15)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('responsavel', 200)->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('bairro', 255)->nullable();
            $table->string('numero', 50)->nullable();
            $table->string('complemento', 150)->nullable();
            $table->string('cep')->nullable();
            $table->unsignedInteger('municipio_id')->nullable();
            $table->foreign('municipio_id')->references('id')->on('municipio');

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
        Schema::dropIfExists('unidade');
    }
}
