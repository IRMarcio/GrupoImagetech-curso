<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArquivoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivo', function (Blueprint $table) {
            $table->increments('id');

            // Relacionados ao arquivo fisico
            $table->string('nome');
            $table->string('mimetype');
            $table->integer('tamanho');

            // Campos gerais
            $table->string('model')->nullable();
            $table->unsignedInteger('registro_id')->nullable();
            $table->integer('visualizacoes')->default(0);
            $table->boolean('contar_visualizacoes')->default(true);
            $table->boolean('publico')->default(false);

            $table->index(['registro_id', 'model']);
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
        Schema::dropIfExists('arquivo');
    }
}
