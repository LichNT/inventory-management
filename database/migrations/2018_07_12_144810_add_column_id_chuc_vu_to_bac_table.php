<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIdChucVuToBacTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bacs', function (Blueprint $table) {
            $table->unsignedInteger('id_chuc_vu')->nullable();
            $table->renameColumn('so_tien', 'muc_luong_co_ban');
            $table->foreign('id_chuc_vu')->references('id')->on('chuc_vus');
            $table->dropColumn('ngach_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bacs', function (Blueprint $table) {
            $table->dropColumn('id_chuc_vu')->nullable();
            $table->renameColumn('muc_luong_co_ban','so_tien');
            $table->foreign('id_chuc_vu')->references('id')->on('chuc_vus');
            $table->integer('ngach_id')->nullable();
        });
    }
}
