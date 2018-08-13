<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhan_sus', function (Blueprint $table) {
            $table->unique(['ma','company_id']);
            $table->unique(['cmnd','company_id']);
            $table->unique(['ma_so_thue','company_id']);
            $table->unique(['tai_khoan_ngan_hang','company_id']);
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
            $table->dropUnique(['ma','company_id']);
            $table->dropUnique(['cmnd','company_id']);
            $table->dropUnique(['ma_so_thue','company_id']);
            $table->dropUnique(['tai_khoan_ngan_hang','company_id']);
        });
    }
}
