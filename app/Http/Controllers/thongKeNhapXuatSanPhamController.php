<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Codec\OrderedTimeCodec;

class thongKeNhapXuatSanPhamController extends Controller
{

    public function getNhapSanPham()
    {
        
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThongKeNhapVatPham();
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
            return view('ThongKe.nhapSanPham')
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

    public function searchThongNhapSanPham(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThongKeChi();
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
                $timNgay = new thongKeThuChiController();
                $arrThoiGian = $timNgay->TimNgayThoiGian($thoiGianTimkiem);
                $ngayBatDau = $arrThoiGian[0]['ngayBatDau'];
                $ngayKetThuc = $arrThoiGian[0]['ngayKetThuc'];
            }

            $out = $this->getDuLieuThongKeNhap($chiNhanhTimKiem,$value,$ngayBatDau,$ngayKetThuc,$page);
            $soTrang = $out[0]['soTrang'];
            $phieuChi = $out[0]['phieuChi'];
            $chiNhanh = DB::table('st_branch')
            ->get();        
            return view('ThongKe.nhapSanPham')
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


    public function getDuLieuThongKeNhap($chiNhanh, $value,$ngayBatDau,$ngayKetThuc,$page)
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

    public function getThongKeXuatSanPham()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThongKeXuatSanPham();
        if($quyenChiTiet==1)
        {
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $xuatVatPham = DB::table('view_phieu_thu')
            ->whereDate('receipt_time',$now)
            ->get()
           ;
           $xuatVatPham2 = DB::table('view_phieu_xuat')
           ->whereDate('deliveryBill_time',$now)
           ->get();
            $arr=[];
           foreach($xuatVatPham as $item)
           {
            $arr[]=[
                'id'=>$item->receipt_id,
                'loaiPhieu'=>1,
                'time'=> $item->receipt_time,
                'branch'=>$item->branch_code,
                'employee'=>$item->employee_name,
                'noiDung'=>$item->receipt_name
            ];
           }
          
            foreach($xuatVatPham2 as $item)
            {
             $arr[]=[
                 'id'=>$item->deliveryBill_id,
                 'loaiPhieu'=>2,
                 'time'=> $item->deliveryBill_time,
                 'branch'=>$item->branch_code,
                 'employee'=>$item->employee_name,
                 'noiDung'=>$item->deliveryBill_name
             ];
            }

            $arr = collect($arr)->sortBy('time')->reverse()->toArray();


           $chiNhanh = DB::table('st_branch')
           ->get();        
           return view('ThongKe.xuatSanPham')
          
           ->with('chiNhanh',$chiNhanh)
           ->with('phieuXuat',$arr)
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


    public function searchThongKeXuatSanPham(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThongKeXuatSanPham();
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
                $timNgay = new thongKeThuChiController();
                $arrThoiGian = $timNgay->TimNgayThoiGian($thoiGianTimkiem);
                $ngayBatDau = $arrThoiGian[0]['ngayBatDau'];
                $ngayKetThuc = $arrThoiGian[0]['ngayKetThuc'];
            }

            $out = $this->getDuLieuThongKeXuat($chiNhanhTimKiem,$value,$ngayBatDau,$ngayKetThuc,$page);
            $soTrang = $out[0]['soTrang'];
            $phieuXuat = $out[0]['phieuXuat'];
            $chiNhanh = DB::table('st_branch')
            ->get();      
            
            
            return view('ThongKe.xuatSanPham')
            ->with('chiNhanh',$chiNhanh)
            ->with('phieuXuat',$phieuXuat)
            ->with('ngayBatDau',$ngayBatDau)
            ->with('ngayKetThuc',$ngayKetThuc)
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
    public function getDuLieuThongKeXuat($chiNhanh, $value,$ngayBatDau,$ngayKetThuc,$page)
    {
        $quyen = new quyenController();
        $lay = $quyen->layDuLieu();
        if($value=="")
        {
            if($chiNhanh==0)
            {
                 $xuatVatPham = DB::table('view_phieu_thu')
                 ->whereDate('receipt_time','>=',$ngayBatDau)
                 ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->get();
                $xuatVatPham2 = DB::table('view_phieu_xuat')
                ->whereDate('deliveryBill_time','>=',$ngayBatDau)
                ->whereDate('deliveryBill_time','<=',$ngayKetThuc)
                ->get();
            }
            else
            {
                $xuatVatPham = DB::table('view_phieu_thu')
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->where('branch_id',$chiNhanh)
               ->get();
               $xuatVatPham2 = DB::table('view_phieu_xuat')
               ->whereDate('deliveryBill_time','>=',$ngayBatDau)
               ->whereDate('deliveryBill_time','<=',$ngayKetThuc)
               ->where('branch_id',$chiNhanh)
               ->get();
              
            }
           
        }
        else
        {
            if($chiNhanh==0)
            {

                $xuatVatPham = DB::table('view_phieu_thu')
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->where('employee_name', 'like', '%' . $value . '%')
               ->get();
               $xuatVatPham2 = DB::table('view_phieu_xuat')
               ->whereDate('deliveryBill_time','>=',$ngayBatDau)
               ->whereDate('deliveryBill_time','<=',$ngayKetThuc)
               ->where('employee_name', 'like', '%' . $value . '%')
               ->get();

             
            }
            else
            {

                $xuatVatPham = DB::table('view_phieu_thu')
                ->whereDate('receipt_time','>=',$ngayBatDau)
                ->whereDate('receipt_time','<=',$ngayKetThuc)
                ->where('branch_id',$chiNhanh)
                ->where('employee_name', 'like', '%' . $value . '%')
               ->get();
               $xuatVatPham2 = DB::table('view_phieu_xuat')
               ->whereDate('deliveryBill_time','>=',$ngayBatDau)
               ->whereDate('deliveryBill_time','<=',$ngayKetThuc)
               ->where('branch_id',$chiNhanh)
               ->where('employee_name', 'like', '%' . $value . '%')
               ->get();

            }
           
        }


      
        $arr=[];
        foreach($xuatVatPham as $item)
        {
         $arr[]=[
             'id'=>$item->receipt_id,
             'loaiPhieu'=>1,
             'time'=> $item->receipt_time,
             'branch'=>$item->branch_code,
             'employee'=>$item->employee_name,
             'noiDung'=>$item->receipt_name
         ];
        }
       
         foreach($xuatVatPham2 as $item)
         {
          $arr[]=[
              'id'=>$item->deliveryBill_id,
              'loaiPhieu'=>2,
              'time'=> $item->deliveryBill_time,
              'branch'=>$item->branch_code,
              'employee'=>$item->employee_name,
              'noiDung'=>$item->deliveryBill_name
          ];
         }

         $arr = collect($arr)->sortBy('time')->reverse()->toArray();
     

          $arr1[]=[
              'phieuXuat'=>$arr,
              'soTrang'=>1
          ];
          return $arr1;
      
    }

    public function getChiTietThongKePhieuXuat(Request $request)
    {
        if($request->ajax())
        {
            $id= $request->get('id');
            $loai= $request->get('loai'); $out=""; $i=1;
            if($loai==1)
            {
                $chiTiet = DB::table('st_receipt_facility')
                ->join('st_facility','st_facility.facility_id',
                '=','st_receipt_facility.facility_id')
                ->where('st_receipt_facility.receipt_id',$id)
                ->get();

               
                foreach($chiTiet as $item)
                {
                    $out.="<tr>
                    <td>".$i."</td>
                    <td>".$item->facility_name."</td>
                    <td>".$item->receiptFacility_number."</td>
                        </tr>";

                        $i++;
                }
            }
            else
            {
                $chiTiet = DB::table('st_delivery_bill_detail')
                ->join('st_facility','st_facility.facility_id',
                '=','st_delivery_bill_detail.facility_id')
                ->where('st_delivery_bill_detail.deliveryBill_id',$id)
                ->get();

               
                foreach($chiTiet as $item)
                {
                    $out.="<tr>
                    <td>".$i."</td>
                    <td>".$item->facility_name."</td>
                    <td>".$item->deliveryBillDetail_amount."</td>
                        </tr>";

                        $i++;
                }
            }
            return response($out);

        }
    }
}
