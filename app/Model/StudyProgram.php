<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    //
    protected $primaryKey = 'studyProgram_id';
    protected $table = 'st_study_program';

    protected $fillable = [
        'studyProgram_id', 'studyProgram_name', 'studyProgram_code', 'studyProgram_detail',
        'studyProgram_status', 'studyProgram_number', 'branch_id'
    ];
}
