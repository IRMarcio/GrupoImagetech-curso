<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunicipioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipio', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 150);
            $table->string('longitude', 20)->nullable();
            $table->string('latitude', 20)->nullable();
            $table->unsignedInteger('uf_id');
            $table->foreign('uf_id')->references('id')->on('uf');
            $table->boolean('ind_cep_unico')->default(false);
            $table->string('cep', 8)->nullable();

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
        Schema::dropIfExists('municipio');
    }
}
