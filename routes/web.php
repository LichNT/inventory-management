<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('profile', 'ProfileController@show')->name('profile');
Route::post('profile', 'ProfileController@update')->name('profile.update');
Route::post('changepassword/{id}', 'ProfileController@changePassword')->name('profile.changepassword');

Route::get('users', 'UserController@index')->name('users');
Route::get('users/show/{id}', 'UserController@show')->name('users.show');
Route::post('users/update/{id}', 'UserController@update')->name('users.update');
Route::delete('users/delete/{id}', 'UserController@delete')->name('users.delete');
Route::post('users/add', 'UserController@add')->name('users.add');

Route::get('lookup','LookupController@indexLookup')->name('lookup');
Route::post('lookup/{id}', 'LookupController@updateLookup')->name('lookup.update');
Route::delete('lookup/delete/{id}', 'LookupController@deleteLookup')->name('lookup.delete');
Route::post('lookup', 'LookupController@addLookup')->name('lookup.add');

Route::get('roles', 'SystemController@indexRole')->name('system.roles');
Route::post('roles/add', 'SystemController@addRole')->name('system.roles.add');
Route::put('roles/update/{id}', 'SystemController@updateRole')->name('system.roles.update');
Route::delete('roles/delete/{id}', 'SystemController@deleteRole')->name('system.roles.delete');

Route::get('thamsohethong', 'SystemController@indexThamSoHeThong')->name('system.thamsohethong');
Route::put('thamsohethong/update', 'SystemController@updateThamSoHeThong')->name('system.thamsohethong.update');
Route::post('thamsohethong/taomathechamcong', 'SystemController@taoMaTheChamCong')->name('system.thamsohethong.taomathechamcong');


Route::get('menus', 'SystemController@indexMenu')->name('system.menus');
Route::post('menus/add', 'SystemController@addMenu')->name('system.menus.add');
Route::put('menus/update/{id}', 'SystemController@updateMenu')->name('system.menus.update');
Route::delete('menus/delete/{id}', 'SystemController@deleteMenu')->name('system.menus.delete');

Route::get('functions', 'SystemController@indexFunctions')->name('system.functions');
Route::post('functions/add', 'SystemController@addFunctions')->name('system.functions.add');
Route::delete('functions/delete/{id}', 'SystemController@deleteFunctions')->name('system.functions.delete');

Route::get('phongban', 'DanhMucController@indexPhongBan')->name('danhmuc.phongban');
Route::get('phongban/struct', 'DanhMucController@structPhongBan')->name('danhmuc.phongban.struct');
Route::post('phongban/add', 'DanhMucController@addPhongBan')->name('danhmuc.phongban.add');
Route::post('phongban/update/{id}', 'DanhMucController@updatePhongBan')->name('danhmuc.phongban.update');
Route::delete('phongban/delete/{id}', 'DanhMucController@deletePhongBan')->name('danhmuc.phongban.delete');

Route::get('tochuc', 'DanhMucController@indexToChuc')->name('danhmuc.tochuc');
Route::post('tochuc/add', 'DanhMucController@addToChuc')->name('danhmuc.tochuc.add');
Route::post('tochuc/update/{id}', 'DanhMucController@updateToChuc')->name('danhmuc.tochuc.update');
Route::delete('tochuc/delete/{id}', 'DanhMucController@deleteToChuc')->name('danhmuc.tochuc.delete');
Route::get('tochuc/showdelete/{id}', 'DanhMucController@showFormDeleteToChuc')->name('danhmuc.tochuc.showdelete');
Route::get('tochuc/phongban/{id}', 'DanhMucController@indexPhongBanToChuc')->name('danhmuc.tochuc.phongban');

Route::get('chucvu', 'DanhMucController@indexChucVu')->name('danhmuc.chucvu');
Route::post('chucvu/add', 'DanhMucController@addChucVu')->name('danhmuc.chucvu.add');
Route::post('chucvu/update/{id}', 'DanhMucController@updateChucVu')->name('danhmuc.chucvu.update');
Route::delete('chucvu/delete/{id}', 'DanhMucController@deleteChucVu')->name('danhmuc.chucvu.delete');

Route::get('loailamthemgio', 'DanhMucController@indexLoaiLamThemGio')->name('luong.danhmuc.loailamthemgio');
Route::post('loailamthemgio/add', 'DanhMucController@addLoaiLamThemGio')->name('luong.danhmuc.loailamthemgio.add');
Route::post('loailamthemgio/update/{id}', 'DanhMucController@updateLoaiLamThemGio')->name('luong.danhmuc.loailamthemgio.update');
Route::delete('loailamthemgio/delete/{id}', 'DanhMucController@deleteLoaiLamThemGio')->name('luong.danhmuc.loailamthemgio.delete');
//-------------------------
Route::get('thamsotinhluong', 'DanhMucController@indexThamSoTinhLuong')->name('luong.thamsotinhluong');
Route::post('thamsotinhluong/add', 'DanhMucController@addThamSoTinhLuong')->name('luong.thamsotinhluong.add');
Route::put('thamsotinhluong/update/{id}', 'DanhMucController@updateThamSoTinhLuong')->name('luong.thamsotinhluong.update');
Route::delete('thamsotinhluong/delete/{id}', 'DanhMucController@deleteThamSoTinhLuong')->name('luong.thamsotinhluong.delete');

Route::get('phanloainhanvien', 'DanhMucController@indexPhanLoaiNhanVien')->name('danhmuc.phanloainhanvien');
Route::post('phanloainhanvien/add', 'DanhMucController@addPhanLoaiNhanVien')->name('danhmuc.phanloainhanvien.add');
Route::post('phanloainhanvien/update/{id}', 'DanhMucController@updatePhanLoaiNhanVien')->name('danhmuc.phanloainhanvien.update');
Route::delete('phanloainhanvien/delete/{id}', 'DanhMucController@deletePhanLoaiNhanVien')->name('danhmuc.phanloainhanvien.delete');

Route::get('tinhthanh', 'DanhMucController@indexTinhThanh')->name('danhmuc.tinhthanh');
Route::post('tinhthanh/add', 'DanhMucController@addTinhThanh')->name('danhmuc.tinhthanh.add');
Route::post('tinhthanh/update/{id}', 'DanhMucController@updateTinhThanh')->name('danhmuc.tinhthanh.update');
Route::delete('tinhthanh/delete/{id}', 'DanhMucController@deleteTinhThanh')->name('danhmuc.tinhthanh.delete');

Route::get('dantoc', 'DanhMucController@indexDanToc')->name('danhmuc.dantoc');
Route::post('dantoc/add', 'DanhMucController@addDanToc')->name('danhmuc.dantoc.add');
Route::post('dantoc/update/{id}', 'DanhMucController@updateDanToc')->name('danhmuc.dantoc.update');
Route::delete('dantoc/delete/{id}', 'DanhMucController@deleteDanToc')->name('danhmuc.dantoc.delete');

Route::get('tongiao', 'DanhMucController@indexTonGiao')->name('danhmuc.tongiao');
Route::post('tongiao/add', 'DanhMucController@addTonGiao')->name('danhmuc.tongiao.add');
Route::post('tongiao/update/{id}', 'DanhMucController@updateTonGiao')->name('danhmuc.tongiao.update');
Route::delete('tongiao/delete/{id}', 'DanhMucController@deleteTonGiao')->name('danhmuc.tongiao.delete');

Route::get('trinhdochuyenmon', 'DanhMucController@indexTrinhDoChuyenMon')->name('danhmuc.trinhdochuyenmon');
Route::post('trinhdochuyenmon/add', 'DanhMucController@addTrinhDoChuyenMon')->name('danhmuc.trinhdochuyenmon.add');
Route::post('trinhdochuyenmon/update/{id}', 'DanhMucController@updateTrinhDoChuyenMon')->name('danhmuc.trinhdochuyenmon.update');
Route::delete('trinhdochuyenmon/delete/{id}', 'DanhMucController@deleteTrinhDoChuyenMon')->name('danhmuc.trinhdochuyenmon.delete');

Route::get('trinhdovanhoa', 'DanhMucController@indexTrinhDoVanHoa')->name('danhmuc.trinhdovanhoa');
Route::post('trinhdovanhoa/add', 'DanhMucController@addTrinhDoVanHoa')->name('danhmuc.trinhdovanhoa.add');
Route::post('trinhdovanhoa/update/{id}', 'DanhMucController@updateTrinhDoVanHoa')->name('danhmuc.trinhdovanhoa.update');
Route::delete('trinhdovanhoa/delete/{id}', 'DanhMucController@deleteTrinhDoVanHoa')->name('danhmuc.trinhdovanhoa.delete');

Route::get('trinhdongoaingu', 'DanhMucController@indexTrinhDoNgoaiNgu')->name('danhmuc.trinhdongoaingu');
Route::post('trinhdongoaingu/add', 'DanhMucController@addTrinhDoNgoaiNgu')->name('danhmuc.trinhdongoaingu.add');
Route::post('trinhdongoaingu/update/{id}', 'DanhMucController@updateTrinhDoNgoaiNgu')->name('danhmuc.trinhdongoaingu.update');
Route::delete('trinhdongoaingu/delete/{id}', 'DanhMucController@deleteTrinhDoNgoaiNgu')->name('danhmuc.trinhdongoaingu.delete');

Route::get('quanhuyen', 'DanhMucController@indexQuanHuyen')->name('danhmuc.quanhuyen');
Route::post('quanhuyen/add', 'DanhMucController@addQuanHuyen')->name('danhmuc.quanhuyen.add');
Route::post('quanhuyen/update/{id}', 'DanhMucController@updateQuanHuyen')->name('danhmuc.quanhuyen.update');
Route::delete('quanhuyen/delete/{id}', 'DanhMucController@deleteQuanHuyen')->name('danhmuc.quanhuyen.delete');

Route::get('quoctich', 'DanhMucController@indexQuocTich')->name('danhmuc.quoctich');
Route::post('quoctich/add', 'DanhMucController@addQuocTich')->name('danhmuc.quoctich.add');
Route::post('quoctich/update/{id}', 'DanhMucController@updateQuocTich')->name('danhmuc.quoctich.update');
Route::delete('quoctich/delete/{id}', 'DanhMucController@deleteQuocTich')->name('danhmuc.quoctich.delete');

Route::get('hedaotao', 'DanhMucController@indexHeDaoTao')->name('danhmuc.hedaotao');
Route::post('hedaotao/add', 'DanhMucController@addHeDaoTao')->name('danhmuc.hedaotao.add');
Route::post('hedaotao/update/{id}', 'DanhMucController@updateHeDaoTao')->name('danhmuc.hedaotao.update');
Route::delete('hedaotao/delete/{id}', 'DanhMucController@deleteHeDaoTao')->name('danhmuc.hedaotao.delete');

Route::get('loaiphongban', 'DanhMucController@indexLoaiPhongBan')->name('danhmuc.loaiphongban');
Route::post('loaiphongban/add', 'DanhMucController@addLoaiPhongBan')->name('danhmuc.loaiphongban.add');
Route::post('loaiphongban/update/{id}', 'DanhMucController@updateLoaiPhongBan')->name('danhmuc.loaiphongban.update');
Route::delete('loaiphongban/delete/{id}', 'DanhMucController@deleteLoaiPhongBan')->name('danhmuc.loaiphongban.delete');

Route::get('loaitochuc', 'DanhMucController@indexLoaiToChuc')->name('danhmuc.loaitochuc');
Route::post('loaitochuc/add', 'DanhMucController@addLoaiToChuc')->name('danhmuc.loaitochuc.add');
Route::post('loaitochuc/update/{id}', 'DanhMucController@updateLoaiToChuc')->name('danhmuc.loaitochuc.update');
Route::delete('loaitochuc/delete/{id}', 'DanhMucController@deleteLoaiToChuc')->name('danhmuc.loaitochuc.delete');

Route::get('loaihopdong', 'DanhMucController@indexLoaiHopDong')->name('danhmuc.loaihopdong');
Route::post('loaihopdong/add', 'DanhMucController@addLoaiHopDong')->name('danhmuc.loaihopdong.add');
Route::post('loaihopdong/update/{id}', 'DanhMucController@updateLoaiHopDong')->name('danhmuc.loaihopdong.update');
Route::delete('loaihopdong/delete/{id}', 'DanhMucController@deleteLoaiHopDong')->name('danhmuc.loaihopdong.delete');

Route::get('hopdongchucvu', 'DanhMucController@indexHopDongChucVu')->name('danhmuc.hopdongchucvu');
Route::post('hopdongchucvu/add', 'DanhMucController@addHopDongChucVu')->name('danhmuc.hopdongchucvu.add');
Route::post('hopdongchucvu/update/{id}', 'DanhMucController@updateHopDongChucVu')->name('danhmuc.hopdongchucvu.update');
Route::delete('hopdongchucvu/delete/{id}', 'DanhMucController@deleteHopDongChucVu')->name('danhmuc.hopdongchucvu.delete');

Route::get('thuethunhap', 'DanhMucController@indexThueThuNhap')->name('danhmuc.thuethunhap');
Route::post('thuethunhap/add', 'DanhMucController@addThueThuNhap')->name('danhmuc.thuethunhap.add');
Route::post('thuethunhap/update/{id}', 'DanhMucController@updateThueThuNhap')->name('danhmuc.thuethunhap.update');
Route::delete('thuethunhap/delete/{id}', 'DanhMucController@deleteThueThuNhap')->name('danhmuc.thuethunhap.delete');

Route::get('mucdongbaohiem', 'DanhMucController@indexMucDongBaoHiem')->name('danhmuc.mucdongbaohiem');
Route::post('mucdongbaohiem/add', 'DanhMucController@addMucDongBaoHiem')->name('danhmuc.mucdongbaohiem.add');
Route::post('mucdongbaohiem/update/{id}', 'DanhMucController@updateMucDongBaoHiem')->name('danhmuc.mucdongbaohiem.update');
Route::delete('mucdongbaohiem/delete/{id}', 'DanhMucController@deleteMucDongBaoHiem')->name('danhmuc.mucdongbaohiem.delete');

Route::get('loainghidacbiet', 'DanhMucController@indexLoaiNghiDacBiet')->name('danhmuc.loainghidacbiet');
Route::post('loainghidacbiet/add', 'DanhMucController@addLoaiNghiDacBiet')->name('danhmuc.loainghidacbiet.add');
Route::post('loainghidacbiet/update/{id}', 'DanhMucController@updateLoaiNghiDacBiet')->name('danhmuc.loainghidacbiet.update');
Route::delete('loainghidacbiet/delete/{id}', 'DanhMucController@deleteLoaiNghiDacBiet')->name('danhmuc.loainghidacbiet.delete');

Route::get('phat', 'LuongController@indexPhat')->name('luong.phat');
Route::post('phat/add', 'LuongController@addPhat')->name('luong.phat.add');
Route::post('phat/update/{id}', 'LuongController@updatePhat')->name('luong.phat.update');
Route::delete('phat/delete/{id}', 'LuongController@deletePhat')->name('luong.phat.delete');
Route::post('phat/sync/byexcel', 'LuongController@syncByExcelPhat')->name('phat.sync.byexcel');


Route::get('chucvu/bacluong/{id}','DanhMucController@indexBacLuong')->name('chucvu.bacluong');
Route::post('chucvu/bacluong/add/{id}','DanhMucController@addBacLuong')->name('chucvu.bacluong.add');
Route::put('chucvu/bacluong/update/{id}','DanhMucController@updateBacLuong')->name('chucvu.bacluong.edit');
Route::delete('chucvu/bacluong/delete/{id}','DanhMucController@deleteBacLuong')->name('chucvu.bacluong.delete');

Route::get('bacluong/phucap/{id}','DanhMucController@indexPhuCapBacLuong')->name('bacluong.phucap');
Route::post('bacluong/phucap/add/{id}','DanhMucController@addPhuCapBacLuong')->name('bacluong.phucap.add');
Route::put('bacluong/phucap/update/{id}','DanhMucController@updatePhuCapBacLuong')->name('bacluong.phucap.edit');
Route::delete('bacluong/phucap/delete/{id}','DanhMucController@deletePhuCapBacLuong')->name('bacluong.phucap.delete');

Route::get('luong/danhmuc/loaiphucap','LuongController@indexLoaiPhuCap')->name('luong.danhmuc.loaiphucap');
Route::post('luong/danhmuc/loaiphucap/add','LuongController@addLoaiPhuCap')->name('luong.danhmuc.loaiphucap.add');
Route::put('luong/danhmuc/loaiphucap/update/{id}','LuongController@updateLoaiPhuCap')->name('luong.danhmuc.loaiphucap.edit');
Route::delete('luong/danhmuc/loaiphucap/delete/{id}','LuongController@deleteLoaiPhuCap')->name('luong.danhmuc.loaiphucap.delete');

Route::get('luong/danhmuc/loaichamcong','LuongController@indexLoaiChamCong')->name('luong.danhmuc.loaichamcong');
Route::post('luong/danhmuc/loaichamcong/add','LuongController@addLoaiChamCong')->name('luong.danhmuc.loaichamcong.add');
Route::put('luong/danhmuc/loaichamcong/update/{id}','LuongController@updateLoaiChamCong')->name('luong.danhmuc.loaichamcong.edit');
Route::delete('luong/danhmuc/loaichamcong/delete/{id}','LuongController@deleteLoaiChamCong')->name('luong.danhmuc.loaichamcong.delete');

Route::get('luong/danhmuc/loaiphat','LuongController@indexLoaiPhat')->name('luong.danhmuc.loaiphat');
Route::post('luong/danhmuc/loaiphat/add','LuongController@addLoaiPhat')->name('luong.danhmuc.loaiphat.add');
Route::put('luong/danhmuc/loaiphat/update/{id}','LuongController@updateLoaiPhat')->name('luong.danhmuc.loaiphat.edit');
Route::delete('luong/danhmuc/loaiphat/delete/{id}','LuongController@deleteLoaiPhat')->name('luong.danhmuc.loaiphat.delete');

Route::get('luong/theodoichamcong','LuongController@indexTheoDoiChamCong')->name('luong.theodoichamcong');

Route::get('cuahang', 'CuaHangController@index')->name('cuahang');
Route::get('cuahang/update/{id}', 'CuaHangController@showFormUpdate')->name('cuahang.update');
Route::put('cuahang/update/{id}', 'CuaHangController@update')->name('cuahang.update');
Route::delete('cuahang/delete/{id}', 'CuaHangController@delete')->name('cuahang.delete');
Route::get('cuahang/add', 'CuaHangController@showFormAdd')->name('cuahang.add');
Route::post('cuahang/add', 'CuaHangController@add')->name('cuahang.add');
Route::get('/cuahang/exports/excel', 'CuaHangController@index')->name('cuahang');
Route::post('cuahang/sync/byexcel', 'CuaHangController@syncByExcel')->name('cuahang.sync.byexcel');
Route::post('cuahang/sync/byexcel', 'CuaHangController@syncByExcel')->name('cuahang.sync.byexcel');

Route::get('cuahang/doanhso/{id}', 'CuaHangController@indexDoanhSo')->name('cuahang.doanhso');
Route::post('cuahang/doanh/so/update/{id}', 'CuaHangController@updateDoanhSo')->name('cuahang.doanhso.update');
Route::delete('cuahang/doanhso/delete/{id}', 'CuaHangController@deleteDoanhSo')->name('cuahang.doanhso.delete');
Route::post('cuahang/doanhso/add/{id}', 'CuaHangController@addDoanhSo')->name('cuahang.doanhso.add');

Route::get('nhansu', 'NhanSuController@index')->name('nhansu');
Route::get('nhansu/update/{id}', 'NhanSuController@showFormUpdate')->name('nhansu.update');
Route::put('nhansu/update/{id}', 'NhanSuController@update')->name('nhansu.update');
Route::put('nhansu/updatenhansu/{id}', 'NhanSuController@updateNhanSu')->name('nhansu.updatenhansu');
Route::get('nhansu/delete/{id}', 'NhanSuController@showFormDelete')->name('nhansu.delete');
Route::delete('nhansu/delete/{id}', 'NhanSuController@delete')->name('nhansu.delete');
Route::get('nhansu/add', 'NhanSuController@showFormAdd')->name('nhansu.add');
Route::post('nhansu/add', 'NhanSuController@add')->name('nhansu.add');
Route::post('nhansu/sync/byexcel', 'NhanSuController@syncByExcel')->name('nhansu.sync.byexcel');

Route::get('nhansu/hopdonghethan', 'ReportController@indexHopDongHetHan')->name('nhansu.hopdonghethan');
Route::get('/nhansu/hopdonghethan/exports/excel', 'ReportController@indexHopDongHetHan');
Route::get('nhansu/thuethunhapcanhan', 'ReportController@thueTNCN')->name('nhansu.thuethunhapcanhan');

Route::get('nhansu/update/chung/{id}', 'NhanSuController@showFormUpdate')->name('nhansu.update.chung');
Route::put('nhansu/update/chung/{id}', 'NhanSuController@update')->name('nhansu.update.chung');
Route::delete('nhansu/delete/{id}', 'NhanSuController@delete')->name('nhansu.delete');
Route::get('nhansu/add', 'NhanSuController@showFormAdd')->name('nhansu.add');
Route::post('nhansu/add', 'NhanSuController@add')->name('nhansu.add');

Route::get('nhansu/update/phongban/{id}','NhanSuController@indexPhongBan')->name('nhansu.update.phongban');
Route::post('nhansu/update/phongban/add/{id}','NhanSuController@addPhongBan')->name('nhansu.update.phongban.create');
Route::delete('nhansu/update/phongban/delete/{id}','NhanSuController@deletePhongBan')->name('nhansu.update.phongban.delete');

Route::get('nhansu/update/chucvu/{id}','NhanSuController@indexChucVu')->name('nhansu.update.chucvu');
Route::post('nhansu/update/chucvu/add/{id}','NhanSuController@addChucVu')->name('nhansu.update.chucvu.create');
Route::put('nhansu/update/chucvu/update/{id}','NhanSuController@updateChucVu')->name('nhansu.update.chucvu.edit');
Route::delete('nhansu/update/chucvu/delete/{id}','NhanSuController@deleteChucVu')->name('nhansu.update.chucvu.delete');

Route::get('nhansu/update/vanbang/{id}','NhanSuController@indexVanBang')->name('nhansu.update.vanbang');
Route::post('nhansu/update/vanbang/add/{id}','NhanSuController@addVanBang')->name('nhansu.update.vanbang.create');
Route::put('nhansu/update/vanbang/update/{id}','NhanSuController@updateVanBang')->name('nhansu.update.vanbang.edit');
Route::delete('nhansu/update/vanbang/delete/{id}','NhanSuController@deleteVanBang')->name('nhansu.update.vanbang.delete');

Route::get('nhansu/update/thue/{id}','NhanSuController@indexGiamTruGiaCanh')->name('nhansu.update.giamtrugiacanh');
Route::post('nhansu/update/thue/add/{id}','NhanSuController@addGiamTruGiaCanh')->name('nhansu.update.giamtrugiacanh.create');
Route::put('nhansu/update/thue/update/{id}','NhanSuController@updateGiamTruGiaCanh')->name('nhansu.update.giamtrugiacanh.edit');
Route::delete('nhansu/update/thue/delete/{id}','NhanSuController@deleteGiamTruGiaCanh')->name('nhansu.update.giamtrugiacanh.delete');

Route::get('nhansu/update/baohiem/{id}','NhanSuController@indexBaoHiem')->name('nhansu.update.baohiem');
Route::post('nhansu/update/baohiem/add/{id}','NhanSuController@addBaoHiem')->name('nhansu.update.baohiem.create');
Route::put('nhansu/update/baohiem/update/{id}','NhanSuController@updateBaoHiem')->name('nhansu.update.baohiem.edit');
Route::delete('nhansu/update/baohiem/delete/{id}','NhanSuController@deleteBaoHiem')->name('nhansu.update.baohiem.delete');

Route::get('nhansu/update/giacanh/{id}','NhanSuController@indexGiaCanh')->name('nhansu.update.giacanh');
Route::post('nhansu/update/giacanh/add/{id}','NhanSuController@addGiaCanh')->name('nhansu.update.giacanh.create');
Route::put('nhansu/update/giacanh/update/{id}','NhanSuController@updateGiaCanh')->name('nhansu.update.giacanh.edit');
Route::delete('nhansu/update/giacanh/delete/{id}','NhanSuController@deleteGiaCanh')->name('nhansu.update.giacanh.delete');

Route::get('nhansu/update/dongphuc/{id}','NhanSuController@indexDongPhuc')->name('nhansu.update.dongphuc');
Route::post('nhansu/update/dongphuc/add/{id}','NhanSuController@addDongPhuc')->name('nhansu.update.dongphuc.create');
Route::put('nhansu/update/dongphuc/edit/{id}','NhanSuController@editDongPhuc')->name('nhansu.update.dongphuc.edit');
Route::delete('nhansu/update/dongphuc/delete/{id}','NhanSuController@deleteDongPhuc')->name('nhansu.update.dongphuc.delete');

Route::get('nhansu/update/nghidacbiet/{id}','NhanSuController@indexNghiDacBiet')->name('nhansu.update.nghidacbiet');
Route::post('nhansu/update/nghidacbiet/add/{id}','NhanSuController@addNghiDacBiet')->name('nhansu.update.nghidacbiet.create');
Route::put('nhansu/update/nghidacbiet/update/{id}','NhanSuController@updateNghiDacBiet')->name('nhansu.update.nghidacbiet.edit');
Route::delete('nhansu/update/nghidacbiet/delete/{id}','NhanSuController@deleteNghiDacBiet')->name('nhansu.update.nghidacbiet.delete');

Route::get('nhansu/update/chungchi/{id}','NhanSuController@indexChungChi')->name('nhansu.update.chungchi');
Route::post('nhansu/update/chungchi/add/{id}','NhanSuController@addChungChi')->name('nhansu.update.chungchi.create');
Route::put('nhansu/update/chungchi/update/{id}','NhanSuController@updateChungChi')->name('nhansu.update.chungchi.edit');
Route::delete('nhansu/update/chungchi/delete/{id}','NhanSuController@deleteChungChi')->name('nhansu.update.chungchi.delete');

Route::get('nhansu/update/luong/{id}','NhanSuController@indexLuong')->name('nhansu.update.luong');
Route::post('nhansu/update/luong/add/{id}','NhanSuController@addLuong')->name('nhansu.update.luong.create');
Route::put('nhansu/update/luong/update/{id}','NhanSuController@updateLuong')->name('nhansu.update.luong.edit');
Route::delete('nhansu/update/luong/delete/{id}','NhanSuController@deleteLuong')->name('nhansu.update.luong.delete');

Route::get('nhansu/update/theodoihopdong/{id}','NhanSuController@indexTheoDoiHopDong')->name('nhansu.update.theodoihopdong');
Route::post('nhansu/update/theodoihopdong/add/{id}','NhanSuController@addTheoDoiHopDong')->name('nhansu.update.theodoihopdong.create');
Route::put('nhansu/update/theodoihopdong/update/{id}','NhanSuController@updateTheoDoiHopDong')->name('nhansu.update.theodoihopdong.edit');
Route::delete('nhansu/update/theodoihopdong/delete/{id}','NhanSuController@deleteTheoDoiHopDong')->name('nhansu.update.theodoihopdong.delete');
Route::post('nhansu/update/theodoihopdong/file/{id}','NhanSuController@fileTheoDoiHopDong')->name('nhansu.update.theodoihopdong.file');

Route::get('nhansu/update/hosonhansu/{id}','NhanSuController@indexHoSoNhanSu')->name('nhansu.update.hosonhansu');
Route::post('nhansu/update/hosonhansu/add/{id}','NhanSuController@addHoSoNhanSu')->name('nhansu.update.hosonhansu.create');
Route::get('hosonhansu/download/file/{id}', 'NhanSuController@getDownload');
Route::delete('nhansu/update/hosonhansu/delete/{id}','NhanSuController@deleteHoSoNhanSu')->name('nhansu.update.hosonhansu.delete');

Route::get('nhansu/update/lichsuthaydoi/{id}','NhanSuController@indexLichSuThayDoi')->name('nhansu.update.lichsuthaydoi');
Route::get('nhansu/update/lichsuthaydoi/detail/{id}','NhanSuController@detailLichSuThayDoi')->name('nhansu.update.lichsuthaydoi.detail');
Route::delete('nhansu/update/lichsuthaydoi/delete/{id}','NhanSuController@deleteLichSuThayDoi')->name('nhansu.update.lichsuthaydoi.delete');

Route::get('companies', 'SystemController@indexCompany')->name('companies');
Route::post('companies/add', 'SystemController@addCompany')->name('companies.add');
Route::put('companies/{id}/update', 'SystemController@updateCompany')->name('companies.update');
Route::delete('companies/{id}/delete', 'SystemController@deleteCompany')->name('companies.delete');

Route::get('/import', 'FileController@index')->name('import');
Route::get('import/detail/{id}', 'FileController@detail')->name('detail');
Route::put('import/detail/{id}', 'FileController@update')->name('import.update');
Route::delete('import/detail/{id}', 'FileController@deletedetail')->name('import.detail.delete');
Route::get('import/detail/{id}/sync', 'FileController@syncdetail')->name('import.detail.sync');  
Route::post('upload', 'FileController@upload')->name('upload');
Route::get('import/add/{id}', 'FileController@add')->name('import.add');

Route::get('/import/cuahang', 'FileController@indexCuaHang')->name('import.cuahang');
Route::post('upload/cuahang', 'FileController@uploadCuaHang')->name('upload.cuahang');
Route::get('import/cuahang/add/{id}', 'FileController@addCuaHang')->name('import.cuahang.add');
Route::get('import/detail/cuahang/{id}', 'FileController@detailCuaHang')->name('detail.cuahang');
Route::delete('import/cuahang/delete/{id}', 'FileController@deleteCuaHang')->name('import.delete.cuahang');
Route::put('import/cuahang/detail/{id}', 'FileController@updateCuaHang')->name('import.cuahang.update');
Route::delete('import/cuahang/detail/{id}', 'FileController@deletedetailCuaHang')->name('import.detail.delete.cuahang');

Route::get('download/template/cuahang', 'FileController@getTemplateFileCuaHang')->name('download.template.cuahang');
Route::get('download/template/nhansu', 'FileController@getTemplateFileNhanSu')->name('download.template.nhansu');
Route::get('download/template/nhansu/update', 'FileController@getTemplateFileNhanSuUpdate')->name('download.template.nhansu.update');
Route::get('download/template/chamcong', 'FileController@getTemplateFileChamCong')->name('download.template.chamcong');
Route::get('download/template/target', 'FileController@getTemplateFileTarget')->name('download.template.target');


Route::delete('import/delete/{id}', 'FileController@delete')->name('import.delete');
Route::get('download/import/{id}', 'FileController@getDownload');
Route::get('/reportcanhan', 'ReportController@index')->name('report');
Route::get('download/template/{name}', 'FileController@getTemplateFile')->name('download.template');
Route::get('/nhansu/exports/excel', 'NhanSuController@index');
//report -human
Route::get('/reportnhansu', 'ReportController@index')->name('report');
Route::get('/report/nhansu', 'ReportController@reportnhansu')->name('report.nhansu');
Route::get('/report/nhansubophan', 'ReportController@reportnhansubophan')->name('report.nhansubophan');
Route::get('/report/nhansuchinhanh', 'ReportController@reportnhansuchinhanh')->name('report.nhansuchinhanh');
Route::get('/report/nhansuthegioisua', 'ReportController@reportnhansuthegioisua')->name('report.nhansuthegioisua');
Route::get('/report/tonghopbaohiem', 'ReportController@reporttonghopbaohiem')->name('report.tonghopbaohiem');
Route::get('/report/danhsachthamgiabaohiem', 'ReportController@reportdanhsachthamgiabaohiem')->name('report.danhsachthamgiabaohiem');
Route::get('/report/baohiemthegioisuatheonam', 'ReportController@reportbaohiemthegioisuatheonam')->name('report.baohiemthegioisuatheonam');
Route::get('/report/nhansuTGS', 'ReportController@reportnhansuTGS')->name('report.nhansuTGS');

Route::post('/upload/file', 'FileController@uploadFile');
Route::post('/remove/file', 'FileController@remove');
Route::get('download/file/{id}', 'FileController@getDownloadFile');
Route::get('show/file/{id}', 'FileController@show');

Route::get('chamcong', 'ChamCongNhanSuController@index')->name('luong.chamcong');
Route::post('chamcong/capnhatnhansu/{tenbang}', 'ChamCongNhanSuController@updateNhanSu')->name('luong.chamcong.capnhatnhansu');

Route::post('chamcong/capnhatchamcong/{tenbang}/{id}', 'ChamCongNhanSuController@tinhLuong')->name('luong.chamcong.capnhatchamcong');
Route::post('chamcong/resetchamcong/{tenbang}/{id}', 'ChamCongNhanSuController@resetChamCong')->name('luong.chamcong.resetchamcong');
Route::post('chamcong/ngayle/{tenbang}', 'ChamCongNhanSuController@chamCongNgayLe')->name('luong.chamcong.ngayle');
Route::post('chamcong/chamcongcuahang/{tenbang}', 'ChamCongNhanSuController@chamCongCuaHang')->name('luong.chamcong.chamcongcuahang');
Route::put('chamcong/duyetbangluong/{tenbang}', 'ChamCongNhanSuController@duyetBangLuong')->name('luong.chamcong.duyetbangluong');
Route::put('chamcong/duyetlaibangluong/{tenbang}', 'ChamCongNhanSuController@duyetLaiBangLuong')->name('luong.chamcong.duyetlaibangluong');
Route::post('chamcong/add', 'ChamCongNhanSuController@add')->name('luong.chamcong.add');
Route::get('chamcong/chitiet/{tenbang}', 'ChamCongNhanSuController@showFormChiTiet')->name('luong.chamcong.chitiet');


Route::post('chamcong/capnhatthamso/{tenbang}', 'ChamCongNhanSuController@updateThamSo')->name('luong.chamcong.updatethamso');

Route::get('chamcong/chitiet/thamso/chucvu', 'ChamCongNhanSuController@showFormChiTietThamSoChucVu')->name('luong.chamcong.thamsochucvu');
Route::post('chamcong/capnhatthamsochucvu/{id}', 'ChamCongNhanSuController@updateThamSoChucVu')->name('luong.chamcong.updatethamsochucvu');
Route::post('chamcong/themthamsochucvu', 'ChamCongNhanSuController@addThamSoChucVu')->name('luong.chamcong.addthamsochucvu');
Route::delete('chamcong/xoathamsochucvu/{id}', 'ChamCongNhanSuController@deleteThamSoChucVu')->name('luong.chamcong.deletethamsochucvu');

Route::get('chamcong/chitiet/thamso/bacluong/{id}', 'ChamCongNhanSuController@showFormChiTietThamSoBacLuong')->name('luong.chamcong.thamsobacluong');
Route::put('chamcong/capnhatthamsobacluong/{id}', 'ChamCongNhanSuController@updateThamSoBacLuong')->name('luong.chamcong.updatethamsobacluong');
Route::post('chamcong/themthamsobacluong/{id}', 'ChamCongNhanSuController@addThamSoBacLuong')->name('luong.chamcong.addthamsobacluong');
Route::delete('chamcong/xoathamsobacluong/{id}', 'ChamCongNhanSuController@deleteThamSoBacLuong')->name('luong.chamcong.deletethamsobacluong');

Route::get('chamcong/chitiet/thamso/phucap/{id}', 'ChamCongNhanSuController@showFormChiTietThamSoPhuCap')->name('luong.chamcong.thamsophucap');
Route::put('chamcong/capnhatthamsophucap/{id}', 'ChamCongNhanSuController@updateThamSoPhuCap')->name('luong.chamcong.updatethamsophucap');
Route::post('chamcong/themthamsophucap/{id}', 'ChamCongNhanSuController@addThamSoPhuCap')->name('luong.chamcong.addthamsophucap');
Route::delete('chamcong/xoathamsophucap/{id}', 'ChamCongNhanSuController@deleteThamSoPhuCap')->name('luong.chamcong.deletethamsophucap');

Route::post('chamcong/sync/byexcel/{tenbang}', 'ChamCongNhanSuController@syncByExcel')->name('chamcong.sync.byexcel');

Route::get('chamcong', 'ChamCongNhanSuController@index')->name('luong.chamcong');
Route::put('chamcong/update/{id}', 'ChamCongNhanSuController@update')->name('luong.chamcong.edit');
Route::delete('chamcong/delete/{id}', 'ChamCongNhanSuController@delete')->name('luong.chamcong.delete');
Route::put('chamcong/khoaso/{id}', 'ChamCongNhanSuController@khoaSo')->name('luong.chamcong.khoaso');
Route::put('chamcong/moso/{id}', 'ChamCongNhanSuController@moSo')->name('luong.chamcong.moso');
Route::put('chamcong/boduyet/{id}', 'ChamCongNhanSuController@boDuyet')->name('luong.chamcong.boduyet');
Route::get('map', 'CuaHangController@map')->name('map');

Route::post('/chamcong/ngaycong/{tenbang}', 'ChamCongNhanSuController@updateNgayCong');
Route::post('/chamcong/tangca/{tenbang}', 'ChamCongNhanSuController@updateTangCa');
Route::get('chamcong/chitiet/{tenbang}/{id}', 'ChamCongNhanSuController@showFormChiTietChamCong')->name('luong.chitiet.chamcong');

Route::get('dangkyungdungchamcong', 'CuaHangController@indexDangKyUngDungChamCong')->name('dangkyungdungchamcong');
Route::post('dangkyungdunsgchamcong/add', 'CuaHangController@addDangKyUngDungChamCong')->name('dangkyungdungchamcong.add');
Route::post('dangkyungdungchamcong/{id}/update', 'CuaHangController@updateDangKyUngDungChamCong')->name('dangkyungdungchamcong.update');

Route::delete('dangkyungdungchamcong/delete/{id}', 'CuaHangController@deleteDangKyUngDungChamCong')->name('dangkyungdungchamcong.delete');
Route::get('dangkyungdungchamcong/search/{id}', 'CuaHangController@searchNhanSu');

Route::get('dangkyungdungchamcong/chitiet/{ma}', 'CuaHangController@indexChiTietChamCong')->name('dangkyungdungchamcong.chitiet');
Route::post('dangkyungdungchamcong/chitiet/edit/{id}', 'CuaHangController@updateChiTietChamCong')->name('dangkyungdungchamcong.chitiet.update');
Route::delete('dangkyungdungchamcong/chitiet/delete/{id}', 'CuaHangController@deleteChiTietChamCong')->name('dangkyungdungchamcong.chitiet.delete');


Route::get('thamsotinhluongthuong', 'ChamCongNhanSuController@indexThamSoTinhLuongThuong')->name('thamsotinhluongthuong');
Route::post('thamsotinhluongthuong/add', 'ChamCongNhanSuController@addThamSoTinhLuongThuong')->name('thamsotinhluongthuong.add');
Route::post('thamsotinhluongthuong/edit/{id}', 'ChamCongNhanSuController@updateThamSoTinhLuongThuong')->name('thamsotinhluongthuong.update');
Route::delete('thamsotinhluongthuong/delete/{id}', 'ChamCongNhanSuController@deleteThamSoTinhLuongThuong')->name('thamsotinhluongthuong.delete');
Route::post('capnhatthamsothuong', 'ChamCongNhanSuController@updateThamSoThuong')->name('capnhatthamsothuong');

Route::get('clearcache','SystemController@clear');

Route::get('danhsachtienbaolanh', 'LuongController@indexDanhSachTienBaoLanh')->name('luong.danhsachtienbaolanh');

Route::get('chitietbaolanh/{id}', 'LuongController@indexChiTietBaoLanh')->name('chitietbaolanh');
Route::post('chitietbaolanh/add/{id}', 'LuongController@addChiTietBaoLanh')->name('chitietbaolanh.add');
Route::post('chitietbaolanh/edit/{id}', 'LuongController@updateChiTietBaoLanh')->name('chitietbaolanh.update');
Route::delete('chitietbaolanh/delete/{id}', 'LuongController@deleteChiTietBaoLanh')->name('chitietbaolanh.delete');

Route::get('luong/danhmuc/loaitarget','LuongController@indexLoaiTarget')->name('luong.danhmuc.loaitarget');
Route::post('luong/danhmuc/loaitarget/add','LuongController@addLoaiTarget')->name('luong.danhmuc.loaitarget.add');
Route::put('luong/danhmuc/loaitarget/update/{id}','LuongController@updateLoaiTarget')->name('luong.danhmuc.loaitarget.edit');
Route::delete('luong/danhmuc/loaitarget/delete/{id}','LuongController@deleteLoaiTarget')->name('luong.danhmuc.loaitarget.delete');

Route::get('luong/lichsuthanhtoan','LuongController@indexLichSuThanhToan')->name('luong.lichsuthanhtoan');

Route::get('traluonglan1/{ten_bang}','LuongController@showFormTraLuongLan1')->name('luong.chamcong.traluonglan1');
Route::get('traluonglan2/{ten_bang}','LuongController@showFormTraLuongLan2')->name('luong.chamcong.traluonglan2');
Route::post('capnhatluonglan1/{ten_bang}','LuongController@updateLuongLan1')->name('luong.chamcong.capnhatluonglan1');
Route::post('capnhatluonglan2/{ten_bang}','LuongController@updateLuongLan2')->name('luong.chamcong.capnhatluonglan2');
Route::put('capnhatluonglan1/{ten_bang}/{id}','LuongController@updateLuongNhanSuLan1')->name('luong.chamcong.updateluongnhansulan1');
Route::put('capnhatluonglan2/{ten_bang}/{id}','LuongController@updateLuongNhanSuLan2')->name('luong.chamcong.updateluongnhansulan2');
Route::post('luong/chamcong/thanhtoan1/{ten_bang}','LuongController@traLuong1')->name('luong.chamcong.thanhtoan1');
Route::post('luong/chamcong/thanhtoan2/{ten_bang}','LuongController@traLuong2')->name('luong.chamcong.thanhtoan2');

Route::get('luong/target','LuongController@indexTarget')->name('luong.target');
Route::post('luong/target/add','LuongController@addTarget')->name('luong.target.add');
Route::post('luong/target/coppy','LuongController@coppyTarget')->name('luong.target.coppy');
Route::put('luong/target/update/{id}','LuongController@updateTarget')->name('luong.target.edit');
Route::delete('luong/target/delete/{id}','LuongController@deleteTarget')->name('luong.target.delete');
Route::post('uploadtarget', 'FileController@uploadTarget')->name('upload.target');


Route::get('luong/congno','LuongController@indexCongNo')->name('luong.congno');
Route::post('luong/congno/add','LuongController@addCongNo')->name('luong.congno.add');
Route::put('luong/congno/update/{id}','LuongController@updateCongNo')->name('luong.congno.edit');
Route::delete('luong/congno/delete/{id}','LuongController@deleteCongNo')->name('luong.congno.delete');

Route::get('chamcong/print/{tenbang}/{id}', 'ChamCongNhanSuController@print')->name('luong.chitiet.chamcong.print');

/////////////////////////////////////////////////////////////////////////////////////
Route::get('kho', 'KhoController@index')->name('kho');
Route::get('kho/update/{id}', 'KhoController@showFormUpdate')->name('kho.update');
Route::put('kho/update/{id}', 'KhoController@update')->name('kho.update');
Route::delete('kho/delete/{id}', 'KhoController@delete')->name('kho.delete');
Route::get('kho/add', 'KhoController@showFormAdd')->name('kho.add');
Route::post('kho/add', 'KhoController@add')->name('kho.add');
Route::get('/kho/exports/excel', 'KhoController@index')->name('kho');
Route::post('kho/sync/byexcel', 'KhoController@syncByExcel')->name('kho.sync.byexcel');
Route::post('kho/sync/byexcel', 'KhoController@syncByExcel')->name('kho.sync.byexcel');

Route::get('kho/doanhso/{id}', 'KhoController@indexDoanhSo')->name('kho.doanhso');
Route::post('kho/doanh/so/update/{id}', 'KhoController@updateDoanhSo')->name('kho.doanhso.update');
Route::delete('kho/doanhso/delete/{id}', 'KhoController@deleteDoanhSo')->name('kho.doanhso.delete');
Route::post('kho/doanhso/add/{id}', 'KhoController@addDoanhSo')->name('kho.doanhso.add');
