<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColChiTietCongTacTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chi_tiet_cong_tacs', function (Blueprint $table) {

            $table->integer('id_mien_cu')->nullable();
            $table->integer('id_mien_moi')->nullable();
            $table->integer('id_chi_nhanh_cu')->nullable();
            $table->integer('id_chi_nhanh_moi')->nullable();
            $table->integer('id_tinh_cu')->nullable();
            $table->integer('id_tinh_moi')->nullable();
            $table->integer('id_bo_phan_cu')->nullable();
            $table->integer('id_bo_phan_moi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('id_mien_cu');
        $table->dropColumn('id_mien_moi');
        $table->dropColumn('id_chi_nhanh_cu');
        $table->dropColumn('id_chi_nhanh_moi');
        $table->dropColumn('id_tinh_cu');
        $table->dropColumn('id_tinh_moi');
        $table->dropColumn('id_bo_phan_cu');
        $table->dropColumn('id_bo_phan_moi');

    }
}
