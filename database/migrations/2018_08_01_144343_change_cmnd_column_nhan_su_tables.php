<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCmndColumnNhanSuTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhan_sus', function (Blueprint $table) {
            $table->string('cmnd',40)->change();
        });

        Schema::table('import_nhan_sus', function (Blueprint $table) {
            $table->string('cmnd',40)->change();
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
            $table->string('cmnd',20)->change();
        });

        Schema::table('import_nhan_sus', function (Blueprint $table) {
            $table->string('cmnd',20)->change();
        });
    }
}
