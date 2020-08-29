<?php

namespace App\Http\Controllers;

use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class chucVuController extends Controller
{
    public function getChucVu()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemChucVu();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $chucVuTong = DB::table('st_position')
                ->select('position_id')
                ->get();
            $chucVu = DB::table('st_position')
            ->take($lay)
            ->get();

            $soKM = count($chucVuTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
                return view('ChucVu.chucVu')
                ->with('chucVu', $chucVu)
                ->with('soTrang', $soTrang)
                ->with('page', 1);
        }
        else
        {
            return redirect()->back();
        }
    }
    public function postThemChucVu(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemChucVu();
            if($quyenChiTiet==1)
            {
                try{
                    $ten = $request->get('ten');
                    DB::table('st_position')
                    ->insert([
                        'position_name'=>$ten
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
    public function postCapNhatChucVu(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaChucVu();
            if($quyenChiTiet==1)
            {
                try{
                    $ten = $request->get('ten2');
                    $id = $request->get('id');
                    DB::table('st_position')
                    ->where('position_id',$id)
                    ->update([
                        'position_name'=>$ten
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
    public function getXoaChucVu(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaChucVu();
            if($quyenChiTiet==1)
            {
                try{ 
                  
                    $id = $request->get('id');
                    DB::table('st_position')
                    ->where('position_id',$id)
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

    public function searchChucVu(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            if ($value == "")
                $khuyenMai = DB::table('st_position')
                  
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            else
                $khuyenMai = DB::table('st_position')
                    
                    ->where('position_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();

            $out = "";
            $i = 1;
            foreach ($khuyenMai as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->position_name . '</td>     ';
              

                if (session('quyen353') == 1)
                    $out .= '<td>
                            <a class="btn"  data-toggle="modal" data-target="#basicModal2"  onclick="setValue(\''.$item->position_id.'\',\''.$item->position_name.'\');">
                                <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                        </td>';
                if (session('quyen354') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->position_id . '\');">
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
