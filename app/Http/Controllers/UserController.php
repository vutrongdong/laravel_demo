<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
class UserController extends Controller
{
    //
    public function getDanhSach(){
    	$user = User::all();
    	return view('admin.user.danhsach', ['user' => $user]);
    }
    public function getThem()
    {
    	return view('admin.user.them');
    }
    public function postThem(Request $request){
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
    	$user->quyen = $request->quyen;
    	$user->save();
    	return redirect('admin/user/them')->with('thongbao', 'Bạn đã thêm người dùng thành công');
    }
    public function getSua($id){
    	$user = User::find($id);
    	return view('admin.user.sua', ['user'=>$user]);
    }
    public function postSua(Request $request, $id){
    	    	$this->validate($request, 
    		[
    			'name'=>'required|min: 3',
    		],
    		[
    			'name.required'=>'Bạn chưa nhập tên người dùng',
    			'name.min' => 'Tên của bạn tối thiểu 3 kí tự trở lên',
    		]);
    	$user = User::find($id);
    	$user->name = $request->name;

    	if($request->changePassword == "on"){
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
    	$user->quyen = $request->quyen;
    	$user->save();
    	return redirect('admin/user/sua/'.$id)->with('thongbao', 'Bạn đã sửa người dùng thành công');
    }
    public function getXoa($id){
    	$user = User::find($id);
    	$user->delete();

    	return redirect('admin/user/danhsach')->with('thongbao', 'Đã xóa người dùng');
    }
    public function getDangnhapAdmin(){
    	return view("admin.login");
    }
    public function postDangnhapAdmin(Request $request){
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
    		return redirect('admin/theloai/danhsach');
    	}else{
    		return redirect('admin/dangnhap')->with('thongbao', 'Bạn đã nhập sai địa chỉ mail hoặc mật khẩu');
    	}

    }
    public function getDangxuatAdmin(){
    	Auth::logout();
    	return redirect('trangchu/login');
    }
}
