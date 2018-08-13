<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeIdChiNhanhColumnImportCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_cua_hangs', function (Blueprint $table) {
            $table->renameColumn('id_chi_nhanh','ten_chi_nhanh');
        });
        Schema::table('import_cua_hangs', function (Blueprint $table) {
            $table->string('ten_chi_nhanh')->change();
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
            $table->renameColumn('ten_chi_nhanh','id_chi_nhanh');
        });
    }
}
