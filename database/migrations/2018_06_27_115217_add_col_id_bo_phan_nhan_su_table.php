<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColIdBoPhanNhanSuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhan_sus', function (Blueprint $table) {
            $table->integer('id_bo_phan')->nullable();
            //$table->foreign('id_bo_phan')->references('id')->on('phong_bans');
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
            $table->dropForeign(['id_bo_phan']);
            $table->dropColumn('id_bo_phan');   
        }); 
    }
}
