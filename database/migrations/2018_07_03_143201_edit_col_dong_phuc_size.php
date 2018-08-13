<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColDongPhucSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhan_sus', function (Blueprint $table) {
            $table->dropColumn('dong_phuc_size');
        });
        Schema::table('nhan_sus', function (Blueprint $table) {
            $table->unsignedInteger('id_dong_phuc_size')->nullable();
            $table->foreign('id_dong_phuc_size')->references('id')->on('lookup');
        });
        Schema::table('chi_tiet_dong_phucs', function (Blueprint $table) {
            $table->dropColumn('size');
        });
        Schema::table('chi_tiet_dong_phucs', function (Blueprint $table) {
            $table->unsignedInteger('id_size')->nullable();
            $table->foreign('id_size')->references('id')->on('lookup');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nhan_sus', function (Blueprint $table) {
            $table->dropColumn('id_dong_phuc_size');
        });
        Schema::table('nhan_sus', function (Blueprint $table) {
            $table->string('dong_phuc_size')->nullable();
        });
        Schema::table('chi_tiet_dong_phucs', function (Blueprint $table) {
            $table->dropColumn('id_size');
        });
        Schema::table('chi_tiet_dong_phucs', function (Blueprint $table) {
            $table->string('size')->nullable();
        });
    }
}
