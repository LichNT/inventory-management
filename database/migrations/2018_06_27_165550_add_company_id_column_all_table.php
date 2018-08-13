<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIdColumnAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('loai_cham_congs', function (Blueprint $table) {
        //     $table->integer('company_id')->nullable()->default('2');
        //     //$table->foreign('company_id')->references('id')->on('companies');
        // });

        // Schema::table('loai_nghi_dac_biets', function (Blueprint $table) {
        //     $table->integer('company_id')->nullable()->default('2');
        //     //$table->foreign('company_id')->references('id')->on('companies');
        // });

        // Schema::table('loai_phu_caps', function (Blueprint $table) {
        //     $table->integer('company_id')->nullable()->default('2');
        //     //$table->foreign('company_id')->references('id')->on('companies');
        // });

        // Schema::table('ngaches', function (Blueprint $table) {
        //     $table->integer('company_id')->nullable()->default('2');
        //     //$table->foreign('company_id')->references('id')->on('companies');
        // });

        // Schema::table('ngan_hangs', function (Blueprint $table) {
        //     $table->integer('company_id')->nullable()->default('2');
        //     //$table->foreign('company_id')->references('id')->on('companies');
        // });

        // Schema::table('nganhs', function (Blueprint $table) {
        //     $table->integer('company_id')->nullable()->default('2');
        //     //$table->foreign('company_id')->references('id')->on('companies');
        // });

        // Schema::table('thue_thu_nhaps', function (Blueprint $table) {
        //     $table->integer('company_id')->nullable()->default('2');
        //     //$table->foreign('company_id')->references('id')->on('companies');
        // });

        // Schema::table('trinh_do_chuyen_mons', function (Blueprint $table) {
        //     $table->integer('company_id')->nullable()->default('2');
        //     //$table->foreign('company_id')->references('id')->on('companies');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loai_cham_congs', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        Schema::table('loai_nghi_dac_biets', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        Schema::table('loai_phu_caps', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        Schema::table('ngaches', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        Schema::table('ngan_hangs', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        Schema::table('nganhs', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        Schema::table('thue_thu_nhaps', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        Schema::table('trinh_do_chuyen_mons', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
}
