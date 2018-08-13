<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoaiPhatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loai_phats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten');
            $table->decimal('so_tien',10,0)->nullable();
            $table->string('mo_ta')->nullable();
            $table->boolean('inactive')->nullable(false);
            $table->integer('company_id')->nullable();
            //$table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loai_phats');
    }
}
