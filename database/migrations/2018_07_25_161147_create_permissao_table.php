<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissaoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('perfil_id');
            $table->unsignedInteger('rota_id');

            $table->foreign('perfil_id')->references('id')->on('perfil');
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
        Schema::dropIfExists('permissao');
    }
}
