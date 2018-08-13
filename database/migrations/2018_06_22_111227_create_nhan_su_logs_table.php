<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNhanSuLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhan_su_logs', function (Blueprint $table) {
            $table->increments('id');
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
            $table->integer('id_ton_giao')->nullable();            
            $table->foreign('id_ton_giao')->references('id')->on('ton_giaos');   
            $table->string('ma_so_thue',100)->nullable();
            $table->string('tai_khoan_ngan_hang',100)->nullable();
            $table->string('hinh_anh', 1000)->nullable();
            $table->string('ma_the_cham_cong',50)->nullable();
            $table->string('gia_canh')->nullable();
            $table->integer('so_con')->nullable();
            $table->integer('id_loai_hop_dong')->nullable();
            $table->foreign('id_loai_hop_dong')->references('id')->on('loai_hop_dongs');
            $table->string('link_file_pdf_hop_dong')->nullable();
            $table->integer('id_phong_ban')->nullable();
            //$table->foreign('id_phong_ban')->references('id')->on('phong_bans');
            $table->integer('to_chuc_id')->nullable();
            $table->foreign('to_chuc_id')->references('id')->on('to_chucs');
            $table->integer('id_cua_hang')->nullable();
            $table->foreign('id_cua_hang')->references('id')->on('cua_hangs');
            $table->string('luu_tru_ho_so_goc',500)->nullable();
            $table->boolean('thu_viec')->default(false);
            $table->boolean('da_nghi_viec')->default(false);
            $table->date('ngay_chinh_thuc')->nullable();
            $table->date('ngay_hoc_viec')->nullable();
            $table->date('ngay_thu_viec')->nullable();
            $table->date('ngay_nghi_viec')->nullable();
            $table->integer('id_trinh_do_van_hoa')->nullable();
            $table->foreign('id_trinh_do_van_hoa')->references('id')->on('trinh_do_van_hoas');
            $table->integer('id_chuc_vu')->nullable();
            $table->foreign('id_chuc_vu')->references('id')->on('chuc_vus');
            $table->year('nam_bat_dau_tinh_phep')->nullable();
            $table->string('so_the_bao_hiem',100)->nullable();
            $table->string('so_so_bao_hiem',100)->nullable();
            $table->integer('nguoi_cap_nhat')->nullable();
            $table->integer('nguoi_tao');
            $table->foreign('nguoi_tao')->references('id')->on('users');
            $table->foreign('nguoi_cap_nhat')->references('id')->on('users');
            $table->boolean('so_yeu_li_lich')->default(false);
            $table->boolean('ban_sao_cmnd')->default(false);
            $table->boolean('ban_sao_ho_khau')->default(false);
            $table->boolean('ban_sao_giay_khai_sinh')->default(false);
            $table->boolean('ban_sao_bang_cap_chung_chi')->default(false);
            $table->boolean('anh')->default(false);
            $table->boolean('so_so_bhxh')->default(false);
            $table->boolean('quyet_dinh_nghi_viec')->default(false);
            $table->boolean('tai_khoan_ca_nhan')->default(false);   
            $table->integer('company_id')->nullable(); 
            $table->float('he_so_luong')->nullable();
            $table->decimal('luong_co_ban')->nullable();
            $table->float('he_so_phu_cap_chuc_vu')->nullable();
            $table->float('he_so_phu_cap_doc_hai')->nullable();
            $table->float('he_so_diem_phuc_tap_cong_viec')->nullable();
            $table->float('he_so_phu_cap_tham_nien')->nullable();
            $table->float('so_nguoi_phu_thuoc')->nullable(); 
            $table->unsignedInteger('dong_phuc_so_luong')->default(0);
            $table->string('dong_phuc_size')->nullable();
            $table->string('change_code', 1);
            $table->text('change_content')->nullable();
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
        Schema::dropIfExists('nhan_su_logs');
    }
}
