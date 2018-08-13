<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_cua_hang');
            $table->foreign('id_cua_hang')->references('id')->on('cua_hangs');
            $table->unsignedInteger('id_loai_target');
            $table->foreign('id_loai_target')->references('id')->on('loai_targets');
            $table->decimal('so_tien','15',0)->nullable();
            $table->date('tu_ngay')->nullable();
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
        Schema::dropIfExists('targets');
    }
}
