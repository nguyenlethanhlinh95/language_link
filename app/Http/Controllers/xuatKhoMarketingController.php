<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class xuatKhoMarketingController extends Controller
{
    public function getXuatKhoMarketing()
    {
        $quyen = new quyenController();
        $quyenXemKH = $quyen->getXemPhieuXuatMarketing();
        if ($quyenXemKH == 1) {
            $quyenTatCa =$quyen->getXemTatCaPhieuXuatMarketing();
            $lay = $quyen->layDuLieu();
           
           
          
            if($quyenTatCa==1)
            {
                $phieuXuat = DB::table('view_phieu_xuat')
                ->where('deliveryBill_type',2)
                ->orderBy('deliveryBill_time')
                ->take($lay)
                ->skip(0)
                ->get();
                $phieuXuatTong = DB::table('view_phieu_xuat')
                ->where('deliveryBill_type',2)
                ->orderBy('deliveryBill_id')
                ->count();
            }
            else
            {
                $phieuXuat = DB::table('view_phieu_xuat')
                ->where('deliveryBill_type',2)
                ->where('branch_id',session('coSo'))
                ->orderBy('deliveryBill_time')
                ->take($lay)
                ->skip(0)
                ->get();
                $phieuXuatTong = DB::table('view_phieu_xuat')
                ->where('deliveryBill_type',2)
                ->where('branch_id',session('coSo'))
                ->orderBy('deliveryBill_id')
                ->count();
            }
            $soKM = $phieuXuatTong;
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
            return view('Marketing.phieuXuatMarketing')
            ->with('soTrang', $soTrang)
            ->with('page', 1)
            ->with('phieuXuat',$phieuXuat)
            ;

        }
        else
            return redirect()->back();
    }
    public function getCapNhatPhieuXuatMarketingKho(Request $request)
    {
        $id = $request->get('id');
        $phieuXuat = DB::table('st_delivery_bill')
            ->join('st_branch','st_branch.branch_id','=','st_delivery_bill.branch_id')
            ->where('deliveryBill_id',$id)
            ->get()->first();
         $quyen = new quyenController();
      
            $idChiNhanh = $phieuXuat->branch_id;
            $quyenXemKH = $quyen->getXemPhieuXuatMarketing();
            if ($quyenXemKH == 1) {
                $chiTiet = DB::table('view_phieu_xuat_chi_tiet')
                ->where('deliveryBill_id',$id)
                ->get();
                $sanPham = DB::table('view_ton_kho')
                ->where('branch_id',$idChiNhanh)
               
                ->orderBy('facilityType_id')
                ->get();

                $nhanVien = DB::table('st_employee')
                ->where('branch_id',$idChiNhanh)
                ->where('employee_status',1)
                ->get();
                $phongBan = DB::table('st_department')
                ->get();
                return view('Marketing.suaPhieuXuatMarketing')
                ->with('phieuXuat',$phieuXuat)
                ->with('chiTiet',$chiTiet)
                ->with('sanPham',$sanPham)
                ->with('nhanVien',$nhanVien)
                ->with('phongBan',$phongBan)
                ;
            
            }
            else
            return redirect()->back();
           
        
    }
    public function getThemPhieuXuatMarketingKho()
    {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getThemPhieuXuatMarketing();
            if ($quyenXemKH == 1) {
                $quyenTatCa =$quyen->getXemTatCaPhieuXuatMarketing();
             
                if($quyenTatCa==1)
                {
                    $chiNhanh = DB::table('st_branch')
                    ->get();
                    $idChiNhanh = 0;
                    if(count($chiNhanh)>0)
                    {
                        $chiNhanhDau = $chiNhanh->first();
                        $idChiNhanh=$chiNhanhDau->branch_id;
                    }
                    $sanPham = DB::table('view_ton_kho')
                    ->where('branch_id',$idChiNhanh)
                   
                    ->orderBy('facilityType_id')
                    ->get();
                }
                else
                {
                    $chiNhanh = DB::table('st_branch')
                    ->where('branch_id',session('coSo'))
                    ->get();
                    $sanPham = DB::table('view_ton_kho')
                    ->where('branch_id',session('coSo'))
                   
                    ->orderBy('facilityType_id')
                    ->get();
                    $idChiNhanh = session('coSo');
                }
              
                $nhanVien = DB::table('st_employee')
                ->where('branch_id',$idChiNhanh)
                ->where('employee_status',1)
                ->get();
                $phongBan = DB::table('st_department')
                ->get();
                return view('Marketing.themPhieuXuatMarketing')
                ->with('chiNhanh',$chiNhanh)
                ->with('nhanVien',$nhanVien)
                ->with('phongBan',$phongBan)
                ->with('sanPham',$sanPham);
            }
            else
            return redirect()->back();
        
    }

    public function postThemPhieuXuatMarketing(Request $request)
    {
        if($request->ajax())
        {
            

            $quyen = new quyenController();
            $quyenXemKH = $quyen->getThemPhieuXuatMarketing();
            if ($quyenXemKH == 1) {
                $loai = $request->get('loaiThem');
               
                        try{
                            $noiDung = $request->get('noiDung');
                            $ghiChu = $request->get('ghiChu');
                            $nguoiNhan = $request->get('nguoiNhan');
                            $boPhan = $request->get('boPhan');
                            $coSo = $request->get('chiNhanh');
                            $loai = $request->get('loai');
                            $nguoiNhan2 = $request->get('nguoiNhan2');
                            $boPhan2 = $request->get('boPhan2');
                            $trangThai =0;
                            if($loai==true)
                            {
                                $nguoiNhan=$nguoiNhan2;
                                $boPhan=$boPhan2;
                                $trangThai=1;
                            }
                           if($ghiChu=="")
                           $ghiChu="";
                            $now= Carbon::now('Asia/Ho_Chi_Minh');
                           
                            
                            $sanPham = DB::table('view_ton_kho')
                            ->where('branch_id',$coSo)
                            ->orderBy('facilityType_id')
                            ->get();
                            $kiemTraTonKho=0;
                            foreach($sanPham as $item)
                            {
                                $key = "soLuong".$item->facility_id;
                                $soLuong = $request->get($key);
                                if($soLuong > $item->inventory_amount)
                                $kiemTraTonKho=1;
                            }
        
                            if($kiemTraTonKho==0)
                            {
                                $id= DB::table('st_delivery_bill')
                                ->insertGetId([
                                    'deliveryBill_name'=>$noiDung,
                                    'deliveryBill_time'=>$now,
                                    'employee_id'=>session('user'),
                                    'deliveryBill_note'=>$ghiChu,
                                    'deliveryBill_status'=>$trangThai,
                                    'branch_id'=>$coSo,
                                    'deliveryBill_receiver'=>$nguoiNhan,
                                    'deliveryBill_partName'=>$boPhan,
                                    'deliveryBill_type'=>2
                                ]);
        
                                foreach($sanPham as $item)
                                {
                                    $key = "soLuong".$item->facility_id;
                                    $soLuong = $request->get($key);
                                    if($soLuong>0)
                                    {
                                        DB::table('st_delivery_bill_detail')
                                        ->insert([
                                            'deliveryBill_id'=>$id,
                                            'facility_id'=>$item->facility_id,
                                            'deliveryBillDetail_amount'=>$soLuong
                                        ]);
                                        $tonKho = DB::table('st_inventory')
                                        ->where('inventory_id',$item->inventory_id)
                                        ->where('branch_id',$coSo)->get()->first();
                                        if(isset($tonKho))
                                            DB::table('st_inventory')
                                            ->where('inventory_id',$item->inventory_id)
                                            ->where('branch_id',$coSo)
                                            ->update([
                                                'inventory_amount'=>$tonKho->inventory_amount - $soLuong
                                            ]);
                                    }
                                }
                                return response(1);
                            }
                            else
                             return response(3);
        
                        }
                        catch(QueryException $ex)
                        {
                            return response(0);
                        }
                    
    
            }
            else
            return response(2);
        }
    }


   
 
   

  
  


   public function searchPhieuXuatMarketing(Request $request)
   {
    if ($request->ajax()) {
        $quyen = new quyenController();
        $lay = $quyen->layDuLieu();
        $value = $request->get('value');
        $page = $request->get('page');
        $quyenTatCa =$quyen->getXemTatCaPhieuXuatMarketing();


        if($quyenTatCa==1)
        {
            if ($value == "")
            $phieuXuat = DB::table('view_phieu_xuat')
                ->where('deliveryBill_type',2)
                ->orderBy('deliveryBill_time')
                ->take($lay)
                ->skip(($page - 1) * $lay)
                ->get();
            else
            $phieuXuat = DB::table('view_phieu_xuat')
            ->where('deliveryBill_type',2)
            ->where(function($query) use ($value)
            {
                $query ->where('employee_name', 'like', '%' . $value . '%')
                ->orwhere('deliveryBill_receiver', 'like', '%' . $value . '%');
            })
            ->orderBy('deliveryBill_time')
            ->take($lay)
            ->skip(($page - 1) * $lay)
            ->get();
        }
        else
        {
            if ($value == "")
            $phieuXuat = DB::table('view_phieu_xuat')
                ->where('deliveryBill_type',2)
                ->where('branch_id',session('coSo'))
                ->orderBy('deliveryBill_time')
                ->take($lay)
                ->skip(($page - 1) * $lay)
                ->get();
            else
            $phieuXuat = DB::table('view_phieu_xuat')
            ->where('deliveryBill_status',1)
            ->where('branch_id',session('coSo'))
            ->where(function($query) use ($value)
            {
                $query ->where('employee_name', 'like', '%' . $value . '%')
                ->orwhere('deliveryBill_receiver', 'like', '%' . $value . '%');
            })
            ->orderBy('deliveryBill_time')
            ->take($lay)
            ->skip(($page - 1) * $lay)
            ->get();
        }
      
       

        $out = "";
        $i = 1;
        foreach ($phieuXuat as $item) {

            $out .= ' <tr>
            <td>'.$i.'</td>
           
            <td>'.$item->deliveryBill_name.'</td>
            <td>'.date('H:i d/m/Y',strtotime( $item->deliveryBill_time)) .'</td>
            <td>'.$item->employee_name.'</td>
            <td>'.$item->deliveryBill_receiver.'</td>
          
            <td><a class="btn" onclick="getChiTiet('.$item->deliveryBill_id.');"  data-toggle="modal" data-target="#basicModal">Chi tiết</a></td>
           ';
            if(session('quyen183')==1)
            $out .= ' <td><a class="btn" href="'.route('getCapNhatPhieuXuatMarketingKho').'?id='.$item->deliveryBill_id.'" >
                            <i style="color: blue" class="fa fa-edit"></i>
                        </a>
                    </td>';
         
           
            if(session('quyen184')==1)
            $out .= '  <td>
                <a class="btn" onclick="xoa('.$item->deliveryBill_id.');">
                    <i style="color: red" class="fa fa-close"></i>
                </a>
            </td>';
           
            $out .= ' </tr>';
            $i++;
        }
        return response($out);
    }
   }


}
