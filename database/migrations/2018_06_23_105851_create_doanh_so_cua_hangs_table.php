<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoanhSoCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doanh_so_cua_hangs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_cua_hang');
            $table->foreign('id_cua_hang')->references('id')->on('cua_hangs');
            $table->integer('thang')->nullable();        
            $table->integer('nam')->nullable();        
            $table->date('ngay_bat_dau')->nullable();        
            $table->date('ngay_ket_thuc')->nullable();        
            $table->decimal('muc_tieu_doanh_so')->nullable();        
            $table->decimal('doanh_so_thuc_te')->nullable();        
            $table->decimal('hieu_suat')->nullable();
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
        Schema::dropIfExists('doanh_so_cua_hangs');
    }
}
