<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhan_sus', function (Blueprint $table) {
            $table->decimal('tong_so_tien_bao_lanh_da_nop',15,0)->nullable();
            $table->decimal('tong_so_tien_bao_lanh_phai_dong',15,0)->nullable();
            $table->decimal('tong_so_tien_bao_lanh_da_tra',15,0)->nullable();
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
            $table->dropColumn('tong_so_tien_bao_lanh_da_nop');  
            $table->dropColumn('tong_so_tien_bao_lanh_phai_dong');  
            $table->dropColumn('tong_so_tien_bao_lanh_da_tra');
        });
    }
}
