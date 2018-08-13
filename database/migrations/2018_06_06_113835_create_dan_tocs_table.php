<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDanTocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dan_tocs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma')->unique();
            $table->string('ten');
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
        Schema::dropIfExists('dan_tocs');
    }
}
