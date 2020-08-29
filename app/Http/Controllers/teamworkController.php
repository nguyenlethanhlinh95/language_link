<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class teamworkController extends Controller
{
    public function getTeam()
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemTeam();

        if($quyenChiTiet==1)
        {
            $quyenTatCa = $quyen->getXemTatCaTeam();
            $lay = $quyen->layDuLieu();
            if($quyenTatCa==1)
            {
                $team = DB::table('st_team')
                ->join('st_branch','st_branch.branch_id','=','st_team.branch_id')
                ->take($lay)
                ->skip(0)
                ->get();
                $teamTong  = DB::table('st_team')
                ->join('st_branch','st_branch.branch_id','=','st_team.branch_id')
                ->get();
                $chiNhanh = DB::table('st_branch')
                ->get();
            }
            else
            {
                $team = DB::table('st_team')
                ->join('st_branch','st_branch.branch_id','=','st_team.branch_id')
                ->where('st_branch.branch_id',session('coSo'))
                ->take($lay)
                ->skip(0)
                ->get();
                $chiNhanh = DB::table('st_branch')
              
                ->where('branch_id',session('coSo'))
                ->get();
                $teamTong  = DB::table('st_team')
                ->join('st_branch','st_branch.branch_id','=','st_team.branch_id')
                ->where('st_branch.branch_id',session('coSo'))
                ->get();

            }

            $soKM = count($teamTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;


            return view('Team.team')  
            ->with('team', $team)
            ->with('chiNhanh', $chiNhanh)
            ->with('soTrang', $soTrang)
            ->with('page', 1);
            
        }
        else
        {
            return redirect()->back();
        }

    }

    public function postThemTeam(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemTeam();
            if($quyenChiTiet==1)
            {
                $ten = $request->get('ten');
                $chiNhanh = $request->get('chiNhanh');

                try
                {
                    DB::table('st_team')
                    ->insert([
                        'team_name'=>$ten,
                        'branch_id'=>$chiNhanh
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
    public function postCapNhatTeam(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaTeam();
            if($quyenChiTiet==1)
            {
                $id= $request->get('id2');
                $ten = $request->get('ten2');
                $chiNhanh = $request->get('chiNhanh2');

                try
                {
                    DB::table('st_team')
                    ->where('team_id',$id)
                    ->update([
                        'team_name'=>$ten,
                        'branch_id'=>$chiNhanh
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
    

    public function getXoaTeam(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getSuaTeam();
            if($quyenChiTiet==1)
            {
                $id= $request->get('id');
               

                try
                {
                    DB::table('st_team')
                    ->where('team_id',$id)
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

    public function searchTeam(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            $quyenTatCa = $quyen->getXemTatCaTeam();
            if($quyenTatCa==1)
            {
                if ($value == "")
                {
                    $team = DB::table('view_team_branch')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                }
                else
                {
                    $team = DB::table('view_team_branch')
                   
                    ->where(function ($query) use ($value)
                    {
                        $query->where('branch_name', 'like', '%' . $value . '%')
                        ->orwhere('team_name', 'like', '%' . $value . '%');
                    })
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                }
            }
            else
            {
                if ($value == "")
                {
                    $team = DB::table('view_team_branch')
                    ->where('branch_id',session('coSo'))
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                }
                else
                {
                    $team = DB::table('view_team_branch')
                    ->where('branch_id',session('coSo'))
                    ->where(function ($query) use ($value)
                    {
                        $query->where('branch_name', 'like', '%' . $value . '%')
                        ->orwhere('team_name', 'like', '%' . $value . '%');
                    })
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                }
            }

            $out = "";
            $i = 1;
            foreach ($team as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->branch_name . '</td>   
                <td>' . $item->team_name . '</td>';

                if(session('quyen371')==1)
                $out .= '  <td><a class="btn" href="'. route('getNhanVienTeam') .'?id='. $item->team_id .'"><i class="fa fa-list"></i></a></td>
               ';

                if (session('quyen363') == 1)
                    $out .= '<td>
                            <a class="btn" data-toggle="modal" data-target="#basicModal2" 
                            onclick="setValue(\''. $item->team_id .'\',\''. $item->team_name .'\'
                            ,\''. $item->branch_id .'\')">
                                <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                        </td>';
                if (session('quyen364') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->team_id . '\');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>';
                $out .= ' </tr>';
                $i++;
            }
            return response($out);
        }
    }


    public function getNhanVienTeam(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemTeamNhanVien();
        if($quyenChiTiet==1)
        {
            $id = $request->get('id');
            $team = DB::table('st_team')
            ->where('team_id',$id)
            ->get()->first();
            $teamNhanVien = DB::table('st_team_employee')
            ->join('st_employee','st_employee.employee_id','=',
            'st_team_employee.employee_id')
            ->where('st_team_employee.team_id',$id)
            ->where('st_employee.employee_status',1)
            ->get();
            $nhanVien = DB::table('st_employee')
            ->where('branch_id',$team->branch_id)
            ->where('employee_status',1)
            ->get();

            return view('Team.teamNhanVien')
            ->with('team',$team)
            ->with('teamNhanVien',$teamNhanVien)
            ->with('nhanVien',$nhanVien)
            ;
        }
        else
        {
            return redirect()->back();
        }
    }

    public function postThemTeamNhanVien(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getThemTeamNhanVien();
            if($quyenChiTiet==1)
            {
                $id = $request->get('id');
                    $nhanVien = $request->get('nhanVien');
                $nhanVienTeam =   DB::table('st_team_employee')
                ->where('team_id',$id)
                ->where('employee_id',$nhanVien)
                ->get()->first();
                if(isset($nhanVienTeam))
                {
                    return response(3);
                }
                else
                {
                    try
                    {
                        
    
                        DB::table('st_team_employee')
                        ->insert([
                            'team_id'=>$id,
                            'employee_id'=>$nhanVien
                        ]);
                        return response(1);
                    }
                    catch(QueryException $ex)
                    {
                        return response(0);
    
                    }
                }
               
            }
            else
            {
                return response(2);
            }
        }
    }

    public function getXoaTeamNhanVien(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaTeamNhanVien();
            if($quyenChiTiet==1)
            {
                $id = $request->get('id');
                   
                    try
                    {
                        DB::table('st_team_employee')
                        ->where('teamEmployee_id',$id)
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
    public function searchTeamNhanVien(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            $id  = $request->get('id');
           
                if ($value == "")
                {
                    $team = DB::table('st_team_employee')
                    ->join('st_employee','st_employee.employee_id','=',
                    'st_team_employee.employee_id')
                    ->where('st_team_employee.team_id',$id)
                    ->where('st_employee.employee_status',1)
                    ->get();
                   
                }
                else
                {
                    $team = DB::table('st_team_employee')
                    ->join('st_employee','st_employee.employee_id','=',
                    'st_team_employee.employee_id')
                    ->where('st_team_employee.team_id',$id)
                    ->where('st_employee.employee_status',1)
                    ->where('st_employee.employee_name', 'like', '%' . $value . '%')
                    ->get();
                   
                }
          
            $out = "";
            $i = 1;
            foreach ($team as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
              
                <td>' . $item->employee_name . '</td>';

                if (session('quyen374') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->teamEmployee_id . '\');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>';
                $out .= ' </tr>';
                $i++;
            }
            return response($out);
        }
    }
}
