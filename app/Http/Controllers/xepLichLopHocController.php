<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class xepLichLopHocController extends Controller
{
    public function getXepLichLopHoc()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichLopHoc();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $lopHocTong = DB::table('view_class')
                ->select('class_id')
                ->get();
          
            $soKM = count($lopHocTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
            $lopHoc= DB::table('view_class')
            ->orderByDesc('class_startDay')
            ->take($lay)
            ->skip(0)
            ->get();

            $arr = [];
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            foreach ($lopHoc as $item)
            {
                $hocVien = DB::table('st_class_student')
                    ->where('class_id',$item->class_id)
                    ->get();
             
                $buoiHoc = DB::table('st_class_time')
                    ->where('class_id',$item->class_id)
                    ->where('classTime_startDate','>=',$now)
                    ->get();

                $giaoVien = DB::table('st_class_employee')
                ->join('st_employee','st_employee.employee_id','=','st_class_employee.employee_id')
                ->where('class_id',$item->class_id)
                ->where('classEmployee_type',1)
               
                ->select('st_employee.employee_id','st_employee.employee_name')
                ->get()->first();
                if(isset($giaoVien))
                $tenGiaoVien = $giaoVien->employee_name;
                else
                $tenGiaoVien="";


                $troGiang = DB::table('st_class_employee')
                ->join('st_employee','st_employee.employee_id','=','st_class_employee.employee_id')
                ->where('class_id',$item->class_id)
                ->where('classEmployee_type',2)
                ->select('st_employee.employee_id','st_employee.employee_name')
                ->get()->first();
                if(isset($troGiang))
                $tenTroGiang = $troGiang->employee_name;
                else
                $tenTroGiang="";

                $nhanVien = DB::table('st_class_employee')
                ->join('st_employee','st_employee.employee_id','=','st_class_employee.employee_id')
                
                ->where('class_id',$item->class_id)
                ->where('classEmployee_type',3)
                ->select('st_employee.employee_id','st_employee.employee_name')
                ->get()->first();
                if(isset($nhanVien))
                $tenNhanVien = $nhanVien->employee_name;
                else
                $tenNhanVien="";
                
                if($item->class_status==0)
                $trangThai = $item->class_status;
                else
                {
                    if($now<$item->class_startDay)
                        $trangThai=1;
                    else if( $now >= $item->class_startDay && $now <= $item->class_endDay)
                        $trangThai=2;
                    else
                        $trangThai=3;
                }

                $arr[]=[
                    'id'=>$item->class_id,
                    'chuongTrinh'=>$item->studyProgram_code,
                    'tenLop'=>$item->class_name,
                    'maLop'=>$item->class_code,
                    'giaoVien'=>$tenGiaoVien,
                    'troGiang'=>$tenTroGiang,
                    'nhanVien'=>$tenNhanVien,
                    'ngayBatDau'=>date('d/m/Y',strtotime($item->class_startDay)),
                    'ngayKetKhoa'=>date('d/m/Y',strtotime($item->class_endDay)),
                    'tinhTrang'=>$trangThai
                ];
            }
            return view('XepLichLopHoc.xepLichLopHoc')
            ->with('lopHoc',$arr)
            ->with('soTrang',$soTrang)
            ->with('page',1)
            ;
        }
        else
        {
            return redirect()->back();
        }
    }

    public function getThemXepLichLopHoc(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichLopHoc();
        if($quyenChiTiet==1)
        {
            $id = $request->get('id');

            $lopHoc = DB::table('st_class')
            ->join('st_course','st_course.course_id','=','st_class.course_id')
            ->join('st_study_program','st_study_program.studyProgram_id','=','st_course.studyProgram_id')
            ->where('st_class.class_id',$id)
            ->get()->first();

            $giaoVien = DB::table('st_employee')
            ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
            '=','st_employee.employee_id')
            ->where('st_quyen_chi_tiet_quyen.quyen_id',210)
            ->where('st_quyen_chi_tiet_quyen.chiTietQuyen_id',1)
            ->where('st_quyen_chi_tiet_quyen.quyen_chiTietQuyen_trangThai',1)
            ->where('st_employee.branch_id',$lopHoc->branch_id)
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
            ->where('st_employee.branch_id',$lopHoc->branch_id)
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
            ->where('st_employee.branch_id',$lopHoc->branch_id)
            ->orderBy('st_employee.employee_id')
            ->where('employee_status',1)
            ->select('st_employee.employee_id','st_employee.employee_name')
            ->get();
            $buoiHoc = DB::table('st_class_day')
            ->where('class_id',$id)
            ->get()->first();
           
            $soGio = $lopHoc->course_hours;
           

            $phongHoc = $this->timPhongTrong($lopHoc->class_id,$lopHoc->branch_id);

            $giaoVienDungLop = DB::table('st_class')
            ->join('st_class_employee','st_class_employee.class_id',
            '=','st_class.class_id')
            ->where('st_class.class_id',$id)
            ->where('st_class_employee.classEmployee_type',1)
            ->get();

            $giaoVienDau = 0;
            if(count($giaoVienDungLop)>0)
            {
                $giaoVienDauTien = $giaoVienDungLop->first();
                $giaoVienDau= $giaoVienDauTien->employee_id;
            }

            $troGiangDungLop = DB::table('st_class')
            ->join('st_class_employee','st_class_employee.class_id',
            '=','st_class.class_id')
            ->where('st_class.class_id',$id)
            ->where('st_class_employee.classEmployee_type',2)
            ->get();

            $TroGiangDau = 0;
            if(count($troGiangDungLop)>0)
            {
                $giaoVienDauTien = $troGiangDungLop->first();
                $TroGiangDau= $giaoVienDauTien->employee_id;
            }

            $nhanVienDungLop =DB::table('st_class')
            ->join('st_class_employee','st_class_employee.class_id',
            '=','st_class.class_id')
            ->where('st_class.class_id',$id)
            ->where('st_class_employee.classEmployee_type',3)
            ->get();

            $nhanVienDau = 0;
            if(count($nhanVienDungLop)>0)
            {
                $giaoVienDauTien = $nhanVienDungLop->first();
                $nhanVienDau= $giaoVienDauTien->employee_id;
            }

            return view('XepLichLopHoc.themXepLichLopHoc')
            ->with('giaoVien',$giaoVien)
            ->with('troGiang',$troGiang)
            ->with('NVDungLop',$NVDungLop)
            ->with('soGio',$soGio)
            ->with('lopHoc',$lopHoc)
            ->with('buoiHoc',$buoiHoc)
            ->with('phongHoc',$phongHoc)
            ->with('giaoVienDungLop',$giaoVienDungLop)
            ->with('troGiangDungLop',$troGiangDungLop)
            ->with('nhanVienDungLop',$nhanVienDungLop)
            ->with('giaoVienDau',$giaoVienDau)
            ->with('TroGiangDau',$TroGiangDau)
            ->with('nhanVienDau',$nhanVienDau)
            ;
        }
        else
        {
            return redirect()->back();
        }
    }

    public function timPhongTrong($idLopHoc,$idChiNhanh)
    {

        $phongHoc = DB::table('st_room')
        ->where('branch_id',$idChiNhanh)
        ->get();

        $lopHocTiem = DB::table('st_class_time')
        ->where('class_id',$idLopHoc)
        ->get();
        $arr=[];
        foreach($phongHoc as $item)
        {
            $kiemTra = 0;
            foreach($lopHocTiem as $item1)
            {
                $lopHocPhongHoc = DB::table('st_class_time')
                ->where('room_id',$item->room_id)
                ->where('class_id','!=',$idLopHoc)
                ->where('classTime_startDate','<=',$item1->classTime_startDate)
                ->where('classTime_endDate','>=',$item1->classTime_startDate)
                ->get()->first();

                if(isset($lopHocPhongHoc))
                {
                    $kiemTra=1;
                }
                else
                {
                    $lopHocPhongHoc = DB::table('st_class_time')
                    ->where('room_id',$item->room_id)
                    ->where('class_id','!=',$idLopHoc)
                    ->where('classTime_startDate','<=',$item1->classTime_endDate)
                    ->where('classTime_endDate','>=',$item1->classTime_endDate)
                    ->get()->first();
    
                    if(isset($lopHocPhongHoc))
                    {
                        $kiemTra=1;
                    }
                    else
                    {
                        $lopHocPhongHoc = DB::table('st_class_time')
                        ->where('room_id',$item->room_id)
                        ->where('class_id','!=',$idLopHoc)
                        ->where('classTime_startDate','<=',$item1->classTime_startDate)
                        ->where('classTime_endDate','>=',$item1->classTime_endDate)
                        ->get()->first();
        
                        if(isset($lopHocPhongHoc))
                        {
                            $kiemTra=1;
                        }
                        else
                        {
                            $lopHocPhongHoc = DB::table('st_class_time')
                            ->where('room_id',$item->room_id)
                            ->where('class_id','!=',$idLopHoc)
                            ->where('classTime_startDate','>=',$item1->classTime_startDate)
                            ->where('classTime_endDate','<=',$item1->classTime_endDate)
                            ->get()->first();
            
                            if(isset($lopHocPhongHoc))
                            {
                                $kiemTra=1;
                            }
                        }
                    }
                }

            }
            if($kiemTra==0)
            {
                $arr[]=[
                    'id'=>$item->room_id,
                    'ten'=>$item->room_name
                ];
            }

        }
        return $arr;

    }



    public function searchPhong(Request $request)
    {
        if($request->ajax())
        {
            $idChiNhanh = $request->get('idChiNhanh');
            $thu= $request->get('thu');
            $thoiGian = $request->get('thoiGian');
            $thoiGianBatDau = $request->get('ngayBatDau');
            $id = $request->get('id');

            $ngay1= substr($thoiGianBatDau,3,2);
            $thang1= substr($thoiGianBatDau,0,2);
            $nam1= substr($thoiGianBatDau,6,4);
            
            $ngay = new Carbon($nam1."-".$thang1."-".$ngay1);
           
          

            $phongHoc = DB::table('st_room')
            ->where('branch_id',$idChiNhanh)
            ->get();
            $arr=[];
            foreach($phongHoc as $item)
            {
                $phong = $item->room_id;
                $tuan = $ngay->weekOfYear;
                $thang = $ngay->month;
                $nam = $ngay->year;
                $kiemTraPhong = "";
                $soGio = $request->get('soGio');
                $soPhut = 0;
                $gioBatDauThem1 = $request->get('batDau');
                $gioKetThucThem1 = $request->get('ketThuc');

                while ($soGio>0)
                {
                    for ($i=0;$i<=6;$i++)
                    {
                        if ($thu[$i]==1)
                        {
                            $gioBatDauThem =  $gioBatDauThem1[$i];
                            $gioKetThucThem =  $gioKetThucThem1[$i];
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
                                if ($ngayHienTai> $ngay)
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

                                    $thoigianBatDau = $nam."-".$thangHienTai."-".$ngayHienTai." "
                                        .$gioBatDau1.":".$phutBatDau1.":00";

                                    $thoigianKetThuc = $nam."-".$thangHienTai."-".$ngayHienTai." "
                                        .$gioKetThuc1.":".$phutKetThuc1.":00";

                                    $thoigianBatDau1 =    date('Y-m-d H:i:s',strtotime($thoigianBatDau) );
                                    $thoigianKetThuc1 = date('Y-m-d H:i:s',strtotime($thoigianKetThuc) );


                                    $phongHoc = DB::table('st_class_time')
                                    ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                                    ->where('st_class.class_statusSchedule',1)
                                        ->where('st_class_time.room_id',$phong)
                                        ->where('st_class_time.classTime_startDate','<=',$thoigianBatDau1)
                                        ->where('st_class_time.classTime_endDate','>=',$thoigianBatDau1)
                                        ->where('st_class_time.class_id','!=',$id)
                                        ->get()
                                        ->first();
                                    if (isset($phongHoc))
                                    {
                                        $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc))." Phòng Học bị trùng lịch";
                                    }
                                    else
                                    {
                                        $phongHoc = DB::table('st_class_time')
                                        ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                                        ->where('st_class.class_statusSchedule',1)
                                            ->where('st_class_time.room_id',$phong)
                                            ->where('st_class_time.classTime_startDate','<=',$thoigianKetThuc1)
                                            ->where('st_class_time.classTime_endDate','>=',$thoigianKetThuc1)
                                            ->where('st_class_time.class_id','!=',$id)
                                            ->get()
                                            ->first();
                                        if (isset($phongHoc))
                                        {
                                            $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc))." Phòng Học bị trùng lịch";

                                        }
                                        else
                                        {
                                            $phongHoc = DB::table('st_class_time')
                                            ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                                            ->where('st_class.class_statusSchedule',1)
                                                ->where('st_class_time.room_id',$phong)
                                                ->where('st_class_time.classTime_startDate','>=',$thoigianBatDau1)
                                                ->where('st_class_time.classTime_endDate','<=',$thoigianKetThuc1)
                                                ->where('st_class_time.class_id','!=',$id)
                                                ->get()
                                                ->first();
                                            if (isset($phongHoc))
                                            {
                                                $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc))." Phòng Học bị trùng lịch";
                                            }else
                                            {
                                                $phongHoc = DB::table('st_class_time')
                                                ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                                                ->where('st_class.class_statusSchedule',1)
                                                    ->where('st_class_time.room_id',$phong)
                                                    ->where('st_class_time.classTime_startDate','<=',$thoigianBatDau1)
                                                    ->where('st_class_time.classTime_endDate','>=',$thoigianKetThuc1)
                                                    ->where('st_class_time.class_id','!=',$id)
                                                    ->get()
                                                    ->first();
                                                if (isset($phongHoc))
                                                {
                                                    $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc))." Phòng Học bị trùng lịch";
                                                }
                                            }
                                        }
                                    }
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

                                    if ($soGio<=0||$kiemTraPhong!="")
                                    {
                                      
                                        break;
                                    }
                                }
                                if ($soGio<=0||$kiemTraPhong!="")
                                {
                                   
                                    break;
                                }

                            }

                        }
                    }
                    if ($soGio<=0||$kiemTraPhong!="")
                    {
                      
                        break;
                    }
                    $tuan++;
                }


                if($kiemTraPhong=="")
                {
                    $arr[]=['id'=>$item->room_id,'ten'=> $item->room_name];
                }
            }
            return response($arr);
        }
       
    }

    public function kiemTraGiaoVienThem(Request $request)
    {
        if($request->ajax())
        {

            $thu= $request->get('thu');
            $thoiGian = $request->get('thoiGian');
            $thoiGianBatDau = $request->get('ngayBatDau');
           

            $ngay1= substr($thoiGianBatDau,3,2);
            $thang1= substr($thoiGianBatDau,0,2);
            $nam1= substr($thoiGianBatDau,6,4);
            
            $ngay = new Carbon($nam1."-".$thang1."-".$ngay1);
            $giaoVien = $request->get('giaoVien');

            $tuan = $ngay->weekOfYear;
            $thang = $ngay->month;
            $nam = $ngay->year;
            $kiemTraPhong = "";
            $soGio = $request->get('soGio');
            $soPhut = 0;
            $gioBatDauThem = $request->get('batDau');
            $gioKetThucThem = $request->get('ketThuc');

            $id = $request->get('id');


            while ($soGio>0)
            {
                for ($i=0;$i<=6;$i++)
                {
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
                            if ($ngayHienTai> $ngay)
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

                                $thoigianBatDau = $nam."-".$thangHienTai."-".$ngayHienTai." "
                                    .$gioBatDau1.":".$phutBatDau1.":00";

                                $thoigianKetThuc = $nam."-".$thangHienTai."-".$ngayHienTai." "
                                    .$gioKetThuc1.":".$phutKetThuc1.":00";

                                $thoigianBatDau1 =    date('Y-m-d H:i:s',strtotime($thoigianBatDau) );
                                $thoigianKetThuc1 = date('Y-m-d H:i:s',strtotime($thoigianKetThuc) );


                                $phongHoc = DB::table('st_class_time')
                                    ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                                    '=','st_class_time.classTime_id')
                                    ->where('st_class_time_employee.employee_id',$giaoVien)
                                    ->where('st_class_time.classTime_startDate','<=',$thoigianBatDau1)
                                    ->where('st_class_time.classTime_endDate','>=',$thoigianBatDau1)
                                    ->where('st_class_time.class_id','!=',$id)
                                    ->get()
                                    ->first();
                                if (isset($phongHoc))
                                {
                                    $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc))." giáo viên  bị trùng lịch";
                                }
                                else
                                {
                                    $phongHoc = DB::table('st_class_time')
                                    ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                                    '=','st_class_time.classTime_id')
                                    ->where('st_class_time_employee.employee_id',$giaoVien)
                                        ->where('st_class_time.classTime_startDate','<=',$thoigianKetThuc1)
                                        ->where('st_class_time.classTime_endDate','>=',$thoigianKetThuc1)
                                        ->where('st_class_time.class_id','!=',$id)
                                        ->get()
                                        ->first();
                                    if (isset($phongHoc))
                                    {
                                        $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc))." giáo viên bị trùng lịch ";

                                    }
                                    else
                                    {
                                        $phongHoc = DB::table('st_class_time')
                                        ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                                        '=','st_class_time.classTime_id')
                                        ->where('st_class_time_employee.employee_id',$giaoVien)
                                            ->where('st_class_time.classTime_startDate','>=',$thoigianBatDau1)
                                            ->where('st_class_time.classTime_endDate','<=',$thoigianKetThuc1)
                                            ->where('st_class_time.class_id','!=',$id)
                                            ->get()
                                            ->first();
                                        if (isset($phongHoc))
                                        {
                                            $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc))." giáo viên  bị trùng lịch";
                                        }else
                                        {
                                            $phongHoc = DB::table('st_class_time')
                                            ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                                            '=','st_class_time.classTime_id')
                                            ->where('st_class_time_employee.employee_id',$giaoVien)
                                                ->where('st_class_time.classTime_startDate','<=',$thoigianBatDau1)
                                                ->where('st_class_time.classTime_endDate','>=',$thoigianKetThuc1)
                                                ->where('st_class_time.class_id','!=',$id)
                                                ->get()
                                                
                                                ->first();
                                                if (isset($phongHoc))
                                                {
                                                    $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc))." giáo viên  bị trùng lịch";
                                                }
                                        }
                                    }
                                }
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
                                  
                                    break;
                                }
                            }
                            if ($soGio<=0)
                            {
                               
                                break;
                            }

                        }

                    }
                }
                if ($soGio<=0)
                {
                  
                    break;
                }
                $tuan++;
            }
            return response($kiemTraPhong);
        }
    }

    public function postThemXepLichLopHoc(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXem = $quyen->getXepLichLopHoc();
            
            if ($quyenXem == 1) {
                $thu=$request->get('thu');
                $thu2=$thu[0];
                $thu3=$thu[1];
                $thu4=$thu[2];
                $thu5=$thu[3];
                $thu6=$thu[4];
                $thu7=$thu[5];
                $thu8=$thu[6];
                
           
                $idLopThem= $request->get('id');
                
            $thoiGianBatDau = $request->get('ngayBatDau');
            $thoiGianKetThuc = $request->get('ngayKetThuc');
            $soGio = $request->get('soGio');
            $phong = $request->get('phong');
            $soPhut = 0;
            $ngay1= substr($thoiGianBatDau,3,2);
            $thang1= substr($thoiGianBatDau,0,2);
            $nam1= substr($thoiGianBatDau,6,4);
            $ngay = new Carbon($nam1."-".$thang1."-".$ngay1);
            $tuan = $ngay->weekOfYear;
            $thang = $ngay->month;
            $nam = $ngay->year;
            $giaoTrinh= $request->get('giaoTrinh');
            $thoiGian=count($thu);
            $soGioTru=0;
            $ngayKetThuc="";
            $kiemTraPhong = "";
            $ngayKetThuc1="";

            $kiemTraGiaoVien = "";
            $gioBatDauThem = $request->get('gioBatDau');
            $gioKetThucThem = $request->get('gioKetThuc');

            $ngayBatDauChinh  =$nam1."-".$thang1."-".$ngay1;
            $ngay2= substr($thoiGianKetThuc,3,2);
            $thang2= substr($thoiGianKetThuc,0,2);
            $nam2= substr($thoiGianKetThuc,6,4);
            $ngayKetThucChinh  =$nam2."-".$thang2."-".$ngay2;
            $ten = $request->get('ten');
            $chuongTrinh = $request->get('chuongTrinh');
            $khoaHoc = $request->get('khoaHoc');
            $trangThai = $request->get('trangThai');
            $hocPhi = $request->get('hocPhi');

            $giaoVien = $request->get('giaoVien'); 
            $troGiang = $request->get('troGiang');           
            $nhanVien = $request->get('nhanVien');
            if($giaoTrinh=="")
            $giaoTrinh="";

            try {


                DB::table('st_class')
                ->where('class_id',$idLopThem)
                ->update([
                    'class_name' => $ten,
                    'class_startDay' => $ngayBatDauChinh,
                    'class_endDay' => $ngayKetThucChinh,
                    'class_hours' => $soGio,
                    'room_id' => $phong,
                    'class_startHouse'=>$gioBatDauThem,
                    'class_endHouse'=>$gioKetThucThem,
                    'class_material'=>$giaoTrinh
                ]);


                DB::table('st_class_employee')
                ->where('class_id',$idLopThem)->delete();
                DB::table('st_class_time')
                ->where('class_id',$idLopThem)->delete();
                DB::table('st_class_day')
                ->where('class_id',$idLopThem)->delete();
                DB::table('st_class_time_employee')
                ->join('st_class_time','st_class_time.classTime_id',
                '=','st_class_time_employee.classTime_id')
                ->where('st_class_time.class_id',$idLopThem)->delete();

                
                
                for($i=0;$i<count($giaoVien);$i++)
                {
                    DB::table('st_class_employee')
                    ->insert([
                        'class_id'=>$idLopThem,
                        'employee_id'=>$giaoVien[$i],
                        'classEmployee_type'=>1
                    ]);
                }
                for($i=0;$i<count($troGiang);$i++)
                {
                    DB::table('st_class_employee')
                    ->insert([
                        'class_id'=>$idLopThem,
                        'employee_id'=>$troGiang[$i],
                        'classEmployee_type'=>2
                    ]);
                }
                for($i=0;$i<count($nhanVien);$i++)
                {
                    DB::table('st_class_employee')
                    ->insert([
                        'class_id'=>$idLopThem,
                        'employee_id'=>$nhanVien[$i],
                        'classEmployee_type'=>3
                    ]);
                }

                    $buoiHoc=0;
                    while ($soGio>0)
                    {
                        for ($i=0;$i<=6;$i++)
                        {
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
                                    if ($ngayHienTai> $ngay)
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
    
                                        $thoigianBatDau = $nam."-".$thangHienTai."-".$ngayHienTai." "
                                            .$gioBatDau1.":".$phutBatDau1.":00";
    
                                        $thoigianKetThuc = $nam."-".$thangHienTai."-".$ngayHienTai." "
                                            .$gioKetThuc1.":".$phutKetThuc1.":00";
    
                                        $thoigianBatDau1 =    date('Y-m-d H:i:s',strtotime($thoigianBatDau) );
                                        $thoigianKetThuc1 = date('Y-m-d H:i:s',strtotime($thoigianKetThuc) );
                                        // if ($buoiHoc<count($noiDung))
                                        // {
                                        //     $dem=0;
                                        //     foreach ($noiDung as $item)
                                        //     {
                                        //         if ($dem==$buoiHoc)
                                        //             $noiDungBuoiHoc=$item->pacingGuide_name;
                                        //         $dem++;
                                        //     }
                                        //     $buoiHoc++;
                                        // }
                                        // else
                                             $noiDungBuoiHoc= "Chưa Có Nội Dung";
    
                                      $idThoiGian=  DB::table('st_class_time')
                                            ->insertGetId([
                                                'class_id'=>$idLopThem,
                                                'classTime_startDate'=>$thoigianBatDau,
                                                'classTime_endDate'=>$thoigianKetThuc,
                                                'classTime_status'=>1,
                                                'classTime_type'=>1,
                                                'classTime_title'=>$noiDungBuoiHoc,
                
                                                'room_id'=>$phong
                                            ]);
                                            for($j=0;$j<count($giaoVien);$j++)
                                            {
                                                DB::table('st_class_time_employee')
                                                ->insert([
                                                    'classTime_id'=>$idThoiGian,
                                                    'employee_id'=>$giaoVien[$j],
                                                    'classTimeEmployee_type'=>1
                                                ]);
                                            }
                                            for($j=0;$j<count($troGiang);$j++)
                                            {
                                                DB::table('st_class_time_employee')
                                                ->insert([
                                                    'classTime_id'=>$idThoiGian,
                                                    'employee_id'=>$troGiang[$j],
                                                    'classTimeEmployee_type'=>2
                                                ]);
                                            }
                                            for($j=0;$j<count($nhanVien);$j++)
                                            {
                                                DB::table('st_class_time_employee')
                                                ->insert([
                                                    'classTime_id'=>$idThoiGian,
                                                    'employee_id'=>$nhanVien[$j],
                                                    'classTimeEmployee_type'=>3
                                                ]);
                                            }
    
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

                return response(1);
            }
            catch(QueryException $ex)
            {
                return response(0);
            }       

           
         
            }
            else
            {
               return response(2);
            }
        }
       
    }

    public function kiemTraLopHocXepLich(Request $request)
    {
        if ($request->ajax())
        {
            $giaoVien =  $request->get('giaoVien');
            $thu= $request->get('thu');
            $thoiGian = $request->get('thoiGian');
            $thoiGianBatDau = $request->get('ngayBatDau');
            $soGio = $request->get('soGio');
            $phong = $request->get('phong');
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
            $ngayKetThuc1="";

            $kiemTraGiaoVien = "";
            $gioBatDauThem = $request->get('batDau');
            $gioKetThucThem = $request->get('ketThuc');
            $troGiang = $request->get('troGiang');
            $id = $request->get('id');

            while ($soGio>0)
            {
                for ($i=0;$i<=6;$i++)
                {
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
                            if ($ngayHienTai> $ngay)
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

                                $thoigianBatDau = $nam."-".$thangHienTai."-".$ngayHienTai." "
                                    .$gioBatDau1.":".$phutBatDau1.":00";

                                $thoigianKetThuc = $nam."-".$thangHienTai."-".$ngayHienTai." "
                                    .$gioKetThuc1.":".$phutKetThuc1.":00";

                                $thoigianBatDau1 =    date('Y-m-d H:i:s',strtotime($thoigianBatDau) );
                                $thoigianKetThuc1 = date('Y-m-d H:i:s',strtotime($thoigianKetThuc) );


                                // $phongHoc = DB::table('st_class_time')
                                //     ->where('room_id',$phong)
                                //     ->where('classTime_startDate','<=',$thoigianBatDau1)
                                //     ->where('classTime_endDate','>=',$thoigianBatDau1)
                                //     ->get()
                                //     ->first();
                                // if (isset($phongHoc))
                                // {
                                //     $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc))." Phòng Học Bị Trùng";
                                // }
                                // else
                                // {
                                //     $phongHoc = DB::table('st_class_time')
                                //         ->where('room_id',$phong)
                                //         ->where('classTime_startDate','<=',$thoigianKetThuc1)
                                //         ->where('classTime_endDate','>=',$thoigianKetThuc1)
                                //         ->get()
                                //         ->first();
                                //     if (isset($phongHoc))
                                //     {
                                //         $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc))." Phòng Học Bị Trùng";

                                //     }
                                //     else
                                //     {
                                //         $phongHoc = DB::table('st_class_time')
                                //             ->where('room_id',$phong)
                                //             ->where('classTime_startDate','>=',$thoigianBatDau1)
                                //             ->where('classTime_endDate','<=',$thoigianKetThuc1)
                                //             ->get()
                                //             ->first();
                                //         if (isset($phongHoc))
                                //         {
                                //             $kiemTraPhong.="Từ ". date('d/m/Y H:i:s' ,strtotime($thoigianBatDau))." đến ". date('d/m/Y H:i:s' ,strtotime($thoigianKetThuc))." Phòng Học Bị Trùng";
                                //         }
                                //     }
                                // }
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

               /* if ($kiemTraPhong!="")
                {
                    break;
                }*/
               /* $soGio=0;*/
                $tuan++;

            $ngay = new Carbon($ngayKetThuc);
           /* $ngay->addDay(-1);*/
            $arr=[];
            if ($kiemTraPhong!="")
            {
               $arr[]=['id'=>1,'text'=>$kiemTraPhong,'ngay'=>date('d/m/Y',strtotime($ngay) )];
               return response($arr);         }
         {
               $arr[]=['id'=>2,'text'=>'','ngay'=>date('m/d/Y',strtotime($ngay) )];
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
}
