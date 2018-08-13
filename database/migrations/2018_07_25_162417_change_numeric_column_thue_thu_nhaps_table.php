<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNumericColumnThueThuNhapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thue_thu_nhaps', function (Blueprint $table) {
            $table->decimal('can_tren',12,0)->change();
            $table->decimal('can_duoi',12,0)->change();
            $table->decimal('thue_suat',6,2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thue_thu_nhaps', function (Blueprint $table) {
            $table->decimal('can_duoi')->change();
            $table->decimal('can_tren')->change();
            $table->float('thue_suat')->change();
        });
    }
}
