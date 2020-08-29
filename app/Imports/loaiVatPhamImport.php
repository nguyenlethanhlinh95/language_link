<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class loaiVatPhamImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $arr=[];
            $i=1;
            $dem =1;
            foreach ($row as  $value) {
                
                
                if( $i >= 4 && $row[0]!="STT")
                DB::table('st_facility_type')
                ->insert([
                    'facilityType_name'=>$row[1]
                ]);
                $i++;
               
            }
            
        return ;
    }
}
