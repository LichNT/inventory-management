<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDongPhucNhanSuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhan_sus', function (Blueprint $table) {           
            $table->unsignedInteger('dong_phuc_so_luong')->default(0);
            $table->string('dong_phuc_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nhan_sus', function (Blueprint $table) {           
            $table->dropColumn(['dong_phuc_so_luong', 'dong_phuc_size']);
        });
    }
}
