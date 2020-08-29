<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class chuongTrinhController extends Controller
{
    public function getChuongTrinhHoc()
    {
        $quyen = new quyenController();
        $quyenXemCTH = $quyen->getXemChuongTrinhHoc();
        if ($quyenXemCTH == 1) {
            $quyenTatCa = $quyen->getXemTatCaChuongTrinhHoc();
            $lay = $quyen->layDuLieu();
            if($quyenTatCa==1)
            {
                $chiNhanh = DB::table('st_branch')
                ->get();
                $chuongTrinh = DB::table('view_branch_study_program')
                ->take($lay)
                ->skip(0)
                ->orderBy('studyProgram_number')
                ->get();
                $chuongTrinhTong = DB::table('view_branch_study_program')
                ->count();    
            }
            else
            {
                $chiNhanh = DB::table('st_branch')
                ->where('branch_id',session('coSo'))
                ->get();
                $chuongTrinh = DB::table('view_branch_study_program')
                ->where('branch_id',session('coSo'))
                ->take($lay)
                ->skip(0)
                ->orderBy('studyProgram_number')
                    ->get();

                    $chuongTrinhTong = DB::table('view_branch_study_program')
                    ->where('branch_id',session('coSo'))
                    ->count();   
            }
            $soKM = $chuongTrinhTong;
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
          
            return view('ChuongTrinhHoc.chuongTrinhHoc')
                ->with('chuongTrinh', $chuongTrinh)
                ->with('chiNhanh', $chiNhanh)
                ->with('soTrang', $soTrang)
                ->with('page', 1)
                ->with('ten', "");
        } else
            return redirect()->back();
    }
    public function postThemChuongTrinHoc(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenThemCTH = $quyen->getThemChuongTrinhHoc();
            if ($quyenThemCTH == 1) {
                $ten = $request->get('ten');
                $ma = $request->get('ma');
                $noiDung = $request->get('noiDung');
                $so = $request->get('so');
                $chiNhanh = $request->get('chiNhanh');
                $chuongTrinhHoc = DB::table('st_study_program')
                    ->where('studyProgram_code', $ma)
                    ->get()
                    ->first();

                if (isset($chuongTrinhHoc)) {
                    return  response(3);
                } else {
                    try {
                        $chuongTrinhHocCapNhat = DB::table('st_study_program')
                        ->where('studyProgram_number','>=', $so)
                        ->where('branch_id', $chiNhanh)
                        ->orderBy('studyProgram_number')
                        ->select('studyProgram_id','studyProgram_name')
                        ->get();

                        DB::table('st_study_program')
                            ->insert([
                                'studyProgram_name' => $ten,
                                'studyProgram_code' => $ma,
                                'studyProgram_detail' => $noiDung,
                                'studyProgram_status' => 1,
                                'studyProgram_number'=>$so,
                                'branch_id'=>$chiNhanh
                            ]);
                           
                            foreach($chuongTrinhHocCapNhat as $item)
                            {
                                $so++;
                                DB::table('st_study_program')
                                ->where('studyProgram_id',  $item->studyProgram_id)
                                ->update([
                                    'studyProgram_number' =>$so
                                ]);
                               
                            }
                        return response(1);
                    } catch (QueryException $e) {
                        // session()->flash('errHocVien', "Không Thể Thêm Học Viên!");
                        return response(0);
                    }
                }
            } else
                return response(2);
        }
    }
    public function getXoaChuongTrinhHoc(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenXoaCTH = $quyen->getXoaChuongTrinhHoc();
            if ($quyenXoaCTH == 1) {
                $id = $request->get('id');
                try {
                    DB::table('st_study_program')
                        ->where('studyProgram_id', $id)
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
    public function postCapNhatChuongTrinhHoc(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenSuaCTH = $quyen->getSuaChuongTrinhHoc();
            if ($quyenSuaCTH == 1) {
                $ten = $request->get('ten2');
                $ma = $request->get('ma2');
                $noiDung = $request->get('noiDung2');
                $id = $request->get('id');
                $so  = $request->get('so2');
                $chiNhanh = $request->get('chiNhanh2');
                $chuongTrinhHoc = DB::table('st_study_program')
                    ->where('studyProgram_code', $ma)
                    ->where('studyProgram_id', '!=', $id)
                    ->get()
                    ->first();

                if (isset($chuongTrinhHoc)) {
                    return  response(3);
                } else {
                    try {
                        $chuongTrinhHocCapNhat = DB::table('st_study_program')
                        ->where('studyProgram_id','!=', $id)
                        ->orderBy('studyProgram_number')
                        ->select('studyProgram_id','studyProgram_name')
                        ->where('branch_id', $chiNhanh)
                        ->get();

                        $i=1;
                        foreach($chuongTrinhHocCapNhat as $item)
                        {
                            if($i==$so)
                            $i++;
                            DB::table('st_study_program')
                            ->where('studyProgram_id',  $item->studyProgram_id)
                            ->update([
                                'studyProgram_number' =>$i
                            ]);
                            $i++;
                        }


                        DB::table('st_study_program')
                            ->where('studyProgram_id', $id)
                            ->update([
                                'studyProgram_name' => $ten,
                                'studyProgram_code' => $ma,
                                'studyProgram_detail' => $noiDung,
                                'studyProgram_number' =>$so,
                                'branch_id' =>$chiNhanh
                            ]);
                        return response(1);
                    } catch (QueryException $e) {
                        // session()->flash('errHocVien', "Không Thể Thêm Học Viên!");
                        return response(0);
                    }
                }
            } else
                return response(2);
        }
    }
    public function searchChuongTrinh(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenTatCa = $quyen->getXemTatCaChuongTrinhHoc();
            $lay = $quyen->layDuLieu();
            $page = $request->get('page');
            $value =$request->get('value');
            if($quyenTatCa==1)
            {
                if ($value == "")
                $chuongTrinh = DB::table('view_branch_study_program')
                ->orderBy('studyProgram_number')
                ->skip(($page-1)*$lay)
                ->take($lay)
                ->get();
            else
                $chuongTrinh = DB::table('view_branch_study_program')
                    ->where('studyProgram_name', 'like', '%' . $value . '%')
                    ->orwhere('studyProgram_code', 'like', '%' . $value . '%')
                    ->orwhere('branch_code', 'like', '%' . $value . '%')
                    ->orderBy('studyProgram_number')
                    ->skip(($page-1)*$lay)
                    ->take($lay)
                    ->get();
            }
            else
            {
                if ($value == "")
                $chuongTrinh = DB::table('view_branch_study_program')
                ->where('branch_id',session('coSo'))
                ->orderBy('studyProgram_number')
                ->skip(($page-1)*$lay)
                ->take($lay)
                ->get();
            else
                $chuongTrinh = DB::table('view_branch_study_program')
                    ->where('branch_id',session('coSo'))
                    ->where(function($query) use ($value)
                    {
                        $query ->where('studyProgram_name', 'like', '%' . $value . '%')
                        ->orwhere('studyProgram_code', 'like', '%' . $value . '%')
                        ->orwhere('branch_code', 'like', '%' . $value . '%');
                    })
                    ->orderBy('studyProgram_number')
                    ->skip(($page-1)*$lay)
                    ->take($lay)
                    ->get();
            }
            

            $out = "";
            $i = 1;
            foreach ($chuongTrinh as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td> '. $item->branch_code.'</td>';
                if(session('quyen51')==1)
                $out .= '<td><a href=\'' . route('getKhoaHoc') . '?id=' . $item->studyProgram_id . '\'>' . $item->studyProgram_name. '</a></td>';
               else
               $out .= '<td> '. $item->studyProgram_name.'</td>';
               
                $out .= '<td>' . $item->studyProgram_code . '</td>
                <td>' . $item->studyProgram_detail . '</td>
                <td>' . $item->studyProgram_number . '</td>
                <td><a class="btn" data-toggle="modal" data-target="#basicModal2"
                onclick="setValue(\''.$item->studyProgram_id.'\',\''.$item->studyProgram_name.'\',
              \''.$item->studyProgram_code.'\',\''.$item->studyProgram_detail.'\',\''.$item->studyProgram_number.'\')">
                        <i style="color: blue" class="fa fa-edit"></i>
                                        </a></td>
                                    <td>
                                        <a class="btn" onclick="xoa(\'' . $item->studyProgram_id . '\');">
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
