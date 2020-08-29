<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class xepLichLopController extends Controller
{
    public function getXepLichLopMoi(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichMoLop();

        if($quyenChiTiet==1)
        {
            $idChiNhanh = $request->get('branch');
            $chiNhanh = DB::table('st_branch')
            ->get();
            
            if($idChiNhanh==0 && count($chiNhanh)>0)
            {
                $chiNhanhDau = $chiNhanh->first();
                $idChiNhanh= $chiNhanhDau->branch_id;
            }

            $chuongTrinhHoc = DB::table('st_study_program')
            ->where('branch_id',$idChiNhanh)
            ->orderBy('studyProgram_number')
            ->get();
            $idCT = 0;
            if(count($chuongTrinhHoc)>0)
            {
                $CTDau = $chuongTrinhHoc->first();
                $idCT= $CTDau->studyProgram_id;
            }
            $khoaHoc = DB::table('st_course')
            ->where('studyProgram_id',$idCT)
            ->orderBy('course_number')
            ->get();
            $soGio = 0;
            $hocPhi=0;
            $giaoTrinh="";
            $gioBuoiHoc ="";
            if(count($khoaHoc)>0)
            {
                $KHDau = $khoaHoc->first();
                $soGio=$KHDau->course_hours;
                $hocPhi = $KHDau->course_price;
                $giaoTrinh= $KHDau->course_material;
               
            }

            $phongHoc = DB::table('st_room')
            ->where('branch_id',$idChiNhanh)
            ->get();

            $giaoVien = DB::table('st_employee')
            ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
            '=','st_employee.employee_id')
            ->where('st_quyen_chi_tiet_quyen.quyen_id',210)
            ->where('st_quyen_chi_tiet_quyen.chiTietQuyen_id',1)
            ->where('st_quyen_chi_tiet_quyen.quyen_chiTietQuyen_trangThai',1)
            
            ->where('employee_status',1)
            ->orderBy('st_employee.employee_id') 
            ->select('st_employee.employee_id','st_employee.employee_name')
            ->get();
           
           
            $troGiang = DB::table('st_employee')
            ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
            '=','st_employee.employee_id')
            ->where('quyen_id',211)
            ->where('chiTietQuyen_id',1)
            ->where('quyen_chiTietQuyen_trangThai',1)
            ->orderBy('st_employee.employee_id')
            ->where('employee_status',1)
            ->select('st_employee.employee_id','st_employee.employee_name')
            ->get();

           


            $NVDungLop = DB::table('st_employee')
            ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
            '=','st_employee.employee_id')
            ->where('quyen_id',212)
            ->where('chiTietQuyen_id',1)
            ->where('quyen_chiTietQuyen_trangThai',1)
            ->orderBy('st_employee.employee_id')
            ->where('employee_status',1)
            ->select('st_employee.employee_id','st_employee.employee_name')
            ->get();

            $giaoVienTong = DB::table('st_employee')
            ->get();




            return view('XepLich.xepLichLopMoi')
            ->with('chiNhanh',$chiNhanh)
            ->with('idChiNhanh',$idChiNhanh)
            ->with('chuongTrinhHoc',$chuongTrinhHoc)
            ->with('khoaHoc',$khoaHoc)
            ->with('phongHoc',$phongHoc)
            ->with('soGio',$soGio)
            ->with('hocPhi',$hocPhi)
            ->with('giaoVien',$giaoVien)
            ->with('troGiang',$troGiang)
            ->with('NVDungLop',$NVDungLop)
            ->with('giaoTrinh',$giaoTrinh)
            ->with('giaoVienTong',$giaoVienTong)
            ->with('gioBuoiHoc',$gioBuoiHoc)
            ;
        }
        else
        {
            return redirect()->back();
        }

     
    }

    public function getXepLichLop(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichMoLop();

        if($quyenChiTiet==1)
        {
            $idLop = $request->get('id');
          $classTime=   DB::table('st_class_time')
            ->where('class_id',$idLop)
            ->get();
            foreach($classTime as $item)
            {
                DB::table('st_class_time_employee')
                ->where('classTime_id',$item->classTime_id)
                ->delete();
            }
            DB::table('st_class_time')
            ->where('class_id',$idLop)
            ->delete(); 
            $lop= DB::table('st_class')
            ->where('class_id',$idLop)
            ->get()->first();
            
            $idChiNhanh = $lop->branch_id;
            $chiNhanh = DB::table('st_branch')
            ->where('branch_id',$idChiNhanh)
            ->get()->first();
            $chuongTrinhHoc = DB::table('st_study_program')
            ->where('branch_id',$idChiNhanh)
            ->orderBy('studyProgram_number')
            ->get();
            $idCT = 0;

            $CTDau =  DB::table('st_study_program')
            ->join('st_course','st_course.studyProgram_id','=',
            'st_study_program.studyProgram_id')
            ->where('course_id',$lop->course_id)
            ->get()->first();

            $idCT= $CTDau->studyProgram_id;
            
            $khoaHoc = DB::table('st_course')
            ->where('studyProgram_id',$idCT)
            ->orderBy('course_number')
            ->get();
            $soGio = 0;
            $hocPhi=0;
            $giaoTrinh="";
            $gioBuoiHoc ="00:00";
              

            $classTimeDefault =DB::table('st_class_time_default')
            ->where('class_id',$idLop)
            ->get()->first();

            $gio1 = substr($classTimeDefault->classTimeDefault_startTime2,0,2);
            $phut1 = substr($classTimeDefault->classTimeDefault_startTime2,3,2);
            $gio2 = substr($classTimeDefault->classTimeDefault_endTime2,0,2);
            $phut2 = substr($classTimeDefault->classTimeDefault_endTime2,3,2);

            $gio = $gio2-$gio1;
            $phut = $phut2- $phut1;

            if($phut<0)
            {
                $phut=$phut+60;
                $gio= $gio-1;
            }

            if($phut<10)
            {
                $phut="0".$phut;
            }
            if($gio<10)
            {
                $gio="0".$gio;
            }
            $gioBuoiHoc = $gio.":".$phut;


            $soGio=$CTDau->course_hours;
            $hocPhi = $CTDau->course_price;
            $giaoTrinh= $CTDau->course_material;
          

            $phongHoc = DB::table('st_room')
            ->where('branch_id',$idChiNhanh)
            ->get();

            $giaoVien = DB::table('st_employee')
            ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
            '=','st_employee.employee_id')
            ->where('st_quyen_chi_tiet_quyen.quyen_id',210)
            ->where('st_quyen_chi_tiet_quyen.chiTietQuyen_id',1)
            ->where('st_quyen_chi_tiet_quyen.quyen_chiTietQuyen_trangThai',1)
            ->where('employee_status',1)
            ->orderBy('st_employee.employee_id') 
            ->select('st_employee.employee_id','st_employee.employee_name')
            ->get();
           
           
            $troGiang = DB::table('st_employee')
            ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
            '=','st_employee.employee_id')
            ->where('quyen_id',211)
            ->where('chiTietQuyen_id',1)
            ->where('quyen_chiTietQuyen_trangThai',1)
            ->orderBy('st_employee.employee_id')
            ->where('employee_status',1)
            ->select('st_employee.employee_id','st_employee.employee_name')
            ->get();

            $NVDungLop = DB::table('st_employee')
            ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
            '=','st_employee.employee_id')
            ->where('quyen_id',212)
            ->where('chiTietQuyen_id',1)
            ->where('quyen_chiTietQuyen_trangThai',1)
            ->orderBy('st_employee.employee_id')
            ->where('employee_status',1)
            ->select('st_employee.employee_id','st_employee.employee_name')
            ->get();

            $giaoVienTong = DB::table('st_employee')
            ->get();

            $thuNgay = DB::table('st_class_day')
            ->where('class_id',$idLop)
            ->get()
            ->first();

            $gioDefault =  DB::table('st_class_time_default')
            ->where('class_id',$idLop)
            ->get()
            ->first();

            return view('XepLich.xepLichLop')
            ->with('lop',$lop)
            ->with('chiNhanh',$chiNhanh)
            ->with('chuongTrinhHoc',$chuongTrinhHoc)
            ->with('khoaHoc',$khoaHoc)
            ->with('phongHoc',$phongHoc)
            ->with('soGio',$soGio)
            ->with('hocPhi',$hocPhi)
            ->with('giaoVien',$giaoVien)
            ->with('troGiang',$troGiang)
            ->with('NVDungLop',$NVDungLop)
            ->with('giaoTrinh',$giaoTrinh)
            ->with('giaoVienTong',$giaoVienTong)
            ->with('CTDau',$CTDau)
            ->with('thuNgay',$thuNgay)
            ->with('gioDefault',$gioDefault)
            ->with('gioBuoiHoc',$gioBuoiHoc)
            
            ;
        }
        else
        {
            return redirect()->back();
        }
    }

    public function kiemTraXepLichLopHoc(Request $request)
    {
        if ($request->ajax())
        {
            $giaoVien =  $request->get('arrGiaoVien');
            $troGiang =  $request->get('arrTroGiang');
            $giaoVienCanDoi = $request->get('giaoVienCanDoi');
            $giaoVienDoi = $request->get('giaoVienDoi');

            $thoiGianBatDauDoi = $request->get('ngayBatDauDoi');
            $thoiGianKetThucDoi = $request->get('ngayKetThucDoi');

            if($thoiGianBatDauDoi!=""&&$thoiGianKetThucDoi!="")
            {
                $ngayBatDauDoi = new Carbon(substr($thoiGianBatDauDoi,6,4)."-".substr($thoiGianBatDauDoi,0,2)."-".substr($thoiGianBatDauDoi,3,2));
                $ngayKetThucDoi =new Carbon(substr($thoiGianKetThucDoi,6,4)."-".substr($thoiGianKetThucDoi,0,2)."-".substr($thoiGianKetThucDoi,3,2));
            }
            else
            {
                $ngayBatDauDoi = new Carbon("1999-01-01");
                $ngayKetThucDoi =new Carbon("1999-01-02");
            }

           

            $thu= $request->get('thu');
            $thoiGian = $request->get('thoiGian');
            $thoiGianBatDau = $request->get('ngayBatDau');
            $soGio = $request->get('soGio');
            $soPhut = 0;

            $ngay1= substr($thoiGianBatDau,3,2);
            $thang1= substr($thoiGianBatDau,0,2);
            $nam1= substr($thoiGianBatDau,6,4);
            
            $ngay = new Carbon($nam1."-".$thang1."-".$ngay1);
            $tuan = $ngay->weekOfYear;
            $thang = $ngay->month;
            $nam = $ngay->year;

            $thoiGian1=count($thu);
            $soGioTru=0;
            $ngayKetThuc="";
            $kiemTraPhong = "";
            $kiemTraPhong1 = "";
            $ngayKetThuc1="";

            $kiemTraGiaoVien = "";
            $gioBatDauThem1 = $request->get('batDau');
            $gioKetThucThem1 = $request->get('ketThuc');
            
            $soBuoiHoc = 1;




            while ($soGio>0)
            {
                for ($i=0;$i<=6;$i++)
                {
                    if ($thu[$i]==1)
                    {
                        $gioBatDauThem = $gioBatDauThem1[$i];
                        $gioKetThucThem = $gioKetThucThem1[$i];

                        $thuHienTai = $i+1;
                        $dto = new \DateTime();
                        $dto->setISODate($nam, $tuan ,$thuHienTai);
                        $ngayHienTai = $dto->format('Y-m-d');
                        $thangKiemTraLe = substr($ngayHienTai,5,2);
                        $ngayKiemTraLe = substr($ngayHienTai,8,2);


                        $ngayLe = DB::table('st_holiday')
                        ->where('holiday_startDate','<=',$ngayHienTai)
                        ->where('holiday_endDate','>=',$ngayHienTai)
                        ->get()->first();
                        if (isset($ngayLe))
                        {

                        }
                        else
                        {
                            if ($ngayHienTai>= $ngay)
                            {

                                $gioBatDau = (int)substr($gioBatDauThem,0,2);
                                $phutBatDau = (int)substr($gioBatDauThem,3,2);
                                $gioKetThuc = (int)substr($gioKetThucThem,0,2);
                                $phutKetThuc = (int)substr($gioKetThucThem,3,2);

                                $gioBatDau1 = substr($gioBatDauThem,0,2);
                                $phutBatDau1 = substr($gioBatDauThem,3,2);
                                $gioKetThuc1 = substr($gioKetThucThem,0,2);
                                $phutKetThuc1 = substr($gioKetThucThem,3,2);


                                $dto = new \DateTime();
                                $dto->setISODate($nam, $tuan ,$thuHienTai);
                                $thoiGianHienTai = $dto->format('Y-m-d');
                                $thangHienTai= substr($thoiGianHienTai,5,2);
                                $ngayHienTai= substr($thoiGianHienTai,8,2);
                                $namHienTai= substr($thoiGianHienTai,0,4);
                                $thoigianBatDau = $namHienTai."-".$thangHienTai."-".$ngayHienTai." "
                                    .$gioBatDau1.":".$phutBatDau1.":00";

                                $thoigianKetThuc = $namHienTai."-".$thangHienTai."-".$ngayHienTai." "
                                    .$gioKetThuc1.":".$phutKetThuc1.":00";
                                
                                $giaoVienThu = $giaoVien[$i];
                                $troGiangThu = $troGiang[$i];
                                $thoigianBatDau1 =    date('Y-m-d H:i:s',strtotime($thoigianBatDau) );
                                $thoigianKetThuc1 = date('Y-m-d H:i:s',strtotime($thoigianKetThuc) );
                                if($ngayBatDauDoi<=$thoiGianHienTai 
                                && $ngayKetThucDoi >=$thoiGianHienTai 
                                && $giaoVienThu==$giaoVienCanDoi )
                                {
                                    $giaoVienHienTai = $giaoVienDoi;
                                }
                                else
                                {
                                    $giaoVienHienTai = $giaoVienThu;
                                }
                                if($ngayBatDauDoi<=$thoiGianHienTai 
                                && $ngayKetThucDoi >=$thoiGianHienTai 
                                && $troGiangThu==$giaoVienCanDoi )
                                {
                                    $troGiangHienTai = $giaoVienDoi;
                                }
                                else
                                {
                                    $troGiangHienTai = $troGiangThu;
                                }
                               if($kiemTraPhong=="")
                                $kiemTraPhong .=$this->kiemTraGiaoVien($thoigianBatDau1,$thoigianKetThuc1,$giaoVienHienTai,1,$thuHienTai+1);
                               
                               //$kiemTraPhong= $troGiangHienTai;
                               if($kiemTraPhong1=="")
                                $kiemTraPhong1 .=$this->kiemTraGiaoVien($thoigianBatDau1,$thoigianKetThuc1,$troGiangHienTai,1,$thuHienTai+1);
                              

                                if ($phutBatDau<=$phutKetThuc)
                                {
                                    $soGioCon= $gioKetThuc-$gioBatDau;
                                    $soPhutCon = $phutKetThuc-$phutBatDau;
                                }
                                else
                                {
                                    $soPhutCon = $phutKetThuc+60 - $phutBatDau;
                                    $soGioCon = $gioKetThuc - $gioBatDau -1;
                                }

                                if($soGioCon<0)
                                    $soGioCon=0;

                                if ($soPhutCon<=$soPhut)
                                {
                                    $soGio= $soGio-$soGioCon;
                                    $soPhut = $soPhut-$soPhutCon;
                                }
                                else
                                {
                                    $soGio= $soGio - $soGioCon -1;
                                    $soPhut = $soPhut-$soPhutCon+60;
                                }

                                if ($soGio<=0)
                                {
                                    $dto1 = new \DateTime();
                                    $dto1->setISODate($nam, $tuan ,$thuHienTai);
                                    $ngayKetThuc = $dto->format('Y-m-d');
                                    break;
                                }
                                $soBuoiHoc++;
                            }
                            if ($soGio<=0)
                            {
                                $dto1 = new \DateTime();
                                $dto1->setISODate($nam, $tuan ,$thuHienTai);
                                $ngayKetThuc = $dto->format('Y-m-d');
                                break;
                            }

                        }

                    }
                }
                if ($soGio<=0)
                {
                    $dto1 = new \DateTime();
                    $dto1->setISODate($nam, $tuan ,$thu[$i]-1);
                    $ngayKetThuc = $dto->format('Y-m-d');
                    break;
                }
                $tuan++;
            }

               /* if ($kiemTraPhong!="")
                {
                    break;
                }*/
               /* $soGio=0;*/
                $tuan++;

            $ngay = new Carbon($ngayKetThuc);
            $kiemTraPhong = $kiemTraPhong. "".$kiemTraPhong1;
           /* $ngay->addDay(-1);*/
            $arr=[];
            if ($kiemTraPhong!="")
            {
               $arr[]=['id'=>1,'text'=>$kiemTraPhong,'ngay'=>date('d/m/Y',strtotime($ngay) ),'soBuoi'=>$soBuoiHoc];
               return response($arr);         }
             {
               $arr[]=['id'=>2,'text'=>'','ngay'=>date('m/d/Y',strtotime($ngay) ),'soBuoi'=>$soBuoiHoc];
               return response($arr);
            }
            /*$a="";
            for ($i=2;$i<=8;$i++) {
                $key = "thu" . $i;
                if ($request->get($key) == true) {
                    $a.=$i." ";
                }
            }
            return response($a);*/
            /*$arr[]=['id'=>1,"text"=>$ngayKetThuc1];
            return response($arr);*/
          //  return response($soGio);
        }
    }


  
    public function kiemTraGiaoVien($thoigianBatDau1,$thoigianKetThuc1,$giaoVien,$loai,$thu)
    {
                            $kiemTraPhong="";
                        $giaoVienDau = DB::table('st_employee')
                        ->where('employee_id',$giaoVien)
                        ->get()->first();

                        if(isset($giaoVienDau))
                        {
                            $tenGiaoVien = $giaoVienDau->employee_name;
                        }
                        else
                        {
                            $tenGiaoVien="";
                        }


                            $phongHoc = DB::table('st_class_time')
                                    ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                                    '=','st_class_time.classTime_id')
                                    ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                                    ->where('st_class.class_statusSchedule',1)
                                    ->where('st_class.class_status',1)
                                    ->where('st_class_time_employee.employee_id',$giaoVien)
                                    ->where('st_class_time_employee.classTimeEmployee_type','!=',3)
                                    ->where('st_class_time.classTime_startDate','<=',$thoigianBatDau1)
                                    ->where('st_class_time.classTime_endDate','>=',$thoigianBatDau1)
                                    ->get()
                                    ->first();
                                if (isset($phongHoc))
                                {
                                   
                                    $kiemTraPhong.="Từ ". date('H:i:s' ,strtotime($thoigianBatDau1))." đến ". date('H:i:s' ,strtotime($thoigianKetThuc1))." thứ ".$thu." giáo  viên ". $tenGiaoVien." bị trùng";
                                }
                                else
                                {
                                    $phongHoc = DB::table('st_class_time')
                                    ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                                    '=','st_class_time.classTime_id')
                                    ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                                    ->where('st_class.class_statusSchedule',1)
                                    ->where('st_class.class_status',1)
                                    ->where('st_class_time_employee.employee_id',$giaoVien)
                                    ->where('st_class_time_employee.classTimeEmployee_type','!=',3)
                                        ->where('st_class_time.classTime_startDate','<=',$thoigianKetThuc1)
                                        ->where('st_class_time.classTime_endDate','>=',$thoigianKetThuc1)
                                        ->get()
                                        ->first();
                                    if (isset($phongHoc))
                                    {
                                       
                                        $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau1))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc1))." thứ ".$thu." giáo viên  ". $tenGiaoVien." bị trùng";

                                    }
                                    else
                                    {
                                        $phongHoc = DB::table('st_class_time')
                                        ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                                        '=','st_class_time.classTime_id')
                                        ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                                        ->where('st_class.class_statusSchedule',1)
                                        ->where('st_class.class_status',1)
                                        ->where('st_class_time_employee.employee_id',$giaoVien)
                                        ->where('st_class_time_employee.classTimeEmployee_type','!=',3)
                                            ->where('st_class_time.classTime_startDate','>=',$thoigianBatDau1)
                                            ->where('st_class_time.classTime_endDate','<=',$thoigianKetThuc1)
                                            ->get()
                                            ->first();
                                        if (isset($phongHoc))
                                        {
                                            
                                            $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau1))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc1))." thứ ".$thu." giáo viên  ". $tenGiaoVien." bị trùng";
                                        }
                                    }
                                }
                            return $kiemTraPhong;
    }



    public function postXepLichLopHoc(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXepLichMoLop();
    
            if($quyenChiTiet==1)
            {
                try
                {
                    $hocPhi =  $request->get('hocPhi');
                    $giaoTrinh =  $request->get('giaoTrinh');
                    $ten =  $request->get('ten');
                    $khoaHoc =  $request->get('khoaHoc');
                    $trangThai =  $request->get('trangThai');


                    $giaoVien =  $request->get('arrGiaoVien');
                    $troGiang =  $request->get('arrTroGiang');
                    $nhanVien =  $request->get('arrNhanVien');
        
                    $giaoVienCanDoi = $request->get('giaoVienCanDoi');
                    $giaoVienDoi = $request->get('giaoVienDoi');
        
                    $thoiGianBatDauDoi = $request->get('ngayBatDauDoi');
                    $thoiGianKetThucDoi = $request->get('ngayKetThucDoi');
        
                    if($thoiGianBatDauDoi!=""&&$thoiGianKetThucDoi!="")
                    {
                        $ngayBatDauDoi = new Carbon(substr($thoiGianBatDauDoi,6,4)."-".substr($thoiGianBatDauDoi,0,2)."-".substr($thoiGianBatDauDoi,3,2));
                        $ngayKetThucDoi =new Carbon(substr($thoiGianKetThucDoi,6,4)."-".substr($thoiGianKetThucDoi,0,2)."-".substr($thoiGianKetThucDoi,3,2));
                    }
                    else
                    {
                        $ngayBatDauDoi = new Carbon("1999-01-01");
                        $ngayKetThucDoi =new Carbon("1999-01-02");
                    }
        
                
        
                    $thu= $request->get('thu');
                    $thoiGian = $request->get('thoiGian');
                    $thoiGianBatDau = $request->get('ngayBatDau');
                    $thoiGianKetThuc= $request->get('ngayKetThuc');
                    
                    $soGio = $request->get('soGio');
                    $soPhut = 0;
        
                    $ngay1= substr($thoiGianBatDau,3,2);
                    $thang1= substr($thoiGianBatDau,0,2);
                    $nam1= substr($thoiGianBatDau,6,4);
                    $ngayBatDauChinh= $nam1."-".$thang1."-".$ngay1;

                    $ngay2= substr($thoiGianKetThuc,3,2);
                    $thang2= substr($thoiGianKetThuc,0,2);
                    $nam2= substr($thoiGianKetThuc,6,4);

                    $ngayKetThucChinh= $nam2."-".$thang2."-".$ngay2;

                    $ngay = new Carbon($nam1."-".$thang1."-".$ngay1);
                    $tuan = $ngay->weekOfYear;
                    $thang = $ngay->month;
                    $nam = $ngay->year;
                
                ;
                    $thoiGian1=count($thu);
                    $soGioTru=0;
                    $ngayKetThuc="";
                    $kiemTraPhong = "";
                    $ngayKetThuc1="";
        
                    $kiemTraGiaoVien = "";
                    $gioBatDauThem1 = $request->get('batDau');
                    $gioKetThucThem1 = $request->get('ketThuc');
                    $phong = $request->get('phong');
                    $chiNhanh = $request->get('chiNhanh');
                    $khoaHocBatDau = DB::table('st_course')
                    ->join('st_study_program','st_study_program.studyProgram_id',
                    '=','st_course.studyProgram_id')
                    ->where('st_course.course_id', $khoaHoc)
                    ->get()->first();


                    $now = Carbon::now('Asia/Ho_Chi_Minh');
                    $namLop = $now->year;


                   $idLopThem = $request->get('id');
                  

                    $lop = DB::table('st_class_course')
                    ->where('course_id', $khoaHocBatDau->studyProgram_id)
                    ->where('classCourse_year', $namLop)
                    ->get()
                    ->last();
                    $coSo = DB::table('st_branch')
                    ->where('branch_id',session('coSo'))
                    ->get()->first();
                    $year = substr($namLop, 2, 2);
                    // if (isset($lop)) {
                    //     $soLop = (int)$lop->classCourse_number + 1;
                    
                    //     if ($soLop < 10)
                    //         $khoaLop = $coSo->branch_code."_" . $khoaHocBatDau->studyProgram_code . "_" . $khoaHocBatDau->course_name . "_" . $year . "0" . $soLop;
                    //     else
                    //         $khoaLop = $coSo->branch_code."_" . $khoaHocBatDau->studyProgram_code . "_" . $khoaHocBatDau->course_name . "_" . $year . "" . $soLop;
                    // } else {
                    //     $soLop = 1;
                    //     $khoaLop = $coSo->branch_code."_" . $khoaHocBatDau->studyProgram_code . "_" . $khoaHocBatDau->course_name . "_" . $year . "01";
                    // }
                    if (isset($lop)) {
                        $soLop = (int)$lop->classCourse_number + 1;
                    
                        if ($soLop < 10)
                            $khoaLop =   $year . "0" . $soLop;
                        else
                            $khoaLop =  $year . "" . $soLop;
                    } else {
                        $soLop = 1;
                        $khoaLop =   $year . "01";
                    }

                    $thu2=$thu[0];
                    $thu3=$thu[1];
                    $thu4=$thu[2];
                    $thu5=$thu[3];
                    $thu6=$thu[4];
                    $thu7=$thu[5];
                    $thu8=$thu[6];
                    
                    $gioBatDau2= $gioBatDauThem1[0];
                    $gioBatDau3= $gioBatDauThem1[1];
                    $gioBatDau4= $gioBatDauThem1[2];
                    $gioBatDau5= $gioBatDauThem1[3];
                    $gioBatDau6= $gioBatDauThem1[4];
                    $gioBatDau7= $gioBatDauThem1[5];
                    $gioBatDau8= $gioBatDauThem1[6];

                    $gioKetThuc2= $gioKetThucThem1[0];
                    $gioKetThuc3= $gioKetThucThem1[1];
                    $gioKetThuc4= $gioKetThucThem1[2];
                    $gioKetThuc5= $gioKetThucThem1[3];
                    $gioKetThuc6= $gioKetThucThem1[4];
                    $gioKetThuc7= $gioKetThucThem1[5];
                    $gioKetThuc8= $gioKetThucThem1[6];

                    if($idLopThem=="")
                    {
                        $idLopThem=   DB::table('st_class')
                        ->insertGetId([
                            'course_id' => $khoaHoc,
                            'class_name' => $ten,
                            'class_startDay' => $ngayBatDauChinh,
                            'class_endDay' => $ngayKetThucChinh,
                            'class_status' => $trangThai,
                            'class_hours' => $soGio,
                            'class_price' => $hocPhi,
                            'room_id' => $phong,
                            'class_code' => $khoaLop,
                            'class_startHouse'=>0,
                            'class_endHouse'=>0,
                            'class_material'=> $giaoTrinh,
                            'branch_id'=>$chiNhanh,
                            'class_statusSchedule'=>0
                        ]);
                        DB::table('st_class_course')
                            ->insert([
                                'course_id' => $khoaHoc,
                                'classCourse_year' => $namLop,
                                'classCourse_number' => $soLop
                            ]);
                            DB::table('st_class_day')
                            ->insert([
                                'class_id' => $idLopThem,
                                'classDay_day2' => $thu2,
                                'classDay_day3' => $thu3,
                                'classDay_day4' => $thu4,
                                'classDay_day5' => $thu5,
                                'classDay_day6' => $thu6,
                                'classDay_day7' => $thu7,
                                'classDay_day8' => $thu8
                            ]);
                            DB::table('st_class_time_default')
                            ->insert([
                                'class_id'=>$idLopThem,
                                'classTimeDefault_startTime2'=>$gioBatDau2,
                                'classTimeDefault_startTime3'=>$gioBatDau3,
                                'classTimeDefault_startTime4'=>$gioBatDau4,
                                'classTimeDefault_startTime5'=>$gioBatDau5,
                                'classTimeDefault_startTime6'=>$gioBatDau6,
                                'classTimeDefault_startTime7'=>$gioBatDau7,
                                'classTimeDefault_startTime8'=>$gioBatDau8,
            
                                'classTimeDefault_endTime2'=>$gioKetThuc2,
                                'classTimeDefault_endTime3'=>$gioKetThuc3,
                                'classTimeDefault_endTime4'=>$gioKetThuc4,
                                'classTimeDefault_endTime5'=>$gioKetThuc5,
                                'classTimeDefault_endTime6'=>$gioKetThuc6,
                                'classTimeDefault_endTime7'=>$gioKetThuc7,
                                'classTimeDefault_endTime8'=>$gioKetThuc8,
            
                            ]);


                    }
                    else
                    {
                        DB::table('st_class')
                        ->where('class_id',$idLopThem)
                        ->update([
                            'course_id' => $khoaHoc,
                            'class_name' => $ten,
                            'class_startDay' => $ngayBatDauChinh,
                            'class_endDay' => $ngayKetThucChinh,
                            'class_status' => $trangThai,
                            'class_hours' => $soGio,
                            'class_price' => $hocPhi,
                            'room_id' => $phong,
                            'class_startHouse'=>0,
                            'class_endHouse'=>0,
                            'class_material'=> $giaoTrinh,
                            'branch_id'=>$chiNhanh,
                            'class_statusSchedule'=>0
                        ]);

                        DB::table('st_class_day')
                        ->where('class_id',$idLopThem)
                        ->update([
                                'class_id' => $idLopThem,
                                'classDay_day2' => $thu2,
                                'classDay_day3' => $thu3,
                                'classDay_day4' => $thu4,
                                'classDay_day5' => $thu5,
                                'classDay_day6' => $thu6,
                                'classDay_day7' => $thu7,
                                'classDay_day8' => $thu8
                            ]);

                            DB::table('st_class_time_default')
                            ->where('class_id',$idLopThem)
                            ->update([
                                'classTimeDefault_startTime2'=>$gioBatDau2,
                                'classTimeDefault_startTime3'=>$gioBatDau3,
                                'classTimeDefault_startTime4'=>$gioBatDau4,
                                'classTimeDefault_startTime5'=>$gioBatDau5,
                                'classTimeDefault_startTime6'=>$gioBatDau6,
                                'classTimeDefault_startTime7'=>$gioBatDau7,
                                'classTimeDefault_startTime8'=>$gioBatDau8,
            
                                'classTimeDefault_endTime2'=>$gioKetThuc2,
                                'classTimeDefault_endTime3'=>$gioKetThuc3,
                                'classTimeDefault_endTime4'=>$gioKetThuc4,
                                'classTimeDefault_endTime5'=>$gioKetThuc5,
                                'classTimeDefault_endTime6'=>$gioKetThuc6,
                                'classTimeDefault_endTime7'=>$gioKetThuc7,
                                'classTimeDefault_endTime8'=>$gioKetThuc8,
            
                            ]);
                    }
                   
                        $noiDung = DB::table('st_pacing_guide')
                        ->where('course_id',$khoaHoc)
                        ->get();
                        $buoiHoc=0;
                    while ($soGio>0)
                    {
                        for ($i=0;$i<=6;$i++)
                        {

                            $gioBatDauThem =  $gioBatDauThem1[$i];
                            $gioKetThucThem =  $gioKetThucThem1[$i];
                            if ($thu[$i]==1)
                            {
                                $thuHienTai = $i+1;
                                $dto = new \DateTime();
                                $dto->setISODate($nam, $tuan ,$thuHienTai);
                                $ngayHienTai = $dto->format('Y-m-d');
                                $thangKiemTraLe = substr($ngayHienTai,5,2);
                                $ngayKiemTraLe = substr($ngayHienTai,8,2);
        
        
                                $ngayLe = DB::table('st_holiday')
                                ->where('holiday_startDate','<=',$ngayHienTai)
                                ->where('holiday_endDate','>=',$ngayHienTai)
                                ->get()->first();
                                if (isset($ngayLe))
                                {
        
                                }
                                else
                                {
                                    if ($ngayHienTai>= $ngay)
                                    {
        
                                        $gioBatDau = (int)substr($gioBatDauThem,0,2);
                                        $phutBatDau = (int)substr($gioBatDauThem,3,2);
                                        $gioKetThuc = (int)substr($gioKetThucThem,0,2);
                                        $phutKetThuc = (int)substr($gioKetThucThem,3,2);
        
                                        $gioBatDau1 = substr($gioBatDauThem,0,2);
                                        $phutBatDau1 = substr($gioBatDauThem,3,2);
                                        $gioKetThuc1 = substr($gioKetThucThem,0,2);
                                        $phutKetThuc1 = substr($gioKetThucThem,3,2);
        
        
                                        $dto = new \DateTime();
                                        $dto->setISODate($nam, $tuan ,$thuHienTai);
                                        $thoiGianHienTai = $dto->format('Y-m-d');
                                        $thangHienTai= substr($thoiGianHienTai,5,2);
                                        $ngayHienTai= substr($thoiGianHienTai,8,2);
                                        $namHienTai= substr($thoiGianHienTai,0,4);
                                        
                                        $thoigianBatDau = $namHienTai."-".$thangHienTai."-".$ngayHienTai." "
                                            .$gioBatDau1.":".$phutBatDau1.":00";
        
                                        $thoigianKetThuc = $namHienTai."-".$thangHienTai."-".$ngayHienTai." "
                                            .$gioKetThuc1.":".$phutKetThuc1.":00";
                                        
                                        $giaoVienThu = $giaoVien[$i];
                                        $troGiangThu = $troGiang[$i];
                                        $nhanVienThu = $nhanVien;

                                        $thoigianBatDau1 =    date('Y-m-d H:i:s',strtotime($thoigianBatDau) );
                                        $thoigianKetThuc1 = date('Y-m-d H:i:s',strtotime($thoigianKetThuc) );
                                        if($ngayBatDauDoi<=$thoiGianHienTai 
                                        && $ngayKetThucDoi >=$thoiGianHienTai 
                                        && $giaoVienThu==$giaoVienCanDoi )
                                        {
                                            $giaoVienHienTai = $giaoVienDoi;
                                        }
                                        else
                                        {
                                            $giaoVienHienTai = $giaoVienThu;
                                        }
                                        if($ngayBatDauDoi<=$thoiGianHienTai 
                                        && $ngayKetThucDoi >=$thoiGianHienTai 
                                        && $troGiangThu==$giaoVienCanDoi )
                                        {
                                            $troGiangHienTai = $giaoVienDoi;
                                        }
                                        else
                                        {
                                            $troGiangHienTai = $troGiangThu;
                                        }

                                        if ($buoiHoc<count($noiDung))
                                            {
                                                $dem=0;
                                                foreach ($noiDung as $item)
                                                {
                                                    if ($dem==$buoiHoc)
                                                        $noiDungBuoiHoc=$item->pacingGuide_name;
                                                    $dem++;
                                                }
                                                $buoiHoc++;
                                            }
                                            else
                                            $noiDungBuoiHoc= "Chưa Có Nội Dung";
                                    
                                    if(strtolower($noiDungBuoiHoc)=="middle")
                                        {
                                            $type = 2;
                                        }
                                    else   if(strtolower($noiDungBuoiHoc)=="final")
                                        {
                                            $type =3;
                                        }
                                        else
                                        {
                                            $type=1;
                                        }

                                    $idClassTime=   DB::table('st_class_time')
                                        ->insertGetId([
                                            'class_id'=>$idLopThem,
                                            'classTime_startDate'=>$thoigianBatDau,
                                            'classTime_endDate'=>$thoigianKetThuc,
                                            'classTime_status'=>1,
                                            'classTime_type'=>$type,
                                            'classTime_title'=>$noiDungBuoiHoc,
                                            'room_id'=>$phong,
                                            'classTime_startTime'=>$gioBatDauThem
                                        ]);
                                    
                                        DB::table('st_class_time_employee')
                                        ->insert([
                                            'classTime_id'=>$idClassTime,
                                            'employee_id'=>$giaoVienHienTai,
                                            'classTimeEmployee_type'=>1
                                        ]);

                                        if($troGiangHienTai!=0)
                                        DB::table('st_class_time_employee')
                                        ->insert([
                                            'classTime_id'=>$idClassTime,
                                            'employee_id'=>$troGiangHienTai,
                                            'classTimeEmployee_type'=>2
                                        ]);
                                        DB::table('st_class_time_employee')
                                        ->insert([
                                            'classTime_id'=>$idClassTime,
                                            'employee_id'=>$nhanVienThu,
                                            'classTimeEmployee_type'=>3
                                        ]);


        
                                        if ($phutBatDau<=$phutKetThuc)
                                        {
                                            $soGioCon= $gioKetThuc-$gioBatDau;
                                            $soPhutCon = $phutKetThuc-$phutBatDau;
                                        }
                                        else
                                        {
                                            $soPhutCon = $phutKetThuc+60 - $phutBatDau;
                                            $soGioCon = $gioKetThuc - $gioBatDau -1;
                                        }
        
                                        if($soGioCon<0)
                                            $soGioCon=0;
        
                                        if ($soPhutCon<=$soPhut)
                                        {
                                            $soGio= $soGio-$soGioCon;
                                            $soPhut = $soPhut-$soPhutCon;
                                        }
                                        else
                                        {
                                            $soGio= $soGio - $soGioCon -1;
                                            $soPhut = $soPhut-$soPhutCon+60;
                                        }
        
                                        if ($soGio<=0)
                                        {
                                            $dto1 = new \DateTime();
                                            $dto1->setISODate($nam, $tuan ,$thuHienTai);
                                            $ngayKetThuc = $dto->format('Y-m-d');
                                            break;
                                        }
                                    }
                                    if ($soGio<=0)
                                    {
                                        $dto1 = new \DateTime();
                                        $dto1->setISODate($nam, $tuan ,$thuHienTai);
                                        $ngayKetThuc = $dto->format('Y-m-d');
                                        break;
                                    }
        
                                }
        
                            }
                        }
                        if ($soGio<=0)
                        {
                            $dto1 = new \DateTime();
                            $dto1->setISODate($nam, $tuan ,$thu[$i]-1);
                            $ngayKetThuc = $dto->format('Y-m-d');
                            break;
                        }
                        $tuan++;
                    }

                    $now = Carbon::now('Asia/Ho_Chi_Minh');
                    $tuan = $now->week();

                    $arr[]=[
                        'loai'=>1,
                        'id'=>$idLopThem,
                        'tuan'=>$tuan
                    ];
                    return response($arr);
                }
                catch(QueryException $ex)
                {
                    $arr[]=[
                        'loai'=>0,
                        'id'=>0,
                        'tuan'=>0
                    ];
                    return response($arr);
                }
            }
            else
            {
                $arr[]=[
                    'loai'=>2,
                    'id'=>0,
                    'tuan'=>0
                ];
                return response(2);
            }
        }
    }

    public function getLuuLich(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXepLichMoLop();
    
            if($quyenChiTiet==1)
            {
            $idLop= $request->get('idLop');

            DB::table('st_class')
            ->where('class_id',$idLop)
            ->update([
                'class_statusSchedule'=>1
            ]);
            return response(1);
            }
            else
            {
                return response(2);
            }
        }
    }
}
