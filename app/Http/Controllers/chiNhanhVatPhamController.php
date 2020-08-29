<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class chiNhanhVatPhamController extends Controller
{
    public function getChiNhanhVatPham()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemChiNhanhVatPham();
        if($quyenChiTiet==1)
        {
           
            $vatPham = DB::table('st_item')
            ->get();
            $chiNhanh = DB::table('st_branch')
            ->get();
            $lay = $quyen->layDuLieu();
           

            $quyenTatCa = $quyen->getXemTatCaChiNhanhVatPham();
            if($quyenTatCa==1)
            {
                $vatPhamChiNhanh = DB::table('view_vat_pham_chi_nhanh')
                ->take($lay)
                ->skip(0)
                ->get();
                $vatPhamChiNhanhTong = DB::table('view_vat_pham_chi_nhanh')
            
                ->select('item_id')
                ->get();
            }
            else
            {
                $vatPhamChiNhanh = DB::table('view_vat_pham_chi_nhanh')
              
                ->where('branch_id',session('coSo'))
                ->take($lay)
                ->skip(0)
                ->get();

                $vatPhamChiNhanhTong = DB::table('view_vat_pham_chi_nhanh')
             
                ->where('branch_id',session('coSo'))
                ->select('item_id')
                ->get();
              
            }

            $soKM = count($vatPhamChiNhanhTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;


            return view('VatPham.vatPhamChiNhanh')
            ->with('soTrang',$soTrang)
            ->with('page',1)
            ->with('chiNhanh',$chiNhanh)
            ->with('vatPhamChiNhanh',$vatPhamChiNhanh)
            ->with('vatPham',$vatPham)
            ;
        }
        else
        {
            return redirect()->back();
        }
    }

    public function postThemChiNhanhVatPham(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemChiNhanhVatPham();
            if($quyenChiTiet==1)
            {
                $loai=$request->get('loaiThem');
                if($loai==0)
                {
                    $sanPham = $request->get('vatPham');
                    $tonKho = DB::table('st_inventory_item')
                    ->where('item_id',$sanPham)
                    ->where('branch_id',session('coSo'))
                    ->get()->first();
                    if(isset($tonKho))
                    {
                        return response(4);
                    }
                    else
                    {
                        DB::table('st_inventory_item')
                        ->insert([
                            'item_id'=>$sanPham,
                            'inventoryItem_amount'=>0,
                            'branch_id'=>session('coSo'),
                            'inventoryItem_status'=>0
                        ]);
                        return response(1);
                    }
                }
                else
                {
                    $quyenChiTiet = $quyen->getXemTatCaChiNhanhVatPham();
                    if($quyenChiTiet==1)
                    {
                      
                        $sanPham = $request->get('vatPham');
                        $chiNhanh = DB::table('st_branch')
                        ->get();

                        foreach($chiNhanh as $item)
                        {
                            $key = "check".$item->branch_id;
                            if($request->get($key)==true)
                            {
                                $tonKho = DB::table('st_inventory_item')
                                ->where('item_id',$sanPham)
                                ->where('branch_id',$item->branch_id)
                                ->get()->first();

                                if(isset($tonKho))
                                {
                                   
                                }
                                else
                                {
                                    DB::table('st_inventory_item')
                                    ->insert([
                                        'item_id'=>$sanPham,
                                        'inventoryItem_amount'=>0,
                                        'branch_id'=>$item->branch_id,
                                    
                                        'inventoryItem_status'=>0
                                    ]);
                                   
                                }
                               
                            }
                        }
                        return response(1);
                    }
                    else
                    {
                       return response(3);
                    }

                }
            }
            else
            {
                return response(2);
            }
        }
    }

    public function getCapnhatChiNhanhVatPham(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaChiNhanhVatPham();
            if($quyenChiTiet==1)
            {
            $id = $request->get('id');
            try
            {
               

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
    }

    public function getXoaChiNhanhVatPham(Request $request)
    {
        if($request->ajax())
        {
             $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaChiNhanhVatPham();
            if($quyenChiTiet==1)
            {
                 $id = $request->get('id');
                try
                {
                    DB::table('st_inventory_item')
                    ->where('inventoryItem_id',$id)
                    ->delete();

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
    
    }

    public function searchVatPhamChiNhanh(Request $request)
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
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->orderBy('branch_id')
                    ->get();
                else
                $vatPham = DB::table('view_vat_pham_chi_nhanh')
                    ->where('branch_name', 'like', '%' . $value . '%')
                    ->orwhere('item_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->orderBy('branch_id')
                    ->get();

            }
            else
            {
                if ($value == "")
                $vatPham = DB::table('view_vat_pham_chi_nhanh')
                    ->where('branch_name',session('coSo'))
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->orderBy('branch_id')
                    ->get();
                else
                $vatPham = DB::table('view_vat_pham_chi_nhanh')
                    ->where('branch_name',session('coSo'))
                    ->where('item_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->orderBy('branch_id')
                    ->get();
            }
           
            $out = "";
            $i = 1;
            foreach ($vatPham as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->branch_name . '</td>     
                <td>' . $item->item_name . '</td>';
               

                // if (session('quyen313') == 1)
                //     $out .= '<td>
                //             <a class="btn" href=\'' . route('getCapNhatChuongTrinhKM') . '?id=' . $item->promotions_id . '\'>
                //                 <i style="color: blue" class="fa fa-edit"></i>
                //                         </a>
                //         </td>';
                if (session('quyen224') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->inventoryItem_id . '\');">
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
