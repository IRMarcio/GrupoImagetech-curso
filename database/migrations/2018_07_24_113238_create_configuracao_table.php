<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracaoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracao', function (Blueprint $table) {
            $table->increments('id');

            $table->string('email_host')->nullable();
            $table->string('email_porta')->nullable();
            $table->string('email_encriptacao')->nullable();
            $table->string('email_nome')->nullable()->default('Singest');
            $table->string('email')->nullable();
            $table->string('email_senha')->nullable();

            $table->string('timezone')->default('America/Sao_Paulo');
            $table->integer('tempo_maximo_sessao')->default(1440); // 1440 minutos
            $table->char('acao_apos_timeout_sessao', 1)->default('B'); // Bloquear tela
            $table->integer('max_tentativas_login')->default(5);
            $table->text('termos_uso')->nullable();
            $table->integer('dias_max_alterar_senha')->default(182); // 6 meses
            $table->integer('max_senhas_historico')->default(5); // 5 senhas

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
        Schema::dropIfExists('configuracao');
    }
}
