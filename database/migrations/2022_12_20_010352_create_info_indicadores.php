<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoIndicadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_indicadores', function (Blueprint $table) {
            $table->id();
            $table->integer("id_indicador");
            $table->string("notas");
            $table->string("estado")->nullable();
            $table->string("cidade")->nullable();
            $table->string("ano")->nullable();
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
        Schema::dropIfExists('info_indicadores');
    }
}
