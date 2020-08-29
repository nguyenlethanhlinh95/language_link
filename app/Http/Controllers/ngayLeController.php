<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ngayLeController extends Controller
{
    public function getNgayLe()
    {
        $quyen = new quyenController();
        $quyenXem = $quyen->getXemNgayLe();
        if ($quyenXem == 1) {
            $lay = $quyen->layDuLieu();
            $ngayLe = DB::table('st_holiday')
            ->take($lay)
            ->skip(0)
                ->get();

                $ngayLeTong = DB::table('st_holiday')
                    ->count();
              
                $soTrang =(int)$ngayLeTong/$lay;

                if($ngayLeTong%$lay>0)
                $soTrang++;
            return view('NgayLe.ngayLe')
            ->with('page',1)
            ->with('soTrang',$soTrang)
                ->with('ngayLe', $ngayLe);
        } else
            return redirect()->back();
    }

    public function postThemNgayLe(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenThem = $quyen->getThemNgayLe();
            if ($quyenThem == 1) {
                try
                {
                    $ten = $request->get('ten');
                    $thoiGianBatDau = $request->get('ngayBatDau');
                    $thoiGianKetThuc = $request->get('ngayKetThuc');


                    $now = Carbon::now('Asia/Ho_Chi_Minh');
                    $ngayBatDau = substr($thoiGianBatDau,6,4)."-". substr($thoiGianBatDau,0,2)."-".substr($thoiGianBatDau,3,2);
                    $ngayKetThuc = substr($thoiGianKetThuc,6,4)."-". substr($thoiGianKetThuc,0,2)."-".substr($thoiGianKetThuc,3,2);


                    DB::table('st_holiday')
                    ->insert([
                        'holiday_name'=>$ten,
                        'holiday_startDate'=>$ngayBatDau,
                        'holiday_endDate'=>$ngayKetThuc
                    ]);

                    return response(1);
                }
                catch(QueryException $ex)
                {
                    return response(0);
                }
            } else
              return response(2);
            }
    }
    public function postCapNhatNgayLe(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenSua = $quyen->getSuaNgayLe();
            if ($quyenSua == 1) {
                try
                {
                    $id = $request->get('id');
                    $ten = $request->get('ten2');
                    $thoiGianBatDau = $request->get('ngayBatDau2');
                    $thoiGianKetThuc = $request->get('ngayKetThuc2');


                    $now = Carbon::now('Asia/Ho_Chi_Minh');
                    $ngayBatDau = substr($thoiGianBatDau,6,4)."-". substr($thoiGianBatDau,0,2)."-".substr($thoiGianBatDau,3,2);
                    $ngayKetThuc = substr($thoiGianKetThuc,6,4)."-". substr($thoiGianKetThuc,0,2)."-".substr($thoiGianKetThuc,3,2);

                    DB::table('st_holiday')
                    ->where('holiday_id',$id)
                    ->update([
                        'holiday_name'=>$ten,
                        'holiday_startDate'=>$ngayBatDau,
                        'holiday_endDate'=>$ngayKetThuc
                    ]);

                    return response(1);
                }
                catch(QueryException $ex)
                {
                    return response(0);
                }
            } else
              return response(2);
            }
    }
    public function getXoaNgayLe(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXoa = $quyen->getXoaNgayLe();
            if ($quyenXoa == 1) {
                try
                {
                    $id = $request->get('id');
                 
                    DB::table('st_holiday')
                    ->where('holiday_id',$id)
                    ->delete();

                    return response(1);
                }
                catch(QueryException $ex)
                {
                    return response(0);
                }
            } else
              return response(2);
            }
    }

    public function searchPageNgayLe(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $lay=$quyen->layDuLieu();
            $value = $request->get('value');
            $page=$request->get('page');
            if($value=="")
            $marketing = DB::table('st_holiday')
            ->take($lay)
            ->skip(($page-1)*$lay)
            ->get();
            else
            $marketing = DB::table('st_holiday')
                    ->where('holiday_name','like','%'.$value.'%')
                    ->take($lay)
                    ->skip( ($page-1)*$lay)
                    ->get();

            $out="";
            $i=1;
            foreach($marketing as $item)
            {
               
                $out.='<tr>
                <td>'.$i.'</td>
                <td>'.$item->holiday_name.'</td>
                <td>'.date('d/m/Y',strtotime($item->holiday_startDate)).'</td>
                <td>'.date('d/m/Y',strtotime($item->holiday_endDate)).'</td>';
                if(session('quyen323')==1)
                $out.='<td><a class="btn" data-toggle="modal" data-target="#basicModal2"
                onclick="setValue(\''.$item->holiday_id.'\',\''.$item->holiday_name.'\',
              \''.date('m/d/Y',strtotime($item->holiday_startDate)).'\',\''.date('m/d/Y',strtotime($item->holiday_endDate)).'\')">
               <i style="color: blue"  class="fa fa-edit"></i>
           </a>        
       </td>';
       if(session('quyen324')==1)
               $out.='<td>
               <a class="btn" onclick="xoa(\''.$item->holiday_id.'\');">
                   <i style="color: red" class="fa fa-close"></i>
               </a>
           </td>';
                $i++;
            }
            return response($out);
        
        }
    }
}
