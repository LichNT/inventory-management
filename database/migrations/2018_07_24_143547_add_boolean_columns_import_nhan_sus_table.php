<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBooleanColumnsImportNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_nhan_sus', function (Blueprint $table) {
            $table->boolean('so_yeu_li_lich')->default(false);
            $table->boolean('ban_sao_cmnd')->default(false);
            $table->boolean('ban_sao_ho_khau')->default(false);
            $table->boolean('ban_sao_giay_khai_sinh')->default(false);
            $table->boolean('ban_sao_bang_cap_chung_chi')->default(false);
            $table->boolean('anh')->default(false);
            $table->boolean('so_so_bhxh')->default(false);
            $table->boolean('quyet_dinh_nghi_viec')->default(false);
            $table->boolean('tai_khoan_ca_nhan')->default(false);
            $table->boolean('giay_ksk')->default(false);
            $table->boolean('cam_ket_thue')->default(false);
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
            $table->dropColumn('so_yeu_li_lich');
            $table->dropColumn('ban_sao_cmnd');
            $table->dropColumn('ban_sao_ho_khau');
            $table->dropColumn('ban_sao_giay_khai_sinh');
            $table->dropColumn('ban_sao_bang_cap_chung_chi');
            $table->dropColumn('anh');
            $table->dropColumn('so_so_bhxh');
            $table->dropColumn('quyet_dinh_nghi_viec');
            $table->dropColumn('tai_khoan_ca_nhan');
            $table->dropColumn('giay_ksk');
            $table->dropColumn('cam_ket_thue');
        });
    }
}
