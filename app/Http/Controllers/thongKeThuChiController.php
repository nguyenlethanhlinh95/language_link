<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class thongKeThuChiController extends Controller
{
    public function getThongKeThu()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThongKeThu();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $phieuThuTong = DB::table('view_phieu_thu')
            ->whereDate('receipt_time',$now)
            ->select('receipt_id')
            ->get();
         
            $phieuThu = DB::table('view_phieu_thu')
                ->orderByDesc('receipt_time')
                ->whereDate('receipt_time',$now)
               
                
                ->get();
                $soKM = count($phieuThuTong);
                $soTrang = (int) $soKM / $lay;
                if ($soKM % $lay > 0)
                    $soTrang++;

            $chiNhanh = DB::table('st_branch')
            ->get();        
            return view('ThongKe.doanhThu')
            ->with('soTrang',$soTrang)
            ->with('chiNhanh',$chiNhanh)
            ->with('phieuThu',$phieuThu)
            ->with('ngayBatDau',$now)
            ->with('ngayKetThuc',$now)
            ->with('thoiGianTimkiem',1)
            ->with('chiNhanhTimKiem',0)
            ->with('tenNguoiLap',"")
            ->with('page',1);
        }
        else
        {
            return redirect()->back();
        }
    }


    public function getThongKeChi()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThongKeChi();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $phieuChiTong = DB::table('view_nhap_kho')
            ->whereDate('warehousing_time',$now)
            ->select('warehousing_id')
            ->get();
         
            $phieuChi = DB::table('view_nhap_kho')
                ->orderByDesc('warehousing_time')
                ->whereDate('warehousing_time',$now)
               
                
                ->get();
                $soKM = count($phieuChiTong);
                $soTrang = (int) $soKM / $lay;
                if ($soKM % $lay > 0)
                    $soTrang++;

            $chiNhanh = DB::table('st_branch')
            ->get();        
            return view('ThongKe.chiPhi')
            ->with('soTrang',$soTrang)
            ->with('chiNhanh',$chiNhanh)
            ->with('phieuChi',$phieuChi)
            ->with('ngayBatDau',$now)
            ->with('ngayKetThuc',$now)
            ->with('thoiGianTimkiem',1)
            ->with('chiNhanhTimKiem',0)
            ->with('tenNguoiLap',"")
            ->with('page',1);
        }
        else
        {
            return redirect()->back();
        }
    }
    public function searchThongKeThuThoiGian(Request $request)
    {
        if($request->ajax())
        {
            $value= $request->get('value');
            $page= $request->get('page');
            $chiNhanh= $request->get('chiNhanh');
            $thoiGian= $request->get('thoiGian');

            $arrThoiGian = $this->TimNgayThoiGian($thoiGian);
            $ngayBatDau = $arrThoiGian[0]['ngayBatDau'];
            $ngayKetThuc = $arrThoiGian[0]['ngayKetThuc'];


           // $out = $this->getDuLieuThongKeThu($chiNhanh,$value,$ngayBatDau,$ngayKetThuc,$page);

            return response($arrThoiGian);
           // return response($ngayBatDau. " ". $ngayKetThuc);
        }
    }

    public function searchThongKeChi(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThongKeChi();
        if($quyenChiTiet==1)
        {
            $value= $request->get('tenNguoiLap2');
            $page= $request->get('page');
            $chiNhanhTimKiem= $request->get('chiNhanhTimKiem2');
            $thoiGianTimkiem= $request->get('thoiGianTimKiem2');
            $khoangThoiGianTimKiem= $request->get('khoangThoiGianTimKiem2');
           
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
                $arrThoiGian = $this->TimNgayThoiGian($thoiGianTimkiem);
                $ngayBatDau = $arrThoiGian[0]['ngayBatDau'];
                $ngayKetThuc = $arrThoiGian[0]['ngayKetThuc'];
            }

            $out = $this->getDuLieuThongKeChi($chiNhanhTimKiem,$value,$ngayBatDau,$ngayKetThuc,$page);
        

            $soTrang = $out[0]['soTrang'];
            $phieuChi = $out[0]['phieuChi'];
            $chiNhanh = DB::table('st_branch')
            ->get();        
            return view('ThongKe.chiPhi')
            ->with('soTrang',$soTrang)
            ->with('chiNhanh',$chiNhanh)
            ->with('phieuChi',$phieuChi)
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
    public function searchThongKeThuKhoangThoiGian(Request $request)
    {
        
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThongKeThu();
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
            $arrThoiGian = $this->TimNgayThoiGian($thoiGianTimkiem);
            $ngayBatDau = $arrThoiGian[0]['ngayBatDau'];
            $ngayKetThuc = $arrThoiGian[0]['ngayKetThuc'];
        }
      
       $out = $this->getDuLieuThongKeThu($chiNhanhTimKiem,$value,$ngayBatDau,$ngayKetThuc,$page);
        

       $soTrang = $out[0]['soTrang'];
       $phieuThu = $out[0]['phieuThu'];
       $chiNhanh = DB::table('st_branch')
       ->get();        
       return view('ThongKe.doanhThu')
       ->with('soTrang',$soTrang)
       ->with('chiNhanh',$chiNhanh)
       ->with('phieuThu',$phieuThu)
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
    public function getDuLieuThongKeChi($chiNhanh, $value,$ngayBatDau,$ngayKetThuc,$page)
    {
        $quyen = new quyenController();
        $lay = $quyen->layDuLieu();
        if($value=="")
        {
            if($chiNhanh==0)
            {
                $phieuChiTong =DB::table('view_nhap_kho')
                ->orderByDesc('warehousing_time')
                ->whereDate('warehousing_time','>=',$ngayBatDau)
                ->whereDate('warehousing_time','<=',$ngayKetThuc)
                ->select('warehousing_id')
                ->get();
                $phieuChi = DB::table('view_nhap_kho')
                ->orderByDesc('warehousing_time')
                ->whereDate('warehousing_time','>=',$ngayBatDau)
                ->whereDate('warehousing_time','<=',$ngayKetThuc)
               
                
                ->get();
            }
            else
            {

                $phieuChiTong =DB::table('view_nhap_kho')
                ->orderByDesc('warehousing_time')
                ->whereDate('warehousing_time','>=',$ngayBatDau)
                ->whereDate('warehousing_time','<=',$ngayKetThuc)
                ->where('branch_id',$chiNhanh)
                ->select('warehousing_id')
                ->get();
                $phieuChi = DB::table('view_nhap_kho')
                ->orderByDesc('warehousing_time')
                ->whereDate('warehousing_time','>=',$ngayBatDau)
                ->whereDate('warehousing_time','<=',$ngayKetThuc)
                ->where('branch_id',$chiNhanh)
               
                
                ->get();

            }
           
        }
        else
        {
            if($chiNhanh==0)
            {
                $phieuChiTong =DB::table('view_nhap_kho')
                ->orderByDesc('warehousing_time')
                ->whereDate('warehousing_time','>=',$ngayBatDau)
                ->whereDate('warehousing_time','<=',$ngayKetThuc)
                ->where('employee_name', 'like', '%' . $value . '%')
                ->select('warehousing_id')
                
                ->get();
                $phieuChi = DB::table('view_nhap_kho')
                ->orderByDesc('warehousing_time')
                ->whereDate('warehousing_time','>=',$ngayBatDau)
                ->whereDate('warehousing_time','<=',$ngayKetThuc)
                ->where('employee_name', 'like', '%' . $value . '%')
               
                
                ->get();
            }
            else
            {

                $phieuChiTong =DB::table('view_phieu_thu')
                ->orderByDesc('warehousing_time')
                ->whereDate('warehousing_time','>=',$ngayBatDau)
                ->whereDate('warehousing_time','<=',$ngayKetThuc)
                ->where('branch_id',$chiNhanh)
                ->where('employee_name', 'like', '%' . $value . '%')
                ->select('warehousing_id')
                ->get();
                $phieuChi = DB::table('view_nhap_kho')
                ->orderByDesc('warehousing_time')
                ->whereDate('warehousing_time','>=',$ngayBatDau)
                ->whereDate('warehousing_time','<=',$ngayKetThuc)
                ->where('branch_id',$chiNhanh)
                ->where('employee_name', 'like', '%' . $value . '%')
               
                
                ->get();

            }
           
        }

      
     
     
            $soKM = count($phieuChiTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;


          $arr[]=[
              'phieuChi'=>$phieuChi,
              'soTrang'=>$soTrang
          ];
          return $arr;
      
    }

    public function getDuLieuThongKeThu($chiNhanh, $value,$ngayBatDau,$ngayKetThuc,$page)
    {
        $quyen = new quyenController();
        $lay = $quyen->layDuLieu();
        if($value=="")
        {
            if($chiNhanh==0)
            {
                $phieuThuTong =DB::table('view_phieu_thu')
                ->orderByDesc('receipt_time')
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->select('receipt_id')
                ->get();
                $phieuThu = DB::table('view_phieu_thu')
                ->orderByDesc('receipt_time')
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
               
                
                ->get();
            }
            else
            {
                $phieuThuTong =DB::table('view_phieu_thu')
                ->orderByDesc('receipt_time')
                ->whereDate('branch_id',$chiNhanh)
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->where('receipt_time','<=',$ngayKetThuc)
                ->select('receipt_id')
                ->get();
                $phieuThu = DB::table('view_phieu_thu')
                ->orderByDesc('receipt_time')
                ->where('branch_id',$chiNhanh)
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
               
                
                ->get();
            }
           
        }
        else
        {
            if($chiNhanh==0)
            {

                $phieuThuTong = DB::table('view_phieu_thu')
                ->orderByDesc('receipt_time')
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->where('employee_name', 'like', '%' . $value . '%')
                ->select('receipt_id')
                ->get();
                $phieuThu = DB::table('view_phieu_thu')
                ->orderByDesc('receipt_time')
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->where('employee_name', 'like', '%' . $value . '%')
               
                
                ->get();
            }
            else
            {


                $phieuThuTong =DB::table('view_phieu_thu')
                ->orderByDesc('receipt_time')
                ->where('branch_id',$chiNhanh)
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->where('employee_name', 'like', '%' . $value . '%')
                ->select('receipt_id')
                ->get();

                $phieuThu = DB::table('view_phieu_thu')
                ->orderByDesc('receipt_time')
                ->where('branch_id',$chiNhanh)
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->where('employee_name', 'like', '%' . $value . '%')
               
                
                ->get();
            }
        }

      
     
     
            $soKM = count($phieuThuTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;


          $arr[]=[
              'phieuThu'=>$phieuThu,
              'soTrang'=>$soTrang
          ];
          return $arr;
      
    }

    public function TimNgayThoiGian($thoiGian)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $now1 = Carbon::now('Asia/Ho_Chi_Minh');
        $ngayBatDau = $now;
        $ngayKetThuc = $now;
        if($thoiGian==1)
        {
            $ngayBatDau = $now;
            $ngayKetThuc = $now;
        }
        else if($thoiGian ==2)
        {
            $ngayKetThuc = $now;
            $ngayBatDau = $now1->addDay(-7);
        }
        else if($thoiGian==3)
        {
            $tuan = $now->weekOfYear;
            $dto = new \DateTime();
            $dto->setISODate($now->year,($tuan-1));
            $ngayBatDau = $dto->format('Y-m-d');
            $dto->modify('+6 days');
            $ngayKetThuc = $dto->format('Y-m-d');
        }
        else if($thoiGian==4)
        {
             $tuan = $now->weekOfYear;
            $dto = new \DateTime();
            $dto->setISODate($now->year,$tuan);
            $ngayBatDau = $dto->format('Y-m-d');
            $dto->modify('+6 days');
            $ngayKetThuc = $dto->format('Y-m-d');
        }  else if($thoiGian ==5)
        {
            $ngayKetThuc = $now;
            $ngayBatDau = $now1->addDay(-30);
        }
        else if($thoiGian ==6)
        {
            $now->addMonth(-1);
            if($now->month<10)
            {
                $thang = "0".$now->month;
            }
            else
            {
                $thang =$now->month;
            }
            $ngayKetThuc =  $now->year."-". $thang ."-".$now->daysInMonth;
            $ngayBatDau =  $now->year."-". $thang."-01";
        }
        else if($thoiGian ==7)
        {
            if($now->month<10)
            {
                $thang = "0".$now->month;
            }
            else
            {
                $thang =$now->month;
            }
            $ngayKetThuc =  $now->year."-". $thang ."-".$now->daysInMonth;
            $ngayBatDau =  $now->year."-". $thang."-01";
        }
        else if($thoiGian ==8)
        {
           
            $ngayKetThuc = $now->year-1 ."-12-31";
            $ngayBatDau =  $now->year-1 ."-01-01";
        }
        else
        {
            $ngayKetThuc = $now->year ."-12-31";
            $ngayBatDau =  $now->year ."-01-01";
        }
      

        $arr[]=[
            'ngayBatDau'=>$ngayBatDau,
            'ngayKetThuc'=>$ngayKetThuc
        ];

        return $arr;
    }


    public function getThongKeThuChi()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThongKeThuChi();
        if($quyenChiTiet==1)
        {
           
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $phieuThu = DB::table('view_phieu_thu')
            ->whereDate('receipt_time',$now)
            ->sum('receipt_total')
           ;
           $phieuChi = DB::table('view_nhap_kho')
           ->whereDate('warehousing_time',$now)
           ->sum('warehousing_total')
          ;

          $xuatVatPham = DB::table('view_phieu_thu_vat_pham')
          ->whereDate('receipt_time',$now)
          ->sum('receiptFacility_number')
         ;


         $nhapVatPham = DB::table('view_phieu_nhap_chi_tiet')
          ->whereDate('warehousing_time',$now)
          ->sum('warehousing_amount')
         ;
            
         $xuatVatPham2 =  DB::table('view_phieu_xuat_chi_tiet')
         ->whereDate('deliveryBill_time',$now)
         ->sum('deliveryBillDetail_amount')
        ;
          
        $xuatVatPham+= $xuatVatPham2;
            
        $hocVien =  DB::table('view_student_detail')
        ->whereDate('student_dateTime',$now)
        ->count()
       ;
          $chiNhanh = DB::table('st_branch')
          ->get();        
          return view('ThongKe.thuChi')
          ->with('chiNhanh',$chiNhanh)
          ->with('phieuThu',$phieuThu)
          ->with('phieuChi',$phieuChi)
          ->with('xuatVatPham',$xuatVatPham)
          ->with('nhapVatPham',$nhapVatPham)
          ->with('ngayBatDau',$now)
          ->with('ngayKetThuc',$now)
          ->with('thoiGianTimkiem',1)
          ->with('chiNhanhTimKiem',0)
          ->with('tenNguoiLap',"")
          ->with('hocVien',$hocVien)
          ->with('page',1);
        }
        else
        {
            return redirect()->back();
        }
    }


    public function searchTongThuChi(Request $request)
    {
        if($request->ajax())
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
                $arrThoiGian = $this->TimNgayThoiGian($thoiGianTimkiem);
                $ngayBatDau = $arrThoiGian[0]['ngayBatDau'];
                $ngayKetThuc = $arrThoiGian[0]['ngayKetThuc'];
            }
            $out = $this->getDuLieuTongThuChi($chiNhanhTimKiem,$value,$ngayBatDau,$ngayKetThuc,1);
            return response($out);
        }
    }

    public function getDuLieuTongThuChi($chiNhanh, $value,$ngayBatDau,$ngayKetThuc,$page)
    {
        if($value=="")
        {
            if($chiNhanh==0)
            {
                $phieuThu = DB::table('view_phieu_thu')
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->sum('receipt_total')
               ;
               $phieuChi = DB::table('view_nhap_kho')
    
               ->whereDate('warehousing_time','>=',$ngayBatDau)
               ->whereDate('warehousing_time','<=',$ngayKetThuc)
               ->sum('warehousing_total')
              ;
              
                $xuatVatPham = DB::table('view_phieu_thu_vat_pham')
                ->whereDate('receipt_time','>=',$ngayBatDau)
                    ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->sum('receiptFacility_number')
                ;


                $nhapVatPham = DB::table('view_phieu_nhap_chi_tiet')
                ->whereDate('warehousing_time','>=',$ngayBatDau)
                ->whereDate('warehousing_time','<=',$ngayKetThuc)
                ->sum('warehousing_amount')
                ;
            
                $xuatVatPham2 =  DB::table('view_phieu_xuat_chi_tiet')
               
                ->whereDate('deliveryBill_time','>=',$ngayBatDau)
                ->whereDate('deliveryBill_time','<=',$ngayKetThuc)
                ->sum('deliveryBillDetail_amount')
               ;
                 
               $xuatVatPham+= $xuatVatPham2;
               $hocVien =  DB::table('view_student_detail')
             
               ->whereDate('student_dateTime','>=',$ngayBatDau)
               ->whereDate('student_dateTime','<=',$ngayKetThuc)
               ->count()
              ;
            }
            else
            {
                $phieuThu = DB::table('view_phieu_thu')
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->where('branch_id',$chiNhanh)
                ->sum('receipt_total')
               ;
               $phieuChi = DB::table('view_nhap_kho')
               ->whereDate('warehousing_time','>=',$ngayBatDau)
               ->whereDate('warehousing_time','<=',$ngayKetThuc)
               ->where('branch_id',$chiNhanh)
               ->sum('warehousing_total')
              ;

              $xuatVatPham = DB::table('view_phieu_thu_vat_pham')
              ->whereDate('receipt_time','>=',$ngayBatDau)
               ->whereDate('receipt_time','<=',$ngayKetThuc)
                   ->where('branch_id',$chiNhanh)
              ->sum('receiptFacility_number')
             ;
    
    
             $nhapVatPham = DB::table('view_phieu_nhap_chi_tiet')
             ->whereDate('warehousing_time','>=',$ngayBatDau)
             ->whereDate('warehousing_time','<=',$ngayKetThuc)
             ->where('branch_id',$chiNhanh)
              ->sum('warehousing_amount')
             ;

             $xuatVatPham2 =  DB::table('view_phieu_xuat_chi_tiet')
             ->where('branch_id',$chiNhanh)
             ->whereDate('deliveryBill_time','>=',$ngayBatDau)
             ->whereDate('deliveryBill_time','<=',$ngayKetThuc)
             ->sum('deliveryBillDetail_amount')
           
            ;
              
            $xuatVatPham+= $xuatVatPham2;

            $hocVien =  DB::table('view_student_detail')
            ->where('branch_id',$chiNhanh)
            ->whereDate('student_dateTime','>=',$ngayBatDau)
            ->whereDate('student_dateTime','<=',$ngayKetThuc)
            ->count()
           ;

            }
        }
        else
        {
            if($chiNhanh==0)
            {
                $phieuThu = DB::table('view_phieu_thu')
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->where('employee_name', 'like', '%' . $value . '%')
                ->sum('receipt_total')
               ;
               $phieuChi = DB::table('view_nhap_kho')
               ->whereDate('warehousing_time','>=',$ngayBatDau)
               ->whereDate('warehousing_time','<=',$ngayKetThuc)
               ->where('employee_name', 'like', '%' . $value . '%')
               ->sum('warehousing_total')
              ;
              $xuatVatPham = DB::table('view_phieu_thu_vat_pham')
              ->whereDate('receipt_time','>=',$ngayBatDau)
              ->whereDate('receipt_time','<=',$ngayKetThuc)
                 
                   ->where('employee_name', 'like', '%' . $value . '%')
              ->sum('receiptFacility_number')
             ;
    
    
             $nhapVatPham = DB::table('view_phieu_nhap_chi_tiet')
             ->whereDate('warehousing_time','>=',$ngayBatDau)
             ->whereDate('warehousing_time','<=',$ngayKetThuc)
            
             ->where('employee_name', 'like', '%' . $value . '%')
              ->sum('warehousing_amount');

              $xuatVatPham2 =  DB::table('view_phieu_xuat_chi_tiet')
              ->whereDate('deliveryBill_time','>=',$ngayBatDau)
              ->whereDate('deliveryBill_time','<=',$ngayKetThuc)
              ->where('employee_name', 'like', '%' . $value . '%')
              ->sum('deliveryBillDetail_amount')
            
             ;
               
             $xuatVatPham+= $xuatVatPham2;
             $hocVien =  DB::table('view_student_detail')
            
             ->whereDate('student_dateTime','>=',$ngayBatDau)
             ->whereDate('student_dateTime','<=',$ngayKetThuc)
             ->where('employee_name', 'like', '%' . $value . '%')
             ->count()
            ;
            }
            else
            {
                $phieuThu = DB::table('view_phieu_thu')
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->where('employee_name', 'like', '%' . $value . '%')
                ->where('branch_id',$chiNhanh)
                ->sum('receipt_total')
               ;
               $phieuChi = DB::table('view_nhap_kho')
               ->whereDate('warehousing_time','>=',$ngayBatDau)
               ->whereDate('warehousing_time','<=',$ngayKetThuc)
               ->where('employee_name', 'like', '%' . $value . '%')
               ->where('branch_id',$chiNhanh)
               ->sum('warehousing_total')
              ;
              $xuatVatPham = DB::table('view_phieu_thu_vat_pham')
              ->whereDate('receipt_time','>=',$ngayBatDau)
              ->whereDate('receipt_time','<=',$ngayKetThuc)
                   ->where('branch_id',$chiNhanh)
                   ->where('employee_name', 'like', '%' . $value . '%')
              ->sum('receiptFacility_number')
             ;
    
    
             $nhapVatPham = DB::table('view_phieu_nhap_chi_tiet')
             ->whereDate('warehousing_time','>=',$ngayBatDau)
             ->whereDate('warehousing_time','<=',$ngayKetThuc)
             ->where('branch_id',$chiNhanh)
             ->where('employee_name', 'like', '%' . $value . '%')
              ->sum('warehousing_amount');

              $xuatVatPham2 =  DB::table('view_phieu_xuat_chi_tiet')
              ->where('branch_id',$chiNhanh)
              ->whereDate('deliveryBill_time','>=',$ngayBatDau)
              ->whereDate('deliveryBill_time','<=',$ngayKetThuc)
              ->where('employee_name', 'like', '%' . $value . '%')
              ->sum('deliveryBillDetail_amount')
            
             ;
             $hocVien =  DB::table('view_student_detail')
             ->where('branch_id',$chiNhanh)
             ->whereDate('student_dateTime','>=',$ngayBatDau)
             ->whereDate('student_dateTime','<=',$ngayKetThuc)
             ->where('employee_name', 'like', '%' . $value . '%')
             ->count()
            ;
             $xuatVatPham+= $xuatVatPham2;
            }

        }

        $arr[]=[
            'phieuThu'=>number_format( $phieuThu,0,"","." )."đ",
            'phieuChi'=>number_format($phieuChi,0,"","." )."đ",
            'xuatVatPham'=>$xuatVatPham,
            'nhapVatPham'=>$nhapVatPham,
            'hocVien'=>$hocVien
        ];
        return $arr;
    }

}
