<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class lichCaNhanController extends Controller
{

    public function getLichCaNhan()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $tuan = $now->week();
        $idNhanVien = session('user');
        $arr = $this->getlichGiaoVien($tuan,$idNhanVien);

        return view('CaNhan.lichCaNhan')
        ->with('ngayBatDauChinh',$arr[0]['ngayBatDauChinh'])
        ->with('ngayThu3',$arr[0]['ngayThu3'])
        ->with('ngayThu4',$arr[0]['ngayThu4'])
        ->with('ngayThu5',$arr[0]['ngayThu5'])
        ->with('ngayThu6',$arr[0]['ngayThu6'])
        ->with('ngayThu7',$arr[0]['ngayThu7'])
        ->with('ngayKetThucChinh',$arr[0]['ngayKetThucChinh'])
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
        ->with('idNhanVien',$idNhanVien)
        ->with('idClass',0)
        ->with('arrTrungGio',$arr[0]['arrTrungGio'])
        ;
    }
    public function getLichCaNhanTuan(Request $request)
    {
        $idNhanVien = session('user');
        $tuan = $request->get('tuan');
        $arr = $this->getlichGiaoVien($tuan,$idNhanVien);

        return view('CaNhan.lichCaNhan')
        ->with('ngayBatDauChinh',$arr[0]['ngayBatDauChinh'])
        ->with('ngayThu3',$arr[0]['ngayThu3'])
        ->with('ngayThu4',$arr[0]['ngayThu4'])
        ->with('ngayThu5',$arr[0]['ngayThu5'])
        ->with('ngayThu6',$arr[0]['ngayThu6'])
        ->with('ngayThu7',$arr[0]['ngayThu7'])
        ->with('ngayKetThucChinh',$arr[0]['ngayKetThucChinh'])
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
        ->with('idNhanVien',$idNhanVien)
        ->with('idClass',0)
        ->with('arrTrungGio',$arr[0]['arrTrungGio'])
        ;
     }


    public function getlichGiaoVien($tuan,$idNhanVien)
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

            $kiemTraLe = new xepLichChiNhanhController();
            $ngayLe2 = $kiemTraLe->kiemTraLe($ngayBatDauChinh);
            $ngayLe3 = $kiemTraLe->kiemTraLe($ngayThu3);
            $ngayLe4 = $kiemTraLe->kiemTraLe($ngayThu4);
            $ngayLe5 = $kiemTraLe->kiemTraLe($ngayThu5);
            $ngayLe6 = $kiemTraLe->kiemTraLe($ngayThu6);
            $ngayLe7 = $kiemTraLe->kiemTraLe($ngayThu7);
            $ngayLe8 = $kiemTraLe->kiemTraLe($ngayKetThucChinh);

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
                ->where('st_class_time_employee.employee_id',$idNhanVien)
                ->where('st_class_time_employee.classTimeEmployee_type','!=',3)
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
                            $soLopTrung++;
                            if($sttLopTrung==0)
                            $sttLopTrung = $itemLop['stt'];
                        }
                    
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


                    if($sttLopTrung==0)
                    {
                        $stt = $soThuTu;
                       
                    }
                    else
                    {
                        $stt = $sttLopTrung.".".$soLopTrung;
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
                        'final'=>$finalText
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
        $gioThu2=$gioThu2*2;
        $gioThu3=$gioThu3*2;
        $gioThu4=$gioThu4*2;
        $gioThu5=$gioThu5*2;
        $gioThu6=$gioThu6*2;
        $gioThu7=$gioThu7*2;
        $gioThu8=$gioThu8*2;


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
}
