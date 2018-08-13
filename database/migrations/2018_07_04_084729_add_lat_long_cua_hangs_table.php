<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatLongCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cua_hangs', function (Blueprint $table) {
            $table->decimal('lat', 10, 6)->nullable();
            $table->decimal('long', 10, 6)->nullable();
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
            $table->dropColumn(['source_id', 'long']);
        });
    }
}
