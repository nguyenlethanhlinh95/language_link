<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Psy\Sudo\SudoVisitor;

class chuongTrinhKhuyenMaiController extends Controller
{
    public function getChuongTrinhKM()
    {
        $quyen = new quyenController();
        $quyenXem = $quyen->getXemCTKM();
        if ($quyenXem == 1) {
            $lay = $quyen->layDuLieu();
            $khuyenMaiTong = DB::table('st_promotions')
                ->select('promotions_id')
                ->get();
            $khuyenMai = DB::table('st_promotions')
                ->orderByDesc('promotions_endDate')
                ->take($lay)
                ->skip(0)
                ->get();
            $soKM = count($khuyenMaiTong);
            $soTrang = (int) $soKM / $lay;
            if ($soKM % $lay > 0)
                $soTrang++;


            return view('ChuongTrinhKhuyenMai.chuongTrinhKhuyenMai')
                ->with('khuyenMai', $khuyenMai)
                ->with('soTrang', $soTrang)
                ->with('page', 1);
        } else return redirect()->back();
    }
    public function getThemChuongTrinhKM()
    {
        $quyen = new quyenController();
        $quyenThem = $quyen->getThemCTKM();
        if ($quyenThem == 1) {

            return view('ChuongTrinhKhuyenMai.themChuongTrinhKhuyenMai');
        } else return redirect()->back();
    }

    public function getCapNhatChuongTrinhKM(Request $request)
    {
        $quyen = new quyenController();
        $quyenSua = $quyen->getSuaCTKM();
        if ($quyenSua == 1) {
            $id = $request->get('id');
            $khuyenMai = DB::table('st_promotions')
                ->where('promotions_id', $id)
                ->get()
                ->first();

            return view('ChuongTrinhKhuyenMai.capNhatCTKM')
                ->with('khuyenMai', $khuyenMai);
        } else return redirect()->back();
    }
    public function postThemKM(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenThem = $quyen->getThemCTKM();
            if ($quyenThem == 1) {
                try {
                    $ten = $request->get('ten');
                    $loai = $request->get('loai');
                    $so = $request->get('so');
                    $gia = $request->get('gia');
                    $startDate = $request->get('startDate');
                    $startTime = $request->get('startTime');
                    $endDate = $request->get('endDate');
                    $endTime = $request->get('endTime');
                    if ($loai == 0 && $so == "") {
                        return response(3);
                    } else {
                        if ($so == "")
                            $so = 0;
                        $ngay = substr($startDate, 3, 2);
                        $thang = substr($startDate, 0, 2);
                        $nam = substr($startDate, 6, 4);
                        $ngayBatDau = $nam . "-" . $thang . "-" . $ngay . " " . $startTime;
                        $ngay1 = substr($endDate, 3, 2);
                        $thang1 = substr($endDate, 0, 2);
                        $nam1 = substr($endDate, 6, 4);
                        $ngayKetThuc = $nam1 . "-" . $thang1 . "-" . $ngay1 . " " . $endTime;

                        DB::table('st_promotions')
                            ->insert([
                                'promotions_name' => $ten,
                                'promotions_startDate' => $ngayBatDau,
                                'promotions_endDate' => $ngayKetThuc,
                                'promotions_discount' => $gia,
                                'promotions_status' => 1,
                                'promotions_type' => $loai,
                                'promotions_number' => $so
                            ]);
                        return response(1);
                    }
                } catch (QueryException $ex) {
                    return response(0);
                }
            } else return response(2);
        }
    }

    public function postCapNhatKM(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenSua = $quyen->getSuaCTKM();
            if ($quyenSua == 1) {
                try {
                    $id = $request->get('id');
                    $ten = $request->get('ten');
                    $loai = $request->get('loai');
                    $so = $request->get('so');
                    $gia = $request->get('gia');
                    $startDate = $request->get('startDate');
                    $startTime = $request->get('startTime');
                    $endDate = $request->get('endDate');
                    $endTime = $request->get('endTime');
                    if ($loai == 0 && $so == "") {
                        return response(3);
                    } else {
                        if ($so == "")
                            $so = 0;
                        $ngay = substr($startDate, 3, 2);
                        $thang = substr($startDate, 0, 2);
                        $nam = substr($startDate, 6, 4);
                        $ngayBatDau = $nam . "-" . $thang . "-" . $ngay . " " . $startTime;
                        $ngay1 = substr($endDate, 3, 2);
                        $thang1 = substr($endDate, 0, 2);
                        $nam1 = substr($endDate, 6, 4);
                        $ngayKetThuc = $nam1 . "-" . $thang1 . "-" . $ngay1 . " " . $endTime;

                        DB::table('st_promotions')
                            ->where('promotions_id', $id)
                            ->update([
                                'promotions_name' => $ten,
                                'promotions_startDate' => $ngayBatDau,
                                'promotions_endDate' => $ngayKetThuc,
                                'promotions_discount' => $gia,
                                'promotions_type' => $loai,
                                'promotions_number' => $so
                            ]);
                        return response(1);
                    }
                } catch (QueryException $ex) {
                    return response(0);
                }
            } else return response(2);
        }
    }
    public function getXoaCTKM(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenXoa = $quyen->getXoaCTKM();
            if ($quyenXoa == 1) {
                try {
                    $id = $request->get('id');

                    DB::table('st_promotions')
                        ->where('promotions_id', $id)
                        ->delete();
                    return response(1);
                } catch (QueryException $ex) {
                    return response(0);
                }
            } else return response(2);
        }
    }


    public function searchCTKM(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $lay = $quyen->layDuLieu();
            $value = $request->get('value');
            $page = $request->get('page');
            if ($value == "")
                $khuyenMai = DB::table('st_promotions')
                    ->orderByDesc('promotions_endDate')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();
            else
                $khuyenMai = DB::table('st_promotions')
                    ->orderByDesc('promotions_endDate')
                    ->where('promotions_name', 'like', '%' . $value . '%')
                    ->take($lay)
                    ->skip(($page - 1) * $lay)
                    ->get();

            $out = "";
            $i = 1;
            foreach ($khuyenMai as $item) {

                $out .= '<tr>
                <td>' . $i . '</td>
                <td>' . $item->promotions_name . '</td>     
                <td>' . date('H:i d/m/Y', strtotime($item->promotions_startDate)) . '</td>
                <td>' . date('H:i d/m/Y', strtotime($item->promotions_endDate)) . '</td>
                <td>' . $item->promotions_discount . '</td>
                <td>' . $item->promotions_number . '</td>';
                if ($item->promotions_type == 0)
                    $out .= '<td>Cố định</td>';
                else
                    $out .= '<td>Khác</td>';

                if (session('quyen313') == 1)
                    $out .= '<td>
                            <a class="btn" href=\'' . route('getCapNhatChuongTrinhKM') . '?id=' . $item->promotions_id . '\'>
                                <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                        </td>';
                if (session('quyen314') == 1)
                    $out .= '  <td>
                                        <a class="btn" onclick="xoa(\'' . $item->promotions_id . '\');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>';
                $out .= ' </tr>';
                $i++;
            }
            return response($out);
        }
    }
}
