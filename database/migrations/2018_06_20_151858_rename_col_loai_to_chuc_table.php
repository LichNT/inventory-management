<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColLoaiToChucTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loai_to_chucs', function (Blueprint $table) {
            $table->renameColumn('inactve', 'inactive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loai_to_chucs', function (Blueprint $table) {
            $table->renameColumn('inactive','inactve');
        });
    }
}
