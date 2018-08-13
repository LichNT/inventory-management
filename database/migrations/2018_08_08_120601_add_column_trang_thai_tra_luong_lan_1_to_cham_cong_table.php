<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTrangThaiTraLuongLan1ToChamCongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cham_congs', function (Blueprint $table) {
            $table->boolean('trang_thai_tra_luong_lan_1')->default(false);
            $table->boolean('trang_thai_tra_luong_lan_2')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cham_congs', function (Blueprint $table) {
            $table->dropColumn('trang_thai_tra_luong_lan_1');
            $table->dropColumn('trang_thai_tra_luong_lan_2');
        });
    }
}
