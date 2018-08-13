<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoaiToChucsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loai_to_chucs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma');
            $table->string('ten');
            $table->text('mo_ta')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            //$table->foreign('company_id')->references('id')->on('companies');            
            $table->boolean('inactve')->default(false);  
            $table->unique(['ma', 'company_id']);                      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */    
    public function down()
    {
        Schema::dropIfExists('loai_to_chucs');
    }
}
