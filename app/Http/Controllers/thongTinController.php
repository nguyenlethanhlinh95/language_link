<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class thongTinController extends Controller
{
    public function getThongTinCaNhan()
    {
        $idNhanVien = session('user');
        $nhanVien = DB::table('st_employee')
        ->where('employee_id',$idNhanVien)
        ->get()->first();
      
      
            return view('CaNhan.thongTinNhanVien')
            ->with('nhanVien', $nhanVien)
           ;
    }

    public function getDoiMatKhau()
    {
        return view('CaNhan.doiMatKhauNhanVien');
    }
    public function postCapNhatMatKhau(Request $request)
    {
        $idNhanVien = session('user');
        $matKhauMoi = $request->get('matKhauMoi');
        $reMatKhauMoi = $request->get('reMatKhauMoi');
        $matKhauCu = $request->get('matKhauCu');

        if($matKhauMoi==$reMatKhauMoi)
        {
            $nhanVien = DB::table('st_employee')
            ->where('employee_id',$idNhanVien)
            ->where('employee_password',$matKhauCu)
            ->get()->first();

            if(isset($nhanVien))
            {
                try
                {
                    DB::table('st_employee')
                    ->where('employee_id',$idNhanVien)
                    ->update([
                        'employee_password'=>$matKhauMoi
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
                return response(3);
            }
            
        }
        else
        {
            return response(2);
        }
        

    }

    public function postCapNhatCaNhanh(Request $request)
    {
        $idNhanVien = $request->get('id');
        $ten = $request->get('ten');
        $ngaySinh = $request->get('ngaySinh');
        $mail = $request->get('mail');
        $diaChi = $request->get('diaChi');
        $sdt = $request->get('sdt');

        try
        {
            DB::table('st_employee')
            ->where('employee_id',$idNhanVien)
            ->update([
                'employee_name'=>$ten,
                'employee_birthDay'=>$ngaySinh,
                'employee_phone'=>$sdt,
                'employee_email'=>$mail,
                'employee_address'=>$diaChi,
            ]);
            return response(1);

        }
        catch(QueryException $ex)
        {
            return response(0);
        }

    }
}
