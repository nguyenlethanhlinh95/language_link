<?php

namespace App\Exports;

use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class loaiVatPhamExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $loai = DB::table('st_facility_type')
        ->get();
        $arr = [];
        $i =1;
        foreach($loai as $item)
        {
            $arr[]=[
                'stt'=>$i,
                'ten'=>$item->facilityType_name
            ];
            $i++;
        }
        

        return collect($arr);
    }
    public function headings(): array
    {
        return [
            'STT ',
            'Tên Loại vật phẩm'
        ];
    }
}
