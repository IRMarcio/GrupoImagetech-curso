<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditoriaAcaoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditoria_acao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('auditoria_id');
            $table->string('tabela', 200);
            $table->unsignedInteger('registro_id');
            $table->enum('acao_tabela', ['I', 'U', 'D'])->default('I');
            $table->text('dados_new');
            $table->text('dados_old');
            $table->text('dados_alt');
            $table->timestamps();

            $table->foreign('auditoria_id')->references('id')->on('auditoria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auditoria_acao');
    }

}
