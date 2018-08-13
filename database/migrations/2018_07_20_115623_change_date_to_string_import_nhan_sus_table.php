<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDateToStringImportNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_nhan_sus', function (Blueprint $table) {           
            $table->string('ngay_sinh')->change();
            $table->string('ngay_cap')->change();
            $table->string('ngay_hoc_viec')->change();
            $table->string('ngay_thu_viec')->change();
            $table->string('ngay_chinh_thuc')->change();
            $table->string('ngay_nghi_viec')->change();
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
            $table->date('ngay_sinh')->change();
            $table->date('ngay_cap')->change();
            $table->date('ngay_hoc_viec')->change();
            $table->date('ngay_thu_viec')->change();
            $table->date('ngay_chinh_thuc')->change();
            $table->date('ngay_nghi_viec')->change();
        });
    }
}
