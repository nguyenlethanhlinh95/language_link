<?php

namespace App\Services;


use App\Model\PlacementTest;
use App\Model\Student;
use Illuminate\Support\Facades\DB;

class PlacementTestStudentService
{
    /**
     * Search Student Placement Test
     * @return mixed
     */
    public function searchAllPlacementTestStudentWithPagination($params)
    {
        $pagination = config('constant.pagination');
        $select = [
            'st_placement_test.placementTest_note', 'st_placement_test.placementTest_id', 'st_placement_test.placementTest_dateTime',
            'st_student.student_id', 'st_student.student_lastName', 'st_student.student_firstName', 'st_student.student_phone',
            'st_study_program.studyProgram_name',
            'st_employee.employee_name'
        ];
        $rs = DB::table('st_placement_test')
            ->select($select)
            ->join('st_employee', 'st_employee.employee_id', '=', 'st_placement_test.employee_id')
            ->join('st_student', 'st_student.student_id', '=', 'st_placement_test.student_id')
            ->join('st_study_program', 'st_study_program.studyProgram_id', '=', 'st_placement_test.studyProgram_id')
            ->where('st_student.student_lastName', 'like', '%' . $params['search'] . '%')
            ->orWhere('st_student.student_lastNameHidden', 'like', '%' . $params['search'] . '%')
            ->orWhere('st_student.student_firstName', 'like', '%' . $params['search'] . '%')
            ->paginate($pagination)
            ->appends(request()->all());
        return $rs;
    }

    /**
     * find Placement Test Student By Id
     * @return $plancementTestStudent
     */
    public function findPlacementTestStudentById($id)
    {
        $plancementTestStudent = PlacementTest::query()->findOrFail($id);
        return $plancementTestStudent;
    }

    /**
     * Check status Placement Test Student Fill All Infomation
     * @return boolean
     */
    public function isPlacementTestStudentFillAllInfomation($id)
    {
        $plancementTestStudent = PlacementTest::query()->findOrFail($id);
        if ($plancementTestStudent->placementTest_reading != '') {
            return true;
        }
        if ($plancementTestStudent->placementTest_writing != '') {
            return true;
        }
        if ($plancementTestStudent->placementTest_listening != '') {
            return true;
        }
        if ($plancementTestStudent->placementTest_speaking != '') {
            return true;
        }
        return false;
    }
}