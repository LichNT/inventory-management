<?php

namespace App;

use App\Scopes\NghiViecScope;
use Carbon\Carbon;
use App\Events\NhanSuUpdated;
use App\Events\NhanSuDeleting;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;
use App\Scopes\ChiNhanhScope;
use Illuminate\Notifications\Notifiable;
use App\ChiTietGiamTruGiaCanh;

class NhanSu extends Model
{
    use Notifiable;
    protected $table='nhan_sus';

    protected $fillable = [
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
        'source_id',
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
        'trinh_do',
        'chuyen_nganh',
        'tong_so_tien_bao_lanh_da_nop',
        'tong_so_tien_bao_lanh_phai_dong',
        'tong_so_tien_bao_lanh_da_tra',
    ];

    protected $dates = [
        'ngay_sinh',
        'ngay_cap',
        'ngay_chinh_thuc',
        'ngay_hoc_viec',
        'ngay_thu_viec',
        'ngay_nghi_viec',
    ];


    public function setDongPhucSoLuongAttribute($value) {
        if(!empty($value)&&$value<0){
            $this->attributes['dong_phuc_so_luong']=0;
        }
        else{
            $this->attributes['dong_phuc_so_luong']=$value;
        }
    }

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
            if($value=="Nam"||$value==1||$value==true)
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
        else{
            $this->attributes['ngay_thu_viec']=null;
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
        else{
            $this->attributes['ngay_hoc_viec']=null;
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
        else{
            $this->attributes['ngay_nghi_viec']=null;
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
        else{
            $this->attributes['ngay_chinh_thuc']=null;
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

    public function getMaTenAttribute()
    {
        if(!empty($this->attributes['ma']) || !empty($this->attributes['ho_ten'])){
            return $this->attributes['ma'].'-'.$this->attributes['ho_ten'];
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

    function boPhan(){
        return $this->belongsTo('App\PhongBan', 'id_bo_phan', 'id')->withDefault();
    }

    function cuaHang(){
        return $this->belongsTo('App\CuaHang', 'id_cua_hang', 'id')->withDefault();
    }

    function toChuc(){
        return $this->belongsTo('App\ToChuc', 'to_chuc_id', 'id')->withDefault();
    }

    function trinhDoVanHoa(){
        return $this->belongsTo('App\TrinhDoVanHoa', 'id_trinh_do_van_hoa', 'id')->withDefault();
    }

    function tonGiao(){
        return $this->belongsTo('App\TonGiao', 'id_ton_giao', 'id')->withDefault();
    }

    function nguoiTao(){
        return $this->belongsTo('App\User', 'nguoi_tao', 'id');
    }

    function nguoiCapNhat(){
        return $this->belongsTo('App\User', 'nguoi_cap_nhat', 'id');
    }

    function chucVu(){
        return $this->belongsTo('App\ChucVu', 'id_chuc_vu', 'id')->withDefault();
    }

    function chiNhanh(){
        return $this->belongsTo('App\ToChuc', 'id_chi_nhanh', 'id')->withDefault();
    }

    function mien(){
        return $this->belongsTo('App\ToChuc', 'id_mien', 'id')->withDefault();
    }

    function tinh(){
        return $this->belongsTo('App\ToChuc', 'id_tinh', 'id')->withDefault();
    }

    public function chiTietCongTacs() {
        return $this->hasMany('App\ChiTietCongTac', 'id_nhan_su');
    }

    public function chiTietLuongs() {
        return $this->hasMany('App\ChiTietLuong', 'nhan_su_id');
    }

    public function chiTietGiamTruGiaCanhs() {
        return $this->hasMany('App\ChiTietGiamTruGiaCanh', 'id_nhan_su');
    }

    public function chiTietBaoHiems() {
        return $this->hasMany('App\ChiTietBaoHiem', 'id_nhan_su')->orderBy('ten');
    }

    public function chiTietBaoHiemHienTai() {
        return $this->hasOne('App\ChiTietBaoHiem', 'id_nhan_su')->orderBy('thang_bat_dau','desc');
    }


    public function size(){
        return $this->belongsTo('App\Lookup','id_dong_phuc_size','id')->withDefault();
    }

    public function heSoLuong(){
        return $this->belongsTo('App\Bac','id_bac_luong','id')->withDefault();
    }

    public function thamSoTinhLuong(){
        return $this->belongsTo('App\ThamSoTinhLuong','id_chuc_vu','id_chuc_vu')->where('id_loai_hop_dong',$this->attributes['id_loai_hop_dong'])->withDefault();
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
        static::addGlobalScope(new ChiNhanhScope);
    }

    public function getHinhAnhAttribute()
    {
        if(empty($this->attributes['hinh_anh'])){
            return config('app.url') . "/images/defaults/avatar.png";
        }

        return config('app.url') . "/" . $this->attributes['hinh_anh'];
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'gioi_tinh' => 'integer',
        'thu_viec' => 'integer',
        'da_nghi_viec' => 'integer',
        'so_yeu_li_lich' => 'integer',
        'ban_sao_cmnd' => 'integer',
        'ban_sao_ho_khau' => 'integer',
        'ban_sao_giay_khai_sinh' => 'integer',
        'ban_sao_bang_cap_chung_chi' => 'integer',
        'anh' => 'integer', 
        'so_so_bhxh' => 'integer', 
        'quyet_dinh_nghi_viec' => 'integer', 
        'tai_khoan_ca_nhan' => 'integer', 
        'hoc_viec' => 'integer',
        'chinh_thuc' => 'integer',
        'co_giay_ksk' => 'integer',
        'cam_ket_thue' => 'integer',
    ];
}
