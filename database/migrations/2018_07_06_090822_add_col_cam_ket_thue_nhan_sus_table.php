<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColCamKetThueNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhan_sus', function (Blueprint $table) {
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
        Schema::table('nhan_sus', function (Blueprint $table) {
            $table->dropColumn('cam_ket_thue');
        });
    }
}
