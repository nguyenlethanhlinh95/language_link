<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class capDoController extends Controller
{
    public function getCapDoLopHoc()
    {

        $quyen = new quyenController();
        $quyenXemCapDo = $quyen->getXemCapDo();
        if ($quyenXemCapDo == 1) {
            $capDo = DB::table('st_level')
                ->get();

            return view('CapDo.capDo')
                ->with('capDo', $capDo);
        } else
            return redirect()->back();
    }
    public function postThemCapDo(Request $request)
    {
        if ($request->ajax()) {

            $quyen = new quyenController();
            $quyenThemCapDo = $quyen->getThemCapDo();
            if ($quyenThemCapDo == 1) {
                try {
                    $ten = $request->get('ten');
                    $so = $request->get('ma');
                    DB::table('st_level')
                        ->insert([
                            'level_name' => $ten,
                            'level_number' => $so
                        ]);
                    return response(1);
                } catch (QueryException $e) {
                    // session()->flash('errHocVien', "Không Thể Thêm Học Viên!");
                    return response(0);
                }
            } else
                return response(2);
        }
    }
    public function postCapNhatCapDo(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenSuaCapDo = $quyen->getSuaCapDo();
            if ($quyenSuaCapDo == 1) {
                try {
                    $ten = $request->get('ten2');
                    $so = $request->get('ma2');
                    $id = $request->get('id');
                    DB::table('st_level')
                        ->where('level_id', $id)
                        ->update([
                            'level_name' => $ten,
                            'level_number' => $so
                        ]);
                    return response(1);
                } catch (QueryException $e) {
                    // session()->flash('errHocVien', "Không Thể Thêm Học Viên!");
                    return response(0);
                }
            } else
                return response(2);
        }
    }

    public function getXoaCapDo(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenXoaCapDo = $quyen->getXoaCapDo();
            if ($quyenXoaCapDo == 1) {
                try {
                    $id = $request->get('id');
                    DB::table('st_level')
                        ->where('level_id', $id)
                        ->delete();
                    return response(1);
                } catch (QueryException $e) {
                    // session()->flash('errHocVien', "Không Thể Thêm Học Viên!");
                    return response(0);
                }
            } else
                return response(2);
        }
    }

    public function searchCapDo(Request $request)
    {
        if ($request->ajax()) {
            $value =$request->get('value');
            if ($value == "")
                $chuongTrinh = DB::table('st_level')
                    ->get();
            else
                $chuongTrinh = DB::table('st_level')
                    ->where('level_name', 'like', '%' . $value . '%')
                    ->orwhere('level_number', 'like', '%' . $value . '%')
                    ->get();

            $out = "";
            $i = 1;
            foreach ($chuongTrinh as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>';
                if(session('quyen71')==1)
                $out .= '<td><a href="' . route('getCapDoChiTiet') . '?id=' . $item->level_id . '">' . $item->level_name. '</a></td>';
               else
               $out .= '<td> '. $item->level_name.'</td>';
               
                $out .= '<td>' . $item->level_number . '</td>
                <td><a class="btn" data-toggle="modal" data-target="#basicModal2"
                onclick="setValue(\''.$item->level_id.'\',\''.$item->level_name.'\',
              \''.$item->level_number.'\')">
                        <i style="color: blue" class="fa fa-edit"></i>
                                        </a></td>
                                    <td>
                                        <a class="btn" onclick="xoa(\''.$item->level_id.'\');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>
                </tr>';
                $i++;
            }
            return response($out);
        }
    }


    public function getCapDoChiTiet(Request $request)
    {

        $quyen = new quyenController();
        $quyenXemCapDo = $quyen->getXemCapDoChiTiet();
        if ($quyenXemCapDo == 1) {
            $id=$request->get('id');
            $capDo = DB::table('st_level')
            ->where('level_id',$id)
                ->get()
                ->first();
                $capDoChiTiet = DB::table('st_level_detail')
                ->join('st_level','st_level.level_id','=','st_level_detail.level_id')
                ->where('st_level.level_id',$id)
                    ->get();
            return view('CapDo.capDoChiTiet')
                ->with('capDo', $capDo)
                ->with('capDoChiTiet', $capDoChiTiet)
                ;
        } else
            return redirect()->back();
    }
    public function postThemCapDoChiTiet(Request $request)
    {
        if ($request->ajax()) {

            $quyen = new quyenController();
            $quyenThemCapDo = $quyen->getThemCapDoChiTiet();
            if ($quyenThemCapDo == 1) {
                try {
                    $ten = $request->get('ten');
                    $id = $request->get('id');
                    $so = $request->get('ma');
                    DB::table('st_level_detail')
                        ->insert([
                            'levelDetail_name' => $ten,
                            'levelDetail_number' => $so,
                            'level_id' => $id
                        ]);
                    return response(1);
                } catch (QueryException $e) {
                    // session()->flash('errHocVien', "Không Thể Thêm Học Viên!");
                    return response(0);
                }
            } else
                return response(2);
        }
    }
    public function postCapNhatCapDoChiTiet(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenSuaCapDo = $quyen->getSuaCapDoChiTiet();
            if ($quyenSuaCapDo == 1) {
                try {
                    $ten = $request->get('ten2');
                    $so = $request->get('ma2');
                    $id = $request->get('id2');
                    DB::table('st_level_detail')
                        ->where('levelDetail_id', $id)
                        ->update([
                            'levelDetail_name' => $ten,
                            'levelDetail_number' => $so
                        ]);
                    return response(1);
                } catch (QueryException $e) {
                    // session()->flash('errHocVien', "Không Thể Thêm Học Viên!");
                    return response(0);
                }
            } else
                return response(2);
        }
    }

    public function getXoaCapDoChiTiet(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenXoaCapDo = $quyen->getXoaCapDoChiTiet();
            if ($quyenXoaCapDo == 1) {
                try {
                    $id = $request->get('id');
                    DB::table('st_level_detail')
                        ->where('levelDetail_id', $id)
                        ->delete();
                    return response(1);
                } catch (QueryException $e) {
                    // session()->flash('errHocVien', "Không Thể Thêm Học Viên!");
                    return response(0);
                }
            } else
                return response(2);
        }
    }

    public function searchCapDoChiTiet(Request $request)
    {
        if ($request->ajax()) {
            $value =$request->get('value');
            $id=$request->get('id');
            if ($value == "")
            $capDoChiTiet = DB::table('st_level_detail')
            ->join('st_level','st_level.level_id','=','st_level_detail.level_id')
            ->where('st_level.level_id',$id)
                ->get();
            else
            $capDoChiTiet = DB::table('st_level_detail')
            ->join('st_level','st_level.level_id','=','st_level_detail.level_id')
            ->where('st_level.level_id',$id)
            ->Where(function($query) use($value){
                $query->where('levelDetail_name', 'like', '%' . $value . '%')
                        ->orwhere('level_name', 'like', '%' . $value . '%');
            })
                ->get();

            $out = '';
            $i = 1;
            foreach ($capDoChiTiet as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->level_name . '</td>
                <td>' . $item->levelDetail_name . '</td>
                <td>' . $item->levelDetail_number . '</td>
                <td><a class="btn" data-toggle="modal" data-target="#basicModal2"
                onclick="setValue(\''.$item->levelDetail_id.'\',\''.$item->levelDetail_name.'\',
                \''.$item->levelDetail_number.'\')">
                        <i style="color: blue" class="fa fa-edit"></i>
                                        </a></td>
                                    <td>
                                        <a class="btn" onclick="xoa('.$item->levelDetail_id.');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>
                </tr>';
                $i++;
            }
            return response($out);
        }
    }
}
