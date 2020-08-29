<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class vatPhamController extends Controller
{
    public function getVatPham()
    {   
        $quyen = new quyenController();
        $quyenChiTiet= $quyen->getXemVatPham();
        if($quyenChiTiet==1)
        {
           
            $lay = $quyen->layDuLieu();
            $vatPhamTong = DB::table('st_item')
                ->select('item_id')
                ->get();
            $vatPham = DB::table('st_item')
                ->take($lay)
                ->skip(0)
                ->get();
            $soKM = count($vatPhamTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
            return view('VatPham.vatPham')
            ->with('soTrang', $soTrang)
            ->with('page', 1)
            ->with('vatPham',$vatPham)
            ;
        }
        else
        return redirect()->back();
    }

    public function postThemVatPham(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getThemVatPham();
            if ($quyenXemKH == 1) {
                try
                {
                    $ten = $request->get('ten');
                    $donVi = $request->get('donVi');
                    $id=    DB::table('st_item')
                        ->insertGetId([
                            'item_name'=>$ten ,
                           
                            // 'facility_purchasePrice'=>0,
                            // 'facility_price'=>$gia,
                            'item_unit'=>$donVi,
                           
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
    public function postCapNhatVatPham(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getSuaVatPham();
            if ($quyenXemKH == 1) {
                try
                {
                    $id= $request->get('id');
                    $ten = $request->get('ten2');
                    $donVi = $request->get('donVi2');
                     DB::table('st_item')
                    ->where('item_id',$id)
                        ->update([
                            'item_name'=>$ten ,
                           
                            // 'facility_purchasePrice'=>0,
                            // 'facility_price'=>$gia,
                            'item_unit'=>$donVi,
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

    public function getXoaVatPham(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getXoaVatPham();
            if ($quyenXemKH == 1) {
                try
                {
                    $id= $request->get('id');
                 
                     DB::table('st_item')
                    ->where('item_id',$id)
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

    public function searchVatPham(Request $request)
    {
        if($request->ajax())
        {
            $value = $request->get('value');
            $page = $request->get('page');

            $quyen = new quyenController();
        
                $lay = $quyen->layDuLieu();
            if($value=="")
            {
                $vatPham = DB::table('st_item')
                ->take($lay)
                ->skip(0)
                ->get();
        
            }
            else
            {
                $vatPham = DB::table('st_item')
                ->where('item_name', 'like', '%' . $value . '%')
                ->take($lay)
                ->skip(0)
                ->get();
        
            }
            $out="";
            $i=1;
            foreach($vatPham as $item)
            {
                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->item_name . '</td>     
                <td>' . $item->item_unit . '</td>';
            
                if (session('quyen213') == 1)
                    $out .= '<td>
                            <a class="btn" data-toggle="modal" data-target="#basicModal2"
                            onclick="setValue(\''.$item->item_id.'\',\''.$item->item_name.'\'
                            
                            ,\''.$item->item_unit.'\')">
                                <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                        </td>';
                if (session('quyen214') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->item_id . '\');">
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
