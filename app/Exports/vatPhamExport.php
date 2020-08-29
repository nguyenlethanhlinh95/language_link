<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
class vatPhamExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $id = session('idLoaiVatPham');
        $loai = DB::table('st_facility')
        ->where('facilityType_id',$id)
        ->get();
        $arr = [];
        $i =1;
        foreach($loai as $item)
        {
            $arr[]=[
                'stt'=>$i,
                'ten'=>$item->facility_name,
                'donVi'=>$item->facility_unit
            ];
            $i++;
        }
        return collect($arr);
    }
    public function headings(): array
    {
        return [
            'STT',
            'Tên Vật phẩm',
            'Đơn vị tính'
        ];
    }
}
