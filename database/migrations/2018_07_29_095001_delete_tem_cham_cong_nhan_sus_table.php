<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTemChamCongNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tem_cham_cong_nhan_sus');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('tem_cham_cong_nhan_sus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma');
            $table->string('he_so_hoan_thanh_cong_viec')->nullable();
            $table->string('he_so_luong_san_pham')->nullable();
            $table->string('ngay_cong_so_01')->nullable();
            $table->string('ngay_cong_so_02')->nullable();
            $table->string('ngay_cong_so_03')->nullable();
            $table->string('ngay_cong_so_04')->nullable();
            $table->string('ngay_cong_so_05')->nullable();
            $table->string('ngay_cong_so_06')->nullable();
            $table->string('ngay_cong_so_07')->nullable();
            $table->string('ngay_cong_so_08')->nullable();
            $table->string('ngay_cong_so_09')->nullable();
            $table->string('ngay_cong_so_10')->nullable();
            $table->string('ngay_cong_so_11')->nullable();
            $table->string('ngay_cong_so_12')->nullable();
            $table->string('ngay_cong_so_13')->nullable();
            $table->string('ngay_cong_so_14')->nullable();
            $table->string('ngay_cong_so_15')->nullable();
            $table->string('ngay_cong_so_16')->nullable();
            $table->string('ngay_cong_so_17')->nullable();
            $table->string('ngay_cong_so_18')->nullable();
            $table->string('ngay_cong_so_19')->nullable();
            $table->string('ngay_cong_so_20')->nullable();
            $table->string('ngay_cong_so_21')->nullable();
            $table->string('ngay_cong_so_22')->nullable();
            $table->string('ngay_cong_so_23')->nullable();
            $table->string('ngay_cong_so_24')->nullable();
            $table->string('ngay_cong_so_25')->nullable();
            $table->string('ngay_cong_so_26')->nullable();
            $table->string('ngay_cong_so_27')->nullable();
            $table->string('ngay_cong_so_28')->nullable();
            $table->string('ngay_cong_so_29')->nullable();
            $table->string('ngay_cong_so_30')->nullable();
            $table->string('ngay_cong_so_31')->nullable();
            $table->string('cong_le')->nullable();
            $table->string('cong_phep')->nullable();
            $table->string('cong_cong_tac')->nullable();
            $table->string('cong_nghi_bu')->nullable();
            $table->string('cong_rieng')->nullable();
            $table->string('cong_rieng_khong_luong')->nullable();
            $table->string('cong_om')->nullable();
            $table->string('cong_thai_san')->nullable();
            $table->boolean('inactive')->default(true);
        });
    }
}
