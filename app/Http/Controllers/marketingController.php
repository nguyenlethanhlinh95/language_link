<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class marketingController extends Controller
{
    public function getMarketing()
    {
        $quyen = new quyenController();
        $quyenXemMarketing = $quyen->getXemMarketing();
        
        if ($quyenXemMarketing == 1) {
            $lay=$quyen->layDuLieu();
            $tongMarketTing = DB::table('st_marketing')
            ->select('marketing_id')
            ->get();


            $marketing = DB::table('st_marketing')
                ->take($lay)
                ->skip(0)
                ->get();
                $soMarketing= count($tongMarketTing);
            $soTrang =(int)$soMarketing/$lay;
            if($soMarketing%$lay>0)
            $soTrang++;
            return view('Marketing.marketing')
                ->with('page',1)
                ->with('soTrang',$soTrang)
                ->with('marketing', $marketing);
        } else {
            return redirect()->back();
        }
    }
    public function postThemMarketing(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenThemMarketing = $quyen->getThemMarketing();
            if ($quyenThemMarketing == 1) {
                $ten = $request->get('ten');
                $trangThai = $request->get('trangThai');

                try {
                    DB::table('st_marketing')->insert([
                        'marketing_name' => $ten,
                        'marketing_status' => $trangThai
                    ]);
                    return response(1);
                } catch (QueryException $ex) {
                    return response(0);
                }
            } else
                return response(2);
        }
    }
    public function postCapNhatMarketing(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenSuaMarketing = $quyen->getSuaMarketing();
            if ($quyenSuaMarketing == 1) {
                $id = $request->get('id');
                $ten = $request->get('ten2');
                $trangThai = $request->get('trangThai2');

                try {
                    DB::table('st_marketing')
                    ->where('marketing_id',$id)
                    ->update([
                        'marketing_name' => $ten,
                        'marketing_status' => $trangThai
                    ]);
                    return response(1);
                } catch (QueryException $ex) {
                    return response(0);
                }
            } else
                return response(2);
        }
    }
    public function xoaMarketing(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenXoaMarketing = $quyen->getXoaMarketing();
            if ($quyenXoaMarketing == 1) {
                $id = $request->get('id');
                try {
                    DB::table('st_marketing')
                    ->where('marketing_id',$id)
                    ->delete();
                    return response(1);
                } catch (QueryException $ex) {
                    return response(0);
                }
            } else
                return response(2);
        }
    }

    public function searchMarketing(Request $request)
    {
        if ($request->ajax()) {

            $quyen = new quyenController();
            $lay=$quyen->layDuLieu();
            $value = $request->get('value');
            if($value=="")
            
            $marketing = DB::table('st_marketing')
            ->take($lay)
            ->skip(0)
                    ->get();
            else
            $marketing = DB::table('st_marketing')
                    ->where('marketing_name','like','%'.$value.'%')
                    ->take($lay)
                    ->skip(0)
                    ->get();

            $out="";
            $i=1;
            foreach($marketing as $item)
            {
                if($item->marketing_status==1)
                $trangThai="Hoạt động";
                else
                $trangThai="Ngừng hoạt động";
                $out.='<tr>
                <td>'.$i.'</td>
                <td>'.$item->marketing_name.'</td>
                <td>'.$trangThai.'</td>
                <td><a class="btn">
                        <i style="color: blue" data-toggle="modal" data-target="#basicModal2" 
                        onclick="setValue(\''.$item->marketing_id.'\',\''.$item->marketing_name.'\',
                        \''.$item->marketing_status.'\')" class="fa fa-edit"></i>
                                        </a></td>
                                    <td>
                                        <a class="btn" onclick="xoa(\''.$item->marketing_id .'\');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>
                </tr>';
                $i++;
            }
            return response($out);
        }
    }

    public function searchPageMarketing(Request $request)
    {
        if ($request->ajax()) {

            $quyen = new quyenController();
            $lay=$quyen->layDuLieu();
            $value = $request->get('value');
            $page=$request->get('page');
            if($value=="")
            $marketing = DB::table('st_marketing')
            ->take($lay)
            ->skip(($page-1)*$lay)
                    ->get();
            else
            $marketing = DB::table('st_marketing')
                    ->where('marketing_name','like','%'.$value.'%')
                    ->take($lay)
                    ->skip( ($page-1)*$lay)
                    ->get();

            $out="";
            $i=1;
            foreach($marketing as $item)
            {
                if($item->marketing_status==1)
                $trangThai="Hoạt động";
                else
                $trangThai="Ngừng hoạt động";
                $out.='<tr>
                <td>'.$i.'</td>
                <td>'.$item->marketing_name.'</td>
                <td>'.$trangThai.'</td>';
                if(session('quyen303')==1)
                $out.=' <td><a class="btn">
                        <i style="color: blue" data-toggle="modal" data-target="#basicModal2" 
                        onclick="setValue(\''.$item->marketing_id.'\',\''.$item->marketing_name.'\',
                        \''.$item->marketing_status.'\')" class="fa fa-edit"></i>
                                        </a></td>';

                 if(session('quyen303')==1)
                $out.='  <td>
                                   <a class="btn" onclick="xoa(\''.$item->marketing_id .'\');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>';
                                    $out.='  </tr>';
                $i++;
            }
            return response($out);
        }
    }
}
