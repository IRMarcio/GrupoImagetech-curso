<?php

use App\Models\TabRelacaoProdutoCarga;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadeCentroDistribuicaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidade_centro_distribuicao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('unidade_id');
            $table->unsignedInteger('tab_centro_distribuicao_id');

            $table->foreign('unidade_id')->references('id')->on('unidade');
            $table->foreign('tab_centro_distribuicao_id')->references('id')->on('centro_distribuicao');
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
        Schema::dropIfExists('unidade_centro_distribuicao');
    }
}
