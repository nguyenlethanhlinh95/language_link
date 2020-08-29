<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class phongHocController extends Controller
{
    public function getPhongHoc(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemPhongHoc();
        if($quyenChiTiet==1)
        {
            $id = $request->get('id');
            $phongHoc = DB::table('st_room')
            ->where('branch_id',$id)
            ->get();
            $chiNhanh = DB::table('st_branch')
            ->where('branch_id',$id)
            ->get()->first();
            return view('ChiNhanh.phongHoc')
            ->with('chiNhanh',$chiNhanh)
            ->with('phongHoc',$phongHoc)
            ;
        }
        else
        return redirect()->back();
    }
    public function postThemPhongHoc(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemPhongHoc();
            if($quyenChiTiet==1)
            {
                $id= $request->get('id');
                $ten= $request->get('ten');
                DB::table('st_room')
                ->insert([
                    'branch_id'=>$id,
                    'room_name'=>$ten
                ]);
                return response(1);
            }
            else
            return response(2);
        }
    }
    public function postCapNhatPhongHoc(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaPhongHoc();
            if($quyenChiTiet==1)
            {
                $id= $request->get('id2');
                $ten= $request->get('ten2');
                DB::table('st_room')
                ->where('room_id',$id)
                ->update([
                    
                    'room_name'=>$ten
                ]);
                return response(1);
            }
            else
            return response(2);
        }
    }
    public function getXoaPhongHoc(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaPhongHoc();
            if($quyenChiTiet==1)
            {
                $id= $request->get('id');
              
                DB::table('st_room')
                ->where('room_id',$id)
                ->delete();
                return response(1);
            }
            else
            return response(2);
        }
    }
}
