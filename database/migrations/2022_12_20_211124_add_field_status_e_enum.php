<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldStatusEEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('info_indicadores', function (Blueprint $table) {
            $table->string('status');
            $table->string('enum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('info_indicadores', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('enum');
        });
    }
}
