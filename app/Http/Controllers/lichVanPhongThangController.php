<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class lichVanPhongThangController extends Controller
{
    public function getXepLichThang(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemLichThang();
        if($quyenChiTiet==1)
        {
            $id = $request->get('id');
            $thang = $request->get('month');
            $nam = $request->get('year');
            $nhanVien = DB::table('st_employee')
            ->where('employee_id',$id)
            ->get()->first();
            $now = Carbon::now('Asia/Ho_Chi_Minh');
           
            if($thang=="")
            {
                $thang = $now->month;
            }
            if($nam=="")
            {
                $nam = $now->year;
            }

           if($thang>12)
           {
               $thang = $thang-12;
               $nam++;
           }
           
           if($thang==0)
           {
               $thang=12;
               $nam--;
           }

            $arrCa =[];
          
            $khungGioCa = DB::table('st_calendar_month')
            ->whereMonth('calendarMonth_month',$thang)
            ->whereYear('calendarMonth_month',$nam)
            ->where('employee_id',$id)
            ->get();

        
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

             return view('GioVanPhong.xepLichThang')
             ->with('nhanVien',$nhanVien)
             ->with('arrCa',$arrCa)
             ->with('khungGioCa',$khungGioCa)
             
             ->with('khungGioCa1',$khungGioCa1)
             ->with('khungGioCa2',$khungGioCa2)
             ->with('khungGioCa3',$khungGioCa3)
             ->with('thang',$thang)
             ->with('nam',$nam)
             ;
        }
        else
        {
            return back();
        }
    }

    public function postXepLichVanPhongThang(Request $request)
    {
        
        if($request->ajax())
        {
            $duLieu = "";
            $id = $request->get('id');
          
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $thang = $request->get('thang');
            $nam =  $request->get('nam');

            $thoiGian = new Carbon($nam."-".($thang-1)."-26");
            $date =new Carbon($nam."-".($thang)."-01");
            $lichVanPhong = new lichVanPhongController();
            $ngayBatDau = $nam."-".($thang-1)."-26";
            $ngayKetThuc = $nam."-".($thang)."-25";
           try
           {
            $nhanVien = DB::table('st_employee')
            ->where('employee_id',$id)
            ->get()
            ->first();
            $duLieu="";
                for($i=0;$i<$thoiGian->daysInMonth;$i++)
                {
                    $thu = $thoiGian->dayOfWeekIso +1;
                    
                    for($j=2;$j<=8;$j++)
                    {
                        if($thu == $j)
                        {
                            $keyCa1 ="gioCa1T".$j;
                            $ca1 = $request->get($keyCa1);
                            if($ca1!="")
                            {
                                $thoiGianBatDau = substr($ca1,0,5);
                                $thoiGianKetThuc = substr($ca1,8,5);
                                    $gioBatDau =date('Y-m-d',strtotime($thoiGian))." ".$thoiGianBatDau;
                                    $gioKetThuc = date('Y-m-d',strtotime($thoiGian))." ".$thoiGianKetThuc;
            
                                    
                                    $duLieu.=$this->kiemTraLichVanPhong($id,$gioBatDau,$gioKetThuc,$thu);
                                    
                                    if($duLieu!="")
                                    return $duLieu;
                            }
                            $keyCa2 ="gioCa2T".$j;
                            $ca2 = $request->get($keyCa2);
                            if($ca2!="")
                            {
                                $thoiGianBatDau = substr($ca2,0,5);
                                $thoiGianKetThuc = substr($ca2,8,5);
                                    $gioBatDau =date('Y-m-d',strtotime($thoiGian))." ".$thoiGianBatDau;
                                    $gioKetThuc = date('Y-m-d',strtotime($thoiGian))." ".$thoiGianKetThuc;
            
                                    
                                    $duLieu.=$this->kiemTraLichVanPhong($id,$gioBatDau,$gioKetThuc,$thu);
                                    
                                    if($duLieu!="")
                                    return $duLieu;
                                if($ca1!="")
                                {
                                    $thoiGianBatDau1 = substr($ca1,0,5);
                                    $thoiGianKetThuc1 = substr($ca1,8,5);
                                    $thoiGianBatDau2 = substr($ca2,0,5);
                                    $thoiGianKetThuc2 = substr($ca2,8,5);
                                    $duLieu = $this->kiemTraKhungGio($thoiGianBatDau1,$thoiGianKetThuc1,
                                    $thoiGianBatDau2,$thoiGianKetThuc2);

                                    if($duLieu!="")
                                    return "Thứ ".$j." " .$duLieu;
                                }    

                            }
                            $keyCa3 ="gioCa3T".$j;
                            $ca3 = $request->get($keyCa3);
                            if($ca3!="")
                            {
                                $thoiGianBatDau = substr($ca3,0,5);
                                $thoiGianKetThuc = substr($ca3,8,5);
                                    $gioBatDau =date('Y-m-d',strtotime($thoiGian))." ".$thoiGianBatDau;
                                    $gioKetThuc = date('Y-m-d',strtotime($thoiGian))." ".$thoiGianKetThuc;
            
                                    
                                    $duLieu.=$this->kiemTraLichVanPhong($id,$gioBatDau,$gioKetThuc,$thu);
                                    
                                    if($duLieu!="")
                                    return $duLieu;
                                    if($ca1!="")
                                    {
                                        $thoiGianBatDau1 = substr($ca1,0,5);
                                        $thoiGianKetThuc1 = substr($ca1,8,5);
                                        $thoiGianBatDau2 = substr($ca3,0,5);
                                        $thoiGianKetThuc2 = substr($ca3,8,5);
                                        $duLieu = $this->kiemTraKhungGio($thoiGianBatDau1,$thoiGianKetThuc1,
                                        $thoiGianBatDau2,$thoiGianKetThuc2);
    
                                        if($duLieu!="")
                                        return "Thứ ".$j." " .$duLieu;
                                    }    
                                    if($ca2!="")
                                    {
                                        $thoiGianBatDau1 = substr($ca2,0,5);
                                        $thoiGianKetThuc1 = substr($ca2,8,5);
                                        $thoiGianBatDau2 = substr($ca3,0,5);
                                        $thoiGianKetThuc2 = substr($ca3,8,5);
                                        $duLieu = $this->kiemTraKhungGio($thoiGianBatDau1,$thoiGianKetThuc1,
                                        $thoiGianBatDau2,$thoiGianKetThuc2);
    
                                        if($duLieu!="")
                                        return "Thứ ".$j." " .$duLieu;
                                    }    
                            }

                        }
                       
                      
                    }


                    $thoiGian->addDay(1);
                }
              
                DB::table('st_calendar_month')  
                ->where('employee_id',$id)
                ->whereMonth('calendarMonth_month',$thang)
                ->whereYear('calendarMonth_month',$nam)
                ->delete();
                    
                    for($j=2;$j<=8;$j++)
                    {
                        
                            $keyCa1 ="gioCa1T".$j;
                            $ca1 = $request->get($keyCa1);
                            if($ca1!="")
                            {
                                $thoiGianBatDau = substr($ca1,0,5);
                                $thoiGianKetThuc = substr($ca1,8,5);
                                    
                                  DB::table('st_calendar_month')  
                                  ->insert([
                                      'employee_id'=>$id,
                                      'calendarMonth_startTime'=>$thoiGianBatDau,
                                      'calendarMonth_endTime'=>$thoiGianKetThuc,
                                      'calendarMonth_shift'=>1,
                                      'calendarMonth_dayOfWeek'=>$j,
                                      'calendarMonth_month'=> $date
                                  ]);
                            }
                            $keyCa2 ="gioCa2T".$j;
                            $ca2 = $request->get($keyCa2);
                            if($ca2!="")
                            {
                                $thoiGianBatDau = substr($ca2,0,5);
                                $thoiGianKetThuc = substr($ca2,8,5);
                                DB::table('st_calendar_month')  
                                ->insert([
                                    'employee_id'=>$id,
                                    'calendarMonth_startTime'=>$thoiGianBatDau,
                                    'calendarMonth_endTime'=>$thoiGianKetThuc,
                                    'calendarMonth_shift'=>2,
                                    'calendarMonth_dayOfWeek'=>$j,
                                    'calendarMonth_month'=> $date
                                ]);
                            }
                            $keyCa3 ="gioCa3T".$j;
                            $ca3 = $request->get($keyCa3);
                            if($ca3!="")
                            {
                                
                                $thoiGianBatDau = substr($ca3,0,5);
                                $thoiGianKetThuc = substr($ca3,8,5);
                                DB::table('st_calendar_month')  
                                ->insert([
                                    'employee_id'=>$id,
                                    'calendarMonth_startTime'=>$thoiGianBatDau,
                                    'calendarMonth_endTime'=>$thoiGianKetThuc,
                                    'calendarMonth_shift'=>3,
                                    'calendarMonth_dayOfWeek'=>$j,
                                    'calendarMonth_month'=> $date
                                ]);
                            }

                      
                    }
                DB::table('st_office_hours')
                ->where('officeHours_date','>=',$ngayBatDau)
                ->where('officeHours_date','<=',$ngayKetThuc)
                ->where('employee_id',$id)
                ->delete();
                $nghiLe = DB::table('st_application_leave')
                ->where('department_id',$nhanVien->department_id)
                ->where('applicationLeave_type',1)
                ->get()
                ->first();

            $thoiGian = new Carbon($nam."-".($thang-1)."-26");
                for($i=0;$i<$thoiGian->daysInMonth;$i++)
                {
                    $thu = $thoiGian->dayOfWeekIso +1;
                    
                    $le = DB::table('st_holiday')
                    ->whereDate('holiday_startDate','<=',$thoiGian)
                    ->whereDate('holiday_endDate','>=',$thoiGian)
                    ->get()->first();
                    if(isset($nghiLe) && isset($le))
                    {
                        DB::table('st_resignation_application')
                        ->insert([
                            'resignationApplication_date'=>$thoiGian,
                            'applicationLeave_id'=>$nghiLe->applicationLeave_id,
                            'employee_id'=>$id
                        ]);
                    }
                    for($j=2;$j<=8;$j++)
                    {
                        if($thu == $j)
                        {
                            $keyCa1 ="gioCa1T".$j;
                            $ca1 = $request->get($keyCa1);
                            if($ca1!="")
                            {
                                $thoiGianBatDau = substr($ca1,0,5);
                                $thoiGianKetThuc = substr($ca1,8,5);
                                DB::table('st_office_hours')
                                ->insert([
                                    'employee_id'=>$id,
                                    'officeHours_startTime'=>$thoiGianBatDau,
                                    'officeHours_endTime'=>$thoiGianKetThuc,
                                    'officeHours_date'=>$thoiGian,
                                    'officeHours_shift'=>1,
                                    'officeHours_dayOfWeek'=>$i
                                ]);
                            }
                            $keyCa2 ="gioCa2T".$j;
                            $ca2 = $request->get($keyCa2);
                            if($ca2!="")
                            {
                                $thoiGianBatDau = substr($ca2,0,5);
                                $thoiGianKetThuc = substr($ca2,8,5);
                                DB::table('st_office_hours')
                                ->insert([
                                    'employee_id'=>$id,
                                    'officeHours_startTime'=>$thoiGianBatDau,
                                    'officeHours_endTime'=>$thoiGianKetThuc,
                                    'officeHours_date'=>$thoiGian,
                                    'officeHours_shift'=>2,
                                    'officeHours_dayOfWeek'=>$i
                                ]);
                            }
                            $keyCa3 ="gioCa3T".$j;
                            $ca3 = $request->get($keyCa3);
                            if($ca3!="")
                            {
                                $thoiGianBatDau = substr($ca3,0,5);
                                $thoiGianKetThuc = substr($ca3,8,5);
                                DB::table('st_office_hours')
                                ->insert([
                                    'employee_id'=>$id,
                                    'officeHours_startTime'=>$thoiGianBatDau,
                                    'officeHours_endTime'=>$thoiGianKetThuc,
                                    'officeHours_date'=>$thoiGian,
                                    'officeHours_shift'=>3,
                                    'officeHours_dayOfWeek'=>$i
                                ]);
                            }

                        }
                       
                      
                    }


                    $thoiGian->addDay(1);
                }
                return response(1);
           }catch(QueryException $ex)
           {
            return response(0);
           }
           
            


           

        }
    }
    public function kiemTraKhungGio($thoiGianBatDau1,$thoiGianKetThuc1,
    $thoiGianBatDau2,$thoiGianKetThuc2)
    {
        $ngay =date('d/m/Y',strtotime(Carbon::now())) ;
        $gioBatDau1 = new Carbon($ngay ." ".$thoiGianBatDau1);
        $gioKetThuc1 = new Carbon($ngay ." ".$thoiGianKetThuc1);
        $gioBatDau2 = new Carbon($ngay ." ".$thoiGianBatDau2);
        $gioKetThuc2 = new Carbon($ngay ." ".$thoiGianKetThuc2);
      

        if($gioBatDau1<=$gioBatDau2 && $gioKetThuc1<=$gioBatDau2)
        {
            return "";
        }
        else  if($gioBatDau1>=$gioKetThuc2 && $gioKetThuc1>=$gioKetThuc2)
        {
            return "";
        }
        else
        {
            return "đã trùng giờ";
        }

       
    }
    public function kiemTraLichVanPhong($id,$gioBatDau,$gioKetThuc,$thu)
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
            return "Nhân viên có lịch từ " . date('H:i', strtotime($gioLamViec->classTime_startDate) )." đến ". date('H:i', strtotime($gioLamViec->classTime_endDate) )." thứ ".$thu." ngày ".date('d/m/Y', strtotime($gioLamViec->classTime_startDate) ) ; 
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
                return "Nhân viên có lịch từ " . date('H:i', strtotime($gioLamViec->classTime_startDate) )." đến ". date('H:i', strtotime($gioLamViec->classTime_endDate) )." thứ ".$thu." ngày ".date('d/m/Y', strtotime($gioLamViec->classTime_startDate) ) ; 
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
                    return "Nhân viên có lịch từ " . date('H:i', strtotime($gioLamViec->classTime_startDate) )." đến ". date('H:i', strtotime($gioLamViec->classTime_endDate) )." thứ ".$thu." ngày ".date('d/m/Y', strtotime($gioLamViec->classTime_startDate) ) ; 
                }
            }
        }

            


        return"";

    }

    public function TinhGio($gioBatDau,$gioKetThuc)
    {
 
        $gio1 = substr($gioBatDau,0,2);
        $phut1 = substr($gioBatDau,3,2);
        $gio2 = substr($gioKetThuc,0,2);
        $phut2 = substr($gioKetThuc,3,2);

        $gio = (int)$gio2 - (int)$gio1;
        $phut = (int)$phut2- (int)$phut1;
        if($gio1<12)
        {
            $ca=1;
        }
        else if($gio1>=12 && $gio1<17)
        {
            $ca =2;
         }
         else
         {
            $ca =3;
         }


        if($phut<0)
        {
            $gio= $gio-1;
            $phut = $phut+60;
        }
        if($phut!=0)
        {
            $phut = round($phut/60,2) ;
        }

        $soGio =($gio+$phut);
        $arr []=[
            'soGio'=>$soGio,
            'ca'=>$ca
        ];
        return $arr;
     }


    public function getLichTongQuat(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemLichThangTongQuat();
        if($quyenChiTiet==1)
        {
            $thang = $request->get('month');
            $nam = $request->get('year');
            $now = Carbon::now('Asia/Ho_Chi_Minh');
           
            if($thang == "")
            {
                $thang= $now->month;
            }
            if($nam == "")
            {
                $nam= $now->year;
            }
            if($thang>12)
            {
                $thang = $thang-12;
                $nam++;
            }
            
            if($thang==0)
            {
                $thang=12;
                $nam--;
            }

            $thoiGian = new Carbon($nam."-".($thang-1)."-26");
            $gioTuan =44;
            $ngayTuan = $thoiGian->daysInMonth;
            $soTuan =round($ngayTuan/7,1) ;
            $tongGioTuan = $soTuan*$gioTuan;
            $arrGioGiaoVien=[];
            $arrGioVanPhong=[];
            $ngayBatDauChinh = new Carbon($nam."-".($thang-1)."-26");
            $ngayKetThucChinh = new Carbon($nam."-".($thang)."-25");
            $phongBan = DB::table('st_department')
            ->get();
            $giaoVien = DB::table('st_employee')
            ->get();


             $gioDay = DB::table('class_time_employee')
             ->where('classTime_startDate','>=',$ngayBatDauChinh)
             ->where('classTime_startDate','<=',$ngayKetThucChinh)
             ->where('class_statusSchedule',1)
             ->where('classTimeEmployee_type','!=',3)
             ->get();

             $gioVanPhong = DB::table('st_office_hours')
             ->where('officeHours_date','>=',$ngayBatDauChinh)
             ->where('officeHours_date','<=',$ngayKetThucChinh)
            ->get();
            $lichVanPhong = new lichVanPhongController();
            $arrNhanVien =[];
            foreach($gioDay as $item)
            {
                $thoiGianBatDau =date('H:i',strtotime($item->classTime_startDate));
                $thoigianketThuc =date('H:i',strtotime($item->classTime_endDate));
                $ngay =  date('d/m/Y',strtotime($item->classTime_startDate));
                $duLieu =$this->TinhGio($thoiGianBatDau,$thoigianketThuc);
                $soGio=$duLieu[0]['soGio'];
                $ca= $duLieu[0]['ca'];
                $i =0;
                $soDem =0;
                $kiemTra=0;

                



                foreach($arrGioGiaoVien as $item2)
                {
                    if($item2['idGiaoVien']==$item->employee_id 
                    && $item2['thoiGian']==$ngay 
                    && $item2['ca']==$ca)
                    {
                        $kiemTra = 1;
                        $soDem=$i;
                    }
                    $i++;
                }

                if($kiemTra ==0)
                { 
                    $arrGioGiaoVien[]=[
                        'idGiaoVien'=>$item->employee_id,
                        'thoiGian'=>$ngay,
                        'ca'=>$ca,
                        'soGio'=>$soGio
                    ];
                }
                else
                {
                    $arrGioGiaoVien[$soDem]['soGio']=$arrGioGiaoVien[$soDem]['soGio']+$soGio;
                }

                $i =0;
                $soDem =0;
                $kiemTra=0;
                foreach($arrNhanVien as $item2)
                {
                    if($item2['idGiaoVien']==$item->employee_id )
                    {
                        $kiemTra = 1;
                        $soDem=$i;
                    }
                    $i++;
                }
                if($kiemTra ==0)
                { 
                    $arrNhanVien[]=[
                        'idGiaoVien'=>$item->employee_id,
                        'soGioDay'=>$soGio,
                        'soGioVanPhong'=>0,
                        'tongGioVanPhong'=>0
                    ];
                }
                else
                {
                    $arrNhanVien[$soDem]['soGioDay']=$arrNhanVien[$soDem]['soGioDay']+$soGio;
                }
              
            }

            foreach($gioVanPhong as $item)
            {
                $thoiGianBatDau =$item->officeHours_startTime;
                $thoigianketThuc =$item->officeHours_endTime;
                $gio = substr($thoiGianBatDau,0,2);
                $ngay =  date('d/m/Y',strtotime($item->officeHours_date));
         
                $duLieu =$this->getGioVanPhong($item->employee_id,$item->officeHours_date,$item->officeHours_startTime,$item->officeHours_endTime);
                $soGio=$duLieu[0]['soGio'];
                if($gio<12)
                {
                    $ca=1;
                }
                else if($gio>=12 && $gio<17)
                {
                    $ca =2;
                 }
                 else
                 {
                    $ca =3;
                 }

                $i =0;
                $soDem =0;
                $kiemTra=0;
                foreach($arrGioVanPhong as $item2)
                {
                    if($item2['idGiaoVien']==$item->employee_id 
                    && $item2['thoiGian']==$ngay 
                    && $item2['ca']==$ca)
                    {
                        $kiemTra = 1;
                        $soDem=$i;
                    }
                    $i++;
                }

                if($kiemTra ==0)
                { 
                    $arrGioVanPhong[]=[
                        'idGiaoVien'=>$item->employee_id,
                        'thoiGian'=>$ngay,
                        'ca'=>$ca,
                        'soGio'=>$soGio
                    ];
                }
                else
                {
                    $arrGioVanPhong[$soDem]['soGio']=$arrGioVanPhong[$soDem]['soGio']+$soGio;
                }



                $i =0;
                $soDem =0;
                $kiemTra=0;
               
                foreach($arrNhanVien as $item2)
                {
                    if($item2['idGiaoVien']==$item->employee_id )
                    {
                        $kiemTra = 1;
                        $soDem=$i;
                    }
                    $i++;
                }
               

                if($kiemTra ==0)
                { 
                    $arrNhanVien[]=[
                        'idGiaoVien'=>$item->employee_id,
                        'soGioDay'=>0,
                        'soGioVanPhong'=>$soGio
                       
                    ];
                }
                else
                {
                    $arrNhanVien[$soDem]['soGioVanPhong']=$arrNhanVien[$soDem]['soGioVanPhong']+$soGio;
                   
                }
            }
            $i =0;
            $arrNhanVienTong = [];
            foreach($arrNhanVien as $item)
            {
                $nhanVien = DB::table('st_employee')
                ->where('employee_id',$item['idGiaoVien'])
                ->get()
                ->first();
                if($nhanVien->employee_office==1)
                {
                    $tongGioVanPhong = $item['soGioVanPhong']/2;
                }
                else
                {
                    $tongGioVanPhong=$item['soGioVanPhong'];
                }
                $tongGioDaLam = $item['soGioDay'] + $tongGioVanPhong;
                $gioCongNo  = DB::table('st_Debt')
                ->where('employee_id',$item['idGiaoVien'])
                ->whereMonth('Debt_date',$thang-1)
                ->whereYear('Debt_date',$nam)
                ->get()->first();
                if(isset($gioCongNo))
                {
                    $tongGioNo = $gioCongNo->Debt_numner;
                }
                else
                {
                    $tongGioNo=0;
                }
                $ngayNghi = DB::table('st_resignation_application')
                ->join('st_application_leave','st_application_leave.applicationLeave_id',
                '=','st_resignation_application.applicationLeave_id')
                ->where('st_resignation_application.employee_id',$item['idGiaoVien'])
                ->where('st_resignation_application.resignationApplication_date','>=',$ngayBatDauChinh)
                ->where('st_resignation_application.resignationApplication_date','<=',$ngayKetThucChinh)
                ->get();
                $tongGioCanLam =0;
                $gioCon =0;
                if($nhanVien->employee_type==1)
                {
                    $tongGioLam = $nhanVien->employee_numberHours;
                    $tongGioCanLam = $tongGioLam+ $tongGioNo;
                }
                else
                {
                    $tongGioLam = $tongGioTuan;
                    $tongGioCanLam  = $tongGioTuan;
                }
                $trungBinhGioLam = $nhanVien->employee_numberHours/($ngayTuan-4);
                $thoiGianNghi =0;
                foreach($ngayNghi as $item2)
               {
                    if($nhanVien->employee_type==1)
                    {
                        if($item2->applicationLeave_isDate==1)
                        {
                            $thoiGianNghi += $trungBinhGioLam;
                        }
                        else
                        {
                            $thoiGianNghi += $trungBinhGioLam/2;
                        }
                    }
                    else
                    {
                        $thoiGianNghi +=$item2->applicationLeave_number;
                    }
                  
               }
               $thoiGianNghi = round($thoiGianNghi,2);

               if($nhanVien->employee_type==1)
               $thoiGianDu = $tongGioCanLam - $thoiGianNghi - $tongGioDaLam;
               else
               $thoiGianDu=0;


               $thoiGianDu = round($thoiGianDu,2);
               if($tongGioCanLam-$thoiGianNghi==0)
               {
                   $soChia =1;
               }
               else
               {
                   $soChia = $tongGioCanLam-$thoiGianNghi;
               }
               $phanTram = $tongGioDaLam/$soChia *100;


               $arrNhanVienTong[]=[
                'idGiaoVien'=>$item['idGiaoVien'],
                'soGioDay'=>$item['soGioDay'],
                'soGioVanPhong'=>$item['soGioVanPhong'],
                'tongGioVanPhong'=>$tongGioVanPhong,
                'thoiGianLam'=>$tongGioCanLam,
                'gioNo'=>round($tongGioNo,2),
                'tongGioDaLam'=>$tongGioDaLam,
                'tongGioNghi'=>round($thoiGianNghi,2),
                'thoiGianDu'=>round($thoiGianDu,2),
                'phanTram'=>round($phanTram,1)."%" 
                ];

                $congNo = DB::table('st_Debt')
                ->whereMonth('Debt_date',$thang)
                ->whereYear('Debt_date',$nam)
                ->where('employee_id',$item['idGiaoVien'])
                ->get()
                ->first();
                if(isset($congNo))
                {
                    DB::table('st_Debt')
                ->whereMonth('Debt_date',$thang)
                ->whereYear('Debt_date',$nam)
                ->where('employee_id',$item['idGiaoVien'])
                ->update([
                    'Debt_numner'=>$thoiGianDu
                ]);
                

                }
                else
                {
                    DB::table('st_Debt')
                    ->insert([
                        'Debt_date'=>$nam."-".$thang."-01",
                        'employee_id'=>$item['idGiaoVien'],
                        'Debt_numner'=>$thoiGianDu
                    ]);
                }



                $i++;
            }





            return view('GioVanPhong.lichTongQuat')
            ->with('gioTuan',$gioTuan)
            ->with('ngayTuan',$ngayTuan)
            ->with('soTuan',$soTuan)
            ->with('tongGioTuan',$tongGioTuan)
            ->with('thoiGian',$thoiGian)
            ->with('phongBan',$phongBan)
            ->with('giaoVien',$giaoVien)
            ->with('arrGioGiaoVien',$arrGioGiaoVien)
            ->with('arrGioVanPhong',$arrGioVanPhong)
            ->with('arrNhanVien',$arrNhanVienTong)
            ->with('ngayBatDauChinh',$ngayBatDauChinh)
            ->with('ngayKetThucChinh',$ngayKetThucChinh)
            ->with('thang',$thang)
            ->with('nam',$nam)
            ;
        }
        else
        {
            return redirect()->back();
        }

        
    }


    public function getGioVanPhong($id,$ngay,$thoiGianBatDau,$thoigianketThuc)
    {

            $soGio=0;
            $khoangThoiGian="";
          
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
         
            $classTime = DB::table('class_time_employee')
            ->where('classTime_startDate','>=',$ngay." ".$thoiGianBatDau)
            ->where('classTime_endDate','<=',$ngay." ".$thoigianketThuc)
            ->where('class_statusSchedule',1)  
            ->where('class_status',1)
            ->where('employee_id',$id)
            ->where('classTimeEmployee_type','!=',3)
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

        $arr[]=[
            'soGio'=>$soGio,
            'khoangThoiGian'=>$khoangThoiGian
        ];

        return $arr;
    }
}
