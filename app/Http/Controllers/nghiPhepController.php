<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class nghiPhepController extends Controller
{
    public function getNghiPhep(Request $request)
    {
        $quyen = new quyenController();

        $quyenChiTiet = $quyen->getXemNghiPhep();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $nghiPhepTong  =  DB::table('view_application_leave')
            ->select('applicationLeave_id')
            ->count();

            $nghiPhep  =  DB::table('view_application_leave')
            ->orderBy('department_id')
            ->take($lay)
            ->get();

        
            $phongBan = DB::table('st_department')
            ->get();
            $soKM = $nghiPhepTong;
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
                return view('NghiPhep.nghiPhep')
                ->with('nghiPhep', $nghiPhep)
                ->with('soTrang', $soTrang)
                ->with('phongBan', $phongBan)
                ->with('page', 1);
        }
        else
        {
            return redirect()->back();
        }
    }

    public function postThemNghiPhep(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();

            $quyenChiTiet = $quyen->getThemNghiPhep();
            if($quyenChiTiet==1)
            {
                $phongBan  = $request->get('phongBan');
                $ten  = $request->get('ten');
                $ma  = $request->get('ma');
                $gio  = $request->get('gio');
                $ngayLe  = $request->get('ngayLe');
                $motNgay  = $request->get('motNgay');
                if($ngayLe ==true)
                {
                    $trangThai=1;
                }
                else
                {
                    $trangThai=0;
                }
                if($motNgay ==true)
                {
                    $trangThaiNgay=1;
                }
                else
                {
                    $trangThaiNgay=0;
                }

                try
                {
                    DB::table('st_application_leave')
                    ->insert([
                        'applicationLeave_name'=>$ten,
                        'applicationLeave_code'=>$ma,
                        'applicationLeave_number'=>$gio,
                        'applicationLeave_type'=>$trangThai,
                        'department_id'=>$phongBan,
                        'applicationLeave_isDate'=>$trangThaiNgay
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
    public function postCapNhatNghiPhep(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();

            $quyenChiTiet = $quyen->getSuaNghiPhep();
            if($quyenChiTiet==1)
            {
                $id = $request->get('id');
                $phongBan  = $request->get('phongBan2');
                $ten  = $request->get('ten2');
                $ma  = $request->get('ma2');
                $gio  = $request->get('gio2');
                $ngayLe  = $request->get('ngayLe2');
                $motNgay  = $request->get('motNgay2');
                if($ngayLe ==true)
                {
                    $trangThai=1;
                }
                else
                {
                    $trangThai=0;
                }
                if($motNgay ==true)
                {
                    $trangThaiNgay=1;
                }
                else
                {
                    $trangThaiNgay=0;
                }

                try
                {
                    DB::table('st_application_leave')
                    ->where('applicationLeave_id',$id)
                    ->update([
                        'applicationLeave_name'=>$ten,
                        'applicationLeave_code'=>$ma,
                        'applicationLeave_number'=>$gio,
                        'applicationLeave_type'=>$trangThai,
                        'department_id'=>$phongBan,
                        'applicationLeave_isDate'=>$trangThaiNgay
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

    public function getXoaNghiPhep(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();

            $quyenChiTiet = $quyen->getXoaNghiPhep();
            if($quyenChiTiet==1)
            {
                $id = $request->get('id');
               

                try
                {
                    DB::table('st_application_leave')
                    ->where('applicationLeave_id',$id)
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


    public function getNghiPhepNhanVien(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemNghiPhepNhanVien();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $id = $request->get('id');
            $nhanVien = DB::table('st_employee')
            ->where('employee_id',$id)
            ->get()->first();

            $loaiNghiPhep = DB::table('st_application_leave')
            ->where('department_id',$nhanVien->department_id)
            ->get();

            $nghiPhepTong = DB::table('view_application_leave_employee')
            ->where('employee_id',$id)
            ->count();

            $nghiPhep = DB::table('view_application_leave_employee')
            ->orderByDesc('resignationApplication_date')
            ->where('employee_id',$id)
            ->take($lay)
            ->get();
            $soKM =$nghiPhepTong;
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
            return view('NghiPhep.nghiPhepNhanVien')
            ->with('nhanVien',$nhanVien)
            ->with('nghiPhep',$nghiPhep)
            ->with('soTrang', $soTrang)
            ->with('page', 1)
            ->with('loaiNghiPhep',$loaiNghiPhep)
            ;

        }
        else
        {
            return redirect()->back();
        }
    }

    public function postThemNghiPhepNhanVien(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemNghiPhepNhanVien();
            if($quyenChiTiet==1)
            {
               
            
                try{
                    $loai = $request->get('loai');
                    $id = $request->get('id');
                    $ngay = $request->get('ngayBatDau');
                    $thoiGian = substr($ngay,6,4)."-".substr($ngay,0,2)."-".substr($ngay,3,2);
                    DB::table('st_resignation_application')
                    ->insert([
                        'resignationApplication_date'=>$thoiGian,
                        'applicationLeave_id'=>$loai,
                        'employee_id'=>$id
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
    public function postCapNhatNghiPhepNhanVien(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaNghiPhepNhanVien();
            if($quyenChiTiet==1)
            {
               
            
                try{
                    $loai = $request->get('loai2');
                    $id = $request->get('id2');
                    $ngay = $request->get('ngayBatDau2');
                    $thoiGian = substr($ngay,6,4)."-".substr($ngay,0,2)."-".substr($ngay,3,2);
                    DB::table('st_resignation_application')
                    ->where('resignationApplication_id',$id)
                    ->update([
                        'resignationApplication_date'=>$thoiGian,
                        'applicationLeave_id'=>$loai
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
    public function getXoaNghiPhepNhanVien(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaNghiPhepNhanVien();
            if($quyenChiTiet==1)
            {
               
            
                try{
                  
                    $id = $request->get('id');
                   
                    DB::table('st_resignation_application')
                    ->where('resignationApplication_id',$id)
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


    public function searchNghiPhepNhanVien(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $lay=$quyen->layDuLieu();
            $value = $request->get('value');
            $page=$request->get('page');
            $id = $request->get('id');
            if($value=="")
            $marketing = DB::table('view_application_leave_employee')
            ->orderByDesc('resignationApplication_date')
            ->where('employee_id',$id)
            ->take($lay)
            ->skip(($page-1)*$lay)
            ->get();
            else
            $marketing =DB::table('view_application_leave_employee')
                    ->orderByDesc('resignationApplication_date')
                    ->where('employee_id',$id)
                    ->where('applicationLeave_name','like','%'.$value.'%')
                    ->take($lay)
                    ->skip( ($page-1)*$lay)
                    ->get();

            $out="";
            $i=1;
            foreach($marketing as $item)
            {
               
                $out.='<tr>
                <td>'.$i.'</td>
                <td>'.$item->applicationLeave_name.'</td>
                <td>'.date('d/m/Y',strtotime($item->resignationApplication_date)).'</td>';

                if($item->applicationLeave_isDate==1)
                $out.='<td>Một ngày</td>';
                else
                $out.='<td>Một buổi</td>';
             
                if(session('quyen443')==1)
                $out.='<td><a class="btn" data-toggle="modal" data-target="#basicModal2"  
                    onclick="setValue(\''.$item->resignationApplication_id.'\'
                    ,\''.date('m/d/Y',strtotime($item->resignationApplication_date)).'\'
                    ,\''.$item->applicationLeave_id.'\');">
                        <i style="color: blue" class="fa fa-edit"></i>
                    </a>
                </td>';
               
                if(session('quyen444')==1)
                $out.='<td>
                    <a class="btn" onclick="xoa(\''.$item->resignationApplication_id.'\');">
                        <i style="color: red" class="fa fa-close"></i>
                    </a>
                </td>';
               
                $i++;
            }
            return response($out);
        
        
        }
    }
    
}
