<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class khoaHocController extends Controller
{
    public function getKhoaHoc(Request $request)
    {
        $quyen = new quyenController();
        $quyenXemKH = $quyen->getXemKhoaHoc();
        if ($quyenXemKH == 1) {
            $id = $request->get('id');
            $chuongTrinhHoc = DB::table('st_study_program')
                ->where('studyProgram_id', $id)
                ->get()->first();
            $khoaHoc = DB::table('st_course')
                ->join(
                    'st_study_program',
                    'st_study_program.studyProgram_id',
                    '=',
                    'st_course.studyProgram_id'
                )
                ->orderBy('course_number')
                ->where('st_study_program.studyProgram_id', $id)
                ->get();
            return view('ChuongTrinhHoc.khoaHoc')
                ->with('khoaHoc', $khoaHoc)
                ->with('chuongTrinhHoc', $chuongTrinhHoc);
        } else
            return redirect()->back();
    }
    public function getThemKhoaHoc(Request $request)
    {
        $id = $request->get('id');
        $chuongTrinhHoc = DB::table('st_study_program')
            ->where('studyProgram_id', $id)
            ->get()->first();
        $giaoVien = DB::table('st_employee')

            ->get();
        return view('admin.KhoaHoc.themKhoaHoc')
            ->with('giaoVien', $giaoVien)
            ->with('chuongTrinhHoc', $chuongTrinhHoc);
    }
    public function postThemKhoaHoc(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenThemKH = $quyen->getThemKhoaHoc();
            if ($quyenThemKH == 1) {
                $id = $request->get('id');
                $ten = $request->get('ten');
                $gio = $request->get('gio');
                $gia = $request->get('gia');
                $so = $request->get('so');
                $thoiGian = $request->get('thoiGian');
                $giaoTrinh = $request->get('giaoTrinh');
                if($giaoTrinh=="")
                $giaoTrinh="";
                try {

                    $khoaHocCapNhat=DB::table('st_course')
                    ->where('course_number','>=',$so)
                    ->where('studyProgram_id',$id)
                    ->orderBy('course_number')
                    ->get();

                    DB::table('st_course')
                        ->insert([
                            'course_name' => $ten,
                            'course_hours' => $gio,
                            'course_price' => $gia,
                            'studyProgram_id' => $id,
                            'course_number'=>$so,
                            'course_material'=>$giaoTrinh
                        ]);

                        foreach($khoaHocCapNhat as $item)
                        {
                            $so++;
                            DB::table('st_course')
                            ->where('course_id', $item->course_id)                           
                            ->update([
                                'course_number' =>  $so
                                ]);
                        }
                    return response(1);
                } catch (QueryException $e) {
                    // session()->flash('errHocVien', "Không Thể Thêm Học Viên!");
                    return response(0);
                }
            } else
                return response(2);
        }
    }
    public function getCapNhatKhoaHoc(Request $request)
    {
        $id = $request->get('id');
        $khoaHoc = DB::table('st_course')
            ->join(
                'st_study_program',
                'st_study_program.studyProgram_id',
                '=',
                'st_course.studyProgram_id'
            )
            ->where('st_course.course_id', $id)
            ->get()->first();
        $giaoVien = DB::table('st_employee')
            ->get();
        return view('admin.KhoaHoc.suaKhoaHoc')
            ->with('giaoVien', $giaoVien)
            ->with('khoaHoc', $khoaHoc);
    }

    public function postCapNhatKhoaHoc(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenSuaKH = $quyen->getSuaKhoaHoc();
            if ($quyenSuaKH == 1) {
                $id = $request->get('id2');
                $ten = $request->get('ten2');
                $soGio = $request->get('gio2');
              
                $idCT = $request->get('idCT');
                $gia = $request->get('gia2');
                $so = $request->get('so2');
                $giaoTrinh = $request->get('giaoTrinh2');
                $thoiGian = $request->get('thoiGian2');
                if($giaoTrinh=="")
                $giaoTrinh="";
                try {

                    $khoaHocCapNhat =  DB::table('st_course')
                    ->where('course_id', '!=',$id)
                    ->where('studyProgram_id',$idCT)
                    ->orderBy('course_number')
                    ->get();
                    $i=1;
                    foreach($khoaHocCapNhat as $item)
                    {
                        if($i==$so)
                        $i++;

                        DB::table('st_course')
                        ->where('course_id', $item->course_id)
                        ->update([
                            'course_number' => $i
                            ]);
                        
                        $i++;
                    }

                    DB::table('st_course')
                        ->where('course_id', $id)
                        ->update([
                            'course_name' => $ten,
                            'course_hours' => $soGio,
                            'course_price' => $gia,
                            'course_number'=>$so,
                            'course_material'=>$giaoTrinh
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
    public function getXoaKhoaHoc(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenXoaKH = $quyen->getXoaKhoaHoc();
            if ($quyenXoaKH == 1) {
                $id = $request->get('id');
                try {
                    DB::table('st_course')
                        ->where('course_id', $id)
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
    public function searchKhoaHoc(Request $request)
    {
        if ($request->ajax()) {
            $value =$request->get('value');
            $id=$request->get('id');
            if ($value == "")
                $khoaHoc = DB::table('st_course')
                ->join( 'st_study_program','st_study_program.studyProgram_id',
                    '=','st_course.studyProgram_id')
                    ->where('st_study_program.studyProgram_id', $id)
                    ->orderBy('course_number')
                    ->get();
            else
                $khoaHoc = DB::table('st_course')
                ->join( 'st_study_program','st_study_program.studyProgram_id',
                '=','st_course.studyProgram_id')
                    ->where('st_study_program.studyProgram_id', $id)
                    ->Where(function($query) use($value){
                        $query->where('course_name', 'like', '%' . $value . '%')
                        ->orwhere('studyProgram_code', 'like', '%' . $value . '%');
                    })
                    ->orderBy('course_number')
                    ->get();

            $out = "";
            $i = 1;
            foreach ($khoaHoc as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->studyProgram_code . '</td>
                <td>' . $item->course_name . '</td>
                <td>' . $item->course_hours . '</td>
                <td>' .number_format($item->course_price ,0,"",".") . 'đ</td>
                <td>' . $item->course_number . '</td>
                 <td>' . $item->course_material . '</td>';

                if(session('quyen81')==1)
                $out .= '<td><a href="'.route('getBaiGiang').'?id='.$item->course_id.'">Chi tiết</a></td>';
                if(session('quyen121')==1)
                $out .= '<td><a href="'.route('getLoaiKetQuaHocTap').'?id='.$item->course_id.'">Chi tiết</a></td>';
                
               
                if(session('quyen53')==1)       
                $out .= '<td><a class="btn" data-toggle="modal" data-target="#basicModal2"
                onclick="setValue(\''.$item->course_id.'\',\''.$item->course_name.'\',
              \''.$item->course_hours.'\',\''.$item->course_price.'\'
              ,\''.$item->course_number.'\',\''.$item->course_material.'\')">
                        <i style="color: blue" class="fa fa-edit"></i>
                                        </a></td>';
                 if(session('quyen54')==1)       
                $out .= '<td>
                            <a class="btn" onclick="xoa(\'' . $item->course_id . '\');">
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
