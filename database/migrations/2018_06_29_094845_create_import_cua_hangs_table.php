<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_cua_hangs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_id');
            $table->string('ma');
            $table->string('ten');
            $table->string('ten_dia_diem');
            $table->string('dia_chi')->nullable();
            $table->string('quoc_gia')->nullable();
            $table->string('fax')->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->string('zip_code')->nullable();
            $table->integer('id_chi_nhanh');
            $table->integer('company_id');
            $table->integer('nguoi_cap_nhat');
            $table->integer('nguoi_tao');
            $table->boolean('active')->nullable();
            $table->text('mo_ta')->nullable();
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
        Schema::dropIfExists('import_cua_hangs');
    }
}
