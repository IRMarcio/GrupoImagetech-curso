<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao', 150);
            $table->string('slug', 150);
            $table->string('url')->nullable();
            $table->unsignedInteger('menu_id')->nullable();
            $table->string('tipo_menu')->nullable();
            $table->integer('ordem')->default(0);
            $table->string('icone')->nullable();
            $table->timestamps();
        });

        Schema::table('menu', function (Blueprint $table) {
            $table->foreign('menu_id')->references('id')->on('menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
