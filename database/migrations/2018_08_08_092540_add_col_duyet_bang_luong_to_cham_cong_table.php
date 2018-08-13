<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColDuyetBangLuongToChamCongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cham_congs', function (Blueprint $table) {
            $table->boolean('duyet_bang_luong')->default(false);
            $table->datetime('ngay_duyet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cham_congs', function (Blueprint $table) {
            $table->dropColumn('duyet_bang_luong');
            $table->dropColumn('ngay_duyet');
        });
    }
}
