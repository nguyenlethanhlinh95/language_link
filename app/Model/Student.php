<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table = 'st_student';
    protected $primaryKey = 'student_id';

    protected $fillable = [
        'student_id', 'student_firstName', 'student_lastName', 'student_lastNameHidden',
        'student_parentName', 'student_birthDay', 'student_parentPhone', 'student_phone',
        'student_email', 'student_address', 'student_img', 'student_status', 'student_dateTime',
        'employee_id', 'student_nickName', 'branch_id', 'student_link', 'student_surplus'
    ];

    /**
     * Get the branch info record associated with the Branch.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    /**
     * The marketings that belong to the students.
     */
    public function marketings()
    {
        return $this->belongsToMany(Marketing::class);
    }
}
