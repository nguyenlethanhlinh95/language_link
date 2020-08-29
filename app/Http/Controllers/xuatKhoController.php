<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\ViewName;

class xuatKhoController extends Controller
{
    public function getXuatKho()
    {
        $quyen = new quyenController();
        $quyenXemKH = $quyen->getXemPhieuXuat();
        if ($quyenXemKH == 1) {
            $quyenTatCa =$quyen->getXemTatCaPhieuXuat();
            $lay = $quyen->layDuLieu();
        
            if($quyenTatCa==1)
            {
                $phieuXuat = DB::table('view_phieu_xuat')
                ->where('deliveryBill_type',1)
                ->orderByDesc('deliveryBill_time')
                ->take($lay)
                ->skip(0)
                ->get();
                $phieuXuatTong = DB::table('view_phieu_xuat')
                ->where('deliveryBill_type',1)
                ->orderBy('deliveryBill_id')
                ->count();
            }
            else
            {
                $phieuXuat = DB::table('view_phieu_xuat')
                ->where('deliveryBill_type',1)
                ->where('branch_id',session('coSo'))
                ->orderByDesc('deliveryBill_time')
                ->take($lay)
                ->skip(0)
                ->get();
                $phieuXuatTong = DB::table('view_phieu_xuat')
                ->where('deliveryBill_type',1)
                ->where('branch_id',session('coSo'))
                ->orderBy('deliveryBill_id')
                ->count();
            }
            $soKM = $phieuXuatTong;
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
            return view('CoSoVatChat.phieuXuat')
            ->with('soTrang', $soTrang)
            ->with('page', 1)
            ->with('phieuXuat',$phieuXuat)
            ;

        }
        else
            return redirect()->back();
    }
    public function getCapNhatPhieuXuatKho(Request $request)
    {
        $id = $request->get('id');
        $phieuXuat = DB::table('st_delivery_bill')
            ->join('st_branch','st_branch.branch_id','=','st_delivery_bill.branch_id')
            ->where('deliveryBill_id',$id)
            ->get()->first();
            $idChiNhanh = $phieuXuat->branch_id;
         $quyen = new quyenController();
      

            $quyenXemKH = $quyen->getSuaPhieuXuat();
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

                return view('CoSoVatChat.suaPhieuXuat')
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
    public function getThemPhieuXuatKho()
    {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getThemPhieuXuat();
            if ($quyenXemKH == 1) {
                $quyenTatCa =$quyen->getXemTatCaPhieuXuat();
             
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
                    $idChiNhanh = session('coSo');
                    $chiNhanh = DB::table('st_branch')
                    ->where('branch_id',session('coSo'))
                    ->get();
                    $sanPham = DB::table('view_ton_kho')
                    ->where('branch_id',session('coSo'))
                   
                    ->orderBy('facilityType_id')
                    ->get();
                }
                $nhanVien = DB::table('st_employee')
                ->where('branch_id',$idChiNhanh)
                ->where('employee_status',1)
                ->get();
                $phongBan = DB::table('st_department')
                ->get();

                return view('CoSoVatChat.themPhieuXuat')
                ->with('chiNhanh',$chiNhanh)
                ->with('nhanVien',$nhanVien)
            ->with('phongBan',$phongBan)
                ->with('sanPham',$sanPham);
            }
            else
            return redirect()->back();
        
    }

    public function postThemPhieuXuatKho(Request $request)
    {
        if($request->ajax())
        {
            

            $quyen = new quyenController();
            $quyenXemKH = $quyen->getThemPhieuXuat();
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
                                    'deliveryBill_type'=>1
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


    public function getDuyetPhieuXuatKho(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getDuyetPhieuXuat();
            if ($quyenXemKH == 1) {

                try{
                  $id=$request->get('id');
                  $trangThai = $request->get('trangThai');

                

                if($trangThai==1)
                {
                    $phieuXuat= DB::table('view_phieu_xuat_chi_tiet')
                    ->where('deliveryBill_id',$id)
                    ->get();
                    $kiemTraTonKho=0;
                    foreach($phieuXuat as $item)
                    {
                        $tonKho = DB::table('view_ton_kho')
                        ->where('facility_id',$item->facility_id)
                        ->where('branch_id',$item->branch_id)
                        ->get()->first();
                        if(isset($tonKho))
                            $soLuongTon = $tonKho->inventory_amount;
                            else
                            $soLuongTon=0;

                        if($soLuongTon<$item->deliveryBillDetail_amount)
                            $kiemTraTonKho=1;
                    }
                    if($kiemTraTonKho==0)
                    {
                        foreach($phieuXuat as $item)
                        {
                            $tonKho = DB::table('view_ton_kho')
                            ->where('facility_id',$item->facility_id)
                            ->where('branch_id',$item->branch_id)
                            ->get()
                            ->first();
                            if(isset($tonKho))
                                $soLuongTon = $tonKho->inventory_amount;
                                else
                                $soLuongTon=0;
    
                                DB::table('st_inventory')
                                ->where('facility_id',$item->facility_id)
                                ->where('branch_id',$item->branch_id)
                                ->update([
                                    'inventory_amount'=>$soLuongTon-$item->deliveryBillDetail_amount
                                ]);
                        }
                        DB::table('st_delivery_bill')
                        ->where('deliveryBill_id',$id)
                        ->update([
                            'deliveryBill_status'=>$trangThai
                        ]);
                        return response(1);
                    }
                    else
                    {
                        return response(3);
                    }
                }
                else
                {
                    DB::table('st_delivery_bill')
                    ->where('deliveryBill_id',$id)
                    ->update([
                        'deliveryBill_status'=>$trangThai
                    ]);
                    return response(1);
                }
              

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

   public function postCapNhatPhieuXuatKho(Request $request)
   {
       if($request->ajax())
       {
           $id = $request->get('id');
           $phieuXuat = DB::table('st_delivery_bill')
           ->where('deliveryBill_id',$id)
           ->get()->first();
           $quyen = new quyenController();
           $nguoiNhan = $request->get('nguoiNhan');
                $boPhan = $request->get('boPhan');
                
            $quyenXemKH = $quyen->getSuaPhieuXuat();
            if ($quyenXemKH == 1) {
                $noiDung = $request->get('noiDung');
                $ghiChu = $request->get('ghiChu');
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
                $phieuXuat = DB::table('st_delivery_bill')
                ->join('st_branch','st_branch.branch_id','=','st_delivery_bill.branch_id')
                ->where('deliveryBill_id',$id)
                ->get()->first();
                $coSo= $phieuXuat->branch_id;


                $sanPham = DB::table('view_ton_kho')
                ->where('branch_id',$coSo)
                ->orderBy('facilityType_id')
                ->get();
                $kiemTraTonKho=0;
                foreach($sanPham as $item)
                {
                    $key = "soLuong".$item->facility_id;
                    $soLuong = $request->get($key);
                    $sanPhamThem = DB::table('st_delivery_bill_detail')
                    ->where('facility_id',$item->facility_id)
                    ->where('deliveryBill_id',$id)
                    ->get()->first();
                    if(isset($sanPhamThem))
                    $soLuongDaThem = $sanPhamThem->deliveryBillDetail_amount;
                    else
                    $soLuongDaThem=0;
                    if($soLuong > $item->inventory_amount+$soLuongDaThem)
                    $kiemTraTonKho=1;
                }
                if($kiemTraTonKho==0)
                {
                    DB::table('st_delivery_bill')
                    ->where('deliveryBill_id',$id)
                    ->update([
                        'deliveryBill_name'=>$noiDung,
                        'deliveryBill_note'=>$ghiChu,   
                        'deliveryBill_receiver'=>$nguoiNhan,
                        'deliveryBill_status'=>$trangThai,
                        'deliveryBill_partName'=>$boPhan
                    ]);
                  
                    $chiTiet= DB::table('view_phieu_xuat_chi_tiet')
                    ->where('deliveryBill_id',$id)->get();

                    foreach($chiTiet as $item)
                    {
                        $tonKho = DB::table('view_ton_kho')
                        ->where('facility_id',$item->facility_id)
                        ->where('branch_id',$item->branch_id)
                        ->get()->first();
                        if(isset($tonKho))
                            $soLuongTon = $tonKho->inventory_amount;
                            else
                            $soLuongTon=0;

                            DB::table('st_inventory')
                            ->where('facility_id',$item->facility_id)
                            ->where('branch_id',$item->branch_id)
                            ->update([
                                'inventory_amount'=>$soLuongTon+$item->deliveryBillDetail_amount
                            ]);
                    }
                    DB::table('st_delivery_bill_detail')
                    ->where('deliveryBill_id',$id)
                    ->delete();

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

                            $tonKho = DB::table('view_ton_kho')
                            ->where('facility_id',$item->facility_id)
                            ->where('branch_id',$item->branch_id)
                            ->get()->first();
                            if(isset($tonKho))
                                $soLuongTon = $tonKho->inventory_amount;
                                else
                                $soLuongTon=0;
    
                                DB::table('st_inventory')
                                ->where('facility_id',$item->facility_id)
                                ->where('branch_id',$item->branch_id)
                                ->update([
                                    'inventory_amount'=>$soLuongTon-$soLuong
                                ]);
                        }
                    }
                    return response(1);
                }
                else
                 return response(3);
            }
            else
            return  response(4);
           
       }
   }


   public function getChiTietPhieuXuat(Request $request)
   {
        if($request->ajax())
        {
            $id= $request->get('id');
            $chiTiet = DB::table('view_phieu_xuat_chi_tiet')
            ->where('deliveryBill_id',$id)
            ->get();
            $out="";
            $i=1;
            foreach($chiTiet as $item)
            {
                $out.="<tr>
                <td>".$i."</td>
                <td>".$item->facility_name."</td>
                <td>".$item->deliveryBillDetail_amount."</td>
                </tr>";
                $i++;
            }

            return response($out);
        }
   }

   public function getChangeChiNhanhPhieuXuat(Request $request)
   {
       if($request->ajax())
       {
           $id= $request->get('id');
           $sanPham = DB::table('view_ton_kho')
           ->where('branch_id', $id)
          
           ->get();

           $out ='';
           foreach($sanPham as $item)
           $out .='<option value="'.$item->facility_id.'">'.$item->facility_name.' ('.$item->inventory_amount.')</option>';
          
           $out1 ='';
           foreach($sanPham as $item)
           {
            if($item->inventory_amount>0)
               $out1.=' <input hidden id="tenSanPham'.$item->facility_id.'" value="'.$item->facility_name.'">
               <input hidden id="tonKho'.$item->facility_id.'" value="'.$item->inventory_amount.'">';
           }
          $arr[]=[
              'sanPham'=>$out,
              'tonKho'=>$out1
          ];
           return response($arr);
           
       }
   }

   public function getXoaPhieuXuat(Request $request)
   {
       if($request->ajax())
       {
        $quyen = new quyenController();
          
        $quyenChiTiet = $quyen->getXoaPhieuXuat();
        if ($quyenChiTiet == 1) {
            try
            {
            $id = $request->get('id');
            $chiTiet = DB::table('view_phieu_xuat_chi_tiet')
            ->where('deliveryBill_id',$id)
            ->get();

            foreach($chiTiet as $item)
            {
                $tonKho = DB::table('st_inventory')
                ->where('facility_id',$item->facility_id)
                ->where('branch_id',$item->branch_id)
                ->get()->first();
                if(isset($tonKho))
                {
                    DB::table('st_inventory')
                    ->where('facility_id',$item->facility_id)
                    ->where('branch_id',$item->branch_id)
                    ->update([
                        'inventory_amount'=>$tonKho->inventory_amount+ $item->deliveryBillDetail_amount
                    ]);
                }
                
            }
            DB::table('st_delivery_bill_detail')
            ->where('deliveryBill_id',$id)
            ->delete();
            
            DB::table('st_delivery_bill')
            ->where('deliveryBill_id',$id)
            ->delete();
           
            return response(1);
        }catch(QueryException $ex)
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


   public function searchPhieuXuat(Request $request)
   {
    if ($request->ajax()) {
        $quyen = new quyenController();
        $lay = $quyen->layDuLieu();
        $value = $request->get('value');
        $page = $request->get('page');
        $quyenTatCa =$quyen->getXemTatCaPhieuXuat();

        $phieuXuat = DB::table('view_phieu_xuat')
        ->where('deliveryBill_status',1)
        ->orderBy('deliveryBill_time')
        ->take($lay)
        ->skip(0)
        ->get();

        if($quyenTatCa==1)
        {
            if ($value == "")
            $phieuXuat = DB::table('view_phieu_xuat')
            ->where('deliveryBill_type',1)
                ->orderByDesc('deliveryBill_time')
                ->take($lay)
                ->skip(($page - 1) * $lay)
                ->get();
            else
            $phieuXuat = DB::table('view_phieu_xuat')
            ->where('deliveryBill_type',1)
            ->where(function($query) use ($value)
            {
                $query ->where('employee_name', 'like', '%' . $value . '%')
                ->orwhere('deliveryBill_receiver', 'like', '%' . $value . '%');
            })
            ->orderByDesc('deliveryBill_time')
            ->take($lay)
            ->skip(($page - 1) * $lay)
            ->get();
        }
        else
        {
            if ($value == "")
            $phieuXuat = DB::table('view_phieu_xuat')
            ->where('deliveryBill_type',1)
                ->where('branch_id',session('coSo'))
                ->orderByDesc('deliveryBill_time')
                ->take($lay)
                ->skip(($page - 1) * $lay)
                ->get();
            else
            $phieuXuat = DB::table('view_phieu_xuat')
            ->where('deliveryBill_type',1)
            ->where('branch_id',session('coSo'))
            ->where(function($query) use ($value)
            {
                $query ->where('employee_name', 'like', '%' . $value . '%')
                ->orwhere('deliveryBill_receiver', 'like', '%' . $value . '%');
            })
            ->orderByDesc('deliveryBill_time')
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
            $out .= ' <td><a class="btn" href="'.route('getCapNhatPhieuXuatKho').'?id='.$item->deliveryBill_id.'" >
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
