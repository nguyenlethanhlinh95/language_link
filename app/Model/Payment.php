<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'st_payment';
    protected $primaryKey = 'payment_id';
    protected $fillable = [
        'payment_title', 'payment_content', 'payment_amount', 'payment_created_day', 'payment_note', 'employee_id'
    ];

    public $timestamps = false;

    /**
     * The Payment that belong to the employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
