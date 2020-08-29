<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\DB;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if (empty(session('user'))) {
            return redirect()->route('getLogin');
        }
        
        $loaiVatPham = DB::table('st_facility_type')
        ->get();
        $arr = [];
        foreach($loaiVatPham as $item)
        {
            $arr[]=[
                'id'=>$item->facilityType_id,
                'ten'=>$item->facilityType_name
            ];
        }
        $thoiGianHienTai = Carbon::now('Asia/Ho_Chi_Minh');
        $congViecHoanThanh = DB::table('view_task_detail')
       ->where('employee_id',session('user'))
       ->where('task_status',4)
       ->count();
       $congViecChuaLam = DB::table('view_task_detail')
       ->where('employee_id',session('user'))
       ->where('task_status',0)
       ->count();
       $congViecDangLam = DB::table('view_task_detail')
       ->where('employee_id',session('user'))
       ->whereDate('task_startDate','<=',$thoiGianHienTai)
       ->whereDate('task_endDate','>=',$thoiGianHienTai)
       ->where('task_status','>=',1)
       ->where('task_status','<=',3)
       ->count();
       $congViecTre = DB::table('view_task_detail')
       ->where('employee_id',session('user'))
       ->whereDate('task_endDate','<',$thoiGianHienTai)
       ->where('task_status','>=',1)
       ->where('task_status','<=',3)
       ->count();

       session(['viecHT'=>$congViecHoanThanh]);
       session(['viecTre'=>$congViecTre]);
       session(['ViecCho'=>$congViecChuaLam]);
       session(['ViecDangLam'=>$congViecDangLam]);

        $thongBao = DB::table('st_notification')
        ->join('st_branch','st_branch.branch_id','=','st_notification.branch_id')
        ->where('st_notification.notification_leader',session('user'))
        ->where('st_notification.notification_status',0)
        ->get();
        $arrThongBao = [];
        foreach($thongBao as $item)
        {
            $now = new Carbon($item->notification_deadline);
            $now->addHour(-2);
            $arrThongBao[]=[
                'id'=>$item->notification_id,
                'ten'=>$item->notification_content,
                'thoiGian'=>$now,
                'chiNhanh'=>$item->branch_name
            ];
        }
        session(['thongBao'=>null]);
        session(['thongBao'=>$arrThongBao]);
        session(['loaiVatPham'=>$arr]);
        return $next($request);
    }
}
