<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCompanyIdToDanhMucTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chuc_vus', function (Blueprint $table) {

            $table->integer('company_id')->nullable();
        });
        Schema::table('loai_hop_dongs', function (Blueprint $table) {

            $table->integer('company_id')->nullable();
        });
        Schema::table('phan_loai_nhan_viens', function (Blueprint $table) {

            $table->integer('company_id')->nullable();
        });
        Schema::table('loai_phong_bans', function (Blueprint $table) {

            $table->integer('company_id')->nullable();
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

            $table->dropColumn('company_id');
        });
        Schema::dropColumn('loai_hop_dongs', function (Blueprint $table) {

            $table->dropColumn('company_id');
        });
        Schema::table('phan_loai_nhan_viens', function (Blueprint $table) {

            $table->dropColumn('company_id');
        });
        Schema::table('loai_phong_bans', function (Blueprint $table) {

            $table->dropColumn('company_id');
        });
    }
}
