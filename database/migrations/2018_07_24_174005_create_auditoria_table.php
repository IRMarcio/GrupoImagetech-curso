<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditoriaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditoria', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descricao')->nullable();
            $table->text('dados_server');
            $table->text('dados_get');
            $table->text('dados_post');
            $table->string('endereco_ipv4', 20);
            $table->string('metodo', 7);

            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('tipo_rota_id');
            $table->unsignedInteger('rota_id');

            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->foreign('tipo_rota_id')->references('id')->on('tipo_rota');
            $table->foreign('rota_id')->references('id')->on('rota');

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
        Schema::dropIfExists('auditoria');
    }

}
