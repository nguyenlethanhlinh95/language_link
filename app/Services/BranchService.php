<?php

namespace App\Services;


use App\Model\Branch;
use Illuminate\Support\Facades\DB;

class BranchService
{
    public function getAllBranch()
    {
        return DB::table('st_branch')->get();
    }

    public function getBranchNameFromUserLogin()
    {
        $user = getUserLogin();
        $branchName = Branch::query()
            ->where('branch_id', $user['branch_id'])
            ->select('branch_name')
            ->first();
        return $branchName->branch_name;
    }
}