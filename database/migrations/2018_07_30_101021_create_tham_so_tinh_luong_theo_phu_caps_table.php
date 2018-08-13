<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThamSoTinhLuongTheoPhuCapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tham_so_tinh_luong_theo_phu_caps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bac_id');
            $table->foreign('bac_id')->references('id')->on('tham_so_tinh_luong_theo_bac_luongs');
            $table->integer('id_loai_phu_cap');
            $table->foreign('id_loai_phu_cap')->references('id')->on('loai_phu_caps');
            $table->integer('so_tien')->nullable(); 
            $table->unsignedInteger('company_id')->nullable();
            //$table->foreign('company_id')->references('id')->on('companies');    
            $table->datetime('tu_ngay')->nullable();  
            $table->datetime('den_ngay')->nullable();
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
        Schema::dropIfExists('tham_so_tinh_luong_theo_phu_caps');
    }
}
