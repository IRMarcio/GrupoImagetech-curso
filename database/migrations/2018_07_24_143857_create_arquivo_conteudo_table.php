<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArquivoConteudoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivo_conteudo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('arquivo_id');
            $table->foreign('arquivo_id')->references('id')->on('arquivo')->onDelete('cascade');
            $table->timestamps();
        });

        \DB::statement("ALTER TABLE arquivo_conteudo ADD conteudo LONGBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arquivo_conteudo');
    }
}
