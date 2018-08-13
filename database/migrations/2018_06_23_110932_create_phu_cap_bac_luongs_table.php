<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhuCapBacLuongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phu_cap_bac_luongs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bac_id');
            $table->foreign('bac_id')->references('id')->on('bacs');
            $table->unsignedInteger('id_loai_phu_cap');
            $table->foreign('id_loai_phu_cap')->references('id')->on('loai_phu_caps');
            $table->decimal('so_tien',10,0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phu_cap_bac_luongs');
    }
}
