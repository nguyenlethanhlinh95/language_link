<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Hamcrest\Type\IsNumeric;
use Maatwebsite\Excel\Facades\Excel;

class ketQuaHocTapLopHocController extends Controller
{
    public function getDanhSachHocVienKetQuaHocTap(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getCapNhatKetQuaHocTapHocVien();
        if($quyenChiTiet==1)
        {
            $id = $request->get('id');
            $lop = DB::table('st_class')
            ->where('class_id',$id)
            ->get()->first();

            $hocVien = DB::table('view_class_student')
            ->where('class_id',$id)
            ->get();

            return view('LopHoc.danhSachHocVien')
            ->with('lop',$lop)
            ->with('hocVien',$hocVien);
        }
        else
        return redirect()->back();
    }

    public function getNhanXetHocVien(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getCapNhatKetQuaHocTapHocVien();
        if($quyenChiTiet==1)
        {
            $id = $request->get('id');
            $type = $request->get('type');
            $classStudent = DB::table('st_class_student')
            ->join('st_class','st_class.class_id','=','st_class_student.class_id')
            ->join('st_student','st_student.student_id','=','st_class_student.student_id')
            ->where('classStudent_id',$id)
            ->get()
            ->first();

            $nhanXetLop = DB::table('view_learning_comment')
            ->where('learningOutcomeType_id',$type)
            ->orderBy('comment_id')
            ->get();
            $ketQuaNhanXet = [];
            foreach($nhanXetLop as $item)
            {
                $ketQua = DB::table('st_class_student_comment')
                ->where('classStudent_id',$id)
                ->where('commentDetail_id',$item->commentDetail_id)
                ->where('learningOutcomeType_id',$type)
                ->get()->first();
                if(isset($ketQua))
                {
                    $ketQuaNhanXet[]=['ketQua'=>$ketQua->classStudentComment_result];
                }
                else
                {
                    $ketQuaNhanXet[]=['ketQua'=>""];
                }
            }

            

            return view('LopHoc.nhanXetHocVien')
            ->with('classStudent',$classStudent)
            ->with('nhanXetLop',$nhanXetLop)
            ->with('ketQuaNhanXet',$ketQuaNhanXet)
            ->with('type',$type)
            ;
        }
        else
        {
            return redirect()->back();
        }
    }


    public function postNhanXetHocVien(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getCapNhatKetQuaHocTapHocVien();
            if($quyenChiTiet==1)
            {
                try
                {
                    $id = $request->get('id');
                    $id2 = $request->get('id2');
                    $nhanXet = $request->get('nhanXet');
                    $type = $request->get('type');
                    $nhanXetHocVien = DB::table('st_class_student_comment')
                    ->where('classStudent_id',$id)
                    ->where('commentDetail_id',$id2)
                    ->where('learningOutcomeType_id',$type)
                    ->get()->first();
                    if(isset($nhanXetHocVien))
                    {
                        DB::table('st_class_student_comment')
                        ->where('classStudent_id',$id)
                        ->where('commentDetail_id',$id2)
                        ->where('learningOutcomeType_id',$type)
                        ->update([
                            'classStudentComment_result'=>$nhanXet
                        ]);
                    }
                    else
                    {
                        DB::table('st_class_student_comment')
                        ->insert([
                            'classStudent_id'=>$id,
                            'commentDetail_id'=>$id2,
                            'classStudentComment_result'=>$nhanXet,
                            'learningOutcomeType_id'=>$type
                        ]);
                    }
    
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
    public function getLoaiKetQuaHocTapHocVien(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getCapNhatKetQuaHocTapHocVien();
        if($quyenChiTiet==1)
        {
            $id = $request->get('id');
            $classStudent = DB::table('st_class_student')
            ->join('st_class','st_class.class_id','=','st_class_student.class_id')
            ->where('classStudent_id',$id)
            ->select('st_class.course_id')
            ->get()->first();
            $khoaHoc = DB::table('st_course')
                ->where('course_id', $classStudent->course_id)
                ->get()->first();
            $ketQuaHocTap = DB::table('st_learning_outcome_type')
                ->where('course_id', $classStudent->course_id)
                ->get();

            $arrKetQua=[];
           
            foreach($ketQuaHocTap as $item)
            {
              $ketQua = DB::table('st_learning_outcomes')
              ->where('learningOutcomeType_id',$item->learningOutcomeType_id)
              ->get();
                
                $diemKetQua = 0;
                $soLuongKetQua =0;
                $phanTram=0;
                foreach($ketQua as $item2)
                {
                    $diemHocTap = DB::table('st_learning_outcomes_student')
                    ->where('learningOutcome_id',$item2->learningOutcome_id)
                    ->where('classStudent_id',$id)
                    ->get()->first();

                    if(isset($diemHocTap))
                    {
                        if($item2->learningOutcome_type==1)
                        {
                            $diemKetQua += $diemHocTap->learningOutcomeStudent_comment/$item2->learningOutcome_point;
                        }
                    }
                   
                }
                $soLuongKetQua = count($ketQua);
                
                if($soLuongKetQua>0)
                $phanTram = ($diemKetQua/$soLuongKetQua)*$item->learningOutcomeType_percent;


                $arrKetQua[]=[
                    'phanTram'=>$phanTram
                ];
            }

            return view('LopHoc.LoaiKetQuaHocTap')
                ->with('khoaHoc', $khoaHoc)
                ->with('id', $id)
                ->with('arrKetQua', $arrKetQua)
                ->with('ketQuaHocTap', $ketQuaHocTap);
        }
        else
        {
            return redirect()->back();
        }
    }

    public function xuatKetQuaHocVien(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->get('id');
            $type = $request->get('type');
            $classStudent = DB::table('st_class_student')
            ->join('st_class','st_class.class_id','=','st_class_student.class_id')
            ->join('st_student','st_student.student_id','=','st_class_student.student_id')
            ->where('classStudent_id',$id)
            ->get()
            ->first();

           
            if(isset($classStudent))
            {
                $hocVien = $classStudent->student_firstName." ".$classStudent->student_lastName;
                $khoaHoc = DB::table('st_study_program')
                ->join('st_course','st_course.studyProgram_id','=','st_study_program.studyProgram_id')
                ->where('st_course.course_id',$classStudent->course_id)
                ->get()->first();
                if(isset($khoaHoc))
                {
                    $lop = $khoaHoc->studyProgram_name." ".$khoaHoc->course_name;
                    $CTH = $khoaHoc->studyProgram_name;
                }
                else
                {
                    $lop = "";
                    $CTH ="";
                }
                $thoiGian = date('d/m/Y',strtotime($classStudent->class_startDay)) ." - " . date('d/m/Y',strtotime($classStudent->class_endDay));

                $loaiKetQua = DB::table('st_learning_outcome_type')
                ->where('learningOutcomeType_id',$type)
                ->get()->first();

                if(isset($loaiKetQua))
                {
                    $tenLoaiKetQua = $loaiKetQua->learningOutcomeType_name;
                }
                else
                {
                    $tenLoaiKetQua="";
                }


                $ketQuaHocTap = DB::table('st_learning_outcomes')
                ->where('learningOutcomeType_id',$type)
                ->get();

                $diemSo = "";
                $tongDiem =0;
                $diem = 0;
                foreach($ketQuaHocTap as $item)
                {
                    $diemKetQua = DB::table('st_learning_outcomes_student')
                    ->where('classStudent_id',$id)
                    ->where('learningOutcome_id',$item->learningOutcome_id)
                    ->get()->first();
                    if($item->learningOutcome_type==1)
                    {
                        $tongDiem += $item->learningOutcome_point;
                    }
                    


                    if(isset($diemKetQua))
                    {
                        $diemHocVien = $diemKetQua->learningOutcomeStudent_comment;
                        if($item->learningOutcome_type==1)
                        {
                            $diem +=$diemKetQua->learningOutcomeStudent_comment;
                        }
                    }
                    else
                    {
                        $diemHocVien ="";
                    }
                    $diemSo.='<div style="display:inline-block;width:40%">'
                    .$item->learningOutcome_name.': '.$diemHocVien.'/'.$item->learningOutcome_point.'</div>';
                }
                if($tongDiem>0)
                $phanTram = round($diem/$tongDiem*100,0);
                else
                {
                    $phanTram = $diem*100;
                }
                $diemSo.='<div style="display:inline-block;width:40%">
                TOTAL MARK/TỔNG ĐIỂM: '.$diem.'/'.$tongDiem.'</div>';
                $diemSo.='<div style="display:inline-block;width:40%">
                PERCENTAGE: '.$phanTram.'%</div>';
                
                $nhanXetLopHoc = DB::table('st_learning_outcome_type_comment')
                ->join('st_comment_detail','st_comment_detail.commentDetail_id',
                '=','st_learning_outcome_type_comment.commentDetail_id')
                ->join('st_comment','st_comment.comment_id',
                '=','st_comment_detail.comment_id')
                ->where('learningOutcomeType_id',$type)
                ->get();
                $arrComment=[];
                $arrCommentDetail=[];
                foreach($nhanXetLopHoc as $item)
                {
                    $kiemTra=0;
                    foreach($arrComment as $item2)
                    {
                        if($item2['idComment']==$item->comment_id)
                        {
                            $kiemTra=1;
                        }

                    }
                    if($kiemTra == 0)
                    {
                        $arrComment[]=[
                            'idComment'=>$item->comment_id,
                            'tenComment'=>$item->comment_name
                        ];
                    }
                    $nhanXetHocVien = DB::table('st_class_student_comment')
                    ->where('commentDetail_id',$item->commentDetail_id)
                    ->where('classStudent_id',$id)
                    ->where('learningOutcomeType_id',$type)
                    ->get()->first();
                    if(isset($nhanXetHocVien))
                    {
                        if(is_numeric($nhanXetHocVien->classStudentComment_result))
                        {
                            $nhanXet = DB::table('st_comment_result')
                            ->where('commentDetail_id',$item->commentDetail_id)
                            ->where('commentResult_number',$nhanXetHocVien->classStudentComment_result)
                            ->get()->first();
                            if(isset($nhanXet))
                            {
                                $ketQuaNhanXet=$nhanXet->commentResult_name;
                            }
                            else
                            {
                                $ketQuaNhanXet=$nhanXetHocVien->classStudentComment_result;
                            }
                        }
                        else
                        {
                            $ketQuaNhanXet=$nhanXetHocVien->classStudentComment_result;
                        }
                        
                    }
                    else
                    {
                        $ketQuaNhanXet="";
                    }

                    $arrCommentDetail []= [
                        'idComment'=>$item->comment_id,
                        'tenCommentDetail'=>$item->commentDetail_name,
                        'ketQua'=>$ketQuaNhanXet
                    ];
                }

                $duLieuNhanXet = "";
                foreach($arrComment as $item1)
                {
                    $duLieuNhanXet.=$item1['tenComment']."<br>";
                    $duLieuNhanXet.="<table>
                    <thead></thead>
                    <tbody>";
                    $i=1;
                    foreach($arrCommentDetail as $item2)
                    {
                        if($item1['idComment']==$item2['idComment'])
                        {
                            $duLieuNhanXet.="<tr>
                            <td style='width:20px;height:30px'>  &nbsp;".$i."</td>
                            <td style='width:400px'>  &nbsp;".$item2['tenCommentDetail']."</td>
                            <td style='width:400px'>  &nbsp;".$item2['ketQua']."</td>
                            </tr>";
                            $i++;
                        }
                      
                    }
                    $duLieuNhanXet.="</tbody>
                    </table>";
                }

                $arr[]=[
                    'tenLoai'=>$tenLoaiKetQua,
                    'tenHV'=>$hocVien,
                    'lop'=>$lop,
                    'CTH'=>$CTH,
                    'thoiGian'=>$thoiGian,
                    'diemSo'=>$diemSo,
                    'diem'=>$diem,
                    'tongDiem'=>$tongDiem,
                    'duLieuNhanXet'=>$duLieuNhanXet
                ];



                return response($arr);
            }
        }
    }


    public function getKetQuaHocTapHocVien(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getCapNhatKetQuaHocTapHocVien();
        if($quyenChiTiet==1)
        {
            $idClassStudent = $request->get('id');
            $type = $request->get('type');
            $lopHoc =DB::table('st_learning_outcomes')
            ->where('learningOutcomeType_id',$type)
            ->get();

            $hocVien = DB::table('st_class_student')
            ->join('st_student','st_student.student_id','=',
            'st_class_student.student_id')
            ->where('st_class_student.classStudent_id',$idClassStudent)
            ->get()
            ->first();
            $arrKetQua =[];
            foreach($lopHoc as $item)
            {
                $ketQuaHocTap = DB::table('st_learning_outcomes_student')
                ->where('learningOutcome_id',$item->learningOutcome_id)
                ->where('classStudent_id',$idClassStudent)
                ->get()->first()
                ;
                if(isset($ketQuaHocTap))
                {
                    $ketQua = $ketQuaHocTap->learningOutcomeStudent_comment;
                }
                else
                {
                    $ketQua="";
                }

                $arrKetQua[]=[
                    'learningOutcome_id'=>$item->learningOutcome_id,
                    'learningOutcome_name'=>$item->learningOutcome_name,
                    'learningOutcome_commnet'=>$ketQua,
                    'learningOutcome_type'=>$item->learningOutcome_type,
                    'learningOutcome_point'=>$item->learningOutcome_point
                ];

            }
            return view('LopHoc.ketQuaHocTap')
            ->with('id',$idClassStudent)
            ->with('type',$type)
            ->with('arrKetQua',$arrKetQua)
            ->with('hocVien',$hocVien);


        }
        else
        {
            return redirect()->back();
        }
    }

    public function postCapNhatKetQuaHocVien(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getCapNhatKetQuaHocTapHocVien();
            if($quyenChiTiet==1)
            {
                try
                {
                    $id = $request->get('id');
                    $idClassStudent = $request->get('idClassStudent');
                    $diem = $request->get('diem');

                    $ketQua = DB::table('st_learning_outcomes_student')
                    ->where('learningOutcome_id',$id)
                    ->where('classStudent_id',$idClassStudent)
                    ->get()->first();
                    if(isset($ketQua))
                    {
                        DB::table('st_learning_outcomes_student')
                        ->where('learningOutcome_id',$id)
                        ->where('classStudent_id',$idClassStudent)
                        ->update([
                            'learningOutcomeStudent_comment'=>$diem
                        ]);
                    }
                    else
                    {
                        DB::table('st_learning_outcomes_student')
                        ->insert([
                            'learningOutcome_id'=>$id,
                            'classStudent_id'=>$idClassStudent,
                            'learningOutcomeStudent_comment'=>$diem
                        ]);
                    }

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

    public function exportKetQuaHocTap(Request $request) 
    {
        $id = $request->get('id');
        session(['idLopHoc'=>$id]);
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
