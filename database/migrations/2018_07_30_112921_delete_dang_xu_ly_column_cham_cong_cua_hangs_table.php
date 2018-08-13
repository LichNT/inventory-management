<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteDangXuLyColumnChamCongCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cham_cong_cua_hangs', function (Blueprint $table) {
            $table->dropColumn('dang_xu_ly');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cham_cong_cua_hangs', function (Blueprint $table) {
            $table->boolean('dang_xu_ly')->default(false);   
        });                   
    }
}
