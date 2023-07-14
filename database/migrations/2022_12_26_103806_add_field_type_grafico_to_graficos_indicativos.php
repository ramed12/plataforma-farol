<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldTypeGraficoToGraficosIndicativos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('graficos_indicativos', function (Blueprint $table) {
            $table->integer('type_grafico')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('graficos_indicativos', function (Blueprint $table) {
            $table->dropColumn('type_grafico');
        });
    }
}
