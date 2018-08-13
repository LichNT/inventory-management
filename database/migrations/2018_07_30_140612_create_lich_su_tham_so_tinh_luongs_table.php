<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLichSuThamSoTinhLuongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lich_su_tham_so_tinh_luongs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma');
            $table->string('ten')->nullable();
            $table->decimal('gia_tri',15,2)->nullable();
            $table->unsignedInteger('company_id')->nullable();
            //$table->foreign('company_id')->references('id')->on('companies');
            $table->datetime('tu_ngay')->nullable();
            $table->boolean('inactive')->default(false);
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
        Schema::dropIfExists('lich_su_tham_so_tinh_luongs');
    }
}
