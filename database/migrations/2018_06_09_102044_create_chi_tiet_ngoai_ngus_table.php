<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietNgoaiNgusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_ngoai_ngus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nhan_su');
            $table->foreign('id_nhan_su')->references('id')->on('nhan_sus');
            $table->integer('id_trinh_do');
            $table->foreign('id_trinh_do')->references('id')->on('trinh_do_chuyen_mons');
            $table->string('van_bang',500)->nullable();
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
        Schema::dropIfExists('chi_tiet_ngoai_ngus');
    }
}
