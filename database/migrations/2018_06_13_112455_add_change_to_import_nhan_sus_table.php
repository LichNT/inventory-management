<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChangeToImportNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_nhan_sus', function (Blueprint $table) {
            $table->string('quan_ho_khau_thuong_tru',500)->nullable()->change();
            $table->string('tinh_ho_khau_thuong_tru',500)->nullable()->change();
            $table->string('quan_cho_o_hien_tai',500)->nullable()->change();
            $table->string('tinh_cho_o_hien_tai',500)->nullable()->change();
            $table->string('quoc_tich',500)->nullable()->change();
            
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('import_nhan_sus', function (Blueprint $table) {
            //
        });
    }
}
