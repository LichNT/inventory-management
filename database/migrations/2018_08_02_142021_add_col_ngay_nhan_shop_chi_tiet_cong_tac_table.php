<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColNgayNhanShopChiTietCongTacTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chi_tiet_cong_tacs', function (Blueprint $table) {
            $table->datetime('ngay_nhan_shop')->nullable();
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chi_tiet_cong_tacs', function (Blueprint $table) {
            $table->dropColumn('ngay_nhan_shop');  
        });
    }
}
