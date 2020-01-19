<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 200)->nullable();
            $table->string('cpf', 30)->nullable();
            $table->string('senha')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('email', 150)->nullable();
            $table->string('tel_celular', 15)->nullable();
            $table->string('tel_residencial', 15)->nullable();
            $table->date('ultimo_login')->nullable();
            $table->date('ultima_alteracao_senha')->nullable();
            $table->boolean('aceitou_termos_uso')->default(false);
            $table->boolean('gestor')->default(false);
            $table->boolean('super_admin')->default(false);
            $table->string('remember_token')->nullable();

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
        Schema::dropIfExists('usuario');
    }
}
