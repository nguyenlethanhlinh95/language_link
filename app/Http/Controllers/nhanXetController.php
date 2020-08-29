<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class nhanXetController extends Controller
{
    public function getNhanXet()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemNhanXet();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $chucVuTong = DB::table('st_comment')
                ->select('comment_id')
                ->count();
            $nhanXet = DB::table('st_comment')
            ->take($lay)
            ->get();

            $soKM = $chucVuTong;
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
                return view('NhanXet.nhanXet')
                ->with('nhanXet', $nhanXet)
                ->with('soTrang', $soTrang)
                ->with('page', 1);
        }
        else
        {
            return redirect()->back();
        }
    }
    public function postThemNhanXet(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemNhanXet();
            if($quyenChiTiet==1)
            {
                try{
                    $ten = $request->get('ten');
                    DB::table('st_comment')
                    ->insert([
                        'comment_name'=>$ten,
                        'comment_status'=>1
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
    public function postCapNhatNhanXet(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaNhanXet();
            if($quyenChiTiet==1)
            {
                try{
                    $ten = $request->get('ten2');
                    $id = $request->get('id');
                    DB::table('st_comment')
                    ->where('comment_id',$id)
                    ->update([
                        'comment_name'=>$ten
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
    public function getXoaNhanXet(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaNhanXet();
            if($quyenChiTiet==1)
            {
                try{ 
                  
                    $id = $request->get('id');
                    DB::table('st_comment')
                    ->where('comment_id',$id)
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

    public function searchNhanXet(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            if ($value == "")
                $khuyenMai = DB::table('st_comment')
                  
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            else
                $khuyenMai = DB::table('st_comment')
                    
                    ->where('comment_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();

            $out = "";
            $i = 1;
            foreach ($khuyenMai as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->comment_name . '</td>     ';
                if(session('quyen421')==1)
                $out.='<td><a href="'. route('getNhanXetChiTiet') .'?id='. $item->comment_id .'"><i class="fa fa-list"></i></a></td>';


                if (session('quyen413') == 1)
                    $out .= '<td>
                            <a class="btn"  data-toggle="modal" data-target="#basicModal2"  onclick="setValue(\''.$item->comment_id.'\',\''.$item->comment_name.'\');">
                                <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                        </td>';
                if (session('quyen414') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->comment_id . '\');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>';
                $out .= ' </tr>';
                $i++;
            }
            return response($out);
        }
    }


    public function getNhanXetChiTiet(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemNhanXetChiTiet();
        if($quyenChiTiet==1)
        {
            $id = $request->get('id');

            $nhanXet= DB::table('st_comment')
            ->where('comment_id',$id)
            ->get()->first();
            $lay = $quyen->layDuLieu();
            $chucVuTong = DB::table('st_comment_detail')
                ->where('comment_id',$id)
                ->select('commentDetail_id')
                ->count();
            $nhanXetChiTiet = DB::table('st_comment_detail')
            ->where('comment_id',$id)
            ->take($lay)
            ->get();

            $soKM = $chucVuTong;
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
                return view('NhanXet.nhanXetChiTiet')
                ->with('nhanXet', $nhanXet)
                ->with('nhanXetChiTiet', $nhanXetChiTiet)
                ->with('soTrang', $soTrang)
                ->with('page', 1);
        }
        else
        {
            return redirect()->back();
        }
    }
    public function postThemNhanXetChiTiet(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemNhanXetChiTiet();
            if($quyenChiTiet==1)
            {
                try{
                    $id = $request->get('id');
                    $ten = $request->get('ten');
                    DB::table('st_comment_detail')
                    ->insert([
                        'commentDetail_name'=>$ten,
                        'commentDetail_status'=>1,
                        'comment_id'=>$id
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
    public function postCapNhatNhanXetChiTiet(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaNhanXetChiTiet();
            if($quyenChiTiet==1)
            {
                try{

                    $id = $request->get('id2');
                    $ten = $request->get('ten2');
                    DB::table('st_comment_detail')
                    ->where('commentDetail_id',$id)
                    ->update([
                        'commentDetail_name'=>$ten
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

    public function getXoaNhanXetChiTiet(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaNhanXetChiTiet();
            if($quyenChiTiet==1)
            {
                try{

                    $id = $request->get('id');
                    DB::table('st_comment_detail')
                    ->where('commentDetail_id',$id)
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
    public function searchNhanXetChiTiet(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            $id = $request->get('id');
            if ($value == "")
                $khuyenMai = DB::table('st_comment_detail')
                    ->where('comment_id',$id)
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            else
                $khuyenMai = DB::table('st_comment_detail')
                    ->where('comment_id',$id)
                    ->where('commentDetail_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();

            $out = "";
            $i = 1;
            foreach ($khuyenMai as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->commentDetail_name . '</td>     ';
                if(session('quyen431')==1)
                $out.='<td><a href="'. route('getDiemSoNhanXet') .'?id='. $item->commentDetail_id .'"><i class="fa fa-list"></i></a></td>';


                if (session('quyen423') == 1)
                    $out .= '<td>
                            <a class="btn"  data-toggle="modal" data-target="#basicModal2"  onclick="setValue(\''.$item->commentDetail_id.'\',\''.$item->commentDetail_name.'\');">
                                <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                        </td>';
                if (session('quyen424') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->commentDetail_id . '\');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>';
                $out .= ' </tr>';
                $i++;
            }
            return response($out);
        }
    }

    

    
    public function getDiemSoNhanXet(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemNhanXetDiemSo();
        if($quyenChiTiet == 1)
        {
            $id = $request->get('id');

            $nhanXet= DB::table('st_comment_detail')
            ->where('commentDetail_id',$id)
            ->get()->first();
            $lay = $quyen->layDuLieu();
            $chucVuTong = DB::table('st_comment_result')
                ->where('commentDetail_id',$id)
                ->select('commentResult_id')
                ->count();
            $nhanXetDiemSo = DB::table('st_comment_result')
            ->where('commentDetail_id',$id)
            ->take($lay)
            ->get();

            $soKM = $chucVuTong;
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
                return view('NhanXet.nhanXetDiemSo')
                ->with('nhanXet', $nhanXet)
                ->with('nhanXetDiemSo', $nhanXetDiemSo)
                ->with('soTrang', $soTrang)
                ->with('page', 1);
        }
        else
        {
            return redirect()->back();
        }
    }
    public function postThemNhanXetDiemSo(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemNhanXetDiemSo();
            if($quyenChiTiet==1)
            {
                try{
                    $id = $request->get('id');
                    $ten = $request->get('ten');
                    $diemSo = $request->get('diemSo');
                    DB::table('st_comment_result')
                    ->insert([
                        'commentResult_name'=>$ten,
                        'commentResult_status'=>1,
                        'commentDetail_id'=>$id,
                        'commentResult_number'=>$diemSo
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

    public function postCapNhatNhanXetDiemSo(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaNhanXetDiemSo();
            if($quyenChiTiet==1)
            {
                try{
                    $id = $request->get('id2');
                    $ten = $request->get('ten2');
                    $diemSo = $request->get('diemSo2');
                    DB::table('st_comment_result')
                    ->where('commentResult_id',$id)
                    ->update([
                        'commentResult_name'=>$ten,
                        'commentResult_status'=>1,
                        'commentResult_number'=>$diemSo
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
    

    public function getXoaNhanXetDiemSo(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaNhanXetDiemSo();
            if($quyenChiTiet==1)
            {
                try{
                    $id = $request->get('id');
                   
                    DB::table('st_comment_result')
                    ->where('commentResult_id',$id)
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
    public function searchNhanXetDiemSo(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            $id = $request->get('id');
            if ($value == "")
                $khuyenMai = DB::table('st_comment_result')
                    ->where('commentDetail_id',$id)
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            else
                $khuyenMai = DB::table('st_comment_result')
                    ->where('commentDetail_id',$id)
                    ->where('commentResult_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();

            $out = "";
            $i = 1;
            foreach ($khuyenMai as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->commentResult_name . '</td>
                <td>' . $item->commentResult_number . '</td>     ';
                

                if (session('quyen423') == 1)
                    $out .= '<td>
                            <a class="btn"  data-toggle="modal" data-target="#basicModal2"  onclick="setValue(\''.$item->commentResult_id.'\',\''.$item->commentResult_name.'\',\''.$item->commentResult_number.'\');">
                                <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                        </td>';
                if (session('quyen424') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->commentResult_id . '\');">
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
