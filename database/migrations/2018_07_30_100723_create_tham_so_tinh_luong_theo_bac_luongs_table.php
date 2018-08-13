<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThamSoTinhLuongTheoBacLuongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tham_so_tinh_luong_theo_bac_luongs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_chuc_vu');
            $table->foreign('id_chuc_vu')->references('id')->on('tham_so_tinh_luong_theo_chuc_vus');
            $table->string('ten')->nullable();
            $table->float('he_so_luong')->nullable();
            $table->decimal('muc_luong_co_ban',15,2)->nullable();
            $table->unsignedInteger('company_id')->nullable();
            //$table->foreign('company_id')->references('id')->on('companies');    
            $table->datetime('tu_ngay')->nullable();  
            $table->datetime('den_ngay')->nullable();
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
        Schema::dropIfExists('tham_so_tinh_luong_theo_bac_luongs');
    }
}
