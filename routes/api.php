<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('login', 'API\LoginAPIController@login');
Route::get('logout', 'API\LoginAPIController@logout');
Route::get('trang-chu', 'API\LoginAPIController@home')->middleware('checkToken');

Route::group(['middleware' => ['api', 'auth:api', 'checkToken'], 'prefix' => 'vanbannoibo'], function () {
    Route::get('/danh-sach-gui', 'API\VanBanNoiBoAPIController@danh_sach_gui');
    Route::get('/chi-tiet/{vanbanId}', 'API\VanBanNoiBoAPIController@chi_tiet_van_ban_gui_di');
    Route::get('/danh-sach-nhan', 'API\VanBanNoiBoAPIController@danh_sach_nhan');
});

Route::group(['middleware' => ['api', 'auth:api', 'checkToken'], 'prefix' => 'vanban'], function () {
    Route::get('/danh_sach_van_ban_den', 'API\VanBanAPIController@danh_sach_van_ban_den');
    Route::get('/chi-tiet-van-ban-den/{id}', 'API\VanBanAPIController@detailVanBanDen');
    Route::get('/danh_sach_van_ban_di', 'API\VanBanAPIController@danh_sach_van_ban_di');
    Route::get('/chi-tiet-van-ban-di/{id}', 'API\VanBanAPIController@detailVanBanDi');
});

Route::group(['middleware' => ['api', 'auth:api', 'checkToken'], 'prefix' => 'congviec'], function () {
    Route::get('danhsach','API\CongViecAPIController@getDanhSachCongViec');
    Route::get('chitiet/{id}','API\CongViecAPIController@chiTietCongViec');
});

Route::group(['middleware' => ['api', 'auth:api', 'checkToken'], 'prefix' => 'seach'], function () {
    Route::get('/','API\SeachAPIController@seachVanBan');
});

Route::group(['middleware' => ['api', 'auth:api', 'checkToken'], 'prefix' => ''], function () {
    Route::get('/xem-luong-thue','API\LuongAPIController@xemLuongThue');
    Route::get('/search-luong-thue','API\LuongAPIController@searchLuongAndThue');
});