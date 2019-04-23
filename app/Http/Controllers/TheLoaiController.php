<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
class TheLoaiController extends Controller
{
    //
    public function getDanhSach(){
    	$theloai = TheLoai::all();
    	return view('admin.theloai.danhsach', ['theloai' => $theloai]);
    }
    public function getThem(){
    	return view('admin.theloai.them');
    }

    public function postThem(Request $request){
    	$this->validate($request, 
    	[
    		'Ten' => 'required|min:3|max: 100|unique:theloai,Ten'
    	], 
    	[
    		'Ten.required' => 'Bạn chưa nhập tên',
    		'Ten.unique' => 'Tên thể loại đã tồn tại',
    		'Ten.min' => 'Tên kí tự phải nhiều hơn 3',
    		'Ten.max' => 'Tên kí tự phải ít hơn 100'
    	]);
    	$theloai = new TheLoai;
    	$theloai->Ten = $request->Ten;
    	$theloai->TenKhongDau = changeTitle($request->Ten);
    	$theloai->save();

    	return redirect('admin/theloai/them')->with('thongbao', 'Bạn đã thêm Thể Loại thành công');    	
    }
    public function getSua($id){
    	$theloai = TheLoai::find($id);
    	return view('admin.theloai.sua', ['theloai'=>$theloai]);
    }
    public function postSua(Request $request, $id){
    	$theloai = TheLoai::find($id);
    	$this->validate($request, 
    	[
    		'Ten' => 'required|unique:theloai,ten|min:3|max:100'
    	], 
    	[
    		'Ten.required' => 'Bạn chưa nhập tên',
    		'Ten.unique' => 'Tên thể loại đã tồn tại',
    		'Ten.min' => 'Tên kí tự phải nhiều hơn 3',
    		'Ten.max' => 'Tên kí tự phải ít hơn 100'
    	]);

    	$theloai->Ten = $request->Ten;
    	$theloai->TenKhongDau = changeTitle($request->Ten);
    	$theloai->save();
    	return redirect('admin/theloai/sua/'.$id)->with('thongbao', 'Bạn đã sửa Thể Loại thành công');    	
    }
    public function getXoa($id){
    	$theloai = TheLoai::find($id);
    	$theloai->delete();
    	return redirect('admin/theloai/danhsach')->with('thongbao', 'Bạn đã xóa thành công');
    }
}
