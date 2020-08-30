<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    //
    protected $table = 'st_branch';
    protected $primaryKey = 'branch_id';

    protected $fillable = [
        'branch_id', 'branch_code', 'branch_name', 'branch_address',
        'branch_phone', 'branch_mail', 'branch_detail', 'branch_status',
        'branch_logo', 'branch_link'
    ];

    /**
     * Get the students list record associated with the Students.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'branch_id', 'branch_id');
    }

    /**
     * Get the employee list record associated with the Employees.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'branch_id', 'branch_id');

    }
}
