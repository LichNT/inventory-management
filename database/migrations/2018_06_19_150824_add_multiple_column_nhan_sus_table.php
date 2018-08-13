<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultipleColumnNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhan_sus', function (Blueprint $table) {                       
            $table->float('he_so_luong')->nullable();
            $table->decimal('luong_co_ban')->nullable();
            $table->float('he_so_phu_cap_chuc_vu')->nullable();
            $table->float('he_so_phu_cap_doc_hai')->nullable();
            $table->float('he_so_diem_phuc_tap_cong_viec')->nullable();
            $table->float('he_so_phu_cap_tham_nien')->nullable();
            $table->float('so_nguoi_phu_thuoc')->nullable();                        
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
            $table->dropColumn(['ngach_id', 'he_so_luong']);
        });
    }
}
