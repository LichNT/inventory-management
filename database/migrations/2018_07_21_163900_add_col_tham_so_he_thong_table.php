<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColThamSoHeThongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tham_so_he_thongs', function (Blueprint $table) {
            $table->integer('luong_lam_them_gio_ngay_thuong')->nullable();
            $table->integer('luong_lam_them_gio_ngay_le')->nullable();
            $table->integer('luong_lam_them_gio_ngay_nghi')->nullable();
            $table->integer('he_so_luong_thu_viec')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tham_so_he_thongs', function (Blueprint $table) {
            $table->dropColumn('luong_lam_them_gio_ngay_thuong');
            $table->dropColumn('luong_lam_them_gio_ngay_le');
            $table->dropColumn('luong_lam_them_gio_ngay_nghi');
            $table->dropColumn('he_so_luong_thu_viec');
        });
    }
}
