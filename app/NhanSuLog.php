<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\NhanSu;
use Carbon\Carbon;
use App\Scopes\CompanyScope;
class NhanSuLog extends Model
{
    protected $fillable=[
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
        'id_ton_giao',
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
        'so_yeu_li_lich',
        'ban_sao_cmnd',
        'ban_sao_ho_khau',
        'ban_sao_giay_khai_sinh',
        'ban_sao_bang_cap_chung_chi',
        'anh',
        'so_so_bhxh',
        'quyet_dinh_nghi_viec',
        'tai_khoan_ca_nhan',
        'company_id',
        'he_so_luong',
        'luong_co_ban',
        'he_so_phu_cap_chuc_vu',
        'he_so_phu_cap_doc_hai',
        'he_so_diem_phuc_tap_cong_viec',
        'he_so_phu_cap_tham_nien',
        'so_nguoi_phu_thuoc',
        'dong_phuc_so_luong',
        'id_dong_phuc_size',
        'trang_thai_nhan_su',
        'to_chuc_id',
        'id_bo_phan',
        'company_id',
        'id_mien',
        'id_chi_nhanh',
        'id_tinh',
        'chinh_thuc',
        'co_giay_ksk',
        'cam_ket_thue',
        'change_code',
        'change_content',
    ];

    protected $dates = [
        'ngay_sinh',
        'ngay_cap',
        'ngay_chinh_thuc',
        'ngay_hoc_viec',
        'ngay_thu_viec',
        'ngay_nghi_viec',
        'updated_at',
        'created_at'
    ];

     public function setNgaySinhAttribute($value) {
         if(!empty($value)){
             if($value instanceof Carbon){
                 $this->attributes['ngay_sinh'] = $value;
             }
             else if(is_numeric($value)) {
                 $this->attributes['ngay_sinh'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
             }
             else{
                 $this->attributes['ngay_sinh'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
             }
         }
     }

     public function setGioiTinhAttribute($value) {
        if(!empty($value)){
            if($value=="Nam"||$value==1)
            $this->attributes['gioi_tinh']=1;
        }
        else{
            $this->attributes['gioi_tinh']=0;
        }
    }

    public function setNgayThuViecAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_thu_viec'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_thu_viec'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_thu_viec'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }

    }

    public function setNgayHocViecAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_hoc_viec'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_hoc_viec'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_hoc_viec'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }
    }

    public function setNgayNghiViecAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_nghi_viec'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_nghi_viec'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_nghi_viec'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }

    }

    public function setNgayChinhThucAttribute($value) {
        if(!empty($value)){
            if($value instanceof Carbon){
                $this->attributes['ngay_chinh_thuc'] = $value;
            }
            else if(is_numeric($value)) {
                $this->attributes['ngay_chinh_thuc'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
            }
            else{
                $this->attributes['ngay_chinh_thuc'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
            }
        }

    }

     public function setNgayCapAttribute($value) {
         if(!empty($value)){
             if($value instanceof Carbon){
                 $this->attributes['ngay_cap'] = $value;
             }
             else if(is_numeric($value)) {
                 $this->attributes['ngay_cap'] = Carbon::createFromTimestamp(($value - 25569) * 86400)->startOfDay();
             }
             else{
                 $this->attributes['ngay_cap'] = Carbon::createFromFormat(config('app.format_date'),$value)->startOfDay();
             }
         }

     }

     public function getNgaySinhAttribute()
    {
        if(!empty($this->attributes['ngay_sinh'])){
            return  Carbon::parse($this->attributes['ngay_sinh'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function getNgayThuViecAttribute()
    {
        if(!empty($this->attributes['ngay_thu_viec'])){
            return  Carbon::parse($this->attributes['ngay_thu_viec'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function getNgayHocViecAttribute()
    {
        if(!empty($this->attributes['ngay_hoc_viec'])){
            return  Carbon::parse($this->attributes['ngay_hoc_viec'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function getNgayNghiViecAttribute()
    {
        if(!empty($this->attributes['ngay_nghi_viec'])){
            return  Carbon::parse($this->attributes['ngay_nghi_viec'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function getNgayChinhThucAttribute()
    {
        if(!empty($this->attributes['ngay_chinh_thuc'])){
            return  Carbon::parse($this->attributes['ngay_chinh_thuc'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function getNgayCapAttribute()
    {
        if(!empty($this->attributes['ngay_cap'])){
            return  Carbon::parse($this->attributes['ngay_cap'])->format(config('app.format_date'));
        }
        else{
            return null;
        }
        
    }

    public function getUpdatedAtAttribute()
    {
        if(!empty($this->attributes['updated_at'])){
            return  Carbon::parse($this->attributes['updated_at'])->format(config('app.format_datetime'));
        }
        else{
            return null;
        }
        
    }

    function loaiHopDong(){
        return $this->belongsTo('App\LoaiHopDong', 'id_loai_hop_dong', 'id')->withDefault();
    }

    function phongBan(){
        return $this->belongsTo('App\PhongBan', 'id_phong_ban', 'id')->withDefault();
    }

    function trinhDoVanHoa(){
        return $this->belongsTo('App\TrinhDoVanHoa', 'id_trinh_do_van_hoa', 'id')->withDefault();
    }

    function tonGiao(){
        return $this->belongsTo('App\TonGiao', 'id_ton_giao', 'id')->withDefault();
    }

    function nguoiTao(){
        return $this->belongsTo('App\User', 'nguoi_tao', 'id')->withDefault();
    }

    function nguoiCapNhat(){
        return $this->belongsTo('App\User', 'nguoi_cap_nhat', 'id')->withDefault();
    }

    function chucVu(){
        return $this->belongsTo('App\ChucVu', 'id_chuc_vu', 'id')->withDefault();
    }

    public function chiTietCongTacs() {
        return $this->hasMany('App\ChiTietCongTac', 'id_nhan_su');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }


}
