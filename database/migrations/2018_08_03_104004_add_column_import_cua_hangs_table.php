<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnImportCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_cua_hangs', function (Blueprint $table) {
            $table->string('ngay_dang_ki_kinh_doanh')->nullable();
            $table->string('ngay_ban_hang')->nullable();
            $table->string('ngay_khai_truong')->nullable();
            $table->string('nguoi_dai_dien')->nullable();
            $table->string('nguoi_lien_he')->nullable();
            $table->string('id_tinh')->nullable();
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
            $table->dropColumn('ngay_dang_ki_kinh_doanh');
            $table->dropColumn('ngay_ban_hang');
            $table->dropColumn('ngay_khai_truong');
            $table->dropColumn('nguoi_dai_dien');
            $table->dropColumn('nguoi_lien_he');
            $table->dropColumn('id_tinh');
        });
    }
}
