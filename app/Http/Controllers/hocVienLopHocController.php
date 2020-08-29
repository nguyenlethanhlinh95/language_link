<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class hocVienLopHocController extends Controller
{
    public function getHocVienLopHoc(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemHocVienLopHoc();
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        if ($quyenChiTiet == 1) {
            $id= $request->get('id');
            $lay = $quyen->layDuLieu();

            $lopHocTong = DB::table('st_class_student')
                ->join('st_student','st_student.student_id','=','st_class_student.student_id')
                ->where('st_class_student.class_id',$id)
                ->orderBy('st_student.student_lastName')
                ->select('class_id')
                ->get();
            $lopHoc=DB::table('st_class')
            ->where('class_id',$id)
            ->get()->first();

            $lopHocDoi =DB::table('st_class')
            ->where('class_id','!=',$id)
            ->where('class_status',1)
            ->where('class_endDay','>',$now)
            ->where('course_id',$lopHoc->course_id)
            ->get();

            $giaoVien = DB::table('st_class_employee')
            ->join('st_employee','st_employee.employee_id','=','st_class_employee.employee_id')
            ->where('st_class_employee.class_id',$id)
            ->get()->first();
            if(isset($giaoVien))
            $tenGiaoVien = $giaoVien->employee_name;
            else
            $tenGiaoVien="";

            $soKM = count($lopHocTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;


                $buoiHoc = DB::table('st_class_time')
                ->where('class_id',$id)
                ->orderBy('classTime_startDate')
                ->get();

                $soBuoiHoc = 1;
                $arrBuoiHoc=[];
                $arrCountBuoi=[]; 
                $gioiHan = 10;
                $dem=1;
               foreach($buoiHoc as $item)
               {
                    if($dem>$gioiHan)
                    {
                        $dem=1;
                        $soBuoiHoc++;
                    }

                    $arrBuoiHoc[]=[
                        'soBuoi'=>$soBuoiHoc,
                        'ngay'=>date('d/m',strtotime( $item->classTime_startDate)),
                        'id'=>$item->classTime_id
                    ];

                    $dem++;
                   
               }



                $danhSachHocVien = DB::table('st_student')
                ->join('st_branch','st_branch.branch_id','=','st_student.branch_id')
                ->where('st_student.student_status',1)
                ->orderBy('st_student.student_lastName')
                ->get();

            $hocVien=  DB::table('st_class_student')
            ->join('st_student','st_student.student_id','=','st_class_student.student_id')
          
            ->where('st_class_student.class_id',$id)
            ->orderBy('st_student.student_lastName')
            // ->take($lay)
            // ->skip(0)
           
            ->get();


            $arrHocVien = [];
            $arrDiemDanhDau=[];
            $arrDiemDanhSau=[];
            $arrDiemDanh=[];
            
            foreach($hocVien as $item)
            {
                $dem=1;
                $soBuoiHoc=1;
                foreach($buoiHoc as $item2)
                {
                    $diemDanh = DB::table('st_class_time_student')
                    ->where('student_id',$item->student_id)
                    ->where('classTime_id',$item2->classTime_id)
                    ->get()
                    ->first();
                    if($dem>$gioiHan)
                    {
                        $dem=1;
                        $soBuoiHoc++;
                    }
                    if(isset($diemDanh))
                    {
                        $arrDiemDanh[]=[
                            'idHocVien'=>$item->student_id,
                            'classTime_id'=>$item2->classTime_id,
                            'idDiemDanh'=>$diemDanh->classTimeStudent_id,
                            'trangThai'=>$diemDanh->classTimeStudent_status,
                            'soBuoi'=>$soBuoiHoc,
                            'ngay'=>date('d/m',strtotime( $item2->classTime_startDate))
                        ];
                    }
                    else
                    {
                        $arrDiemDanh[]=[
                            'idHocVien'=>$item->student_id,
                            'classTime_id'=>$item2->classTime_id,
                            'idDiemDanh'=>0,
                            'trangThai'=>"",
                            'soBuoi'=>$soBuoiHoc,
                            'ngay'=>date('d/m',strtotime( $item2->classTime_startDate))
                        ];
                    }
                    $dem++;
                }
                $idPhieu=0;
                if($item->classStudent_status==1)
                {
                    $hocPhi =  DB::table('st_receipt_detail')
                    ->join('st_receipt','st_receipt.receipt_id','=','st_receipt_detail.receipt_id')
                    ->join('st_branch','st_branch.branch_id','=','st_receipt.branch_id')
                    ->where('st_receipt_detail.class_id',$item->class_id)
                    ->where('st_receipt.student_id',$item->student_id)
                    ->select('st_branch.branch_code','st_receipt.*','st_receipt_detail.*')
                    ->get()
                    ->first();
                    if(isset($hocPhi))
                    {
                        $trangThai=$hocPhi->branch_code."_".$hocPhi->receipt_number;
                        $idPhieu = $hocPhi->receipt_id;
                    }
                    else
                    $trangThai="";
                }
                else  if($item->classStudent_status==2)
                {
                    $trangThai= "Học Thử";
                }
                else
                {
                    $trangThai = "Học Chờ";
                }
               
                $arrHocVien[]=[
                    'idPhieu'=>$idPhieu,
                    'trangThai'=> $trangThai,
                    'idHocVien'=>$item->student_id,
                    'nickName'=>$item->student_nickName,
                    'tenHocVien'=>$item->student_firstName." ".$item->student_lastName,
                    'sdtHV'=>$item->student_parentPhone,
                    'sdtPH'=>$item->student_phone,
                    'phuHuynh'=>$item->student_parentName,
                    'ngaySinh'=>date('d/m/Y', strtotime($item->student_birthDay)),
                    'idClassStudent'=>$item->classStudent_id
                ];

            }


          
            if($lopHoc->class_status==0)
                $tinhTrang =0;
            else
            {
                if($now<$lopHoc->class_startDay)
                $tinhTrang=1;
                elseif($now>$lopHoc->class_startDay && $now<$lopHoc->class_endDay)
                $tinhTrang =2;
                else
                $tinhTrang=3;
            }
          

            return view('LopHoc.hocVienLopHoc')
            ->with('hocVien',$hocVien)
            ->with('arrHocVien',$arrHocVien)
            ->with('arrDiemDanhDau',$arrDiemDanhDau)
            ->with('arrDiemDanhSau',$arrDiemDanhSau)
            ->with('tenGiaoVien',$tenGiaoVien)
            ->with('lopHoc',$lopHoc)
            ->with('tinhTrang',$tinhTrang)
            ->with('soTrang',$soTrang)
            ->with('danhSachHocVien',$danhSachHocVien)
             ->with('soBuoiHoc',$soBuoiHoc)
             ->with('arrBuoiHoc',$arrBuoiHoc)
             ->with('arrDiemDanh',$arrDiemDanh)
             ->with('lopHocDoi',$lopHocDoi)
            ->with('page',1)
            ;
        }
        else
         return redirect()->back();
    }

    public function getKiemTraTrangThaiHocVien(Request $request)
    {
        
        if($request->ajax())
        {
            $idHocVien = $request->get('idHocVien');
            $idKhoaHoc = $request->get('idKhoaHoc');

            $hocPhi = DB::table('st_receipt_detail')
            ->join('st_receipt','st_receipt.receipt_id','=','st_receipt_detail.receipt_id')
            ->where('st_receipt_detail.course_id',$idKhoaHoc)
            ->where('st_receipt.student_id',$idHocVien)
            ->where('st_receipt_detail.class_id',0)
            ->get()->first();
            if(isset($hocPhi))
            {
                $out="<select class='form-control' id='trangThai' name='trangThai'>
                    <option value='1'>Học chính</option>
                    <option value='2'>Học thử</option>
                </select>";
            }
            else
            {
                $out="<select class='form-control' id='trangThai' name='trangThai'>
                <option value='2'>Học thử</option>
            </select>";
            }

            return response($out);
            
        }
    }

    public function getThongTinLopChuyen(Request $request)
    {
        if($request->ajax())
        {
            $idLopHoc = $request->get('idLopHoc');
            $lopHoc = DB::table('st_class')
            ->where('class_id',$idLopHoc)
            ->get()->first();
            $hocPhi ="";
            $thoiGian="";
            if(isset($lopHoc))
            {
                $hocPhi= number_format($lopHoc->class_price,0,"",".")."đ";
                $thoiGian = date('d/m/Y',strtotime($lopHoc->class_startDay))." - ".date('d/m/Y',strtotime($lopHoc->class_endDay));
            }
            $arr[]=[
                'hocPhi'=>$hocPhi,
                'thoiGian'=>$thoiGian
            ];
            return response($arr);

        }
    }

    public function getXoaHocVienKhoiLopHoc(Request $request)
    {
        if($request->ajax())
        {
            $idLopHoc = $request->get('idLopHoc');
            $idHocVien = $request->get('idHocVien');
            
            try
            {
                $phieuThu = DB::table('st_receipt_detail')
                ->join('st_receipt','st_receipt.receipt_id','=',
                'st_receipt_detail.receipt_id')
                ->where('st_receipt_detail.class_id',$idLopHoc)
                ->where('st_receipt.student_id',$idHocVien)
                ->get()->first();
                if(isset($phieuThu))
                {
                    DB::table('st_receipt_detail')
                    ->where('receiptDeatil_id',$phieuThu->receiptDeatil_id)
                    ->update([
                        'class_id'=>0
                    ]);
                }
                DB::table('st_class_student')
                ->where('class_id',$idLopHoc)
                ->where('student_id',$idHocVien)
                ->delete();

                return response(1);
            }catch(QueryException $ex)
            {
                return response(0);
            }

           

        }
    }

    public function getChuyenLopHoc(Request $request)
    {
        if($request->ajax())
        {
            $idLopHoc = $request->get('idLopHoc');
            $idHocVien = $request->get('idHocVien');
            $lopChuyen = $request->get('lopChuyen');
            try
            {
               
               $hocVienLopMoi = DB::table('view_class_student')
               ->where('class_id',$lopChuyen)
               ->where('student_id',$idHocVien)
               ->get()->first();
                if(isset($hocVienLopMoi))
                {
                    return response(2);
                }
                else
                {
                    $lopCu = DB::table('view_class_student')
                    ->where('class_id',$idLopHoc)
                    ->where('student_id',$idHocVien)
                    ->get()->first();
                    if(isset($lopCu))
                    {
                        $phieuThu = DB::table('st_receipt_detail')
                        ->join('st_receipt','st_receipt.receipt_id','=',
                        'st_receipt_detail.receipt_id')
                        ->where('st_receipt_detail.class_id',$idLopHoc)
                        ->where('st_receipt.student_id',$idHocVien)
                        ->get()->first();
                        if(isset($phieuThu))
                        {
                            DB::table('st_receipt_detail')
                            ->where('receiptDeatil_id',$phieuThu->receiptDeatil_id)
                            ->update([
                                'class_id'=>$lopChuyen
                            ]);
                            DB::table('st_class_student')
                            ->insert([
                                'student_middle'=>"",
                                'student_final'=>"",
                                'student_comment'=>"",
                                'student_id'=>$idHocVien,
                                'class_id'=>$lopChuyen,
                                'classStudent_status'=>1
                            ]);
                            $lopMoi = DB::table('st_class')
                            ->where('class_id',$lopChuyen)
                            ->get()->first();

                            $tienLopCu = $lopCu->class_price;
                            $tienLopMoi =  $lopMoi->class_price;

                            $tienNo = $tienLopCu - $tienLopMoi;

                            $hocVien = DB::table('st_student')
                            ->where('student_id',$idHocVien)
                            ->get()->first();
                            if(isset($hocVien))
                            {
                                DB::table('st_student')
                                ->where('student_id',$idHocVien)
                                ->update([
                                    'student_surplus'=>$hocVien->student_surplus + $tienNo
                                ]);
                            }
                        }
                        else
                        {
                            DB::table('st_class_student')
                            ->insert([
                                'student_middle'=>"",
                                'student_final'=>"",
                                'student_comment'=>"",
                                'student_id'=>$idHocVien,
                                'class_id'=>$lopChuyen,
                                'classStudent_status'=>2
                            ]);
                        }
                        DB::table('st_class_student')
                        ->where('class_id',$idLopHoc)
                        ->where('student_id',$idHocVien)
                        ->delete();

                        return response(1);
                    }
                    else
                    {
                        return response(3);
                    }
                    return response(1);
                }
             
            }catch(QueryException $ex)
            {
                return response(0);
            }

           

        }
    }



    
    public function postThemHocVienVaoLop(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemHocVienLopHoc();
            
            if ($quyenChiTiet == 1) {
                $idHocVien= $request->get('hocVien');
                $trangThai = $request->get('trangThai');
                $idClass = $request->get('id');
                $idKhoaHoc = $request->get('idKhoaHoc');
                $hocVienLopHoc = DB::table('st_class_student')
                ->where('student_id',$idHocVien)
                ->where('class_id',$idClass)
                ->get()->first();
                if(isset($hocVienLopHoc))
                {
                    return response(3);
                }
                else
                {
                    try
                    {
                        DB::table('st_class_student')
                        ->insert([
                            'student_id'=>$idHocVien,
                            'student_middle'=>"",
                            'student_final'=>"",
                            'student_comment'=>"",
                            'class_id'=>$idClass,
                            'classStudent_status'=>$trangThai
    
                        ]); 
                        if($trangThai==1)
                        {
                          $phieuThu=   DB::table('st_receipt_detail')
                          ->join('st_receipt','st_receipt.receipt_id','=','st_receipt_detail.receipt_id')
                          ->where('st_receipt_detail.course_id',$idKhoaHoc)
                          ->where('st_receipt.student_id',$idHocVien)
                          ->where('st_receipt_detail.class_id',0)
                          ->get()
                          ->first();
                          if(isset($phieuThu))
                            DB::table('st_receipt_detail')
                            ->where('receiptDeatil_id',$phieuThu->receiptDeatil_id)
                            ->update([
                                'class_id'=>$idClass
                            ]);
                             DB::table('st_placement_test')
                            ->where('student_id',$idHocVien)
                            ->where(function($query) use ($idKhoaHoc)
                            {
                                $query->where('course_id',$idKhoaHoc)
                                ->orwhere('course_id2',$idKhoaHoc);
                            }
                            )
                            ->update([
                                'placementTest_classStatus'=>1
                            ]);
                            
                        }
    
    
                        return response(1);
                    }catch(QueryException $ex)
                    {
                        return response(0);
                    }
                }
            }
            else
            return response(2);
        }
    }

    public function postDiemDanhHocVien(Request $request)
    {
        if($request->ajax())
        {
            $idHocVien= $request->get('idHocVien');
            $classTime_id= $request->get('idClassTime');
            $trangThai= $request->get('trangThai');
            $late = $request->get('late');

            if($trangThai==1)
            {
                $giaTri="/";
            }
            else if($trangThai==2)
            {
                $giaTri="A";
            }
            else
            {
                $giaTri="L".$late;
            }

            try
            {
                $diemDanh =DB::table('st_class_time_student')
                ->where('classTime_id',$classTime_id)
                ->where('student_id',$idHocVien)
                ->get()->first();
                if(isset($diemDanh))
                {
                    DB::table('st_class_time_student')
                    ->where('classTimeStudent_id',$diemDanh->classTimeStudent_id)
                    ->update([
                        'classTimeStudent_status'=>$giaTri
                    ]);
                }
                else
                {
                    DB::table('st_class_time_student')
                    ->insert([
                        'classTime_id'=>$classTime_id,
                        'student_id'=>$idHocVien,
                        'student_comment'=>"",
                        'classTimeStudent_status'=>$giaTri
                    ]);
                }
                return response(1);
            }catch(QueryException $ex)
            {
                return response(0);
            }
        }
    }
}
