<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class nhiemVuController extends Controller
{
    public function getNhiemVu(Request $request)
    {
        $quyen = new quyenController();
        $quyenXemMarketing = $quyen->getXemNhiemVu();
        
        if ($quyenXemMarketing == 1) {
            $lay=$quyen->layDuLieu();
            $nhiemVuTong = DB::table('view_task')
            ->select('task_id')
            ->count();
            $sms = $request->get('sms');

            if($sms =="")
            {
                $sms=3;
            }

            $nhiemVu = DB::table('view_task')
            ->orderByDesc('task_startDate')
                ->take($lay)
                ->skip(0)
                ->get();
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $arrTrangThai=[];
            foreach($nhiemVu as $item)
            {
                $nhanVien = DB::table('st_employee')
                ->where('employee_id',$item->task_create)
                ->get()->first();

                if(isset($nhanVien))
                {
                    $nguoiTao = $nhanVien->employee_name;
                }
                else
                {
                    $nguoiTao="";
                }
                if($item->task_status==0)
                {
                    $trangThai = "Mới tạo";
                }
                else if($item->task_status==1)
                {
                    if($now < $item->task_endDate)
                    {
                        $trangThai = "Đang Thực hiện";
                    }
                    else
                    {
                        $trangThai = "Trể giờ";
                    }
                }
                else if($item->task_status==2)
                {
                    $trangThai = "Đề nghị gia hạn";
                }
                else if($item->task_status==3)
                {
                    $trangThai = "Đề nghị hủy";
                }
                else
                {
                    $trangThai = "Đã hoàn thành";
                }
                $arrTrangThai[]=[
                    'trangThai'=>$trangThai,
                    'nguoiTao'=>$nguoiTao
                ];
            }

            $soMarketing= $nhiemVuTong;

            $soTrang =(int)$soMarketing/$lay;
            if($soMarketing%$lay>0)
            $soTrang++;
            return view('NhiemVu.nhiemVu')
                ->with('page',1)
                ->with('soTrang',$soTrang)
                ->with('sms',$sms)
                ->with('arrTrangThai',$arrTrangThai)
                ->with('nhiemVu', $nhiemVu);

                
        } else {
            return redirect()->back();
        }
    }

    public function getNhiemVuCaNhan(Request $request)
    {
        $quyen = new quyenController();
        
        $sms = $request->get('sms');

        if($sms="")
        {
            $sms=5;
        }
        $lay=$quyen->layDuLieu();
            $trangThai = $request->get('status');

            $now = Carbon::now('Asia/Ho_Chi_Minh');
            if($trangThai ==0)
            {
                $nhiemVuTong = DB::table('view_task_detail')
                ->where('employee_id',session('user'))
                ->select('task_id')
                ->count();
                $nhiemVu = DB::table('view_task_detail')
                ->where('employee_id',session('user'))
                ->orderByDesc('task_startDate')
                ->take($lay)
                ->skip(0)
                ->get();
            }
            else if($trangThai ==1)
            {
                $nhiemVuTong = DB::table('view_task_detail')
                ->where('employee_id',session('user'))
                ->where('task_status',0)
                ->select('task_id')
                ->count();
                $nhiemVu = DB::table('view_task_detail')
                ->where('employee_id',session('user'))
                ->orderByDesc('task_startDate')
                ->where('task_status',0)
                ->take($lay)
                ->skip(0)
                ->get();
            }
            else if($trangThai ==2)
            {
                $nhiemVuTong = DB::table('view_task_detail')
                ->where('employee_id',session('user'))
                ->whereDate('task_startDate','<=',$now)
                ->whereDate('task_endDate','>=',$now)
                ->where('task_status','>=',1)
                ->where('task_status','<=',3)
                ->select('task_id')
                ->count();
                $nhiemVu = DB::table('view_task_detail')
                ->where('employee_id',session('user'))
                ->whereDate('task_startDate','<=',$now)
                ->whereDate('task_endDate','>=',$now)
                ->where('task_status','>=',1)
                ->where('task_status','<=',3)
                ->orderByDesc('task_startDate')
                ->take($lay)
                ->skip(0)
                ->get();
            }
            else if($trangThai ==3)
            {
                $nhiemVuTong = DB::table('view_task_detail')
                ->where('employee_id',session('user'))
                ->whereDate('task_endDate','<',$now)
                ->where('task_status','>=',1)
                ->where('task_status','<=',3)
                ->select('task_id')
                ->count();
                $nhiemVu = DB::table('view_task_detail')
                ->where('employee_id',session('user'))
                ->whereDate('task_endDate','<',$now)
                ->where('task_status','>=',1)
       ->where('task_status','<=',3)
                ->orderByDesc('task_startDate')
                ->take($lay)
                ->skip(0)
                ->get();
            }
            else
            {
                $nhiemVuTong = DB::table('view_task_detail')
                ->where('employee_id',session('user'))
                ->where('task_status',4)
                ->select('task_id')
                ->count();
                $nhiemVu = DB::table('view_task_detail')
                ->where('employee_id',session('user'))
                ->where('task_status',4)
                ->orderByDesc('task_startDate')
                ->take($lay)
                ->skip(0)
                ->get();
            }
          $arrLeader=[];
           foreach($nhiemVu as $item)
           {
               $nhanVien = DB::table('st_employee')
               ->where('employee_id',$item->task_leader)
               ->get()->first();
               $nhanVienTao = DB::table('st_employee')
               ->where('employee_id',$item->task_create)
               ->get()->first();
               if(isset($nhanVien))
               {
                   $tenNhanVien = $nhanVien->employee_name;
               }
               else
               {
                   $tenNhanVien = "";
               }
               if(isset($nhanVienTao))
               {
                   $tenNhanVienTao = $nhanVienTao->employee_name;
               }
               else
               {
                   $tenNhanVienTao = "";
               }
               $arrLeader[]=[
                   'ten'=>$tenNhanVien,
                   'tenNguoiTao'=>$tenNhanVienTao
                ];
           }


            $sms = $request->get('sms');

            if($sms =="")
            {
                $sms=3;
            }

           
            $soMarketing= $nhiemVuTong;

            $soTrang =(int)$soMarketing/$lay;
            if($soMarketing%$lay>0)
            $soTrang++;
            return view('NhiemVu.nhiemVuCaNhan')
                ->with('page',1)
                ->with('soTrang',$soTrang)
                ->with('arrLeader',$arrLeader)
                ->with('sms',$sms)
                ->with('trangThai',$trangThai)
                ->with('nhiemVu', $nhiemVu);
    }

    public function getCapNhatTrangThaiNhiemVu(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->get('id');
            $trangThai = $request->get('trangThai');
            $ghiChu = $request->get('ghiChu');
            try
            {
                DB::table('st_task')
                ->where('task_id',$id)
                ->update([
                    'task_status'=>$trangThai,
                    'task_note'=>$ghiChu
                ]);

                return response(1);
            }
            catch(QueryException $ex)
            {
                return response(0);
            }
        }
    }
    public function searchNhiemVu(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
           
                if ($value == "")
                {
                    $nhiemVu = DB::table('view_task')
                    ->orderByDesc('task_startDate')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                }
                else
                {
                    $nhiemVu = DB::table('view_task')
                    ->orderByDesc('task_startDate')
                    ->where('task_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                }
           

            $out = "";
            $i = 1;
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            foreach ($nhiemVu as $item) {
                $nhanVien = DB::table('st_employee')
                ->where('employee_id',$item->task_create)
                ->get()->first();

                if(isset($nhanVien))
                {
                    $nguoiTao = $nhanVien->employee_name;
                }
                else
                {
                    $nguoiTao="";
                }
                if($item->task_status==0)
                {
                    $trangThai = "Mới tạo";
                }
                else if($item->task_status==1)
                {
                    if($now < $item->task_endDate)
                    {
                        $trangThai = "Đang Thực hiện";
                    }
                    else
                    {
                        $trangThai = "Trể giờ";
                    }
                }
                else if($item->task_status==2)
                {
                    $trangThai = "Đề nghị gia hạn";
                }
                else if($item->task_status==3)
                {
                    $trangThai = "Đề nghị hủy";
                }
                else
                {
                    $trangThai = "Đã hoàn thành";
                }

                $out .= '<tr>
                <td>' . $i . '</td>
                <td><a onclick="xemNhiemVu('. $item->task_id .');"     class="btn" data-toggle="modal" data-target="#basicModal">'.$item->task_name.'</a></td>   
                <td>' . $item->employee_name . '</td>
                <td>' .date('d/m/Y',strtotime($item->task_startDate )) .' - '.  date('d/m/Y',strtotime($item->task_endDate )).'</td>
                <td>' . $trangThai . '</td>
                <td>' . $nguoiTao . '</td>
                <td>' . $item->task_note . '</td>
                ';
                if (session('quyen513') == 1)
                    $out .= '<td>
                            <a class="btn" href="'. route('getCapNhatNhiemVu') .'?id='. $item->task_id .'">
                                <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                        </td>';
                if (session('quyen514') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->task_id . '\');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>';
                $out .= ' </tr>';
                $i++;
            }
            return response($out);
        }
    }
    public function getThemCongViec(Request $request)
    {
        $quyen = new quyenController();
        $quyenXemMarketing = $quyen->getThemNhiemVu();
        
        if ($quyenXemMarketing == 1) {
           $chiNhanh = DB::table('st_branch')
           ->get();
           $nhanVien = DB::table('st_employee')
           ->where('employee_status',1)
           ->get();
            return view('NhiemVu.themNhiemVu')
            ->with('chiNhanh',$chiNhanh)
            ->with('nhanVien',$nhanVien)
                ;
        } else {
            return redirect()->back();
        }
    }

    public function getCapNhatNhiemVu(Request $request)
    {
        $quyen = new quyenController();
        $quyenXemMarketing = $quyen->getSuaNhiemVu();
        
        if ($quyenXemMarketing == 1) {
            $id = $request->get('id');
            $nhiemVu = DB::table('st_task')
            ->where('task_id',$id)
            ->get()->first();
            $nhiemVuChiTiet = DB::table('st_task_detail')
            ->where('task_id',$id)
            ->get();

           $chiNhanh = DB::table('st_branch')
           ->get();
           $nhanVien = DB::table('st_employee')
           ->where('employee_status',1)
           ->get();
            return view('NhiemVu.capNhatNhiemVu')
            ->with('chiNhanh',$chiNhanh)
            ->with('nhanVien',$nhanVien)
            ->with('nhiemVu',$nhiemVu)
            ->with('nhiemVuChiTiet',$nhiemVuChiTiet)
                ;
        } else {
            return redirect()->back();
        }
    }

    public function getCapNhatNhiemVuLeader(Request $request)
    {
       
            $id = $request->get('id');
            $nhiemVu = DB::table('st_task')
            ->where('task_id',$id)
            ->get()->first();
            if(session('user')==$nhiemVu->task_leader)
            {
                $nhiemVuChiTiet = DB::table('st_task_detail')
                ->where('task_id',$id)
                ->get();
    
               $chiNhanh = DB::table('st_branch')
               ->get();
               $nhanVien = DB::table('st_employee')
               ->where('employee_status',1)
               ->get();
                return view('NhiemVu.capNhatNhiemVuLeader')
                ->with('chiNhanh',$chiNhanh)
                ->with('nhanVien',$nhanVien)
                ->with('nhiemVu',$nhiemVu)
                ->with('nhiemVuChiTiet',$nhiemVuChiTiet)
                    ;
            }
            else
            {
                return redirect()->back();
            }

           
       
    }
    public function postThemNhiemVu(Request $request)
    {
       
            
            $quyen = new quyenController();
            $quyenXemMarketing = $quyen->getThemNhiemVu();
            
            if ($quyenXemMarketing == 1) {
                try{
                    $chiNhanh = $request->get('chiNhanh');
                    $tieuDe = $request->get('tieuDe');
                    $ngayBatDau = $request->get('startDate');
                    $ngayKetThuc = $request->get('endDate');
                    $thoiGianBatDau = substr($ngayBatDau,6,4)."-".substr($ngayBatDau,0,2)."-".substr($ngayBatDau,3,2);
                    $thoiGianKetThuc = substr($ngayKetThuc,6,4)."-".substr($ngayKetThuc,0,2)."-".substr($ngayKetThuc,3,2);
                    $nguoiChinh = $request->get('leader');
                    $noiDung= $request->get('noiDung');

                    $nguoiNhan= $request->get('nguoiNhan');
                    $id = DB::table('st_task')
                    ->insertGetId([
                        'task_name'=>$tieuDe,
                        'task_content'=>$noiDung,
                        'task_startDate'=>$thoiGianBatDau,
                        'task_endDate'=>$thoiGianKetThuc,
                        'task_leader'=>$nguoiChinh,
                        'branch_id'=>0,
                        'task_create'=>session('user'),
                        'task_status'=>0,
                        'task_note'=>""
                    ]);
                    DB::table('st_task_detail')
                    ->insert([
                        'employee_id'=>$nguoiChinh,
                        'task_id'=>$id
                    ]);
                    if($nguoiNhan!="")
                    $out = $this->themNhiemVuNhanVien($nguoiNhan,$id,$chiNhanh);

                    return redirect()->route('getNhiemVu',['sms'=>1]);
                }catch(QueryException $ex)
                {
                    return redirect()->route('getThemNhiemVu',['sms'=>0]);
                }

            }
            else
            {
                return redirect()->route('getNhiemVu',['sms'=>2]);
            }
        
    }
    
    public function postCapNhatNhiemVu(Request $request)
    {
       
            
            $quyen = new quyenController();
            $quyenXemMarketing = $quyen->getSuaNhiemVu();
            
            if ($quyenXemMarketing == 1) {
                try{
                    $id = $request->get('id');
                    $chiNhanh = $request->get('chiNhanh');
                    $tieuDe = $request->get('tieuDe');
                    $ngayBatDau = $request->get('startDate');
                    $ngayKetThuc = $request->get('endDate');
                    $thoiGianBatDau = substr($ngayBatDau,6,4)."-".substr($ngayBatDau,0,2)."-".substr($ngayBatDau,3,2);
                    $thoiGianKetThuc = substr($ngayKetThuc,6,4)."-".substr($ngayKetThuc,0,2)."-".substr($ngayKetThuc,3,2);
                    $nguoiChinh = $request->get('leader');
                    $noiDung= $request->get('noiDung');

                    $nguoiNhan= $request->get('nguoiNhan');
                    DB::table('st_task')
                    ->where('task_id',$id)
                    ->update([
                        'task_name'=>$tieuDe,
                        'task_content'=>$noiDung,
                        'task_startDate'=>$thoiGianBatDau,
                        'task_endDate'=>$thoiGianKetThuc,
                        'task_leader'=>$nguoiChinh,
                        'branch_id'=>0,
                        'task_create'=>session('user')
                    ]);

                    DB::table('st_task_detail')
                    ->where('task_id',$id)
                    ->delete();


                    DB::table('st_task_detail')
                    ->insert([
                        'employee_id'=>$nguoiChinh,
                        'task_id'=>$id
                    ]);

                    $out = $this->themNhiemVuNhanVien($nguoiNhan,$id,$chiNhanh);
                    return redirect()->route('getNhiemVu',['sms'=>4]);
                }catch(QueryException $ex)
                {
                    return redirect()->route('getCapNhatNhiemVu',['sms'=>0,'id'=>$id]);
                }

            }
            else
            {
                return redirect()->route('getNhiemVu',['sms'=>2]);
            }
        
    }


    
    public function postCapNhatNhiemVuLeader(Request $request)
    {
       
            
          
                try{
                    $id = $request->get('id');
                    $chiNhanh = $request->get('chiNhanh');
                    $tieuDe = $request->get('tieuDe');
                    $ngayBatDau = $request->get('startDate');
                    $ngayKetThuc = $request->get('endDate');
                    $thoiGianBatDau = substr($ngayBatDau,6,4)."-".substr($ngayBatDau,0,2)."-".substr($ngayBatDau,3,2);
                    $thoiGianKetThuc = substr($ngayKetThuc,6,4)."-".substr($ngayKetThuc,0,2)."-".substr($ngayKetThuc,3,2);
                    $nguoiChinh = $request->get('leader');
                    $noiDung= $request->get('noiDung');

                    $nguoiNhan= $request->get('nguoiNhan');
                    DB::table('st_task')
                    ->where('task_id',$id)
                    ->update([
                        'task_name'=>$tieuDe,
                        'task_content'=>$noiDung,
                        'task_startDate'=>$thoiGianBatDau,
                        'task_endDate'=>$thoiGianKetThuc,
                        'task_leader'=>$nguoiChinh,
                        'branch_id'=>0,
                        'task_create'=>session('user')
                    ]);

                    DB::table('st_task_detail')
                    ->where('task_id',$id)
                    ->delete();


                    DB::table('st_task_detail')
                    ->insert([
                        'employee_id'=>$nguoiChinh,
                        'task_id'=>$id
                    ]);

                    $out = $this->themNhiemVuNhanVien($nguoiNhan,$id,$chiNhanh);
                    return redirect()->route('getNhiemVuCaNhan',['sms'=>4]);
                }catch(QueryException $ex)
                {
                    return redirect()->route('getCapNhatNhiemVuLeader',['sms'=>0,'id'=>$id]);
                }
    }
    public function getXoaNhiemVu(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXemMarketing = $quyen->getXoaNhiemVu();
            
            if ($quyenXemMarketing == 1) {
                $id = $request->get('id');
                try
                {
                    $id = $request->get('id');
                    DB::table('st_task_detail')
                    ->where('task_id',$id)
                    ->delete();
                    DB::table('st_task')
                    ->where('task_id',$id)
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
    public function themNhiemVuNhanVien($value,$idThongBao,$chiNhanh)
    {
        foreach($value as $item)
        {
            if($item==0)
            {
                if($chiNhanh==0)
                $nhanvien = DB::table('st_employee')
                ->where('employee_status',1)
                ->get();
                else
                $nhanvien = DB::table('st_employee')
                ->where('branch_id',$chiNhanh)
                ->where('employee_status',1)
                ->get();
                foreach($nhanvien as $item2)
                {
                    $nhiemVu = DB::table('st_task_detail')
                    ->where('employee_id',$item2->employee_id)
                    ->where('task_id',$idThongBao)
                    ->get()->first();
                    if(isset($nhiemVu))
                    {

                    }
                    else
                    {
                    DB::table('st_task_detail')
                    ->insert([
                        'task_id'=>$idThongBao,
                        'employee_id'=>$item2->employee_id
                    ]);  
                    }
                }

                return;
            }
            $nhiemVu = DB::table('st_task_detail')
            ->where('employee_id',$item)
            ->where('task_id',$idThongBao)
            ->get()->first();
            if(isset($nhiemVu))
            {

            }
            else
            {
            DB::table('st_task_detail')
            ->insert([
                'task_id'=>$idThongBao,
                'employee_id'=>$item
            ]);
            }
        }
    }
    public function changeChiNhanhCongViec(Request $request)
    {
        if($request->ajax())
        {
            $chiNhanh = $request->get('chiNhanh');
            if($chiNhanh ==0)
                $nhanVien = DB::table('st_employee')
                ->where('employee_status',1)
                ->get();
           else
                $nhanVien = DB::table('st_employee')
                ->where('employee_status',1)
                ->where('branch_id',$chiNhanh)
                ->get();
            
            $nguoiNhan = "<option value='0'>Tất cả</option>";
            $leader ="";

            foreach($nhanVien as $item)
            {
                $nguoiNhan.="<option value='".$item->employee_id."'>".$item->employee_name."</option>";
                $leader.="<option value='".$item->employee_id."'>".$item->employee_name."</option>";
            }
           $arr[]=[
               'leader'=>$leader,
               'nguoiNhan'=>$nguoiNhan
           ];
           return response($arr);

        }
    }

    public function getChiTietNhiemVu(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->get('id');
            $nhiemVu = DB::table('view_task')
            ->where('task_id',$id)
            ->get()->first();
            
            $nhiemVuChiTiet = DB::table('st_task_detail')
            ->join('st_employee','st_employee.employee_id','=','st_task_detail.employee_id')
            ->where('st_task_detail.task_id',$id)
            ->get();

            $tieuDe= $nhiemVu->task_name;
            $noiDung = $nhiemVu->task_content;
            $ngayBatDau = $nhiemVu->task_startDate;
            $ngayKetThuc = $nhiemVu->task_endDate;
            $leader = $nhiemVu->employee_name;
            $nguoiNhan = "";
            foreach($nhiemVuChiTiet as $item)
            {
                $nguoiNhan.=$item->employee_name.", ";
            }

            $arr[]=[
                'tieuDe'=>$tieuDe,
                'noiDung'=>$noiDung,
                'ngayBatDau'=>date('d/m/Y',strtotime($ngayBatDau)),
                'ngayKetThuc'=>date('d/m/Y',strtotime($ngayKetThuc)),
                'leader'=>$leader,
                'nguoiNhan'=>$nguoiNhan,
            ];
            return response($arr);

        }
    }


}
