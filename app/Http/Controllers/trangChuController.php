<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class trangChuController extends Controller
{
    public function getTrangChu(Request $request)
    {
       
        return view('TrangChu.trangChu')
        ;
    }
}
