<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlunoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {

            $table->increments('id');
            $table->string('nome', 255)->nullable();
            $table->string('cpf', 50)->nullable();
            $table->string('rg', 50)->nullable();
            $table->string('telefone', 15)->nullable();
            $table->date('dt_nascimento')->nullable();
            $table->string('email', 150)->nullable();
            $table->tinyInteger('ativo')->default(1);
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
        Schema::dropIfExists('alunos');
    }
}
