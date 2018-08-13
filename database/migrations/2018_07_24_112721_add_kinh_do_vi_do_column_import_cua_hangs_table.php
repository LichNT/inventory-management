<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKinhDoViDoColumnImportCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_cua_hangs', function (Blueprint $table) {
            $table->decimal('kinh_do',19,15)->nullable();
            $table->decimal('vi_do',19,15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('import_cua_hangs', function (Blueprint $table) {
            $table->dropColumn('kinh_do');
            $table->dropColumn('vi_do');
        });
    }
}
