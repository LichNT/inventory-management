<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToChucsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('to_chucs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma', 100);
            $table->string('ten')->nullable();
            $table->string('so_dien_thoai', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('nguoi_lien_he', 100)->nullable();
            $table->text('mo_ta')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            //$table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('to_chucs');
            $table->unsignedInteger('loai_to_chuc_id');
            $table->foreign('loai_to_chuc_id')->references('id')->on('loai_to_chucs');
            $table->boolean('inactve')->default(false);   
            $table->timestamps();
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
        Schema::dropIfExists('to_chucs');
    }
}
