<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\loaiVatPhamExport;
use App\Imports\loaiVatPhamImport;
use App\Exports\vatPhamExport;
use App\Imports\vatPhamImport;
use Excel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class coSoVatChatController extends Controller
{
    public function getLoaiCoSoVatChat()
    {
        $quyen = new quyenController();
        $quyenXemKH = $quyen->getXemLoaiCSVC();
        if ($quyenXemKH == 1) {
            $loaiCSVC = DB::table('st_facility_type')
            ->get();

        
            return view('CoSoVatChat.loaiCoSoVatChat')
          
            ->with('loaiCSVC',$loaiCSVC);

        }
        else
        return redirect()->back();
    }
    public function postThemLoaiCoSoVatChat(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getThemLoaiCSVC();
            if ($quyenXemKH == 1) {
                try
                {
                    $ten = $request->get('ten');
                        DB::table('st_facility_type')
                        ->insert([
                            'facilityType_name'=>$ten 
                        ]);
                        return response(1);
                }catch(QueryException $ex)
                {
                    return response(0);
                }
    
            }
            else
            return response(2);
        }
    }
    public function postCapNhatLoaiCoSoVatChat(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getSuaLoaiCSVC();
            if ($quyenXemKH == 1) {
                try
                {
                    $ten = $request->get('ten2');
                    $id= $request->get('id');
                        DB::table('st_facility_type')
                        ->where('facilityType_id',$id)
                        ->update([
                            'facilityType_name'=>$ten 
                        ]);
                        return response(1);
                }catch(QueryException $ex)
                {
                    return response(0);
                }
    
            }
            else
            return response(2);
        }
    }
    public function getXoaLoaiCoSoVatChat(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getXoaLoaiCSVC();
            if ($quyenXemKH == 1) {
                try
                {
                    $id= $request->get('id');
                        DB::table('st_facility_type')
                        ->where('facilityType_id',$id)
                        ->delete();
                        return response(1);
                }catch(QueryException $ex)
                {
                    return response(0);
                }
    
            }
            else
            return response(2);
        }
    }


    public function getCoSoVatChat(Request $request)
    {
        $quyen = new quyenController();
        $quyenXemKH = $quyen->getXemCSVC();
        if ($quyenXemKH == 1) {
            $lay = $quyen->layDuLieu();
            $id=$request->get('id');

            $CSVC = DB::table('st_facility')
            ->take($lay)
            ->skip(0)
            ->where('facilityType_id',$id)
            ->get();
            $CSVCTong = DB::table('st_facility')
            ->where('facilityType_id',$id)
            ->get();

            $loaiCSVC = DB::table('st_facility_type')
            ->where('facilityType_id',$id)
            ->get()->first();
       

            $soKM = count($CSVCTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
            
            return view('CoSoVatChat.coSoVatChat')
            ->with('CSVC',$CSVC)
            ->with('page',1)
            ->with('soTrang',$soTrang)
            ->with('loaiCSVC',$loaiCSVC);

        }
        else
        return redirect()->back();
    }
    public function searchCSVC(Request $request)
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
                        $sanPhamChiNhan = DB::table('st_facility')
                        ->where('facilityType_id',$id)
                        ->take($lay)
                        ->skip(($page - 1) * $lay)
                        ->get();
            }
            else
            {

                    $sanPhamChiNhan = DB::table('st_facility')
                    ->where('facilityType_id',$id)
                    ->where('facility_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
               
            }

            $out = "";
            $i = 1;
             foreach ($sanPhamChiNhan as $item) {

                $out .= "<tr>
                <td>" . $i . "</td>
               
                <td>".$item->facility_name."</td>
                <td>".$item->facility_unit."</td>
                ";
              
                if(session('quyen163')==1)
                    $out.=" <td><a class='btn'   data-toggle='modal' data-target='#basicModal2'
                    onclick='setValue(\"".$item->facility_id."\",\"".$item->facility_name."\",\"".$item->facilityType_id."\"
                    ,\"".$item->facility_unit."\");' >
                    <i style='color: blue' class='fa fa-edit'></i>
                                </a>
                            </td>";
                                    
                if(session('quyen164')==1)
                    $out.=" <td>
                            <a class='btn' onclick='xoa('".$item->facility_id."');'>
                                            <i style='color: red' class='fa fa-close'></i>
                                        </a>
                                </td>";
                                    
                $out .= " </tr>";
                $i++;
             }
            return response($out);
        }
    }
    public function postThemCoSoVatChat(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getThemCSVC();
            if ($quyenXemKH == 1) {
                try
                {
                    $ten = $request->get('ten');
                    $gia = $request->get('gia');
                    $giaMua = $request->get('giaMua');
                    $donVi = $request->get('donVi');
                    $loai = $request->get('loai');
                    $id=    DB::table('st_facility')
                        ->insertGetId([
                            'facility_name'=>$ten ,
                            'facilityType_id'=>$loai,
                            // 'facility_purchasePrice'=>0,
                            // 'facility_price'=>$gia,
                            'facility_unit'=>$donVi
                        ]);

                       
                        return response(1);
                }catch(QueryException $ex)
                {
                    return response(0);
                }
    
            }
            else
            return response(2);
        }
    }
    public function postCapNhatCoSoVatChat(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getSuaCSVC();
            if ($quyenXemKH == 1) {
                try
                {
                    $ten = $request->get('ten2');
                    $gia = $request->get('gia2');
                    $donVi = $request->get('donVi2');
                    $loai = $request->get('loai2');
                    $giaMua = $request->get('giaMua2');
                    $id= $request->get('id');
                        DB::table('st_facility')
                        ->where('facility_id',$id)
                        ->update([
                            'facility_name'=>$ten ,
                            'facilityType_id'=>$loai,
                            // 'facility_purchasePrice'=>0,
                            // 'facility_price'=>$gia,
                            'facility_unit'=>$donVi
                        ]);
                        return response(1);
                }catch(QueryException $ex)
                {
                    return response(0);
                }
    
            }
            else
            return response(2);
        }
    }
    public function getXoaCoSoVatChat(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXoaCSVC= $quyen->getXoaCSVC();
            if ($quyenXoaCSVC == 1) {
                try
                {
                    $id= $request->get('id');
                        DB::table('st_facility')
                        ->where('facility_id',$id)
                        ->delete();
                        return response(1);
                }catch(QueryException $ex)
                {
                    return response(0);
                }
    
            }
            else
            return response(2);
        }
    }

    public function getTonKho(Request $request)
    {

        $quyen = new quyenController();
        $quyenXem= $quyen->getXemTonKho();
        if ($quyenXem == 1) {
        
            $id= $request->get('id');
            $lay = $quyen->layDuLieu();
            $chiNhanh = DB::table('st_branch')
            ->get();
            $quyenXemTatCa= $quyen->getXemTonKhoTatCaChiNhanh();
            if($quyenXemTatCa==1)
            {
                $tonKho = DB::table('view_ton_kho')
                ->where('facilityType_id',$id)
                ->where('inventory_status',1)
                ->orderBy('branch_id')
                ->orderBy('facilityType_id')
                ->take($lay)
                ->skip(0)
                ->get();
                $tonKhoTong = DB::table('view_ton_kho')
                ->where('facilityType_id',$id)
                ->where('inventory_status',1)
                ->orderBy('branch_id')
                ->orderBy('facilityType_id')
                ->select('facilityType_id')
                ->get();
            }
            else
            {
                $tonKho = DB::table('view_ton_kho')
                ->where('facilityType_id',$id)
                ->where('inventory_status',1)
                ->where('branch_id',session('coSo'))
                ->orderBy('branch_id')
                ->orderBy('facilityType_id')
                ->take($lay)
                ->skip(0)
                ->get();
                $tonKhoTong = DB::table('view_ton_kho')
                ->where('facilityType_id',$id)
                ->where('inventory_status',1)
                ->where('branch_id',session('coSo'))
                ->orderBy('branch_id')
                ->orderBy('facilityType_id')
                ->select('facilityType_id')
                ->get();
            }


            $soKM = count($tonKhoTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;

          $loaiCSVC = DB::table('st_facility_type')
          ->where('facilityType_id',$id)
          ->get()->first();
          return view('CoSoVatChat.tonkho')
          ->with('tonKho',$tonKho)
          ->with('loaiCSVC',$loaiCSVC)
          ->with('page',1)
          ->with('soTrang',$soTrang)
          ->with('chiNhanh',$chiNhanh)
          ;

        }
        else
        return redirect()->back();
        
    }
    public function searchSanPhamTonKhoChiNhanh(Request $request)
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
                    $tonKho = DB::table('view_ton_kho')
                    ->where('facilityType_id',$id)
                    ->where('inventory_status',1)
                    ->orderBy('branch_id')
                    ->orderBy('facilityType_id')
                        ->take($lay)
                        ->skip(($page - 1) * $lay)
                        ->get();
                }
                else
                {
                    $tonKho = DB::table('view_ton_kho')
                    ->where('facilityType_id',$id)
                    ->where('inventory_status',1)
                    ->orderBy('branch_id')
                    ->orderBy('facilityType_id')
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
                    $tonKho = DB::table('view_ton_kho')
                    ->where('facilityType_id',$id)
                    ->where('inventory_status',1)
                    ->where('facility_name', 'like', '%' . $value . '%')
                    ->orderBy('branch_id')
                    ->orderBy('facilityType_id')
                        ->take($lay)
                        ->skip(($page - 1) * $lay)
                        ->get();
                }
                else
                {
                    $tonKho = DB::table('view_ton_kho')
                    ->where('facilityType_id',$id)
                    ->where('inventory_status',1)
                    ->where('facility_name', 'like', '%' . $value . '%')
                    ->orderBy('branch_id')
                    ->orderBy('facilityType_id')
                    ->where('branch_id',$chiNhanh)
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                   
                }

              
            }

            $out = "";
            $i = 1;
             foreach ($tonKho as $item) {

                $out .= "<tr>
                <td>" . $i . "</td>
                <td>".$item->branch_name."</td>
              
                <td>".$item->facility_name."</td>
                <td>".$item->inventory_amount."</td>";
              
                // if(session('quyen173')==1)
                //     $out.=" <td><a class='btn'   data-toggle='modal' data-target='#basicModal2'
                //     onclick='setValue2(\"".$item->inventory_id."\",\"".$item->inventory_amount."\");' >
                //     <i style='color: blue' class='fa fa-edit'></i>
                //                 </a>
                //             </td>";
                                    
               
                                    
                $out .= " </tr>";
                $i++;
             }
            return response($out);
        }
    }

    public function postThemTonKho(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenThem= $quyen->getThemTonKho();
            if ($quyenThem == 1) {
                try
                {
                    $id=$request->get('id');
                    $soLuong=$request->get('soLuong');

                    $tonKho = DB::table('st_inventory')
                    ->where('inventory_id',$id)
                    ->get()->first();
                    if(isset($tonKho))
                    $soLuongTon = $tonKho->inventory_amount;
                    else
                    $soLuongTon=0;
                    DB::table('st_inventory')
                    ->where('inventory_id',$id)
                    ->update([
                        'inventory_amount'=>$soLuongTon+$soLuong
                    ]);
                    return response(1);
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

    public function postCapNhatTonKho(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenThem= $quyen->getSuaTonKho();
            if ($quyenThem == 1) {
                try
                {
                    $id=$request->get('id2');
                    $soLuong=$request->get('soLuong2');

                    DB::table('st_inventory')
                    ->where('inventory_id',$id)
                    ->update([
                        'inventory_amount'=>$soLuong
                    ]);
                    return response(1);
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

    

    public function getExportLoaiSanPham()
    {
        return Excel::download(new loaiVatPhamExport, 'loaiVatPham.xlsx');
    }
    public function postImportLoaiSanPham(Request $request) 
    {
        try
        {
            Excel::import(new loaiVatPhamImport,request()->file('file'));
            return response(1);
        }
        catch(ModelNotFoundException $exception)
        {
            return response(0);
        }
    }

    public function getExportSanPham(Request $request)
    {
        $id = $request->get('id');
        session(['idLoaiVatPham'=>$id]);
        return Excel::download(new vatPhamExport, 'vatPham.xlsx');
    }
    public function postImportSanPham(Request $request) 
    {
        try
        {
            $id = $request->get('id3');
            session(['idLoaiVatPham'=>$id]);
            Excel::import(new vatPhamImport,request()->file('file'));
            return response(1);
        }
        catch(ModelNotFoundException $exception)
        {
            return response(0);
        }
    }
}
