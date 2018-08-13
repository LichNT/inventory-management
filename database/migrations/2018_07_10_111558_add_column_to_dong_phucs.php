<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToDongPhucs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chi_tiet_dong_phucs', function (Blueprint $table) {
            $table->integer('id_trang_thai_dong_phuc')->nullable();
            $table->date('ngay_cap_nhat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chi_tiet_dong_phucs', function (Blueprint $table) {
            $table->dropColumn('id_trang_thai_dong_phuc')->nullable();
            $table->dropColumn('ngay_cap_nhat')->nullable();
        });
    }
}
