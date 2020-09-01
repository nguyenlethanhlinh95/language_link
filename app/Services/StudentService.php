<?php

namespace App\Services;


use App\Model\Student;
use Illuminate\Support\Facades\DB;

class StudentService
{
    /**
     * Get Total record student
     *
     * @return integer | null
     */
    public function getTotalStudent()
    {
        return DB::table('st_student')->count();
    }

    /**
     * Get take student
     *
     * @return $students | null
     */
    public function getTakeStudent($take) {
        $user = getUserLogin();
        if ($user['employee_account'] != config('constant.ADMIN')) {
            $students = DB::table('st_student')
                ->where('branch_id', $user['branch_id'])
                ->orderBy('student_lastName')
                ->orderByDesc('student_dateTime')
                ->paginate($take);
        } else {
            $students = DB::table('st_student')
                ->orderBy('student_lastName')
                ->orderByDesc('student_dateTime')
                ->paginate($take);

        }
        return $students;
    }

    /**
     * Search student
     *
     * @param $value
     * @param $branch
     * @param $pagination
     *
     * @return $students | null
     */
    public function searchStudent($value, $pagination) {
        $user = getUserLogin();
        if ($user['employee_account'] == config('constant.ADMIN')) {
            $marketing = DB::table('st_student')
                ->orderBy('student_lastName')
                ->where('student_firstName', 'like', '%' . $value . '%')
                ->orwhere('student_lastName', 'like', '%' . $value . '%')
                ->orwhere('student_lastNameHidden', 'like', '%' . $value . '%')
                ->orwhere('student_nickName', 'like', '%' . $value . '%')
                ->orwhere('student_phone', 'like', '%' . $value . '%')
                ->orwhere('student_parentPhone', 'like', '%' . $value . '%')
                ->orderByDesc('student_dateTime')
                ->paginate($pagination)
                ->appends(request()->all());
        } else {
            $marketing = DB::table('st_student')
                ->orderBy('student_lastName')
                ->where('branch_id', $user['branch_id'])
                ->where(function($query) use ($value, $pagination){
                    return $query->where('student_firstName', 'like', '%' . $value . '%')
                        ->orwhere('student_lastName', 'like', '%' . $value . '%')
                        ->orwhere('student_lastNameHidden', 'like', '%' . $value . '%')
                        ->orwhere('student_nickName', 'like', '%' . $value . '%')
                        ->orwhere('student_phone', 'like', '%' . $value . '%')
                        ->orwhere('student_parentPhone', 'like', '%' . $value . '%')
                        ->orderByDesc('student_dateTime');
                    })
                ->paginate($pagination)
                ->appends(request()->all());
        }
        return $marketing;

    }

    /**
     * Search searchStudentView
     *
     * @param $params
     *
     * @return $students | null
     */
    public function searchStudentView($params)
    {
        $searchByName = $params['search_by_name'];
        $pagination = config('constant.pagination');
        $students = $this->searchStudent($searchByName, $pagination, $params);
        return $students;
    }

    /**
     * Get Student By Id
     *
     * @param $id
     *
     * @return $student
     */
    public function findStudentById($id)
    {
        $student = Student::query()
            ->findOrFail($id);
        return $student;
    }

    /**
     * Get All marketing By Student Id
     *
     * @param $id
     *
     * @return $student
     */
    public function getAllMarketingByStudentId($id)
    {
        $marketings = DB::table('st_student_marketing')
            ->where('student_id', $id)
            ->get();
        return $marketings;
    }

    /**
     * Get All marketing By Student Id
     *
     * @param $id
     *
     * @return $student
     */
    public function searchAllStudentRegistered($params)
    {
        $keyword = $params['q'];
        $students = DB::table('st_student')
            ->where('student_firstName', 'like', '%' . $keyword . '%')
            ->orwhere('student_lastName', 'like', '%' . $keyword . '%')
            ->orwhere('student_lastNameHidden', 'like', '%' . $keyword . '%')
            ->orwhere('student_phone', 'like', '%' . $keyword . '%')
            ->orwhere('student_parentPhone', 'like', '%' . $keyword . '%')
            ->orderByDesc('student_dateTime')
            ->paginate(config('constant.pagination'))
            ->appends(request()->all());
        return $students;
    }

    public function isNickNameExist($nickName)
    {
        $Student = DB::table('st_student')
            ->select('student_id')
            ->where('student_nickName', $nickName)
            ->first();
        if (!is_null($Student)) {
            return true;
        }
        return false;
    }
}