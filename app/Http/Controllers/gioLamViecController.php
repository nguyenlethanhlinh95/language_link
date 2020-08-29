<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class gioLamViecController extends Controller
{
    public function getGioLamVien()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getGioLamViec();

        if($quyenChiTiet==1)
        {
            $giaoVien = DB::table('st_employee')
            ->where('employee_status',1)
            ->get();
            $chiNhanh = DB::table('st_branch')
            ->get();
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $tuan = $now->week();
            $dto = new \DateTime();
            $dto->setISODate($now->year,$tuan);
            $ngayBatDauChinh = $dto->format('Y-m-d');
            $dto->modify('+6 days');
            $ngayKetThucChinh = $dto->format('Y-m-d');

          $duLieu = $this->gioLamViecChiNhanh($ngayBatDauChinh,$ngayKetThucChinh,0);

          $arrGioLamViec= $duLieu[0]['arrGioLamViec'];

          $i=1;
          $out="";
          foreach($arrGioLamViec as $item)
          {
  
            $out.='  <tr>
              <td>'.$i.'</td>
              <td>'.date('M.d',strtotime($item['dateStart'])) .'</td>
              <td>'.$item['tenLop'].'</td>
          
              <td>'.$item['time'] .'</td>
              <td>'.$item['gio'].'</td>
              <td>'.$item['giaoVien'].'</td>
              <td></td>
              </tr>';
           $i++; 
          }
          $out.='  <tr>
          <td colspan="4" ><b style="float: right">Total teaching hours</b></td>
          <td>'.$duLieu[0]['tongGio'].' hours</td>
          <td></td>
          <td></td>
          </tr>';      



            return view('GioLamViec.gioLamViec')
            ->with('giaoVien',$giaoVien)
            ->with('chiNhanh',$chiNhanh)
            ->with('ngayBatDauChinh',$ngayBatDauChinh)
            ->with('ngayKetThucChinh',$ngayKetThucChinh)
            ->with('arrGioLamViec',$duLieu[0]['arrGioLamViec'])
            ->with('tongGio',$duLieu[0]['tongGio'])
            ->with('out',$out)
            ;
        }
        else
        return redirect()->back();

    }
    public function gioLamViecChiNhanh($ngayBatDauChinh, $ngayKetThucChinh,$idChiNhanh)
    {
        if($idChiNhanh==0)
        {
            $lich  = DB::table('st_class_time')
            ->join('st_class','st_class.class_id','=',
                'st_class_time.class_id')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id','=',
                'st_class_time.classTime_id')
                ->join('st_employee','st_employee.employee_id','=',
                'st_class_time_employee.employee_id')
            ->whereDate('classTime_startDate','>=',$ngayBatDauChinh)
            ->whereDate('classTime_startDate','<=',$ngayKetThucChinh)
            ->where('st_class.class_statusSchedule',1)
            ->where('st_class.class_status',1)
            ->where('st_class_time_employee.classTimeEmployee_type','!=',3)
            ->select('st_class_time.*','st_class.class_id','st_class.class_name','st_employee.employee_name')
            ->get();
           
        }
        else
        {
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
            ->where('st_class_time_employee.classTimeEmployee_type','!=',3)
            ->where('st_class.class_statusSchedule',1)
            ->where('st_class.class_status',1)
            ->select('st_class_time.*','st_class.class_id','st_class.class_name','st_employee.employee_name')
            ->get();   
        }
      
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
        $gioThu += $PhutThu/60;
        $arrGioLamViec[]=[
            'dateStart'=>$item->classTime_startDate,
            'dateEnd'=>$item->classTime_endDate,
            'tenLop'=>$item->class_name,
            'gio'=>$gioThu,
            'giaoVien'=>$item->employee_name,
            'time'=>$gioBatDau.":".$phutBatDau." - ".$gioKetThuc.":".$phutKetThuc
        ];
       

        $tongGio+=$gioThu;
    }
    $arr[]=[
        'tongGio'=>$tongGio,
        'arrGioLamViec'=>$arrGioLamViec
    ];
    return $arr;

    }

    public function getDuLieuGioLamViecChiNhanh(Request $request)
    {
        if($request->ajax())
        {
            $chiNhanh = $request->get('chiNhanh');
            $thoiGian = $request->get('thoiGian');


            
        $thoiGian = $request->get('thoiGian');
        $ngay1= substr($thoiGian,3,2);
        $thang1= substr($thoiGian,0,2);
        $nam1= substr($thoiGian,6,4);

        $ngay2= substr($thoiGian,16,2);
        $thang2= substr($thoiGian,13,2);
        $nam2= substr($thoiGian,19,4);

        $ngayBatDauChinh = new Carbon($nam1."-".$thang1."-".$ngay1);
        $ngayKetThucChinh = new Carbon($nam2."-".$thang2."-".$ngay2);
        $duLieu = $this->gioLamViecChiNhanh($ngayBatDauChinh,$ngayKetThucChinh,$chiNhanh);
        $out = "";

        $arrGioLamViec= $duLieu[0]['arrGioLamViec'];

        $i=1;
        foreach($arrGioLamViec as $item)
        {

          $out.='  <tr>
            <td>'.$i.'</td>
            <td>'.date('M.d',strtotime($item['dateStart'])) .'</td>
            <td>'.$item['tenLop'].'</td>
        
            <td>'.$item['time'] .'</td>
            <td>'.$item['gio'].'</td>
            <td>'.$item['giaoVien'].'</td>
            <td></td>
            </tr>';
         $i++; 
        }
        $out.='  <tr>
        <td colspan="4" ><b style="float: right">Total teaching hours</b></td>
        <td>'.$duLieu[0]['tongGio'].' hours</td>
        <td></td>
        <td></td>
        </tr>';                  
        
        $arr[]=[
            'duLieu'=>$out,
            'ngayBatDau'=>date("M.d",strtotime($ngayBatDauChinh)),
            'ngayKetThuc'=>date("M.d",strtotime($ngayKetThucChinh))
        ];

        return response($arr);

        }
    }

    public function getDuLieuGioLamGiaoVien(Request $request)
    {
        if($request->ajax())
        {
            $giaoVien = $request->get('giaoVien');
            $thoiGian = $request->get('thoiGian');


            
        $thoiGian = $request->get('thoiGian');
        $ngay1= substr($thoiGian,3,2);
        $thang1= substr($thoiGian,0,2);
        $nam1= substr($thoiGian,6,4);

        $ngay2= substr($thoiGian,16,2);
        $thang2= substr($thoiGian,13,2);
        $nam2= substr($thoiGian,19,4);

        $ngayBatDauChinh = new Carbon($nam1."-".$thang1."-".$ngay1);
        $ngayKetThucChinh = new Carbon($nam2."-".$thang2."-".$ngay2);

        $duLieu = $this->gioLamViecGiaoVien($ngayBatDauChinh,$ngayKetThucChinh,$giaoVien);
        $arrGioLamViec= $duLieu[0]['arrGioLamViec'];
            $out="";
        $i=1;
        foreach($arrGioLamViec as $item)
        {
           $out.=' <tr>
            <td> '.$i.'</td>
            <td>'.date('M.d',strtotime($item['dateStart'])) .'</td>
            <td>'.$item['tenLop'].'</td>
            <td>'.$item['chiNhanh'].'</td>
            <td>'.$item['time'] .'</td>
            <td>'.$item['gio'].'</td>
            <td></td>
        </tr>';
         $i++; 
        }
       
    
        $out.=' <tr>
        <td colspan="5" ><b style="float: right">Total teaching hours</b></td>
        <td>'.$duLieu[0]['tongGio'].'</td>
        <td></td>
         </tr>';

         $arr[]=[
            'duLieu'=>$out,
            'ngayBatDau'=>date("M.d",strtotime($ngayBatDauChinh)),
            'ngayKetThuc'=>date("M.d",strtotime($ngayKetThucChinh))
        ];

        return response($arr);
        }
       
    }

    public function gioLamViecGiaoVien($ngayBatDauChinh,$ngayKetThucChinh, $idNhanVien)
    {
        if($idNhanVien!=0)
        {
            $lich  = DB::table('st_class_time')
            ->join('st_class','st_class.class_id','=',
                'st_class_time.class_id')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                '=','st_class_time.classTime_id')
            ->join('st_branch','st_branch.branch_id','=','st_class.branch_id')
            ->where('st_class.class_statusSchedule',1)
            ->where('st_class.class_status',1)
            ->where('st_class_time_employee.classTimeEmployee_type','!=',3)
            ->where('st_class_time_employee.employee_id',$idNhanVien)
            ->whereDate('classTime_startDate','>=',$ngayBatDauChinh)
            ->whereDate('classTime_startDate','<=',$ngayKetThucChinh)
            ->get();
        }
        else
        {
            $lich  = DB::table('st_class_time')
            ->join('st_class','st_class.class_id','=',
                'st_class_time.class_id')
                ->join('st_class_time_employee','st_class_time_employee.classTime_id',
                '=','st_class_time.classTime_id')
            ->join('st_branch','st_branch.branch_id','=','st_class.branch_id')
            ->where('st_class_time_employee.classTimeEmployee_type','!=',3)
            ->where('st_class.class_status',1)
            ->whereDate('classTime_startDate','>=',$ngayBatDauChinh)
            ->whereDate('classTime_startDate','<=',$ngayKetThucChinh)
            ->where('st_class.class_statusSchedule',1)
            ->get();
        }
    
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
            $gioThu +=$PhutThu/60;
            $arrGioLamViec[]=[
                'dateStart'=>$item->classTime_startDate,
                'dateEnd'=>$item->classTime_endDate,
                'tenLop'=>$item->class_name,
                'gio'=>$gioThu,
                'chiNhanh'=>$item->branch_code,
                'time'=>$gioBatDau.":".$phutBatDau." - ".$gioKetThuc.":".$phutKetThuc
            ];
            $tongGio+=$gioThu;
        }
        $arr[]=[
            'tongGio'=>$tongGio,
            'arrGioLamViec'=>$arrGioLamViec
        ];
        return $arr;
    
    }
}
