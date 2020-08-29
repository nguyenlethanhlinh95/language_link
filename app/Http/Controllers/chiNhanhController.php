<?php

namespace App\Http\Controllers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class chiNhanhController extends Controller
{
    public function getChiNhanh(Request $request)
    {
        $quyen = new quyenController();
        $quyenXem = $quyen->getXemChiNhanh();
        if ($quyenXem== 1) {
           $chiNhanh = DB::table('st_branch')
           ->get();
           return view('ChiNhanh.chiNhanh')
           ->with('chiNhanh',$chiNhanh);

        }
         else
        return redirect()->back();
    }


    public function getThemChinhanh(Request $request)
    {
        $quyen = new quyenController();
        $quyenThem = $quyen->getThemChiNhanh();
        if ($quyenThem== 1) {
           return view('ChiNhanh.themChiNhanh')
                ->with('sms',3);
        }
         else
            return redirect()->back();
    }
    public function postThemChiNhanh(Request $request)
    {
            $ten = $request->get('ten');
            $ma = $request->get('ma');
            $sdt = $request->get('sdt');
            $mail = $request->get('mail');
            $diaChi = $request->get('diaChi');
            $chiTiet = $request->get('chiTiet');
            $link = $request->get('link');
            if($link=="")
            $link="";
            if($chiTiet=="")
            $chiTiet="";
            $quyen = new quyenController();
            $quyenThem = $quyen->getThemChiNhanh();
            if ($quyenThem== 1) {
                try
                {

                    $profileImage = "";
                    if ($files = $request->file('logo')) {
                        $destinationPath = public_path('images');
                        $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                        $files->move($destinationPath, $profileImage);
                    }
                   
                    DB::table('st_branch')
                    ->insert([
                        'branch_code'=>$ma,
                        'branch_name'=>$ten,
                        'branch_address'=>$diaChi,
                        'branch_phone'=>$sdt,
                        'branch_mail'=>$mail,
                        'branch_detail'=>$chiTiet,
                        'branch_status'=>1,
                        'branch_link'=>$link,
                        'branch_logo'=>$profileImage
                    ]);
                    return view('ChiNhanh.themChiNhanh')
                    ->with('sms', 1);
                }
                catch(QueryExecuted $ex)
                {
                    return view('ChiNhanh.themChiNhanh')
                    ->with('sms', 0);
                }
            }
            else
            return view('ChiNhanh.themChiNhanh')
            ->with('sms', 2);
   
    }

    public function getCapNhatChiNhanh(Request $request)
    {
        $quyen = new quyenController();
        $quyenSua = $quyen->getSuaChiNhanh();
        if ($quyenSua== 1) {
           return view('ChiNhanh.capNhatChiNhanh')
                ->with('sms',"");
        }
         else
            return redirect()->back();
    }
    public function postCapNhatChiNhanh(Request $request)
    {
            $id = $request->get('id');
            $ten = $request->get('ten');
            $ma = $request->get('ma');
            $sdt = $request->get('sdt');
            $mail = $request->get('mail');
            $diaChi = $request->get('diaChi');
            $chiTiet = $request->get('chiTiet');
            $quyen = new quyenController();
            $quyenSua = $quyen->getSuaChiNhanh();
            if ($quyenSua== 1) {
                try
                {
                    $link = $request->get('link');
                    if($link=="")
                    $link="";
                    if($chiTiet=="")
                    $chiTiet="";
                    $profileImage = "";
                    if ($files = $request->file('logo')) {
                        $destinationPath = public_path('images');
                        $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                        $files->move($destinationPath, $profileImage);
                    }

                    DB::table('st_branch')
                    ->where('branch_id',$id)
                    ->update([
                        'branch_code'=>$ma,
                        'branch_name'=>$ten,
                        'branch_address'=>$diaChi,
                        'branch_phone'=>$sdt,
                        'branch_mail'=>$mail,
                        'branch_detail'=>$chiTiet,
                        'branch_status'=>1,  
                        'branch_link'=>$link,
                        'branch_logo'=>$profileImage
                    ]);

                    return redirect()->route('getCapNhatChiNhanh', ['id' => $id,'sms'=>1]);
                   
                }
                catch(QueryExecuted $ex)
                {
                    return redirect()->route('getCapNhatChiNhanh', ['id' => $id,'sms'=>0]);
                   
                }
            }
            else
            return redirect()->route('getCapNhatChiNhanh', ['id' => $id,'sms'=>2]);
                   
   
    }

    public function getXoaChiNhanh(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenXoa = $quyen->getXoaChiNhanh();
            if ($quyenXoa== 1) {
                try
                {
                    $id = $request->get('id');
                    DB::table('st_branch')
                        ->where('branch_id',$id)
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

    public function searchChiNhanh(Request $request)
    {
        $quyen = new quyenController();
          
            $value = $request->get('value');
           
            if($value=="")
            $marketing = DB::table('st_branch')

                    ->get();
            else
            $marketing = DB::table('st_branch')
                    ->where('branch_name','like','%'.$value.'%')
                    
                    ->get();

            $out="";
            $i=1;
            foreach($marketing as $item)
            {
               
                $out.='<tr>
                <td>'.$i.'</td>';
                if(session('quyen341')==1)
                $out.='<td><a href="'.route('getPhongHoc').'?id='.$item->branch_id.'">'.$item->branch_name.'</a></td>';
                else
                $out.='<td>'.$item->branch_name.'</td>';

                $out.='<td>'.$item->branch_code.'</td>
                <td>'.$item->branch_phone.'</td>
                <td>'.$item->branch_address.'</td>
                <td>'.$item->branch_mail.'</td>';
                if(session('quyen333')==1)
                $out.='  <td><a class="btn" href="'.route('getCapNhatChiNhanh').'?id='.$item->branch_id.'">
                        <i style="color: blue"  class="fa fa-edit"></i>
                    </a>
                </td>';

                if(session('quyen334')==1)
                $out.='<td>
                    <a class="btn" onclick="xoa(\''.$item->branch_id .'\');">
                        <i style="color: red" class="fa fa-close"></i>
                    </a>
                </td>';
                $out.='</tr>';
                $i++;
            }
            return response($out);
        
    }
    
}
