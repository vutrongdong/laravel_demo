<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Comment;
class TinTucController extends Controller
{
    //
    public function getDanhSach(){
    	$tintuc = TinTuc::all();
    	return view('admin.tintuc.danhsach', ['tintuc' => $tintuc]);
    }
    public function getThem(){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them', ['theloai'=>$theloai, 'loaitin'=>$loaitin]);
    }

    public function postThem(Request $request){
        $this->validate($request, 
            [
                'LoaiTin' => 'required',
                'TieuDe'=>'required|unique:TinTuc,TieuDe|min:3|max:100',
                'NoiDung'=>'required',
                'TomTat'=>'required|min:20'
            ],
            [
                'LoaiTin.required' => 'Bạn chưa nhập loại tin',
                'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
                'TieuDe.unique' => 'Tiêu đề đã tồn tại',
                'TieuDe.min' => 'Tiêu đề cần tối thiểu 3 kí tự',
                'TieuDe.mã' => 'Tiêu đề cho phép tối đa 100 kí tự',
                'NoiDung.required' => 'Bạn chưa nhập nội dung',
                'TomTat.required' => 'Bạn chưa nhập tóm tắt',
                'TomTat.min' => 'Tóm tắt cần tối thiểu 20 kí tự'
            ]);
        $tintuc = new TinTuc;
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->SoLuotXem = 0;

        if($request->hasFile('Hinh'))
        {
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();

            if($duoi!='jpg' && $duoi!='png' && $duoi!='jpeg')
            {
                return redirect('admin/tintuc/them')->with('loi', 'Bạn chỉ được phép nhập ảnh có đuôi jpg, png, jpeg');
            }
            $name = $file->getClientOriginalName();
            $Hinh = str_random(5)."_".$name;
                //Kiểm tra tồn tại tên file
            while(file_exists('upload/tintuc/'.$Hinh))
            {
                $Hinh = str_random(5)."_".$name;
            }
            $file->move('upload/tintuc', $Hinh);
            $tintuc->Hinh = $Hinh;
        }else
        {
            $tintuc->Hinh = "";
        }
        $tintuc->save();
        return redirect('admin/tintuc/them')->with('thongbao', 'Bạn đã thêm tin tức thành công');
    }
    public function getSua($id){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();       
        $tintuc = TinTuc::find($id);
        return view('admin.tintuc.sua', ['tintuc'=>$tintuc, 'theloai'=>$theloai, 'loaitin'=>$loaitin]);
    }
    public function postSua(Request $request, $id){
        $tintuc = TinTuc::find($id);
        $this->validate($request, 
            [
                'LoaiTin' => 'required',
                'TieuDe'=>'required|unique:TinTuc,TieuDe|min:3|max:100',
                'NoiDung'=>'required',
                'TomTat'=>'required|min:20'
            ],
            [
                'LoaiTin.required' => 'Bạn chưa nhập loại tin',
                'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
                'TieuDe.unique' => 'Tiêu đề đã tồn tại',
                'TieuDe.min' => 'Tiêu đề cần tối thiểu 3 kí tự',
                'TieuDe.mã' => 'Tiêu đề cho phép tối đa 100 kí tự',
                'NoiDung.required' => 'Bạn chưa nhập nội dung',
                'TomTat.required' => 'Bạn chưa nhập tóm tắt',
                'TomTat.min' => 'Tóm tắt cần tối thiểu 20 kí tự'
            ]);
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;

        if($request->hasFile('Hinh'))
        {
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();

            if($duoi!='jpg' && $duoi!='png' && $duoi!='jpeg')
            {
                return redirect('admin/tintuc/them')->with('loi', 'Bạn chỉ được phép nhập ảnh có đuôi jpg, png, jpeg');
            }
            $name = $file->getClientOriginalName();
            $Hinh = str_random(5)."_".$name;
                //Kiểm tra tồn tại tên file
            while(file_exists('upload/tintuc/'.$Hinh))
            {
                $Hinh = str_random(5)."_".$name;
            }
            $file->move('upload/tintuc', $Hinh);
            unlink('upload/tintuc/'.$tintuc->Hinh);
            $tintuc->Hinh = $Hinh;
        }
        $tintuc->save();   
        return redirect('admin/tintuc/sua/'.$id)->with('thongbao', 'Bạn đã sửa thành công');
    }
    public function getXoa($id){
        $tintuc = TinTuc::find($id);
        $tintuc->delete();
        return redirect('admin/tintuc/danhsach')->with('thongbao', 'Bạn đã xóa tập tin');
    }
}
