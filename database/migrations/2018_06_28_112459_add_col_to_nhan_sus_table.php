<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhan_sus', function (Blueprint $table) {
            $table->integer('id_mien')->nullable();
            $table->foreign('id_mien')->references('id')->on('to_chucs');
            $table->integer('id_chi_nhanh')->nullable();
            $table->foreign('id_chi_nhanh')->references('id')->on('to_chucs');
            $table->integer('id_tinh')->nullable();
            $table->foreign('id_tinh')->references('id')->on('to_chucs');

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
            $table->dropForeign(['id_mien']);
            $table->dropColumn('id_mien');   
            $table->dropForeign(['id_chi_nhanh']);
            $table->dropColumn('id_chi_nhanh');   
            $table->dropForeign(['id_tinh']);
            $table->dropColumn('id_tinh');   
        }); 
    }
}
