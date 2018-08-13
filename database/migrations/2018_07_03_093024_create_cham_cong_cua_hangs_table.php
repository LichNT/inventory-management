<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChamCongCuaHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cham_cong_cua_hangs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma')->unique();
            $table->unsignedInteger('nguoi_tao_id')->nullable();
            $table->foreign('nguoi_tao_id')->references('id')->on('users');
            $table->unsignedInteger('nguoi_sua_id')->nullable();
            $table->foreign('nguoi_sua_id')->references('id')->on('users');
            $table->integer('thang')->nullable();        
            $table->integer('nam')->nullable();            
            $table->unsignedInteger('nhan_su_id');
            $table->foreign('nhan_su_id')->references('id')->on('nhan_sus');
            $table->unsignedInteger('cua_hang_id')->nullable();
            $table->foreign('cua_hang_id')->references('id')->on('cua_hangs');
            $table->string('ma_the_cham_cong', 50)->nullable();
            $table->float('so_gio_lam')->nullable();
            $table->float('do_hieu_qua')->default(100);
            $table->decimal('don_gia_gio_lam', 8, 0)->nullable();            
            $table->decimal('lat_check_in', 10, 6);
            $table->decimal('long_check_in', 10, 6);
            $table->decimal('cua_hang_lat', 10, 6)->nullable();
            $table->decimal('cua_hang_long', 10, 6)->nullable();
            $table->text('dia_chi')->nullable();
            $table->text('huyen')->nullable();
            $table->text('tinh')->nullable();            
            $table->string('cmnd', 20)->nullable();
            $table->decimal('khoang_cach_check_in')->nullable();       
            $table->decimal('khoang_cach_check_out')->nullable();       
            $table->boolean('hop_le')->default(true);                   
            $table->string('device_id', 100)->nullable();                   
            $table->text('duong_dan_anh_check_in')->nullable();
            $table->datetime('thoi_gian_check_in')->nullable();
            $table->datetime('thoi_gian_check_out')->nullable();            
            $table->boolean('checked_out')->default(false);                                    
            $table->boolean('dang_xu_ly')->default(false);            
            $table->boolean('huy')->default(false);
            $table->datetime('het_han_check_out');  
            $table->boolean('khoa_so')->default(false);
            $table->date('ngay_khoa_so')->nullable();          
            $table->text('ghi_chu')->nullable();                                                                       
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
        Schema::dropIfExists('cham_cong_cua_hangs');
    }
}
