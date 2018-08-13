<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThueThuNhapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thue_thu_nhaps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten', 100);
            $table->decimal('can_duoi')->nullable();
            $table->decimal('can_tren')->nullable();
            $table->float('thue_suat')->nullable();
            $table->float('tru_bot')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thue_thu_nhaps');
    }
}
