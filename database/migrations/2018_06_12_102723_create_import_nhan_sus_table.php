<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_nhan_sus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_id');
            $table->string('ma',10);
            $table->string('ho_ten',30);
            $table->date('ngay_sinh')->nullable();
            $table->string('cmnd',20)->nullable();
            $table->date('ngay_cap')->nullable();
            $table->string('noi_cap',500)->nullable();
            $table->string('ho_khau_thuong_tru',500)->nullable();
            $table->integer('quan_ho_khau_thuong_tru')->nullable();
            $table->integer('tinh_ho_khau_thuong_tru')->nullable();
            $table->string('cho_o_hien_tai',500)->nullable();
            $table->integer('quan_cho_o_hien_tai')->nullable();
            $table->integer('tinh_cho_o_hien_tai')->nullable();
            $table->string('so_dien_thoai',50)->nullable();
            $table->string('email',50)->nullable();
            $table->boolean('gioi_tinh')->default(true);
            $table->string('noi_sinh',500)->nullable();
            $table->string('que_quan',500)->nullable();
            $table->string('dan_toc',50)->nullable();
            $table->integer('quoc_tich')->nullable();
            $table->string('ton_giao',50)->nullable();
            $table->string('ma_so_thue',100)->nullable();
            $table->string('tai_khoan_ngan_hang',100)->nullable();
            $table->string('hinh_anh')->nullable();
            $table->string('ma_the_cham_cong',50)->nullable();
            $table->string('gia_canh')->nullable();
            $table->integer('so_con')->nullable();
            $table->integer('id_loai_hop_dong')->nullable();
            $table->string('link_file_pdf_hop_dong')->nullable();
            $table->integer('id_phong_ban')->nullable();
            $table->integer('id_cua_hang')->nullable();
            $table->string('luu_tru_ho_so_goc',500)->nullable();
            $table->boolean('thu_viec')->default(false);
            $table->boolean('da_nghi_viec')->default(false);
            $table->date('ngay_chinh_thuc')->nullable();
            $table->date('ngay_hoc_viec')->nullable();
            $table->date('ngay_thu_viec')->nullable();
            $table->date('ngay_nghi_viec')->nullable();
            $table->integer('id_trinh_do_van_hoa')->nullable();
            $table->year('nam_bat_dau_tinh_phep')->nullable();
            $table->string('so_the_bao_hiem',100)->nullable();
            $table->string('so_so_bao_hiem',100)->nullable();
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
        Schema::dropIfExists('import_nhan_sus');
    }
}
