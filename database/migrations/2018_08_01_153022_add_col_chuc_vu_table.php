<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColChucVuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chuc_vus', function (Blueprint $table) {
            $table->decimal('so_tien_bao_lanh',15,0)->nullable();
            $table->unsignedInteger('so_thang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chuc_vus', function (Blueprint $table) {
            $table->dropColumn('so_tien_bao_lanh');  
            $table->dropColumn('so_thang');  
        });
    }
}
