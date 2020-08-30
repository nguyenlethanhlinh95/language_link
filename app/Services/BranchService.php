<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class BranchService
{
    public function getAllBranch()
    {
        return DB::table('st_branch')->get();
    }
}