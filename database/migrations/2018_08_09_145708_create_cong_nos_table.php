<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCongNosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cong_nos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_nhan_su');
            $table->foreign('id_nhan_su')->references('id')->on('nhan_sus');
            $table->date('thang_nam');
            $table->decimal('so_tien',15,0);
            $table->string('noi_dung');
            $table->boolean('inactive')->default(false);
            $table->integer('company_id');
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
        Schema::dropIfExists('cong_nos');
    }
}
