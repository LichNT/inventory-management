<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColIdToChucPhongBanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phong_bans', function (Blueprint $table) {
            $table->integer('to_chuc_id')->nullable();   
            // $table->foreign('to_chuc_id')->references('id')->on('to_chucs');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('phong_bans', function (Blueprint $table) {
            $table->dropForeign(['to_chuc_id']);
            $table->dropColumn('to_chuc_id');   
        }); 
    }
}
