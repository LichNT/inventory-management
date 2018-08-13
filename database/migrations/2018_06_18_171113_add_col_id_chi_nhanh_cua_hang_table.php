<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColIdChiNhanhCuaHangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cua_hangs', function (Blueprint $table) {
           
            $table->integer('id_chi_nhanh')->nullable();
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
           
            $table->dropColumn('id_chi_nhanh');
        });
    }
}
