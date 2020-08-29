<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class phongBanController extends Controller
{
    public function getPhongBan()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemPhongBan();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $phongBanTong = DB::table('st_department')
                ->select('department_id')
                ->get();
            $phongBan = DB::table('st_department')
            ->take($lay)
            ->get();

            $soKM = count($phongBanTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
                return view('PhongBan.phongBan')
                ->with('phongBan', $phongBan)
                ->with('soTrang', $soTrang)
                ->with('page', 1);
        }
        else
        {
            return redirect()->back();
        }
    }
    public function postThemPhongBan(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemPhongBan();
            if($quyenChiTiet==1)
            {
                try{
                    $ten = $request->get('ten');
                    DB::table('st_department')
                    ->insert([
                        'department_name'=>$ten
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
    public function postCapNhatPhongBan(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaPhongBan();
            if($quyenChiTiet==1)
            {
                try{
                    $ten = $request->get('ten2');
                    $id = $request->get('id');
                    DB::table('st_department')
                    ->where('department_id',$id)
                    ->update([
                        'department_name'=>$ten
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
    public function getXoaPhongBan(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaPhongBan();
            if($quyenChiTiet==1)
            {
                try{ 
                  
                    $id = $request->get('id');
                    DB::table('st_department')
                    ->where('department_id',$id)
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

    public function searchPhongBan(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            if ($value == "")
                $khuyenMai = DB::table('st_department')
                  
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            else
                $khuyenMai = DB::table('st_department')
                    
                    ->where('department_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();

            $out = "";
            $i = 1;
            foreach ($khuyenMai as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->department_name . '</td>     ';
              

                if (session('quyen383') == 1)
                    $out .= '<td>
                            <a class="btn"  data-toggle="modal" data-target="#basicModal2"  onclick="setValue(\''.$item->department_id.'\',\''.$item->department_name.'\');">
                                <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                        </td>';
                if (session('quyen384') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->department_id . '\');">
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
