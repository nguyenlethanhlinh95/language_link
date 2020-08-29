<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class tonKhoVatPhamController extends Controller
{
    public function getTonKhoVatPham()
    {
        $quyen = new quyenController();
        $quyenXem= $quyen->getXemTonKhoVatPham();
        if ($quyenXem == 1) {
            $quyenXemTatCa= $quyen->getXemTonKhoTatCaChiNhanhVatPham();
            $lay = $quyen->layDuLieu();
            if($quyenXemTatCa==1)
            {
                $tonKho = DB::table('view_vat_pham_chi_nhanh')
                ->where('inventoryItem_status',1)
                ->orderBy('branch_id')
                ->take($lay)
                ->skip(0)
                ->get();

                $tonKhoTong =  DB::table('view_vat_pham_chi_nhanh')
                ->where('inventoryItem_status',1)
                ->select('inventoryItem_id')
                ->get();
         
            }
            else
            {
                $tonKho = DB::table('view_vat_pham_chi_nhanh')
                ->where('inventoryItem_status',1)
                ->where('branch_id',session('coSo'))
                ->orderBy('branch_id')
                ->take($lay)
                ->skip(0)
                ->get();
                
                $tonKhoTong =  DB::table('view_vat_pham_chi_nhanh')
                ->where('inventoryItem_status',1)
                ->where('branch_id',session('coSo'))
                ->select('inventoryItem_id')
                ->get();
            }
            $soKM = count($tonKhoTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
        
          return view('VatPham.tonkho')
          ->with('tonKho',$tonKho)
          ->with('soTrang', $soTrang)
          ->with('page', 1)
          ;
        }
        else
        return redirect()->back();
    }
    public function searchTonkhoVatPham(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');

            $quyenXemTatCa= $quyen->getXemTatCaChiNhanhVatPham();   
            if($quyenXemTatCa==1)
            {
                if ($value == "")
                $vatPham = DB::table('view_vat_pham_chi_nhanh')
                    ->where('inventoryItem_status',1)
                    ->orderBy('branch_id')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                else
                    $vatPham = DB::table('view_vat_pham_chi_nhanh')
                    ->where('inventoryItem_status',1)
                    ->where(function($query) use ($value)
                    {
                        $query->where('branch_name', 'like', '%' . $value . '%')
                        ->orwhere('item_name', 'like', '%' . $value . '%');
                    })
                    ->orderBy('branch_id')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();

            }
            else
            {
             
                    
                if ($value == "")
                $vatPham = DB::table('view_vat_pham_chi_nhanh')
                    ->where('inventoryItem_status',1)
                    ->where('branch_id',session('coSo'))
                    ->orderBy('branch_id')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                else
                    $vatPham = DB::table('view_vat_pham_chi_nhanh')
                    ->where('inventoryItem_status',1)
                    ->where('branch_id',session('coSo'))
                    ->where('item_name', 'like', '%' . $value . '%')
                    ->orderBy('branch_id')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            }
           
            $out = "";
            $i = 1;
            foreach ($vatPham as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->branch_name . '</td>     
                <td>' . $item->item_name . '</td>
                <td>' . $item->inventoryItem_amount . '</td>
                </tr>';
                $i++;
            }
            return response($out);
        }
    }
}
