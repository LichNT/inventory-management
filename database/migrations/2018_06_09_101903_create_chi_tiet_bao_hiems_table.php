<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietBaoHiemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_bao_hiems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nhan_su');
            $table->foreign('id_nhan_su')->references('id')->on('nhan_sus');
            $table->string('ten');
            $table->date('thang_bat_dau')->nullable();
            $table->date('thang_chuyen_bao_hiem_ve_chi_nhanh')->nullable();
            $table->date('thang_dung_dong_bao_hiem')->nullable();
            $table->double('muc_dong_bao_hiem_xa_hoi')->nullable();
            $table->date('tu_ngay')->nullable();
            $table->date('toi_ngay')->nullable();
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
        Schema::dropIfExists('chi_tiet_bao_hiems');
    }
}
