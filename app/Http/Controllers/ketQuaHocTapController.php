<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ketQuaHocTapController extends Controller
{
    public function getLoaiKetQuaHocTap(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemLoaiKetQuaHocTap();
        if ($quyenChiTiet == 1) {
            $id = $request->get('id');
            $khoaHoc = DB::table('st_course')
                ->where('course_id', $id)
                ->get()->first();
            $ketQuaHocTap = DB::table('st_learning_outcome_type')
                ->where('course_id', $id)
                ->get();
            return view('ChuongTrinhHoc.loaiKetQuaHocTap')
                ->with('khoaHoc', $khoaHoc)
                ->with('ketQuaHocTap', $ketQuaHocTap);
        } else return redirect()->back();
    }
    public function postThemLoaiKetQuaHocTap(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemLoaiKetQuaHocTap();
            if ($quyenChiTiet == 1) {
                try
                {
                    $id = $request->get('id');
                    $phanTram = $request->get('phanTram');
                    $loai = $request->get('loai');
                    DB::table('st_learning_outcome_type')
                    ->insert([
                        'course_id'=>$id,
                        'learningOutcomeType_percent'=>$phanTram,
                        'learningOutcomeType_name'=>$loai
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
    
    public function postCapNhatLoaiKetQuaHocTap(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaLoaiKetQuaHocTap();
            if ($quyenChiTiet == 1) {
                try
                {
                    $id = $request->get('id2');
                    $phanTram = $request->get('phanTram2');
                    $loai = $request->get('loai2');
                    DB::table('st_learning_outcome_type')
                    ->where('learningOutcomeType_id',$id)
                    ->update([
                        'learningOutcomeType_percent'=>$phanTram,
                        'learningOutcomeType_name'=>$loai
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
    public function getXoaLoaiKetQuaHocTap(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaLoaiKetQuaHocTap();
            if ($quyenChiTiet == 1) {
                try
                {
                    $id = $request->get('id');
                  
                    DB::table('st_learning_outcome_type')
                    ->where('learningOutcomeType_id',$id)
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

    public function searchLoaiKetQuaHocTap(Request $request)
    {
        if($request->ajax())
        {
            $value= $request->get('value');
            $id = $request->get('idKhoaHoc');
            if($value=="")
            {
                $ketQuaHocTap = DB::table('st_learning_outcome_type')
                ->where('course_id', $id)
                ->get();
            }
            else
            {
                $ketQuaHocTap = DB::table('st_learning_outcome_type')
                ->where('course_id', $id)
                ->where('learningOutcomeType_name', 'like', '%' . $value . '%')
                ->get();
            }
            $out = "";
            $i = 1;
            foreach ($ketQuaHocTap as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->learningOutcomeType_name . '</td>
                <td>' . $item->learningOutcomeType_percent . '</td>';
                if(session('quyen131')==1)
                $out .= '<td><a  href="'.route('getKetQuaHocTap').'?id='.$item->learningOutcomeType_id.'" class="fa fa-list"></a></td>';

                if(session('quyen123')==1)       
                $out .= '<td><a class="btn" data-toggle="modal" data-target="#basicModal2"
                onclick="setValue(\''.$item->learningOutcomeType_id.'\',\''.$item->learningOutcomeType_name.'\',
              \''.$item->learningOutcomeType_percent.'\')">
                        <i style="color: blue" class="fa fa-edit"></i>
                                        </a></td>';
                 if(session('quyen124')==1)       
                $out .= '<td>
                            <a class="btn" onclick="xoa(\'' . $item->learningOutcomeType_id . '\');">
                                <i style="color: red" class="fa fa-close"></i>
                            </a>
                        </td>
                </tr>';
                $i++;
            }
            return response($out);
        }
    }

    public function searchLoaiKetQuaHocTapHocVien(Request $request)
    {
        if($request->ajax())
        {
            $value= $request->get('value');
            $id = $request->get('idKhoaHoc');
            if($value=="")
            {
                $ketQuaHocTap = DB::table('st_learning_outcome_type')
                ->where('course_id', $id)
                ->get();
            }
            else
            {
                $ketQuaHocTap = DB::table('st_learning_outcome_type')
                ->where('course_id', $id)
                ->where('learningOutcomeType_name', 'like', '%' . $value . '%')
                ->get();
            }
            $out = "";
            $i = 1;
            foreach ($ketQuaHocTap as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->learningOutcomeType_name . '</td>
                <td>' . $item->learningOutcomeType_percent . '</td>
                <td><a class="fa fa-list"></a></td>';
                $i++;
            }
            return response($out);
        }
    }
    public function getKetQuaHocTap(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemKetQuaHocTap();
        if ($quyenChiTiet == 1) {
            $id = $request->get('id');
            $loaiKetQuaHocTap = DB::table('st_learning_outcome_type')
                ->join('st_course','st_course.course_id','=','st_learning_outcome_type.course_id')
                ->where('learningOutcomeType_id', $id)
                ->get()->first();
            $ketQuaHocTap = DB::table('st_learning_outcomes')
                ->where('learningOutcomeType_id', $id)
                ->get();
            return view('ChuongTrinhHoc.ketQuaHocTap')
                ->with('loaiKetQuaHocTap', $loaiKetQuaHocTap)
                ->with('ketQuaHocTap', $ketQuaHocTap);
        } else return redirect()->back();
    }

    public function searchKetQuaHocTap(Request $request)
    {
        if($request->ajax())
        {
            $value= $request->get('value');
            $id = $request->get('idKhoaHoc');
            if($value=="")
            {
                $ketQuaHocTap = DB::table('st_learning_outcomes')
                ->where('learningOutcomeType_id', $id)
                ->get();
            }
            else
            {
                $ketQuaHocTap = DB::table('st_learning_outcomes')
                ->where('learningOutcomeType_id', $id)
                ->where('learningOutcome_name', 'like', '%' . $value . '%')
                ->get();
            }
            $out = "";
            $i = 1;
            foreach ($ketQuaHocTap as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->learningOutcome_name . '</td>';
                if($item->learningOutcome_type==1)
                $out .= '<td>Điểm số</td>';
                else 
                $out .= '<td>Nhận xét</td>';


                $out .= '<td>' . $item->learningOutcome_point . '</td>';

                if(session('quyen123')==1)       
                $out .= '<td><a class="btn" data-toggle="modal" data-target="#basicModal2"
                onclick="setValue(\''.$item->learningOutcome_id.'\',\''.$item->learningOutcome_name.'\',
              \''.$item->learningOutcome_type.'\',\''.$item->learningOutcome_point.'\')">
                        <i style="color: blue" class="fa fa-edit"></i>
                                        </a></td>';
                 if(session('quyen124')==1)       
                $out .= '<td>
                            <a class="btn" onclick="xoa(\'' . $item->learningOutcome_id . '\');">
                                <i style="color: red" class="fa fa-close"></i>
                            </a>
                        </td>
                </tr>';
                $i++;
            }
            return response($out);
        }
    }
    public function postThemKetQuaHocTap(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemKetQuaHocTap();
            if ($quyenChiTiet == 1) {
                try
                {
                    $id = $request->get('id');
                    $ten = $request->get('ten');
                    $loai = $request->get('loai');
                    if($loai==1)
                    {
                        $diemSo = $request->get('diemSo');
                    }
                    else
                    {
                        $diemSo="";
                    }

                    DB::table('st_learning_outcomes')
                    ->insert([
                        'learningOutcomeType_id'=>$id,
                        'learningOutcome_name'=>$ten,
                        'learningOutcome_point'=>$diemSo,
                        'learningOutcome_type'=>$loai
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
    public function postCapNhatKetQuaHocTap(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaKetQuaHocTap();
            if ($quyenChiTiet == 1) {
                try
                {
                    $id = $request->get('id2');
                    $ten = $request->get('ten2');
                    $loai = $request->get('loai2');
                    if($loai==1)
                    {
                        $diemSo = $request->get('diemSo2');
                    }
                    else
                    {
                        $diemSo="";
                    }

                    DB::table('st_learning_outcomes')
                    ->where('learningOutcome_id',$id)
                    ->update([
                       
                        'learningOutcome_name'=>$ten,
                        'learningOutcome_point'=>$diemSo,
                        'learningOutcome_type'=>$loai
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
    public function getXoaKetQuaHocTap(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaKetQuaHocTap();
            if ($quyenChiTiet == 1) {
                try
                {
                    $id = $request->get('id');
                    

                    DB::table('st_learning_outcomes')
                    ->where('learningOutcome_id',$id)
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

    public function getNhanXetKetQuaHocTap(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemNhanXetKetQuaHocTap();
        if($quyenChiTiet ==1)
        {
            $id = $request->get('id');
            $ketQuaHocTap = DB::table('st_learning_outcome_type')
            ->where('learningOutcomeType_id',$id)
            ->get()->first();

            $nhanXetKetQua = DB::table('st_learning_outcome_type_comment')
            ->join('st_comment_detail','st_comment_detail.commentDetail_id','=','st_learning_outcome_type_comment.commentDetail_id')
            ->join('st_comment','st_comment.comment_id','=','st_comment_detail.comment_id')
            ->where('st_learning_outcome_type_comment.learningOutcomeType_id',$id)
            ->orderBy('st_comment.comment_id')
            ->get();

            $nhanXet = DB::table('st_comment')
            ->join('st_comment_detail','st_comment_detail.comment_id','=','st_comment.comment_id')
            ->get();

            return view('ChuongTrinhHoc.nhanXetLoaiKetQuaHocTap')
            ->with('ketQuaHocTap',$ketQuaHocTap)
            ->with('nhanXetKetQua',$nhanXetKetQua)
            ->with('nhanXet',$nhanXet);



        }
        else
        {
            return redirect()->back();
        }
    }

    public function postThemNhanXetLoaiKetQuaHocTap(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemNhanXetKetQuaHocTap();
            if($quyenChiTiet ==1)
            {
                try
                {
                    $id = $request->get('id');
                    $nhanXet = $request->get('nhanXet');
                    $ketQuaNhanXet= DB::table('st_learning_outcome_type_comment')
                    ->where('commentDetail_id',$nhanXet)
                    ->where('learningOutcomeType_id',$id)
                    ->get()->first();
     
                    if(isset($ketQuaNhanXet))
                    {
                        return response(3);
                    }
                    else
                    {
                        DB::table('st_learning_outcome_type_comment')
                        ->insert([
                            'commentDetail_id'=>$nhanXet,
                            'learningOutcomeType_id'=>$id
                        ]);
                        return response(1);
                    }
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

    public function postCapNhatNhanXetLoaiKetQuaHocTap(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaNhanXetKetQuaHocTap();
            if($quyenChiTiet ==1)
            {
                try
                {
                    $id = $request->get('id2');
                    $id3 = $request->get('id3');
                    $nhanXet = $request->get('nhanXet2');
                    $ketQuaNhanXet= DB::table('st_learning_outcome_type_comment')
                    ->where('learningOutcomeTypeComment_id','!=',$id3)
                    ->where('commentDetail_id',$nhanXet)
                    ->where('learningOutcomeType_id',$id)
                    ->get()->first();
     
                    if(isset($ketQuaNhanXet))
                    {
                        return response(3);
                    }
                    else
                    {
                        DB::table('st_learning_outcome_type_comment')
                        ->where('learningOutcomeTypeComment_id',$id3)
                        ->update([
                            'commentDetail_id'=>$nhanXet
                        ]);
                        return response(1);
                    }
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

    public function getXoaNhanXetKetQuaHocTap(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaNhanXetKetQuaHocTap();
            if($quyenChiTiet ==1)
            {
                try
                {
                    $id = $request->get('id');
                  
                  
                        DB::table('st_learning_outcome_type_comment')
                        ->where('learningOutcomeTypeComment_id',$id)
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
    


}
