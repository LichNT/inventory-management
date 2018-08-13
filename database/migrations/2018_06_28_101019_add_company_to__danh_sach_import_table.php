<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyToDanhSachImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('danh_sach_file_imports', function (Blueprint $table) {
            $table->integer('company_id')->nullable()->default('2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('danh_sach_file_imports', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
}
