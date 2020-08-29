<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class xepLichChiNhanhController extends Controller
{
    public function getLichChiNhanh()
    {
        $quyen = new quyenController();
        $quyenXem = $quyen->getXepLichChiNhanh();
        if ($quyenXem== 1) {
           $chiNhanh = DB::table('st_branch')
           ->get();
           return view('XepLichLopHoc.xepLichChiNhanh')
           ->with('chiNhanh',$chiNhanh);

        }
         else
        return redirect()->back();        
    }
    public function kiemTraLe($date)
    {
       $ngayLe=  DB::table('st_holiday')
        ->where('holiday_startDate','<=',$date)
        ->where('holiday_endDate','>=',$date)
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


    public function lichChiNhanh($idChiNhanh,$tuan,$idClass)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
      
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
        $tongHocVien=0;
        if($idChiNhanh!=0)
        {
            $danhSachLop = DB::table('st_class_time')
            ->join('st_class','st_class.class_id','=','st_class_time.class_id')
            ->where('st_class.branch_id',$idChiNhanh)
            ->where('st_class.class_status',1)
            ->whereDate('st_class_time.classTime_startDate','>=',$ngayBatDauChinh)
            ->whereDate('st_class_time.classTime_startDate','<=',$ngayKetThucChinh)
            ->where(function($query) use($idClass)
            {
                $query->where('st_class.class_statusSchedule',1)  
                ->orWhere('st_class.class_id',$idClass);        
              })
            //->where('st_class.class_id',$idClass)
              ->orderBy('st_class_time.classTime_startTime')
              ->select('st_class_time.*','st_class.class_id','st_class.class_name'
              ,'st_class.class_material','st_class.class_startDay','st_class.class_endDay')
              
              
            ->get();
        }  
        else
        {
            $danhSachLop = DB::table('st_class_time')
            ->join('st_class','st_class.class_id','=','st_class_time.class_id')
            ->whereDate('st_class_time.classTime_startDate','>=',$ngayBatDauChinh)
            ->whereDate('st_class_time.classTime_startDate','<=',$ngayKetThucChinh)
            ->where('st_class.class_status',1)
            
            //->where('st_class.class_id',$idClass)
            ->where(function($query) use($idClass)
            {
                $query->where('st_class.class_statusSchedule',1)  
                ->orWhere('st_class.class_id',$idClass);        
              })
              ->orderBy('st_class_time.classTime_startTime')
              ->select('st_class_time.*','st_class.class_id','st_class.class_name'
              ,'st_class.class_material','st_class.class_startDay','st_class.class_endDay')
            ->get();
        }




        $arrLop=[];
     
        $arrTrungGio = [];
        $soThuTu=1;
       
        $kiemTraTrungGio=0;
        $gioBatDauDau ="";
        $gioKetThucDau= "";
        $soLanTrungGio=0;


        $thuTuTrungGio =0;
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
                    if($itemLop['TimeStart']== date('H:i',strtotime( $item->classTime_startDate))
                    &&  $itemLop['TimeEnd']== date('H:i',strtotime( $item->classTime_endDate))
                    && $itemLop['idPhong']==$item->room_id)
                    {
                        $checkLop=1;
                    }
                    else
                    {
                        if( $arrLop[$viTriMang]['trangThai']==0)
                        {
                            $arrLop[$viTriMang]['soKem']=".1";
                            $arrLop[$viTriMang]['trangThai']=1;
                          
                        }
                        $soLopTrung++;
                        if($sttLopTrung==0)
                        $sttLopTrung = $itemLop['stt'] ;
                      
                        
                    }
                  
                }
              $viTriMang++;
            }
        
            
            if ($checkLop==0)
            {
      
                $chiNhanh = DB::table('st_branch')
                    ->join('st_room','st_room.branch_id','=',
                        'st_branch.branch_id')
                    ->where('st_room.room_id',$item->room_id)
                    ->select('st_branch.*','st_room.room_name','st_room.room_id')
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
                
                    if($sttLopTrung==0)
                    {
                        $stt = $soThuTu;
                        $soKem="";
                        $tongHocVien+= count($hocVien);
                        $trangThai=0;
                    }
                    else
                    {
                        $stt = $sttLopTrung;
                        $soKem = ".".($soLopTrung+1);
                        $soThuTu--;
                        $trangThai =1;
                    }

               
                $arrLop[]=[
                    'stt'=>$stt,
                    'idLop'=>$item->class_id,
                    'chiNhanh'=>$chiNhanh->branch_code,
                    'TimeStart'=> date('H:i',strtotime( $item->classTime_startDate)) ,
                    'TimeEnd'=> date('H:i',strtotime( $item->classTime_endDate)),
                    'tenLop'=>$item->class_name,
                    'siSo'=>count($hocVien),
                    'phong'=>$chiNhanh->room_name,
                    'Material'=>$item->class_material,
                    'ngayBatDau'=>date('M.d',strtotime($item->class_startDay)) ,
                    'ngayKetThuc'=>date('M.d',strtotime($item->class_endDay)),
                    'mid'=>$midText,
                    'final'=>$finalText,
                    'trangThai'=>$trangThai,
                    'soKem'=>$soKem,
                    'idPhong'=>$chiNhanh->room_id
                ];
                $soThuTu++;
            }
            

           
        }
      
        $arrLich = [];
        $ngayTong="";
        $i=0;
        foreach ($arrLop as $item)
        {
            $i++;

            if($kiemTraTrungGio==0)
            {
                $gioBatDauDau = $item['TimeStart'];
                $gioKetThucDau = $item['TimeEnd'];
                $kiemTraTrungGio= 1;
            }
            else
            {
                $gioBatDauSau = $item['TimeStart'];
                $gioKetThucSau = $item['TimeEnd'];

                if($gioBatDauDau==$gioBatDauSau && $gioKetThucDau==$gioKetThucSau)
                {
                    if($soLanTrungGio==0)
                    {
                        $thuTuTrungGio=$i;
                    }
                    $soLanTrungGio++;
                }
                else
                {
                    if($soLanTrungGio>0)
                    {
                        $arrTrungGio[]=[
                            'sttTrung'=>$thuTuTrungGio,
                            'soLan'=>$soLanTrungGio
                        ];
                        $thuTuTrungGio=0;
                        $soLanTrungGio=0;
                       
                    }
                  
                }
                $gioBatDauDau = $gioBatDauSau;
                $gioKetThucDau =$gioKetThucSau;
            }


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
           
                $idClassTime2=0;
                $idClassTime3=0;
                $idClassTime4=0;
                $idClassTime5=0;
                $idClassTime6=0;
                $idClassTime7=0;
                $idClassTime8=0;
          
            foreach ($danhSachLop as $item1)
            {
               
                    $ngay = date('Y-m-d',strtotime($item1->classTime_startDate));
                    $ngayTong.=" ".$ngay;
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

             if($item['TimeStart']== date('H:i',strtotime( $item1->classTime_startDate))
             &&  $item['TimeEnd'] == date('H:i',strtotime( $item1->classTime_endDate))
             && $item['idPhong']==$item1->room_id)  
             {     
                if ($item1->class_id==$item['idLop'] && $ngay==$ngayBatDauChinh )
                {
                    $idClassTime2 = $item1->classTime_id;

                   
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
                    $idClassTime3 = $item1->classTime_id;
                   
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
                    $idClassTime4 = $item1->classTime_id;
                   
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
                    $idClassTime5 = $item1->classTime_id;
                    
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
                    $idClassTime6 = $item1->classTime_id;
                   
                    $noiDung6=$item1->classTime_title;

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
                    $idClassTime7 = $item1->classTime_id;
                   
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
                    $idClassTime8 = $item1->classTime_id;
                   
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
                'troGiang8'=>$troGiang8,
                'idClassTime2'=>$idClassTime2,
                'idClassTime3'=>$idClassTime3,
                'idClassTime4'=>$idClassTime4,
                'idClassTime5'=>$idClassTime5,
                'idClassTime6'=>$idClassTime6,
                'idClassTime7'=>$idClassTime7,
                'idClassTime8'=>$idClassTime8
            ];
        }
        if($soLanTrungGio>0)
        $arrTrungGio[]=[
            'sttTrung'=>$thuTuTrungGio,
            'soLan'=>$soLanTrungGio
        ];
       
       


        $tongGio = $gioThu2+$gioThu3+$gioThu4+$gioThu5+$gioThu6+$gioThu7+$gioThu8;

        $arrValue[]= ['lich'=>$arrLich,
        'tongGio'=>$tongGio,
        'ngayBatDauChinh'=>$ngayBatDauChinh,
       'ngayThu3'=>$ngayThu3,
       'ngayThu4'=>$ngayThu4,
        'ngayThu5'=>$ngayThu5,
       'ngayThu6'=>$ngayThu6,
        'ngayThu7'=>$ngayThu7,
        'ngayKetThucChinh'=>$ngayKetThucChinh,
        'lop'=>$arrLop,
        'lich'=>$arrLich,
        'danhSachLop'=>count($danhSachLop),
        'gioThu2'=>$gioThu2,
        'gioThu3'=>$gioThu3,
        'gioThu4'=>$gioThu4,
        'gioThu5'=>$gioThu5,
        'gioThu6'=>$gioThu6,
        'gioThu7'=>$gioThu7,
        'gioThu8'=>$gioThu8,
        'ngayLe2'=>$ngayLe2,
        'ngayLe3'=>$ngayLe3,
        'ngayLe4'=>$ngayLe4,
        'ngayLe5'=>$ngayLe5,
        'ngayLe6'=>$ngayLe6,
        'ngayLe7'=>$ngayLe7,
        'ngayLe8'=>$ngayLe8,
        'ngayTong'=>$ngayTong,
        'tongHocVien'=>$tongHocVien,
        'arrTrungGio'=>$arrTrungGio
    ];
        return $arrValue;
    }
    public function getLichChiNhanhChiTiet(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichChiNhanh();
        if($quyenChiTiet==1)
        {
            $idChiNhanh = $request->get('id');
            $chiNhanh = DB::table('st_branch')
            ->get();

            
                $idChiNhanh=0;
            if(count($chiNhanh)>0)
            {
                $chiNhanhDau = $chiNhanh->first();
                $idChiNhanh = $chiNhanhDau->branch_id;
            }
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $tuan = $now->week();
           $arr = $this->lichChiNhanh($idChiNhanh,$tuan,0);
            $phong = DB::table('st_room')
            ->where('branch_id',$idChiNhanh)
            ->get();
           $giaoVienThayDoi = DB::table('st_employee')
           ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
           '=','st_employee.employee_id')
           ->where('st_quyen_chi_tiet_quyen.quyen_id',210)
           ->where('st_quyen_chi_tiet_quyen.chiTietQuyen_id',1)
           ->where('st_quyen_chi_tiet_quyen.quyen_chiTietQuyen_trangThai',1)
           ->where('employee_status',1)
          
           ->orderBy('st_employee.employee_id') 
           ->select('st_employee.employee_id','st_employee.employee_name')
           ->get();
          
          
           $troGiangThayDoi = DB::table('st_employee')
           ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
           '=','st_employee.employee_id')
           ->where('quyen_id',211)
           ->where('chiTietQuyen_id',1)
           ->where('quyen_chiTietQuyen_trangThai',1)
           ->orderBy('st_employee.employee_id')
          
           ->where('employee_status',1)
           ->select('st_employee.employee_id','st_employee.employee_name')
           ->get();

           $giaoVienTong = DB::table('st_employee')
           ->where('employee_status',1)
           ->get();

            return view('XepLichLopHoc.chiTietLichChiNhanh')
            ->with('ngayBatDauChinh',$arr[0]['ngayBatDauChinh'])
            ->with('ngayThu3',$arr[0]['ngayThu3'])
            ->with('ngayThu4',$arr[0]['ngayThu4'])
            ->with('ngayThu5',$arr[0]['ngayThu5'])
            ->with('ngayThu6',$arr[0]['ngayThu6'])
            ->with('ngayThu7',$arr[0]['ngayThu7'])
            ->with('ngayKetThucChinh',$arr[0]['ngayKetThucChinh'])
            ->with('chiNhanh',$chiNhanh)
            ->with('lop',$arr[0]['lop'])
            ->with('lich',$arr[0]['lich'])
            ->with('danhSachLop',$arr[0]['danhSachLop'])
            ->with('gioThu2',$arr[0]['gioThu2'])
            ->with('gioThu3',$arr[0]['gioThu3'])
            ->with('gioThu4',$arr[0]['gioThu4'])
            ->with('gioThu5',$arr[0]['gioThu5'])
            ->with('gioThu6',$arr[0]['gioThu6'])
            ->with('gioThu7',$arr[0]['gioThu7'])
            ->with('gioThu8',$arr[0]['gioThu8'])
            ->with('tongGio',$arr[0]['tongGio'])
            ->with('ngayLe2',$arr[0]['ngayLe2'])
            ->with('ngayLe3',$arr[0]['ngayLe3'])
            ->with('ngayLe4',$arr[0]['ngayLe4'])
            ->with('ngayLe5',$arr[0]['ngayLe5'])
            ->with('ngayLe6',$arr[0]['ngayLe6'])
            ->with('ngayLe7',$arr[0]['ngayLe7'])
            ->with('ngayLe8',$arr[0]['ngayLe8'])
            ->with('tuan',$tuan)
            ->with('idChiNhanh',$idChiNhanh)
            ->with('idClass',0)
            ->with('giaoVienThayDoi',$giaoVienThayDoi)
            ->with('troGiangThayDoi',$troGiangThayDoi)
            ->with('giaoVienTong',$giaoVienTong)
            ->with('tongHocVien',$arr[0]['tongHocVien'])
            ->with('arrTrungGio',$arr[0]['arrTrungGio'])
            ->with('phong',$phong)
            ;
            
        }
        else
        return redirect()->back();
    }


    public function postLichChiNhanhTuan(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichChiNhanh();
        if($quyenChiTiet==1)
        {
            $idChiNhanh = $request->get('id');

            $tuan =$request->get('tuan');
            $chiNhanh = DB::table('st_branch')
            ->get();
            $idClass = $request->get('class');
            if($idChiNhanh=="")
            {
                $idChiNhanh=0;
            }
            if($idClass=="")
            {
                $idClass=0;
            }

            $phong = DB::table('st_room')
            ->where('branch_id',$idChiNhanh)
            ->get();
           $arr = $this->lichChiNhanh($idChiNhanh,$tuan,$idClass);
           $giaoVienTong = DB::table('st_employee')
           ->where('employee_status',1)
           ->get();

           $giaoVienThayDoi = DB::table('st_employee')
           ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
           '=','st_employee.employee_id')
           ->where('st_quyen_chi_tiet_quyen.quyen_id',210)
           ->where('st_quyen_chi_tiet_quyen.chiTietQuyen_id',1)
           ->where('st_quyen_chi_tiet_quyen.quyen_chiTietQuyen_trangThai',1)
           ->where('employee_status',1)
          
           ->orderBy('st_employee.employee_id') 
           ->select('st_employee.employee_id','st_employee.employee_name')
           ->get();
          
          
           $troGiangThayDoi = DB::table('st_employee')
           ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
           '=','st_employee.employee_id')
           ->where('quyen_id',211)
           ->where('chiTietQuyen_id',1)
           ->where('quyen_chiTietQuyen_trangThai',1)
           ->orderBy('st_employee.employee_id')
          
           ->where('employee_status',1)
           ->select('st_employee.employee_id','st_employee.employee_name')
           ->get();

            return view('XepLichLopHoc.chiTietLichChiNhanh')
            ->with('ngayBatDauChinh',$arr[0]['ngayBatDauChinh'])
            ->with('ngayThu3',$arr[0]['ngayThu3'])
            ->with('ngayThu4',$arr[0]['ngayThu4'])
            ->with('ngayThu5',$arr[0]['ngayThu5'])
            ->with('ngayThu6',$arr[0]['ngayThu6'])
            ->with('ngayThu7',$arr[0]['ngayThu7'])
            ->with('ngayKetThucChinh',$arr[0]['ngayKetThucChinh'])
            ->with('chiNhanh',$chiNhanh)
            ->with('lop',$arr[0]['lop'])
            ->with('lich',$arr[0]['lich'])
            ->with('danhSachLop',$arr[0]['danhSachLop'])
            ->with('gioThu2',$arr[0]['gioThu2'])
            ->with('gioThu3',$arr[0]['gioThu3'])
            ->with('gioThu4',$arr[0]['gioThu4'])
            ->with('gioThu5',$arr[0]['gioThu5'])
            ->with('gioThu6',$arr[0]['gioThu6'])
            ->with('gioThu7',$arr[0]['gioThu7'])
            ->with('gioThu8',$arr[0]['gioThu8'])
            ->with('tongGio',$arr[0]['tongGio'])
            ->with('ngayLe2',$arr[0]['ngayLe2'])
            ->with('ngayLe3',$arr[0]['ngayLe3'])
            ->with('ngayLe4',$arr[0]['ngayLe4'])
            ->with('ngayLe5',$arr[0]['ngayLe5'])
            ->with('ngayLe6',$arr[0]['ngayLe6'])
            ->with('ngayLe7',$arr[0]['ngayLe7'])
            ->with('ngayLe8',$arr[0]['ngayLe8'])
            ->with('tuan',$tuan)
            ->with('idChiNhanh',$idChiNhanh)
            ->with('idClass',$idClass)
            ->with('ngayTong',$arr[0]['ngayTong'])
            ->with('giaoVienThayDoi',$giaoVienThayDoi)
            ->with('troGiangThayDoi',$troGiangThayDoi)
            ->with('giaoVienTong',$giaoVienTong)
            ->with('tongHocVien',$arr[0]['tongHocVien'])
            ->with('arrTrungGio',$arr[0]['arrTrungGio'])
            ->with('phong',$phong)
            ;
        }
        else
        return redirect()->back();
    }
    public function getValueXuatLichChiNhanh(Request $request)
    {
        if($request->ajax())
        {
            $idChiNhanh = $request->get('chiNhanh');
            $tuan = $request->get('tuan');
            $arr = $this->lichChiNhanh($idChiNhanh,$tuan,0);
            $lop = $arr[0]['lop'];
            $arrTrungGio = $arr[0]['arrTrungGio'];
           
            $out="";    
            $ngayLe2 = $arr[0]['ngayLe2'] ; 
            $ngayLe3 = $arr[0]['ngayLe3'] ; 
            $ngayLe4 = $arr[0]['ngayLe4'] ; 
            $ngayLe5 = $arr[0]['ngayLe5'] ; 
            $ngayLe6 = $arr[0]['ngayLe6'] ; 
            $ngayLe7 = $arr[0]['ngayLe7'] ; 
            $ngayLe8 = $arr[0]['ngayLe8'] ;
            $tongHocVien =  $arr[0]['tongHocVien'];  
            $lich = $arr[0]['lich']; 
            $ngayBatDauChinh = $arr[0]['ngayBatDauChinh'];
            $ngayThu3 = $arr[0]['ngayThu3'];
            $ngayThu4 = $arr[0]['ngayThu4'];
            $ngayThu5 = $arr[0]['ngayThu5'];
            $ngayThu6 = $arr[0]['ngayThu6'];
            $ngayThu7 = $arr[0]['ngayThu7'];
            $ngayKetThucChinh = $arr[0]['ngayKetThucChinh'];
            
            $soLanTrung=0; $soLanLapTrung=0;$kiemTraTrung=0;
            for($i=0;$i<count($lop);$i++)
            {

                if($kiemTraTrung==0)
                {
                    for($j = 0; $j<count($arrTrungGio);$j++)
                    {
                        if($arrTrungGio[$j]['sttTrung']-2==$i)
                        {
                            $kiemTraTrung=1; 
                            $soLanTrung=$arrTrungGio[$j]['soLan']; 
                        }
                     
                    }
                   
                }
                   
           
                          
                $out.='  <tr>
                    <td>'.$lop[$i]['stt'].$lop[$i]['soKem'].'  </td>';

                    if($kiemTraTrung==0)
                    {
                        $out.='<td>'.$lop[$i]['TimeStart'].' '.$lop[$i]['TimeEnd'].'</td>';
                    }
                   else
                   {
                        if($soLanLapTrung==0)
                        $out.=' <td rowspan="'. ($soLanTrung+1) .'">'.$lop[$i]['TimeStart'].' '.$lop[$i]['TimeEnd'].'</td>';
                      
                        $soLanLapTrung++ ;
                        if($soLanLapTrung>$soLanTrung)
                        {
                            $soLanTrung=0; $soLanLapTrung=0;$kiemTraTrung=0; 
                        }
                        
                   } 
                       
                 
                   $out.='
                    <td>'.$lop[$i]['tenLop'].'</td>
                    <td>'.$lop[$i]['siSo'].'</td>
                    <td>'.$lop[$i]['phong'].'</td>
                    <td>'.$lop[$i]['Material'].'</td>
                    <td>'.$lop[$i]['ngayBatDau'].'</td>
                    <td>'.$lop[$i]['mid'].'</td>
                    <td>'.$lop[$i]['final'].'</td>
                    <td>'.$lop[$i]['ngayKetThuc'].'</td>';

                    if($ngayLe2=="")
                    {
                        $out.=' <td onclick="changeLich(\''. $lich[$i]['idClassTime2'] .'\',\''. date('m/d/Y',strtotime($ngayBatDauChinh)) .'\'
                        ,\''.$lop[$i]['TimeStart'].'\',\''.$lop[$i]['TimeEnd'].'\');">
                            <b>'.$lich[$i]['giaoVien2'].'</b><br>
                            <b>'.$lich[$i]['troGiang2'].'</b><br>';
                            
                            if($lich[$i]['noiDung2']!="")
                            $out.= $lich[$i]['noiDung2'] ;
                           
                            $out.='  </td>';
                    }
                   else
                   {
                    $out.='  <td style="color: red;text-align:center;
                    transform: rotate(90deg);">'. $ngayLe2 .'</td>';
                   }
                   
                    if($ngayLe3=="")
                    {
                        $out.='  <td  onclick="changeLich(\''. $lich[$i]['idClassTime3'] .'\',\''. date('m/d/Y',strtotime($ngayThu3)) .'\'
                        ,\''.$lop[$i]['TimeStart'].'\',\''.$lop[$i]['TimeEnd'].'\');">
                            <b>'.$lich[$i]['giaoVien3'].'</b><br>
                            <b>'.$lich[$i]['troGiang3'].'</b><br>';
                            if($lich[$i]['noiDung3']!="")
                            $out.= $lich[$i]['noiDung3'] ;
                            $out.='  </td>';
                    }else 
                    {
                        $out.='  <td style="color: red;text-align:center;
                        transform: rotate(90deg);">'. $ngayLe3 .'</td>';
                    }
                 
                  
                    if($ngayLe4=="")
                    {
                        $out.=' <td  onclick="changeLich(\''. $lich[$i]['idClassTime4'] .'\',\''. date('m/d/Y',strtotime($ngayThu4)) .'\'
                        ,\''.$lop[$i]['TimeStart'].'\',\''.$lop[$i]['TimeEnd'].'\');">
                            <b>'.$lich[$i]['giaoVien4'].'</b><br>
                            <b>'.$lich[$i]['troGiang4'].'</b><br>';
                            if($lich[$i]['noiDung4']!="")
                            $out.=$lich[$i]['noiDung4'] ;
                            
                            $out.='</td>';
                    }
                  
                    else 
                    {
                        $out.='<td style="color: red;text-align:center;
                        transform: rotate(90deg);">'. $ngayLe4 .'</td>';
                    }
                   
                   if($ngayLe5=="")
                   {
                    $out.=' <td  onclick="changeLich(\''. $lich[$i]['idClassTime5'] .'\',\''. date('m/d/Y',strtotime($ngayThu5)) .'\'
                    ,\''.$lop[$i]['TimeStart'].'\',\''.$lop[$i]['TimeEnd'].'\');">
                        <b>'.$lich[$i]['giaoVien5'].'</b><br>
                        <b>'.$lich[$i]['troGiang5'].'</b><br>';
                        if($lich[$i]['noiDung5']!="")
                        $out.= $lich[$i]['noiDung5'] ;
                        $out.=' </td>';
                   }
                 else 
                 {
                    $out.='  <td style="color: red;text-align:center;
                    transform: rotate(90deg);">'. $ngayLe5 .'</td>';
                 }
                   
                   if($ngayLe6=="")
                   {
                    $out.='<td  onclick="changeLich(\''. $lich[$i]['idClassTime6'] .'\',\''. date('m/d/Y',strtotime($ngayThu6)) .'\'
                    ,\''.$lop[$i]['TimeStart'].'\',\''.$lop[$i]['TimeEnd'].'\');">
                        <b>'.$lich[$i]['giaoVien6'].'</b><br>
                        <b>'.$lich[$i]['troGiang6'].'</b><br>';
                        if($lich[$i]['noiDung6']!="")
                        $out.=$lich[$i]['noiDung6'] ;
                        $out.='
                    </td>';
                   }
                   else 
                   {
                    $out.=' <td style="color: red;text-align:center;
                    transform: rotate(90deg);">'. $ngayLe6 .'</td>';
                   }
                  
                   if($ngayLe7=="")
                   {
                    $out.='  <td  onclick="changeLich(\''. $lich[$i]['idClassTime7'] .'\',\''. date('m/d/Y',strtotime($ngayThu7)) .'\'
                    ,\''.$lop[$i]['TimeStart'].'\',\''.$lop[$i]['TimeEnd'].'\');">
                        <b>'.$lich[$i]['giaoVien7'].'</b><br>
                        <b>'.$lich[$i]['troGiang7'].'</b><br>';
                        if($lich[$i]['noiDung7']!="")
                        $out.= $lich[$i]['noiDung7'] ;
                       
                        $out.='</td>';
                   }else 
                   {
                    $out.=' <td style="color: red;text-align:center;
                    transform: rotate(90deg);">'. $ngayLe7 .'</td>';
                   }
                   
                   if($ngayLe8=="")
                   {
                    $out.='<td  onclick="changeLich(\''. $lich[$i]['idClassTime8'] .'\',\''. date('m/d/Y',strtotime($ngayKetThucChinh)) .'\'
                    ,\''.$lop[$i]['TimeStart'].'\',\''.$lop[$i]['TimeEnd'].'\');">
                        <b>'.$lich[$i]['giaoVien8'].'</b><br>
                        <b>'.$lich[$i]['troGiang8'].'</b><br>';
                      
                        if($lich[$i]['noiDung8']!="")
                        $out.= $lich[$i]['noiDung8d'] ;
                        
                        $out.='</td>';
                   }
                   
                    else 
                    {
                        $out.=' <td style="color: red;text-align:center;
                        transform: rotate(90deg);">'. $ngayLe8 .'</td>';
                    }
                  
                   
                    $out.='</tr>';
            }

            
            $out.='   <tr>
                <td colspan="17">Total Students: <b>'.$tongHocVien.' student</b></td>
               
                
            </tr>';

            return response($out);
        }
    }

    public function getGioLamChiNhanh(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichChiNhanh();
        if($quyenChiTiet==1)
        {
        $idChiNhanh = $request->get('id');
     
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

        $chiNhanh = DB::table('st_branch')
            ->where('branch_id',$idChiNhanh)
            ->get()->first();
        $lich  = DB::table('st_class_time')
            ->join('st_class','st_class.class_id','=',
                'st_class_time.class_id')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id','=',
                'st_class_time.classTime_id')
                ->join('st_employee','st_employee.employee_id','=',
                'st_class_time_employee.employee_id')
            ->where('st_class.branch_id',$idChiNhanh)
            ->whereDate('classTime_startDate','>=',$ngayBatDauChinh)
            ->whereDate('classTime_startDate','<=',$ngayKetThucChinh)
            ->select('st_class_time.*','st_class.class_id','st_class.class_name','st_employee.employee_name')
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
                'giaoVien'=>$item->employee_name
            ];
            $tongGio+=$gioThu;
        }

        return view('XepLichLopHoc.gioLamViecChiNhanh')
            ->with('chiNhanh',$chiNhanh)
            ->with('ngayBatDauChinh',$ngayBatDauChinh)
            ->with('ngayKetThucChinh',$ngayKetThucChinh)
            ->with('arrGioLamViec',$arrGioLamViec)
            ->with('tongGio',$tongGio)
            ->with('idchiNhanh',$idChiNhanh )
            ;
        }
        else
        return redirect()->back();
    }
    public function postTimGioChiNhanh(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXepLichChiNhanh();
        if($quyenChiTiet==1)
        {
        $idChiNhanh = $request->get('id');
     
        $thoiGian = $request->get('thoiGian');
        $ngay1= substr($thoiGian,3,2);
        $thang1= substr($thoiGian,0,2);
        $nam1= substr($thoiGian,6,4);

        $ngay2= substr($thoiGian,16,2);
        $thang2= substr($thoiGian,13,2);
        $nam2= substr($thoiGian,19,4);

        $ngayBatDauChinh = new Carbon($nam1."-".$thang1."-".$ngay1);
        $ngayKetThucChinh = new Carbon($nam2."-".$thang2."-".$ngay2);

        $chiNhanh = DB::table('st_branch')
            ->where('branch_id',$idChiNhanh)
            ->get()->first();
        $lich  = DB::table('st_class_time')
            ->join('st_class','st_class.class_id','=',
                'st_class_time.class_id')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id','=',
                'st_class_time.classTime_id')
                ->join('st_employee','st_employee.employee_id','=',
                'st_class_time_employee.employee_id')
            ->where('st_class.branch_id',$idChiNhanh)
            ->whereDate('classTime_startDate','>=',$ngayBatDauChinh)
            ->whereDate('classTime_startDate','<=',$ngayKetThucChinh)
            ->select('st_class_time.*','st_class.class_id','st_class.class_name','st_employee.employee_name')
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
                'giaoVien'=>$item->employee_name
            ];
            $tongGio+=$gioThu;
        }

        return view('XepLichLopHoc.gioLamViecChiNhanh')
            ->with('chiNhanh',$chiNhanh)
            ->with('ngayBatDauChinh',$ngayBatDauChinh)
            ->with('ngayKetThucChinh',$ngayKetThucChinh)
            ->with('arrGioLamViec',$arrGioLamViec)
            ->with('tongGio',$tongGio)
            ->with('idchiNhanh',$idChiNhanh )
            ;
        }
        else
        return redirect()->back();
    }

    public function getDanhSachLopXepLich(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->get('id');
            if($id==0)
            {
                $lopHoc = DB::table('st_class')
            ->join('st_branch','st_branch.branch_id','=','st_class.branch_id')
            ->where('st_class.class_statusSchedule',0)
            ->where('st_class.class_status',1)
            ->get();
            }
            else
            {
                $lopHoc = DB::table('st_class')
            ->join('st_branch','st_branch.branch_id','=','st_class.branch_id')
            ->where('st_class.class_statusSchedule',0)
            ->where('st_class.class_status',1)
            ->get();
            }
          

            $i=1;
            $out="";
            foreach($lopHoc as $item)
            {
                $out.="<tr>
                <td>".$i."</td>
                <td>$item->branch_name</td>
              
                <td>$item->class_name</td>
                <td> ".date('d/m/Y',strtotime($item->class_startDay)) ."</td>
                <td>".date('d/m/Y',strtotime($item->class_endDay)) ."</td>
                <td><a href='".route('getXepLichLop')."?id=".$item->class_id."'><i class='fa fa-edit'></i></a></td>
                    </tr>";

                $i++;
            }
            return response($out);
        }
    }

    public function getChangeLich(Request $request)
    {
        if($request->ajax())
        {
            $idClassTime = $request->get('idClassTime');
            $giaoVien = DB::table('st_class_time')
            ->join('st_class_time_employee','st_class_time_employee.classTime_id',
            '=','st_class_time.classTime_id')
            ->where('st_class_time.classTime_id',$idClassTime)
            ->where('st_class_time_employee.classTimeEmployee_type',1)
            ->select('st_class_time_employee.employee_id')
            ->get()->first();
            if(isset($giaoVien))
            {
                $idGiaoVien = $giaoVien->employee_id;
            }
            else
            {
                $idGiaoVien =0;
            }

            $troGiang = DB::table('st_class_time')
            ->join('st_class_time_employee','st_class_time_employee.classTime_id',
            '=','st_class_time.classTime_id')
            ->where('st_class_time.classTime_id',$idClassTime)
            ->where('st_class_time_employee.classTimeEmployee_type',2)
            ->select('st_class_time_employee.employee_id')
            ->get()->first();
            if(isset($troGiang))
            {
                $idTroGiang = $troGiang->employee_id;
            }
            else
            {
                $idTroGiang =0;
            }

            $giaoVienThayDoi = DB::table('st_employee')
            ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
            '=','st_employee.employee_id')
            ->where('st_quyen_chi_tiet_quyen.quyen_id',210)
            ->where('st_quyen_chi_tiet_quyen.chiTietQuyen_id',1)
            ->where('st_quyen_chi_tiet_quyen.quyen_chiTietQuyen_trangThai',1)
            ->where('employee_status',1)
            ->where('st_employee.employee_id','!=',$idGiaoVien)
            ->orderBy('st_employee.employee_id') 
            ->select('st_employee.employee_id','st_employee.employee_name')
            ->get();
           
           
            $troGiangThayDoi = DB::table('st_employee')
            ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
            '=','st_employee.employee_id')
            ->where('quyen_id',211)
            ->where('chiTietQuyen_id',1)
            ->where('quyen_chiTietQuyen_trangThai',1)
            ->orderBy('st_employee.employee_id')
            ->where('st_employee.employee_id','!=',$idTroGiang)
            ->where('employee_status',1)
            ->select('st_employee.employee_id','st_employee.employee_name')
            ->get();

            $out='<label>Teacher</label>
            <select class="js-example-responsive" style="width: 100%" id="giaoVien" name="giaoVien"  onchange="kiemTraGioHoc();">';
            foreach($giaoVienThayDoi as $item)
            $out.='<option value="'.$item->employee_id.'">'.$item->employee_name.'</option>';
            
            $out.='</select>';
            


            return response($out);
        }
    }
    
    public function postCapNhatLichDayNganHan(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXepLichChiNhanh();
            if($quyenChiTiet==1)
            {
                $idClass = $request->get('id');
                $giaoVien = $request->get('giaoVien');
                $troGiang = $request->get('troGiang');
                $ngay = $request->get('ngayBatDau');
                $gioBatDau = $request->get('gioBatDau');
                $gioKetThuc = $request->get('gioKetThuc');
                $kiemTra = "";

                $thoiGian = substr($ngay,6,4)."-".substr($ngay,0,2)."-".substr($ngay,3,2);
                $thoiGianBatDau = $thoiGian . " ".$gioBatDau;
                $thoiGianKetThuc= $thoiGian . " ".$gioKetThuc;
                $phong = $request->get('phong');


                $kiemTra.=$this->kiemTraGiaoVienThayDoiNganhang($idClass,$giaoVien,$thoiGianBatDau,$thoiGianKetThuc);
               if($troGiang!=0)
                $kiemTra.=$this->kiemTraGiaoVienThayDoiNganhang($idClass,$troGiang,$thoiGianBatDau,$thoiGianKetThuc);
                $kiemTra.=$this->kiemTraPhongThayDoiNganhang($idClass,$phong,$thoiGianBatDau,$thoiGianKetThuc);

                if($kiemTra=="")
                {
                    try
                    {
                        DB::table('st_class_time')
                        ->where('classTime_id',$idClass)
                        ->update([
                            'classTime_startDate'=>$thoiGianBatDau,
                            'classTime_endDate'=>$thoiGianKetThuc,
                            'room_id'=>$phong
                        ]);


                        DB::table('st_class_time_employee')
                        ->where('classTime_id',$idClass)
                        ->where('classTimeEmployee_type',1)
                        ->update([
                            'employee_id'=>$giaoVien
                        ]);
                        if($troGiang!=0)
                        DB::table('st_class_time_employee')
                        ->where('classTime_id',$idClass)
                        ->where('classTimeEmployee_type',2)
                        ->update([
                            'employee_id'=>$troGiang
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
                    return response($kiemTra);
                }
            }
            else
            return response(2);
        }
    }

    public function kiemTraGiaoVienThayDoiNganhang($idClass,$giaoVien,$thoiGianBatDau,$thoiGianKetThuc)
    {
        $kiemTra="";
        $lop = DB::table('st_class_time')
                ->where('classTime_id',$idClass)
                ->get()->first();
              
                    $lichGiaoVien = DB::table('st_class_time')
                    ->join('st_class_time_employee','st_class_time_employee.classTime_id','=',
                    'st_class_time.classTime_id')
                    ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                    ->where('st_class.class_statusSchedule',1)
                    ->where('st_class_time_employee.classTimeEmployee_type','!=',3)
                    ->where('st_class_time_employee.employee_id',$giaoVien)
                    ->where('st_class_time.classTime_startDate','<=',$thoiGianBatDau)
                    ->where('st_class_time.classTime_endDate','>=',$thoiGianBatDau)
                    ->where('st_class.class_status',1)
                    ->where('st_class_time.classTime_id','!=',$idClass)
                    ->get()->first();
                if (isset($lichGiaoVien))
                {
                    $kiemTra.=" Ngày ".date('d/m/Y H:i',strtotime($lichGiaoVien->classTime_startDate))." Đã Có Lịch.";

                }
                else
                {
                    $lichGiaoVien = DB::table('st_class_time')
                    ->join('st_class_time_employee','st_class_time_employee.classTime_id','=',
                    'st_class_time.classTime_id')
                    ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                    ->where('st_class.class_statusSchedule',1)
                    ->where('st_class_time_employee.employee_id',$giaoVien)
                    ->where('st_class_time_employee.classTimeEmployee_type','!=',3)
                    ->where('st_class.class_status',1)
                        ->where('st_class_time.classTime_startDate','<=',$thoiGianKetThuc)
                        ->where('st_class_time.classTime_endDate','>=',$thoiGianKetThuc)
                        ->where('st_class_time.classTime_id','!=',$idClass)
                        ->get()->first();

                    if (isset($lichGiaoVien))
                    {
                        $kiemTra.=" Ngày ".date('d/m/Y H:i',strtotime($lichGiaoVien->classTime_startDate))." Đã Có Lịch.";
                       
                    }
                    else
                    {
                        $lichGiaoVien = DB::table('st_class_time')
                        ->join('st_class_time_employee','st_class_time_employee.classTime_id','=',
                        'st_class_time.classTime_id')
                        ->where('st_class.class_statusSchedule',1)
                        ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                        ->where('st_class.class_statusSchedule',1)
                        ->where('st_class.class_status',1)
                        ->where('st_class_time_employee.employee_id',$giaoVien)
                        ->where('st_class_time_employee.classTimeEmployee_type','!=',3)
                            ->where('st_class_time.classTime_startDate','>=',$thoiGianBatDau)
                            ->where('st_class_time.classTime_endDate','<=',$thoiGianKetThuc)
                            ->where('st_class_time.classTime_id','!=',$idClass)
                            ->get()->first();
                        if (isset($lichGiaoVien))
                        {
                            $kiemTra.=" Ngày ".date('d/m/Y H:i',strtotime($lichGiaoVien->classTime_startDate))." Đã Có Lịch.";

                        }
                    }
                }
                return $kiemTra;
    }
    public function kiemTraPhongThayDoiNganhang($idClass,$phong,$thoiGianBatDau,$thoiGianKetThuc)
    {
        $kiemTra="";
        $lop = DB::table('st_class_time')
                ->where('classTime_id',$idClass)
                ->get()->first();
              
                    $lichGiaoVien = DB::table('st_class_time')
                    ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                    ->where('st_class.class_statusSchedule',1)
                    ->where('st_class_time.room_id',$phong)
                    ->where('st_class_time.classTime_startDate','<=',$thoiGianBatDau)
                    ->where('st_class_time.classTime_endDate','>=',$thoiGianBatDau)
                    ->where('st_class.class_status',1)
                    ->where('st_class_time.classTime_id','!=',$idClass)
                    ->get()->first();
                if (isset($lichGiaoVien))
                {
                    $kiemTra.=" Ngày ".date('d/m/Y H:i',strtotime($lichGiaoVien->classTime_startDate))." phòng trùng.";

                }
                else
                {
                    $lichGiaoVien = DB::table('st_class_time')
                    ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                    ->where('st_class.class_statusSchedule',1)
                    ->where('st_class_time.room_id',$phong)
                    ->where('st_class.class_status',1)
                        ->where('st_class_time.classTime_startDate','<=',$thoiGianKetThuc)
                        ->where('st_class_time.classTime_endDate','>=',$thoiGianKetThuc)
                        ->where('st_class_time.classTime_id','!=',$idClass)
                        ->get()->first();

                    if (isset($lichGiaoVien))
                    {
                        $kiemTra.=" Ngày ".date('d/m/Y H:i',strtotime($lichGiaoVien->classTime_startDate))." phòng trùng.";
                       
                    }
                    else
                    {
                        $lichGiaoVien = DB::table('st_class_time')
                       
                        ->where('st_class.class_statusSchedule',1)
                        ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                        ->where('st_class.class_statusSchedule',1)
                        ->where('st_class.class_status',1)
                        ->where('st_class_time.room_id',$phong)
                            ->where('st_class_time.classTime_startDate','>=',$thoiGianBatDau)
                            ->where('st_class_time.classTime_endDate','<=',$thoiGianKetThuc)
                            ->where('st_class_time.classTime_id','!=',$idClass)
                            ->get()->first();
                        if (isset($lichGiaoVien))
                        {
                            $kiemTra.=" Ngày ".date('d/m/Y H:i',strtotime($lichGiaoVien->classTime_startDate))." phòng trùng.";

                        }
                    }
                }
                return $kiemTra;
    }
    public function getXuatLichGiaoVien(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXepLichChiNhanh();
            if($quyenChiTiet==1)
            {
                $tuan = $request->get('tuan');
                $giaoVien = $request->get('giaoVien');
                $chiNhanh= $request->get('chiNhanh');
                if($giaoVien!=0)
                $duLieu = $this->getlichGiaoVien($tuan,$giaoVien,$chiNhanh);
                else
                $duLieu = $this->getlichTatCaGiaoVien($tuan,$chiNhanh);

                $chiNhanhChinh = DB::table('st_branch')
                ->where('branch_id',$chiNhanh)->get()->first();
                if(isset($chiNhanhChinh))
                {
                    $tenChiNhanh = $chiNhanhChinh->branch_name;
                }
                else
                {
                    $tenChiNhanh="";
                }

                $lop = $duLieu[0]['lop'];
                $lich = $duLieu[0]['lich'];
                $arrTrungGio = $duLieu[0]['arrTrungGio'];
                
               // $out= $duLieu[0]['ngayBatDauChinh'];
                $out ='  <div style="text-align: center">
                <h4 class="card-title">CLASSES SCHEDULE</h4>
                <h4><b>('.date('M.d',strtotime($duLieu[0]['ngayBatDauChinh'])).' - '.date('M.d',strtotime($duLieu[0]['ngayKetThucChinh'])).')</b></h4>
                
                    </div>

                    <br>
                    <div>
                        <h4><b>Branch:</b> '.$tenChiNhanh.' </h4>
                        <h4><b>Teacher\'s name:</b> '.$duLieu[0] ['giaoVien'].' </h4>
                    </div>
                    <div style="text-align: center;">
                    <table class="table table-striped table-bordered ">
                    <thead>
                        <tr >
                            <th style="width: 5px">No</th>
                           
                            <th style="width: 5px">Time</th>
                            <th style="width: 5px">Class name</th>
                            <th style="width: 5px">Number of Ss</th>
                            <th style="width: 5px">Room</th>
                            <th style="width: 5px">Material</th>
                            <th style="width: 5px">Start date</th>
                            <th style="width: 5px">Mid.</th>
                            <th style="width: 5px">Final</th>
                            <th style="width: 5px">End date</th>
                            <th>Mon<br>'.date('M.d',strtotime($duLieu[0]['ngayBatDauChinh'])).'</th>
                            <th>Tue<br>'.date('M.d',strtotime($duLieu[0]['ngayThu3'])).'</th>
                            <th>Wed<br>'.date('M.d',strtotime($duLieu[0]['ngayThu4'])).'</th>
                            <th>Thu<br>'.date('M.d',strtotime($duLieu[0]['ngayThu5'])).'</th>
                            <th>Fri<br>'.date('M.d',strtotime($duLieu[0]['ngayThu6'])).'</th>
                            <th>Sat<br>'.date('M.d',strtotime($duLieu[0]['ngayThu7'])).'</th>
                            <th>Sun<br>'.date('M.d',strtotime($duLieu[0]['ngayKetThucChinh'])).'</th>
                        </tr>
                        </thead><tbody>';
                        $soLanTrung=0; $soLanLapTrung=0;$kiemTraTrung=0;
                        for($i=0;$i<count($lop);$i++)
                        {
                            if($kiemTraTrung==0)
                                for($j = 0; $j<count($arrTrungGio);$j++)
                                {
                                    if($arrTrungGio[$j]['sttTrung']-2==$i)
                                    {
                                         $kiemTraTrung=1; 
                                        $soLanTrung=$arrTrungGio[$j]['soLan']; 
                                    }
                                }
                                                   
                          $out.='  <tr>
                            <td>'.$lop[$i]['stt'].$lop[$i]['soKem'].'</td>
                            ';
                            if($kiemTraTrung==0)
                                $out.='<td>'.$lop[$i]['TimeStart'].' '.$lop[$i]['TimeEnd'].'</td>';
                            else 
                            {
                                if($soLanLapTrung==0)
                                    $out.='<td rowspan="'. ($soLanTrung+1) .'">'.$lop[$i]['TimeStart'].' '.$lop[$i]['TimeEnd'].'</td>';
                                
                                    $soLanLapTrung++ ;
                                if($soLanLapTrung>$soLanTrung)
                                {
                                    $soLanTrung=0; 
                                    $soLanLapTrung=0;
                                    $kiemTraTrung=0; 
                                }
                            }
                               
                           
                      

                           $out.=' <td>'.$lop[$i]['tenLop'].'</td>
                            <td>'.$lop[$i]['siSo'].'</td>
                            <td>'.$lop[$i]['phong'].'</td>
                            <td>'.$lop[$i]['Material'].'</td>
                            <td>'.$lop[$i]['ngayBatDau'].'</td>
                            <td>'.$lop[$i]['mid'].'</td>
                            <td>'.$lop[$i]['final'].'</td>
                            <td>'.$lop[$i]['ngayKetThuc'].'</td>';
                            if($duLieu[0]['ngayLe2']=="")
                            {
                                $out.='  <td><b>'.$lich[$i]['giaoVien2'].'</b><br>
                                <b>'.$lich[$i]['troGiang2'].'</b><br>';
                                if($lich[$i]['noiDung2']!="")
                                $out.=''.$lich[$i]['noiDung2'].'';
                                
                                $out.='</td>';
                            }                     
                            else
                            {
                                $out.='  <td style="color: red;text-align:center;
                                transform: rotate(90deg);">'. $duLieu[0]['ngayLe2'] .'</td>';
                            } 

                            if($duLieu[0]['ngayLe3']=="")
                            {
                                $out.='  <td><b>'.$lich[$i]['giaoVien3'].'</b><br>
                                <b>'.$lich[$i]['troGiang3'].'</b><br>';
                                if($lich[$i]['noiDung3']!="")
                                $out.=''.$lich[$i]['noiDung3'].'';
                                
                                $out.='</td>';
                            }                     
                            else
                            {
                                $out.='  <td style="color: red;text-align:center;
                                transform: rotate(90deg);">'. $duLieu[0]['ngayLe3'] .'</td>';
                            } 
                            if($duLieu[0]['ngayLe4']=="")
                            {
                                $out.='  <td><b>'.$lich[$i]['giaoVien4'].'</b><br>
                                <b>'.$lich[$i]['troGiang4'].'</b><br>';
                                if($lich[$i]['noiDung4']!="")
                                $out.=''.$lich[$i]['noiDung4'].'';
                                
                                $out.='</td>';
                            }                     
                            else
                            {
                                $out.='  <td style="color: red;text-align:center;
                                transform: rotate(90deg);">'. $duLieu[0]['ngayLe4'] .'</td>';
                            } 
                            if($duLieu[0]['ngayLe5']=="")
                            {
                                $out.='  <td><b>'.$lich[$i]['giaoVien5'].'</b><br>
                                <b>'.$lich[$i]['troGiang5'].'</b><br>';
                                if($lich[$i]['noiDung5']!="")
                                $out.=''.$lich[$i]['noiDung5'].'';
                                
                                $out.='</td>';
                            }                     
                            else
                            {
                                $out.='  <td style="color: red;text-align:center;
                                transform: rotate(90deg);">'. $duLieu[0]['ngayLe5'] .'</td>';
                            } 
                            if($duLieu[0]['ngayLe6']=="")
                            {
                                $out.='  <td><b>'.$lich[$i]['giaoVien6'].'</b><br>
                                <b>'.$lich[$i]['troGiang6'].'</b><br>';
                                if($lich[$i]['noiDung6']!="")
                                $out.=''.$lich[$i]['noiDung6'].'';
                                
                                $out.='</td>';
                            }                     
                            else
                            {
                                $out.='  <td style="color: red;text-align:center;
                                transform: rotate(90deg);">'. $duLieu[0]['ngayLe6'] .'</td>';
                            } 
                            if($duLieu[0]['ngayLe7']=="")
                            {
                                $out.='  <td><b>'.$lich[$i]['giaoVien7'].'</b><br>
                                <b>'.$lich[$i]['troGiang7'].'</b><br>';
                                if($lich[$i]['noiDung7']!="")
                                $out.=''.$lich[$i]['noiDung7'].'';
                                
                                $out.='</td>';
                            }                     
                            else
                            {
                                $out.='  <td style="color: red;text-align:center;
                                transform: rotate(90deg);">'. $duLieu[0]['ngayLe7'] .'</td>';
                            } 
                            if($duLieu[0]['ngayLe8']=="")
                            {
                                $out.='  <td><b>'.$lich[$i]['giaoVien8'].'</b><br>
                                <b>'.$lich[$i]['troGiang8'].'</b><br>';
                                if($lich[$i]['noiDung8']!="")
                                $out.=''.$lich[$i]['noiDung8'].'';
                                
                                $out.='</td>';
                            }                     
                            else
                            {
                                $out.='  <td style="color: red;text-align:center;
                                transform: rotate(90deg);">'. $duLieu[0]['ngayLe8'] .'</td>';
                            } 
                          
                          
                            $out.='</tr>';
                        }
                            
                      
                        $out.=' <tr>
                            <td colspan="10" style="text-align: right">Total teaching hours: <b>'.$duLieu[0]['tongGio'].' hours</b></td>
                            <td>';
                            if($duLieu[0]['gioThu2']!=0)
                            $out.= $duLieu[0]['gioThu2'].' hours';
                            $out.='</td>
                            <td>';
                            if($duLieu[0]['gioThu3']!=0)
                            $out.= $duLieu[0]['gioThu3'].' hours';
                            $out.='</td>
                            <td>';
                            if($duLieu[0]['gioThu4']!=0)
                            $out.= $duLieu[0]['gioThu4'].' hours';
                            $out.='</td>
                            <td>';
                            if($duLieu[0]['gioThu5']!=0)
                            $out.= $duLieu[0]['gioThu5'].' hours';
                            $out.='</td>
                            <td>';
                            if($duLieu[0]['gioThu6']!=0)
                            $out.= $duLieu[0]['gioThu6'].' hours';
                            $out.='</td>
                            <td>';
                            if($duLieu[0]['gioThu7']!=0)
                            $out.= $duLieu[0]['gioThu7'].' hours';
                            $out.='</td>
                            <td>';
                            if($duLieu[0]['gioThu8']!=0)
                            $out.= $duLieu[0]['gioThu8'].' hours';
                            $out.='</td>
                           
                        </tr>
                        </tbody>
                        </table>
                            
                    </div>';
                
                return response($out);
            }
            else
            return response(2);
        }
    }

    
    
    public function getlichGiaoVien($tuan,$idNhanVien,$chiNhanh)
    {
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            
          

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
            $tenNhanVien="";
            
                $danhSachLop = DB::table('st_class_time')
                ->join('st_class','st_class.class_id','=','st_class_time.class_id')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                '=','st_class_time.classTime_id')
                ->where('st_class.branch_id',$chiNhanh)
                ->where('st_class_time_employee.employee_id',$idNhanVien)
                ->where('st_class_time_employee.classTimeEmployee_type',1)
                ->where('st_class.class_statusSchedule',1)
                ->where('st_class.class_status',1)
                ->whereDate('st_class_time.classTime_startDate','>=',$ngayBatDauChinh)
                ->whereDate('st_class_time.classTime_startDate','<=',$ngayKetThucChinh)
                ->get();

                $giaoVienChinh = DB::table('st_employee')
                ->where('employee_id',$idNhanVien)
                ->get()->first();
                if(isset($giaoVienChinh))
                $tenNhanVien = $giaoVienChinh->employee_name;
            

           

            $arrLop=[];
            $arrTrungGio = [];
            $soThuTu=1;
           
            $kiemTraTrungGio=0;
            $gioBatDauDau ="";
            $gioKetThucDau= "";
            $soLanTrungGio=0;
    
    
            $thuTuTrungGio =0;




            foreach ($danhSachLop as $item)
            {
                $sttLopTrung=0;
                $checkLop=0;
                $soLopTrung=0;
                $viTriMang=0;
                foreach ($arrLop as $itemLop)
                {
                    if ($itemLop['idLop']== $item->class_id )
                    {
                        if($itemLop['TimeStart']== date('H:i',strtotime( $item->classTime_startDate))
                        &&  $itemLop['TimeEnd']== date('H:i',strtotime( $item->classTime_endDate)))
                        {
                            $checkLop=1;
                        }
                        else
                        {
                            if( $arrLop[$viTriMang]['trangThai']==0)
                            {
                                $arrLop[$viTriMang]['soKem']=".1";
                                $arrLop[$viTriMang]['trangThai']=1;
                            }
                            $soLopTrung++;
                            if($sttLopTrung==0)
                            $sttLopTrung = $itemLop['stt'];
                        }
                    
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


                    if($sttLopTrung==0)
                    {
                        $stt = $soThuTu;
                       $trangThai =0;
                       $soKem="";
                    }
                    else
                    {
                        $stt = $sttLopTrung;
                        $soKem = ".".($soLopTrung+1);
                        $soThuTu--;
                        $trangThai=1;
                    }

                    $arrLop[]=[
                        'stt'=>$stt,
                        'idLop'=>$item->class_id,
                        'chiNhanh'=>$chiNhanh->branch_code,
                        'TimeStart'=> date('H:i',strtotime( $item->classTime_startDate)) ,
                        'TimeEnd'=> date('H:i',strtotime( $item->classTime_endDate)),
                        'tenLop'=>$item->class_name,
                        'siSo'=>count($hocVien),
                        'phong'=>$chiNhanh->room_name,
                        'Material'=>"",
                        'ngayBatDau'=>date('M.d',strtotime($item->class_startDay)) ,
                        'ngayKetThuc'=>date('M.d',strtotime($item->class_endDay)),
                        'mid'=>$midText,
                        'final'=>$finalText,
                        'trangThai'=>$trangThai,
                        'soKem'=>$soKem
                    ];
                    $soThuTu++;
                }
                
            }
            $arrLich = [];
            $ngayTong="";
            $i=0;
           


            foreach ($arrLop as $item)
            {
                $i++;
                if($kiemTraTrungGio==0)
                {
                    $gioBatDauDau = $item['TimeStart'];
                    $gioKetThucDau = $item['TimeEnd'];
                    $kiemTraTrungGio= 1;
                }
                else
                {
                    $gioBatDauSau = $item['TimeStart'];
                    $gioKetThucSau = $item['TimeEnd'];
    
                    if($gioBatDauDau==$gioBatDauSau && $gioKetThucDau==$gioKetThucSau)
                    {
                        if($soLanTrungGio==0)
                        {
                            $thuTuTrungGio=$i;
                        }
                        $soLanTrungGio++;
                    }
                    else
                    {
                        if($soLanTrungGio>0)
                        {
                            $arrTrungGio[]=[
                                'sttTrung'=>$thuTuTrungGio,
                                'soLan'=>$soLanTrungGio
                            ];
                            $thuTuTrungGio=0;
                            $soLanTrungGio=0;
                           
                        }
                      
                    }
                    $gioBatDauDau = $gioBatDauSau;
                    $gioKetThucDau =$gioKetThucSau;
                }

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
                   
                    $giaoVienHienTai =DB::table('st_class_time')
                    ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                    '=','st_class_time.classTime_id')
                    ->join('st_employee','st_employee.employee_id',
                    '=','st_class_time_employee.employee_id')
                    ->where('st_class_time.classTime_id',$item1->classTime_id)
                    ->where('st_class_time_employee.employee_id',$idNhanVien)
                    ->where('st_class_time_employee.classTimeEmployee_type',1)
                    ->select('st_employee.employee_id','st_employee.employee_name')
                    ->get()->first();

                    if(isset($giaoVienHienTai))
                    {
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


                        if($item['TimeStart']== date('H:i',strtotime( $item1->classTime_startDate))
                        &&  $item['TimeEnd'] == date('H:i',strtotime( $item1->classTime_endDate)))  
                        { 

                            if ($item1->class_id==$item['idLop'] && $ngay==$ngayBatDauChinh)
                            {
                                
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
                               
                                $noiDung6=$item1->classTime_title;
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

            if($soLanTrungGio>0)
        $arrTrungGio[]=[
            'sttTrung'=>$thuTuTrungGio,
            'soLan'=>$soLanTrungGio
        ];
        $gioThu2=$gioThu2+$PhutThu2/60;
        $gioThu3=$gioThu3+$PhutThu3/60;
        $gioThu4=$gioThu4+$PhutThu4/60;
        $gioThu5=$gioThu5+$PhutThu5/60;
        $gioThu6=$gioThu6+$PhutThu6/60;
        $gioThu7=$gioThu7+$PhutThu7/60;
        $gioThu8=$gioThu8+$PhutThu8/60;



        $tongGio = $gioThu2+$gioThu3+$gioThu4+$gioThu5+$gioThu6+$gioThu7+$gioThu8;




            $arr[] = [
            'ngayBatDauChinh'=>$ngayBatDauChinh,
            'ngayThu3'=>$ngayThu3,
            'ngayThu4'=>$ngayThu4,
            'ngayThu5'=>$ngayThu5,
            'ngayThu6'=>$ngayThu6,
            'ngayThu7'=>$ngayThu7,
            'ngayKetThucChinh'=>$ngayKetThucChinh,
                'giaoVien'=>$tenNhanVien,
                'lop'=>$arrLop,
                'lich'=>$arrLich,
                'danhSachLop'=>count($danhSachLop),
                'gioThu2'=>$gioThu2,
                'gioThu3'=>$gioThu3,
                'gioThu4'=>$gioThu4,
                'gioThu5'=>$gioThu5,
                'gioThu6'=>$gioThu6,
                'gioThu7'=>$gioThu7,
                'gioThu8'=>$gioThu8,
                'tongGio'=>$tongGio,
                'ngayLe2'=>$ngayLe2,
                'ngayLe3'=>$ngayLe3,
                'ngayLe4'=>$ngayLe4,
                'ngayLe5'=>$ngayLe5,
                'ngayLe6'=>$ngayLe6,
                'ngayLe7'=>$ngayLe7,
                'ngayLe8'=>$ngayLe8,
                'tuan'=>$tuan,
                'arrTrungGio'=>$arrTrungGio
            ];
            
            return $arr;
       
    }
    

    public function getlichTatCaGiaoVien($tuan,$chiNhanh)
    {
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            
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
                ->where('st_class.branch_id',$chiNhanh)
                ->where('st_class.class_statusSchedule',1)
                ->where('st_class.class_status',1)
                ->whereDate('st_class_time.classTime_startDate','>=',$ngayBatDauChinh)
                ->whereDate('st_class_time.classTime_startDate','<=',$ngayKetThucChinh)
                ->orderBy('st_class_time.classTime_startTime')
                ->get();

                $arrLop=[];
     
                $arrTrungGio = [];
              
               
                $kiemTraTrungGio=0;
                $gioBatDauDau ="";
                $gioKetThucDau= "";
                $soLanTrungGio=0;
        
        
                $thuTuTrungGio =0;
                $soThuTu=1;
                foreach ($danhSachLop as $item)
                {
                    $sttLopTrung=0;
                    $checkLop=0;
                    $soLopTrung=0;
        
                    
                
        
        
                    $viTriMang=0;
                    foreach ($arrLop as $itemLop)
                    {
                        if ($itemLop['idLop']== $item->class_id )
                        {
                            if($itemLop['TimeStart']== date('H:i',strtotime( $item->classTime_startDate))
                            &&  $itemLop['TimeEnd']== date('H:i',strtotime( $item->classTime_endDate)))
                            {
                                $checkLop=1;
                            }
                            else
                            {
                                if( $arrLop[$viTriMang]['trangThai']==0)
                                {
                                    $arrLop[$viTriMang]['soKem']=".1";
                                    $arrLop[$viTriMang]['trangThai']=1;
                                  
                                }
                                $soLopTrung++;
                                if($sttLopTrung==0)
                                $sttLopTrung = $itemLop['stt'];
                            }
                          
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
                        
                            if($sttLopTrung==0)
                            {
                                $stt = $soThuTu;
                                $soKem="";
                                $trangThai=0;
                               
                            }
                            else
                            {
                                $stt = $sttLopTrung;
                                $soKem=".".($soLopTrung+1);
                                $trangThai=1;
                                $soThuTu--;
                            }
        
                         
                        $arrLop[]=[
                            'stt'=>$stt,
                            'idLop'=>$item->class_id,
                            'chiNhanh'=>$chiNhanh->branch_code,
                            'TimeStart'=> date('H:i',strtotime( $item->classTime_startDate)) ,
                            'TimeEnd'=> date('H:i',strtotime( $item->classTime_endDate)),
                            'tenLop'=>$item->class_name,
                            'siSo'=>count($hocVien),
                            'phong'=>$chiNhanh->room_name,
                            'Material'=>$item->class_material,
                            'ngayBatDau'=>date('M.d',strtotime($item->class_startDay)) ,
                            'ngayKetThuc'=>date('M.d',strtotime($item->class_endDay)),
                            'mid'=>$midText,
                            'final'=>$finalText,
                            'trangThai'=>$trangThai,
                            'soKem'=>$soKem
                        ];
                        $soThuTu++;
                    }
                   
                   
                }
              
                $arrLich = [];
                $ngayTong="";
                $i=0;
                foreach ($arrLop as $item)
                {
                    $i++;
        
                    if($kiemTraTrungGio==0)
                    {
                        $gioBatDauDau = $item['TimeStart'];
                        $gioKetThucDau = $item['TimeEnd'];
                        $kiemTraTrungGio= 1;
                    }
                    else
                    {
                        $gioBatDauSau = $item['TimeStart'];
                        $gioKetThucSau = $item['TimeEnd'];
        
                        if($gioBatDauDau==$gioBatDauSau && $gioKetThucDau==$gioKetThucSau)
                        {
                            if($soLanTrungGio==0)
                            {
                                $thuTuTrungGio=$i;
                            }
                            $soLanTrungGio++;
                        }
                        else
                        {
                            if($soLanTrungGio>0)
                            {
                                $arrTrungGio[]=[
                                    'sttTrung'=>$thuTuTrungGio,
                                    'soLan'=>$soLanTrungGio
                                ];
                                $thuTuTrungGio=0;
                                $soLanTrungGio=0;
                               
                            }
                          
                        }
                        $gioBatDauDau = $gioBatDauSau;
                        $gioKetThucDau =$gioKetThucSau;
                    }
        
        
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
                   
                        $idClassTime2=0;
                        $idClassTime3=0;
                        $idClassTime4=0;
                        $idClassTime5=0;
                        $idClassTime6=0;
                        $idClassTime7=0;
                        $idClassTime8=0;
                  
                    foreach ($danhSachLop as $item1)
                    {
                        if($item1->classTimeEmployee_type!=3)
                        {

                       
                            $ngay = date('Y-m-d',strtotime($item1->classTime_startDate));
                            $ngayTong.=" ".$ngay;
                            $giaoVien = DB::table('st_class_time')
                            ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                            '=','st_class_time.classTime_id')
                            ->join('st_employee','st_employee.employee_id',
                            '=','st_class_time_employee.employee_id')
                            ->where('st_class_time.classTime_id',$item1->classTime_id)
                            ->where('st_class_time_employee.classTimeEmployee_type',1)
                            ->select('st_employee.employee_id','st_employee.employee_name')
                            ->get()
                            ->first();
        
                            $troGiang =DB::table('st_class_time')
                            ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                            '=','st_class_time.classTime_id')
                            ->join('st_employee','st_employee.employee_id',
                            '=','st_class_time_employee.employee_id')
                            ->where('st_class_time.classTime_id',$item1->classTime_id)
                            ->where('st_class_time_employee.classTimeEmployee_type',2)
                            ->select('st_employee.employee_id','st_employee.employee_name')
                            ->get()->first();
        
                            if($item['TimeStart']== date('H:i',strtotime( $item1->classTime_startDate))
                            &&  $item['TimeEnd'] == date('H:i',strtotime( $item1->classTime_endDate)))  
                            {     
                                if ($item1->class_id==$item['idLop'] && $ngay==$ngayBatDauChinh )
                                {
                                    $idClassTime2 = $item1->classTime_id;
                
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
                                    $idClassTime3 = $item1->classTime_id;
                                
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
                                    $idClassTime4 = $item1->classTime_id;
                                
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
                                    $idClassTime5 = $item1->classTime_id;
                                    
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
                                    $idClassTime6 = $item1->classTime_id;
                                    
                                    $noiDung6=$item1->classTime_title;
                
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
                                    $idClassTime7 = $item1->classTime_id;
                                
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
                                    $idClassTime8 = $item1->classTime_id;
                                    
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
                        'troGiang8'=>$troGiang8,
                        'idClassTime2'=>$idClassTime2,
                        'idClassTime3'=>$idClassTime3,
                        'idClassTime4'=>$idClassTime4,
                        'idClassTime5'=>$idClassTime5,
                        'idClassTime6'=>$idClassTime6,
                        'idClassTime7'=>$idClassTime7,
                        'idClassTime8'=>$idClassTime8
                    ];
                }
                if($soLanTrungGio>0)
                $arrTrungGio[]=[
                    'sttTrung'=>$thuTuTrungGio,
                    'soLan'=>$soLanTrungGio
                ];
               
               
        
        
                $tongGio = $gioThu2+$gioThu3+$gioThu4+$gioThu5+$gioThu6+$gioThu7+$gioThu8;
        
                $arrValue[]= ['lich'=>$arrLich,
                'tongGio'=>$tongGio,
                'ngayBatDauChinh'=>$ngayBatDauChinh,
               'ngayThu3'=>$ngayThu3,
               'ngayThu4'=>$ngayThu4,
                'ngayThu5'=>$ngayThu5,
               'ngayThu6'=>$ngayThu6,
                'ngayThu7'=>$ngayThu7,
                'ngayKetThucChinh'=>$ngayKetThucChinh,
                'lop'=>$arrLop,
                'lich'=>$arrLich,
                'danhSachLop'=>count($danhSachLop),
                'gioThu2'=>$gioThu2,
                'gioThu3'=>$gioThu3,
                'gioThu4'=>$gioThu4,
                'gioThu5'=>$gioThu5,
                'gioThu6'=>$gioThu6,
                'gioThu7'=>$gioThu7,
                'gioThu8'=>$gioThu8,
                'ngayLe2'=>$ngayLe2,
                'ngayLe3'=>$ngayLe3,
                'ngayLe4'=>$ngayLe4,
                'ngayLe5'=>$ngayLe5,
                'ngayLe6'=>$ngayLe6,
                'ngayLe7'=>$ngayLe7,
                'ngayLe8'=>$ngayLe8,
                'ngayTong'=>$ngayTong,
                'arrTrungGio'=>$arrTrungGio,
                'giaoVien'=>"ALL"
            ];
            
            return $arrValue;
       
    }
}
