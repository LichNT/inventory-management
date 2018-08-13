<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeKhoangCachChamCongCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cham_cong_cua_hangs', function (Blueprint $table) {
            $table->decimal('lat_check_in',19,15)->change();
            $table->decimal('long_check_in',19,15)->change();
            $table->decimal('lat_check_out',19,15)->change();
            $table->decimal('long_check_out',19,15)->change();
            $table->decimal('cua_hang_lat',19,15)->change();
            $table->decimal('cua_hang_long',19,15)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cham_cong_cua_hangs', function (Blueprint $table) {
            $table->decimal('lat_check_in',10,6)->change();
            $table->decimal('long_check_in',10,6)->change();
            $table->decimal('lat_check_out',10,6)->change();
            $table->decimal('long_check_out',10,6)->change();
            $table->decimal('cua_hang_lat',10,6)->change();
            $table->decimal('cua_hang_long',10,6)->change();
        });
    }
}
