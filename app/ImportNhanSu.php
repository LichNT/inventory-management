<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class ImportNhanSu extends Model
{
    protected $table='import_nhan_sus';
    
    protected $fillable = [
        'file_id',
        'ma',
        'ho_ten',
        'ngay_sinh',
        'cmnd',
        'ngay_cap',
        'noi_cap',
        'ho_khau_thuong_tru',
        'quan_ho_khau_thuong_tru',
        'tinh_ho_khau_thuong_tru',
        'cho_o_hien_tai',
        'quan_cho_o_hien_tai',
        'tinh_cho_o_hien_tai',
        'so_dien_thoai',
        'email',
        'gioi_tinh',
        'noi_sinh',
        'que_quan',
        'dan_toc',
        'quoc_tich',
        'ton_giao',
        'ma_so_thue',
        'tai_khoan_ngan_hang',
        'hinh_anh',
        'ma_the_cham_cong',
        'gia_canh',
        'so_con',
        'id_loai_hop_dong',
        'link_file_pdf_hop_dong',
        'id_phong_ban',
        'id_cua_hang',
        'luu_tru_ho_so_goc',
        'thu_viec',
        'da_nghi_viec',
        'ngay_chinh_thuc',
        'ngay_hoc_viec',
        'ngay_thu_viec',
        'ngay_nghi_viec',
        'id_trinh_do_van_hoa',
        'nam_bat_dau_tinh_phep',
        'so_the_bao_hiem',
        'so_so_bao_hiem',
        'nguoi_cap_nhat',
        'nguoi_tao',
        'active',
        'mo_ta',
        'company_id',
        'trinh_do',
        'chuyen_nganh',
        'nghi_thai_san',
        'di_lam_sau_thai_san',
        'thang_dong_bh',
        'thang_chuyen_bh_ve_cn',
        'thang_dung_dong_bao_hiem',
        'ms_npt1',
        'ms_npt2',
        'ms_npt3',
        'ms_npt4',
        'id_tinh',
        'hoc_viec',
        'thu_viec',
        'so_yeu_li_lich',
        'ban_sao_cmnd',
        'ban_sao_ho_khau',
        'ban_sao_giay_khai_sinh',
        'ban_sao_bang_cap_chung_chi',
        'anh',
        'so_so_bhxh',
        'quyet_dinh_nghi_viec',
        'tai_khoan_ca_nhan',
        'giay_ksk',
        'cam_ket_thue',
    ];


    public function setGioiTinhAttribute($value) {
        if(!empty($value)){
            if($value=="Nam"||$value==1||$value==true||$value="1")
                $this->attributes['gioi_tinh']=true;
        }
        else{
            $this->attributes['gioi_tinh']=false;
        }
    }

    public function setSoYeuLiLichAttribute($value) {
        if($value){
            return $this->attributes['so_yeu_li_lich'] = true;
        }
        else{
            return $this->attributes['so_yeu_li_lich'] = false;
        }
    }
    public function setBanSaoCMNDAttribute($value) {
        if($value){
            return $this->attributes['ban_sao_cmnd'] = true;
        }
        else{
            return $this->attributes['ban_sao_cmnd'] = false;
        }
    }
    public function setBanSaoHoKhauAttribute($value) {
        if($value){
            return $this->attributes['ban_sao_ho_khau'] = true;
        }
        else{
            return $this->attributes['ban_sao_ho_khau'] = false;
        }
    }
    public function setBanSaoGiayKhaiSinhAttribute($value) {
        if($value){
            return $this->attributes['ban_sao_giay_khai_sinh'] = true;
        }
        else{
            return $this->attributes['ban_sao_giay_khai_sinh'] = false;
        }
    }
    public function setBanSaoBangCapChungChiAttribute($value) {
        if($value){
            return $this->attributes['ban_sao_bang_cap_chung_chi'] = true;
        }
        else{
            return $this->attributes['ban_sao_bang_cap_chung_chi'] = false;
        }
    }
    public function setAnhAttribute($value) {
        if($value){
            return $this->attributes['anh'] = true;
        }
        else{
            return $this->attributes['anh'] = false;
        }
    }
    public function setSoSoBHXHAttribute($value) {
        if($value){
            return $this->attributes['so_so_bhxh'] = true;
        }
        else{
            return $this->attributes['so_so_bhxh'] = false;
        }
    }
    public function setQuyetDinhNghiViecAttribute($value) {
        if($value){
            return $this->attributes['quyet_dinh_nghi_viec'] = true;
        }
        else{
            return $this->attributes['quyet_dinh_nghi_viec'] = false;
        }
    }
    public function setTaiKhoanCaNhanAttribute($value) {
        if($value){
            return $this->attributes['tai_khoan_ca_nhan'] = true;
        }
        else{
            return $this->attributes['tai_khoan_ca_nhan'] = false;
        }
    }
    public function setGiayKSKAttribute($value) {
        if($value){
            return $this->attributes['giay_ksk'] = true;
        }
        else{
            return $this->attributes['giay_ksk'] = false;
        }
    }
    public function setCamKetThueAttribute($value) {
        if($value){
            return $this->attributes['cam_ket_thue'] = true;
        }
        else{
            return $this->attributes['cam_ket_thue'] = false;
        }
    }

    public function getGioiTinhAttribute()
    {
        if(!empty($this->attributes['gioi_tinh'])){
            if($this->attributes['gioi_tinh']=true)
                return  1;
            else
                return 0;
        }
        else{
            return null;
        }
    }

    function tinh(){
        return $this->belongsTo('App\ToChuc', 'id_tinh', 'id')->withDefault();
    }
    
}
