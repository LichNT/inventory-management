<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLichSuThanhToansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lich_su_thanh_toans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nhan_su');
            $table->foreign('id_nhan_su')->references('id')->on('nhan_sus');
            $table->decimal('so_tien',15,0)->nullable();
            $table->date('ngay_giao_dich')->nullable();
            $table->string('noi_dung')->nullable();
            $table->integer('company_id')->nullable();
            //$table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
        });
        Schema::table('nhan_sus', function (Blueprint $table) {
            $table->decimal('so_du',15,0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lich_su_thanh_toans');
        Schema::table('nhan_sus', function (Blueprint $table) {
            $table->dropColumn('so_du',15,0);
        });
    }
}
