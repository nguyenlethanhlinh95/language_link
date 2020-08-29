<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class phieuThuController extends Controller
{
    public function getPhieuThu(Request $request)
    {
        $quyen = new quyenController();
        $quyenChiTiet = $quyen->getXemPhieuThu();

        if($quyenChiTiet==1)
        {
            $quyenXemTatCa = $quyen->getXemTatCaPhieuThu();
            $lay = $quyen->layDuLieu();
            if($quyenXemTatCa==1)
            {
                 
                $phieuThuTong = DB::table('view_phieu_thu')
               
                ->select('receipt_id')
                ->get();
                $phieuThu = DB::table('view_phieu_thu')
                    ->orderByDesc('receipt_time')
                    ->take($lay)
                    ->skip(0)
                    ->get();
            }
            else
            {
                $phieuThuTong = DB::table('view_phieu_thu')
                ->where('branch_id',session('coSo'))
                ->select('receipt_id')
                ->get();
            $phieuThu = DB::table('view_phieu_thu')
            ->where('branch_id',session('coSo'))
                ->orderByDesc('receipt_time')
                ->take($lay)
                ->skip(0)
                ->get();
            }
            
            
            $loai = DB::table('st_facility_type')
            ->get();
            $soKM = count($phieuThuTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;

            return view('PhieuThu.phieuThu')
            ->with('phieuThu', $phieuThu)
            ->with('loai', $loai)
            ->with('soTrang', $soTrang)
            ->with('page', 1)
            ;
        }
        else
        {
            return redirect()->back();
        }
    }

    public function searchDanhSachPhieuThu(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            $quyenXemTatCa = $quyen->getXemTatCaPhieuThu();
            if($quyenXemTatCa==1)
            {
                if ($value == "")
                {
                    $phieuThu = DB::table('view_phieu_thu')
                    ->orderByDesc('receipt_time')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                }
                else
                {
                    $phieuThu = DB::table('view_phieu_thu')
                    ->where('employee_name', 'like', '%' . $value . '%')
                    ->orwhere('receipt_name', 'like', '%' . $value . '%')
                    ->orwhere('branch_name', 'like', '%' . $value . '%')
                   
                    ->orwhere('student_lastName', 'like', '%' . $value . '%')
                    ->orderByDesc('receipt_time')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                }
               
            }
            else
            {
                if ($value == "")
                {
                    $phieuThu = DB::table('view_phieu_thu')
                    ->where('branch_id',session('coSo'))
                    ->orderByDesc('receipt_time')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                }
                else
                {
                    $phieuThu = DB::table('view_phieu_thu')
                    ->where('branch_id',session('coSo'))
                    ->where(function($query) use ($value)
                    {
                        $query->where('employee_name', 'like', '%' . $value . '%')
                        ->orwhere('receipt_name', 'like', '%' . $value . '%')
                        ->orwhere('student_lastName', 'like', '%' . $value . '%')
                        ->orwhere('branch_name', 'like', '%' . $value . '%');
                    })
                    ->orderByDesc('receipt_time')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
                }
            }
            $loai = DB::table('st_facility_type')
            ->get();

            $out = "";
            $i = 1;
            foreach ($phieuThu as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->branch_name . '</td>     
                <td>' . $item->receipt_name . '</td>
                <td>' . date('H:i d/m/Y', strtotime($item->receipt_time)) . '</td>
                <td>' . $item->employee_name . '</td>
                <td>' . $item->student_firstName .' '. $item->student_lastName . '</td>
                <td>' .number_format( $item->receipt_total,0,"",".") . 'đ</td>';
                if ($item->receipt_type == 0)
                    $out .= '<td>Thu học phí</td>';
                else if ($item->receipt_type == -1)
                    $out .= '<td>Thu khác</td>';
                else
                {
                    foreach($loai as $item2)
                    {
                        if($item2->facilityType_id== $item->receipt_type)
                        $out .= '<td>'.$item2->facilityType_name.'</td>';
                    }
                }

                if (session('quyen313') == 1)
                    $out .= '<td>
                            <a class="btn" href=\'' . route('getCapNhatPhieuThu') . '?id=' . $item->receipt_id . '\'>
                                Chi tiết 
                                        </a>
                        </td>';
                if (session('quyen314') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->receipt_id . '\');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>';
                $out .= ' </tr>';
                $i++;
            }
            return response($out);
        }
    } 
    public function getThemPhieuThu(Request $request)
    {
        $quyen = new quyenController();
        $quyenThem = $quyen->getThemPhieuThu();
        if ($quyenThem == 1) {
            $id = $request->get('id');
            $hocVien = DB::table('st_student')
                ->where('student_id', $id)
                ->get()->first();
            $chuongTrinhHoc = DB::table('st_study_program')
                ->where('branch_id',session('coSo'))
                ->orderBy('studyProgram_number')
                ->get();

            $idCT = 0;
            if (count($chuongTrinhHoc) > 0) {
                $chuongTrinhHocDau = $chuongTrinhHoc->first();
                $idCT = $chuongTrinhHocDau->studyProgram_id;
            }

            $khoaHoc =  DB::table('st_course')
                ->where('studyProgram_id', $idCT)
                ->orderBy('course_number')
                ->get();

                $now = Carbon::now('Asia/Ho_Chi_Minh');
               
            $chuongTrinhKhuyenMai = DB::table('st_promotions')
            ->where('promotions_type',1)
            ->orderBy('promotions_discount')
            ->where('promotions_startDate','<=',$now)
            ->where('promotions_endDate','>=',$now)
            ->get();

            $sanPham = DB::table('st_facility')
            ->join('st_inventory','st_inventory.facility_id','=','st_facility.facility_id')
            ->where('st_inventory.inventory_amount','>',0)
            ->where('st_inventory.branch_id',session('coSo'))
            ->get();

            $chiNhanh = DB::table('st_branch')
            ->where('branch_id',session('coSo'))
            ->get()
            ->first();
            $loaiThu = DB::table('st_facility_type')
            ->get();
            return view('PhieuThu.themPhieuThu')
                ->with('chuongTrinhKhuyenMai', $chuongTrinhKhuyenMai)
                ->with('hocVien', $hocVien)
                ->with('chuongTrinhHoc', $chuongTrinhHoc)
                ->with('khoaHoc', $khoaHoc)
                ->with('sanPham', $sanPham)
                ->with('thoiGian',$now)
                ->with('loaiThu',$loaiThu)
                ->with('chiNhanh', $chiNhanh)
                ;
        } else
            return redirect()->back();
    }

    public function getCapNhatPhieuThu(Request $request)
    {
        $quyen = new quyenController();
        $quyenThem = $quyen->getSuaPhieuThu();
        if ($quyenThem == 1) {
            $id = $request->get('id');
           
            $phieuThu = DB::table('view_phieu_thu')
            ->where('receipt_id',$id)
            ->get()->first();
            $KhoaHocPhieuThu = DB::table('st_receipt_detail')
            ->join('st_course','st_course.course_id','=',
            'st_receipt_detail.course_id')
            ->join('st_study_program','st_study_program.studyProgram_id','=',
            'st_course.studyProgram_id')
            ->where('st_receipt_detail.receipt_id',$id)
            ->get();
            $khoaDau = 0;
            $idCT = 0;
            if(count($KhoaHocPhieuThu)>0)
            {
                $khoaHocDauDau = $KhoaHocPhieuThu->first();
                $khoaDau= $khoaHocDauDau->course_id;
                $idCT = $khoaHocDauDau->studyProgram_id;
            }

            $sanPhamPhieuThu = DB::table('st_receipt_facility')
            ->join('st_facility','st_facility.facility_id','=','st_receipt_facility.facility_id')
            ->where('st_receipt_facility.receipt_id',$id)
            ->get()
            ;


            $chuongTrinhHoc = DB::table('st_study_program')
                ->orderBy('studyProgram_number')
                ->get();


            $khoaHoc =  DB::table('st_course')
                ->where('studyProgram_id', $idCT)
                ->orderBy('course_number')
                ->get();

                $now = Carbon::now('Asia/Ho_Chi_Minh');
            $chuongTrinhKhuyenMai = DB::table('st_promotions')
            ->where('promotions_type',1)
            ->orderBy('promotions_discount')
            ->where('promotions_startDate','<=',$now)
            ->where('promotions_endDate','>=',$now)
            ->get();

            $sanPham = DB::table('st_facility')
            ->join('st_inventory','st_inventory.facility_id','=','st_facility.facility_id')
            ->where('st_inventory.inventory_amount','>',0)
            ->where('st_inventory.branch_id',session('coSo'))
            ->get();

            $chiNhanh = DB::table('st_branch')
            ->where('branch_id',session('coSo'))
            ->get()
            ->first();

            $giamCoDinh = DB::table('st_receipt_promotions')
            ->join('st_promotions','st_promotions.promotions_id','=','st_receipt_promotions.promotions_id')
            ->where('receipt_id',$id)
            ->where('st_promotions.promotions_type',0)
            ->get()->first();
            
            $congNo = DB::table('st_student_surplus')
            ->where('receipt_id',$id)
            ->get()->first();
            $soDu=0;
            if(isset($congNo))
            {
                $soDu=$congNo->studentSurplus_surplus;
            }

            if(isset($giamCoDinh))
            {
                $tenGiamGiaCoDinh = $giamCoDinh->promotions_name;
                $phanTramGGCD = $giamCoDinh->receipt_discount;
            }
            else
            {
                $tenGiamGiaCoDinh = "";
                $phanTramGGCD = 0;
            }
            $giamKhac = DB::table('st_receipt_promotions')
            ->join('st_promotions','st_promotions.promotions_id','=','st_receipt_promotions.promotions_id')
            ->where('receipt_id',$id)
            ->where('st_promotions.promotions_type',1)
            ->get()->first();
            if(isset($giamKhac))
            {
                $tenGiamKhach = $giamKhac->promotions_name;
                $phanTramKhac = $giamKhac->receipt_discount;
            }
            else
            {
                $tenGiamKhach = "";
                $phanTramKhac = 0;
            }
            $bangChu =$this->convert_number_to_words($phieuThu->receipt_total);
            $bangChuTienGoc =$this->convert_number_to_words($phieuThu->receipt_price);
            $loai =DB::table('st_facility_type')
            ->get();
            return view('PhieuThu.capNhatPhieuThu')
                ->with('chuongTrinhKhuyenMai', $chuongTrinhKhuyenMai)
                ->with('phieuThu', $phieuThu)
                ->with('chuongTrinhHoc', $chuongTrinhHoc)
                ->with('khoaHoc', $khoaHoc)
                ->with('sanPham', $sanPham)
                ->with('thoiGian',$now)
                ->with('chiNhanh', $chiNhanh)
                ->with('KhoaHocPhieuThu',$KhoaHocPhieuThu)
                ->with('khoaDau', $khoaDau)
                ->with('idCT', $idCT)
                ->with('tenGiamGiaCoDinh', $tenGiamGiaCoDinh)
                ->with('phanTramGGCD', $phanTramGGCD)
                ->with('tenGiamKhach', $tenGiamKhach)
                ->with('phanTramKhac', $phanTramKhac)
                ->with('sanPhamPhieuThu', $sanPhamPhieuThu)
                ->with('bangChu', $bangChu)
                ->with('loai', $loai)
                ->with('bangChuTienGoc', $bangChuTienGoc)
                ->with('soDu',$soDu)
                ;
        } else
            return redirect()->back();
    }
    public function searchCTHThemPhieuThu(Request $request)
    {
        if ($request->ajax()) {
            $idCT = $request->get('chuongTrinhHoc');

            $soKhoa = $request->get('soKhoa');
            $tenGiamGiaKhac = $request->get('tenGiamGiaKhac');
            $nhanKhuyenMaiCD = $request->get('nhanKhuyenMaiCD');
            $nhanKhuyenMaiKhac = $request->get('nhanKhuyenMaiKhac');

            $soDu = $request->get('soDu');
            $nhanSoDu = $request->get('nhanSoDu');
            $idKhoaHoc = 0;
            $khoaHoc =  DB::table('st_course')
                ->where('studyProgram_id', $idCT)
                ->orderBy('course_number')
                ->get();

            $outKhoaHoc = '<select class="form-control" id="khoaHoc" name="khoaHoc" onchange="changeKH();">';
            foreach ($khoaHoc as $item)
                $outKhoaHoc .= ' <option value="' . $item->course_id . '">' . $item->course_name . '</option>';

            $outKhoaHoc .= '</select>';

            $soHienThiKhoa = 0;
            if ($soKhoa == "")
                $soKhoa = 0;

            if (count($khoaHoc) > 0) {
                $khoaHocDau = $khoaHoc->first();
                $idKhoaHoc = $khoaHocDau->course_id;
                $soHienThiKhoa = $khoaHocDau->course_number;
            }

          
            $outSoKhoaHoc = $this->getSoKhoaHoc($idCT, $soHienThiKhoa, $soKhoa,$tenGiamGiaKhac
            ,$nhanKhuyenMaiCD,$nhanKhuyenMaiKhac,$soDu,$nhanSoDu);
           
          
            

            $arr[] = [
                'khoaHoc' => $outKhoaHoc,
                'khoaChon' => $outSoKhoaHoc[0]['soKhoaHoc'],
                'tongTien'=>$outSoKhoaHoc[0]['tongTien'],
                'tongTienformat'=>number_format( $outSoKhoaHoc[0]['tongTien'],0,"",".")." đ",
                'soKhoa' => $soKhoa,
                'phanTram'=>$outSoKhoaHoc[0]['phanTram'],
                'tenKM'=>$outSoKhoaHoc[0]['tenKM'],
                'soKhoa'=>$outSoKhoaHoc[0]['soKhoa'],
                'thanhToan'=>$outSoKhoaHoc[0]['thanhToan'],
                'phanTramKMK'=>$outSoKhoaHoc[0]['phanTramKMK'],
                'hocPhi'=>$outSoKhoaHoc[0]['hocPhi'],
                'tienGiamGia'=>$outSoKhoaHoc[0]['tienGiamGia']
            ];
            return response($arr);
        }
    }

    public function searchKHThemPhieuThu(Request $request)
    {
        if ($request->ajax()) {
            $idCT = $request->get('chuongTrinhHoc');
            $idKhoaHoc = $request->get('khoaHoc');
            $soKhoa = $request->get('soKhoa');
            $tenGiamGiaKhac = $request->get('tenGiamGiaKhac');
            $nhanKhuyenMaiCD = $request->get('nhanKhuyenMaiCD');
            $nhanKhuyenMaiKhac = $request->get('nhanKhuyenMaiKhac');
            if ($soKhoa == "")
                $soKhoa = 0;

                $soDu = $request->get('soDu');
                $nhanSoDu = $request->get('nhanSoDu');
            $khoaHoc =  DB::table('st_course')
                ->where('course_id', $idKhoaHoc)
                ->get()
                ->first();

            $soHienThiKhoa = $khoaHoc->course_number;

            $outSoKhoaHoc = $this->getSoKhoaHoc($idCT, $soHienThiKhoa, $soKhoa,$tenGiamGiaKhac
            ,$nhanKhuyenMaiCD,$nhanKhuyenMaiKhac,$soDu,$nhanSoDu);

            $arr[] = [
                'khoaChon' => $outSoKhoaHoc[0]['soKhoaHoc'],
                'tongTien'=>$outSoKhoaHoc[0]['tongTien'],
                'tongTienformat'=>number_format( $outSoKhoaHoc[0]['tongTien'],0,"",".")." đ",
                'phanTram'=>$outSoKhoaHoc[0]['phanTram'],
                'tenKM'=>$outSoKhoaHoc[0]['tenKM'],
                'soKhoa'=>$outSoKhoaHoc[0]['soKhoa'],
                'thanhToan'=>$outSoKhoaHoc[0]['thanhToan'],
                'phanTramKMK'=>$outSoKhoaHoc[0]['phanTramKMK'],
                'hocPhi'=>$outSoKhoaHoc[0]['hocPhi'],
                'tienGiamGia'=>$outSoKhoaHoc[0]['tienGiamGia']
            ];
            return response($arr);
        }
    }

    public function getSoKhoaHoc($idCT, $soHienThiKhoa, $soKhoa,$phieuThuKhac,$nhanKMCD,$nhanKMK,$soDu,$nhanSoDu)
    {
        $tongTien =0;
        $soKhoaBatDau = $soKhoa;
        $phamTramKhuyenMaiKhac=0;
        if($phieuThuKhac!="")
        {
            $KM = DB::table('st_promotions')
            ->where('promotions_id',$phieuThuKhac)
            ->get()->first();
            if(isset($KM))
            $phamTramKhuyenMaiKhac=$KM->promotions_discount;
        }

        if ($soKhoa > 0) {
            $khoaHocChon  =  DB::table('st_course')
            ->join(
                'st_study_program',
                'st_study_program.studyProgram_id',
                '=',
                'st_course.studyProgram_id'
            )
            ->where('st_course.course_number', '>=', $soHienThiKhoa)
            ->where('st_course.studyProgram_id', $idCT)
            ->select('st_study_program.studyProgram_number', 'st_study_program.studyProgram_code', 'st_course.*')
            ->orderBy('st_course.course_number')
            ->take($soKhoa)
            ->get();

        $chuongTrinhHoc = DB::table('st_study_program')
            ->where('studyProgram_id', $idCT)
            ->get()
            ->first();



        $soHienThiCT = $chuongTrinhHoc->studyProgram_number;
        $outSoKhoaHoc = "";
        $i = 1;
        $tienKhoaDau =0;
        foreach ($khoaHocChon as $item) {
            if($i==1)
                $tienKhoaDau=$item->course_price;
            $soKhoa--;
            $tongTien+=$item->course_price;
            $outSoKhoaHoc .= "<tr>
                    <td>" . $i . "</td>
                    <td>" . $item->studyProgram_code . "</td>
                    <td>" . $item->course_name . "</td>
                    <td>" . number_format($item->course_price, 0, "", ".") . "đ</td>
                    </tr>";
            $i++;
        }

        while ($soKhoa > 0) {
            $chuongTrinhHoc = DB::table('st_study_program')
                ->where('studyProgram_number', '>', $soHienThiCT)
                ->where('branch_id',session('coSo'))
                ->orderBy('studyProgram_number')
                ->get()->first();

            if (isset($chuongTrinhHoc)) {
                $soHienThiCT =  $chuongTrinhHoc->studyProgram_number;
                $khoaHocChon  =  DB::table('st_course')
                    ->where('studyProgram_id', $chuongTrinhHoc->studyProgram_id)
                    ->orderBy('course_number')
                    ->get();
                foreach ($khoaHocChon as $item) {
                    if($i==1)
                        $tienKhoaDau=$item->course_price;


                    $tongTien+=$item->course_price;
                    $outSoKhoaHoc .= "<tr>
                            <td>" . $i . "</td>
                            <td>" . $chuongTrinhHoc->studyProgram_code . "</td>
                            <td>" . $item->course_name . "</td>
                            <td>" . number_format($item->course_price, 0, "", ".") . "đ</td>
                            </tr>";
                    $i++;
                    $soKhoa--;
                    if ($soKhoa <= 0)
                        break;
                }
            } else {
                break;
            }
        }


        $soKhoaSuDung = $soKhoaBatDau - $soKhoa;
        $phanTram=0;
        $tenKM ="";
        if($nhanKMCD==1)
        {
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $phieuThu = DB::table('st_promotions')
            ->where('promotions_startDate','<=',$now)
            ->where('promotions_endDate','>=',$now)
            ->where('promotions_number','<=',$soKhoaSuDung)
            ->where('promotions_type',0)
            ->orderBy('promotions_number')
            ->get()->last();
           
            if(isset($phieuThu))
            {
                $phanTram = $phieuThu->promotions_discount;
                $tenKM =  $phieuThu->promotions_name;
            }   
        }
       
       
       
        $hocPhi = $tongTien;
        
        $tongTien = $tongTien - $tongTien*$phanTram/100;
        $tienGiamKhac=0;
        if($nhanKMK==1)
        if($soKhoaSuDung>0)
        $tienGiamKhac = ( $tienKhoaDau)*$phamTramKhuyenMaiKhac/100;
        
        $tienGiamGia = $tongTien- $tienGiamKhac;

        if($nhanSoDu==1)
        {
            $thanhToan = $tienGiamGia - $soDu;
        }
        else
        $thanhToan = $tienGiamGia ;
        $arr[]=[
            'soKhoaHoc'=>$outSoKhoaHoc,
            'tongTien'=>$tongTien,
            'phanTram'=>$phanTram,
            'tenKM'=>$tenKM,
            'soKhoa'=>$soKhoaSuDung,
            'thanhToan'=>$thanhToan,
            'phanTramKMK'=>$phamTramKhuyenMaiKhac,
            'hocPhi'=>number_format($hocPhi,0,"",".")." đ" ,
            'tienGiamGia'=>$tienGiamGia
            
        ];
        return $arr;
        }
        else
        {
            $arr[]=[
                'soKhoaHoc'=>"",
                'tongTien'=>"0",
                'tenKM'=>"",
                'phanTram'=>"0",
                'soKhoa'=>"0",
                'thanhToan'=>"0",
                'phanTramKMK'=>"0",
                'hocPhi'=>"",
                'tienGiamGia'=>""
            ];
            return $arr;     
        }
           
    }

    public function searhTongTienPhamTramGiaKmhac(Request $request)
    {
        if($request->ajax())
        {
            $tongTien= $request->get('tongTien');
            $phamTramKhuyenMaiKhac = $request->get('giamGiaKhac');
            $khoaHoc = $request->get('khoaHoc');
            $nhanKhuyenMaiKhac = $request->get('nhanKhuyenMaiKhac');
            $tienGiamKhac=0;
            if($nhanKhuyenMaiKhac==1)
            {
                $khoaHocDau = DB::table('st_course')
                ->where('course_id',$khoaHoc)
                ->get()->first();
                $tienKhoaDau=0;
                if(isset($khoaHocDau))
                {
                    $tienKhoaDau=$khoaHocDau->course_price;
                }
    
              
                if($phamTramKhuyenMaiKhac>0)
                $tienGiamKhac = $tienKhoaDau*$phamTramKhuyenMaiKhac/100;
            }
         
           
            $thanhToan = $tongTien - $tienGiamKhac;
            $arr[]=[
                'phanTram'=>$phamTramKhuyenMaiKhac,
                'thanhToan'=>$thanhToan
            ];
            return response($arr);
        }
    }

    public function searhTongTienGiaKhac(Request $request)
    {
        if($request->ajax())
        {
            $tongTien= $request->get('tongTien');
            $phieuThuKhac = $request->get('tenGiamGiaKhac');
            $khoaHoc = $request->get('khoaHoc');
          
            $nhanKhuyenMaiKhac = $request->get('nhanKhuyenMaiKhac');
            $phamTramKhuyenMaiKhac=0;
            $tienGiamKhac=0;
            if($nhanKhuyenMaiKhac==1)
            {
                $khoaHocDau = DB::table('st_course')
                ->where('course_id',$khoaHoc)
                ->get()->first();
                $tienKhoaDau=0;
                if(isset($khoaHocDau))
                {
                    $tienKhoaDau=$khoaHocDau->course_price;
                }
    
                if($phieuThuKhac!="")
                {
                    $KM = DB::table('st_promotions')
                    ->where('promotions_id',$phieuThuKhac)
                    ->get()->first();
                    if(isset($KM))
                    $phamTramKhuyenMaiKhac=$KM->promotions_discount;
                }
    
    
             
                if($phamTramKhuyenMaiKhac>0)
                $tienGiamKhac = $tienKhoaDau*$phamTramKhuyenMaiKhac/100;
               
            }

            $thanhToan = $tongTien - $tienGiamKhac;
          
            $arr[]=[
                'phanTram'=>$phamTramKhuyenMaiKhac,
                'thanhToan'=>$thanhToan
            ];


            return response($arr);
        }
    }
    public function XoaThemPhieuThu($idPhieuXuat)
    {
        try
        {
            $chiTietPhieuXuat = DB::table('view_phieu_thu_vat_pham')
            ->where('receipt_id',$idPhieuXuat)
            ->get();
    
            
            $congNo = DB::table('st_student_surplus')
            ->where('receipt_id',$idPhieuXuat)
            ->get()->first();
            if(isset($congNo))
            {
                $hocVien = DB::table('st_student')
                ->where('student_id',$congNo->student_id)
                ->get()->first();
                if(isset($hocVien))
                {
                    DB::table('st_student')
                ->where('student_id',$congNo->student_id)
                ->update([
                    'student_surplus'=>$hocVien->student_surplus + $congNo->studentSurplus_surplus
                ]);
                }
            }

            foreach($chiTietPhieuXuat as $item)
            {
                $tonKho = DB::table('st_inventory')
                ->where('branch_id',$item->branch_id)
                ->where('facility_id',$item->facility_id)
                ->get()->first();
                if(isset($tonKho))
                {
                    DB::table('st_inventory')
                    ->where('branch_id',$item->branch_id)
                    ->where('facility_id',$item->facility_id)
                    ->update([
                        'inventory_amount'=>$tonKho->inventory_amount + $item->receiptFacility_number
                    ]);
                }
            }
            DB::table('st_receipt_promotions')
            ->where('receipt_id',$idPhieuXuat)
            ->delete();
            DB::table('st_receipt_facility')
            ->where('receipt_id',$idPhieuXuat)
            ->delete();
            DB::table('st_receipt_detail')
            ->where('receipt_id',$idPhieuXuat)
            ->delete();
            DB::table('st_receipt')
            ->where('receipt_id',$idPhieuXuat)
            ->delete();
            return 1;
        }
        catch(QueryException $ex)
        {
            return 0;
        }
       

    }

    public function postThemPhieuThu(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenThem = $quyen->getThemPhieuThu();
            if ($quyenThem == 1) 
            {
                $idHocVien = $request->get('id');
                $loai = $request->get('loai');
                $idPhieuXuat = $request->get('idPhieuXuat');


                $soDu = $request->get('soDu');
                $nhanSoDu = $request->get('nhanSoDu');
                if($idPhieuXuat>0)
                {
                    $xoaPhieuThu=   $this->XoaThemPhieuThu($idPhieuXuat);

                }
               


                if($loai==0)
                {
                    $idKhoaHoc= $request->get('khoaHoc');
                    $soKhoa= $request->get('soKhoa');
                    $idCT = $request->get('chuongTrinh');
                    $giamGiaKhac = $request->get('giamGiaKhac');
                    $ghiChu = $request->get('ghiChu');
                    $tenGiamGiaKhac = $request->get('tenGiamGiaKhac');
                    $tongThanhToan = $request->get('thanhToan');

                    $nhanKhuyenMaiCD = $request->get('nhanKhuyenMaiCD');
                    $nhanKhuyenMaiKhac = $request->get('nhanKhuyenMaiKhac');

                    if ($soKhoa == "")
                    $soKhoa = 0;


                    $khoaHoc =  DB::table('st_course')
                        ->where('course_id', $idKhoaHoc)
                        ->get()
                        ->first();

                    $soHienThiKhoa = $khoaHoc->course_number;

                    $sanPham = DB::table('st_facility')
                    ->get();
                    $arrSanPham=[];
                    foreach($sanPham as $item)
                    {
                        $key = "soLuong".$item->facility_id;
                        if($request->get($key)>0)
                        {
                            $arrSanPham[]=[
                                'id'=>$item->facility_id,
                                'soLuong'=>$request->get($key)
                            ];
                        }
                    }

                    


                    $out = $this->themPhieuThu($idCT, $soHienThiKhoa, $soKhoa,$giamGiaKhac,
                    $idHocVien,$loai,$ghiChu,$arrSanPham,$tenGiamGiaKhac ,
                    $tongThanhToan,$nhanKhuyenMaiCD,$nhanKhuyenMaiKhac,$soDu,$nhanSoDu);
                    return response($out);
                // return response(0);
                }
                else if($loai==-1)
                {
                    $noiDung = $request->get('noiDungThuKhac');
                    $tienThuKhac = $request->get('tienThuKhac');
                    $ghiChuThuKhac = $request->get('ghiChuThuKhac');
                    if($ghiChuThuKhac == "")
                    $ghiChuThuKhac="";
                    $now=Carbon::now('Asia/Ho_Chi_Minh');

                    $phieuThu =  DB::table('st_receipt')
                      ->where('branch_id',session('coSo'))
                      ->orderByDesc('receipt_number')
                      ->get()->first();
                      if(isset($phieuThu))
                      {
                          $soPhieuThu = $phieuThu->receipt_number +1;
                      }
                      else
                          $soPhieuThu=1;
          
                      $id = DB::table('st_receipt')
                      ->insertGetId([
                          'receipt_name'=>$noiDung,
                          'receipt_total'=>$tienThuKhac,
                          'receipt_time'=>$now,
                          'employee_id'=>session('user'),
                          'student_id'=>$idHocVien,
                          'receipt_type'=>$loai,
                          'receipt_note'=>$ghiChuThuKhac,
                          'branch_id'=>session('coSo'),
                          'receipt_number'=>$soPhieuThu,
                          'receipt_price'=>$tienThuKhac,
                          'receipt_promotion'=>0,
                          'receipt_otherPromotion'=>0,
                          'receipt_discount'=>0
                      ]);
                    
                   
                      $bangChu =$this->convert_number_to_words($tienThuKhac);
                    $arr[]=[
                        'loai'=>1,
                        'soPhieuThu'=>$soPhieuThu,
                        'noiDung'=>$noiDung,
                        'soTien'=>number_format($tienThuKhac,0,"","."),
                        'bangChu'=>$bangChu,
                        'tienGoc'=>number_format($tienThuKhac,0,"","."),
                        'bangChuTienGoc'=>$bangChu,
                        'tenKM'=>"",
                        'quaTang'=>"",
                        'ghiChu'=>$ghiChuThuKhac,
                        'idPhieuXuat'=>$id
                    ];
                    return response($arr);
                }
                else 
                {
                    $noiDung = $request->get('noiDungThuBanSach');
                    $ghiChuBanSach = $request->get('ghiChuBanSach');
                    if($ghiChuBanSach=="")
                    $ghiChuBanSach="";

                    $sanPham = DB::table('st_facility')
                    ->join('st_inventory','st_inventory.facility_id','=','st_facility.facility_id')
                    ->where('st_inventory.branch_id',session('coSo'))
                    ->where('st_facility.facilityType_id',$loai)
                    ->get();
                    $arrSanPham=[];
                    foreach($sanPham as $item)
                    {
                        $key = "soLuongBanSach".$item->facility_id;
                        if($request->get($key)>0)
                        {
                            $arrSanPham[]=[
                                'id'=>$item->facility_id,
                                'soLuong'=>$request->get($key),
                                'gia'=>$item->facility_price,
                            ];
                        }
                    }
                    

                    $out = $this->themBanSach($idHocVien,$noiDung,$ghiChuBanSach,$arrSanPham,$loai);
                   
                   return response($out);
                 
                  
                }
             
            } 
            $arr[]=[
                'loai'=>2,
                'soPhieuThu'=>0,
                'noiDung'=>"",
                'soTien'=>0,
                'bangChu'=>"",
                'quaTang'=>""
            ];
           
            return response($arr);
        }
       
    }
    public function themBanSach($idHocVien,$noiDung,$ghiChuBanSach,$arrSanPham,$loai)
    {
        try
        {
            $tongTien =0;
        
            $now=Carbon::now('Asia/Ho_Chi_Minh');

            $phieuThu =  DB::table('st_receipt')
            ->where('branch_id',session('coSo'))
            ->orderByDesc('receipt_number')
            ->get()->first();
            if(isset($phieuThu))
            {
                $soPhieuThu = $phieuThu->receipt_number +1;
            }
            else
                $soPhieuThu=1;

            $id = DB::table('st_receipt')
            ->insertGetId([
                'receipt_name'=>$noiDung,
                'receipt_total'=>0,
                'receipt_time'=>$now,
                'employee_id'=>session('user'),
                'student_id'=>$idHocVien,
                'receipt_type'=>$loai,
                'receipt_note'=>$ghiChuBanSach,
                'branch_id'=>session('coSo'),
                'receipt_number'=>$soPhieuThu,
                'receipt_price'=>0,
                'receipt_promotion'=>0,
                'receipt_otherPromotion'=>0 ,
                'receipt_discount'=>0
            ]);
             $quaTang="";
             $tongTien=0;
            foreach($arrSanPham as $item)
            {
                DB::table('st_receipt_facility')
                ->insert([
                    'facility_id'=>$item['id'],
                    'receipt_id'=>$id,
                    'receiptFacility_number'=>$item['soLuong'],
                    'receiptFacility_price'=>$item['gia'],
                    'receiptFacility_type'=>$loai
                ]);

                $tongTien+= $item['gia']* $item['soLuong'];

                $tonKho = DB::table('st_inventory')
                ->join('st_facility','st_facility.facility_id','=','st_inventory.facility_id')
                ->where('st_inventory.facility_id',$item['id'])
                ->where('st_inventory.branch_id',session('coSo'))
                ->get()->first();
                if(isset($tonKho))
                {
                    DB::table('st_inventory')
                    ->where('facility_id',$item['id'])
                    ->where('branch_id',session('coSo'))
                    ->update([
                        'inventory_amount'=>$tonKho->inventory_amount -$item['soLuong']
                    ]);
                    $quaTang.=$item['soLuong']. " " .$tonKho->facility_name. ". ";
                }

               
            }
            DB::table('st_receipt')
            ->where('receipt_id',$id)
            ->update([
                'receipt_total'=>$tongTien,
                'receipt_price'=>$tongTien
            ]);

            $bangChu =$this->convert_number_to_words($tongTien);
            $bangChuTienGoc =$this->convert_number_to_words($tongTien);
           
            $arr[]=[
                'loai'=>1,
                'soPhieuThu'=>$soPhieuThu,
                'noiDung'=>$noiDung,
                'soTien'=>number_format( $tongTien,0,"","."),
                'bangChu'=>$bangChu,
                'tienGoc'=>number_format($tongTien,0,"","."),
                'bangChuTienGoc'=>$bangChuTienGoc,
                'tenKM'=>"",
                'quaTang'=>$quaTang,
                'ghiChu'=>$ghiChuBanSach,
                'idPhieuXuat'=>$id
            ];
            return $arr;
          
        }
        catch(QueryException $ex)
        {
            $arr[]=[
                'loai'=>0,
                'soPhieuThu'=>0,
                'noiDung'=>"",
                'soTien'=>0,
                'bangChu'=>"",
                'quaTang'=>""
            ];
            return $arr; 
        }
    }

    public function themPhieuThu($idCT, $soHienThiKhoa, 
    $soKhoa,$phamTramKhuyenMaiKhac,$idHocVien,$loai,$ghiChu,$arrSanPham,$tenGiamGiaKhac, $tongThanhToan
    ,$nhanKhuyenMaiCD,$nhanKhuyenMaiKhac,$soDu,$nhanSoDu)
    {
        try
        {
            $tongTien =0;
            $soKhoaBatDau = $soKhoa;
          
            $now=Carbon::now('Asia/Ho_Chi_Minh');

          $phieuThu =  DB::table('st_receipt')
            ->where('branch_id',session('coSo'))
            ->orderByDesc('receipt_number')
            ->get()->first();
            if(isset($phieuThu))
            {
                $soPhieuThu = $phieuThu->receipt_number +1;
            }
            else
                $soPhieuThu=1;

            $id = DB::table('st_receipt')
            ->insertGetId([
                'receipt_name'=>"",
                'receipt_total'=>0,
                'receipt_discount'=>0,
                'receipt_time'=>$now,
                'employee_id'=>session('user'),
                'student_id'=>$idHocVien,
                'receipt_type'=>$loai,
                'receipt_note'=>$ghiChu,
                'branch_id'=>session('coSo'),
                'receipt_number'=>$soPhieuThu,
                'receipt_price'=>0,
                'receipt_promotion'=>$nhanKhuyenMaiCD,
                'receipt_otherPromotion'=>$nhanKhuyenMaiKhac
            ]);

            
                $tenKhoaHoc="";
            if ($soKhoa > 0) 
            {
    
                $khoaHocChon  =  DB::table('st_course')
                ->join(
                    'st_study_program',
                    'st_study_program.studyProgram_id',
                    '=',
                    'st_course.studyProgram_id'
                )
                ->where('st_course.course_number', '>=', $soHienThiKhoa)
                ->where('st_course.studyProgram_id', $idCT)
                ->select('st_study_program.studyProgram_number', 'st_study_program.studyProgram_code', 'st_course.*')
                ->orderBy('st_course.course_number')
                ->take($soKhoa)
                ->get();
    
                $chuongTrinhHoc = DB::table('st_study_program')
                ->where('studyProgram_id', $idCT)
                ->get()
                ->first();
    
    
    
                $soHienThiCT = $chuongTrinhHoc->studyProgram_number;
                $outSoKhoaHoc = "";
                $i = 1;
                $tienKhoaDau =0;
    
                foreach ($khoaHocChon as $item) {
                    if($i==1)
                        $tienKhoaDau=$item->course_price;
                    $soKhoa--;
                    $tongTien+=$item->course_price;
                   
                    DB::table('st_receipt_detail')
                    ->insert([
                        'course_id'=>$item->course_id,
                        'receipt_id'=>$id,
                        'class_id'=>0,
                        'receiptDeatil_price'=>$item->course_price
                    ]);
                    $tenKhoaHoc.=$item->course_name.", ";
    
                    $i++;
                }
    
             while ($soKhoa > 0) {
                $chuongTrinhHoc = DB::table('st_study_program')
                    ->where('studyProgram_number', '>', $soHienThiCT)
                    ->where('branch_id',session('coSo'))
                    ->orderBy('studyProgram_number')
                    ->get()->first();
    
                if (isset($chuongTrinhHoc)) {
                    $soHienThiCT =  $chuongTrinhHoc->studyProgram_number;
                    $khoaHocChon  =  DB::table('st_course')
                        ->where('studyProgram_id', $chuongTrinhHoc->studyProgram_id)
                        ->orderBy('course_number')
                        ->get();
                    foreach ($khoaHocChon as $item) {
                        if($i==1)
                            $tienKhoaDau=$item->course_price;
    
    
                        $tongTien+=$item->course_price;
                        DB::table('st_receipt_detail')
                        ->insert([
                            'course_id'=>$item->course_id,
                            'receipt_id'=>$id,
                            'class_id'=>0
                        ]);
                        $tenKhoaHoc.=$item->course_name.". ";
    
                        $i++;
                        $soKhoa--;
                        if ($soKhoa <= 0)
                            break;
                    }
                } else {
                    break;
                }
                }
                $quaTang="";
                foreach($arrSanPham as $item)
                {
                    DB::table('st_receipt_facility')
                    ->insert([
                        'facility_id'=>$item['id'],
                        'receipt_id'=>$id,
                        'receiptFacility_number'=>$item['soLuong'],
                        'receiptFacility_price'=>0,
                        'receiptFacility_type'=>$loai
                    ]);

                    $tonKho = DB::table('st_inventory')
                    ->join('st_facility','st_facility.facility_id','=','st_inventory.facility_id')
                    ->where('st_inventory.facility_id',$item['id'])
                    ->where('st_inventory.branch_id',session('coSo'))
                    ->get()->first();
                    if(isset($tonKho))
                    {
                        DB::table('st_inventory')
                        ->where('facility_id',$item['id'])
                        ->where('branch_id',session('coSo'))
                        ->update([
                            'inventory_amount'=>$tonKho->inventory_amount -$item['soLuong']
                        ]);
                        $quaTang.=$item['soLuong']. " " .$tonKho->facility_name . ". ";
                    }


                }
    
                $soKhoaSuDung = $soKhoaBatDau - $soKhoa;
                $phanTram=0;
                $tenKM ="";
               
            if($nhanKhuyenMaiCD==1)
            {
                $now = Carbon::now('Asia/Ho_Chi_Minh');
                $phieuThu = DB::table('st_promotions')
                ->where('promotions_startDate','<=',$now)
                ->where('promotions_endDate','>=',$now)
                ->where('promotions_number','<=',$soKhoaSuDung)
                ->where('promotions_type',0)
                ->orderBy('promotions_number')
                ->get()->last();
               
               
                if(isset($phieuThu))
                {
                    $phanTram = $phieuThu->promotions_discount;
                    $tenKM .=  $phieuThu->promotions_name .". ";
                    DB::table('st_receipt_promotions')
                    ->insert([
                        'promotions_id'=>$phieuThu->promotions_id,
                        'receipt_id'=>$id,
                        'receipt_discount'=> $phieuThu->promotions_discount
                    ]);
                }   
            }
               
           
                $tienGoc=  $tongTien ;
    
            
                $tongTien = $tongTien - $tongTien*$phanTram/100;
                $tienGiamKhac=0;
          
            if($nhanKhuyenMaiKhac==1)
            {
                $giamGiaKhacNhau = DB::table('st_promotions')
                ->where('promotions_id',$tenGiamGiaKhac)
                ->get()
                ->first();

                if(isset($giamGiaKhacNhau))
                {
                    $tenUUDaiGiamGiaKhac = $giamGiaKhacNhau->promotions_name;
                }
                else
                {
                    $tenUUDaiGiamGiaKhac ="";
                }
               
                if($soKhoaSuDung>0)
                {
                    $tienGiamKhac = ($tienKhoaDau)*$phamTramKhuyenMaiKhac/100;
                    $tenKM .= $tenUUDaiGiamGiaKhac .". ";
                    DB::table('st_receipt_promotions')
                    ->insert([
                        'promotions_id'=> $tenGiamGiaKhac,
                        'receipt_id'=>$id,
                        'receipt_discount'=> $phamTramKhuyenMaiKhac
                    ]);
                }
            }
               
                $thanhToan = $tongTien- $tienGiamKhac;

              
                DB::table('st_receipt')
                ->where('receipt_id',$id)
                ->update([
                    'receipt_name'=> "Nộp học phí ". $tenKhoaHoc,
                    'receipt_total'=>$tongThanhToan,
                    'receipt_price'=>$tienGoc,
                    'receipt_discount'=>$tongTien
                ]);


                if($nhanSoDu ==1)
                {
                    DB::table('st_student_surplus')
                    ->insert([
                        'student_id'=>$idHocVien,
                        'receipt_id'=>$id,
                        'studentSurplus_surplus'=>$soDu
                    ]);
                    $hocVien = DB::table('st_student')
                    ->where('student_id',$idHocVien)
                    ->get()->first();
                    if(isset($hocVien))
                    {
                        DB::table('st_student')
                    ->where('student_id',$idHocVien)
                    ->update([
                        'student_surplus'=>0
                    ]);
                    }
                }
                


                $bangChu =$this->convert_number_to_words($tongThanhToan);
                $bangChuTienGoc =$this->convert_number_to_words($tienGoc);
                $arr[]=[
                    'loai'=>1,
                    'soPhieuThu'=>$soPhieuThu,
                    'noiDung'=>"Nộp học phí ". $tenKhoaHoc,
                    'soTien'=>number_format( $tongThanhToan,0,"","."),
                    'bangChu'=>$bangChu,
                    'tienGoc'=>number_format( $tienGoc,0,"","."),
                    'bangChuTienGoc'=>$bangChuTienGoc,
                    'tenKM'=>$tenKM,
                    'quaTang'=>$quaTang,
                    'ghiChu'=>$ghiChu,
                    'idPhieuXuat'=>$id
                ];
                
                return $arr;
            }
            else
            {
                $arr[]=[
                    'loai'=>3,
                    'soPhieuThu'=>0,
                    'noiDung'=>"",
                    'soTien'=>0,
                    'bangChu'=>"",
                    'quaTang'=>""
                ];
                return $arr; 
            }
        }
       catch(QueryException $ex)
       {
        $arr[]=[
            'loai'=>0,
            'soPhieuThu'=>0,
            'noiDung'=>"",
            'soTien'=>0,
            'bangChu'=>"",
            'quaTang'=>""
        ];
        return $arr; 
       }
           
    }


    public function changeLoaiPhieuThu(Request $request)
    {
        if($request->ajax())
        {
            $loai = $request->get('loai');
            $sanPham = DB::table('st_facility')
            ->join('st_inventory','st_inventory.facility_id','=','st_facility.facility_id')
            ->where('st_inventory.inventory_amount','>',0)
            ->where('st_facility.facilityType_id',$loai)
            ->where('st_inventory.branch_id',session('coSo'))
            ->get();
            return response($sanPham);
        }
    }


    public function getXoaPhieuThu(Request $request)
    {
        if($request->ajax())
        {
            $quyen = new quyenController();
            $quyenChiTiet = $quyen->getXoaPhieuThu();
            if($quyenChiTiet==1)
            {
                $id = $request->get('id');
                $xoaPhieuThu = $this->XoaThemPhieuThu($id);
                return response($xoaPhieuThu);
            }
            else
            {
                return response(2);
            }
        }
    }


   
public function convert_number_to_words( $number )
{
	$hyphen = ' ';
	$conjunction = '  ';
	$separator = ' ';
	$negative = 'âm ';
	$decimal = ' phẩy ';
	$dictionary = array(
		0 => 'không',
		1 => 'một',
		2 => 'hai',
		3 => 'ba',
		4 => 'bốn',
		5 => 'năm',
		6 => 'sáu',
		7 => 'bảy',
		8 => 'tám',
		9 => 'chín',
		10 => 'mười',
		11 => 'mười một',
		12 => 'mười hai',
		13 => 'mười ba',
		14 => 'mười bốn',
		15 => 'mười năm',
		16 => 'mười sáu',
		17 => 'mười bảy',
		18 => 'mười tám',
		19 => 'mười chín',
		20 => 'hai mươi',
		30 => 'ba mươi',
		40 => 'bốn mươi',
		50 => 'năm mươi',
		60 => 'sáu mươi',
		70 => 'bảy mươi',
		80 => 'tám mươi',
		90 => 'chín mươi',
		100 => 'trăm',
		1000 => 'ngàn',
		1000000 => 'triệu',
		1000000000 => 'tỷ',
		1000000000000 => 'nghìn tỷ',
		1000000000000000 => 'ngàn triệu triệu',
		1000000000000000000 => 'tỷ tỷ'
	);

	if( !is_numeric( $number ) )
	{
		return false;
	}

	if( ($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX )
	{
		// overflow
		trigger_error( 'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING );
		return false;
	}

	if( $number < 0 )
	{
		return $negative . $this->convert_number_to_words( abs( $number ) );
	}

	$string = $fraction = null;

	if( strpos( $number, '.' ) !== false )
	{
		list( $number, $fraction ) = explode( '.', $number );
	}

	switch (true)
	{
		case $number < 21:
			$string = $dictionary[$number];
			break;
		case $number < 100:
			$tens = ((int)($number / 10)) * 10;
			$units = $number % 10;
			$string = $dictionary[$tens];
			if( $units )
			{
				$string .= $hyphen . $dictionary[$units];
			}
			break;
		case $number < 1000:
			$hundreds = $number / 100;
			$remainder = $number % 100;
			$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
			if( $remainder )
			{
				$string .= $conjunction .  $this->convert_number_to_words( $remainder );
			}
			break;
		default:
			$baseUnit = pow( 1000, floor( log( $number, 1000 ) ) );
			$numBaseUnits = (int)($number / $baseUnit);
			$remainder = $number % $baseUnit;
			$string =  $this->convert_number_to_words( $numBaseUnits ) . ' ' . $dictionary[$baseUnit];
			if( $remainder )
			{
				$string .= $remainder < 100 ? $conjunction : $separator;
				$string .=  $this->convert_number_to_words( $remainder );
			}
			break;
	}

	if( null !== $fraction && is_numeric( $fraction ) )
	{
		$string .= $decimal;
		$words = array( );
		foreach( str_split((string) $fraction) as $number )
		{
			$words[] = $dictionary[$number];
		}
		$string .= implode( ' ', $words );
	}

	return $string;
}
}
