<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class phongVanController extends Controller
{
    public function getPhongVan()
    {
        $quyen = new quyenController();
        $quyenXemPV = $quyen->getXemPhongVan();
        if ($quyenXemPV == 1) {
            $lay = $quyen->layDuLieu();
            $phongVan = DB::table('view_phong_van')
            ->orderByDesc('placementTest_dateTime')
           
            ->take($lay)
            ->skip(0)
            ->get();
          
          
            $phongVanTong = DB::table('view_phong_van')
            ->orderByDesc('placementTest_dateTime')
           
                ->select('placementTest_id')
                ->get();
            
            $soHocVien = count($phongVanTong);
            $soTrang = (int) $soHocVien / $lay;
            if ($soHocVien % $lay > 0)
                $soTrang++;


            return view('PhongVan.phongVan')
                ->with('phongVan', $phongVan)
                ->with('soTrang', $soTrang)
                ->with('page', 1)
                ;
        } else
        return redirect()->back();
    }

    public function getThemPhongVan(Request $request)
    {
        $quyen = new quyenController();
        $quyenThemPV = $quyen->getThemPhongVan();
        if ($quyenThemPV == 1) {
            $id = $request->get('id');
            $hocVien = DB::table('st_student')
                ->where('student_id',$id)
                ->get()
                ->first();
            $giaoVien = DB::table('st_employee')
            ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
            '=','st_employee.employee_id')
            ->where('st_quyen_chi_tiet_quyen.quyen_id',213)
            ->where('st_quyen_chi_tiet_quyen.chiTietQuyen_id',1)
            ->where('st_quyen_chi_tiet_quyen.quyen_chiTietQuyen_trangThai',1)
            ->get();
            $chuongTrinhHoc = DB::table('st_study_program')
            ->get();
            return view('PhongVan.themPhongVan')
                ->with('giaoVien', $giaoVien)
                ->with('chuongTrinhHoc', $chuongTrinhHoc)
                ->with('hocVien', $hocVien);
    } else
        return redirect()->back();
    }
    public function kiemTraGiaoVienphongVan(Request $request)
    {
        if($request->ajax())
        {
            $giaoVien = $request->get('giaoVien');
            $thoiGian = $request->get('thoiGian');
            $time = $request->get('time');
            $ngay = substr($thoiGian,3,2);
            $thang = substr($thoiGian,0,2);
            $nam = substr($thoiGian,6,4);
            $thoiGianstr = $nam."-".$thang."-".$ngay." ".$time;
            $thoiGianPT= new Carbon($thoiGianstr);

            $lich = DB::table('st_class_time_employee')
            ->join('st_employee','st_employee.employee_id',
            '=','st_class_time_employee.employee_id')
            ->join('st_class_time','st_class_time.classTime_id',
            '=','st_class_time_employee.classTime_id')
            ->where('st_class_time.classTime_startDate','<=',$thoiGianPT)
            ->where('st_class_time.classTime_endDate','>=',$thoiGianPT)
            ->where('st_employee.employee_id',$giaoVien)
            ->get()->first();
            if(isset($lich))
            {
                return response(0);
            }
            else
            {
                return response(1);
            }
        }

    }
    public function getDuLieuLichPT(Request $request)
    {
        if($request->ajax())
        {
            $thoiGian = $request->get('thoiGian');
            $ngay = substr($thoiGian,3,2);
            $thang = substr($thoiGian,0,2);
            $nam = substr($thoiGian,6,4);
            $thoiGianPT = $nam."-".$thang."-".$ngay;
            $now = Carbon::now();
            $lich = DB::table('st_class_time_employee')
            ->join('st_employee','st_employee.employee_id',
            '=','st_class_time_employee.employee_id')
            ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
            '=','st_employee.employee_id')
            ->join('st_class_time','st_class_time.classTime_id',
            '=','st_class_time_employee.classTime_id')
            ->where('st_quyen_chi_tiet_quyen.quyen_id',213)
            ->where('st_quyen_chi_tiet_quyen.chiTietQuyen_id',1)
            ->where('st_quyen_chi_tiet_quyen.quyen_chiTietQuyen_trangThai',1)
            ->whereDate('st_class_time.classTime_startDate',$thoiGianPT)
            ->get();

            $i =1;
            $out="";
            foreach($lich as $item)
            {
                $out.="<tr>
                <td>".$i."</td>
                <td>".$item->employee_name."</td>
                <td>Đứng lớp</td>
                <td>".date('H:i',strtotime($item->classTime_startDate))." ".date('H:i',strtotime($item->classTime_endDate))."</td>    
                </tr>";
                $i++;
            }
            return response($out);
        }
    }

    public function getCapNhatPhongVan(Request $request)
    {
        $quyen = new quyenController();
        $quyenSuaPV = $quyen->getSuaPhongVan();
        if ($quyenSuaPV == 1) {
            $id = $request->get('id');
           
            $phongVan = DB::table('view_phong_van')
            ->where('placementTest_id',$id)
            ->get()->first();

            $giaoVien = DB::table('st_employee')
            ->join('st_quyen_chi_tiet_quyen','st_quyen_chi_tiet_quyen.employee_id',
            '=','st_employee.employee_id')
            ->where('st_quyen_chi_tiet_quyen.quyen_id',213)
            ->where('st_quyen_chi_tiet_quyen.chiTietQuyen_id',1)
            ->where('st_quyen_chi_tiet_quyen.quyen_chiTietQuyen_trangThai',1)
            ->get();
            $chuongTrinhHoc = DB::table('st_study_program')
            ->get();
            return view('PhongVan.capNhatPhongVan')
                ->with('giaoVien', $giaoVien)
                ->with('chuongTrinhHoc', $chuongTrinhHoc)
                ->with('phongVan', $phongVan);
        } else
            return redirect()->back();
    }

    public function postThemPhongVan(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenThemPV = $quyen->getThemPhongVan();
            if ($quyenThemPV == 1) {
                $id = $request->get('id');
                $date = $request->get('date');
                $time = $request->get('time');
                $giaoVien = $request->get('giaoVien');
                $khoaHoc = $request->get('khoaHoc');
                $note = $request->get('note');
                $ngay = substr($date,3,2);
                $thang = substr($date,0,2);
                $nam = substr($date,6,4);
                $ngayChinh = $nam."-".$thang."-".$ngay;
                try
                {
                    DB::table('st_placement_test')
                    ->insert([
                        'student_id'=>$id,
                        'employee_id'=>$giaoVien,
                        'studyProgram_id'=>$khoaHoc,
                        'placementTest_dateTime'=>$ngayChinh." ".$time,
                        'placementTest_note'=>$note,
                        'placementTest_reading'=>"",
                        'placementTest_writing'=>"",
                        'placementTest_listening'=>"",
                        'placementTest_speaking'=>"",
                        'course_id'=>0,
                        'course_id2'=>0,
                        'placementTest_status'=>0,
                        'placementTest_reason'=>"",
                        'placementTest_classStatus'=>0
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
    public function postCapNhatPhongVan(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenSuaPV = $quyen->getSuaPhongVan();
            if ($quyenSuaPV == 1) {
                $id = $request->get('id');
                $date = $request->get('date');
                $time = $request->get('time');
                $giaoVien = $request->get('giaoVien');
                $khoaHoc = $request->get('khoaHoc');
                $note = $request->get('note');
                $ngay = substr($date,3,2);
                $thang = substr($date,0,2);
                $nam = substr($date,6,4);
                $ngayChinh = $nam."-".$thang."-".$ngay;
                try
                {
                    DB::table('st_placement_test')
                    ->where('placementTest_id',$id)
                    ->update([
                        'employee_id'=>$giaoVien,
                        'studyProgram_id'=>$khoaHoc,
                        'placementTest_dateTime'=>$ngayChinh." ".$time,
                        'placementTest_note'=>$note
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
    public function getXoaPhongVan(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXoaPV = $quyen->getXoaPhongVan();
            if ($quyenXoaPV == 1) {
                $id = $request->get('id');
                try
                {
                    DB::table('st_placement_test')
                    ->where('placementTest_id',$id)
                    ->de();
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
    public function getCapNhatKetQuaPhongVan(Request $request)
    {
        $quyen = new quyenController();
        $quyenKetQuaPV = $quyen->geCapNhatKetQuaPhongVan();
        if ($quyenKetQuaPV == 1) {
            $id = $request->get('id');
           
            $phongVan = DB::table('st_placement_test')
            ->join('st_student','st_student.student_id','=','st_placement_test.student_id')
            ->where('placementTest_id',$id)
            ->select('st_student.student_phone','st_student.student_firstName',
            'st_student.student_lastName','st_placement_test.*')
            ->get()->first();

            $khoaHoc = DB::table('st_course')
            ->join('st_study_program','st_study_program.studyProgram_id',
            '=','st_course.studyProgram_id')
            ->where('st_study_program.studyProgram_id',$phongVan->studyProgram_id)
            ->get();
            $khoaHocDau = $khoaHoc->first();
            if(isset($khoaHocDau))

         
            return view('PhongVan.ketQuaPhongVan')
                ->with('phongVan', $phongVan)
                ->with('khoaHoc', $khoaHoc)
              
                ;
        } else
            return redirect()->back();
    }
    public function postCapNhatKetQuaPhongVan(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenKetQuaPV = $quyen->geCapNhatKetQuaPhongVan();
            if ($quyenKetQuaPV == 1) {
                $reading = "";
                $writing = "";
                $listening = "";
                $speaking = "";
                $level = "";
                $status = 0;
                $note = "";

                $id = $request->get('id');
                $reading = $request->get('reading');
                $writing = $request->get('writing');
                $listening = $request->get('listening');
                $speaking = $request->get('speaking');
                $khoaHoc1 = $request->get('khoaHoc1');
                $khoaHoc2 = $request->get('khoaHoc2');
                $status = $request->get('status');
                $note = $request->get('detail');
                if($note=="")
                $note="";
                try
                {
                    DB::table('st_placement_test')
                    ->where('placementTest_id',$id)
                    ->update([
                        'placementTest_reading'=>$reading,
                        'placementTest_writing'=>$writing,
                        'placementTest_listening'=>$listening,
                        'placementTest_speaking'=>$speaking,
                        'course_id'=>$khoaHoc1,
                        'course_id2'=>$khoaHoc2,
                        'placementTest_status'=>$status,
                        'placementTest_reason'=>$note
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

    public function searchPhongVan(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
           
            if ($value == "")
                $phongVan = DB::table('view_phong_van')
               
                    ->take($lay)
                   ->orderByDesc('placementTest_dateTime')
                    ->skip(($page - 1) * $lay)
                    ->get();
            else
                $phongVan = DB::table('view_phong_van')
                   
                    ->where(function($query) use ($value)
                    {
                       $query->where('student_firstName', 'like', '%' . $value . '%')
                        ->orwhere('student_lastName', 'like', '%' . $value . '%')
                        ->orwhere('student_lastNameHidden', 'like', '%' . $value . '%');
                    })
                    ->take($lay)
                   ->orderByDesc('placementTest_dateTime')
                    ->skip(($page - 1) * $lay)
                    ->get();

            $out = "";
            $i = 1;
            foreach ($phongVan as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td><a href=\'' . route('getChiTietHocVien') . '?id=' . $item->student_id . '\'>' . $item->student_firstName . ' ' . $item->student_lastName . '</a></td>
                <td>' . $item->student_phone . '</td>
                <td>' . $item->course_name . '</td>
                <td>' . date('H:i d/m/Y', strtotime($item->placementTest_dateTime)) . '</td>
                <td>' . $item->employee_name . '</td>
                <td><a href=\'' . route('getCapNhatKetQuaPhongVan') . '?id=' . $item->placementTest_id . '\'>Chi tiết</a></td>
                <td><a class="btn" href=\'' . route('getCapNhatPhongVan') . '?id=' . $item->placementTest_id . '\'>
                        <i style="color: blue" class="fa fa-edit"></i>
                                        </a></td>
                                    <td>
                                        <a class="btn" onclick="xoa(\'' . $item->placementTest_id . '\');">
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
