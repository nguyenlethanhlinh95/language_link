<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class phieuXuatVatPhamController extends Controller
{
    public function getXuatVatPham()
    {
        $quyen = new quyenController();
        $quyenXemKH = $quyen->getXemPhieuXuatVatPham();
        if ($quyenXemKH == 1) {
            $quyenTatCa =$quyen->getPhieuXuatVatPhamTatCaChiNhanh();
            $lay = $quyen->layDuLieu();


            if($quyenTatCa==1)
            {
                $PhieuXuatVatPhamTong = DB::table('view_phieu_xuat_vat_pham')
                ->orderByDesc('deliveryBillItem_time')
                ->select('deliveryBillItem_id')
                ->get();

                $PhieuXuatVatPham = DB::table('view_phieu_xuat_vat_pham')
                ->orderByDesc('deliveryBillItem_time')
                ->take($lay)
                ->skip(0)
                ->get();
            }
            else
            {
                $PhieuXuatVatPhamTong = DB::table('view_phieu_xuat_vat_pham')
                ->where('branch_id',session('coSo'))
                ->orderByDesc('deliveryBillItem_time')
                ->select('deliveryBillItem_id')
                ->get();
                $PhieuXuatVatPham = DB::table('view_phieu_xuat_vat_pham')
                ->where('branch_id',session('coSo'))
                ->orderByDesc('deliveryBillItem_time')
                ->take($lay)
                ->skip(0)
                ->get();
            }
            $soKM = count($PhieuXuatVatPhamTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
            return view('VatPham.phieuXuat')
            ->with('soTrang', $soTrang)
            ->with('page', 1)
            ->with('phieuXuat',$PhieuXuatVatPham);

        }
        else
            return redirect()->back();
    }
    public function getCapNhatPhieuXuatVatPham(Request $request)
    {
        $id = $request->get('id');
        $PhieuXuatVatPham = DB::table('st_delivery_bill_item')
            ->join('st_branch','st_branch.branch_id','=','st_delivery_bill_item.branch_id')
            ->where('deliveryBillItem_id',$id)
            ->get()->first();
         $quyen = new quyenController();
      
        $idChiNhanh = $PhieuXuatVatPham->branch_id;
            $quyenXemKH = $quyen->getXemPhieuXuatVatPham();
            if ($quyenXemKH == 1) {
                $chiTiet = DB::table('view_phieu_xuat_vat_pham_chi_tiet')
                ->where('deliveryBillItem_id',$id)
                ->get();
                $sanPham = DB::table('view_vat_pham_chi_nhanh')
                ->where('branch_id',$idChiNhanh)
                
                ->get();

                $nhanVien = DB::table('st_employee')
                ->where('branch_id',$idChiNhanh)
                ->where('employee_status',1)
                ->get();
                $phongBan = DB::table('st_department')
                ->get();

                return view('VatPham.capNhatPhieuXuat')
                ->with('phieuXuat',$PhieuXuatVatPham)
                ->with('chiTiet',$chiTiet)
                ->with('sanPham',$sanPham)
                ->with('nhanVien',$nhanVien)
                ->with('phongBan',$phongBan)
                ;
            
            }
            else
            return redirect()->back();
           
       
          
        
           
    }
    public function getThemPhieuXuatVatPham()
    {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getThemPhieuXuatVatPham();
            if ($quyenXemKH == 1) {
                $quyenTatCa =$quyen->getPhieuXuatVatPhamTatCaChiNhanh();
               
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
                    $sanPham = DB::table('view_vat_pham_chi_nhanh')
                    ->where('branch_id',$idChiNhanh)
                    
                    ->get();
                }
                else
                {
                    $chiNhanh = DB::table('st_branch')
                    ->where('branch_id',session('coSo'))
                    ->get();
                    $sanPham = DB::table('view_vat_pham_chi_nhanh')
                    ->where('branch_id',session('coSo'))
                   
                    ->get();
                    $idChiNhanh = session('coSo');
                }
                $nhanVien = DB::table('st_employee')
                ->where('branch_id',$idChiNhanh)
                ->where('employee_status',1)
                ->get();
                $phongBan = DB::table('st_department')
                ->get();

                return view('VatPham.themPhieuXuatVatPham')
                ->with('chiNhanh',$chiNhanh)
                ->with('nhanVien',$nhanVien)
                ->with('phongBan',$phongBan)
                ->with('sanPham',$sanPham);
            }
            else
            return redirect()->back();
        
    }

    public function postThemPhieuXuatVatPham(Request $request)
    {
        if($request->ajax())
        {
            

            $quyen = new quyenController();
            $quyenXemKH = $quyen->getThemPhieuXuatVatPham();
            if ($quyenXemKH == 1) {
               
               
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
                           
                            
                            $sanPham = DB::table('view_vat_pham_chi_nhanh')
                            ->where('branch_id',$coSo)
                            ->get();
                            $kiemTraTonKho=0;
                            foreach($sanPham as $item)
                            {
                                $key = "soLuong".$item->item_id;
                                $soLuong = $request->get($key);
                                if($soLuong > $item->inventoryItem_amount)
                                $kiemTraTonKho=1;
                            }
        
                            if($kiemTraTonKho==0)
                            {
                                $id= DB::table('st_delivery_bill_item')
                                ->insertGetId([
                                    'deliveryBillItem_name'=>$noiDung,
                                    'deliveryBillItem_time'=>$now,
                                    'employee_id'=>session('user'),
                                    'deliveryBillItem_note'=>$ghiChu,
                                    'deliveryBillItem_status'=>$trangThai,
                                    'branch_id'=>$coSo,
                                    'deliveryBillItem_receiver'=>$nguoiNhan,
                                    'deliveryBillItem_partName'=>$boPhan
                                ]);
        
                                foreach($sanPham as $item)
                                {
                                    $key = "soLuong".$item->item_id;
                                    $soLuong = $request->get($key);
                                    if($soLuong>0)
                                    {
                                        DB::table('st_delivery_bill_item_detail')
                                        ->insert([
                                            'deliveryBillItem_id'=>$id,
                                            'item_id'=>$item->item_id,
                                            'deliveryBillItemDetail_amount'=>$soLuong
                                        ]);

                                        $tonKho =   DB::table('st_inventory_item')
                                        ->where('item_id',$item->item_id)
                                        ->where('branch_id',$coSo)
                                        ->get()
                                        ->first();

                                        if(isset($tonKho))
                                            DB::table('st_inventory_item')
                                            ->where('inventoryItem_id',$tonKho->inventoryItem_id)
                                            ->update([
                                                'inventoryItem_amount'=>$tonKho->inventoryItem_amount - $soLuong
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


    public function getDuyetPhieuXuatVatPham(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getDuyetPhieuXuatVatPham();
            if ($quyenXemKH == 1) {

                try{
                  $id=$request->get('id');
                  $trangThai = $request->get('trangThai');

                

                if($trangThai==1)
                {
                    $PhieuXuatVatPham= DB::table('view_phieu_xuat_vat_pham_chi_tiet')
                    ->where('deliveryBillItem_id',$id)
                    ->get();
                    $kiemTraTonKho=0;
                    foreach($PhieuXuatVatPham as $item)
                    {
                        $tonKho = DB::table('view_vat_pham_chi_nhanh')
                        ->where('item_id',$item->item_id)
                        ->where('branch_id',$item->branch_id)
                        ->get()->first();
                        if(isset($tonKho))
                            $soLuongTon = $tonKho->inventoryItem_amount;
                            else
                            $soLuongTon=0;

                        if($soLuongTon<$item->deliveryBillItemDetail_amount)
                            $kiemTraTonKho=1;
                    }
                    if($kiemTraTonKho==0)
                    {
                        foreach($PhieuXuatVatPham as $item)
                        {
                            $tonKho = DB::table('view_vat_pham_chi_nhanh')
                            ->where('item_id',$item->item_id)
                            ->where('branch_id',$item->branch_id)
                            ->get()->first();
                            if(isset($tonKho))
                                $soLuongTon = $tonKho->inventoryItem_amount;
                                else
                                $soLuongTon=0;
    
                                DB::table('st_inventory_item')
                                ->where('item_id',$item->item_id)
                                ->where('branch_id',$item->branch_id)
                                ->update([
                                    'inventoryItem_amount'=>$soLuongTon-$item->deliveryBillItemDetail_amount
                                ]);
                        }
                        DB::table('st_delivery_bill_item')
                        ->where('deliveryBillItem_id',$id)
                        ->update([
                            'deliveryBillItem_status'=>$trangThai
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
                    DB::table('st_delivery_bill_item')
                    ->where('deliveryBillItem_id',$id)
                    ->update([
                        'deliveryBillItem_status'=>$trangThai
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

   public function postCapNhatPhieuXuatVatPham(Request $request)
   {
       if($request->ajax())
       {
           $id = $request->get('id');
           $PhieuXuatVatPham = DB::table('st_delivery_bill_item')
           ->where('deliveryBillItem_id',$id)
           ->get()->first();
           $quyen = new quyenController();
          
            $quyenXemKH = $quyen->getSuaPhieuXuatVatPham();
            if ($quyenXemKH == 1) {
                $noiDung = $request->get('noiDung');
                $ghiChu = $request->get('ghiChu');
                $nguoiNhan = $request->get('nguoiNhan');
                $boPhan = $request->get('boPhan');
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
                $PhieuXuatVatPham = DB::table('st_delivery_bill_item')
                ->join('st_branch','st_branch.branch_id','=','st_delivery_bill_item.branch_id')
                ->where('deliveryBillItem_id',$id)
                ->get()->first();
                $coSo= $PhieuXuatVatPham->branch_id;


                $sanPham = DB::table('view_vat_pham_chi_nhanh')
                ->where('branch_id',$coSo)
                ->get();
                $kiemTraTonKho=0;
                foreach($sanPham as $item)
                {
                    $key = "soLuong".$item->item_id;
                    $soLuong = $request->get($key);
                    $sanPhamThem = DB::table('st_delivery_bill_item_detail')
                    ->where('item_id',$item->item_id)
                    ->where('deliveryBillItem_id',$id)
                    ->get()->first();
                    if(isset($sanPhamThem))
                    $soLuongDaThem = $sanPhamThem->deliveryBillItemDetail_amount;
                    else
                    $soLuongDaThem=0;
                    if($soLuong > $item->inventoryItem_amount+$soLuongDaThem)
                    $kiemTraTonKho=1;
                }
                if($kiemTraTonKho==0)
                {
                    DB::table('st_delivery_bill_item')
                    ->where('deliveryBillItem_id',$id)
                    ->update([
                        'deliveryBillItem_name'=>$noiDung,
                        'deliveryBillItem_note'=>$ghiChu,   
                        'deliveryBillItem_receiver'=>$nguoiNhan,
                        'deliveryBillItem_partName'=>$boPhan,
                        'deliveryBillItem_status'=>$trangThai
                    ]);
                  
                    $chiTiet= DB::table('view_phieu_xuat_vat_pham_chi_tiet')
                    ->where('deliveryBillItem_id',$id)->get();

                    foreach($chiTiet as $item)
                    {
                        $tonKho = DB::table('view_vat_pham_chi_nhanh')
                        ->where('item_id',$item->item_id)
                        ->where('branch_id',$item->branch_id)
                        ->get()->first();
                        if(isset($tonKho))
                            $soLuongTon = $tonKho->inventoryItem_amount;
                            else
                            $soLuongTon=0;

                            DB::table('st_inventory_item')
                            ->where('item_id',$item->item_id)
                            ->where('branch_id',$item->branch_id)
                            ->update([
                                'inventoryItem_amount'=>$soLuongTon+$item->deliveryBillItemDetail_amount
                            ]);
                    }
                    DB::table('st_delivery_bill_item_detail')
                    ->where('deliveryBillItem_id',$id)
                    ->delete();

                    foreach($sanPham as $item)
                    {
                        $key = "soLuong".$item->item_id;
                        $soLuong = $request->get($key);
                        if($soLuong>0)
                        {
                            DB::table('st_delivery_bill_item_detail')
                            ->insert([
                                'deliveryBillItem_id'=>$id,
                                'item_id'=>$item->item_id,
                                'deliveryBillItemDetail_amount'=>$soLuong
                            ]);

                            $tonKho = DB::table('view_vat_pham_chi_nhanh')
                            ->where('item_id',$item->item_id)
                            ->where('branch_id',$item->branch_id)
                            ->get()->first();
                            if(isset($tonKho))
                                $soLuongTon = $tonKho->inventoryItem_amount;
                                else
                                $soLuongTon=0;
    
                                DB::table('st_inventory_item')
                                ->where('item_id',$item->item_id)
                                ->where('branch_id',$item->branch_id)
                                ->update([
                                    'inventoryItem_amount'=>$soLuongTon-$soLuong
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


   public function getChiTietPhieuXuatVatPham(Request $request)
   {
        if($request->ajax())
        {
            $id= $request->get('id');
            $chiTiet = DB::table('view_phieu_xuat_vat_pham_chi_tiet')
            ->where('deliveryBillItem_id',$id)
            ->get();
            $out="";
            $i=1;
            foreach($chiTiet as $item)
            {
                $out.="<tr>
                <td>".$i."</td>
                <td>".$item->item_name."</td>
                <td>".$item->deliveryBillItemDetail_amount."</td>
                </tr>";
                $i++;
            }

            return response($out);
        }
   }

   public function getChangeChiNhanhPhieuXuatVatPham(Request $request)
   {
       if($request->ajax())
       {
           $id= $request->get('id');
           $sanPham = DB::table('view_vat_pham_chi_nhanh')
           ->where('branch_id', $id)->get();

           $out ='';
           foreach($sanPham as $item)
           $out .='<option value="'.$item->item_id.'">'.$item->item_name.' ('.$item->inventoryItem_amount.')</option>';
          
           $out1='';
           foreach($sanPham as $item)
           {
               $out1.=' <input hidden id="tenSanPham'.$item->item_id.'" value="'.$item->item_name.'">
               <input hidden id="tonKho'.$item->item_id.'" value="'.$item->inventoryItem_amount.'">';
           }
          $arr[]=[
              'tonKho'=>$out1,
              'sanPham'=>$out
          ];
           return response($arr);
           
       }
   }

   public function getXoaPhieuXuatVatPham(Request $request)
   {
       if($request->ajax())
       {
        $quyen = new quyenController();
          
        $quyenChiTiet = $quyen->getXoaPhieuXuatVatPham();
        if ($quyenChiTiet == 1) {
            try
            {
            $id = $request->get('id');
            $chiTiet = DB::table('view_phieu_xuat_vat_pham_chi_tiet')
            ->where('deliveryBillItem_id',$id)
            ->get();

            foreach($chiTiet as $item)
            {
                $tonKho = DB::table('st_inventory_item')
                ->where('item_id',$item->item_id)
                ->where('branch_id',$item->branch_id)
                ->get()->first();
                if(isset($tonKho))
                {
                    DB::table('st_inventory_item')
                    ->where('item_id',$item->item_id)
                    ->where('branch_id',$item->branch_id)
                    ->update([
                        'inventoryItem_amount'=>$tonKho->inventoryItem_amount+ $item->deliveryBillItemDetail_amount
                    ]);
                }
                
            }
            DB::table('st_delivery_bill_item_detail')
            ->where('deliveryBillItem_id',$id)
            ->delete();
            
            DB::table('st_delivery_bill_item')
            ->where('deliveryBillItem_id',$id)
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

   public function searchPhieuXuatVatPham(Request $request)
   {
    if ($request->ajax()) {
        $quyen = new quyenController();
        $lay = $quyen->layDuLieu();
        $value = $request->get('value');
        $page = $request->get('page');
        $quyenTatCa = $quyen->getPhieuXuatVatPhamTatCaChiNhanh();
       
        if($quyenTatCa == 1)
        {
            if ($value == "")
            $khuyenMai =  DB::table('view_phieu_xuat_vat_pham')
            ->orderByDesc('deliveryBillItem_time')
                ->take($lay)
                ->skip(($page - 1) * $lay)
                ->get();
            else
            $khuyenMai = DB::table('view_phieu_xuat_vat_pham')
            ->orderByDesc('deliveryBillItem_time')
                ->where('branch_name', 'like', '%' . $value . '%')
                ->orWhere('deliveryBillItem_name', 'like', '%' . $value . '%')
                ->orWhere('employee_name', 'like', '%' . $value . '%')
                ->orWhere('deliveryBillItem_receiver', 'like', '%' . $value . '%')
                ->take($lay)
                ->skip(($page - 1) * $lay)
                ->get();

        }
        else
        {
            if ($value == "")
            $khuyenMai =  DB::table('view_nhap_kho_vat_pham')
            ->orderByDesc('deliveryBillItem_time')
            ->where('branch_id',session('coSo'))
                ->take($lay)
                ->skip(($page - 1) * $lay)
                ->get();
            else
            $khuyenMai = DB::table('view_nhap_kho_vat_pham')
            ->orderByDesc('deliveryBillItem_time')
            ->where('branch_id',session('coSo'))
            ->where(function($query) use($value)
            {
                $query->Where('deliveryBillItem_name', 'like', '%' . $value . '%')
                ->orWhere('employee_name', 'like', '%' . $value . '%')
                ->orWhere('deliveryBillItem_receiver', 'like', '%' . $value . '%');
            })
                ->take($lay)
                ->skip(($page - 1) * $lay)
                ->get();
        }

       
        $out = "";
        $i = 1;
        foreach ($khuyenMai as $item) {

            $out .= '<tr>
            <td>' . $i . '</td>
            <td>' . $item->branch_name . '</td>  
            <td>' . $item->deliveryBillItem_name . '</td>     
            <td>' . date('H:i d/m/Y', strtotime($item->deliveryBillItem_time)) . '</td>
            <td>' . $item->employee_name . '</td>
            <td>' . $item->deliveryBillItem_receiver . '</td>
            <td><a class="btn" onclick="getChiTiet('.$item->deliveryBillItem_id.');"  data-toggle="modal" data-target="#basicModal">Chi tiết</a></td>
            ';

            if (session('quyen243') == 1)
                $out .= '<td>
                        <a class="btn" href=\'' . route('getCapNhatPhieuXuatVatPham') . '?id=' . $item->deliveryBillItem_id . '\'>
                            <i style="color: blue" class="fa fa-edit"></i>
                                    </a>
                    </td>';
            if (session('quyen244') == 1)
                $out .= '  <td>
                                    <a class="btn" onclick="xoa(\'' . $item->deliveryBillItem_id . '\');">
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
