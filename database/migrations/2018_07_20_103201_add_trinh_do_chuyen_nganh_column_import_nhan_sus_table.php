<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrinhDoChuyenNganhColumnImportNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_nhan_sus', function (Blueprint $table) {
            $table->string('trinh_do')->nullable();
            $table->string('chuyen_nganh')->nullable();
            $table->string('nghi_thai_san')->nullable();
            $table->string('di_lam_sau_thai_san')->nullable();
            $table->string('thang_dong_bh')->nullable();
            $table->string('thang_chuyen_bh_ve_cn')->nullable();
            $table->string('thang_dung_dong_bao_hiem')->nullable();
            $table->string('ms_npt1')->nullable();
            $table->string('ms_npt2')->nullable();
            $table->string('ms_npt3')->nullable();
            $table->string('ms_npt4')->nullable();
            $table->integer('id_tinh')->nullable();
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
            $table->dropColumn('trinh_do');
            $table->dropColumn('chuyen_nganh');
            $table->dropColumn('nghi_thai_san');
            $table->dropColumn('di_lam_sau_thai_san');
            $table->dropColumn('thang_dong_bh');
            $table->dropColumn('thang_chuyen_bh_ve_cn');
            $table->dropColumn('thang_dung_dong_bao_hiem');
            $table->dropColumn('ms_npt1');
            $table->dropColumn('ms_npt2');
            $table->dropColumn('ms_npt3');
            $table->dropColumn('ms_npt4');
            $table->dropColumn('id_tinh');
        });
    }
}
