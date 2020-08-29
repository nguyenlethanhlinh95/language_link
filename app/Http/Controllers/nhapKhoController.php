<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class nhapKhoController extends Controller
{
    public function getPhieuNhap()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemPhieuNhap();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
           
            $quyenTatCa = $quyen->getXemTatCaPhieuNhap();
            if($quyenTatCa==1)
            {
                    $phieuNhap = DB::table('view_nhap_kho')
                    ->orderByDesc('warehousing_time')
                    ->take($lay)
                    ->skip(0)
                    ->get();

                    $phieuNhapTong = DB::table('view_nhap_kho')
                    ->orderByDesc('warehousing_time')
                    ->count();
            }
            else
            {
                $phieuNhap = DB::table('view_nhap_kho')
                ->where('branch_id',session('coSo'))
                ->orderByDesc('warehousing_time')
                ->take($lay)
                    ->skip(0)
                ->get();
                $phieuNhapTong = DB::table('view_nhap_kho')
                ->where('branch_id',session('coSo'))
                
                ->orderByDesc('warehousing_time')
                ->count();
            }

            $soKM = $phieuNhapTong;
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
            return view('PhieuNhap.phieuNhap')
            ->with('soTrang', $soTrang)
            ->with('page', 1)
            ->with('phieuNhap',$phieuNhap);
        }
        else
        return redirect()->back();
    }
    public function searchPhieuNhapKho(Request $request)
    {
     if ($request->ajax()) {
         $quyen = new quyenController();
         $lay = $quyen->layDuLieu();
         $value = $request->get('value');
         $page = $request->get('page');
         $quyenTatCa =$quyen->getXemTatCaPhieuNhap();
 
       
       
         if($quyenTatCa==1)
         {
             if ($value == "")
             $phieuXuat = DB::table('view_nhap_kho')
             ->orderByDesc('warehousing_time')
                 ->take($lay)
                 ->skip(($page - 1) * $lay)
                 ->get();
             else
             $phieuXuat =  DB::table('view_nhap_kho')
             ->orderByDesc('warehousing_time')
             ->where(function($query) use ($value)
             {
                 $query ->where('employee_name', 'like', '%' . $value . '%')
                 ->orwhere('warehousing_receiver', 'like', '%' . $value . '%');
             })
             ->take($lay)
             ->skip(($page - 1) * $lay)
             ->get();
         }
         else
         {
             if ($value == "")
             $phieuXuat =  DB::table('view_nhap_kho')
             ->orderByDesc('warehousing_time')
                 ->where('branch_id',session('coSo'))
                
                 ->take($lay)
                 ->skip(($page - 1) * $lay)
                 ->get();
             else
             $phieuXuat = DB::table('view_nhap_kho')
             ->orderByDesc('warehousing_time')
             ->where('branch_id',session('coSo'))
             ->where(function($query) use ($value)
             {
                 $query ->where('employee_name', 'like', '%' . $value . '%')
                 ->orwhere('warehousing_receiver', 'like', '%' . $value . '%');
             })  ->orderBy('deliveryBill_time')
             ->take($lay)
             ->skip(($page - 1) * $lay)
             ->get();
         }
       
        
 
         $out = "";
         $i = 1;
         foreach ($phieuXuat as $item) {
 
             $out .= '<tr>
             <td>'.$i.'</td>
             <td>'.$item->branch_code.'</td>
             <td>'.$item->warehousing_name.'</td>
             <td>'.date('H:i d/m/Y',strtotime( $item->warehousing_time)) .'</td>
             <td>'.$item->employee_name.'</td>
             <td>'.$item->warehousing_receiver.'</td>
             <td>'.number_format( $item->warehousing_total,0,"",".").'đ</td>
             <td><a class="btn" onclick="getChiTiet('.$item->warehousing_id.');"  data-toggle="modal" data-target="#basicModal">Chi tiết</a></td>
            ';
             if(session('quyen193')==1)
             $out .= '   <td><a class="btn" href="'.route('getCapNhatPhieuNhap').'?id='.$item->warehousing_id.'" >
                             <i style="color: blue" class="fa fa-edit"></i>
                         </a>
                     </td>';
            if(session('quyen194')==1)
            $out .= ' <td>
                 <a class="btn" onclick="xoa('.$item->warehousing_id.');">
                     <i style="color: red" class="fa fa-close"></i>
                 </a>
             </td>
            
         ';
            
             $out .= ' </tr>';
             $i++;
         }
         return response($out);
     }
    }
    public function getThemPhieuNhap()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThemPhieuNhap();
        if($quyenChiTiet==1)
        {
          

            $quyenTatCa = $quyen->getXemTatCaPhieuNhap();
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
                
                $sanPham = DB::table('view_ton_kho')
                ->where('branch_id',$idChiNhanh)->get();
               
            }
            else
            {
                $chiNhanh = DB::table('st_branch')
                ->where('branch_id',session('coSo'))
                ->get();
                $sanPham = DB::table('view_ton_kho')
                ->where('branch_id',session('coSo'))->get();
                $idChiNhanh = session('coSo');
            }

            $nhanVien = DB::table('st_employee')
            ->where('branch_id',$idChiNhanh)
            ->where('employee_status',1)
            ->get();
            $phongBan = DB::table('st_department')
            ->get();

            return view('PhieuNhap.themPhieuNhap')
            ->with('chiNhanh',$chiNhanh)
            ->with('sanPham',$sanPham)
            ->with('nhanVien',$nhanVien)
            ->with('phongBan',$phongBan)
            ;
        }
        else
        return redirect()->back();
    }
    public function getCapNhatPhieuNhap(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getSuaPhieuNhap();
        if($quyenChiTiet==1)
        {
            $id = $request->get('id');
            $phieuNhap = DB::table('view_nhap_kho')
            ->where('warehousing_id',$id)
            ->get()->first();
            $chiTietPhieuNhap = DB::table('st_warehousing_detail')
            ->join('st_facility','st_facility.facility_id','=','st_warehousing_detail.facility_id')
            ->where('warehousing_id',$id)
            ->get();

            $sanPham = DB::table('view_ton_kho')
            ->where('branch_id',$phieuNhap->branch_id)
            ->get();
            $nhanVien = DB::table('st_employee')
            ->where('branch_id',$phieuNhap->branch_id)
            ->where('employee_status',1)
            ->get();
            $phongBan = DB::table('st_department')
            ->get();
            return view('PhieuNhap.capNhatPhieuNhap')
            ->with('phieuNhap',$phieuNhap)
            ->with('chiTietPhieuNhap',$chiTietPhieuNhap)
            ->with('nhanVien',$nhanVien)
            ->with('phongBan',$phongBan)
            ->with('sanPham',$sanPham);
        }
        else
        return redirect()->back();
    }
    public function postThemPhieuNhapKho(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThemPhieuNhap();
        if($quyenChiTiet==1)
        {
           
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
                        $id= DB::table('st_warehousing')
                        ->insertGetId([
                            'warehousing_name'=>$noiDung,
                            'warehousing_time'=>$now,
                            'employee_id'=>session('user'),
                            'warehousing_note'=>$ghiChu,
                            'warehousing_status'=>$trangThai,
                            'branch_id'=>$coSo,
                            'warehousing_total'=>0,
                            'warehousing_receiver'=>$nguoiNhan,
                            'warehousing_partName'=>$boPhan
                        ]);
                        $sanPham = DB::table('view_ton_kho')
                        ->where('branch_id',$coSo)->get();
                        $tongTien = 0;
                        foreach($sanPham as $item)
                        {
                            $key = "soLuong".$item->facility_id;
                            $soLuong = $request->get($key);
                            if($soLuong>0)
                            {
                                DB::table('st_warehousing_detail')
                                ->insert([
                                    'warehousing_id'=>$id,
                                    'facility_id'=>$item->facility_id,
                                    'warehousing_amount'=>$soLuong,
                                    'warehousing_price'=>$item->facility_purchasePrice
                                ]);
                                $tongTien+=$item->facility_purchasePrice*$soLuong;
                                $tonKho = DB::table('st_inventory')
                                ->where('facility_id',$item->facility_id)
                                ->where('branch_id',$coSo)
                                ->get()->first();
                                    $soLuongTon = 0;
                                if(isset($tonKho))
                                $soLuongTon=$tonKho->inventory_amount;
                                DB::table('st_inventory')
                                ->where('facility_id',$item->facility_id)
                                ->where('branch_id',$coSo)->update([
                                    'inventory_status'=>1,
                                    'inventory_amount'=>$soLuongTon+$soLuong
                                ]);
                            }
                        }
                        DB::table('st_warehousing')
                        ->where('warehousing_id',$id)
                        ->update([
                            'warehousing_total'=>$tongTien
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
            return response(2);
        }
        
    }
    public function getChangChiNhanhPhieuNhap(Request $request)
    {
        if($request->ajax())
        {
            $id= $request->get('id');
            $sanPham = DB::table('view_ton_kho')
            ->where('branch_id', $id)->get();

            $out ='';
            foreach($sanPham as $item)
            $out .='<option value="'.$item->facility_id.'">'.$item->facility_name.'</option>';
           
            $out1 ='';
            foreach($sanPham as $item)
            {
                $out1.=' <input hidden id="tenSanPham'.$item->facility_id.'" value="'.$item->facility_name.'">
                <input hidden id="giaSanPham'.$item->facility_id.'" value="'.$item->facility_purchasePrice.'">';
            }
           $arr[]=[
               'duLieu'=>$out,
               'soLuong'=>$out1
           ];
            return response($arr);
            
        }
    }

    public function postCapNhatSanPham(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaPhieuNhap();
            if($quyenChiTiet==1)
            {
                $id = $request->get('id');
                $phieuNhap = DB::table('view_nhap_kho')
                ->where('warehousing_id',$id)
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
                $sanPham = DB::table('view_ton_kho')
                ->where('branch_id',$phieuNhap->branch_id)
                ->get();
                $kiemTraTon="";
                $tongTien = 0;
                foreach($sanPham as $item)
                {
                    $key = "soLuong".$item->facility_id;
                    $soLuong = $request->get($key);
                    $tonkho = DB::table('st_inventory')
                    ->where('facility_id',$item->facility_id)
                    ->where('branch_id',$phieuNhap->branch_id)
                    ->get()->first();
                    $tongTien += $soLuong * $item->facility_purchasePrice;
                    $soLuongTon=0;
                    if(isset($tonkho))
                    $soLuongTon=$tonkho->inventory_amount;

                    $chiTietPhieuNhap=DB::table('st_warehousing_detail')
                    ->where('warehousing_id',$phieuNhap->warehousing_id)
                    ->where('facility_id',$item->facility_id)
                    ->get()->first();
                    $soLuongNhap = 0;
                    if(isset($chiTietPhieuNhap))
                    $soLuongNhap = $chiTietPhieuNhap->warehousing_amount;

                    if($soLuongTon - $soLuongNhap + $soLuong < 0 )
                        $kiemTraTon.="Số lượng vật phẩm ". $item->facility_name." không đủ. ";
                }
           
                if($kiemTraTon=="")
                {
                    try{
                        DB::table('st_warehousing')
                        ->where('warehousing_id',$id)
                        ->update([
                            'warehousing_name'=>$noiDung,
                            'employee_id'=>session('user'),
                            'warehousing_note'=>$ghiChu,
                            'warehousing_receiver'=>$nguoiNhan,
                            'warehousing_partName'=>$boPhan,
                            'warehousing_status'=>$trangThai,
                            'warehousing_total'=>$tongTien
                        ]);
    
                        foreach($sanPham as $item)
                        {
                            $key = "soLuong".$item->facility_id;
                            $soLuong = $request->get($key);
                            $tonkho = DB::table('st_inventory')
                            ->where('facility_id',$item->facility_id)
                            ->where('branch_id',$phieuNhap->branch_id)
                            ->get()->first();
                            $soLuongTon=0;
                            if(isset($tonkho))
                            $soLuongTon=$tonkho->inventory_amount;
        
                            $chiTietPhieuNhap=DB::table('st_warehousing_detail')
                            ->where('warehousing_id',$phieuNhap->warehousing_id)
                            ->where('facility_id',$item->facility_id)
                            ->get()->first();
                            
                            $kiemTraSanPham=DB::table('st_warehousing_detail')
                            ->join('st_warehousing','st_warehousing.warehousing_id',
                            '=','st_warehousing_detail.warehousing_id')
                            ->where('st_warehousing.warehousing_id','!=',$phieuNhap->warehousing_id)
                            ->where('st_warehousing_detail.facility_id',$item->facility_id)
                            ->where('st_warehousing.branch_id',$phieuNhap->branch_id)
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
                            if(isset($chiTietPhieuNhap))
                            {
                               $soLuongNhap = $chiTietPhieuNhap->warehousing_amount;
                               DB::table('st_inventory')
                                ->where('facility_id',$item->facility_id)
                                ->where('branch_id',$phieuNhap->branch_id)
                                ->update([
                                    'inventory_amount'=>$soLuongTon-$soLuongNhap + $soLuong,
                                    'inventory_status'=>$trangThai
                                ]);
                                DB::table('st_warehousing_detail')
                                ->where('warehousingDetail_id',$chiTietPhieuNhap->warehousingDetail_id)
                                ->delete();
    
                            }
                          
                           
                            if($soLuong>0)
                            DB::table('st_warehousing_detail')
                            ->insert([
                                'warehousing_id'=>$id,
                                'facility_id'=>$item->facility_id,
                                'warehousing_amount'=>$soLuong,
                                'warehousing_price'=>$item->facility_purchasePrice
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

    public function getXoaPhieuNhap(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaPhieuNhap();
            
            if($quyenChiTiet==1)
            {
                $id = $request->get('id');
                $chiTiet = DB::table('view_phieu_nhap_chi_tiet')
                ->where('warehousing_id',$id)
                ->get();
                
                $soLuong=0;
                $kiemTraTon = 0;
                foreach($chiTiet as $item)
                {
                    $tonKho = DB::table('st_inventory')
                    ->where('facility_id',$item->facility_id)
                    ->where('branch_id',$item->branch_id)
                    ->get()
                    ->first();
                    $soLuongTon = 0;
                    if(isset($tonKho))
                    {
                        if($tonKho->inventory_amount<$item->warehousing_amount)
                        $kiemTraTon=1;

                        
                    }
                   
                    
                }
                if($kiemTraTon==0)
                {
                    try
                    {
                        foreach($chiTiet as $item)
                        {
                            $tonKho = DB::table('st_inventory')
                            ->where('facility_id',$item->facility_id)
                            ->where('branch_id',$item->branch_id)
                            ->get()
                            ->first();
                            $soLuongTon = 0;
                            $kiemTraSanPham = DB::table('view_phieu_nhap_chi_tiet')
                            ->where('warehousing_id','!=',$id)
                            ->where('facility_id',$item->facility_id)
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
                                DB::table('st_inventory')
                                ->where('facility_id',$item->facility_id)
                                ->where('branch_id',$item->branch_id)
                                ->update([
                                    'inventory_amount'=>$tonKho->inventory_amount - $item->warehousing_amount,
                                    'inventory_status'=>$trangThai
                                    ]);
                            }
                        }

                        DB::table('st_warehousing_detail')
                        ->where('warehousing_id',$id)
                        ->delete();
                        DB::table('st_warehousing')
                        ->where('warehousing_id',$id)
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

    public function getChiTietPhieuNhap(Request $request)
    {
        if($request->ajax())
        {
            $id= $request->get('id');
            $chiTiet = DB::table('view_phieu_nhap_chi_tiet')
            ->where('warehousing_id',$id)
            ->get();
            $out="";
            $i=1;
            foreach($chiTiet as $item)
            {
                $out.="<tr>
                <td>".$i."</td>
                <td>".$item->facility_name."</td>
                <td>".$item->warehousing_amount."</td>
                <td>".number_format( $item->warehousing_price,0,"",".")."đ</td>
                <td>".number_format($item->warehousing_amount* $item->warehousing_price,0,"",".")."đ</td>
                </tr>";
                $i++;
            }

            return response($out);
        }
    }
}
