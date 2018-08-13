<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveNotNullColumnImportCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_cua_hangs', function (Blueprint $table) {
            $table->string('ma')->nullable()->change();
            $table->string('ten')->nullable()->change();
            $table->string('ten_dia_diem')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('import_cua_hangs', function (Blueprint $table) {
            $table->string('ma')->nullable(false)->change();
            $table->string('ten')->nullable(false)->change();
            $table->string('ten_dia_diem')->nullable(false)->change();
        });
    }
}