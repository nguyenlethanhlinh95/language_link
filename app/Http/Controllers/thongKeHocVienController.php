<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class thongKeHocVienController extends Controller
{
    public function getThongKeHocVien()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThongKeHocVien();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $now = Carbon::now('Asia/Ho_Chi_Minh');
           
         
            $hocVien = DB::table('view_student_detail')
                ->orderByDesc('student_lastName')
                ->whereDate('student_dateTime',$now)
                ->get();
              

            $chiNhanh = DB::table('st_branch')
            ->get();        
            return view('ThongKe.hocVien')
            
            ->with('chiNhanh',$chiNhanh)
            ->with('hocVien',$hocVien)
            ->with('ngayBatDau',$now)
            ->with('ngayKetThuc',$now)
            ->with('thoiGianTimkiem',1)
            ->with('chiNhanhTimKiem',0)
            ->with('tenNguoiLap',"");
           
        }
        else
        {
            return redirect()->back();
        }

    }

    public function searchThongKeHocVien(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThongKeHocVien();
        if($quyenChiTiet==1)
        {
            $value= $request->get('tenNguoiLap');
            $page= $request->get('page');
            $chiNhanhTimKiem= $request->get('chiNhanhTimKiem');
            $thoiGianTimkiem= $request->get('thoiGianTimKiem');
            $khoangThoiGianTimKiem= $request->get('khoangThoiGianTimKiem');
           
            if($thoiGianTimkiem=="")
            {
                $ngay1= substr($khoangThoiGianTimKiem,3,2);
                $thang1= substr($khoangThoiGianTimKiem,0,2);
                $nam1= substr($khoangThoiGianTimKiem,6,4);
        
                $ngay2= substr($khoangThoiGianTimKiem,16,2);
                $thang2= substr($khoangThoiGianTimKiem,13,2);
                $nam2= substr($khoangThoiGianTimKiem,19,4);
                $ngayBatDau = $nam1."-".$thang1."-".$ngay1;
                $ngayKetThuc = $nam2."-".$thang2."-".$ngay2;
            }
            else
            {
                $timNgay = new thongKeThuChiController();
                $arrThoiGian = $timNgay->TimNgayThoiGian($thoiGianTimkiem);
                $ngayBatDau = $arrThoiGian[0]['ngayBatDau'];
                $ngayKetThuc = $arrThoiGian[0]['ngayKetThuc'];
            }

            $out = $this->getDuLieuThongHocVien($chiNhanhTimKiem,$value,$ngayBatDau,$ngayKetThuc,$page);
            $soTrang = $out[0]['soTrang'];
            $hocVien = $out[0]['hocVien'];
            $chiNhanh = DB::table('st_branch')
            ->get();        
            return view('ThongKe.hocVien')
            ->with('soTrang',$soTrang)
            ->with('chiNhanh',$chiNhanh)
            ->with('hocVien',$hocVien)
            ->with('ngayBatDau',$ngayBatDau)
            ->with('ngayKetThuc',$ngayKetThuc)
            ->with('thoiGianTimkiem',$thoiGianTimkiem)
            ->with('chiNhanhTimKiem',$chiNhanhTimKiem)
            ->with('tenNguoiLap',$value)
            ->with('page',1);
        }
        else
        {
            return redirect()->back();
        }
    }

    public function getDuLieuThongHocVien($chiNhanh, $value,$ngayBatDau,$ngayKetThuc,$page)
    {
        $quyen = new quyenController();
        $lay = $quyen->layDuLieu();
        if($value=="")
        {
            if($chiNhanh==0)
            {
                $hocVien = DB::table('view_student_detail')
                ->orderByDesc('student_lastName')
                ->whereDate('student_dateTime','>=',$ngayBatDau)
                ->whereDate('student_dateTime','<=',$ngayKetThuc)
                ->get();
              
              
            }
            else
            {

               
                $hocVien = DB::table('view_student_detail')
                ->orderByDesc('student_lastName')
                ->where('branch_id',$chiNhanh)
                ->whereDate('student_dateTime','>=',$ngayBatDau)
                ->whereDate('student_dateTime','<=',$ngayKetThuc)
                ->get();

            }
           
        }
        else
        {
            if($chiNhanh==0)
            {

                $hocVien = DB::table('view_student_detail')
                ->orderByDesc('student_lastName')
                ->whereDate('student_dateTime','>=',$ngayBatDau)
                ->whereDate('student_dateTime','<=',$ngayKetThuc)
                ->where(function($query) use($value)
                {
                    $query->where('employee_name', 'like', '%' . $value . '%')
                    ->orwhere('student_lastName', 'like', '%' . $value . '%')
                    ->orwhere('student_lastNameHidden', 'like', '%' . $value . '%');
                })
                ->get();
               
            }
            else
            {

                $hocVien = DB::table('view_student_detail')
                ->orderByDesc('student_lastName')
                ->where('branch_id',$chiNhanh)
                ->whereDate('student_dateTime','>=',$ngayBatDau)
                ->whereDate('student_dateTime','<=',$ngayKetThuc)
                ->where(function($query) use($value)
                {
                    $query->where('employee_name', 'like', '%' . $value . '%')
                    ->orwhere('student_lastName', 'like', '%' . $value . '%')
                    ->orwhere('student_lastNameHidden', 'like', '%' . $value . '%');
                })
                ->get();

            }
           
        }

      
     
     


          $arr[]=[
              'hocVien'=>$hocVien,
              'soTrang'=>1
          ];
          return $arr;
      
    }
}
