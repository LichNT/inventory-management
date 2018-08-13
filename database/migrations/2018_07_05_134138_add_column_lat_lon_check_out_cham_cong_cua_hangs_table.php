<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLatLonCheckOutChamCongCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cham_cong_cua_hangs', function (Blueprint $table) {
            $table->decimal('lat_check_out', 10, 6)->nullable();
            $table->decimal('long_check_out', 10, 6)->nullable();
            $table->text('duong_dan_anh_check_out')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cua_hangs', function (Blueprint $table) {
            $table->dropColumn(['lat_check_out', 'long_check_out', 'duong_dan_anh_check_out']);
        });
    }
}
