<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cua_hangs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma_chi_nhanh');
            $table->string('ma');
            $table->string('ten');
            $table->string('ten_dia_diem');
            $table->date('ngay_dang_ki_kinh_doanh');
            $table->date('ngay_ban_hang')->nullable();
            $table->date('ngay_khai_truong')->nullable();
            $table->string('quoc_gia')->nullable();
            $table->string('tinh_thanh')->nullable();
            $table->string('quan_huyen')->nullable();
            $table->string('phuong_xa')->nullable();
            $table->string('so_nha')->nullable();
            $table->string('nguoi_dai_dien')->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->string('email')->nullable();
            $table->string('nguoi_lien_he')->nullable();
            $table->string('loai_cua_hang')->nullable();
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('cua_hangs');
    }
}
