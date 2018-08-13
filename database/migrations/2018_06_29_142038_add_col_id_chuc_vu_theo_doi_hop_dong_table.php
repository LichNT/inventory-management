<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColIdChucVuTheoDoiHopDongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('theo_doi_hop_dongs', function (Blueprint $table) {
            $table->integer('id_chuc_vu')->nullable();
            $table->foreign('id_chuc_vu')->references('id')->on('chuc_vus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('theo_doi_hop_dongs', function (Blueprint $table) {
            $table->dropForeign(['id_chuc_vu']);
            $table->dropColumn('id_chuc_vu');   
        }); 
    }
}
