<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBangMaNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bang_ma_nhan_sus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma');
            $table->unsignedInteger('company_id')->nullable();
            //$table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedInteger('index')->nullable();
            $table->boolean('inactive')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bang_ma_nhan_sus');
    }
}
