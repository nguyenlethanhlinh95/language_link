<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Complex\sec;

class nhanSuController extends Controller
{
    public function getNhanSu()
    {
      

        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemNhanVien();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $nhanSuTong = DB::table('st_employee')
            ->join('st_position','st_position.position_id','=',
            'st_employee.position_id')
                ->select('st_employee.employee_id')
                ->get();
            $nhanSu = DB::table('st_employee')
            ->join('st_position','st_position.position_id','=',
            'st_employee.position_id')
            ->take($lay)
            ->get();
            $chiNhanh = DB::table('st_branch')
            ->get();

            $soKM = count($nhanSuTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
                return view('NhanSu.nhanSu')
                ->with('chiNhanh', $chiNhanh)
                ->with('nhanSu', $nhanSu)
                ->with('soTrang', $soTrang)
                ->with('page', 1);
        }
        else
        {
            return redirect()->back();
        }
    }
    public function getThemNhanSu()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getThemNhanVien();
        if($quyenChiTiet==1)
        {
            $chucVu = DB::table('st_position')
            ->get();
            $nhomQuyen = DB::table('st_permission_group')
            ->get();
            $chiNhanh = DB::table('st_branch')
            ->get();
            $phongBan = DB::table('st_department')
            ->get();
            
                return view('NhanSu.themNhanSu')
                ->with('chucVu', $chucVu)
                ->with('phongBan', $phongBan)
                ->with('chiNhanh', $chiNhanh)
                ->with('nhomQuyen', $nhomQuyen)
               ;
        }
        else
        {
            return redirect()->back();
        }
    }
    public function getCapNhatNhanSu(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getSuaNhanVien();
        if($quyenChiTiet==1)
        {
            $idNhanVien = $request->get('id');

            $nhanVien = DB::table('st_employee')
            ->where('employee_id',$idNhanVien)
            ->get()->first();
            $chucVu = DB::table('st_position')
            ->get();
            $chiNhanh = DB::table('st_branch')
            ->get();
            $nhomQuyen = DB::table('st_permission_group')
            ->get();

            $phongBan = DB::table('st_department')
            ->get();
                return view('NhanSu.capNhatNhanSu')
                ->with('chucVu', $chucVu)
                ->with('phongBan', $phongBan)
                ->with('chiNhanh', $chiNhanh)
                ->with('nhanVien', $nhanVien)
                ->with('nhomQuyen', $nhomQuyen)
               ;
        }
        else
        {
            return redirect()->back();
        }
    }

    public function postThemNhanSu(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemNhanVien();
            if($quyenChiTiet==1)
            {
                try
                {
                    $ten = $request->get('ten');
                    $ngaySinh = $request->get('ngaySinh');
                    $sdt = $request->get('sdt');
                    $mail = $request->get('mail');
                    $diaChi = $request->get('diaChi');
                    $chucVu = $request->get('chucVu');
                    $loaiHopDong = $request->get('loaiHopDong');
                    $ngayBatDau = $request->get('ngayBatDau');
                    $ngayKetThuc = $request->get('ngayKetThuc');
                    $trangThai = $request->get('trangThai');
                    $quyen = $request->get('quyen');
                    $taiKhoan = $request->get('taiKhoan');
                    $matKhau = $request->get('matKhau');
                    $link = $request->get('link');
                    $chiNhanh = $request->get('chiNhanh');

                    $phongBan = $request->get('phongBan');
                    $gioLamViec = $request->get('gioLamViec');
                    $loaiGiaoVien = $request->get('loaiGiaoVien');
                    $soGio = $request->get('soGio');

                    $soGio=(float)$soGio;
                    if($gioLamViec==true)
                    {
                        $trangThaiGioLamVien =1;
                    }
                    else
                    {
                        $trangThaiGioLamVien =0;
                    }

                  

                    $nhanVien = DB::table('st_employee')
                   

                    ->where('employee_account',$taiKhoan)
                    ->get()
                    ->first();
                    if(isset($nhanVien))
                    {
                        return response(3);
                    }
                    else
                    {
                        $thoiGianSinh = substr($ngaySinh,6,4)."-". substr($ngaySinh,0,2)."-". substr($ngaySinh,3,2);
                        $thoiGianBatDau = substr($ngayBatDau,6,4)."-". substr($ngayBatDau,0,2)."-". substr($ngayBatDau,3,2);
                        if($loaiHopDong==0)
                        {
                            $thoiGianKetThuc =Carbon::now('Asia/Ho_Chi_Minh');
                        }
                        else
                        {
                            $thoiGianKetThuc = substr($ngayKetThuc,6,4)."-". substr($ngayKetThuc,0,2)."-". substr($ngayKetThuc,3,2);
                        }
                      
                        $thoiGianNghi =Carbon::now('Asia/Ho_Chi_Minh');
                       
    
                        $chiTietQuyen = DB::table('st_permission_detail')
                        ->where('permissionGroup_id',$quyen)
                        ->get();
    

                        $profileImage = "";
                        if ($files = $request->file('images')) {
                            $destinationPath = public_path('images');
                            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                            $files->move($destinationPath, $profileImage);
                        }

                        $idNhanVien = DB::table('st_employee')
                        ->insertGetId([
                            'employee_name'=>$ten,
                            'employee_birthDay'=>$thoiGianSinh,
                            'employee_phone'=>$sdt,
                            'employee_address'=>$diaChi,
                            'employee_email'=>$mail,
                            'position_id'=>$chucVu,
                            'employee_startDay'=>$thoiGianBatDau,
                            'employee_endDay'=>$thoiGianKetThuc,
                            'permissionGroup_id'=>$quyen,
                            'employee_status'=>$trangThai,
                            'employee_account'=>$taiKhoan,
                            'employee_password'=>$matKhau,
                            'employee_finishedDay'=>$thoiGianNghi,
                            'contractType_id'=>$loaiHopDong,
                            'employee_img'=>$profileImage,
                            'employee_link'=>$link,
                            'branch_id'=>$chiNhanh,
                            'department_id'=>$phongBan,
                            'employee_office'=>$trangThaiGioLamVien,
                            'employee_type'=>$loaiGiaoVien,
                            'employee_numberHours'=>$soGio
                        ]);

                        foreach($chiTietQuyen as $item)
                        {
                            DB::table('st_quyen_chi_tiet_quyen')
                            ->insert([
                                'quyen_id'=>$item->quyen_id,
                                'chiTietQuyen_id'=>$item->chiTietQuyen_id,
                                'quyen_chiTietQuyen_trangThai'=>$item->permissionDetail_status,
                                'employee_id'=>$idNhanVien
                            ]);
                        }

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

    
    public function postCapNhatNhanSu(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaNhanVien();
            if($quyenChiTiet==1)
            {
                try
                {
                    $id = $request->get('id');
                    $ten = $request->get('ten');
                    $ngaySinh = $request->get('ngaySinh');
                    $sdt = $request->get('sdt');
                    $mail = $request->get('mail');
                    $diaChi = $request->get('diaChi');
                    $chucVu = $request->get('chucVu');
                    $loaiHopDong = $request->get('loaiHopDong');
                    $ngayBatDau = $request->get('ngayBatDau');
                    $ngayKetThuc = $request->get('ngayKetThuc');
                    $trangThai = $request->get('trangThai');
                    $quyen = $request->get('quyen');
                    $taiKhoan = $request->get('taiKhoan');
                    $matKhau = $request->get('matKhau');
                    $link = $request->get('link');
                    $chiNhanh = $request->get('chiNhanh');
                    $phongBan = $request->get('phongBan');
                    $gioLamViec = $request->get('gioLamViec');
                  
                    $loaiGiaoVien = $request->get('loaiGiaoVien');
                    $soGio = $request->get('soGio');

                    $soGio=(float)$soGio;
                    if($gioLamViec==true)
                    {
                        $trangThaiGioLamVien =1;
                    }
                    else
                    {
                        $trangThaiGioLamVien =0;
                    }
                   


                        $thoiGianSinh = substr($ngaySinh,6,4)."-". substr($ngaySinh,0,2)."-". substr($ngaySinh,3,2);
                        $thoiGianBatDau = substr($ngayBatDau,6,4)."-". substr($ngayBatDau,0,2)."-". substr($ngayBatDau,3,2);
                        if($loaiHopDong==0)
                        {
                            $thoiGianKetThuc =Carbon::now('Asia/Ho_Chi_Minh');
                        }
                        else
                        {
                            $thoiGianKetThuc = substr($ngayKetThuc,6,4)."-". substr($ngayKetThuc,0,2)."-". substr($ngayKetThuc,3,2);
                        }
                      
                        $thoiGianNghi =Carbon::now('Asia/Ho_Chi_Minh');
                       
    
                        $nhanVien = DB::table('st_employee')
                        ->where('employee_id',$id)
                        ->get()->first();
    
                        
                        $profileImage = "";
                        if ($files = $request->file('images')) {
                            $destinationPath = public_path('images');
                            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                            $files->move($destinationPath, $profileImage);
                        }
                        if($profileImage=="")
                        {
                            $profileImage=$nhanVien->employee_img;
                        }
                        else
                        {
                            if($nhanVien->employee_img != '' && file_exists(public_path('images/'.$nhanVien->employee_img)))
                            {
                                unlink(public_path('images/'.$nhanVien->employee_img));
                            }
                        }
                        
                            DB::table('st_employee')
                            ->where('employee_id',$id)
                           ->update([
                               'employee_name'=>$ten,
                               'employee_birthDay'=>$thoiGianSinh,
                               'employee_phone'=>$sdt,
                               'employee_address'=>$diaChi,
                               'employee_email'=>$mail,
                               'position_id'=>$chucVu,
                               'employee_startDay'=>$thoiGianBatDau,
                               'employee_endDay'=>$thoiGianKetThuc,
                               
                               'employee_status'=>$trangThai,
                               'employee_password'=>$matKhau,
                               'employee_finishedDay'=>$thoiGianNghi,
                               'contractType_id'=>$loaiHopDong,
                               'employee_link'=>$link,
                               'employee_img'=>$profileImage,
                               'branch_id'=>$chiNhanh,
                               'department_id'=>$phongBan,
                               'employee_office'=>$trangThaiGioLamVien,
                               'employee_type'=>$loaiGiaoVien,
                               'employee_numberHours'=>$soGio
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

    public function getXoaNhanSu(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaNhanVien();
            if($quyenChiTiet==1)
            {
                try
                {
                    $id = $request->get('id');
                    DB::table('st_quyen_chi_tiet_quyen')
                    ->where('employee_id',$id)
                    ->delete();
                    DB::table('st_employee')
                    ->where('employee_id',$id)
                    ->delete();
                    return response(1);
                }
                catch(QueryException $ex)
                {
                    return response(0);
                }
            }
            else
            return response(2);
        }
    }

    public function searchNhanSu(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $chiNhanh = $request->get('chiNhanh');
            $page = $request->get('page');
            if ($value == "")
            {
                if($chiNhanh ==0)
                {
                    $khuyenMai = DB::table('view_employee_position')
                   
                        ->take($lay)
                        ->skip(($page - 1) * $lay)
                        ->get();
                }
                else
                {
                    $khuyenMai = DB::table('view_employee_position')
                   
                    ->where('branch_id',$chiNhanh)
                        ->take($lay)
                        ->skip(($page - 1) * $lay)
                        ->get();
                }
            }
               
            else
            {

                if($chiNhanh ==0)
                {
                $khuyenMai = DB::table('view_employee_position')
               
                    ->where('employee_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                }
                else
                {
                    $khuyenMai = DB::table('view_employee_position')
                    
                    ->where('branch_id',$chiNhanh)
                        ->where('employee_name', 'like', '%' . $value . '%')
                        ->take($lay)
                        ->skip(($page - 1) * $lay)
                        ->get();
                }
            }

            $out = "";
            $i = 1;
             foreach ($khuyenMai as $item) {

                $out .= "<tr>
                <td>" . $i . "</td>
                <td>".$item->employee_name."</td>
                <td>".date('d/m/Y',strtotime($item->employee_birthDay)) ."</td>
                <td>".$item->employee_phone."</td>
                <td>".$item->employee_address."</td>
                <td>".$item->employee_email."</td>
                <td>".$item->position_name."</td>
                <td>".date('d/m/Y',strtotime($item->employee_startDay)) ."</td>";
                if($item->contractType_id==0)
                    $out.=" <td>Vô thời hạn</td>";
                elseif($item->contractType_id==1)
                    $out.="<td>Có thời hạn </td>";
                else
                    $out.="<td>Part-time</td>";
                                  
                if($item->contractType_id==0)
                    $out.=" <td></td>";
                else
                    $out.=" <td>".date('d/m/Y',strtotime($item->employee_endDay)) ."</td>";
                                   
                if($item->employee_status==1)
                    $out.=" <td></td>";
                else   
                    $out.=" <td>".date('d/m/Y',strtotime($item->employee_finishedDay)) ."</td>";
                if(session('quyen13')==1)
                    $out.=" <td><a class='btn' href='".route('getCapNhatNhanSu')."?id=".$item->employee_id."'>
                                <i style='color: blue' class='fa fa-edit'></i>
                                </a>
                            </td>";
                                    
                if(session('quyen14')==1)
                    $out.=" <td>
                            <a class='btn' onclick='xoa('".$item->employee_id."');'>
                                            <i style='color: red' class='fa fa-close'></i>
                                        </a>
                                </td>";
                                    
                $out .= " </tr>";
                $i++;
             }
            return response($out);
        }
    }
}
