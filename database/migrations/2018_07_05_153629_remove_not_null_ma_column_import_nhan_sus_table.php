<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveNotNullMaColumnImportNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_nhan_sus', function (Blueprint $table) {
            $table->string('ma')->nullable()->change();
            $table->string('ho_ten')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('import_nhan_sus', function (Blueprint $table) {
            $table->string('ma')->nullable(false)->change();
            $table->string('ho_ten')->nullable(false)->change();
        });
    }
}
