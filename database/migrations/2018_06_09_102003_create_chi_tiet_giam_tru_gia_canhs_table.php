<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietGiamTruGiaCanhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_giam_tru_gia_canhs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nhan_su');
            $table->foreign('id_nhan_su')->references('id')->on('nhan_sus');
            $table->string('ho_ten');
            $table->date('ngay_sinh')->nullable();
            $table->boolean('gioi_tinh')->default(true);
            $table->string('quan_he')->nullable();
            $table->string('cmnd')->nullable();
            $table->date('thoi_diem_bat_dau')->nullable();
            $table->date('thoi_diem_ket_thuc')->nullable();
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
        Schema::dropIfExists('chi_tiet_giam_tru_gia_canhs');
    }
}
