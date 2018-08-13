<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThamSoTinhLuongTheoChucVusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tham_so_tinh_luong_theo_chuc_vus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma');
            $table->string('ten')->nullable();
            $table->integer('so_ngay_nghi_trong_thang')->nullable();  
            $table->decimal('so_tien_hoc_viec_theo_ngay',12,0)->nullable();
            $table->integer('so_gio_quy_dinh')->nullable();
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
        Schema::dropIfExists('tham_so_tinh_luong_theo_chuc_vus');
    }
}
