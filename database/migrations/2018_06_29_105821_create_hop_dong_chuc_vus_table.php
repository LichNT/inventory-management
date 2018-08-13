<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHopDongChucVusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hop_dong_chuc_vus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_loai_hop_dong')->nullable();
            $table->foreign('id_loai_hop_dong')->references('id')->on('loai_hop_dongs');
            $table->integer('id_chuc_vu')->nullable();
            $table->foreign('id_chuc_vu')->references('id')->on('chuc_vus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hop_dong_chuc_vus');
    }
}
