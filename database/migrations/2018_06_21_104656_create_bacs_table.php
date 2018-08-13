<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBacsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bacs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ngach_id');
            $table->foreign('ngach_id')->references('id')->on('ngaches');
            $table->string('ten', 100);
            $table->float('he_so_luong');
            $table->text('mo_ta')->nullable();                     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bacs');
    }
}
