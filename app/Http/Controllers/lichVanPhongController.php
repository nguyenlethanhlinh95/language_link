<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

use function Ramsey\Uuid\v1;

class lichVanPhongController extends Controller
{
    public function getLichVanPhong()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemLichVanPhong();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $nhanVien = DB::table('view_employee_department')
            ->orderBy('branch_id')
            ->orderBy('department_id')
            ->take($lay)
            ->get();

            $nhanVienTong = DB::table('view_employee_department')
                        ->count();
            
          
            $soTrang = (int) $nhanVienTong / $lay;
            if ($nhanVienTong % $lay > 0)
                $soTrang++;
            $phongBan = DB::table('st_department')
                ->get();
            $chiNhanh = DB::table('st_branch')
            ->get();
            return view('GioVanPhong.gioVanPhong')
                ->with('nhanVien', $nhanVien)
                ->with('soTrang', $soTrang)
                ->with('phongBan', $phongBan)
                ->with('chiNhanh', $chiNhanh)
                ->with('page', 1);


        }
        else
        {
            return redirect()->back();
        }
        
    }

    public function getXepLicVanPhong(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemLichVanPhong();
        if($quyenChiTiet==1)
        {
            $id = $request->get('id');
            $tuan = $request->get('week');
          
            $nhanVien = DB::table('st_employee')
            ->where('employee_id',$id)
            ->get()->first();
            $now = Carbon::now('Asia/Ho_Chi_Minh');
          
            if($tuan=="")
            {
                $tuan = $now->week();
            }

            $dto = new \DateTime();
            $dto->setISODate($now->year,$tuan);
            $arrCa =[];
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

            $khungGioCa = DB::table('st_office_hours')
            ->whereDate('officeHours_date','>=',$ngayBatDauChinh)
            ->whereDate('officeHours_date','<=',$ngayKetThucChinh)
            ->where('employee_id',$id)
            ->get();

            foreach($khungGioCa as $item)
            {
                if($item->officeHours_date == $ngayBatDauChinh)
                {
                    $thu = 2;   
                }
                else if($item->officeHours_date == $ngayThu3)
                {
                    $thu = 3;   
                }
                else if($item->officeHours_date == $ngayThu4)
                {
                    $thu = 4;   
                }
                else if($item->officeHours_date == $ngayThu5)
                {
                    $thu = 5;   
                }
                else if($item->officeHours_date == $ngayThu6)
                {
                    $thu = 6;   
                }
                else if($item->officeHours_date == $ngayThu7)
                {
                    $thu = 7;   
                }
                else if($item->officeHours_date == $ngayKetThucChinh)
                {
                    $thu = 8;   
                }

                $arrCa []= [
                    'ca'=>$item->officeHours_shift,
                    'thu'=>$thu,
                    'gioBatDau'=>$item->officeHours_startTime,
                    'gioKetThuc'=>$item->officeHours_endTime
                ];
            }


            $khungGioCa1 = DB::table('st_time_slot')
            ->where('department_id',$nhanVien->department_id)
            ->orderBy('timeSlot_startTime')
            ->orderBy('timeSlot_endTime')
            ->get();
            $khungGioCa2 = DB::table('st_time_slot')
            ->where('department_id',$nhanVien->department_id)
            ->where('timeSlot_shift',2)
            ->get();
            $khungGioCa3 = DB::table('st_time_slot')
            ->where('department_id',$nhanVien->department_id)
            ->where('timeSlot_shift',3)
            ->get();

             return view('GioVanPhong.xepLichVanPhong')
             ->with('nhanVien',$nhanVien)
             ->with('arrCa',$arrCa)
             ->with('khungGioCa1',$khungGioCa1)
             ->with('khungGioCa2',$khungGioCa2)
             ->with('khungGioCa3',$khungGioCa3)
             ->with('ngayBatDauChinh',$ngayBatDauChinh)
             ->with('ngayThu3',$ngayThu3)
             ->with('ngayThu4',$ngayThu4)
             ->with('ngayThu5',$ngayThu5)
             ->with('ngayThu6',$ngayThu6)
             ->with('ngayThu7',$ngayThu7)
             ->with('ngayKetThucChinh',$ngayKetThucChinh)
             ->with('tuan',$tuan)
             ;
        }
        else
        {
            return redirect()->back();
        }
    }


    public function postXepLichVanPhong(Request $request)
    {
        if($request->ajax())
        {
            $duLieu = "";
            $id = $request->get('id');
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $tuan = $request->get('tuan');
            $dto = new \DateTime();
            $dto->setISODate($now->year,$tuan);
            $ngay = $dto->format('Y-m-d');
           try
           {
               $ngayBatDau = $ngay;
            for($i=2;$i<=8;$i++)
            {
               
                $keyCa1 ="gioCa1T".$i;
                $ca1 = $request->get($keyCa1);
                if($ca1!="")
                {
                    $thoiGianBatDau = substr($ca1,0,5);
                    $thoiGianKetThuc = substr($ca1,8,5);
                        $gioBatDau = $ngay." ".$thoiGianBatDau;
                        $gioKetThuc = $ngay." ".$thoiGianKetThuc;

                        
                        $duLieu.=$this->kiemTraLichVanPhong($id,$gioBatDau,$gioKetThuc);
                        
                        if($duLieu!="")
                        return $duLieu;
                    

                }
                $keyCa2 ="gioCa2T".$i;
                $ca2 = $request->get($keyCa2);
                if($ca2!="")
                {
                   
                        $thoiGianBatDau = substr($ca2,0,5);
                        $thoiGianKetThuc = substr($ca2,8,5);
                        $gioBatDau = $ngay." ".$thoiGianBatDau;
                        $gioKetThuc = $ngay." ".$thoiGianKetThuc;

                        
                        $duLieu.=$this->kiemTraLichVanPhong($id,$gioBatDau,$gioKetThuc);
                        if($duLieu!="")
                        return $duLieu;
                    
                   
                }

                $keyCa3 ="gioCa3T".$i;
                $ca3 = $request->get($keyCa3);
                if($ca3!="")
                {
                   
                        $thoiGianBatDau = substr($ca3,0,5);
                        $thoiGianKetThuc = substr($ca3,8,5);
                        $gioBatDau = $ngay." ".$thoiGianBatDau;
                        $gioKetThuc = $ngay." ".$thoiGianKetThuc;

                        
                        $duLieu.=$this->kiemTraLichVanPhong($id,$gioBatDau,$gioKetThuc);
                        if($duLieu!="")
                        return $duLieu;
                    
                }
                $dto->modify('+1 days');
                $ngay = $dto->format('Y-m-d');
            }
            $dto->modify('-1 days');
            $ngay = $dto->format('Y-m-d');
            $ngayKetThuc= $ngay;

           DB::table('st_office_hours')
            ->whereDate('officeHours_date','>=',$ngayBatDau)
            ->whereDate('officeHours_date','<=',$ngayKetThuc)
            ->where('employee_id',$id)
            ->delete();


            $dto = new \DateTime();
            $dto->setISODate($now->year,$tuan);
            $ngay = $dto->format('Y-m-d');

            for($i=2;$i<=8;$i++)
            {
               
                $keyCa1 ="gioCa1T".$i;
                $ca1 = $request->get($keyCa1);
                if($ca1!=0)
                {
                    $thoiGianBatDau = substr($ca1,0,5);
                    $thoiGianKetThuc = substr($ca1,8,5);
                    DB::table('st_office_hours')
                    ->insert([
                        'employee_id'=>$id,
                        'officeHours_startTime'=>$thoiGianBatDau,
                        'officeHours_endTime'=>$thoiGianKetThuc,
                        'officeHours_date'=>$ngay,
                        'officeHours_shift'=>1,
                        'officeHours_dayOfWeek'=>$i
                    ]);

                   
                }
                $keyCa2 ="gioCa2T".$i;
                $ca2 = $request->get($keyCa2);
                if($ca2!=0)
                {
                    $thoiGianBatDau = substr($ca2,0,5);
                    $thoiGianKetThuc = substr($ca2,8,5);
                    DB::table('st_office_hours')
                    ->insert([
                        'employee_id'=>$id,
                        'officeHours_startTime'=>$thoiGianBatDau,
                        'officeHours_endTime'=>$thoiGianKetThuc,
                        'officeHours_date'=>$ngay,
                        'officeHours_shift'=>2,
                        'officeHours_dayOfWeek'=>$i
                    ]);
                   
                }

                $keyCa3 ="gioCa3T".$i;
                $ca3 = $request->get($keyCa3);
                if($ca3!=0)
                {
                    $thoiGianBatDau = substr($ca3,0,5);
                    $thoiGianKetThuc = substr($ca3,8,5);
                    DB::table('st_office_hours')
                    ->insert([
                        'employee_id'=>$id,
                        'officeHours_startTime'=>$thoiGianBatDau,
                        'officeHours_endTime'=>$thoiGianKetThuc,
                        'officeHours_date'=>$ngay,
                        'officeHours_shift'=>3,
                        'officeHours_dayOfWeek'=>$i
                    ]);
                   
                }
                $dto->modify('+1 days');
                $ngay = $dto->format('Y-m-d');
            }


            return response(1);
           }catch(QueryException $ex)
           {
            return response(0);
           }
           
            


           

        }
    }


    public function kiemTraLichVanPhong($id,$gioBatDau,$gioKetThuc)
    {
        $gioLamViec = DB::table('class_time_employee')
        ->where('employee_id',$id)
        ->where('classTimeEmployee_type','!=',3)
        ->where('classTime_startDate','<=',$gioBatDau)
        ->where('classTime_endDate','>=',$gioBatDau)
        ->where('class_statusSchedule',1)  
        ->where('class_status',1)
        ->get()
        ->first();
        
        if(isset($gioLamViec))
        {
            return "Nhân viên có lịch từ " . date('H:i', strtotime($gioLamViec->classTime_startDate) )." đến ". date('H:i', strtotime($gioLamViec->classTime_endDate) )." ngày ".date('d/m/Y', strtotime($gioLamViec->classTime_startDate) ) ; 
        }
        else
        {
            $gioLamViec = DB::table('class_time_employee')
            ->where('employee_id',$id)
            ->where('classTimeEmployee_type','!=',3)
            ->where('classTime_startDate','<=',$gioKetThuc)
            ->where('classTime_endDate','>=',$gioKetThuc)
            ->get()
            ->first();
            
            if(isset($gioLamViec))
            {
                return "Nhân viên có lịch từ " . date('H:i', strtotime($gioLamViec->classTime_startDate) )." đến ". date('H:i', strtotime($gioLamViec->classTime_endDate) )." ngày ".date('d/m/Y', strtotime($gioLamViec->classTime_startDate) ) ; 
            }
            else
            {
                $gioLamViec = DB::table('class_time_employee')
                ->where('employee_id',$id)
                ->where('classTimeEmployee_type','!=',3)
                ->where('classTime_startDate','<=',$gioBatDau)
                ->where('classTime_endDate','>=',$gioKetThuc)
                ->get()
                ->first();
                
                if(isset($gioLamViec))
                {
                    return "Nhân viên có lịch từ " . date('H:i', strtotime($gioLamViec->classTime_startDate) )." đến ". date('H:i', strtotime($gioLamViec->classTime_endDate) )." ngày ".date('d/m/Y', strtotime($gioLamViec->classTime_startDate) ) ; 
                }
            }
        }

            


        return"";

    }


    public function getXemLichVanPhong(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemLichVanPhong();
        if($quyenChiTiet==1)
        {
            $id = $request->get('id');
            $tuan = $request->get('week');
          
            $nhanVien = DB::table('st_employee')
            ->where('employee_id',$id)
            ->get()->first();
            $now = Carbon::now('Asia/Ho_Chi_Minh');
          
            if($tuan=="")
            {
                $tuan = $now->week();
            }
            $arrLich=[];
            $dto = new \DateTime();
            $dto->setISODate($now->year,$tuan);
            $arrCa =[];
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

            $danhSachLop = DB::table('class_time_employee')
            ->whereDate('classTime_startDate','>=',$ngayBatDauChinh)
            ->whereDate('classTime_startDate','<=',$ngayKetThucChinh)
            ->where('class_statusSchedule',1)  
            ->where('class_status',1)
            ->where('employee_id',$id)
            ->where('classTimeEmployee_type',1)
            ->orderBy('classTime_startTime')
            ->get();

            $arrLop=[];
            foreach ($danhSachLop as $item)
            {
                $sttLopTrung=0;
                $checkLop=0;
                $soLopTrung=0;
  
                $viTriMang=0;
                $demMang =0;
                foreach ($arrLop as $itemLop)
                {
                   
                    if ($itemLop['idLop']== $item->class_id )
                    {
                       $checkLop=1;
                    }
                  $viTriMang++;
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
                   
                    $arrLop[]=[
                        'idLop'=>$item->class_id,
                        'chiNhanh'=>$chiNhanh->branch_code,
                        'TimeStart'=> date('H:i',strtotime( $item->classTime_startDate)) ,
                        'TimeEnd'=> date('H:i',strtotime( $item->classTime_endDate)),
                        'tenLop'=>$item->class_code,
                        'phong'=>$chiNhanh->room_name,
                        'ngayBatDau'=>date('d/m/Y',strtotime($item->class_startDay)) ,
                        'ngayKetThuc'=>date('d/m/Y',strtotime($item->class_endDay)),
                    ];
                   
                }
                
    
               
            }
            $i=0;
            $tongGioDay2=0;
            $tongGioDay3=0;
            $tongGioDay4=0;
            $tongGioDay5=0;
            $tongGioDay6=0;
            $tongGioDay7=0;
            $tongGioDay8=0;
            foreach ($arrLop as $item)
            {
                $i++;

             


                    $soGio2 = "";
                    $khoangThoiGian2="";
                    $soGio3 = "";
                    $khoangThoiGian3="";                 
                    $soGio4 = "";
                    $khoangThoiGian4="";               
                    $soGio5 = "";
                    $khoangThoiGian5="";                
                    $soGio6 = "";
                    $khoangThoiGian6="";               
                    $soGio7 = "";
                    $khoangThoiGian7="";   
                    $soGio8 = "";
                    $khoangThoiGian8="";
                

                $duLieu2 = $this->getThoiGianGio($id,$ngayBatDauChinh,$item['idLop']);
                $duLieu3 = $this->getThoiGianGio($id,$ngayThu3,$item['idLop']);
                $duLieu4 = $this->getThoiGianGio($id,$ngayThu4,$item['idLop']);
                $duLieu5 = $this->getThoiGianGio($id,$ngayThu5,$item['idLop']);
                $duLieu6 = $this->getThoiGianGio($id,$ngayThu6,$item['idLop']);
                $duLieu7 = $this->getThoiGianGio($id,$ngayThu7,$item['idLop']);
                $duLieu8 = $this->getThoiGianGio($id,$ngayKetThucChinh,$item['idLop']);
                $soGio2 = $duLieu2[0]['soGio'];
                $khoangThoiGian2 = $duLieu2[0]['khoangThoiGian'];
                $soGio3 = $duLieu3[0]['soGio'];
                $khoangThoiGian3 = $duLieu3[0]['khoangThoiGian'];
                $soGio4 = $duLieu4[0]['soGio'];
                $khoangThoiGian4 = $duLieu4[0]['khoangThoiGian'];
                $soGio5 = $duLieu5[0]['soGio'];
                $khoangThoiGian5 = $duLieu5[0]['khoangThoiGian'];
                $soGio6 = $duLieu6[0]['soGio'];
                $khoangThoiGian6 = $duLieu6[0]['khoangThoiGian'];
                $soGio7 = $duLieu7[0]['soGio'];
                $khoangThoiGian7 = $duLieu7[0]['khoangThoiGian'];
                $soGio8 = $duLieu8[0]['soGio'];
                $khoangThoiGian8 = $duLieu8[0]['khoangThoiGian'];

                $tongGioDay2+=(Double)$soGio2;
                $tongGioDay3+=(Double)$soGio3;
                $tongGioDay4+=(Double)$soGio4;
                $tongGioDay5+=(Double)$soGio5;
                $tongGioDay6+=(Double)$soGio6;
                $tongGioDay7+=(Double)$soGio7;
                $tongGioDay8+=(Double)$soGio8;
              
                $arrLich[]=[
                    'soGio2'=>$soGio2,
                    'khoangThoiGian2'=>$khoangThoiGian2,
                    'soGio3'=>$soGio3,
                    'khoangThoiGian3'=>$khoangThoiGian3,
                    'soGio4'=>$soGio4,
                    'khoangThoiGian4'=>$khoangThoiGian4,
                    'soGio5'=>$soGio5,
                    'khoangThoiGian5'=>$khoangThoiGian5,
                    'soGio6'=>$soGio6,
                    'khoangThoiGian6'=>$khoangThoiGian6,
                    'soGio7'=>$soGio7,
                    'khoangThoiGian7'=>$khoangThoiGian7,
                    'soGio8'=>$soGio8,
                    'khoangThoiGian8'=>$khoangThoiGian8,
                ];
            }

            $duLieuOFF2 = $this->getGioVanPhong($id,$ngayBatDauChinh);
            $duLieuOFF3 = $this->getGioVanPhong($id,$ngayThu3);
            $duLieuOFF4 = $this->getGioVanPhong($id,$ngayThu4);
            $duLieuOFF5 = $this->getGioVanPhong($id,$ngayThu5);
            $duLieuOFF6 = $this->getGioVanPhong($id,$ngayThu6);
            $duLieuOFF7 = $this->getGioVanPhong($id,$ngayThu7);
            $duLieuOFF8 = $this->getGioVanPhong($id,$ngayKetThucChinh);

         



            return view('GioVanPhong.lichVanPhong')
            ->with('nhanVien',$nhanVien)
            ->with('ngayBatDauChinh',$ngayBatDauChinh)
            ->with('ngayThu3',$ngayThu3)
            ->with('ngayThu4',$ngayThu4)
            ->with('ngayThu5',$ngayThu5)
            ->with('ngayThu6',$ngayThu6)
            ->with('ngayThu7',$ngayThu7)
            ->with('ngayKetThucChinh',$ngayKetThucChinh)
            ->with('tuan',$tuan)
            ->with('arrLop',$arrLop)
            ->with('arrLich',$arrLich)
            ->with('tongGioDay2',$tongGioDay2)
            ->with('tongGioDay3',$tongGioDay3)
            ->with('tongGioDay4',$tongGioDay4)
            ->with('tongGioDay5',$tongGioDay5)
            ->with('tongGioDay6',$tongGioDay6)
            ->with('tongGioDay7',$tongGioDay7)
            ->with('tongGioDay8',$tongGioDay8)

            ->with('duLieuOFF2',$duLieuOFF2)
            ->with('duLieuOFF3',$duLieuOFF3)
            ->with('duLieuOFF4',$duLieuOFF4)
            ->with('duLieuOFF5',$duLieuOFF5)
            ->with('duLieuOFF6',$duLieuOFF6)
            ->with('duLieuOFF7',$duLieuOFF7)
            ->with('duLieuOFF8',$duLieuOFF8)
            ;
        }
        else
        {
            return redirect()->back();
        }
    }

    public function getThoiGianGio($id,$thoiGian,$idClass)
    {
        $classTime = DB::table('class_time_employee')
        ->whereDate('classTime_startDate',$thoiGian)
        ->where('class_statusSchedule',1)  
        ->where('class_status',1)
        ->where('class_id',$idClass)
        ->where('employee_id',$id)
        ->where('classTimeEmployee_type',1)
        ->orderBy('classTime_startDate')
        ->get();

        $soGio = 0;
        $khoangThoiGian="";
       foreach($classTime as $item)
        {
            $thoiGianBatDau = date('H:i',strtotime($item->classTime_startDate));
            $thoigianketThuc = date('H:i',strtotime($item->classTime_endDate));
            $gio1 = substr($thoiGianBatDau,0,2);
            $phut1 = substr($thoiGianBatDau,3,2);
            $gio2 = substr($thoigianketThuc,0,2);
            $phut2 = substr($thoigianketThuc,3,2);

            $gio = (int)$gio2 - (int)$gio1;
            $phut = (int)$phut2- (int)$phut1;

            if($phut<0)
            {
                $gio= $gio-1;
                $phut = $phut+60;
            }
            if($phut!=0)
            {
                $phut = round($phut/60,2) ;
            }

            $soGio +=($gio+$phut);
           $khoangThoiGian.="(".$thoiGianBatDau."-".$thoigianketThuc.") ";
        }   
         
        $arr[]=[
            'soGio'=>$soGio,
            'khoangThoiGian'=>$khoangThoiGian
        ];
        return $arr;
    }

    public function getGioVanPhong($id,$thoiGian)
    {
        $gioVanPhong = DB::table('view_time_slot_office')
        ->where('employee_id',$id)
        ->whereDate('officeHours_date','=',$thoiGian)
        ->get();
        $soGio =0;
        $khoangThoiGian = "";
        $chiNhanh="";
        foreach($gioVanPhong as $item)
        {
            $thoiGianBatDau = date('H:i',strtotime($item->officeHours_startTime));
            $thoigianketThuc = date('H:i',strtotime($item->officeHours_endTime));
            $gio1 = substr($thoiGianBatDau,0,2);
            $phut1 = substr($thoiGianBatDau,3,2);
            $gio2 = substr($thoigianketThuc,0,2);
            $phut2 = substr($thoigianketThuc,3,2);

            $gio = (int)$gio2 - (int)$gio1;
            $phut = (int)$phut2- (int)$phut1;

            if($phut<0)
            {
                $gio= $gio-1;
                $phut = $phut+60;
            }
            if($phut!=0)
            {
                $phut = round($phut/60,2) ;
            }

            $soGio+=$gio+$phut;
            $khoangThoiGian .= "(".$thoiGianBatDau."-".$thoigianketThuc. ") ";
            $chiNhanh=$item->branch_code;
            $classTime = DB::table('class_time_employee')
            ->where('classTime_startDate','>=',$thoiGian." ".$thoiGianBatDau)
            ->where('classTime_endDate','<=',$thoiGian." ".$thoigianketThuc)
            ->where('class_statusSchedule',1)  
            ->where('class_status',1)
            ->where('employee_id',$id)
            ->where('classTimeEmployee_type',1)
            ->get()->first();
            if(isset($classTime))
            {
                $thoiGianBatDau = date('H:i',strtotime($classTime->classTime_startDate));
                $thoigianketThuc = date('H:i',strtotime($classTime->classTime_endDate));

                $gio1 = substr($thoiGianBatDau,0,2);
                $phut1 = substr($thoiGianBatDau,3,2);
                $gio2 = substr($thoigianketThuc,0,2);
                $phut2 = substr($thoigianketThuc,3,2);
               
                $gio3 = (int)$gio2 - (int)$gio1;
                $phut3 = (int)$phut2- (int)$phut1;
    
                if($phut3<0)
                {
                    $gio3= $gio3-1;
                    $phut3 = $phut3+60;
                }
                if($phut3!=0)
                {
                    $phut3 = round($phut3/60,2) ;
                }

                $soGio = $soGio-($gio3+$phut3);
    

            }




           
        }

    

        $arr[]=[
            'soGio'=>$soGio,
            'khoangThoiGian'=>$khoangThoiGian,
            'chiNhanh'=>$chiNhanh
        ];

        return $arr;
    }
}
