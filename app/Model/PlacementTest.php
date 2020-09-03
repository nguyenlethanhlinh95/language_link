<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PlacementTest extends Model
{
    //
    protected $primaryKey = 'placementTest_id';

    protected $table = 'st_placement_test';

    protected $fillable = [
      'student_id', 'employee_id', 'studyProgram_id', 'course_id', 'course_id2',
      'placementTest_dateTime', 'placementTest_note', 'placementTest_reading', 'placementTest_writing',
      'placementTest_listening', 'placementTest_speaking', 'placementTest_status', 'placementTest_reason',
      'placementTest_classStatus'
    ];

    /**
     * The placementTest that belong to the teacher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    /**
     * The placementTest that belong to the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');

    }

    /**
     * Get the study Program record associated.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class,'studyProgram_id', 'studyProgram_id');
    }
}
