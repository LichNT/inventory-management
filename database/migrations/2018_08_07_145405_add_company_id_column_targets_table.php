<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIdColumnTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('targets', function (Blueprint $table) {
            $table->integer('company_id')->nullable();
        });

        Schema::table('loai_targets', function (Blueprint $table) {
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
        Schema::table('targets', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });

        Schema::table('loai_targets', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
}
