<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHocViecChinhThucColumnImportNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_nhan_sus', function (Blueprint $table) {
            $table->boolean('hoc_viec')->default(false);
            $table->boolean('chinh_thuc')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('import_nhan_sus', function (Blueprint $table) {
            $table->dropColumn('hoc_viec');
            $table->dropColumn('chinh_thuc');
        });
    }
}
