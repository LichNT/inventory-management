<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUniqueToPhanLoaiNhanViensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phan_loai_nhan_viens', function (Blueprint $table) {
            $table->dropUnique('phan_loai_nhan_viens_ma_unique');
            $table->unique(['ma', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phan_loai_nhan_viens', function (Blueprint $table) {
            $table->unique('ma');
            $table->dropUnique(['ma', 'company_id']);
        });
    }
}
