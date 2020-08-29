<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class phieuNhapVatPhamController extends Controller
{
    public function getPhieuNhapVatPham()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemPhieuNhapVatPham();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $quyenTatCa = $quyen->getPhieuNhapVatPhamTatCaChiNhanh();
            if($quyenTatCa==1)
            {
                $PhieuNhapVatPhamTong = DB::table('view_nhap_kho_vat_pham')
                ->orderByDesc('warehousingItem_time')
                ->select('warehousingItem_id')
                ->get();
                    $PhieuNhapVatPham = DB::table('view_nhap_kho_vat_pham')
                    ->take($lay)
                    ->skip(0)
                    ->orderByDesc('warehousingItem_time')
                    ->get();
            }
            else
            {
                $PhieuNhapVatPhamTong = DB::table('view_nhap_kho_vat_pham')
                ->orderByDesc('warehousingItem_time')
                ->where('branch_id',session('coSo'))
                ->select('warehousingItem_id')
                ->get();
                $PhieuNhapVatPham = DB::table('view_nhap_kho_vat_pham')
                ->where('branch_id',session('coSo'))
                ->take($lay)
                ->skip(0)
                ->orderByDesc('warehousingItem_time')
                ->get();
            }

            $soKM = count($PhieuNhapVatPhamTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;

            return view('VatPham.phieuNhap')
            ->with('soTrang', $soTrang)
            ->with('page', 1)
            ->with('PhieuNhapVatPham',$PhieuNhapVatPham);
        }
        else
        return redirect()->back();
    }

    public function getThemPhieuNhapVatPham()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThemPhieuNhapVatPham();
        if($quyenChiTiet==1)
        {
           

            $quyenTatCa = $quyen->getPhieuNhapVatPhamTatCaChiNhanh();
            if($quyenTatCa==1)
            {
                $chiNhanh = DB::table('st_branch')
                ->get();
                $idChiNhanh = 0;
                if(count( $chiNhanh)>0)
                {   
                    $chiNhanhDau = $chiNhanh->first();
                    $idChiNhanh= $chiNhanhDau->branch_id;
                }
                
                $sanPham = DB::table('view_vat_pham_chi_nhanh')
                ->where('branch_id',$idChiNhanh)->get();
            }
            else
            {
                $chiNhanh = DB::table('st_branch')
                ->where('branch_id',session('coSo'))
                ->get();
                $sanPham = DB::table('view_vat_pham_chi_nhanh')
                ->where('branch_id',session('coSo'))->get();
                $idChiNhanh = session('coSo');
            }
            $nhanVien = DB::table('st_employee')
            ->where('branch_id',$idChiNhanh)
            ->where('employee_status',1)
            ->get();
            $phongBan = DB::table('st_department')
            ->get();
            return view('VatPham.themPhieuNhapVatPham')
            ->with('chiNhanh',$chiNhanh)
            ->with('nhanVien',$nhanVien)
            ->with('phongBan',$phongBan)
            ->with('sanPham',$sanPham)
            ;
        }
        else
        return redirect()->back();
    }
    public function getCapNhatPhieuNhapVatPham(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getSuaPhieuNhapVatPham();
        if($quyenChiTiet==1)
        {
            $id = $request->get('id');
            $PhieuNhapVatPham = DB::table('view_nhap_kho_vat_pham')
            ->where('warehousingItem_id',$id)
            ->get()->first();
            $chiTietPhieuNhapVatPham = DB::table('st_warehousing_item_detail')
            ->join('st_item','st_item.item_id','=','st_warehousing_item_detail.item_id')
            ->where('warehousingItem_id',$id)
            ->get();

            $sanPham = DB::table('view_vat_pham_chi_nhanh')
            ->where('branch_id',$PhieuNhapVatPham->branch_id)
            ->get();
            $nhanVien = DB::table('st_employee')
            ->where('branch_id',$PhieuNhapVatPham->branch_id)
            ->where('employee_status',1)
            ->get();
            $phongBan = DB::table('st_department')
            ->get();
            return view('VatPham.capNhatPhieuNhap')
            ->with('phieuNhap',$PhieuNhapVatPham)
            ->with('chiTietPhieuNhap',$chiTietPhieuNhapVatPham)
            ->with('nhanVien',$nhanVien)
            ->with('phongBan',$phongBan)
            ->with('sanPham',$sanPham);
        }
        else
        return redirect()->back();
    }
    public function postThemPhieuNhapVatPhamKho(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThemPhieuNhapVatPham();
        if($quyenChiTiet==1)
        {
            $loai = $request->get('loaiThem');
           
                    $noiDung = $request->get('noiDung');
                    $nguoiNhan = $request->get('nguoiNhan');
                    $boPhan = $request->get('boPhan');
                    $ghiChu = $request->get('ghiChu');
                    $now = Carbon::now('Asia/Ho_Chi_Minh');
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
                    try
                    {
                        $id= DB::table('st_warehousing_item')
                        ->insertGetId([
                            'warehousingItem_name'=>$noiDung,
                            'warehousingItem_time'=>$now,
                            'employee_id'=>session('user'),
                            'warehousingItem_note'=>$ghiChu,
                            'warehousingItem_status'=>$trangThai,
                            'branch_id'=>$coSo,
                            'warehousingItem_receiver'=>$nguoiNhan,
                            'warehousingItem_partName'=>$boPhan
                        ]);
                        $sanPham = DB::table('view_vat_pham_chi_nhanh')
                        ->where('branch_id',$coSo)->get();
                        $tongTien = 0;
                        foreach($sanPham as $item)
                        {
                            $key = "soLuong".$item->item_id;
                            $soLuong = $request->get($key);
                            if($soLuong>0)
                            {
                                DB::table('st_warehousing_item_detail')
                                ->insert([
                                    'warehousingItem_id'=>$id,
                                    'item_id'=>$item->item_id,
                                    'warehousingItem_amount'=>$soLuong
                                ]);
                             
                                $tonKho = DB::table('st_inventory_item')
                                ->where('item_id',$item->item_id)
                                ->where('branch_id',$coSo)
                                ->get()->first();
                                    $soLuongTon = 0;
                                if(isset($tonKho))
                                $soLuongTon=$tonKho->inventoryItem_amount;
                                DB::table('st_inventory_item')
                                ->where('item_id',$item->item_id)
                                ->where('branch_id',$coSo)->update([
                                    'inventoryItem_status'=>1,
                                    'inventoryItem_amount'=>$soLuongTon+$soLuong
                                ]);
                            }
                        }
                       
                        return response(1);
                    }
                    catch(QueryException $ex)
                    {
                        return response(0);
                    }
           
        }
        else
        {
            return response(2);
        }
        
    }
    public function getChangChiNhanhPhieuNhapVatPham(Request $request)
    {
        if($request->ajax())
        {
            $id= $request->get('id');
            $sanPham = DB::table('view_vat_pham_chi_nhanh')
            ->where('branch_id', $id)->get();

            $out ='';
            foreach($sanPham as $item)
            $out .='<option value="'.$item->item_id.'">'.$item->item_name.'</option>';
           
            $out1 ='';
            foreach($sanPham as $item)
            {
                $out1.=' <input hidden id="tenSanPham'.$item->item_id.'" value="'.$item->item_name.'">
              ';
            }
           $arr[]=[
               'tonKho'=>$out1,
               'sanPham'=>$out
           ];
            return response($arr);
            
        }
    }

    public function postCapNhatPhieuNhapSanPham(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaPhieuNhapVatPham();
            if($quyenChiTiet==1)
            {
                $id = $request->get('id');
                $PhieuNhapVatPham = DB::table('view_nhap_kho_vat_pham')
                ->where('warehousingItem_id',$id)
                ->get()->first();
                $noiDung = $request->get('noiDung');
                $nguoiNhan = $request->get('nguoiNhan');
                $boPhan = $request->get('boPhan');
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
                $sanPham = DB::table('view_vat_pham_chi_nhanh')
                ->where('branch_id',$PhieuNhapVatPham->branch_id)
                ->get();
                $kiemTraTon="";
                foreach($sanPham as $item)
                {
                    $key = "soLuong".$item->item_id;
                    $soLuong = $request->get($key);
                    $tonkho = DB::table('st_inventory_item')
                    ->where('item_id',$item->item_id)
                    ->where('branch_id',$PhieuNhapVatPham->branch_id)
                    ->get()->first();
                    
                    $soLuongTon=0;
                    if(isset($tonkho))
                    $soLuongTon=$tonkho->inventoryItem_amount;

                    $chiTietPhieuNhapVatPham=DB::table('st_warehousing_item_detail')
                    ->where('warehousingItem_id',$PhieuNhapVatPham->warehousingItem_id)
                    ->where('item_id',$item->item_id)
                    ->get()->first();
                    $soLuongNhap = 0;
                    if(isset($chiTietPhieuNhapVatPham))
                    $soLuongNhap = $chiTietPhieuNhapVatPham->warehousingItem_amount;

                    if($soLuongTon - $soLuongNhap + $soLuong < 0 )
                        $kiemTraTon.="Số lượng vật phẩm ". $item->item_name." không đủ. ";
                }
               
                if($kiemTraTon=="")
                {
                    try{
                        DB::table('st_warehousing_item')
                        ->where('warehousingItem_id',$id)
                        ->update([
                            'warehousingItem_name'=>$noiDung,
                            'employee_id'=>session('user'),
                            'warehousingItem_note'=>$ghiChu,
                            'warehousingItem_receiver'=>$nguoiNhan,
                            'warehousingItem_partName'=>$boPhan,
                            'warehousingItem_status'=>$trangThai
                        ]);
    
                        foreach($sanPham as $item)
                        {
                            $key = "soLuong".$item->item_id;
                            $soLuong = $request->get($key);
                            $tonkho = DB::table('st_inventory_item')
                            ->where('item_id',$item->item_id)
                            ->where('branch_id',$PhieuNhapVatPham->branch_id)
                            ->get()->first();
                            $soLuongTon=0;
                            if(isset($tonkho))
                            $soLuongTon=$tonkho->inventoryItem_amount;
        
                            $chiTietPhieuNhapVatPham=DB::table('st_warehousing_item_detail')
                            ->where('warehousingItem_id',$PhieuNhapVatPham->warehousingItem_id)
                            ->where('item_id',$item->item_id)
                            ->get()->first();
                            
                            $kiemTraSanPham=DB::table('st_warehousing_item_detail')
                            ->join('st_warehousing_item','st_warehousing_item.warehousingItem_id',
                            '=','st_warehousing_item_detail.warehousingItem_id')
                            ->where('st_warehousing_item.warehousingItem_id','!=',$PhieuNhapVatPham->warehousingItem_id)
                            ->where('st_warehousing_item_detail.item_id',$item->item_id)
                            ->where('st_warehousing_item.branch_id',$PhieuNhapVatPham->branch_id)
                            ->get()
                            ->first();
    
                            if(isset($kiemTraSanPham))
                            {
                                $trangThai =1;
                            }
                            else if($soLuong>0)
                            {
                                $trangThai=1;
                            }
                            else
                            $trangThai=0;
                            
    
                            $soLuongNhap = 0;
                            if(isset($chiTietPhieuNhapVatPham))
                            {
                               $soLuongNhap = $chiTietPhieuNhapVatPham->warehousingItem_amount;
                               DB::table('st_inventory_item')
                                ->where('item_id',$item->item_id)
                                ->where('branch_id',$PhieuNhapVatPham->branch_id)
                                ->update([
                                    'inventoryItem_amount'=>$soLuongTon-$soLuongNhap + $soLuong,
                                    'inventoryItem_status'=>$trangThai
                                ]);
                                DB::table('st_warehousing_item_detail')
                                ->where('warehousingItemDetail_id',$chiTietPhieuNhapVatPham->warehousingItemDetail_id)
                                ->delete();
    
                            }
                            if($soLuong>0)
                            DB::table('st_warehousing_item_detail')
                            ->insert([
                                'warehousingItem_id'=>$id,
                                'item_id'=>$item->item_id,
                                'warehousingItem_amount'=>$soLuong
                            ]);
                        }
                        return response(1);
                    }
                    catch(QueryException $ex)
                    {
                        return response(0);
                    }
                  
                }
                else
                {
                    return response($kiemTraTon);
                }

            }
            else
            {
                return response(2);
            }
        }
      
    }

    public function getXoaPhieuNhapVatPham(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaPhieuNhapVatPham();
            
            if($quyenChiTiet==1)
            {
                $id = $request->get('id');
                $chiTiet = DB::table('view_phieu_nhap_san_pham_chi_tiet')
                ->where('warehousingItem_id',$id)
                ->get();
                
                $soLuong=0;
                $kiemTraTon = 0;
                foreach($chiTiet as $item)
                {
                    $tonKho = DB::table('st_inventory_item')
                    ->where('item_id',$item->item_id)
                    ->where('branch_id',$item->branch_id)
                    ->get()
                    ->first();
                    $soLuongTon = 0;
                    if(isset($tonKho))
                    {
                        if($tonKho->inventoryItem_amount  < $item->warehousingItem_amount)
                        $kiemTraTon=1;

                        
                    }
                   
                    
                }
                if($kiemTraTon==0)
                {
                    try
                    {
                        foreach($chiTiet as $item)
                        {
                            $tonKho = DB::table('st_inventory_item')
                            ->where('item_id',$item->item_id)
                            ->where('branch_id',$item->branch_id)
                            ->get()
                            ->first();
                            $soLuongTon = 0;
                            $kiemTraSanPham = DB::table('view_phieu_nhap_san_pham_chi_tiet')
                            ->where('warehousingItem_id','!=',$id)
                            ->where('item_id',$item->item_id)
                            ->where('branch_id',$item->branch_id)
                            ->get()->first();
    
                            if(isset($kiemTraSanPham))
                            {
                                $trangThai=1;
                            }
                            else
                            {
                                $trangThai=0;
                            }
                            if(isset($tonKho))
                            {
                                DB::table('st_inventory_item')
                                ->where('item_id',$item->item_id)
                                ->where('branch_id',$item->branch_id)
                                ->update([
                                    'inventoryItem_amount'=>$tonKho->inventoryItem_amount - $item->warehousingItem_amount,
                                    'inventoryItem_status'=>$trangThai
                                    ]);
                            }
                        }

                        DB::table('st_warehousing_item_detail')
                        ->where('warehousingItem_id',$id)
                        ->delete();
                        DB::table('st_warehousing_item')
                        ->where('warehousingItem_id',$id)
                        ->delete();
                        return response( 1);
                    }
                    catch(QueryException $ex)
                    {
                        return response(0);
                    }
                    
                }
                else
                    return response(3);
            }
            else
            {
                return response(2);
            }
        }
    }

    public function getChiTietPhieuNhapVatPham(Request $request)
    {
        if($request->ajax())
        {
            $id= $request->get('id');
            $chiTiet = DB::table('view_phieu_nhap_san_pham_chi_tiet')
            ->where('warehousingItem_id',$id)
            ->get();
            $out="";
            $i=1;
            foreach($chiTiet as $item)
            {
                $out.="<tr>
                <td>".$i."</td>
                <td>".$item->item_name."</td>
                <td>".$item->warehousingItem_amount."</td>
                </tr>";
                $i++;
            }

            return response($out);
        }
    }

    public function searchPhieuNhapVatPham(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            $quyenTatCa = $quyen->getPhieuNhapVatPhamTatCaChiNhanh();


           
           
           
            if($quyenTatCa == 1)
            {
                if ($value == "")
                $khuyenMai =  DB::table('view_nhap_kho_vat_pham')
                ->orderByDesc('warehousingItem_time')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                else
                $khuyenMai = DB::table('view_nhap_kho_vat_pham')
                ->orderByDesc('warehousingItem_time')
                    ->where('branch_name', 'like', '%' . $value . '%')
                    ->orWhere('warehousingItem_name', 'like', '%' . $value . '%')
                    ->orWhere('employee_name', 'like', '%' . $value . '%')
                    ->orWhere('warehousingItem_receiver', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();

            }
            else
            {
                if ($value == "")
                $khuyenMai =  DB::table('view_nhap_kho_vat_pham')
                ->orderByDesc('warehousingItem_time')
                ->where('branch_id',session('coSo'))
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                else
                $khuyenMai = DB::table('view_nhap_kho_vat_pham')
                ->orderByDesc('warehousingItem_time')
                ->where('branch_id',session('coSo'))
                ->where(function($query) use($value)
                {
                    $query->Where('warehousingItem_name', 'like', '%' . $value . '%')
                    ->orWhere('employee_name', 'like', '%' . $value . '%')
                    ->orWhere('warehousingItem_receiver', 'like', '%' . $value . '%');
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
                <td>' . $item->warehousingItem_name . '</td>     
                <td>' . date('H:i d/m/Y', strtotime($item->warehousingItem_time)) . '</td>
                <td>' . $item->employee_name . '</td>
                <td>' . $item->warehousingItem_receiver . '</td>
                <td><a class="btn" onclick="getChiTiet('.$item->warehousingItem_id.');"  data-toggle="modal" data-target="#basicModal">Chi tiết</a></td>
                ';

                if (session('quyen243') == 1)
                    $out .= '<td>
                            <a class="btn" href=\'' . route('getCapNhatPhieuNhapVatPham') . '?id=' . $item->warehousingItem_id . '\'>
                                <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                        </td>';
                if (session('quyen244') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->warehousingItem_id . '\');">
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
