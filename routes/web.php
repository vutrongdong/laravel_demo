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
use App\TheLoai; 

Route::get('/', function () {
    return view('pages.trangchu');
});
Route::get('admin/dangnhap', 'UserController@getDangnhapAdmin');
Route::post('admin/dangnhap', 'UserController@postDangnhapAdmin');
Route::get('admin/logout', 'UserController@getDangxuatAdmin');

Route::group(['prefix' => 'admin', 'middleware' => 'adminLogin'], function(){
					//Thể Loại
	Route::group(['prefix' => 'theloai'], function(){
		Route::get('danhsach', 'TheLoaiController@getDanhSach');

		Route::get('them', 'TheLoaiController@getThem');
		Route::post('them', 'TheLoaiController@postThem');

		Route::get('sua/{id}', 'TheLoaiController@getSua');
		Route::post('sua/{id}','TheLoaiController@postSua');

		Route::get('xoa/{id}', 'TheLoaiController@getXoa');
	});
					//Loại Tin
	Route::group(['prefix' => 'loaitin'], function(){
		Route::get('danhsach', 'LoaiTinController@getDanhSach');

		Route::get('them', 'LoaiTinController@getThem');
		Route::post('them', 'LoaiTinController@postThem');

		Route::get('sua/{id}', 'LoaiTinController@getSua');
		Route::post('sua/{id}','LoaiTinController@postSua');

		Route::get('xoa/{id}', 'LoaiTinController@getXoa');
	});
					//Tin Tức
	Route::group(['prefix' => 'tintuc'], function(){
		Route::get('danhsach', 'TinTucController@getDanhSach');

		Route::get('them', 'TinTucController@getThem');
		Route::post('them', 'TinTucController@postThem');

		Route::get('sua/{id}', 'TinTucController@getSua');
		Route::post('sua/{id}', 'TinTucController@postSua');

		Route::get('xoa/{id}', 'TinTucController@getXoa');
	});

	Route::group(['prefix' => 'ajax'], function(){
		Route::get("loaitin/{idTheLoai}", 'AjaxController@getLoaiTin');
	});
					//Comment
	Route::group(['prefix' => 'comment'], function(){
		Route::get('xoa/{id}/{idTinTuc}', 'CommentController@getXoa');
	});
					//Slide
	Route::group(['prefix' => 'slide'], function(){
		Route::get('danhsach', 'SlideController@getDanhSach');

		Route::get('them', 'SlideController@getThem');
		Route::post('them', 'SlideController@postThem');

		Route::get('sua/{id}', 'SlideController@getSua');
		Route::post('sua/{id}', 'SlideController@postSua');

		Route::get('xoa/{id}', 'SlideController@getXoa');
	});
					//User
	Route::group(['prefix' => 'user'], function(){
		Route::get('danhsach', 'UserController@getDanhSach');

		Route::get('them', 'UserController@getThem');
		Route::post('them', 'UserController@postThem');

		Route::get('sua/{id}', 'UserController@getSua');
		Route::post('sua/{id}', 'UserController@postSua');

		Route::get('xoa/{id}', 'UserController@getXoa');
	});
});

Route::get('trangchu', 'PagesController@trangchu');
Route::get('trangchu/lienhe', 'PagesController@lienhe');
Route::get('trangchu/loaitin/{id}/{TenKhongDau}.html', 'PagesController@loaitin');
Route::get('trangchu/tintuc/{id}/{TieuDeKhongDau}.html', 'PagesController@tintuc');
Route::get('trangchu/login', 'PagesController@getDangnhap');
Route::post('trangchu/login', 'PagesController@postDangnhap');
Route::get('logout', 'PagesController@getDangxuat');
Route::get('trangchu/nguoidung', 'PagesController@getNguoidung');
Route::post('trangchu/nguoidung', 'PagesController@postNguoidung');
Route::get('trangchu/dangki', 'PagesController@getDangki');
Route::post('trangchu/dangki', 'PagesController@postDangki');

Route::post('comment/{id}', 'CommentController@postComment');

Route::get('trangchu/timkiem', 'PagesController@getTimkiem');
Route::get('test', function () {
    return view('welcome');
});
