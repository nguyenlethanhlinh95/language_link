<?php

namespace App\Exports;

use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    { 
        $idClass = session()->get('idLopHoc');
        $lopHoc = DB::table('st_class')
        ->where('class_id',$idClass)
        ->get()->first();
        $key =  array();
        $LoaiketQua = DB::table('st_learning_outcome_type')
        ->where('course_id',$lopHoc->course_id)
        ->get();
        array_push($key,"No");
        array_push($key,"Student names");
        $hocVien = DB::table('st_class_student')
        ->join('st_student','st_student.student_id','=','st_class_student.student_id')
        ->where('st_class_student.class_id',$idClass)
        ->orderBy('st_student.student_lastName')
        ->get();
      

        $i =1;
        $arr = [];
        foreach($hocVien as $item3)
        {

            $arrDuLieu[$i-1][0]=$i;
            $arrDuLieu[$i-1][1]=$item3->student_firstName." ". $item3->student_lastName;
            $x=2;
            foreach($LoaiketQua as $item)
            {
                $ketQua = DB::table('st_learning_outcomes')
                ->where('learningOutcomeType_id',$item->learningOutcomeType_id)
                ->get();
                $phanTram=0;
                $tongDiem =0;
                foreach($ketQua as $item2)
                {
                    $diemThi = DB::table('st_learning_outcomes_student')
                    ->where('classStudent_id',$item3->classStudent_id)
                    ->where('learningOutcome_id',$item2->learningOutcome_id)
                    ->get()->first();
                    if(isset($diemThi))
                    {
                        $comment = $diemThi->learningOutcomeStudent_comment;
                        if($item2->learningOutcome_type==1)
                        {
                            if($item2->learningOutcome_point>0)
                            $tongDiem += $comment/$item2->learningOutcome_point;
                        }
                    }
                    else
                    {
                        $comment = "";
                    }
                 
                    $arrDuLieu[$i-1][$x]=$comment;
                    $x++;
                }
                $soKetQua = count($ketQua);
                if($soKetQua>0)
                $phanTram = ($tongDiem * $item->learningOutcomeType_percent)/$soKetQua;
                $arrDuLieu[$i-1][$x]=$phanTram;
                $x++;
            }
            $i++ ;
        }
        

        return collect($arrDuLieu);
    }
    public function headings(): array
    {
        $idClass = session()->get('idLopHoc');
        $lopHoc = DB::table('st_class')
        ->where('class_id',$idClass)
        ->get()->first();

        $LoaiketQua = DB::table('st_learning_outcome_type')
        ->where('course_id',$lopHoc->course_id)
        ->get();

        $key =  array();
        array_push($key,"No");
        array_push($key,"Student names");
        foreach($LoaiketQua as $item)
        {
            $ketQua = DB::table('st_learning_outcomes')
            ->where('learningOutcomeType_id',$item->learningOutcomeType_id)
            ->get();
            foreach($ketQua as $item2)
            {
                array_push($key,$item2->learningOutcome_name);
            }
            array_push($key,$item->learningOutcomeType_name." Total Mark");   
        }


        return $key;
    }
}
