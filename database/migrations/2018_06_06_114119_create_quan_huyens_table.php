<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuanHuyensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quan_huyens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma')->unique();
            $table->string('ten');
            $table->unsignedInteger('tinh_thanh_id');
            $table->foreign('tinh_thanh_id')->references('id')->on('tinh_thanhs');
            $table->string('mo_ta')->nullable();
            $table->boolean('trang_thai')->default(true);      
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
        Schema::dropIfExists('quan_huyens');
    }
}
