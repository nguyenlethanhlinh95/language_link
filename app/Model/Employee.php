<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $table = 'st_employee';
    protected $primaryKey = 'employee_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'employee_name', 'employee_birthDay', 'employee_phone', 'employee_address',
        'employee_email', 'position_id', 'employee_startDay', 'employee_endDay', 'contractType_id',
        'permissionGroup_id', 'employee_account', 'employee_password', 'employee_status', 'employee_finishedDay',
        'employee_img', 'employee_link', 'branch_id', 'department_id', 'employee_office', 'employee_type', 'employee_numberHours'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'employee_password',
    ];

    /**
     * The placementTest that belong to the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function placementTests()
    {
        return $this->belongsToMany(PlacementTest::class, 'employee_id', 'employee_id');
    }
}
