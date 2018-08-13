<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColMaSoThueGiamTruGiaCanhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chi_tiet_giam_tru_gia_canhs', function (Blueprint $table) {
            $table->string('ma_so_thue')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chi_tiet_giam_tru_gia_canhs', function (Blueprint $table) {
            $table->dropColumn('ma_so_thue'); 
        });
    }
}
