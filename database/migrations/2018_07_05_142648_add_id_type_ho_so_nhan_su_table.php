<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdTypeHoSoNhanSuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ho_so_nhan_sus', function (Blueprint $table) {
            $table->unsignedInteger('id_type')->nullable();
        });
        Schema::table('ho_so_nhan_sus', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ho_so_nhan_sus', function (Blueprint $table) {
            $table->dropColumn('id_type');
        });
        Schema::table('ho_so_nhan_sus', function (Blueprint $table) {
            $table->string('type');
        });
    }
}
