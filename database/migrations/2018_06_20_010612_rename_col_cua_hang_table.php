<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColCuaHangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cua_hangs', function (Blueprint $table) {
            $table->renameColumn('id_chi_nhanh', 'id_tinh');
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
            $table->renameColumn('id_tinh', 'id_chi_nhanh');
        });
    }
}
