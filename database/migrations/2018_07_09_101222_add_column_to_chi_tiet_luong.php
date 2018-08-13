<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToChiTietLuong extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chi_tiet_luongs', function (Blueprint $table) {
            $table->decimal('luong_co_ban',18,0)->nullable();
            $table->decimal('tien_phu_cap',18,0)->nullable();
            $table->boolean('inactive')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chi_tiet_luongs', function (Blueprint $table) {
            $table->dropColumn('luong_co_ban');
            $table->dropColumn('tien_phu_cap');
            $table->dropColumn('inactive');
        });
    }
}
