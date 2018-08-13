<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColLanTraLuongLichSuGiaoDichTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lich_su_thanh_toans', function (Blueprint $table) {
            $table->integer('lan_tra_luong')->nullable();      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lich_su_thanh_toans', function (Blueprint $table) {
            $table->dropColumn('lan_tra_luong');
        });
    }
}
