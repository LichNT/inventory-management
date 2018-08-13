<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThamSoTinhLuongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tham_so_tinh_luongs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_chuc_vu')->nullable();
            $table->foreign('id_chuc_vu')->references('id')->on('chuc_vus');
            $table->unsignedInteger('id_loai_hop_dong')->nullable();
            $table->foreign('id_loai_hop_dong')->references('id')->on('loai_hop_dongs');
            $table->decimal('so_tien',10,0)->nullable();
            $table->datetime('ngay_hieu_luc')->nullable();
            $table->datetime('ngay_het_hieu_luc')->nullable();
            $table->boolean('loai')->default(true);
            $table->float('he_so')->nullable();
            $table->boolean('inactive')->default(false);
            $table->unsignedInteger('company_id')->nullable();
            //$table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tham_so_tinh_luongs');
    }
}
