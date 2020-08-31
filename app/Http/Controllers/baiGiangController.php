<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class baiGiangController extends Controller
{
    public function getBaiGiang(Request $request)
    {
        $quyen = new quyenController();
        $quyenXemBG = $quyen->getXemBaiGiang();
        if ($quyenXemBG == 1) {
            $id = $request->get('id');
            $sms = $request->get('sms');
            if($sms=="")
            {
                $sms = 3;
            }
            $khoaHoc = DB::table('st_course')
                ->where('course_id', $id)
                ->get()->first();
            $baiGiang = DB::table('st_pacing_guide')
                ->where('course_id', $id)
                ->get();

            return view('ChuongTrinhHoc.baiGiang')
                ->with('khoaHoc', $khoaHoc)
                ->with('baiGiang', $baiGiang)
                ->with('sms', $sms)
                ;
        } else return redirect()->back();
    }

    public function getThemBaiGiang(Request $request)
    {
        $quyen = new quyenController();
        $quyenXemBG = $quyen->getThemBaiGiang();
        if ($quyenXemBG == 1) {
            $id = $request->get('id');
            $khoaHoc = DB::table('st_course')
                ->where('course_id', $id)
                ->get()->first();

            return view('ChuongTrinhHoc.themBaiGiang')
                ->with('khoaHoc', $khoaHoc)

                ;
        } else return redirect()->back();
    }

    public function getCapNhatBaiGiang(Request $request)
    {
        $quyen = new quyenController();
        $quyenXemBG = $quyen->getSuaBaiGiang();
        if ($quyenXemBG == 1) {
            $id = $request->get('id');

            $baiGiang = DB::table('st_pacing_guide')
            ->where('pacingGuide_id',$id)
            ->get()->first();


            return view('ChuongTrinhHoc.capNhatBaiGiang')
                ->with('baiGiang', $baiGiang)

                ;
        } else return redirect()->back();
    }
    public function postThemBaiDay(Request $request)
    {

            $quyen = new quyenController();
            $quyenThemBG = $quyen->getThemBaiGiang();
            $id = $request->get('id');
            if ($quyenThemBG == 1) {

                $ten = $request->get('ten');
                try {
                    DB::table('st_pacing_guide')
                        ->insert([
                            'pacingGuide_name' => $ten,
                            'course_id' => $id
                        ]);
                        return redirect()->route('getBaiGiang',['id'=>$id,'sms'=>1]);
                } catch (QueryException $e) {
                    // session()->flash('errHocVien', "Không Thể Thêm Học Viên!");
                    return redirect()->route('getBaiGiang',['id'=>$id,'sms'=>0]);
                }
            } else {
                return redirect()->route('getBaiGiang',['id'=>$id,'sms'=>2]);
            }

    }
    public function postChinhSuaBaiDay(Request $request)
    {

            $quyen = new quyenController();
            $quyenSuaBG = $quyen->getSuaBaiGiang();
            $id2 = $request->get('id2');
            $id = $request->get('id');
            if ($quyenSuaBG == 1) {

                $ten = $request->get('ten');
                try {
                    DB::table('st_pacing_guide')
                        ->where('pacingGuide_id', $id2)
                        ->update([
                            'pacingGuide_name' => $ten
                        ]);
                        return redirect()->route('getBaiGiang',['id'=>$id,'sms'=>1]);
                    } catch (QueryException $e) {
                        // session()->flash('errHocVien', "Không Thể Thêm Học Viên!");
                        return redirect()->route('getBaiGiang',['id'=>$id,'sms'=>0]);
                    }
                } else {
                    return redirect()->route('getBaiGiang',['id'=>$id,'sms'=>2]);
                }

    }
    public function getXoaBaiGiang(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenXoaBG = $quyen->getXoaBaiGiang();
                if ($quyenXoaBG == 1) {
                $id = $request->get('id');
                try {
                    DB::table('st_pacing_guide')
                        ->where('pacingGuide_id', $id)
                        ->delete();
                    return response(1);
                } catch (QueryException $e) {
                    // session()->flash('errHocVien', "Không Thể Thêm Học Viên!");
                    return response(0);
                }
            }
            else
                return response(2);
        }
    }
}
