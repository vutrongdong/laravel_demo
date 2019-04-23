<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
class LoaiTinController extends Controller
{
    //
    public function getDanhSach(){
    	$loaitin = LoaiTin::all();
    	return view('admin.loaitin.danhsach', ['loaitin' => $loaitin]);
    }
    public function getThem(){
    	$theloai = TheLoai::all();
    	return view('admin.loaitin.them', ['theloai' => $theloai]);
    }

    public function postThem(Request $request){
    	$this->validate($request, 
    	[
    		'Ten' => 'required|min:3|max: 100|unique:LoaiTin,Ten'
    	], 
    	[
    		'Ten.required' => 'Bạn chưa nhập tên',
    		'Ten.unique' => 'Tên thể loại đã tồn tại',
    		'Ten.min' => 'Tên kí tự phải nhiều hơn 3',
    		'Ten.max' => 'Tên kí tự phải ít hơn 100'
    	]);
    	$loaitin = new LoaiTin;
    	$loaitin->Ten = $request->Ten;
    	$loaitin->TenKhongDau = changeTitle($request->Ten);
    	$loaitin->idTheLoai = $request->TheLoai;
    	$loaitin->save();

    	return redirect('admin/loaitin/them')->with('thongbao', 'Bạn đã thêm Loại Tin thành công');    	
    }
    public function getSua($id){
    	$theloai = TheLoai::all();
    	$loaitin = LoaiTin::find($id);
    	return view('admin.loaitin.sua', ['loaitin'=>$loaitin, 'theloai'=>$theloai]);
    }
    public function postSua(Request $request, $id){
    	$loaitin = LoaiTin::find($id);
    	$this->validate($request, 
    	[
    		'Ten' => 'required|unique:LoaiTin,Ten|min:3|max:100',
    		'TheLoai' => 'required'
    	], 
    	[
    		'Ten.required' => 'Bạn chưa nhập tên',
    		'Ten.unique' => 'Tên thể loại đã tồn tại',
    		'Ten.min' => 'Tên kí tự phải nhiều hơn 3',
    		'Ten.max' => 'Tên kí tự phải ít hơn 100',
    		'TheLoai.required' => 'Bạn chưa chọn thể loại'
    	]);
    	$loaitin->Ten = $request->Ten;
    	$loaitin->TenKhongDau = changeTitle($request->Ten);
    	$loaitin->idTheLoai = $request->TheLoai;
    	$loaitin->save();
    	return redirect('admin/loaitin/sua/'.$id)->with('thongbao', 'Bạn đã sửa Loại Tin thành công');    	
    }
    public function getXoa($id){
    	$loaitin = LoaiTin::find($id);
    	$loaitin->delete();
    	return redirect('admin/loaitin/danhsach')->with('thongbao', 'Bạn đã xóa thành công');
    }
}
