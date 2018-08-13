<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDangKyUngDungChamCongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dang_ky_ung_dung_cham_congs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ho_ten',30);
            $table->date('ngay_sinh')->nullable();
            $table->string('cmnd',20)->nullable();
            $table->string('ma',20)->nullable();
            $table->string('so_dien_thoai',50)->nullable();            
            $table->string('email',50)->nullable();
            $table->unsignedInteger('company_id')->nullable();
            //$table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedInteger('id_mien')->nullable();
            $table->foreign('id_mien')->references('id')->on('to_chucs');            
            $table->unsignedInteger('id_chi_nhanh')->nullable();
            $table->foreign('id_chi_nhanh')->references('id')->on('to_chucs');
            $table->unsignedInteger('id_tinh')->nullable();
            $table->foreign('id_tinh')->references('id')->on('to_chucs');
            $table->unsignedInteger('id_cua_hang')->nullable();
            $table->foreign('id_cua_hang')->references('id')->on('cua_hangs');
            $table->boolean('inactive')->default(false);            
            $table->boolean('created')->default(false);            
            $table->string('ma_the_cham_cong', 50)->nullable();            
            $table->unsignedInteger('nguoi_sua_id')->nullable();
            $table->foreign('nguoi_sua_id')->references('id')->on('users');                   
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
        Schema::dropIfExists('dang_ky_ung_dung_cham_congs');
    }
}
