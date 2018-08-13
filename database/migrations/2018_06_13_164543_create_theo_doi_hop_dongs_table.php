<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTheoDoiHopDongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theo_doi_hop_dongs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nhan_su');
            $table->foreign('id_nhan_su')->references('id')->on('nhan_sus');
            $table->integer('loai_hop_dong')->nullable();
            $table->foreign('loai_hop_dong')->references('id')->on('loai_hop_dongs');
            $table->date('ngay_quyet_dinh')->nullable();
            $table->date('ngay_hieu_luc')->nullable();
            $table->date('ngay_het_hieu_luc')->nullable();
            $table->string('so_quyet_dinh')->nullable();
            $table->boolean('trang_thai')->nullable();
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
        Schema::dropIfExists('theo_doi_hop_dongs');
    }
}
