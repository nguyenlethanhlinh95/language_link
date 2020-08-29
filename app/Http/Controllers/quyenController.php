<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class quyenController extends Controller
{
    public function getXemNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 1)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 1)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 1)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 1)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemKhachHang()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 2)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemKhachHang()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 2)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaKhachHang()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 2)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaKhachHang()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 2)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemPhongVan()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 3)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemPhongVan()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 3)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaPhongVan()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 3)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaPhongVan()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 3)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function geCapNhatKetQuaPhongVan()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 200)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemChuongTrinhHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 4)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemTatCaChuongTrinhHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 229)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemChuongTrinhHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 4)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaChuongTrinhHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 4)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaChuongTrinhHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 4)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemKhoaHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 5)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemKhoaHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 5)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaKhoaHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 5)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaKhoaHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 5)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemCapDo()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 6)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemCapDo()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 6)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaCapDo()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 6)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaCapDo()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 6)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemLopHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 6)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemLopHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 6)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaLopHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 6)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaLopHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 6)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemCapDoChiTiet()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 7)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemCapDoChiTiet()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 7)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaCapDoChiTiet()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 7)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaCapDoChiTiet()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 7)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemHocVienLopHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 7)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemHocVienLopHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 7)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaHocVienLopHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 7)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaHocVienLopHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 7)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemBaiGiang()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 8)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemBaiGiang()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 8)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaBaiGiang()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 8)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaBaiGiang()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 8)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }



    public function getXemBaiTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 9)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemBaiTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 9)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaBaiTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 9)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaBaiTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 9)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemChoMoLop()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 10)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemPhieuThu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 11)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemTatCaPhieuThu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 219)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemPhieuThu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 11)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaPhieuThu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 11)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaPhieuThu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 11)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemKetQuaHocTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 13)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    
    public function getThemKetQuaHocTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 13)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaKetQuaHocTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 13)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaKetQuaHocTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 13)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemTatCaThongBao()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 230)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemThongBao()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 50)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemThongBao()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 50)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaThongBao()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 50)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaThongBao()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 50)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemLoaiKetQuaHocTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 12)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    
    public function getThemLoaiKetQuaHocTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 12)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaLoaiKetQuaHocTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 12)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaLoaiKetQuaHocTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 12)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getCapNhatKetQuaHocTapHocVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 304)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemLoaiCSVC()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 15)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemLoaiCSVC()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 15)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaLoaiCSVC()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 15)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaLoaiCSVC()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 15)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemCSVC()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 16)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemCSVC()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 16)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaCSVC()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 16)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaCSVC()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 16)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemVatPhamChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 20)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemVatPhamChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 20)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaVatPhamChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 20)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaVatPhamChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 20)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemTatCaVatPhamChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 220)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }






    public function getXemTonKho()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 17)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemTonKho()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 17)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaTonKho()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 17)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemTonKhoTatCaChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 223)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemPhieuXuat()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 18)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemPhieuXuat()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 18)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaPhieuXuat()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 18)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaPhieuXuat()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 18)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemNhanXet()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 41)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemNhanXet()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 41)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaNhanXet()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 41)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaNhanXet()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 41)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemNhanXetChiTiet()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 42)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemNhanXetChiTiet()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 42)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaNhanXetChiTiet()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 42)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaNhanXetChiTiet()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 42)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemNhanXetDiemSo()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 43)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemNhanXetDiemSo()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 43)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaNhanXetDiemSo()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 43)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaNhanXetDiemSo()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 43)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }



    public function getXemNhiemVu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 51)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemNhiemVu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 51)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaNhiemVu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 51)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaNhiemVu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 51)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemLichThang()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 422)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemLichThangTongQuat()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 423)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemNghiPhep()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 40)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemNghiPhep()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 40)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaNghiPhep()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 40)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaNghiPhep()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 40)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemNhanXetKetQuaHocTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 14)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemNhanXetKetQuaHocTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 14)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaNhanXetKetQuaHocTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 14)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaNhanXetKetQuaHocTap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 14)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemNghiPhepNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 44)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemNghiPhepNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 44)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaNghiPhepNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 44)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaNghiPhepNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 44)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }





    public function getXemPhieuXuatMarketing()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 26)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemPhieuXuatMarketing()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 26)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaPhieuXuatMarketing()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 26)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaPhieuXuatMarketing()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 26)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemTatCaPhieuXuatMarketing()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 231)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemTatCaPhieuXuat()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 221)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemPhieuNhap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 19)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemPhieuNhap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 19)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaPhieuNhap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 19)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaPhieuNhap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 19)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemTatCaPhieuNhap()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 222)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getDuyetPhieuXuat()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 204)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaSauDuyetPhieuXuat()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 205)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaSauDuyetPhieuXuat()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 206)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 21)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 21)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 21)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 21)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemChiNhanhVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 22)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemChiNhanhVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 22)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaChiNhanhVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 22)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaChiNhanhVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 22)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemTatCaChiNhanhVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 224)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemTonKhoTatCaChiNhanhVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 225)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemTonKhoVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 23)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemPhieuNhapVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 24)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemPhieuNhapVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 24)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaPhieuNhapVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 24)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaPhieuNhapVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 24)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getPhieuNhapVatPhamTatCaChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 226)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemPhieuXuatVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 25)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemPhieuXuatVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 25)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaPhieuXuatVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 25)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaPhieuXuatVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 25)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getPhieuXuatVatPhamTatCaChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 227)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemMarketing()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 30)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemMarketing()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 30)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaMarketing()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 30)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaMarketing()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 30)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemCTKM()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 31)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemCTKM()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 31)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaCTKM()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 31)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaCTKM()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 31)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemNgayLe()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 32)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemNgayLe()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 32)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaNgayLe()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 32)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaNgayLe()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 32)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }



    public function getXemChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 33)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 33)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 33)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 33)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemPhongHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 34)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemPhongHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 34)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaPhongHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 34)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaPhongHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 34)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemChucVu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 35)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThemChucVu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 35)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaChucVu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 35)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaChucVu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 35)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemNhomQuyen()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 90)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getThemNhomQuyen()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 90)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaNhomQuyen()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 90)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaNhomQuyen()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 90)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemTeam()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 36)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemTatCaTeam()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 228)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getThemTeam()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 36)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaTeam()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 36)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaTeam()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 36)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemTeamNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 37)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
  

    public function getThemTeamNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 37)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaTeamNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 37)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaTeamNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 37)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXemPhongBan()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 38)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
  

    public function getThemPhongBan()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 38)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaPhongBan()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 38)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaPhongBan()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 38)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXemKhungGio()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 39)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
  

    public function getThemKhungGio()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 39)
            ->where('chiTietQuyen_id', 2)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getSuaKhungGio()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 39)
            ->where('chiTietQuyen_id', 3)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXoaKhungGio()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 39)
            ->where('chiTietQuyen_id', 4)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }


    public function getXepLichLopHoc()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 401)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXepLichNhanVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 402)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXepLichChiNhanh()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 401)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXepLichMoLop()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 402)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getGioLamViec()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 405)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getXuatGioLamViec()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 406)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

  
    public function getThongKeThu()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 701)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThongKeChi()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 702)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThongKeThuChi()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 700)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

    public function getThongKeNhapVatPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 703)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThongKeXuatSanPham()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 704)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getThongKeHocVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 705)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemChiTietNhomQuyen()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 901)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function getXemQuyenGiaoVien()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 902)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }
    public function layDuLieu()
    {
        return 20;
    }

    public function getXemLichVanPhong()
    {
        $quyen = DB::table('view_quyen_chi_tiet_quyen')
            ->where('quyen_id', 421)
            ->where('chiTietQuyen_id', 1)
            ->where('employee_id', session('user'))
            ->get()->first();
        if (isset($quyen)) {
            return $quyen->quyen_chiTietQuyen_trangThai;
        } else
            return 0;
    }

}
