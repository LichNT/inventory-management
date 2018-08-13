<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDangNhapChamCongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dang_nhap_cham_congs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('nhan_su_id');
            $table->foreign('nhan_su_id')->references('id')->on('nhan_sus');
            $table->string('token', 500)->unique();
            $table->datetime('time_expired');
            $table->string('device_id')->nullable();
            $table->boolean('is_blacklist');
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
        Schema::dropIfExists('dang_nhap_cham_congs');
    }
}
