<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThamSoHeThongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tham_so_he_thongs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id');
            //$table->foreign('company_id')->references('id')->on('companies');
            $table->decimal('tong_quy_luong', 18, 0)->nullable();        
            $table->decimal('giam_tru_ban_than', 8, 1)->nullable();        
            $table->decimal('giam_tru_phu_thuoc', 8, 1)->nullable();        
            $table->decimal('BHXH_DN', 8, 1)->nullable();        
            $table->decimal('BHXH_NLD', 8, 1)->nullable();        
            $table->decimal('BHYT_DN', 8, 1)->nullable();        
            $table->decimal('BHYT_NLD', 8, 1)->nullable();        
            $table->decimal('BHTN_DN', 8, 1)->nullable();        
            $table->decimal('BHTN_NLD', 8, 1)->nullable();
            $table->text('ngay_nghi_le')->nullable();
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
        Schema::dropIfExists('tham_so_he_thongs');
    }
}
