<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietDongPhucsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_dong_phucs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_nhan_su');
            $table->foreign('id_nhan_su')->references('id')->on('nhan_sus');
            $table->unsignedInteger('nguoi_tao_id');
            $table->foreign('nguoi_tao_id')->references('id')->on('users');
            $table->unsignedInteger('nguoi_sua_id');
            $table->foreign('nguoi_sua_id')->references('id')->on('users');
            $table->unsignedInteger('so_luong')->default(1);
            $table->string('size');
            $table->boolean('huy_dang_ky')->default(false);
            $table->datetime('ngay_bao_huy')->nullable();
            $table->boolean('da_phat')->default(false);  
            $table->datetime('ngay_phat')->nullable();          
            $table->boolean('hoan_tra')->default(false);
            $table->datetime('ngay_hoan')->nullable();   
            $table->boolean('hong')->default(false);
            $table->datetime('ngay_bao_hong')->nullable();   
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
        Schema::dropIfExists('chi_tiet_dong_phucs');
    }
}
