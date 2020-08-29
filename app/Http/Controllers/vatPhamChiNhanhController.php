<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class vatPhamChiNhanhController extends Controller
{
    public function getVatPhamChiNhanh(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemVatPhamChiNhanh();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $id= $request->get('id');
            $loaiCSVC = DB::table('st_facility_type')
            ->where('facilityType_id',$id)
            ->get()->first();

            $vatPham = DB::table('st_facility')
            ->where('facilityType_id',$id)
            ->get();
            $chiNhanh = DB::table('st_branch')
            ->get();
            $quyenTatCa = $quyen->getXemTatCaVatPhamChiNhanh();
            if($quyenTatCa==1)
            {
                $sanPhamChiNhan = DB::table('view_ton_kho')
                ->where('facilityType_id',$id)
                ->take($lay)
                ->skip(0)
                ->get();
                $sanPhamChiNhanTong = DB::table('view_ton_kho')
                ->where('facilityType_id',$id)
              
                ->get();
            }
            else
            {
                $sanPhamChiNhan = DB::table('view_ton_kho')
                ->where('facilityType_id',$id)
                ->where('branch_id',session('coSo'))
                ->take($lay)
                ->skip(0)
                ->get();
                $sanPhamChiNhanTong = DB::table('view_ton_kho')
                ->where('facilityType_id',$id)
                ->where('branch_id',session('coSo'))
                ->get();
            }

            $soKM = count($sanPhamChiNhanTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;

            return view('CoSoVatChat.vatPhamChiNhanh')
            ->with('sanPhamChiNhan',$sanPhamChiNhan)
            ->with('chiNhanh',$chiNhanh)
            ->with('loaiCSVC',$loaiCSVC)
            ->with('vatPham',$vatPham)
            ->with('page',1)
            ->with('soTrang',$soTrang)
            ;
        }
        else
        {
            return redirect()->back();
        }
    }

    public function postThemVatPhamChiNhanh(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemVatPhamChiNhanh();
            if($quyenChiTiet==1)
            {
                $loai=$request->get('loaiThem');
                if($loai==0)
                {
                    $sanPham = $request->get('vatPham');
                    $giaMua = $request->get('giaMua');
                    $giaBan = $request->get('giaBan');
                    $tonKho = DB::table('st_inventory')
                    ->where('facility_id',$sanPham)
                    ->where('branch_id',session('coSo'))
                    ->get()->first();
                    if(isset($tonKho))
                    {
                        return response(4);
                    }
                    else
                    {
                        DB::table('st_inventory')
                        ->insert([
                            'facility_id'=>$sanPham,
                            'inventory_amount'=>0,
                            'branch_id'=>session('coSo'),
                            'facility_price'=>$giaBan,
                            'facility_purchasePrice'=>$giaMua,
                            'inventory_status'=>0
                        ]);
                        return response(1);
                    }

                   

                }
                else
                {
                    $quyenChiTiet = $quyen->getXemTatCaVatPhamChiNhanh();
                    if($quyenChiTiet==1)
                    {
                      
                        $sanPham = $request->get('vatPham');
                        $giaMua = $request->get('giaMua');
                        $giaBan = $request->get('giaBan');
                        $chiNhanh = DB::table('st_branch')
                        ->get();

                        foreach($chiNhanh as $item)
                        {
                            $key = "check".$item->branch_id;
                            if($request->get($key)==true)
                            {
                                $tonKho = DB::table('st_inventory')
                                ->where('facility_id',$sanPham)
                                ->where('branch_id',$item->branch_id)
                                ->get()->first();

                                if(isset($tonKho))
                                {
                                   
                                }
                                else
                                {
                                    DB::table('st_inventory')
                                    ->insert([
                                        'facility_id'=>$sanPham,
                                        'inventory_amount'=>0,
                                        'branch_id'=>$item->branch_id,
                                        'facility_price'=>$giaBan,
                                        'facility_purchasePrice'=>$giaMua,
                                        'inventory_status'=>0
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

    public function getCapnhatVatPhamChiNhanh(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaVatPhamChiNhanh();
            if($quyenChiTiet==1)
            {
            $id = $request->get('id');
            $giaMua= $request->get('giaMua2');
            $giaBan= $request->get('giaBan2');
            try
            {
                DB::table('st_inventory')
                ->where('inventory_id',$id)
                ->update([
                    'facility_price'=>$giaBan,
                    'facility_purchasePrice'=>$giaMua
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
    }

    public function getXoaVatPhamChiNhanh(Request $request)
    {
        if($request->ajax())
        {
             $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaVatPhamChiNhanh();
            if($quyenChiTiet==1)
            {
                 $id = $request->get('id');
                try
                {
                    DB::table('st_inventory')
                    ->where('inventory_id',$id)
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

    public function searchSanPhamChiNhanh(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $chiNhanh = $request->get('chiNhanh');
            $page = $request->get('page');
            $id = $request->get('id');
            if ($value == "")
            {
                if($chiNhanh ==0)
                {
                        $sanPhamChiNhan = DB::table('view_ton_kho')
                        ->where('facilityType_id',$id)
                        ->take($lay)
                        ->skip(($page - 1) * $lay)
                        ->get();
                }
                else
                {
                    $sanPhamChiNhan = DB::table('view_ton_kho')
                    ->where('facilityType_id',$id)
                    ->where('branch_id',$chiNhanh)
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                   
                }
            }
               
            else
            {

                if($chiNhanh ==0)
                {
                    $sanPhamChiNhan = DB::table('view_ton_kho')
                    ->where('facilityType_id',$id)
                    ->where('facility_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
               
                }
                else
                {
                    $sanPhamChiNhan = DB::table('view_ton_kho')
                    ->where('facilityType_id',$id)
                    ->where('branch_id',$chiNhanh)
                    ->where('facility_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                }
            }

            $out = "";
            $i = 1;
             foreach ($sanPhamChiNhan as $item) {

                $out .= "<tr>
                <td>" . $i . "</td>
                <td>".$item->branch_name."</td>
              
                <td>".$item->facility_name."</td>
                <td>".number_format($item->facility_purchasePrice,0,"",".") ."đ</td>
                <td>".number_format($item->facility_price,0,"",".") ."</td>";
              
                if(session('quyen203')==1)
                    $out.=" <td><a class='btn'   data-toggle='modal' data-target='#basicModal2'
                    onclick='setValue(\"".$item->inventory_id."\",\"".$item->facility_name."\",\"".$item->facility_price."\"
                    ,\"".$item->facility_purchasePrice."\");' >
                    <i style='color: blue' class='fa fa-edit'></i>
                                </a>
                            </td>";
                                    
                if(session('quyen204')==1)
                    $out.=" <td>
                            <a class='btn' onclick='xoa('".$item->inventory_id."');'>
                                            <i style='color: red' class='fa fa-close'></i>
                                        </a>
                                </td>";
                                    
                $out .= " </tr>";
                $i++;
             }
            return response($out);
        }
    
    }
}
