<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    //
    protected $primaryKey = 'marketing_id';
    protected $table = 'st_marketing';
    protected $fillable = ['marketing_id', 'marketing_name', 'marketing_status'];

    /**
     * The students that belong to the marketings.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
