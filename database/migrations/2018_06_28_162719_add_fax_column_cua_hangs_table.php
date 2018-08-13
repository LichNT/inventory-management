<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFaxColumnCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cua_hangs', function (Blueprint $table) {
            $table->string('fax')->nullable();
            $table->string('zip_code')->nullable();
            $table->renameColumn('so_nha','dia_chi');
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
            $table->dropColumn('fax');
            $table->dropColumn('zip_code');
            $table->renameColumn('dia_chi','so_nha');
        });
    }
}
