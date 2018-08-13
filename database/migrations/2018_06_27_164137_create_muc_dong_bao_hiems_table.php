<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMucDongBaoHiemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('muc_dong_bao_hiems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten');
            $table->decimal('so_tien',10,0);
            $table->timestamps();
        });

        Schema::table('chi_tiet_bao_hiems', function (Blueprint $table) {
            $table->integer('muc_dong_bao_hiem_id')->nullable();
            $table->foreign('muc_dong_bao_hiem_id')->references('id')->on('muc_dong_bao_hiems');
        });
        }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('muc_dong_bao_hiems');
        Schema::table('chi_tiet_bao_hiems', function (Blueprint $table) {
            $table->dropColumn('muc_dong_bao_hiem_id');
        });
    }
}
