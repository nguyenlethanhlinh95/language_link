<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class vatPhamImport implements ToModel
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
            $id = session('idLoaiVatPham');
            foreach ($row as  $value) {
                
                
                if( $i >= 3 && $row[0]!="STT")
                DB::table('st_facility')
                ->insert([
                    'facility_name'=>$row[1],
                    'facility_unit'=>$row[2],
                    'facilityType_id'=>$id
                ]);
                $i++;
               
            }
            
        return ;
    }
}
