<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class nhomQuyenController extends Controller
{
    public function getNhomQuyen()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemNhomQuyen();
        if ($quyenChiTiet == 1) {
            $lay = $quyen->layDuLieu();
            $nhomQuyenTong = DB::table('st_permission_group')
                ->select('permissionGroup_id')
                ->get();
            $nhomQuyen = DB::table('st_permission_group')
                ->take($lay)
                ->skip(0)
                ->get();
            $soKM = count($nhomQuyenTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;
    
    
            return view('NhomQuyen.nhomQuyen')
                ->with('nhomQuyen', $nhomQuyen)
                ->with('soTrang', $soTrang)
                ->with('page', 1);
        } else return redirect()->back();
    }

    public function postThemNhomQuyen(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet= $quyen->getThemNhomQuyen();
            if($quyenChiTiet==1)
            {
                $ten = $request->get('ten');
                $trangThai = $request->get('trangThai');

                $quyenCoBan = DB::table('st_quyen')
                ->where('quyen_id','<',100)
                ->get();

                $quyenNangCao = DB::table('st_quyen')
                ->where('quyen_id','>=',100)
                ->get();
                try
                {
                    $id = DB::table('st_permission_group')
                    ->insertGetId([
                        'permissionGroup_name'=>$ten
                    ]);
                    foreach($quyenCoBan as $item)
                    {
                        DB::table('st_permission_detail')
                        ->insert([
                            'quyen_id'=>$item->quyen_id,
                            'chiTietQuyen_id'=>1,
                            'permissionDetail_status'=>$trangThai,
                            'permissionGroup_id'=>$id
                        ]);
                        DB::table('st_permission_detail')
                        ->insert([
                            'quyen_id'=>$item->quyen_id,
                            'chiTietQuyen_id'=>2,
                            'permissionDetail_status'=>$trangThai,
                            'permissionGroup_id'=>$id
                        ]);
                        DB::table('st_permission_detail')
                        ->insert([
                            'quyen_id'=>$item->quyen_id,
                            'chiTietQuyen_id'=>3,
                            'permissionDetail_status'=>$trangThai,
                            'permissionGroup_id'=>$id
                        ]);
                        DB::table('st_permission_detail')
                        ->insert([
                            'quyen_id'=>$item->quyen_id,
                            'chiTietQuyen_id'=>4,
                            'permissionDetail_status'=>$trangThai,
                            'permissionGroup_id'=>$id
                        ]);
                    }
                    foreach($quyenNangCao as $item)
                    {
                        DB::table('st_permission_detail')
                        ->insert([
                            'quyen_id'=>$item->quyen_id,
                            'chiTietQuyen_id'=>1,
                            'permissionDetail_status'=>$trangThai,
                            'permissionGroup_id'=>$id
                        ]);
                    }
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
   public function postCapNhatNhomQuyen(Request $request)
   {
       if($request->ajax())
       {
            $quyen = new quyenController();
            $quyenChiTiet= $quyen->getSuaNhomQuyen();
            if($quyenChiTiet==1)
            {   
                $id = $request->get('id');
                $ten  = $request->get('ten2');


                try{

                     DB::table('st_permission_group')
                     ->where('permissionGroup_id',$id)
                    ->update([
                        'permissionGroup_name'=>$ten
                    ]);
                    return response(1);
                }catch(QueryException $ex)
                {
                    return response(0);
                }
            }
            else
            return response(2);
       }
   
   }

   public function getXoaNhomQuyen(Request $request)
   {
       if($request->ajax())
       {
            $quyen = new quyenController();
            $quyenChiTiet= $quyen->getXoaNhomQuyen();
            if($quyenChiTiet==1)
            {   
                $id = $request->get('id');
                try{
                    DB::table('st_permission_detail')
                    ->where('permissionGroup_id',$id)
                   ->delete();
                     DB::table('st_permission_group')
                     ->where('permissionGroup_id',$id)
                    ->delete();
                    return response(1);
                }catch(QueryException $ex)
                {
                    return response(0);
                }
            }
            else
            return response(2);
       }
   
   }

   public function getChiTietNhomQuyen(Request $request)
   {
        $quyen = new quyenController();
        $quyenChiTiet= $quyen->getXemChiTietNhomQuyen();
        if($quyenChiTiet==1)
        {   
            $id = $request->get('id');
            $nhomQuyen = DB::table('st_permission_group')
            ->where('permissionGroup_id',$id)
            ->get()->first();
            $quyenCoBan = DB::table('st_permission_detail')
                            ->where('permissionGroup_id',$id)
                            ->where('quyen_id','<',100)
                            ->get();
            $quyenNangCao = DB::table('st_permission_detail')
                            ->where('permissionGroup_id',$id)
                            ->where('quyen_id','>=',100)
                            ->get();
            $nhomQuyenCoBan = DB::table('st_quyen')
            ->where('quyen_id','<',100)
            ->get();
            $nhomQuyenNangCao = DB::table('st_quyen')
            ->where('quyen_id','>=',100)
            ->get();
            $chiTietQuyen = DB::table('st_chi_tiet_quyen')
            ->get();
            return view('NhomQuyen.chiTietQuyen')
            ->with('quyenCoBan',$quyenCoBan)
            ->with('quyenNangCao',$quyenNangCao)
            ->with('nhomQuyenCoBan',$nhomQuyenCoBan)
            ->with('nhomQuyenNangCao',$nhomQuyenNangCao)
            ->with('chiTietQuyen',$chiTietQuyen)
            ->with('nhomQuyen',$nhomQuyen)
            ;

        }
            else
            return redirect()->back();
    }

    public function capNhatTrangThaiNhomQuyen(Request $request)
    {
        if($request->ajax())
        {
            $idQuyen = $request->get('idQuyen');
            $idChiTiet = $request->get('idChiTiet');
            $trangThai = $request->get('trangThai');
            $idNhomQuyen = $request->get('idNhomQuyen');

            try
            {
                DB::table('st_permission_detail')
                ->where('quyen_id',$idQuyen)
                ->where('chiTietQuyen_id',$idChiTiet)
                ->where('permissionGroup_id',$idNhomQuyen)
                ->update([
                    'permissionDetail_status'=>$trangThai
                ]);
                return response(1);
            }
            catch(QueryException $ex)
            {
                return response(0);
            }
        }
    }
    public function capNhatTrangThaiNhomQuyenGiaoVien(Request $request)
    {
        if($request->ajax())
        {
            $idQuyen = $request->get('idQuyen');
            $idChiTiet = $request->get('idChiTiet');
            $trangThai = $request->get('trangThai');
            $idNhanVien = $request->get('idNhomQuyen');

            try
            {
                $quyen =  DB::table('st_quyen_chi_tiet_quyen')
                ->where('quyen_id',$idQuyen)
                ->where('chiTietQuyen_id',$idChiTiet)
                ->where('employee_id',$idNhanVien)
                ->get()->first();
                if(isset($quyen))
                {
                    DB::table('st_quyen_chi_tiet_quyen')
                    ->where('quyen_id',$idQuyen)
                    ->where('chiTietQuyen_id',$idChiTiet)
                    ->where('employee_id',$idNhanVien)
                    ->update([
                        'quyen_chiTietQuyen_trangThai'=>$trangThai
                    ]);
                }
                else
                {
                    DB::table('st_quyen_chi_tiet_quyen')
                    ->insert([
                        'quyen_id'=>$idQuyen,
                        'chiTietQuyen_id'=>$idChiTiet,
                        'employee_id'=>$idNhanVien,
                        'quyen_chiTietQuyen_trangThai'=>$trangThai
                    ]);
                   
                }

              
                return response(1);
            }
            catch(QueryException $ex)
            {
                return response(0);
            }
        }
    }

    
    public function searchNhomQuyen(Request $request)
    {
        
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            if ($value == "")
                $khuyenMai = DB::table('st_permission_group')
                   
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            else
                $khuyenMai = DB::table('st_permission_group')
                   
                    ->where('permissionGroup_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();

            $out = "";
            $i = 1;
            foreach ($khuyenMai as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->permissionGroup_name . '</td>     
                ';
                if (session('quyen9011') == 1)
                    $out .= '<td>
                            <a class="btn" href=\'' . route('getChiTietNhomQuyen') . '?id=' . $item->permissionGroup_id . '\'>
                             Chi tiết
                                        </a>
                        </td>';

                if (session('quyen903') == 1)
                    $out .= '<td>
                            <a class="btn" data-toggle="modal" data-target="#basicModal2"
                            onclick="setValue(\''.$item->permissionGroup_id.'\',\''.$item->permissionGroup_name.'\')">
                                <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                        </td>';
                if (session('quyen904') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->permissionGroup_id . '\');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>';
                $out .= ' </tr>';
                $i++;
            }
            return response($out);
        }
    }

    public function getQuyenGiaoVien(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemQuyenGiaoVien();
        if($quyenChiTiet==1)
        {
            $lay = $quyen->layDuLieu();
            $giaoVien = DB::table('st_employee')
            ->take($lay)
            ->skip(0)
            ->get();
         
            $giaoVienTong = DB::table('st_employee')
                ->select('employee_id')
                ->get();
           
            $soKM = count($giaoVienTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;


            return view('NhomQuyen.quyenGiaoVien')
            ->with('page', 1)
                ->with('soTrang', $soTrang)
            ->with('giaoVien',$giaoVien)
            ;
        }
        else
        {
            return redirect()->back();
        }
    }

    public function searchNhomQuyenGiaoVien(Request $request)
    {
        
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            if ($value == "")
                $khuyenMai = DB::table('st_employee')
                   
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            else
                $khuyenMai = DB::table('st_employee')
                   
                    ->where('employee_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();

            $out = "";
            $i = 1;
            foreach ($khuyenMai as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->employee_name . '</td>     
                ';
               
                    $out .= '<td>
                            <a class="btn" href=\'' . route('getChiTietNhomQuyenGiaoVien') . '?id=' . $item->employee_id . '\'>
                             Chi tiết
                                        </a>
                        </td>';

                
                $out .= ' </tr>';
                $i++;
            }
            return response($out);
        }
    }

    public function getChiTietNhomQuyenGiaoVien(Request $request)
    {
         $quyen = new quyenController();
         $quyenChiTiet= $quyen->getXemChiTietNhomQuyen();
         if($quyenChiTiet==1)
         {   
             $id = $request->get('id');
             $nhomQuyen = DB::table('st_employee')
             ->where('employee_id',$id)
             ->get()->first();
             $quyenCoBan = DB::table('st_quyen_chi_tiet_quyen')
                             ->where('employee_id',$id)
                             ->where('quyen_id','<',100)
                             ->get();
             $quyenNangCao = DB::table('st_quyen_chi_tiet_quyen')
                             ->where('employee_id',$id)
                             ->where('quyen_id','>=',100)
                             ->get();
             $nhomQuyenCoBan = DB::table('st_quyen')
             ->where('quyen_id','<',100)
             ->get();
             $nhomQuyenNangCao = DB::table('st_quyen')
             ->where('quyen_id','>=',100)
             ->get();
             $chiTietQuyen = DB::table('st_chi_tiet_quyen')
             ->get();
             return view('NhomQuyen.chiTietQuyenGiaoVien')
             ->with('quyenCoBan',$quyenCoBan)
             ->with('quyenNangCao',$quyenNangCao)
             ->with('nhomQuyenCoBan',$nhomQuyenCoBan)
             ->with('nhomQuyenNangCao',$nhomQuyenNangCao)
             ->with('chiTietQuyen',$chiTietQuyen)
             ->with('nhomQuyen',$nhomQuyen)
             ;
 
         }
             else
             return redirect()->back();
     }

}
