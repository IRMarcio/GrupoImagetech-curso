<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endereco', function (Blueprint $table) {
            $table->increments('id');
            $table->string('telefone', 15)->nullable();
            $table->string('fax', 15)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('bairro', 255)->nullable();
            $table->string('numero', 50)->nullable();
            $table->string('complemento', 150)->nullable();
            $table->string('cep', 16)->nullable();
            $table->string('latitude', 20)->nullable();
            $table->string('longitude', 20)->nullable();

            $table->unsignedInteger('uf_id')->nullable();
            $table->foreign('uf_id')->references('id')->on('municipio');

            $table->unsignedInteger('municipio_id')->nullable();
            $table->foreign('municipio_id')->references('id')->on('municipio');

            $table->unsignedInteger('centro_distribuicao_id')->nullable();
            $table->foreign('centro_distribuicao_id')->references('id')->on('centro_distribuicao');

            $table->unsignedInteger('aluno_id')->nullable();
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
        Schema::dropIfExists('endereco');
    }
}
