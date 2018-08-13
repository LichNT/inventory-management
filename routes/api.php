<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('cuahang/dangnhap', 'Api\ChamCongCuaHangController@login');  
Route::post('cuahang/dangky', 'Api\ChamCongCuaHangController@register');
Route::post('cuahang/checkin', 'Api\ChamCongCuaHangController@checkin');
Route::post('cuahang/checkout', 'Api\ChamCongCuaHangController@checkout');
Route::get('companies', 'SystemController@indexCompany');
Route::get('tochucs', 'DanhMucController@indexToChuc');
Route::get('cuahangs', 'CuaHangController@index');
Route::post('upload/image', 'Api\UploadController@uploadImage');
Route::get('geocoding', 'Api\GeocodingController@getAddressByLatLon');
Route::post('forget/machamcong','Api\ChamCongCuaHangController@forgetMaChamCong');
Route::get('histories','Api\ChamCongCuaHangController@histories');
