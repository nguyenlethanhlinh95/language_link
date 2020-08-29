<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class xepLichNhanVienController extends Controller
{
    public function getNhanVienLich()
    {

        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichNhanVien();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $nhanVien = DB::table('st_employee')
            ->join('st_branch','st_branch.branch_id',
            '=','st_employee.branch_id')
            ->take($lay)
            ->skip(0)
            ->get();
            $nhanVienTong = DB::table('st_employee')
            ->join('st_branch','st_branch.branch_id',
            '=','st_employee.branch_id')
            ->select('st_employee.employee_id')
            ->get();
            $soKM = count($nhanVienTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;

                $chiNhanh = DB::table('st_branch')
                ->get();
            return view('XepLichLopHoc.nhanVien')
                ->with('nhanVien',$nhanVien)
                ->with('soTrang', $soTrang)
                ->with('chiNhanh', $chiNhanh)
                ->with('page', 1)
                ;
        }
        else
        {
            return redirect()->back();
        }
       
    }
    public function kiemTraLe($date)
    {
       $ngayLe=  DB::table('st_holiday')
        ->where('holiday_day',substr($date,8,2))
        ->where('holiday_month',substr($date,5,2))
        ->get()->first();
        if(isset($ngayLe))
        {
            return $ngayLe->holiday_name;
        }
        else
        {
            return "";
        }
    }
    public function getLichNhanVien(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichNhanVien();
        if($quyenChiTiet==1)
        {
            $idNhanVien = $request->get('id');
            $giaoVienChinh = DB::table('st_employee')
            ->where('employee_id',$idNhanVien)
            ->get()->first();
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $tuan = $now->week();
            $dto = new \DateTime();
            $dto->setISODate($now->year,$tuan);
            $ngayBatDauChinh = $dto->format('Y-m-d');
            $dto->modify('+1 days');
            $ngayThu3 = $dto->format('Y-m-d');

            $dto->modify('+1 days');
            $ngayThu4 = $dto->format('Y-m-d');
            $dto->modify('+1 days');
            $ngayThu5 = $dto->format('Y-m-d');
            $dto->modify('+1 days');
            $ngayThu6 = $dto->format('Y-m-d');
            $dto->modify('+1 days');
            $ngayThu7 = $dto->format('Y-m-d');
            $dto->modify('+1 days');
            $ngayKetThucChinh = $dto->format('Y-m-d');

            $ngayLe2 = $this->kiemTraLe($ngayBatDauChinh);
            $ngayLe3 = $this->kiemTraLe($ngayThu3);
            $ngayLe4 = $this->kiemTraLe($ngayThu4);
            $ngayLe5 = $this->kiemTraLe($ngayThu5);
            $ngayLe6 = $this->kiemTraLe($ngayThu6);
            $ngayLe7 = $this->kiemTraLe($ngayThu7);
            $ngayLe8 = $this->kiemTraLe($ngayKetThucChinh);
           





            $gioThu2=0;
            $gioThu3=0;
            $gioThu4=0;
            $gioThu5=0;
            $gioThu6=0;
            $gioThu7=0;
            $gioThu8=0;
            $PhutThu2=0;
            $PhutThu3=0;
            $PhutThu4=0;
            $PhutThu5=0;
            $PhutThu6=0;
            $PhutThu7=0;
            $PhutThu8=0;
            // $giaoVien = DB::table('st_employee')
            //     ->where('employee_id',$idNhanVien)
            //     ->get()->first();

            $danhSachLop = DB::table('st_class_time')
                ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                '=','st_class_time.classTime_id')
                ->where('st_class_time_employee.employee_id',$idNhanVien)
                ->whereDate('st_class_time.classTime_startDate','>=',$ngayBatDauChinh)
                ->whereDate('st_class_time.classTime_startDate','<=',$ngayKetThucChinh)
                ->get();

            $arrLop=[];
            foreach ($danhSachLop as $item)
            {
                $checkLop=0;
                foreach ($arrLop as $itemLop)
                {
                    if ($itemLop['idLop']== $item->class_id)
                    {
                        $checkLop=1;
                        break;
                    }
                }
                if ($checkLop==0)
                {
                    $chiNhanh = DB::table('st_branch')
                        ->join('st_room','st_room.branch_id','=',
                            'st_branch.branch_id')
                        ->where('st_room.room_id',$item->room_id)
                        ->select('st_branch.*','st_room.room_name')
                        ->get()->first();
                    $hocVien = DB::table('st_class_student')
                        ->where('class_id',$item->class_id)
                        ->select('class_id')->get();
                    $mid= DB::table('st_class_time')
                        ->where('classTime_type',2)
                        ->where('class_id',$item->class_id)
                        ->get()->first();
                    if (isset($mid))
                        $midText = date('M.d',strtotime($mid->classTime_startDate));
                    else
                        $midText="";

                    $final= DB::table('st_class_time')
                        ->where('classTime_type',3)
                        ->where('class_id',$item->class_id)
                        ->get()->first();
                    if (isset($final))
                        $finalText = date('M.d',strtotime($final->classTime_startDate));
                    else
                        $finalText="";
                    $arrLop[]=[
                        'idLop'=>$item->class_id,
                        'chiNhanh'=>$chiNhanh->branch_code,
                        'TimeStart'=> $item->class_startHouse,
                        'TimeEnd'=>$item->class_endHouse,
                        'tenLop'=>$item->class_name,
                        'siSo'=>count($hocVien),
                        'phong'=>$chiNhanh->room_name,
                        'Material'=>"",
                        'ngayBatDau'=>date('M.d',strtotime($item->class_startDay)) ,
                        'ngayKetThuc'=>date('M.d',strtotime($item->class_endDay)),
                        'mid'=>$midText,
                        'final'=>$finalText
                    ];
                }
            }
            $arrLich = [];
            foreach ($arrLop as $item)
            {
                $troGiang2 = "";
                $noiDung2="";

                $troGiang3 = "";
                $noiDung3="";

                $troGiang4 = "";
                $noiDung4="";

                $troGiang5 = "";
                $noiDung5="";

                $troGiang6 = "";
                $noiDung6="";

                $troGiang7 = "";
                $noiDung7="";

                $troGiang8 = "";
                $noiDung8="";
                $giaoVien2="";
                $giaoVien3="";
                $giaoVien4="";
                $giaoVien5="";
                $giaoVien6="";
                $giaoVien7="";
                $giaoVien8="";
               
              
                foreach ($danhSachLop as $item1)
                {
                    $ngay = date('Y-m-d',strtotime($item1->classTime_startDate));
                   
                    $giaoVien = DB::table('st_class_time')
                        ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                        '=','st_class_time.classTime_id')
                        ->join('st_employee','st_employee.employee_id',
                        '=','st_class_time_employee.employee_id')
                        ->where('st_class_time.classTime_id',$item1->classTime_id)
                        ->where('st_class_time_employee.classTimeEmployee_type',1)
                        ->select('st_employee.employee_id','st_employee.employee_name')
                        ->get()->first();

                        $troGiang =DB::table('st_class_time')
                        ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                        '=','st_class_time.classTime_id')
                        ->join('st_employee','st_employee.employee_id',
                        '=','st_class_time_employee.employee_id')
                        ->where('st_class_time.classTime_id',$item1->classTime_id)
                        ->where('st_class_time_employee.classTimeEmployee_type',2)
                        ->select('st_employee.employee_id','st_employee.employee_name')
                        ->get()->first();
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayBatDauChinh)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung2="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung2="Final Test";
                        }
                        else
                            $noiDung2=$item1->classTime_title;

                       
                      

                        if (isset($troGiang))
                            $troGiang2="TA.". $troGiang->employee_name;
                        $giaoVien2=$giaoVien->employee_name;
                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu2+= $phutKetThuc-$phutBatDau;
                            $gioThu2+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu2+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu2+=$gioKetThuc-$gioBatDau-1;
                        }
                    }
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayThu3)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung3="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung3="Final Test";
                        }
                        else
                            $noiDung3=$item1->classTime_title;

                           
                    
                        if (isset($troGiang))
                            $troGiang3="TA.". $troGiang->employee_name;
                        $giaoVien3=$giaoVien->employee_name;


                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu3+= $phutKetThuc-$phutBatDau;
                            $gioThu3+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu3+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu3+=$gioKetThuc-$gioBatDau-1;
                        }
                    }
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayThu4)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung4="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung4="Final Test";
                        }
                        else
                            $noiDung4=$item1->classTime_title;

                           

                    
                        if (isset($troGiang))
                            $troGiang4="TA.". $troGiang->employee_name;



                        $giaoVien4=$giaoVien->employee_name;
                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu4+= $phutKetThuc-$phutBatDau;
                            $gioThu4+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu4+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu4+=$gioKetThuc-$gioBatDau-1;
                        }
                    }
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayThu5)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung5="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung5="Final Test";
                        }
                        else
                            $noiDung5=$item1->classTime_title;
                    
                        if (isset($troGiang))
                            $troGiang5="TA.". $troGiang->employee_name;


                        $giaoVien5=$giaoVien->employee_name;
                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu5+= $phutKetThuc-$phutBatDau;
                            $gioThu5+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu5+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu5+=$gioKetThuc-$gioBatDau-1;
                        }

                    }
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayThu6)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung6="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung6="Final Test";
                        }
                        else
                        $noiDung5=$item1->classTime_title;

                       


                        if (isset($troGiang))
                            $troGiang6="TA.". $troGiang->employee_name;

                        $giaoVien6=$giaoVien->employee_name;
                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu6+= $phutKetThuc-$phutBatDau;
                            $gioThu6+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu6+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu6+=$gioKetThuc-$gioBatDau-1;
                        }
                    }
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayThu7)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung7="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung7="Final Test";
                        }
                        else
                            $noiDung7=$item1->classTime_title;
                    
                        


                        if (isset($troGiang))
                            $troGiang7="TA.". $troGiang->employee_name;

                        $giaoVien7=$giaoVien->employee_name;
                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu7+= $phutKetThuc-$phutBatDau;
                            $gioThu7+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu7+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu7+=$gioKetThuc-$gioBatDau-1;
                        }
                    }
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayKetThucChinh)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung8="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung8="Final Test";
                        }
                        else
                            $noiDung8=$item1->classTime_title;
                    

                          

                        if (isset($troGiang))
                            $troGiang8="TA.". $troGiang->employee_name;
                        $giaoVien8=$giaoVien->employee_name;
                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu8+= $phutKetThuc-$phutBatDau;
                            $gioThu8+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu8+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu8+=$gioKetThuc-$gioBatDau-1;
                        }
                    }
                }

                $arrLich[]=[
                    'giaoVien2'=>$giaoVien2,
                    'noiDung2'=>$noiDung2,
                    'troGiang2'=>$troGiang2,
                    'giaoVien3'=>$giaoVien3,
                    'noiDung3'=>$noiDung3,
                    'troGiang3'=>$troGiang3,
                    'giaoVien4'=>$giaoVien4,
                    'noiDung4'=>$noiDung4,
                    'troGiang4'=>$troGiang4,
                    'giaoVien5'=>$giaoVien5,
                    'noiDung5'=>$noiDung5,
                    'troGiang5'=>$troGiang5,
                    'giaoVien6'=>$giaoVien6,
                    'noiDung6'=>$noiDung6,
                    'troGiang6'=>$troGiang6,
                    'giaoVien7'=>$giaoVien7,
                    'noiDung7'=>$noiDung7,
                    'troGiang7'=>$troGiang7,
                    'giaoVien8'=>$giaoVien8,
                    'noiDung8'=>$noiDung8,
                    'troGiang8'=>$troGiang8
                ];
            }
            $tongGio = $gioThu2+$gioThu3+$gioThu4+$gioThu5+$gioThu6+$gioThu7+$gioThu8;

            return view('XepLichLopHoc.chiTietLichNhanVien')
            ->with('ngayBatDauChinh',$ngayBatDauChinh)
            ->with('ngayThu3',$ngayThu3)
            ->with('ngayThu4',$ngayThu4)
            ->with('ngayThu5',$ngayThu5)
            ->with('ngayThu6',$ngayThu6)
            ->with('ngayThu7',$ngayThu7)
            ->with('ngayKetThucChinh',$ngayKetThucChinh)
            ->with('giaoVien',$giaoVienChinh)
            ->with('lop',$arrLop)
            ->with('lich',$arrLich)
            ->with('danhSachLop',count($danhSachLop))
            ->with('gioThu2',$gioThu2)
            ->with('gioThu3',$gioThu3)
            ->with('gioThu4',$gioThu4)
            ->with('gioThu5',$gioThu5)
            ->with('gioThu6',$gioThu6)
            ->with('gioThu7',$gioThu7)
            ->with('gioThu8',$gioThu8)
            ->with('tongGio',$tongGio)
            ->with('ngayLe2',$ngayLe2)
            ->with('ngayLe3',$ngayLe3)
            ->with('ngayLe4',$ngayLe4)
            ->with('ngayLe5',$ngayLe5)
            ->with('ngayLe6',$ngayLe6)
            ->with('ngayLe7',$ngayLe7)
            ->with('ngayLe8',$ngayLe8)
            ->with('tuan',$tuan)

            ;
        }
        else
        return redirect()->back();
    }


    public function getLichNhanVientuan(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichNhanVien();
        if($quyenChiTiet==1)
        {
            $idNhanVien = $request->get('id');
            $giaoVienChinh = DB::table('st_employee')
            ->where('employee_id',$idNhanVien)
            ->get()->first();
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $tuan = $request->get('tuan');;
            $dto = new \DateTime();
            $dto->setISODate($now->year,$tuan);
            $ngayBatDauChinh = $dto->format('Y-m-d');
            $dto->modify('+1 days');
            $ngayThu3 = $dto->format('Y-m-d');
            $dto->modify('+1 days');
            $ngayThu4 = $dto->format('Y-m-d');
            $dto->modify('+1 days');
            $ngayThu5 = $dto->format('Y-m-d');
            $dto->modify('+1 days');
            $ngayThu6 = $dto->format('Y-m-d');
            $dto->modify('+1 days');
            $ngayThu7 = $dto->format('Y-m-d');
            $dto->modify('+1 days');
            $ngayKetThucChinh = $dto->format('Y-m-d');

            $ngayLe2 = $this->kiemTraLe($ngayBatDauChinh);
            $ngayLe3 = $this->kiemTraLe($ngayThu3);
            $ngayLe4 = $this->kiemTraLe($ngayThu4);
            $ngayLe5 = $this->kiemTraLe($ngayThu5);
            $ngayLe6 = $this->kiemTraLe($ngayThu6);
            $ngayLe7 = $this->kiemTraLe($ngayThu7);
            $ngayLe8 = $this->kiemTraLe($ngayKetThucChinh);

            $gioThu2=0;
            $gioThu3=0;
            $gioThu4=0;
            $gioThu5=0;
            $gioThu6=0;
            $gioThu7=0;
            $gioThu8=0;
            $PhutThu2=0;
            $PhutThu3=0;
            $PhutThu4=0;
            $PhutThu5=0;
            $PhutThu6=0;
            $PhutThu7=0;
            $PhutThu8=0;
            // $giaoVien = DB::table('st_employee')
            //     ->where('employee_id',$idNhanVien)
            //     ->get()->first();

            $danhSachLop = DB::table('st_class_time')
                ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                '=','st_class_time.classTime_id')
                ->where('st_class_time_employee.employee_id',$idNhanVien)
                ->whereDate('st_class_time.classTime_startDate','>=',$ngayBatDauChinh)
                ->whereDate('st_class_time.classTime_startDate','<=',$ngayKetThucChinh)
                ->get();

            $arrLop=[];
            foreach ($danhSachLop as $item)
            {
                $checkLop=0;
                foreach ($arrLop as $itemLop)
                {
                    if ($itemLop['idLop']== $item->class_id)
                    {
                        $checkLop=1;
                        break;
                    }
                }
                if ($checkLop==0)
                {
                    $chiNhanh = DB::table('st_branch')
                        ->join('st_room','st_room.branch_id','=',
                            'st_branch.branch_id')
                        ->where('st_room.room_id',$item->room_id)
                        ->select('st_branch.*','st_room.room_name')
                        ->get()->first();
                    $hocVien = DB::table('st_class_student')
                        ->where('class_id',$item->class_id)
                        ->select('class_id')->get();
                    $mid= DB::table('st_class_time')
                        ->where('classTime_type',2)
                        ->where('class_id',$item->class_id)
                        ->get()->first();
                    if (isset($mid))
                        $midText = date('M.d',strtotime($mid->classTime_startDate));
                    else
                        $midText="";

                    $final= DB::table('st_class_time')
                        ->where('classTime_type',3)
                        ->where('class_id',$item->class_id)
                        ->get()->first();
                    if (isset($final))
                        $finalText = date('M.d',strtotime($final->classTime_startDate));
                    else
                        $finalText="";
                    $arrLop[]=[
                        'idLop'=>$item->class_id,
                        'chiNhanh'=>$chiNhanh->branch_code,
                        'TimeStart'=> $item->class_startHouse,
                        'TimeEnd'=>$item->class_endHouse,
                        'tenLop'=>$item->class_name,
                        'siSo'=>count($hocVien),
                        'phong'=>$chiNhanh->room_name,
                        'Material'=>"",
                        'ngayBatDau'=>date('M.d',strtotime($item->class_startDay)) ,
                        'ngayKetThuc'=>date('M.d',strtotime($item->class_endDay)),
                        'mid'=>$midText,
                        'final'=>$finalText
                    ];
                }
            }
            $arrLich = [];
            foreach ($arrLop as $item)
            {
                $troGiang2 = "";
                $noiDung2="";

                $troGiang3 = "";
                $noiDung3="";

                $troGiang4 = "";
                $noiDung4="";

                $troGiang5 = "";
                $noiDung5="";

                $troGiang6 = "";
                $noiDung6="";

                $troGiang7 = "";
                $noiDung7="";

                $troGiang8 = "";
                $noiDung8="";
                $giaoVien2="";
                $giaoVien3="";
                $giaoVien4="";
                $giaoVien5="";
                $giaoVien6="";
                $giaoVien7="";
                $giaoVien8="";
                foreach ($danhSachLop as $item1)
                {
                    $ngay = date('Y-m-d',strtotime($item1->classTime_startDate));

                    $giaoVien = DB::table('st_class_time')
                        ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                        '=','st_class_time.classTime_id')
                        ->join('st_employee','st_employee.employee_id',
                        '=','st_class_time_employee.employee_id')
                        ->where('st_class_time.classTime_id',$item1->classTime_id)
                        ->where('st_class_time_employee.classTimeEmployee_type',1)
                        ->select('st_employee.employee_id','st_employee.employee_name')
                        ->get()->first();

                        $troGiang =DB::table('st_class_time')
                        ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                        '=','st_class_time.classTime_id')
                        ->join('st_employee','st_employee.employee_id',
                        '=','st_class_time_employee.employee_id')
                        ->where('st_class_time.classTime_id',$item1->classTime_id)
                        ->where('st_class_time_employee.classTimeEmployee_type',2)
                        ->select('st_employee.employee_id','st_employee.employee_name')
                        ->get()->first();
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayBatDauChinh)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung2="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung2="Final Test";
                        }
                        else
                            $noiDung2=$item1->classTime_title;

                        

                        if (isset($troGiang))
                            $troGiang2="TA.". $troGiang->employee_name;
                        $giaoVien2=$giaoVien->employee_name;
                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu2+= $phutKetThuc-$phutBatDau;
                            $gioThu2+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu2+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu2+=$gioKetThuc-$gioBatDau-1;
                        }
                    }
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayThu3)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung3="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung3="Final Test";
                        }
                        else
                            $noiDung3=$item1->classTime_title;

                            
                    
                        if (isset($troGiang))
                            $troGiang3="TA.". $troGiang->employee_name;
                        $giaoVien3=$giaoVien->employee_name;


                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu3+= $phutKetThuc-$phutBatDau;
                            $gioThu3+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu3+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu3+=$gioKetThuc-$gioBatDau-1;
                        }
                    }
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayThu4)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung4="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung4="Final Test";
                        }
                        else
                            $noiDung4=$item1->classTime_title;



                    
                        if (isset($troGiang))
                            $troGiang4="TA.". $troGiang->employee_name;



                        $giaoVien4=$giaoVien->employee_name;
                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu4+= $phutKetThuc-$phutBatDau;
                            $gioThu4+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu4+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu4+=$gioKetThuc-$gioBatDau-1;
                        }
                    }
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayThu5)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung5="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung5="Final Test";
                        }
                        else
                            $noiDung5=$item1->classTime_title;
                    
                        if (isset($troGiang))
                            $troGiang5="TA.". $troGiang->employee_name;

                        $giaoVien5=$giaoVien->employee_name;
                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu5+= $phutKetThuc-$phutBatDau;
                            $gioThu5+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu5+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu5+=$gioKetThuc-$gioBatDau-1;
                        }

                    }
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayThu6)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung6="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung6="Final Test";
                        }
                        else
                        
                        if (isset($troGiang))
                            $troGiang6="TA.". $troGiang->employee_name;

                        $giaoVien6=$giaoVien->employee_name;
                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu6+= $phutKetThuc-$phutBatDau;
                            $gioThu6+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu6+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu6+=$gioKetThuc-$gioBatDau-1;
                        }
                    }
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayThu7)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung7="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung7="Final Test";
                        }
                        else
                            $noiDung7=$item1->classTime_title;
                    
                        if (isset($troGiang))
                            $troGiang7="TA.". $troGiang->employee_name;

                        $giaoVien7=$giaoVien->employee_name;
                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu7+= $phutKetThuc-$phutBatDau;
                            $gioThu7+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu7+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu7+=$gioKetThuc-$gioBatDau-1;
                        }
                    }
                    if ($item1->class_id==$item['idLop'] && $ngay==$ngayKetThucChinh)
                    {
                        if ($item1->classTime_type==2)
                        {
                            $noiDung8="middle Test";
                        }
                        elseif ($item1->classTime_type==3)
                        {
                            $noiDung8="Final Test";
                        }
                        else
                            $noiDung8=$item1->classTime_title;
                    
                        if (isset($troGiang))
                            $troGiang8="TA.". $troGiang->employee_name;
                        $giaoVien8=$giaoVien->employee_name;
                        $gioBatDau = substr($item['TimeStart'],0,2);
                        $phutBatDau = substr($item['TimeStart'],3,2);
                        $gioKetThuc = substr($item['TimeEnd'],0,2);
                        $phutKetThuc = substr($item['TimeEnd'],3,2);

                        if ($phutKetThuc>=$phutBatDau)
                        {
                            $PhutThu8+= $phutKetThuc-$phutBatDau;
                            $gioThu8+=$gioKetThuc-$gioBatDau;
                        }
                        else
                        {
                            $PhutThu8+=60+ $phutKetThuc-$phutBatDau;
                            $gioThu8+=$gioKetThuc-$gioBatDau-1;
                        }
                    }
                }

                $arrLich[]=[
                    'giaoVien2'=>$giaoVien2,
                    'noiDung2'=>$noiDung2,
                    'troGiang2'=>$troGiang2,
                    'giaoVien3'=>$giaoVien3,
                    'noiDung3'=>$noiDung3,
                    'troGiang3'=>$troGiang3,
                    'giaoVien4'=>$giaoVien4,
                    'noiDung4'=>$noiDung4,
                    'troGiang4'=>$troGiang4,
                    'giaoVien5'=>$giaoVien5,
                    'noiDung5'=>$noiDung5,
                    'troGiang5'=>$troGiang5,
                    'giaoVien6'=>$giaoVien6,
                    'noiDung6'=>$noiDung6,
                    'troGiang6'=>$troGiang6,
                    'giaoVien7'=>$giaoVien7,
                    'noiDung7'=>$noiDung7,
                    'troGiang7'=>$troGiang7,
                    'giaoVien8'=>$giaoVien8,
                    'noiDung8'=>$noiDung8,
                    'troGiang8'=>$troGiang8
                ];
            }
            $tongGio = $gioThu2+$gioThu3+$gioThu4+$gioThu5+$gioThu6+$gioThu7+$gioThu8;

            return view('XepLichLopHoc.chiTietLichNhanVien')
            ->with('ngayBatDauChinh',$ngayBatDauChinh)
            ->with('ngayThu3',$ngayThu3)
            ->with('ngayThu4',$ngayThu4)
            ->with('ngayThu5',$ngayThu5)
            ->with('ngayThu6',$ngayThu6)
            ->with('ngayThu7',$ngayThu7)
            ->with('ngayKetThucChinh',$ngayKetThucChinh)
            ->with('giaoVien',$giaoVienChinh)
            ->with('lop',$arrLop)
            ->with('lich',$arrLich)
            ->with('danhSachLop',count($danhSachLop))
            ->with('gioThu2',$gioThu2)
            ->with('gioThu3',$gioThu3)
            ->with('gioThu4',$gioThu4)
            ->with('gioThu5',$gioThu5)
            ->with('gioThu6',$gioThu6)
            ->with('gioThu7',$gioThu7)
            ->with('gioThu8',$gioThu8)
            ->with('tongGio',$tongGio)
            ->with('ngayLe2',$ngayLe2)
            ->with('ngayLe3',$ngayLe3)
            ->with('ngayLe4',$ngayLe4)
            ->with('ngayLe5',$ngayLe5)
            ->with('ngayLe6',$ngayLe6)
            ->with('ngayLe7',$ngayLe7)
            ->with('ngayLe8',$ngayLe8)
            ->with('tuan',$tuan)
            ;
        }
        else
        return redirect()->back();
    }


    public function getGioLamGiaoVien(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichNhanVien();
        if($quyenChiTiet==1)
        {
        $idNhanVien = $request->get('id');
     
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $tuan = $now->week();
        $dto = new \DateTime();
        $dto->setISODate($now->year,$tuan);
        $ngayBatDauChinh = $dto->format('Y-m-d');
        $dto->modify('+1 days');
        $ngayThu3 = $dto->format('Y-m-d');
        $dto->modify('+1 days');
        $ngayThu4 = $dto->format('Y-m-d');
        $dto->modify('+1 days');
        $ngayThu5 = $dto->format('Y-m-d');
        $dto->modify('+1 days');
        $ngayThu6 = $dto->format('Y-m-d');
        $dto->modify('+1 days');
        $ngayThu7 = $dto->format('Y-m-d');
        $dto->modify('+1 days');
        $ngayKetThucChinh = $dto->format('Y-m-d');

        $giaoVien = DB::table('st_employee')
            ->where('employee_id',$idNhanVien)
            ->get()->first();
        $lich  = DB::table('st_class_time')
            ->join('st_class','st_class.class_id','=',
                'st_class_time.class_id')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                '=','st_class_time.classTime_id')
            ->join('st_branch','st_branch.branch_id','=','st_class.branch_id')
            ->where('st_class_time_employee.employee_id',$idNhanVien)
            ->whereDate('classTime_startDate','>=',$ngayBatDauChinh)
            ->whereDate('classTime_startDate','<=',$ngayKetThucChinh)
            ->get();
        $arrGioLamViec =[];
        $tongGio=0;
        foreach ($lich as $item)
        {
            $gioBatDau = substr($item->classTime_startDate,11,2);
            $phutBatDau = substr($item->classTime_startDate,14,2);
            $gioKetThuc = substr($item->classTime_endDate,11,2);
            $phutKetThuc = substr($item->classTime_endDate,14,2);

            if ($phutKetThuc>=$phutBatDau)
            {
                $PhutThu= $phutKetThuc-$phutBatDau;
                $gioThu=$gioKetThuc-$gioBatDau;
            }
            else
            {
                $PhutThu=60+ $phutKetThuc-$phutBatDau;
                $gioThu=$gioKetThuc-$gioBatDau-1;
            }
            $arrGioLamViec[]=[
                'dateStart'=>$item->classTime_startDate,
                'dateEnd'=>$item->classTime_endDate,
                'tenLop'=>$item->class_name,
                'gio'=>$gioThu,
                'chiNhanh'=>$item->branch_code
            ];
            $tongGio+=$gioThu;
        }

        return view('XepLichLopHoc.gioLamViecGiaoVien')
            ->with('giaoVien',$giaoVien)
            ->with('ngayBatDauChinh',$ngayBatDauChinh)
            ->with('ngayKetThucChinh',$ngayKetThucChinh)
            ->with('arrGioLamViec',$arrGioLamViec)
            ->with('tongGio',$tongGio)
            ->with('idNhanVien',$idNhanVien )
            ;
        }
        else
        return redirect()->back();
    }

public function postTimGioGiaoVien(Request $request)
{
    $quyen = new quyenController();
    $quyenChiTiet = $quyen->getXepLichNhanVien();
    if($quyenChiTiet==1)
    {
    $idNhanVien = $request->get('id');
    $thoiGian = $request->get('thoiGian');
    $ngay1= substr($thoiGian,3,2);
    $thang1= substr($thoiGian,0,2);
    $nam1= substr($thoiGian,6,4);

    $ngay2= substr($thoiGian,16,2);
    $thang2= substr($thoiGian,13,2);
    $nam2= substr($thoiGian,19,4);

    $ngayBatDauChinh = new Carbon($nam1."-".$thang1."-".$ngay1);
    $ngayKetThucChinh = new Carbon($nam2."-".$thang2."-".$ngay2);
    $giaoVien = DB::table('st_employee')
        ->where('employee_id',$idNhanVien)
        ->get()->first();
    $lich  = DB::table('st_class_time')
        ->join('st_class','st_class.class_id','=',
            'st_class_time.class_id')
            ->join('st_class_time_employee','st_class_time_employee.classTime_id',
            '=','st_class_time.classTime_id')
        ->join('st_branch','st_branch.branch_id','=','st_class.branch_id')
        ->where('st_class_time_employee.employee_id',$idNhanVien)
        ->whereDate('classTime_startDate','>=',$ngayBatDauChinh)
        ->whereDate('classTime_startDate','<=',$ngayKetThucChinh)
        ->get();
    $arrGioLamViec =[];
    $tongGio=0;
    foreach ($lich as $item)
    {
        $gioBatDau = substr($item->classTime_startDate,11,2);
        $phutBatDau = substr($item->classTime_startDate,14,2);
        $gioKetThuc = substr($item->classTime_endDate,11,2);
        $phutKetThuc = substr($item->classTime_endDate,14,2);

        if ($phutKetThuc>=$phutBatDau)
        {
            $PhutThu= $phutKetThuc-$phutBatDau;
            $gioThu=$gioKetThuc-$gioBatDau;
        }
        else
        {
            $PhutThu=60+ $phutKetThuc-$phutBatDau;
            $gioThu=$gioKetThuc-$gioBatDau-1;
        }
        $arrGioLamViec[]=[
            'dateStart'=>$item->classTime_startDate,
            'dateEnd'=>$item->classTime_endDate,
            'tenLop'=>$item->class_name,
            'gio'=>$gioThu,
            'chiNhanh'=>$item->branch_code
        ];
        $tongGio+=$gioThu;
    }

    return view('XepLichLopHoc.gioLamViecGiaoVien')
        ->with('giaoVien',$giaoVien)
        ->with('ngayBatDauChinh',$ngayBatDauChinh)
        ->with('ngayKetThucChinh',$ngayKetThucChinh)
        ->with('arrGioLamViec',$arrGioLamViec)
        ->with('tongGio',$tongGio)
        ->with('idNhanVien',$idNhanVien )
        ;
    }
    else
    return redirect()->back();
}

public function searchXepLichNhanVien(Request $request)
{
    if ($request->ajax()) {
        $quyen = new quyenController();
        $lay = $quyen->layDuLieu();
        $value = $request->get('value');
        $chiNhanh = $request->get('chiNhanh');
        $page = $request->get('page');
        if ($value == "")
        {
            if($chiNhanh ==0)
            {
                $khuyenMai = DB::table('st_employee')
                ->join('st_position','st_position.position_id','=',
                'st_employee.position_id')
                ->join('st_branch','st_branch.branch_id','=',
                'st_employee.branch_id')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            }
            else
            {
                $khuyenMai = DB::table('st_employee')
                ->join('st_position','st_position.position_id','=',
                'st_employee.position_id')
                ->join('st_branch','st_branch.branch_id','=',
                'st_employee.branch_id')
                ->where('st_employee.branch_id',$chiNhanh)
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            }
        }
           
        else
        {

            if($chiNhanh ==0)
            {
            $khuyenMai = DB::table('st_employee')
            ->join('st_position','st_position.position_id','=',
            'st_employee.position_id')
            ->join('st_branch','st_branch.branch_id','=',
            'st_employee.branch_id')
                ->where('st_employee.employee_name', 'like', '%' . $value . '%')
                ->take($lay)
                ->skip(($page - 1) * $lay)
                ->get();
            }
            else
            {
                $khuyenMai = DB::table('st_employee')
                ->join('st_position','st_position.position_id','=',
                'st_employee.position_id')
                ->join('st_branch','st_branch.branch_id','=',
                'st_employee.branch_id')
                ->where('st_employee.branch_id',$chiNhanh)
                    ->where('st_employee.employee_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            }
        }

        $out = "";
        $i = 1;
         foreach ($khuyenMai as $item) {

            $out .= "<tr>
            <td>" . $i . "</td>
            <td>".$item->branch_name."</td>
            <td>".$item->employee_name."</td>
            <td>".$item->employee_phone."</td>
            <td><a class='btn'  href='". route('getLichNhanVien') ."?id=". $item->employee_id ."'>
            <i class='fa fa-calendar'></i></a></td>
            <td><a class='btn' href=''><i class='fa fa-edit'></i></a></td>
            <td><a class='btn'  href='". route('getGioLamGiaoVien') ."?id=". $item->employee_id ."'>
            <i class='fa  fa-clock-o'></i></a></td>
                                    ";
           
                                
            $out .= " </tr>";
            $i++;
         }
        return response($out);
    }
}


public function getXepLichGiaoVien(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichNhanVien();
        if($quyenChiTiet==1)
        {

            $now = Carbon::now('Asia/Ho_Chi_Minh');
        $idNhanVien = $request->get('id');
        $nhanVien = DB::table('st_employee')
            ->where('employee_id',$idNhanVien)
            ->get()->first();
        $nhanVienThayDoi =  DB::table('st_employee')
            ->where('employee_id','!=',$idNhanVien)
            ->get();

        $lich = DB::table('st_class_time')
            ->join('st_class','st_class.class_id','=','st_class_time.class_id')
            ->join('st_room','st_room.room_id','=','st_class_time.room_id')
            ->join('st_branch','st_branch.branch_id','=','st_room.branch_id')
            ->join('st_class_time_employee','st_class_time_employee.classTime_id',
            '=','st_class_time.classTime_id')
            ->where('st_class_time_employee.employee_id',$idNhanVien)
            ->where('st_class_time.classTime_startDate','>',$now )
            ->orderBy('st_class_time.classTime_startDate')
            ->get();


        return  view('XepLichLopHoc.xepLichNhanVien')
            ->with('nhanVien',$nhanVien)
            ->with('lich',$lich)
            ->with('giaoVien',$nhanVienThayDoi);
        }
        else
        return redirect()->back();
    }


    public function getCapNhatDaiHanXepLichGiaoVien(Request $request)
    {
        if ($request->ajax())
        {
            $nhanVien1= $request->get('nhanVien1');
            $nhanVien= $request->get('nhanVien');
            $ngayBatDau= $request->get('ngayBatDau');
            $ngayKetThuc= $request->get('ngayKetThuc');
            $kiemTra="";

            $ngay1= substr($ngayBatDau,3,2);
            $thang1= substr($ngayBatDau,0,2);
            $nam1= substr($ngayBatDau,6,4);
            $ngayBatDauChinh = $nam1."-".$thang1."-".$ngay1;
            $ngay2= substr($ngayKetThuc,3,2);
            $thang2= substr($ngayKetThuc,0,2);
            $nam2= substr($ngayKetThuc,6,4);
            $ngayKetThucChinh  =$nam2."-".$thang2."-".$ngay2;

            $lich = DB::table('st_class_time')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                'st_class_time.classTime_id')
                ->where('st_class_time_employee.employee_id',$nhanVien1)
                ->whereDate('st_class_time.classTime_startDate','>=',$ngayBatDauChinh)
                ->whereDate('st_class_time.classTime_startDate','<=',$ngayKetThucChinh)
                ->get();

            // return response($ngayBatDauChinh);
            foreach ($lich as $item)
            {
                


                $lichGiaoVien = DB::table('st_class_time')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                'st_class_time.classTime_id')
                ->where('st_class_time_employee.employee_id',$nhanVien)
                    ->where('classTime_startDate','<=',$item->classTime_startDate)
                    ->where('classTime_endDate','>=',$item->classTime_startDate)
                    ->get()->first();
                if (isset($lichGiaoVien))
                {
                    $kiemTra.=" Ngày ".date('d/m/Y H:i',strtotime($item->classTime_startDate))." Đã Có Lịch.";
                }
                else
                    $lichGiaoVien = DB::table('st_class_time')
                    ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                    'st_class_time.classTime_id')
                    ->where('st_class_time_employee.employee_id',$nhanVien)
                        ->where('classTime_startDate','<=',$item->classTime_endDate)
                        ->where('classTime_endDate','>=',$item->classTime_endDate)
                        ->get()->first();

                if (isset($lichGiaoVien))
                {
                    $kiemTra.=" Ngày ".date('d/m/Y H:i',strtotime($item->classTime_startDate))." Đã Có Lịch.";
                }
                else
                    $lichGiaoVien = DB::table('st_class_time')
                    ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                    'st_class_time.classTime_id')
                    ->where('st_class_time_employee.employee_id',$nhanVien)
                        ->where('classTime_startDate','>=',$item->classTime_startDate)
                        ->where('classTime_endDate','<=',$item->classTime_endDate)
                        ->get()->first();
                if (isset($lichGiaoVien))
                {
                    $kiemTra.=" Ngày ".date('d/m/Y H:i',strtotime($item->classTime_startDate))." Đã Có Lịch.";
                }

            }
            if ($kiemTra!="")
            {
                return  response($kiemTra);
            }else
            {
                try {
                    foreach ($lich as $item)
                    {
                        DB::table('st_class_time_employee')
                            ->where('classTime_id',$item->classTime_id)
                            ->where('employee_id',$nhanVien1)
                            ->update([
                                'employee_id'=>$nhanVien
                            ]);
                    }
                    return response(1);
                }
                catch (QueryException $e) {
                    return response(0);
                }
            }

        }
    
    }


    public function getCapNhatXepLichGiaoVien(Request $request)
    {
        if ($request->ajax())
        {
            $nhanVien= $request->get('nhanVien');
            $nhanVien1= $request->get('nhanVien1');
            
            $lich= $request->get('lich');
            $kiemTra="";
            for ($i=0;$i<count($lich);$i++)
            {
                $lop = DB::table('st_class_time')
                    ->where('classTime_id',$lich[$i])
                    ->get()->first();
                $lichGiaoVien = DB::table('st_class_time')
                    ->join('st_class_time_employee','st_class_time_employee.classTime_id','=',
                    'st_class_time.classTime_id')
                    ->where('st_class_time_employee.employee_id',$nhanVien)
                    ->where('st_class_time.classTime_startDate','<=',$lop->classTime_startDate)
                    ->where('st_class_time.classTime_endDate','>=',$lop->classTime_startDate)
                    ->get()->first();
                if (isset($lichGiaoVien))
                {
                    $kiemTra.=" Ngày ".date('d/m/Y H:i',strtotime($lop->classTime_startDate))." Đã Có Lịch.";

                }
                else
                {
                    $lichGiaoVien = DB::table('st_class_time')
                    ->join('st_class_time_employee','st_class_time_employee.classTime_id','=',
                    'st_class_time.classTime_id')
                    ->where('st_class_time_employee.employee_id',$nhanVien)
                        ->where('st_class_time.classTime_startDate','<=',$lop->classTime_endDate)
                        ->where('st_class_time.classTime_endDate','>=',$lop->classTime_endDate)
                        ->get()->first();

                    if (isset($lichGiaoVien))
                    {
                        $kiemTra.=" Ngày ".date('d/m/Y H:i',strtotime($lop->classTime_startDate))." Đã Có Lịch.";
                        break;
                    }
                    else
                    {
                        $lichGiaoVien = DB::table('st_class_time')
                        ->join('st_class_time_employee','st_class_time_employee.classTime_id','=',
                        'st_class_time.classTime_id')
                        ->where('st_class_time_employee.employee_id',$nhanVien)
                            ->where('st_class_time.classTime_startDate','>=',$lop->classTime_startDate)
                            ->where('st_class_time.classTime_endDate','<=',$lop->classTime_endDate)
                            ->get()->first();
                        if (isset($lichGiaoVien))
                        {
                            $kiemTra.=" Ngày ".date('d/m/Y H:i',strtotime($lop->classTime_startDate))." Đã Có Lịch.";

                        }
                    }
                }

            }

            if ($kiemTra!="")
            {
                return  response($kiemTra);
            }else
            {
                try {
                    for ($i=0;$i<count($lich);$i++)
                    {
                        DB::table('st_class_time_employee')
                            ->where('classTime_id',$lich[$i])
                            ->where('employee_id',$nhanVien1)
                            ->update([
                                'employee_id'=>$nhanVien
                            ]);
                    }
                    return response(1);
                }
                catch (QueryException $e) {
                    return response(0);
                }
            }

        }
    }
    


    public function html_email() {




        $data = array('name'=>"Virat Gandhi");
        Mail::send('mail', $data, function($message) {
            $message->to('nguyenhuynhductd2015@gmail.com', 'Tutorials Point')->subject
            ('Laravel HTML Testing Mail');
            $message->from('duc0914@gmail.com','Virat Gandhi');
        });
       
    }
}
