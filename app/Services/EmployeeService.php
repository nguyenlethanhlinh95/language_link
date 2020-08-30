<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class EmployeeService
{
    /**
     * Get list employee
     * @param $branchId $attributes
     * @return mixed
     */
    public function getAllEmployeeFromBranch($branchId, $pagination)
    {
        $pagination = config('constant.pagination');
        $employeesFromBranch = DB::table('st_employee')
                    ->join('st_position','st_position.position_id','=','st_employee.position_id')
                    ->where('branch_id', $branchId)
                    ->take($pagination)
                    ->get();
        return $employeesFromBranch;
    }

    /**
     * Get All employee
     * @return mixed
     */
    public function getAllEmployee($pagination=20)
    {
        $employees = DB::table('st_employee')
                            ->join('st_position','st_position.position_id','=', 'st_employee.position_id')
                            ->take($pagination)
                            ->get();
        return $employees;
    }

    /**
     * Get Total employee
     * @return mixed
     */
    public function getTotalEmployee()
    {
        $emplyees = DB::table('st_employee')
                ->join('st_position','st_position.position_id','=','st_employee.position_id')
                ->select('st_employee.employee_id')
                ->count();
        return $emplyees;
    }
}