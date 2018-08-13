<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietChuyenMonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nganhs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten');
            $table->string('mo_ta');
            $table->timestamps();
        });
        Schema::create('chi_tiet_chuyen_mons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nhan_su');
            $table->foreign('id_nhan_su')->references('id')->on('nhan_sus');
            $table->integer('id_bang_cap');
            $table->foreign('id_bang_cap')->references('id')->on('trinh_do_chuyen_mons');
            $table->integer('id_nganh_hoc');
            $table->foreign('id_nganh_hoc')->references('id')->on('nganhs');
            $table->integer('id_he_dao_tao');
            $table->foreign('id_he_dao_tao')->references('id')->on('he_dao_taos');
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
        Schema::dropIfExists('chi_tiet_chuyen_mons');
        Schema::dropIfExists('nganhs');

    }
}
