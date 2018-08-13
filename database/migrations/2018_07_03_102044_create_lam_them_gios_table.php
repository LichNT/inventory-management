<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLamThemGiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loai_lam_them_gios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten');
            $table->float('he_so')->nullable();
            $table->decimal('muc_luong',18,0)->nullable();
            $table->float('so_gio_theo_quy_dinh')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loai_lam_them_gios');
    }
}
