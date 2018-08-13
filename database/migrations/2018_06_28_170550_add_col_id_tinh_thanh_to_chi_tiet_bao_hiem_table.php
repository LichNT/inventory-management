<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColIdTinhThanhToChiTietBaoHiemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chi_tiet_bao_hiems', function (Blueprint $table) {
            $table->integer('id_tinh_thanh')->nullable();
            $table->foreign('id_tinh_thanh')->references('id')->on('tinh_thanhs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chi_tiet_bao_hiems', function (Blueprint $table) {
            $table->dropForeign(['id_tinh_thanh']);
            $table->dropColumn('id_tinh_thanh');   
        }); 
    }
}
