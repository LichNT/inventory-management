<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietLuongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_luongs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('nhan_su_id');
            $table->foreign('nhan_su_id')->references('id')->on('nhan_sus');
            $table->datetime('ngay_huong_luong');
            $table->string('so_quyet_dinh', 100)->nullable();
            $table->datetime('ngay_ky')->nullable();
            $table->unsignedInteger('ngach_id')->nullable();
            $table->foreign('ngach_id')->references('id')->on('ngaches');
            $table->unsignedInteger('bac_id')->nullable();
            $table->foreign('bac_id')->references('id')->on('bacs');
            $table->float('he_so_luong')->nullable();
            $table->float('he_so_phu_cap_chuc_vu')->nullable();
            $table->float('he_so_phu_cap_doc_hai')->nullable();
            $table->text('dien_dai')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chi_tiet_luongs');
    }
}
