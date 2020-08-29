<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class choLopController extends Controller
{
    public function getChoMoLop()
    {
        $quyen = new quyenController();
        $quyenXem = $quyen->getXemChoMoLop();
        if ($quyenXem == 1) {
            $chuongTrinhHoc = DB::table('st_study_program')
            ->orderBy('studyProgram_number')
            ->get();
            $idChuongTrinh=0;
            if(count($chuongTrinhHoc)>0)
            {
                $chuongTrinhHocDau = $chuongTrinhHoc->first();
                $idChuongTrinh = $chuongTrinhHocDau->studyProgram_id;
            }
            $khoaHoc = DB::table('st_course')
            ->where('studyProgram_id',$idChuongTrinh)
            ->orderBy('course_number')
            ->get();
            $khoaHocDau = $khoaHoc->first();
            $idkhoaHoc = $khoaHocDau->course_id;
            
            $phongVan = DB::table('st_placement_test')
            ->join('st_student','st_student.student_id','=','st_placement_test.student_id')
            ->where('st_placement_test.placementTest_status','!=',0)
            ->where('placementTest_classStatus',0)
            ->where(function ($query) use ($idkhoaHoc){
                $query->where('st_placement_test.course_id',$idkhoaHoc)
                ->orWhere('st_placement_test.course_id2',$idkhoaHoc);
            })
            ->get();
            $hocThu = DB::table('view_class_student')
            ->where('course_id',$idkhoaHoc)
            ->where('classStudent_status',0)
            ->get();


           
            return view('ChoMoLop.choMoLop')
                ->with('khoaHoc', $khoaHoc)
                ->with('hocThu', $hocThu)
                ->with('idkhoaHoc', $idkhoaHoc)
                ->with('phongVan', $phongVan)
                ->with('chuongTrinhHoc', $chuongTrinhHoc);
        } 
        else 
        return redirect()->back();
    }

    public function searchCTHChoMoLop(Request $request)
    {
        if($request->ajax())
        {
            $idChuongTrinh = $request->get('chuongTrinhHoc');
            $khoaHoc = DB::table('st_course')
            ->where('studyProgram_id',$idChuongTrinh)
            ->orderBy('course_number')
            ->get();
            $idkhoaHoc=0;
            if(count($khoaHoc)>0)
            {
                $khoaHocDau = $khoaHoc->first();
                $idkhoaHoc = $khoaHocDau->course_id;
            }
           
            
            $phongVan = DB::table('st_placement_test')
            ->join('st_student','st_student.student_id','=','st_placement_test.student_id')
            ->where('st_placement_test.placementTest_status','!=',0)
            ->where('placementTest_classStatus',0)
            ->where(function ($query) use ($idkhoaHoc){
                $query->where('st_placement_test.course_id',$idkhoaHoc)
                ->orWhere('st_placement_test.course_id2',$idkhoaHoc);
            })
            ->get();
            $hocThu = DB::table('view_class_student')
            ->where('course_id',$idkhoaHoc)
            ->where('classStudent_status',0)
            ->get();

            $outKhoaHoc = ' <select class="form-control" id="khoaHoc" name="khoaHoc" onchange="changeKH();">';
            foreach($khoaHoc as $item)
                    $outKhoaHoc .='<option value="'.$item->course_id.'">'.$item->course_name.'</option>';
            $outKhoaHoc .= ' </select>';

            $i=1;
            $outDuLieu="";
            foreach($phongVan as $item)
            {

                $outDuLieu.='<tr><td>'. $i.'</td>
                <td>'.$item->student_firstName.' '.$item->student_lastName.'</td>
                <td>'.$item->student_phone.'</td>
                <td>'.$item->student_parentPhone.'</td>
                <td>'.date("d/m/Y",strtotime($item->student_birthDay)) .'</td>
                <td>'.$item->student_address.'</td>';
                if($item->course_id==$idkhoaHoc)
                $outDuLieu.='<td>PT chính</td>';
                else
                $outDuLieu.='<td>PT phụ</td>';
               $outDuLieu.='</tr>';
                $i++;
            }

            foreach($hocThu as $item)
            {

                $outDuLieu.='<td>'. $i.'</td>
                <td>'.$item->student_firstName.' '.$item->student_lastName.'</td>
                <td>'.$item->student_phone.'</td>
                <td>'.$item->student_parentPhone.'</td>
                <td>'.date("d/m/Y",strtotime($item->student_birthDay)) .'</td>
                <td>'.$item->student_address.'</td>
                <td>Học thử</td></tr>';
              
               
                $i++;
            }
            $arr[]=[
                'khoaHoc'=>$outKhoaHoc,
                'duLieu'=>$outDuLieu
            ];
            return response($arr);
        }
    }

    public function searchKHChoMoLop(Request $request)
    {
        if($request->ajax())
        {
            $idkhoaHoc = $request->get('khoaHoc');
           
            
            $phongVan = DB::table('st_placement_test')
            ->join('st_student','st_student.student_id','=','st_placement_test.student_id')
            ->where('st_placement_test.placementTest_status','!=',0)
            ->where('placementTest_classStatus',0)
            ->where(function ($query) use ($idkhoaHoc){
                $query->where('st_placement_test.course_id',$idkhoaHoc)
                ->orWhere('st_placement_test.course_id2',$idkhoaHoc);
            })
            ->get();
            
            $hocThu = DB::table('view_class_student')
            ->where('course_id',$idkhoaHoc)
            ->where('classStudent_status',0)
            ->get();
            $i=1;
            $outDuLieu="";
            foreach($phongVan as $item)
            {

                $outDuLieu.='<tr><td>'. $i.'</td>
                <td>'.$item->student_firstName.' '.$item->student_lastName.'</td>
                <td>'.$item->student_phone.'</td>
                <td>'.$item->student_parentPhone.'</td>
                <td>'.date("d/m/Y",strtotime($item->student_birthDay)) .'</td>
                <td>'.$item->student_address.'</td>';
                if($item->course_id==$idkhoaHoc)
                $outDuLieu.='<td>PT chính</td>';
                else
                $outDuLieu.='<td>PT phụ</td>';
                $outDuLieu.='</tr>';
                $i++;
            }

            foreach($hocThu as $item)
            {

                $outDuLieu.='<tr><td>'. $i.'</td>
                <td>'.$item->student_firstName.' '.$item->student_lastName.'</td>
                <td>'.$item->student_phone.'</td>
                <td>'.$item->student_parentPhone.'</td>
                <td>'.date("d/m/Y",strtotime($item->student_birthDay)) .'</td>
                <td>'.$item->student_address.'</td>
                <td>Học thử</td></tr>';
                $i++;
            }
           
            return response($outDuLieu);
        }
    }
    
}
