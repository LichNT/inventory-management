<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColChucVus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chuc_vus', function (Blueprint $table) {
            $table->integer('so_ngay_nghi_trong_thang')->nullable();
            $table->integer('so_gio_quy_dinh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {     
        Schema::table('chuc_vus', function (Blueprint $table) {
            $table->dropColumn('so_ngay_nghi_trong_thang')->nullable();
            $table->dropColumn('so_gio_quy_dinh')->nullable();
        });
    }
}
