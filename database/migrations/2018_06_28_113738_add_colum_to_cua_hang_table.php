<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumToCuaHangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cua_hangs', function (Blueprint $table) {
            $table->integer('id_mien')->nullable();
            $table->foreign('id_mien')->references('id')->on('to_chucs');
            $table->integer('id_chi_nhanh')->nullable();
            $table->foreign('id_chi_nhanh')->references('id')->on('to_chucs');
            $table->string('ma_chi_nhanh')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cua_hangs', function (Blueprint $table) {
            $table->dropColumn('id_mien');
            $table->dropColumn('id_chi_nhanh');
            $table->string('ma_chi_nhanh')->nullable(false)->change();

        });
    }
}
