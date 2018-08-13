<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChamCongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cham_congs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten', 500);
            $table->string('ten_bang')->unique();
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('nguoi_tao_id');
            $table->foreign('nguoi_tao_id')->references('id')->on('users');
            $table->unsignedInteger('nguoi_sua_id')->nullable();
            $table->foreign('nguoi_sua_id')->references('id')->on('users');            
            $table->integer('thang')->nullable();        
            $table->integer('nam')->nullable();        
            $table->date('ngay_bat_dau')->nullable();        
            $table->date('ngay_ket_thuc')->nullable();            
            $table->boolean('khoa_so')->default(false);
            $table->boolean('inactive')->default(false);
            $table->date('ngay_khoa_so')->nullable();
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
        Schema::dropIfExists('cham_congs');
    }
}
