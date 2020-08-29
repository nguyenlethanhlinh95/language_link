<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class khungGioController extends Controller
{
    public function getKhungGio()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemKhungGio();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $khungGioTong = DB::table('view_department_time_slot')
                ->select('timeSlot_id')
                ->get();
            $khungGio = DB::table('view_department_time_slot')
            ->orderBy('department_id')
            ->orderBy('timeSlot_shift')
            ->orderBy('timeSlot_startTime')
            ->orderBy('timeSlot_endTime')
            ->take($lay)
            ->get();
            $phongBan = DB::table('st_department')
            ->get();
            $soKM = count($khungGioTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
                return view('KhungGio.khungGio')
                ->with('khungGio', $khungGio)
                ->with('soTrang', $soTrang)
                ->with('phongBan', $phongBan)
                ->with('page', 1);
        }
        else
        {
            return redirect()->back();
        }
    }
    public function postThemKhungGio(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemKhungGio();
            if($quyenChiTiet==1)
            {
                try{
                    $gioBatDau = $request->get('gioBatDau');
                    $gioKetThuc = $request->get('gioKetThuc');
                    $phongBan  = $request->get('phongBan');
                    $thu = $request->get('thu');
                    $ca = $request->get('ca');
                    $ten = $request->get('ten');
                    $thu2 = $request->get('thu2');
                    $thu3 = $request->get('thu3');
                    $thu4 = $request->get('thu4');
                    $thu5 = $request->get('thu5');
                    $thu6 = $request->get('thu6');
                    $thu7 = $request->get('thu7');
                    $thu8 = $request->get('thu8');
                    if($thu2==true)
                    {
                        $trangThai2 = 1;
                    }
                    else
                    {
                        $trangThai2=0;
                    }
                    if($thu3==true)
                    {
                        $trangThai3 = 1;
                    }
                    else
                    {
                        $trangThai3=0;
                    }
                    if($thu4==true)
                    {
                        $trangThai4 = 1;
                    }
                    else
                    {
                        $trangThai4=0;
                    }
                    if($thu5==true)
                    {
                        $trangThai5 = 1;
                    }
                    else
                    {
                        $trangThai5=0;
                    }
                    if($thu6==true)
                    {
                        $trangThai6 = 1;
                    }
                    else
                    {
                        $trangThai6=0;
                    }
                    if($thu7==true)
                    {
                        $trangThai7 = 1;
                    }
                    else
                    {
                        $trangThai7=0;
                    }
                    if($thu8==true)
                    {
                        $trangThai8 = 1;
                    }
                    else
                    {
                        $trangThai8=0;
                    }
                    DB::table('st_time_slot')
                    ->insert([
                        'timeSlot_startTime'=>$gioBatDau,
                        'timeSlot_endTime'=>$gioKetThuc,
                        'department_id'=>$phongBan,
                        'timeSlot_shift'=>$ca,
                        'timeSlot_name'=>$ten,
                        'timeSlot_day2'=>$trangThai2,
                        'timeSlot_day3'=>$trangThai3,
                        'timeSlot_day4'=>$trangThai4,
                        'timeSlot_day5'=>$trangThai5,
                        'timeSlot_day6'=>$trangThai6,
                        'timeSlot_day7'=>$trangThai7,
                        'timeSlot_day8'=>$trangThai8
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
    public function postCapNhatKhungGio(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaKhungGio();
            if($quyenChiTiet==1)
            {
                try{
                    $gioBatDau = $request->get('gioBatDau2');
                    $gioKetThuc = $request->get('gioKetThuc2');
                    $phongBan  = $request->get('phongBan2');
                    $ca = $request->get('ca2');
                    $id = $request->get('id');
                    $thu = $request->get('thu2');
                    $ten = $request->get('ten2');
                    $thu2 = $request->get('thu22');
                    $thu3 = $request->get('thu32');
                    $thu4 = $request->get('thu42');
                    $thu5 = $request->get('thu52');
                    $thu6 = $request->get('thu62');
                    $thu7 = $request->get('thu72');
                    $thu8 = $request->get('thu82');
                    if($thu2==true)
                    {
                        $trangThai2 = 1;
                    }
                    else
                    {
                        $trangThai2=0;
                    }
                    if($thu3==true)
                    {
                        $trangThai3 = 1;
                    }
                    else
                    {
                        $trangThai3=0;
                    }
                    if($thu4==true)
                    {
                        $trangThai4 = 1;
                    }
                    else
                    {
                        $trangThai4=0;
                    }
                    if($thu5==true)
                    {
                        $trangThai5 = 1;
                    }
                    else
                    {
                        $trangThai5=0;
                    }
                    if($thu6==true)
                    {
                        $trangThai6 = 1;
                    }
                    else
                    {
                        $trangThai6=0;
                    }
                    if($thu7==true)
                    {
                        $trangThai7 = 1;
                    }
                    else
                    {
                        $trangThai7=0;
                    }
                    if($thu8==true)
                    {
                        $trangThai8 = 1;
                    }
                    else
                    {
                        $trangThai8=0;
                    }
                    DB::table('st_time_slot')
                    ->where('timeSlot_id',$id)
                    ->update([
                        'timeSlot_startTime'=>$gioBatDau,
                        'timeSlot_endTime'=>$gioKetThuc,
                        'department_id'=>$phongBan,
                        'timeSlot_shift'=>$ca,
                        'timeSlot_name'=>$ten,
                        'timeSlot_day2'=>$trangThai2,
                        'timeSlot_day3'=>$trangThai3,
                        'timeSlot_day4'=>$trangThai4,
                        'timeSlot_day5'=>$trangThai5,
                        'timeSlot_day6'=>$trangThai6,
                        'timeSlot_day7'=>$trangThai7,
                        'timeSlot_day8'=>$trangThai8
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
    public function getXoaKhungGio(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaKhungGio();
            if($quyenChiTiet==1)
            {
                try{ 
                  
                    $id = $request->get('id');
                    DB::table('st_time_slot')
                    ->where('timeSlot_id',$id)
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

    public function searchKhungGio(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            if ($value == "")
                $khuyenMai = DB::table('view_department_time_slot')
                    ->orderBy('department_id')
                    ->orderBy('timeSlot_shift')
                    ->orderBy('timeSlot_startTime')
                    ->orderBy('timeSlot_endTime')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            else
                $khuyenMai = DB::table('view_department_time_slot')
                    ->where('department_name', 'like', '%' . $value . '%')
                    ->orderBy('department_id')
                    ->orderBy('timeSlot_shift')
                    ->orderBy('timeSlot_startTime')
                    ->orderBy('timeSlot_endTime')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();

            $out = "";
            $i = 1;
            foreach ($khuyenMai as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->department_name . '</td>    
                <td>' . $item->timeSlot_name . '</td>    
                <td>Ca ' . $item->timeSlot_shift . '</td>    
                <td>' . $item->timeSlot_startTime . ' - ' . $item->timeSlot_endTime . '</td>     ';
              

                if (session('quyen383') == 1)
                    $out .= '<td>
                            <a class="btn"  data-toggle="modal" data-target="#basicModal2"  
                            onclick="setValue(\''.$item->timeSlot_id.'\',\''.$item->department_id.'\',\''.$item->timeSlot_shift.'\'
                            ,\''.$item->timeSlot_startTime.'\',\''.$item->timeSlot_endTime.'\');">
                                <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                        </td>';
                if (session('quyen384') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->timeSlot_id . '\');">
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
