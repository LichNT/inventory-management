<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeColumnDanhSachFileImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('danh_sach_file_imports', function (Blueprint $table) {
            $table->string('type')->nullable()->default('nhan_su');
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
            $table->dropColumn('type');
        });
    }
}
