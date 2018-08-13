<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietPhatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_phats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma_nhan_su');
            $table->unsignedInteger('id_loai_phat');
            $table->foreign('id_loai_phat')->references('id')->on('loai_phats');
            $table->decimal('so_tien');
            $table->date('ngay');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chi_tiet_phats');
    }
}
