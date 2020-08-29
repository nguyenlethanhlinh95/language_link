<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class loginController extends Controller
{
    public function getLogin()
    {
        return view('Login.login')
        ->with('sms',3);
    }
    public function getLogout()
    {
        session(['user' => null]);
        return redirect()->route('getLogin');
    }
    
    public function postLogin(Request $request)
    {

            $userName = $request->get('userName');
            $password = $request->get('password');
        
            $nhanVien = DB::table('st_employee')
                ->where('employee_account',$userName)
                ->where('employee_password',$password)
                ->where('employee_status',1)
                ->get()->first();
            if (isset($nhanVien))
            {
                if($nhanVien->employee_status==1)
                {
                    session(['user' => $nhanVien->employee_id]);
                    $quyen =  DB::table('view_quyen_chi_tiet_quyen')
                    ->where('employee_id',session('user'))
                    ->get();
                    session(['coSo' => $nhanVien->branch_id]);
                    session(['userImg' => $nhanVien->employee_img]);
                    session(['userLink' => $nhanVien->employee_link]);
                    foreach($quyen as $item)
                    {
                        session(['quyen'.$item->quyen_id.$item->chiTietQuyen_id=>$item->quyen_chiTietQuyen_trangThai]);
                    }
                    if ($nhanVien->permissionGroup_id==1)
                    {
                        session(['quyen' => 1]);
                        // return response(1);
                        return redirect()->route('getTrangChu');
                    }
                    else
                    {
                        session(['quyen' => 3]);
                        // return response(1);
                        return redirect()->route('getTrangChu');
                    }
                   
                }
                else
                {
                    // return  response(2);
                    return view('Login.login')
                    ->with('sms',"2");
                }
                
        
            }
            else
            {
               // return response(0);
                return view('Login.login')
                ->with('sms',"0");
            }
    }
}
