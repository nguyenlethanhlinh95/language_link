<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

class lopHocController extends Controller
{
    public function getLopHoc()
    {
        $quyen = new quyenController();
        $quyenXem = $quyen->getXemLopHoc();
        
        if ($quyenXem == 1) {
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
                $chiNhanh = DB::table('st_branch')
                ->where('branch_id',$item->branch_id)
                ->get()->first();

                if(isset($chiNhanh))
                {
                    $maChiNhanh = $chiNhanh->branch_code;
                }
                else
                {
                    $maChiNhanh="";
                }

                $giaoVien = DB::table('st_class_time')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id','=','st_class_time.classTime_id')
                ->join('st_employee','st_employee.employee_id','=','st_class_time_employee.employee_id')
                ->where('st_class_time.class_id',$item->class_id)
                ->where('classTimeEmployee_type',1)
                ->select('st_employee.employee_id','st_employee.employee_name')
                ->get()->first();
                
                if(isset($giaoVien))
                $tenGiaoVien = $giaoVien->employee_name;
                else
                $tenGiaoVien="";


                $troGiang =  DB::table('st_class_time')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id','=','st_class_time.classTime_id')
                ->join('st_employee','st_employee.employee_id','=','st_class_time_employee.employee_id')
                ->where('st_class_time.class_id',$item->class_id)
                ->where('classTimeEmployee_type',2)
                ->select('st_employee.employee_id','st_employee.employee_name')
                ->get()->first();
                if(isset($troGiang))
                $tenTroGiang = $troGiang->employee_name;
                else
                $tenTroGiang="";

                $nhanVien = DB::table('st_class_time')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id','=','st_class_time.classTime_id')
                ->join('st_employee','st_employee.employee_id','=','st_class_time_employee.employee_id')
                ->where('st_class_time.class_id',$item->class_id)
                ->where('classTimeEmployee_type',3)
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

                if($item->class_startDay<=$now)
                {
                    $quaHanCapNhat = 1;
                }
                else
                {
                    $quaHanCapNhat= 0;
                }
                $maLop =$maChiNhanh."_".$item->studyProgram_code."_".$item->course_name."_".$item->class_code;
            
                $arr[]=[
                    'id'=>$item->class_id,
                    'chuongTrinh'=>$item->studyProgram_code,
                    'tenLop'=>$item->class_name,
                    'maLop'=>$maLop,
                    'giaoVien'=>$tenGiaoVien,
                    'troGiang'=>$tenTroGiang,
                    'nhanVien'=>$tenNhanVien,
                    'ngayBatDau'=>date('d/m/Y',strtotime($item->class_startDay)),
                    'ngayKetKhoa'=>date('d/m/Y',strtotime($item->class_endDay)),
                    'siSo'=>count($hocVien),
                    'soBuoiConLai'=>count($buoiHoc),
                    'tinhTrang'=>$trangThai,
                    'xepLich'=>$item->class_statusSchedule,
                    'quaHangCapNhat'=>$quaHanCapNhat
                ];
            }
            return view('LopHoc.lopHoc')
            ->with('lopHoc',$arr)
            ->with('soTrang',$soTrang)
            ->with('page',1)
            ;
        } else {
            return redirect()->back();
        }
    }

    public function searchLopHoc(Request $request)
    {
        if ($request->ajax()) {

            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            $out="";
            if ($value == "")
                $lopHoc = DB::table('view_class')
                ->orderByDesc('class_startDay')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            else
                $lopHoc =DB::table('view_class')
                    ->orderByDesc('class_startDay')
                    ->where('class_name', 'like', '%' . $value . '%')
                    ->orwhere('studyProgram_code', 'like', '%' . $value . '%')
                    ->orwhere('class_code', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                    $i = 1;
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
                            $trangThai = "Canceled";
                        else
                        {
                            if($now < $item->class_startDay)
                                $trangThai="Waiting";
                            else if( $now >= $item->class_startDay && $now <= $item->class_endDay)
                                $trangThai="Opening";
                            else
                                $trangThai="Finished";
                        }
                        if($item->class_startDay<=$now)
                        {
                            $quaHanCapNhat = 1;
                        }
                        else
                        {
                            $quaHanCapNhat= 0;
                        }
                        $out .= '   <td>' . $i . '</td>
                        <td>' . $item->studyProgram_code . '</td>   
                        <td>' . $item->class_code . '</td>';   
                        if(session('quyen71')==1)
                        $out .= '<td><a href="'.route('getHocVienLopHoc').'?id='.$item->class_id.'">' . $item->class_name . '</a></td>';  
                        else
                        $out .= '<td>' . $item->class_name . '</td>';  
                        $out .= '<td>' . date('d/m/Y', strtotime($item->class_startDay)) . '</td>
                        <td>' . date('d/m/Y', strtotime($item->class_endDay)) . '</td>
                        <td>' . count($hocVien). '</td>
                        <td>' . $tenGiaoVien. '</td>
                        <td>' . $tenTroGiang. '</td>
                        <td>' . $tenNhanVien. '</td>
                        <td>' . count($buoiHoc). '</td>
                        <td>' . $trangThai. '</td>
                        ';
                        
                        if (session('quyen63') == 1)
                        {
                            if($quaHanCapNhat==0)
                            {
                                $out .= '<td>
                                <a class="btn" href="'. route('capNhatLopHoc') .'?id='.$item->class_id.'">
                                    <i style="color: blue" class="fa fa-edit"></i>
                                            </a>
                                </td>';
                            }
                            else
                            {
                                $out .= '<td>
                                <a class="btn" onclick="quaHan();">
                                    <i style="color: blue" class="fa fa-edit"></i>
                                            </a>
                                </td>';
                            }
                           
                        }
                         
                        if (session('quyen64') == 1)
                            $out .= '  <td>
                                                <a class="btn" onclick="xoa(\'' .$item->class_id . '\');">
                                                    <i style="color: red" class="fa fa-close"></i>
                                                </a>
                                            </td>';
                        $out .= ' </tr>';
                        $i++;
                    }
                    return response($out);
        }
    }

    public function getThemLopHoc()
    {
        $quyen = new quyenController();
        $quyenXem = $quyen->getThemLopHoc();
        
        if ($quyenXem == 1) {
          
            
            $chuongTrinhHoc = DB::table('st_study_program')
            ->where('branch_id',session('coSo'))
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
            $gioBuoiHoc="02:00";
            if(count($khoaHoc)>0)
            {
                $KHDau = $khoaHoc->first();
                $soGio=$KHDau->course_hours;
                $hocPhi = $KHDau->course_price;
              
            }
            $arrGioKetThuc =[];

            for($i=2;$i<=8;$i++)
            {
                $gioBatDau = "09:00";

                $arrGioKetThuc[]=['gio'=>$this->timGioKetThuc($gioBatDau,$gioBuoiHoc)];
            }


            $phongHoc = DB::table('st_room')
            ->where('branch_id',session('coSo'))
            ->get();
            return view('LopHoc.themLopHoc')
            ->with('chuongTrinhHoc',$chuongTrinhHoc)
            ->with('khoaHoc',$khoaHoc)
            ->with('soGio',$soGio)
            ->with('hocPhi',$hocPhi)
            ->with('phongHoc',$phongHoc)
            ->with('gioBuoiHoc',$gioBuoiHoc)
            ->with('arrGioKetThuc',$arrGioKetThuc)
            ;
        } else {
            return redirect()->back();
        }
    }

    public function timGioKetThuc($gioDau,$gioSau)
    {
        $gio1 = (int)( substr($gioDau, 0, 2)) ;
        $phut1 =(int)(  substr($gioDau,3, 2)) ;

        $gio2 = (int)( substr($gioSau,0, 2)) ;
        $phut2 =(int)(  substr($gioSau,3, 2)) ;

       

        $phut3 = $phut1+$phut2;
        $gio3 = $gio1+ $gio2;

        if($phut3>=60)
        {
            $phut3= $phut3-60;
            $gio3++;
        }
        if($phut3<10)
        {
            $phut3="0".$phut3;
        }
        if($gio3<10)
        {
            $gio3="0".$gio3;
        }
     
        return $gio3.":".$phut3;
    }

    public function capNhatLopHoc(Request $request)
    {
        $quyen = new quyenController();
        $quyenXem = $quyen->getSuaLopHoc();
        
        if ($quyenXem == 1) {
            $id = $request->get('id');
            $lopHoc = DB::table('view_class')
            ->where('class_id',$id)
            ->get()->first();
            $chuongTrinhHoc = DB::table('st_study_program')
            ->where('branch_id',session('coSo'))
            ->orderBy('studyProgram_number')
            ->get();
            $idCT = $lopHoc->studyProgram_id;
            $khoaHoc = DB::table('st_course')
            ->where('studyProgram_id',$idCT)
            ->orderBy('course_number')
            ->get();
            $soGio = 0;
            $hocPhi=0;
            $gioBuoiHoc="00:00";

            $KHDau = DB::table('st_course')
            ->where('course_id',$lopHoc->course_id)
            ->get()->first();
            $soGio=$KHDau->course_hours;
            $hocPhi = $KHDau->course_price;

            $classTimeDefault =DB::table('st_class_time_default')
            ->where('class_id',$id)
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
            $classDay = DB::table('st_class_day')
            ->where('class_id',$id)
            ->get()->first();
            $classTimeDefault =DB::table('st_class_time_default')
            ->where('class_id',$id)
            ->get()->first();
            $arrGioKetThuc []=[
                'gio'=>$classTimeDefault->classTimeDefault_endTime2,
                'batDau'=>$classTimeDefault->classTimeDefault_startTime2
             ];
             $arrGioKetThuc []=[
                'gio'=>$classTimeDefault->classTimeDefault_endTime3,
                'batDau'=>$classTimeDefault->classTimeDefault_startTime3
             ];
             $arrGioKetThuc []=[
                'gio'=>$classTimeDefault->classTimeDefault_endTime4,
                'batDau'=>$classTimeDefault->classTimeDefault_startTime4
             ];
             $arrGioKetThuc []=[
                'gio'=>$classTimeDefault->classTimeDefault_endTime5,
                'batDau'=>$classTimeDefault->classTimeDefault_startTime5
             ];
             $arrGioKetThuc []=[
                'gio'=>$classTimeDefault->classTimeDefault_endTime6,
                'batDau'=>$classTimeDefault->classTimeDefault_startTime6
             ];
             $arrGioKetThuc []=[
                'gio'=>$classTimeDefault->classTimeDefault_endTime7,
                'batDau'=>$classTimeDefault->classTimeDefault_startTime7
             ];
             $arrGioKetThuc []=[
                'gio'=>$classTimeDefault->classTimeDefault_endTime8,
                'batDau'=>$classTimeDefault->classTimeDefault_startTime8
             ];
            
            

            return view('LopHoc.capNhatLopHoc')
            ->with('chuongTrinhHoc',$chuongTrinhHoc)
            ->with('khoaHoc',$khoaHoc)
            ->with('soGio',$soGio)
            ->with('hocPhi',$hocPhi)
            ->with('lopHoc',$lopHoc)
            ->with('classDay',$classDay)
            ->with('classTimeDefault',$classTimeDefault)
            ->with('arrGioKetThuc',$arrGioKetThuc)
            ->with('gioBuoiHoc',$gioBuoiHoc)
            ;
            
        }
        else
        return redirect()->back();
    }

    public function changeCTHThemLop(Request $request)
    {
        if($request->ajax())
        {
            $idCT = $request->get('chuongTrinh');

            $khoaHoc = DB::table('st_course')
            ->where('studyProgram_id',$idCT)
            ->orderBy('course_number')
            ->get();
            $soGio = 0;
            $hocPhi=0;
            $sach="";
            $gioBuoiHoc = "00:00";
            if(count($khoaHoc)>0)
            {
                $KHDau = $khoaHoc->first();
                $soGio=$KHDau->course_hours;
                $hocPhi = $KHDau->course_price;
                $sach = $KHDau->course_material;
                
            }

           $out = ' <select class="form-control"  required id="khoaHoc" name="khoaHoc"  onchange="changeKH();">';
                                        
           foreach($khoaHoc as $item)
           $out .= '<option value="'.$item->course_id.'">'.$item->course_name.'</option>';
           $out .= '</select>';

           $arr[]=[
               'khoaHoc'=>$out,
               'soGio'=>$soGio,
               'hocPhi'=>$hocPhi,
               'sach'=>$sach,
               'gioBuoiHoc'=>$gioBuoiHoc
           ];
           return response($arr);

        }
    }

    public function changeChiNhanhThemLop(Request $request)
    {
        if($request->ajax())
        {
            $chiNhanh = $request->get('chiNhanh');
            $chuongTrinhHoc = DB::table('st_study_program')
            ->where('branch_id',$chiNhanh)
            ->orderBy('studyProgram_number')
            ->get();
            $idCT = 0;
            if(count($chuongTrinhHoc)>0)
            {
                $CTDau = $chuongTrinhHoc->first();
                $idCT= $CTDau->studyProgram_id;
            }
            
            $out2 = ' <select class="form-control"  required id="chuongTrinh" name="chuongTrinh"  onchange="changeCTH();">';
                                        
            foreach($chuongTrinhHoc as $item)
            $out2 .= '<option value="'.$item->studyProgram_id.'">'.$item->studyProgram_name.'</option>';
            $out2 .= '</select>';


            $khoaHoc = DB::table('st_course')
            ->where('studyProgram_id',$idCT)
            ->orderBy('course_number')
            ->get();
            $soGio = 0;
            $hocPhi=0;
            $sach="";
            $gioBuoiHoc = "00:00";
            if(count($khoaHoc)>0)
            {
                $KHDau = $khoaHoc->first();
                $soGio=$KHDau->course_hours;
                $hocPhi = $KHDau->course_price;
                $sach = $KHDau->course_material;
               
            }

           $out = ' <select class="form-control"  required id="khoaHoc" name="khoaHoc"  onchange="changeKH();">';
                                        
           foreach($khoaHoc as $item)
           $out .= '<option value="'.$item->course_id.'">'.$item->course_name.'</option>';
           $out .= '</select>';

           $arr[]=[
               'khoaHoc'=>$out,
               'soGio'=>$soGio,
               'hocPhi'=>$hocPhi,
               'sach'=>$sach,
               'CTH'=>$out2,
               'gioBuoiHoc'=>$gioBuoiHoc
           ];
           return response($arr);

        }
    }

    public function changeKHThemLop(Request $request)
    {
        if($request->ajax())
        {
            $idKH = $request->get('khoaHoc');

            $khoaHoc = DB::table('st_course')
            ->where('course_id',$idKH)
           ->get()->first();
            $soGio = 0;
            $hocPhi=0;
            $sach="";
            $gioBuoiHoc = "00:00";
            if(isset($khoaHoc))
            {
                $soGio=$khoaHoc->course_hours;
                $hocPhi = $khoaHoc->course_price;
                $sach = $khoaHoc->course_material;
               
            }

          

           $arr[]=[
               'soGio'=>$soGio,
               'hocPhi'=>$hocPhi,
               'sach'=>$sach,
               'gioBuoiHoc'=>$gioBuoiHoc
           ];
           return response($arr);

        }
    }
    public function kiemTraLopHoc(Request $request)
    {
        if ($request->ajax())
        {
           
            

           

            $thu= $request->get('thu');
          
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
                    $thuHienTai = $i+1;
                    $dto = new \DateTime();
                    if ($thu[$i]==1)
                    {
                        $gioBatDauThem = $gioBatDauThem1[$i];
                        $gioKetThucThem = $gioKetThucThem1[$i];

                       
                      
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
              
                $tuan++;
               
            }

            
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
        }
    }
    public function postThemLopHoc(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXem = $quyen->getThemLopHoc();
            
            if ($quyenXem == 1) {
                $thu=$request->get('thu');
                $thu2=$thu[0];
                $thu3=$thu[1];
                $thu4=$thu[2];
                $thu5=$thu[3];
                $thu6=$thu[4];
                $thu7=$thu[5];
                $thu8=$thu[6];
                
           
          
         
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
            $gioBatDauThem1 = $request->get('batDau');
            $gioKetThucThem1 = $request->get('ketThuc');
            
            $gioBatDauThem2 = $gioBatDauThem1[0];
            $gioBatDauThem3 = $gioBatDauThem1[1];
            $gioBatDauThem4 = $gioBatDauThem1[2];
            $gioBatDauThem5 = $gioBatDauThem1[3];
            $gioBatDauThem6 = $gioBatDauThem1[4];
            $gioBatDauThem7 = $gioBatDauThem1[5];
            $gioBatDauThem8 = $gioBatDauThem1[6];

            $gioKetThucThem2 = $gioKetThucThem1[0];
            $gioKetThucThem3 = $gioKetThucThem1[1];
            $gioKetThucThem4 = $gioKetThucThem1[2];
            $gioKetThucThem5 = $gioKetThucThem1[3];
            $gioKetThucThem6 = $gioKetThucThem1[4];
            $gioKetThucThem7 = $gioKetThucThem1[5];
            $gioKetThucThem8 = $gioKetThucThem1[6];

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

            // $giaoVien = $request->get('giaoVien'); 
            // $troGiang = $request->get('troGiang');           
            // $nhanVien = $request->get('nhanVien');

            try {

                $khoaHocBatDau = DB::table('st_course')
                ->join('st_study_program','st_study_program.studyProgram_id',
                '=','st_course.studyProgram_id')
                ->where('st_course.course_id', $khoaHoc)
                ->get()->first();


            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $namLop = $now->year;

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
                        $khoaLop = $year . "" . $soLop;
                } else {
                    $soLop = 1;
                    $khoaLop =   $year . "01";
                }

                
                $idLopThem=   DB::table('st_class')
                ->insertGetId([
                    'course_id' => $khoaHoc,
                    'class_name' => $ten,
                    'class_startDay' => $ngayBatDauChinh,
                    'class_endDay' => $ngayKetThucChinh,
                    'class_status' => $trangThai,
                    'class_hours' => $soGio,
                    'class_price' => $hocPhi,
                    'room_id' => 0,
                    'class_code' => $khoaLop,
                    'class_startHouse'=>"00:00",
                    'class_endHouse'=>"00:00",
                    'class_material'=> $khoaHocBatDau->course_material,
                    'branch_id'=>session('coSo'),
                    'class_statusSchedule'=>0
                   
                ]);
                DB::table('st_class_course')
                    ->insert([
                        'course_id' => $khoaHocBatDau->studyProgram_id,
                        'classCourse_year' => $namLop,
                        'classCourse_number' => $soLop
                    ]);
                

                DB::table('st_class_time_default')
                ->insert([
                    'class_id'=>$idLopThem,
                    'classTimeDefault_startTime2'=>$gioBatDauThem2,
                    'classTimeDefault_startTime3'=>$gioBatDauThem3,
                    'classTimeDefault_startTime4'=>$gioBatDauThem4,
                    'classTimeDefault_startTime5'=>$gioBatDauThem5,
                    'classTimeDefault_startTime6'=>$gioBatDauThem6,
                    'classTimeDefault_startTime7'=>$gioBatDauThem7,
                    'classTimeDefault_startTime8'=>$gioBatDauThem8,

                    'classTimeDefault_endTime2'=>$gioKetThucThem2,
                    'classTimeDefault_endTime3'=>$gioKetThucThem3,
                    'classTimeDefault_endTime4'=>$gioKetThucThem4,
                    'classTimeDefault_endTime5'=>$gioKetThucThem5,
                    'classTimeDefault_endTime6'=>$gioKetThucThem6,
                    'classTimeDefault_endTime7'=>$gioKetThucThem7,
                    'classTimeDefault_endTime8'=>$gioKetThucThem8,

                ])        ;

                $noiDung = DB::table('st_pacing_guide')
                ->where('course_id',$khoaHoc)
                ->get();
                    $buoiHoc=0;
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
                                
                                if(strtolower($noiDungBuoiHoc)=="midterm")
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
    
                                        DB::table('st_class_time')
                                            ->insert([
                                                'class_id'=>$idLopThem,
                                                'classTime_startDate'=>$thoigianBatDau,
                                                'classTime_endDate'=>$thoigianKetThuc,
                                                'classTime_status'=>1,
                                                'classTime_type'=>$type,
                                                'classTime_title'=>$noiDungBuoiHoc,
    
                                                'room_id'=>0
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

    public function postCapNhatLopHoc(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXem = $quyen->getSuaLopHoc();
            
            if ($quyenXem == 1) {
                $idLopThem = $request->get('id');
                $thu=$request->get('thu');
                $thu2=$thu[0];
                $thu3=$thu[1];
                $thu4=$thu[2];
                $thu5=$thu[3];
                $thu6=$thu[4];
                $thu7=$thu[5];
                $thu8=$thu[6];
                
           
          
         
             $thoiGianBatDau = $request->get('ngayBatDau');
            $thoiGianKetThuc = $request->get('ngayKetThuc');
            $soGio = $request->get('soGio');
         
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
            $gioBatDauThem1 = $request->get('batDau');
            $gioKetThucThem1 = $request->get('ketThuc');

            $gioBatDauThem2 = $gioBatDauThem1[0];
            $gioBatDauThem3 = $gioBatDauThem1[1];
            $gioBatDauThem4 = $gioBatDauThem1[2];
            $gioBatDauThem5 = $gioBatDauThem1[3];
            $gioBatDauThem6 = $gioBatDauThem1[4];
            $gioBatDauThem7 = $gioBatDauThem1[5];
            $gioBatDauThem8 = $gioBatDauThem1[6];

            $gioKetThucThem2 = $gioKetThucThem1[0];
            $gioKetThucThem3 = $gioKetThucThem1[1];
            $gioKetThucThem4 = $gioKetThucThem1[2];
            $gioKetThucThem5 = $gioKetThucThem1[3];
            $gioKetThucThem6 = $gioKetThucThem1[4];
            $gioKetThucThem7 = $gioKetThucThem1[5];
            $gioKetThucThem8 = $gioKetThucThem1[6];


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

           

            try {

                $khoaHocBatDau = DB::table('st_course')
                ->join('st_study_program','st_study_program.studyProgram_id',
                '=','st_course.studyProgram_id')
                ->where('st_course.course_id', $khoaHoc)
                ->get()->first();


                $now = Carbon::now('Asia/Ho_Chi_Minh');
                $namLop = $now->year;

                $lopChinh =  DB::table('st_class')
                ->where('class_id',$idLopThem)
                ->get()->first();

                
             
              
                DB::table('st_class_time_default')
                ->where('class_id',$idLopThem)
                ->update([
                    'classTimeDefault_startTime2'=>$gioBatDauThem2,
                    'classTimeDefault_startTime3'=>$gioBatDauThem3,
                    'classTimeDefault_startTime4'=>$gioBatDauThem4,
                    'classTimeDefault_startTime5'=>$gioBatDauThem5,
                    'classTimeDefault_startTime6'=>$gioBatDauThem6,
                    'classTimeDefault_startTime7'=>$gioBatDauThem7,
                    'classTimeDefault_startTime8'=>$gioBatDauThem8,

                    'classTimeDefault_endTime2'=>$gioKetThucThem2,
                    'classTimeDefault_endTime3'=>$gioKetThucThem3,
                    'classTimeDefault_endTime4'=>$gioKetThucThem4,
                    'classTimeDefault_endTime5'=>$gioKetThucThem5,
                    'classTimeDefault_endTime6'=>$gioKetThucThem6,
                    'classTimeDefault_endTime7'=>$gioKetThucThem7,
                    'classTimeDefault_endTime8'=>$gioKetThucThem8,
                ]);
                
                if($lopChinh->class_statusSchedule==0)
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
                        'class_startHouse'=>"00:00",
                        'class_endHouse'=>"00:00",
                        'class_material'=> $khoaHocBatDau->course_material,
                    ]);
                    DB::table('st_class_time')
                    ->where('class_id',$idLopThem)
                    ->delete();
                   
                    $noiDung = DB::table('st_pacing_guide')
                    ->where('course_id',$khoaHoc)
                    ->get();
                    $buoiHoc=0;
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
                                    
                                    if(strtolower($noiDungBuoiHoc)=="midterm")
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
    
                                        DB::table('st_class_time')
                                            ->insert([
                                                'class_id'=>$idLopThem,
                                                'classTime_startDate'=>$thoigianBatDau,
                                                'classTime_endDate'=>$thoigianKetThuc,
                                                'classTime_status'=>1,
                                                'classTime_type'=>$type,
                                                'classTime_title'=>$noiDungBuoiHoc,
    
                                                'room_id'=>0
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

                }
                else
                {
                    DB::table('st_class')
                    ->where('class_id',$idLopThem)
                    ->update([                       
                        'class_name' => $ten,                     
                        'class_status' => $trangThai,              
                        'class_price' => $hocPhi,
                        'class_material'=> $khoaHocBatDau->course_material,
                    ]);
                }

                    DB::table('st_class_day')
                    ->where('class_id',$idLopThem)
                        ->update([
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


    public function getXoaLopHoc(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXem = $quyen->getSuaLopHoc();
            
            if ($quyenXem == 1) {
                $id = $request->get('id');
                DB::table('st_class_time_default')
                ->where('class_id',$id)
                ->delete();
                DB::table('st_class_day')
                ->where('class_id',$id)
                ->delete();
                DB::table('st_class_student')
                ->where('class_id',$id)
                ->delete();
                

                DB::table('st_class_student')
                ->where('class_id',$id)
                ->delete();

                $classTime = DB::table('st_class_time')
                ->where('class_id',$id)->get();

                foreach($classTime as $item)
                {
                    DB::table('st_class_time_employee')
                    ->where('classTime_id',$item->classTime_id)
                    ->delete();
                    DB::table('st_class_time_student')
                    ->where('classTime_id',$item->classTime_id)
                    ->delete();
                }
                DB::table('st_class_time')
                ->where('class_id',$id)
                ->delete();
                $phieuThu = DB::table('st_receipt_detail')
                ->where('class_id',$id)
                ->get()->first();

                if(isset($phieuThu))
                {
                    DB::table('st_receipt_detail')
                    ->where('receiptDeatil_id',$phieuThu->receiptDeatil_id)
                    ->update([
                        'class_id'=>0
                    ]);
                }
                DB::table('st_class')
                ->where('class_id',$id)
                ->delete();

                return response(1);
            }
            else
            {
                return response(2);
            }
        }
    }
}
