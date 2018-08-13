<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietCongTacsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_cong_tacs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nhan_su');
            $table->foreign('id_nhan_su')->references('id')->on('nhan_sus');
            $table->date('ngay_quyet_dinh')->nullable();
            $table->date('ngay_hieu_luc')->nullable();
            $table->date('ngay_het_hieu_luc')->nullable();
            $table->string('so_quyet_dinh')->nullable();
            $table->integer('id_phong_ban_cu')->nullable();
            //$table->foreign('id_phong_ban_cu')->references('id')->on('phong_bans');
            $table->integer('id_phong_ban_moi')->nullable();
            //$table->foreign('id_phong_ban_moi')->references('id')->on('phong_bans');
            $table->integer('id_cua_hang_moi')->nullable();;
            $table->foreign('id_cua_hang_moi')->references('id')->on('cua_hangs');
            $table->integer('id_cua_hang_cu')->nullable();;
            $table->foreign('id_cua_hang_cu')->references('id')->on('cua_hangs');
            $table->integer('id_chuc_vu_moi')->nullable();;
            $table->foreign('id_chuc_vu_moi')->references('id')->on('chuc_vus');
            $table->integer('id_chuc_vu_cu')->nullable();
            $table->foreign('id_chuc_vu_cu')->references('id')->on('chuc_vus');
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
        Schema::dropIfExists('chi_tiet_cong_tacs');
    }
}
