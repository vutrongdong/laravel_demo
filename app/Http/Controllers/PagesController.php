<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use App\User;
class PagesController extends Controller
{
    //
    public function trangchu(){
    	return view('pages.trangchu');
    }
    public function lienhe(){
    	return view('pages.lienhe');
    }
    public function loaitin($id){
    	$loaitin = LoaiTin::find($id);
    	$tintuc = TinTuc::where('idLoaiTin', $id)->paginate(5); 
    	return view('pages.loaitin', ['loaitin'=>$loaitin, 'tintuc'=>$tintuc]);
    }
    public function tintuc($id){
    	$tintuc = TinTuc::find($id);
    	$tinnoibat = TinTuc::where('NoiBat', 1)->take(4)->get();
    	$tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
    	return view('pages.tintuc', ['tintuc'=>$tintuc, 'tinnoibat'=>$tinnoibat, 'tinlienquan'=>$tinlienquan]);
    }
    public function getDangnhap(){
    	return view('pages.dangnhap');
    }
    public function postDangnhap(Request $request){
    	$this->validate($request,
    		[
    			'password' => 'required|min:5|max:32',
    			'email' => 'required'
    		],
    		[
    			'password.required' => 'Bạn chưa nhập mật khẩu',
    			'password.min' => 'Mật khẩu tối thiểu 5 kí tự',
    			'password.max' => 'Mật khẩu tối đa 32 kí tự',
    			'email.required' => 'Bạn chưa nhập địa chỉ mail'
    		]);
    	if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
    		return redirect('trangchu');
     	}else{
    		return redirect('trangchu/login')->with('thongbao', 'Bạn đã nhập sai địa chỉ mail hoặc mật khẩu');
    	}
    }
    public function getDangxuat(){
    	Auth::logout();
    	return redirect('trangchu');
    }
    public function getNguoidung(){
    	if(Auth::check()){
    		return view('pages.nguoidung',['user'=>Auth::user()]);
    	}else{
    		return redirect('trangchu/login')->with('thongbao','Bạn chưa đăng nhập');
    	}
    }
    public function postNguoidung(Request $request){
	 	$this->validate($request, 
    	[
    		'name'=>'required|min: 3',
    	],
    	[
    		'name.required'=>'Bạn chưa nhập tên người dùng',
    		'name.min' => 'Tên của bạn tối thiểu 3 kí tự trở lên',
    	]);
    	$user = Auth::user();
    	$user->name = $request->name;   	
    
    	if($request->changepassword == "on"){
    		$this->validate($request, 
    		[
    			'password' => 'required|min: 5|max: 32',
    			'passwordAgain' => 'required|same:password'
    		],
    		[
    			'password.required' => 'Bạn chưa nhập mật khẩu',
    			'password.min' => 'Mật khẩu tối thiểu từ 5 kí tự trở lên',
    			'password.max' => 'Mật khẩu tối đa 32 kí tự',
    			'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
    			'passwordAgain.same' => 'Mật khẩu không đúng'
    		]);    		
    		$user->password = bcrypt($request->password);
    	}
    	$user->save();
    	return redirect('trangchu/nguoidung')->with('thongbao', 'Bạn đã sửa người dùng thành công');
    }
    public function getDangki(){
    	return view('pages.dangki');
    }
    public function postDangki(Request $request){
    	$this->validate($request, 
    		[
    			'name'=>'required|min: 3',
    			'email'=>'required|unique:users,email',
    			'password' => 'required|min: 5|max: 32',
    			'passwordAgain' => 'required|same:password'
    		],
    		[
    			'name.required'=>'Bạn chưa nhập tên người dùng',
    			'name.min' => 'Tên của bạn tối thiểu 3 kí tự trở lên',
    			'email.required' => 'Bạn chưa nhập email',
    			'email.unique' => 'Email đã tồn tại',
    			'password.required' => 'Bạn chưa nhập mật khẩu',
    			'password.min' => 'Mật khẩu tối thiểu từ 5 kí tự trở lên',
    			'password.max' => 'Mật khẩu tối đa 32 kí tự',
    			'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
    			'passwordAgain.same' => 'Mật khẩu không đúng'
    		]);
    	$user = new User;
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->password = bcrypt($request->password);
    	$user->quyen = 0;
    	$user->save();
    	return redirect('trangchu/login')->with('success', 'Chúc mừng bạn đã đăng kí thành công, hãy đăng nhập ở đây');
    }
    function getTimkiem(Request $request){
    	$tukhoa = $request->get('tukhoa');
    	$tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orWhere('TomTat','like',"%$tukhoa%")->orWhere('NoiDung','like',"%$tukhoa%")->take(30)->paginate(5)->appends(['tukhoa' => $tukhoa]);
    	return view('pages.timkiem', ['tintuc'=>$tintuc, 'tukhoa'=> $tukhoa]);
    }
}
