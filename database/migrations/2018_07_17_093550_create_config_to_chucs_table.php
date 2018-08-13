<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigToChucsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_to_chucs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten_hien_thi')->nullable();
            $table->unsignedInteger('id_loai_to_chuc')->nullable();
            $table->foreign('id_loai_to_chuc')->references('id')->on('loai_to_chucs');
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
        Schema::dropIfExists('config_to_chucs');
    }
}
