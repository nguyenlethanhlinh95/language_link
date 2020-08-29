<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class thongBaoController extends Controller
{
    public function getThongBao()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemThongBao();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $quyenTatCa = $quyen->getXemTatCaThongBao();
            if($quyenTatCa ==1 )
            {
                $thongBaoTong = DB::table('st_notification')
                ->select('notification_id')
                ->count();
                $thongBao = DB::table('st_notification')
                ->orderByDesc('notification_time')
                ->take($lay)
                ->skip(0)
                ->get();
            }
            else
            {
                $thongBaoTong = DB::table('st_notification')
                ->where('branch_id',session('coSo'))
                ->select('notification_id')
                ->count();
                $thongBao = DB::table('st_notification')
                ->where('branch_id',session('coSo'))
                ->orderByDesc('notification_time')
                ->take($lay)
                ->skip(0)
                ->get();
            }
           
           
                $arr=[];
            foreach($thongBao as $item)
            {
                $nhanVienTao = DB::table('st_employee')
                ->where('employee_id',$item->employee_id)
                ->select('employee_name')
                ->get()->first();

                if(isset($nhanVienTao))
                {
                    $tenNguoiTao = $nhanVienTao->employee_name;
                }
                else
                {
                    $tenNguoiTao="";
                }
                $chiNhanh = DB::table('st_branch')
                ->where('branch_id',$item->branch_id)
                ->select('branch_code')
                ->get()->first();
                if(isset($chiNhanh))
                {
                    $tenChiNhanh = $chiNhanh->branch_code;
                }
                else
                {
                    $tenChiNhanh="";
                }
                $nhanVienChinh = DB::table('st_employee')
                ->where('employee_id',$item->notification_leader)
                ->select('employee_name')
                ->get()->first();

                if(isset($nhanVienChinh))
                {
                    $tenNVChinh = $nhanVienChinh->employee_name;
                }
                else
                {
                    $tenNVChinh="";
                }
                $arr[]=[
                    'id'=>$item->notification_id,
                    'noiDung'=>$item->notification_content,
                    'nguoiTao'=>$tenNguoiTao,
                    'thoiGianTao'=>$item->notification_time,
                    'thoiGianKetThuc'=>$item->notification_deadline,
                    'nguoiXuLy'=>$tenNVChinh,
                    'chiNhanh'=>$tenChiNhanh
                ];
            }

            $soKM = $thongBaoTong;
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;


            return view('ThongBao.thongBao')
                ->with('thongBao', $arr)
                ->with('soTrang', $soTrang)
                ->with('page', 1);
        }
        else
        {
            return redirect()->back();
        }
    }
    public function getThongBaoCaNhan()
    {
        $quyen = new quyenController();
        
            $lay = $quyen->layDuLieu();
            
                $thongBaoTong = DB::table('st_notification')
                ->join('st_notification_detail','st_notification_detail.notification_id',
                '=','st_notification.notification_id')
                ->where('st_notification_detail.employee_id',session('user'))
                ->select('st_notification.notification_id')
                ->count();
                $thongBao = DB::table('st_notification')
                ->join('st_notification_detail','st_notification_detail.notification_id',
                '=','st_notification.notification_id')
                ->where('st_notification_detail.employee_id',session('user'))
                ->orderByDesc('st_notification.notification_time')
                ->take($lay)
                ->skip(0)
                ->get();
           
           
                $arr=[];
            foreach($thongBao as $item)
            {
                $nhanVienTao = DB::table('st_employee')
                ->where('employee_id',$item->employee_id)
                ->select('employee_name')
                ->get()->first();
              
                if(isset($nhanVienTao))
                {
                    $tenNguoiTao = $nhanVienTao->employee_name;
                }
                else
                {
                    $tenNguoiTao="";
                }
                $chiNhanh = DB::table('st_branch')
                ->where('branch_id',$item->branch_id)
                ->select('branch_code')
                ->get()->first();
                if(isset($chiNhanh))
                {
                    $tenChiNhanh = $chiNhanh->branch_code;
                }
                else
                {
                    $tenChiNhanh="";
                }

                $nhanVienChinh = DB::table('st_employee')
                ->where('employee_id',$item->notification_leader)
                ->select('employee_name')
                ->get()->first();

                if(isset($nhanVienChinh))
                {
                    $tenNVChinh = $nhanVienChinh->employee_name;
                }
                else
                {
                    $tenNVChinh="";
                }
                $arr[]=[
                    'id'=>$item->notification_id,
                    'noiDung'=>$item->notification_content,
                    'nguoiTao'=>$tenNguoiTao,
                    'thoiGianTao'=>$item->notification_time,
                    'thoiGianKetThuc'=>$item->notification_deadline,
                    'nguoiXuLy'=>$tenNVChinh,
                    'chiNhanh'=>$tenChiNhanh
                ];
            }

            $soKM = $thongBaoTong;
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;


            return view('ThongBao.thongBaoCaNhan')
                ->with('thongBao', $arr)
                ->with('soTrang', $soTrang)
                ->with('page', 1);
    }
    public function getThemThongBao()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThemThongBao();
        if($quyenChiTiet==1)
        {
            $quyenTatCa = $quyen->getXemTatCaThongBao();
            $idchiNhanh=0;
            if($quyenTatCa ==1 )
            {
               $chiNhanh = DB::table('st_branch')
               ->get();
                if(count($chiNhanh)>0)
                {
                    $ChiNhanhDau = $chiNhanh->first();
                    $idchiNhanh=$ChiNhanhDau->branch_id;
                }
              
            }
            else
            {
                $chiNhanh = DB::table('st_branch')
                ->where('branch_id',session('coSo'))
                ->get();
                $idchiNhanh=session('coSo');
            }

            $nhanvien = DB::table('st_employee')
            ->where('branch_id',$idchiNhanh)
            ->where('employee_status',1)
            ->get();
            return view('ThongBao.themThongBao')
                ->with('nhanVien', $nhanvien)
                ->with('chiNhanh', $chiNhanh);
        }
        else
        {
            return redirect()->back();
        }
    }
    public function getCapNhatThongBao(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getSuaThongBao();
        if($quyenChiTiet==1)
        {
            $id =$request->get('id');

            $thongBao = DB::table('st_notification')
            ->where('notification_id',$id)
            ->get()->first();
            $thongBaoChiTiet = DB::table('st_notification_detail')
            ->where('notification_id',$id)
            ->get();
            $thongBaoGroup = DB::table('st_notification_group')
            ->where('notification_id',$id)
            ->get();
            $quyenTatCa = $quyen->getXemTatCaThongBao();
            $idchiNhanh=$thongBao->branch_id;
            if($quyenTatCa ==1 )
            {
               $chiNhanh = DB::table('st_branch')
               ->get();
            }
            else
            {
                $chiNhanh = DB::table('st_branch')
                ->where('branch_id',session('coSo'))
                ->get();
            }
            $nhanVienChinh=DB::table('st_employee')
            ->where('branch_id',$idchiNhanh)
            ->where('employee_status',1)
            ->get();
            if($thongBao->notification_Type==1 )
            $nhanvien = DB::table('st_employee')
            ->where('branch_id',$idchiNhanh)
            ->where('employee_status',1)
            ->get();
          
            else  if($thongBao->notification_Type==2 )
            {
                $nhanvien = DB::table('st_student')
                ->where('branch_id',$idchiNhanh)
                ->get();
            }
            else  if($thongBao->notification_Type==3 )
            {
                $nhanvien = DB::table('st_class')
                ->where('branch_id',$idchiNhanh)
                ->get();
            }else  
            {
                $nhanvien = DB::table('st_team')
                ->where('branch_id',$idchiNhanh)
                ->get();
            }
            return view('ThongBao.capNhatThongBao')
                ->with('nhanVien', $nhanvien)
                ->with('thongBao', $thongBao)
                ->with('thongBaoChiTiet', $thongBaoChiTiet)
                ->with('thongBaoGroup', $thongBaoGroup)
                ->with('nhanVienChinh', $nhanVienChinh)
                ->with('idchiNhanh', $idchiNhanh)
                ->with('chiNhanh', $chiNhanh);
                
        }
        else
        {
            return redirect()->back();
        }
    }

    
    public function postThemThongBao(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemThongBao();
            if($quyenChiTiet==1)
            {
                $chiNhanh = $request->get('chiNhanh');
                $startDate = $request->get('startDate');
                $startTime = $request->get('startTime');
                $leader = $request->get('leader');
                $nguoiNhan = $request->get('nguoiNhan');
                $noiDung = $request->get('noiDung');
                $loaiThongBao = $request->get('loaiThongBao');
                $dem = 0;
                $ngay = substr($startDate,3,2);
                $thang = substr($startDate,0,2);
                $nam = substr($startDate,6,4);
                $deadline = $nam."-".$thang."-".$ngay." ".$startTime;
                $now = Carbon::now('Asia/Ho_Chi_Minh');
                try
                {
                    $idThongBao = DB::table('st_notification')
                    ->insertGetId([
                        'notification_Type'=>$loaiThongBao,
                        'employee_id'=>session('user'),
                        'notification_content'=>$noiDung,
                        'notification_time'=>$now,
                        'notification_leader'=>$leader,
                        'notification_deadline'=>$deadline,
                        'notification_warning'=>2,
                        'branch_id'=>$chiNhanh,
                        'notification_status'=>0
                    ]);
                    
                    if($loaiThongBao==1)
                    {
                        $this->themThongBaoGiaoVien($nguoiNhan,$idThongBao,$chiNhanh);
                    }
                    else  if($loaiThongBao==2)
                    {
                        $this->themThongBaoHocVien($nguoiNhan,$idThongBao,$chiNhanh);
                    }
                    else  if($loaiThongBao==3)
                    {
                        $this->themThongBaoLopHoc($nguoiNhan,$idThongBao,$chiNhanh);
                    }
                    else
                    $this->themThongBaoTeamWork($nguoiNhan,$idThongBao,$chiNhanh);
                    
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

    public function postCapNhatThongBao(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaThongBao();
            if($quyenChiTiet==1)
            {
                $idThongBao = $request->get('idThongBao');
                $chiNhanh = $request->get('chiNhanh');
                $startDate = $request->get('startDate');
                $startTime = $request->get('startTime');
                $leader = $request->get('leader');
                $nguoiNhan = $request->get('nguoiNhan');
                $noiDung = $request->get('noiDung');
                $loaiThongBao = $request->get('loaiThongBao');
                $dem = 0;
                $ngay = substr($startDate,3,2);
                $thang = substr($startDate,0,2);
                $nam = substr($startDate,6,4);
                $deadline = $nam."-".$thang."-".$ngay." ".$startTime;
                $now = Carbon::now('Asia/Ho_Chi_Minh');
                try
                {
                     DB::table('st_notification')
                    ->where('notification_id',$idThongBao)
                    ->update([
                        'notification_Type'=>$loaiThongBao,
                        'notification_content'=>$noiDung,
                        'notification_leader'=>$leader,
                        'notification_deadline'=>$deadline,
                        'notification_warning'=>2,
                        'branch_id'=>$chiNhanh
                    ]);
                    DB::table('st_notification_detail')
                    ->where('notification_id',$idThongBao)
                    ->delete();
                    DB::table('st_notification_group')
                    ->where('notification_id',$idThongBao)
                    ->delete();

                    if($loaiThongBao==1)
                    {
                        $this->themThongBaoGiaoVien($nguoiNhan,$idThongBao,$chiNhanh);
                    }
                    else  if($loaiThongBao==2)
                    {
                        $this->themThongBaoHocVien($nguoiNhan,$idThongBao,$chiNhanh);
                    }
                    else  if($loaiThongBao==3)
                    {
                        $this->themThongBaoLopHoc($nguoiNhan,$idThongBao,$chiNhanh);
                    }
                    else
                    $this->themThongBaoTeamWork($nguoiNhan,$idThongBao,$chiNhanh);
                    
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
    public function getXoaThongBao(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaThongBao();
            if($quyenChiTiet==1)
            {
                $idThongBao= $request->get('id');

                try
                {
                    DB::table('st_notification_detail')
                    ->where('notification_id',$idThongBao)
                    ->delete();
                    DB::table('st_notification_group')
                    ->where('notification_id',$idThongBao)
                    ->delete();
                    DB::table('st_notification')
                    ->where('notification_id',$idThongBao)
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

    public function getCapNhatTrangThaiThongBao(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
           
                $idThongBao= $request->get('id');

                try
                {
                  
                    DB::table('st_notification')
                    ->where('notification_id',$idThongBao)
                    ->update([
                        'notification_status'=>1
                    ]);
                    return response(1);
                }
                catch(QueryException $ex)
                {
                    return response(0);
                }
           
        }
        
    }
    
    public function getDuLieuNguoiNhanThongBao(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->get('id');
            $thongBao = DB::table('st_notification')
            ->where('notification_id',$id)
            ->get()->first();
            $thongBaoGroup = DB::table('st_notification_group')
            ->where('notification_id',$id)
            ->get();
            $out="";
            $i =1;
                foreach($thongBaoGroup as $item)
                {
                    $out.='<tr>';
                    if($thongBao->notification_Type==1)
                    {
                        if($item->notificationGroup_group==0)
                        {
                            $out="<td>1</td><td>Tất Cả Nhân viên</td>";
                            break;
                        }
                        $nhanVien = DB::table('st_employee')
                        ->where('employee_id',$item->notificationGroup_group)
                        ->get()->first();
                        if(isset($nhanVien))
                        {
                            $tenNhanVien=$nhanVien->employee_name;
                        }
                        else
                        {
                            $tenNhanVien="";
                        }
                        $out.="<td>".$i."</td>
                        <td>".$tenNhanVien."</td>";
                        
                    }
                    else  if($thongBao->notification_Type==2)
                    {
                        if($item->notificationGroup_group==0)
                        {
                            $out="<td>1</td><td>Tất Cả Học viên</td>";
                            break;
                        }
                        $nhanVien = DB::table('st_student')
                        ->where('student_id',$item->notificationGroup_group)
                        ->get()->first();
                        if(isset($nhanVien))
                        {
                            $tenNhanVien=$nhanVien->student_firstName . " ". $nhanVien->student_lastName;
                        }
                        else
                        {
                            $tenNhanVien="";
                        }
                        $out.="<td>".$i."</td>
                        <td>".$tenNhanVien."</td>";
                        
                    }
                    else  if($thongBao->notification_Type==3)
                    {
                        if($item->notificationGroup_group==0)
                        {
                            $out="<td>1</td><td>Tất Cả Lớp học</td>";
                            break;
                        }
                        $nhanVien = DB::table('st_class')
                        ->where('class_id',$item->notificationGroup_group)
                        ->get()->first();
                        if(isset($nhanVien))
                        {
                            $tenNhanVien=$nhanVien->class_name;
                        }
                        else
                        {
                            $tenNhanVien="";
                        }
                        $out.="<td>".$i."</td>
                        <td>".$tenNhanVien."</td>";
                        
                    }
                    else  if($thongBao->notification_Type==3)
                    {
                        if($item->notificationGroup_group==0)
                        {
                            $out="<td>1</td><td>Tất Cả Teamwork</td>";
                            break;
                        }
                        $nhanVien = DB::table('st_team')
                        ->where('team_id',$item->notificationGroup_group)
                        ->get()->first();
                        if(isset($nhanVien))
                        {
                            $tenNhanVien=$nhanVien->team_name;
                        }
                        else
                        {
                            $tenNhanVien="";
                        }
                        $out.="<td>".$i."</td>
                        <td>".$tenNhanVien."</td>";
                        
                    }
                    $out.='</tr>';
                    $i++;
                }
                return response($out);

        }
    }

    public function searchThongBao(Request $request)
    {
      if ($request->ajax()) {
                $quyen = new quyenController();
                $lay = $quyen->layDuLieu();
                $value = $request->get('value');
                $page = $request->get('page');
                $quyenTatCa = $quyen->getXemTatCaThongBao();

                if($quyenTatCa ==1 )
                {
                   
                    if ($value == "")
                        $thongBao = DB::table('view_notification_branch_employee')
                        ->orderByDesc('notification_time')
                            ->take($lay)
                            ->skip(($page - 1) * $lay)
                            ->get();
                    else
                        $thongBao = DB::table('view_notification_branch_employee')
                            ->where('employee_name', 'like', '%' . $value . '%')
                            ->orwhere('branch_code', 'like', '%' . $value . '%')
                            ->orderByDesc('notification_time')
                            ->take($lay)
                            ->skip(($page - 1) * $lay)
                            ->get();
                }
                else
                {
                   
                    if ($value == "")
                        $thongBao = DB::table('view_notification_branch_employee')
                            ->where('branch_id', session('coSo'))
                            ->orderByDesc('notification_time')
                            ->take($lay)
                            ->skip(($page - 1) * $lay)
                            ->get();
                    else
                        $thongBao = DB::table('view_notification_branch_employee')
                        ->where('branch_id', session('coSo'))
                        ->where(function($query) use($value)
                            {
                                $query ->where('employee_name', 'like', '%' . $value . '%')
                                ->orwhere('branch_code', 'like', '%' . $value . '%');
                            }
                            )
                            ->orderByDesc('notification_time')
                            ->take($lay)
                            ->skip(($page - 1) * $lay)
                            ->get();
                }
               
                $out = "";
                $i = 1;
                foreach ($thongBao as $item) {
                    $nhanVien = DB::table('st_employee')
                    ->where('employee_id',$item->notification_leader)
                    ->get()->first();
                    if(isset($nhanVien))
                    {
                        $tenNhanVien=$nhanVien->employee_name;
                    }
                    else
                    {
                        $tenNhanVien="";
                    }

                    $out .= ' <tr>
                    <td>'.$i.'</td>
                    <td>'.$item->branch_code.'</td>
                    <td>'.$item->notification_content.'</td>
                    <td>'.$item->employee_name.'</td>
                    <td>'.date('H:i d/m/Y',strtotime($item->notification_deadline)) .'</td>
                    <td>'.$tenNhanVien.'</td>
                    <td><a  class="btn" onclick="getDuLieu('.$item->notification_id.');" data-toggle="modal" data-target="#basicModal">
                    <i class="fa fa-list"></i>  
                    </a>
                    </td>';
            
                    if(session('quyen503')==1)
                    $out .= '    <td><a class="btn" href="'.route('getCapNhatThongBao').'?id='.$item->notification_id.'">
                            <i style="color: blue" class="fa fa-edit"></i>
                        </a>
                    </td>';
                   
                    if(session('quyen504')==1)
                    $out .= '   <td>
                        <a class="btn" onclick="xoa('.$item->notification_id.');">
                            <i style="color: red" class="fa fa-close"></i>
                        </a>
                    </td>';
                  
                    $out .= ' </tr>';
                    $i++;
            }
                return response($out);
        }
    }
    public function searchThongBaoCaNhan(Request $request)
    {
      if ($request->ajax()) {
                $quyen = new quyenController();
                $lay = $quyen->layDuLieu();
                $value = $request->get('value');
                $page = $request->get('page');
               
                   
                    if ($value == "")
                        $thongBao = DB::table('view_notification_leader')
                        ->where('employee_id',session('user'))
                        ->orderByDesc('notification_time')
                            ->take($lay)
                            ->skip(($page - 1) * $lay)
                            ->get();
                    else
                        $thongBao = DB::table('view_notification_leader')
                            ->where('employee_id',session('user'))
                            ->where(function($query) use ($value)
                            {
                                $query  ->where('employee_name', 'like', '%' . $value . '%')
                                ->orwhere('branch_code', 'like', '%' . $value . '%');
                            })   
                            ->orderByDesc('notification_time')
                            ->take($lay)
                            ->skip(($page - 1) * $lay)
                            ->get();
                
               
                $out = "";
                $i = 1;
                foreach ($thongBao as $item) {
                    $nhanVien = DB::table('st_employee')
                    ->where('employee_id',$item->notification_leader)
                    ->get()->first();
                    if(isset($nhanVien))
                    {
                        $tenNhanVien=$nhanVien->employee_name;
                    }
                    else
                    {
                        $tenNhanVien="";
                    }

                    $out .= ' <tr>
                    <td>'.$i.'</td>
                    <td>'.$item->branch_code.'</td>
                    <td>'.$item->notification_content.'</td>
                    <td>'.$item->employee_name.'</td>
                    <td>'.date('H:i d/m/Y',strtotime($item->notification_deadline)) .'</td>
                    <td>'.$tenNhanVien.'</td>
                    ';
                    $out .= ' </tr>';
                    $i++;
            }
                return response($out);
        }
    }
    public function themThongBaoTeamWork($value,$idThongBao,$chiNhanh)
    {
        foreach($value as $item)
        {
            if($item==0)
            {
                $lopHoc = DB::table('view_team_branch_employee')
                ->where('branch_id',$chiNhanh)
                ->get();
                DB::table('st_notification_group')
                ->insert([
                    'notification_id'=>$idThongBao,
                    'notificationGroup_group'=>0
                ]);
                foreach($lopHoc as $item2)
                {
                    $thongBao = DB::table('st_notification_detail')
                    ->where('employee_id',$item2->employee_id)
                    ->where('notification_id',$idThongBao)
                    ->get()->first();
                    if(isset($thongBao))
                    {

                    }
                    else
                    {
                        DB::table('st_notification_detail')
                        ->insert([
                            'notification_id'=>$idThongBao,
                            'employee_id'=>$item2->employee_id,
                            'student_id'=>0,
                            'notification_status'=>0
                        ]);  
                    }
                   
                }

                return;
            }

            $lopHoc = DB::table('view_team_branch_employee')
            ->where('branch_id',$chiNhanh)
            ->where('team_id',$item)
            ->get();
            foreach($lopHoc as $item2)
            {
                $thongBao = DB::table('st_notification_detail')
                ->where('employee_id',$item2->employee_id)
                ->where('notification_id',$idThongBao)
                ->get()->first();
                if(isset($thongBao))
                {

                }
                else
                {
                    DB::table('st_notification_detail')
                    ->insert([
                        'notification_id'=>$idThongBao,
                        'employee_id'=>$item2->employee_id,
                        'student_id'=>0,
                        'notification_status'=>0
                    ]);  
                }
               
            }
            DB::table('st_notification_group')
            ->insert([
                'notification_id'=>$idThongBao,
                'notificationGroup_group'=>$item
            ]);

        }
    }
    public function themThongBaoLopHoc($value,$idThongBao,$chiNhanh)
    {
        foreach($value as $item)
        {
            if($item==0)
            {
                $lopHoc = DB::table('view_class_branch_student')
                ->where('branch_id',$chiNhanh)
                ->get();
                DB::table('st_notification_group')
                ->insert([
                    'notification_id'=>$idThongBao,
                    'notificationGroup_group'=>0
                ]);
                foreach($lopHoc as $item2)
                {
                    $thongBao = DB::table('st_notification_detail')
                    ->where('student_id',$item2->student_id)
                    ->where('notification_id',$idThongBao)
                    ->get()->first();
                  
                    if(isset($thongBao))
                    {

                    }
                    else
                    {
                        DB::table('st_notification_detail')
                        ->insert([
                            'notification_id'=>$idThongBao,
                            'employee_id'=>0,
                            'student_id'=>$item2->student_id,
                            'notification_status'=>0
                        ]);  
                    }
                   
                }

                return;
            }

                $lopHoc = DB::table('st_class_student')
                ->where('class_id'  ,$item)
                ->get();
                foreach($lopHoc as $item2)
                {
                    $thongBao = DB::table('st_notification_detail')
                    ->where('student_id',$item2->student_id)
                    ->where('notification_id',$idThongBao)
                    ->get()->first();
                    if(isset($thongBao))
                    {

                    }
                    else
                    {
                        DB::table('st_notification_detail')
                        ->insert([
                            'notification_id'=>$idThongBao,
                            'employee_id'=>0,
                            'student_id'=>$item2->student_id,
                            'notification_status'=>0
                        ]);  
                    }
                  
                }
                DB::table('st_notification_group')
                ->insert([
                    'notification_id'=>$idThongBao,
                    'notificationGroup_group'=>$item
                ]);
        }
    }

    public function themThongBaoHocVien($value,$idThongBao,$chiNhanh)
    {
        foreach($value as $item)
        {
            if($item==0)
            {
                DB::table('st_notification_group')
                ->insert([
                    'notification_id'=>$idThongBao,
                    'notificationGroup_group'=>0
                ]);
                $hocVien = DB::table('st_student')
                ->where('branch_id',$chiNhanh)
                ->get();
                foreach($hocVien as $item2)
                { $thongBao = DB::table('st_notification_detail')
                    ->where('student_id',$item2->student_id)
                    ->where('notification_id',$idThongBao)
                    ->get()->first();
                    if(isset($thongBao))
                    {

                    }
                    else
                    {
                    DB::table('st_notification_detail')
                    ->insert([
                        'notification_id'=>$idThongBao,
                        'employee_id'=>0,
                        'student_id'=>$item2->student_id,
                        'notification_status'=>0
                    ]);  
                    }
                }

                return;
            }
            DB::table('st_notification_group')
            ->insert([
                'notification_id'=>$idThongBao,
                'notificationGroup_group'=>$item
            ]);
            DB::table('st_notification_detail')
            ->insert([
                'notification_id'=>$idThongBao,
                'employee_id'=>0,
                'student_id'=>$item,
                'notification_status'=>0
            ]);
        }
    }
    public function themThongBaoGiaoVien($value,$idThongBao,$chiNhanh)
    {
        foreach($value as $item)
        {
            if($item==0)
            {
                $nhanvien = DB::table('st_employee')
                ->where('branch_id',$chiNhanh)
                ->where('employee_status',1)
                ->get();
                DB::table('st_notification_group')
                ->insert([
                    'notification_id'=>$idThongBao,
                    'notificationGroup_group'=>0
                ]);
                foreach($nhanvien as $item2)
                {
                    $thongBao = DB::table('st_notification_detail')
                    ->where('employee_id',$item2->employee_id)
                    ->where('notification_id',$idThongBao)
                    ->get()->first();
                    if(isset($thongBao))
                    {

                    }
                    else
                    {
                    DB::table('st_notification_detail')
                    ->insert([
                        'notification_id'=>$idThongBao,
                        'employee_id'=>$item2->employee_id,
                        'student_id'=>0,
                        'notification_status'=>0
                    ]);  
                    }
                }

                return;
            }

            DB::table('st_notification_detail')
            ->insert([
                'notification_id'=>$idThongBao,
                'employee_id'=>$item,
                'student_id'=>0,
                'notification_status'=>0
            ]);
            DB::table('st_notification_group')
            ->insert([
                'notification_id'=>$idThongBao,
                'notificationGroup_group'=>$item
            ]);
        }
    }

    public function changeLoaiChiNhanhThongBao(Request $request)
    {
        if($request->ajax())
        {
            $chiNhanh = $request->get('chiNhanh');
            $loai = $request->get('loai');
            $duLieu=[];
            if($loai==1)
            {
                $duLieu = $this->getDuLieuLoaiNhanVien($chiNhanh);
            }
            else  if($loai==2)
            {
                $duLieu = $this->getDuLieuLoaiHocVien($chiNhanh);
            }
            else  if($loai==3)
            {
                $duLieu = $this->getDuLieuLoaiLopHoc($chiNhanh);
            }
            else
            {
                $duLieu = $this->getDuLieuLoaiTeam($chiNhanh);
            }
            

            return $duLieu;
        }
    }
    public function getDuLieuLoaiNhanVien($chiNhanh)
    {
        $nhanvien = DB::table('st_employee')
        ->where('branch_id',$chiNhanh)
        ->where('employee_status',1)
        ->get();
        $out = "";
        if(count($nhanvien)>0)
        $out1 = "<option value='0'>ALL</option>";
        else
        $out1="";
        foreach($nhanvien as $item)
        {
            $out.="<option value='".$item->employee_id."'>".$item->employee_name."</option>";
            $out1.="<option value='".$item->employee_id."'>".$item->employee_name."</option>";
        }

        $arr[]=[
            'nguoiChinh'=>$out,
            'nguoiNhan'=>$out1
        ];
        return $arr;
    }
    public function getDuLieuLoaiHocVien($chiNhanh)
    {
        $nhanvien = DB::table('st_employee')
        ->where('branch_id',$chiNhanh)
        ->where('employee_status',1)
        ->get();


        $hocVien = DB::table('st_student')
        ->where('branch_id',$chiNhanh)
        ->get();

        $out = "";
        if(count($hocVien))
        $out1 = "<option value='0'>ALL</option>";
        else
        $out1="";
        foreach($nhanvien as $item)
        {
            $out.="<option value='".$item->employee_id."'>".$item->employee_name."</option>";
        }

        foreach($hocVien as $item)
        {

            $out1.="<option value='".$item->student_id."'>".$item->student_firstName." " .$item->student_lastName."</option>";
        }

        $arr[]=[
            'nguoiChinh'=>$out,
            'nguoiNhan'=>$out1
        ];
        return $arr;
    }

    public function getDuLieuLoaiLopHoc($chiNhanh)
    {
        $nhanvien = DB::table('st_employee')
        ->where('branch_id',$chiNhanh)
        ->where('employee_status',1)
        ->get();

        $now = Carbon::now('Asia/Ho_Chi_Minh');
      
        $lopHoc = DB::table('st_class')
        ->where('branch_id',$chiNhanh)
        ->where('class_statusSchedule',1)
        ->where('class_status',1)
        ->where('class_endDay','>=',$now)
        ->get();

        $out = "";
        if(count($lopHoc))
        $out1 = "<option value='0'>ALL</option>";
        else
        $out1="";
        foreach($nhanvien as $item)
        {
            $out.="<option value='".$item->employee_id."'>".$item->employee_name."</option>";
        }

        foreach($lopHoc as $item)
        {

            $out1.="<option value='".$item->class_id."'>".$item->class_name."</option>";
        }

        $arr[]=[
            'nguoiChinh'=>$out,
            'nguoiNhan'=>$out1
        ];
        return $arr;
    }

    public function getDuLieuLoaiTeam($chiNhanh)
    {
        $nhanvien = DB::table('st_employee')
        ->where('branch_id',$chiNhanh)
        ->where('employee_status',1)
        ->get();

        $now = Carbon::now('Asia/Ho_Chi_Minh');
      
        $lopHoc = DB::table('st_team')
        ->where('branch_id',$chiNhanh)
        ->get();

        $out = "";
        if(count($lopHoc))
        $out1 = "<option value='0'>ALL</option>";
        else
        $out1="";
        foreach($nhanvien as $item)
        {
            $out.="<option value='".$item->employee_id."'>".$item->employee_name."</option>";
        }

        foreach($lopHoc as $item)
        {

            $out1.="<option value='".$item->team_id."'>".$item->team_name."</option>";
        }

        $arr[]=[
            'nguoiChinh'=>$out,
            'nguoiNhan'=>$out1
        ];
        return $arr;
    }
}
