<?php

use App\Http\Controllers\quyenController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {

//     $chucVu = DB::table('view_quyen_chi_tiet_quyen')
//             ->get();
//             $quyen = DB::table('st_quyen')
//             ->get();
//             $chiTietQuyen = DB::table('st_chi_tiet_quyen')
//             ->get();
        
//         $userController = new quyenController();
//        $quyenThemKH= $userController-> getXemKhachHang();
//     return view('welcome')
//     ->with('chucVu',$chucVu)
//     ->with('quyen',$quyen)
//     ->with('quyenThemKH',$quyenThemKH)
//     ->with('chiTietQuyen',$chiTietQuyen );
// });

Route::get('/', 'loginController@getLogin')->name('getLogin');
Route::post('/login', 'loginController@postLogin')->name('postLogin');

Route::get('/logout', 'loginController@getLogout')->name('getLogout');




Route::group(['middleware' => ['CheckLogin']], function () {
Route::get('trang-chu', 'trangChuController@getTrangChu')->name('getTrangChu');

	//Route::group(['prefix'=>'KhachHang'],function(){
Route::get('hoc-vien', 'khachHangController@getHocVien')->name('getHocVien');
Route::get('them-hoc-vien', 'khachHangController@getThemHocVien')->name('getThemHocVien');
Route::post('them-du-lieu-hoc-vien', 'khachHangController@postThemHocVien')->name('postThemHocVien');
Route::get('cap-nhat-hoc-vien', 'khachHangController@getCapNhatHocVien')->name('getCapNhatHocVien');
Route::post('cap-nhat-du-lieu-hoc-vien', 'khachHangController@postCapNhatHocVien')->name('postCapNhatHocVien');
Route::get('xoa-hoc-vien', 'khachHangController@getXoaHocVien')->name('getXoaHocVien');
//Route::get('search-hoc-vien', 'khachHangController@searchHocVien')->name('searchHocVien');
Route::get('tim-kiem-hoc-vien', 'khachHangController@searchHocVien')->name('searchHocVien');
//Route::get('ket-qua-tim-kiem-hoc-vien', 'khachHangController@searchHocVien')->name('searchHocVien');
Route::get('thong-tin-hoc-vien', 'khachHangController@getChiTietHocVien')->name('getChiTietHocVien');
Route::get('ghi-danh-hoc-vien', 'khachHangController@getGhiDanhHocVien')->name('getGhiDanhHocVien');
Route::get('search-hoc-vien-ghi-danh', 'khachHangController@searchHocVienGhiDanh')->name('searchHocVienGhiDanh');
Route::get('thong-tin-hoc-vien-ghi-danh', 'khachHangController@getThongTinGhiDanh')->name('getThongTinGhiDanh');
//)};

Route::get('phong-van', 'phongVanController@getPhongVan')->name('getPhongVan');
Route::get('them-phong-van', 'phongVanController@getThemPhongVan')->name('getThemPhongVan');
Route::get('them-du-lieu-phong-van', 'phongVanController@postThemPhongVan')->name('postThemPhongVan');
Route::get('cap-nhat-phong-van', 'phongVanController@getCapNhatPhongVan')->name('getCapNhatPhongVan');
Route::post('cap-nhat-du-lieu-phong-van', 'phongVanController@postCapNhatPhongVan')->name('postCapNhatPhongVan');
Route::get('xoa-phong-van', 'phongVanController@getXoaPhongVan')->name('getXoaPhongVan');
Route::get('search-phong-van', 'phongVanController@searchPhongVan')->name('searchPhongVan');
Route::get('ket-qua-phong-van', 'phongVanController@getCapNhatKetQuaPhongVan')->name('getCapNhatKetQuaPhongVan');
Route::post('ket-qua-du-lieu-phong-van', 'phongVanController@postCapNhatKetQuaPhongVan')->name('postCapNhatKetQuaPhongVan');
Route::get('getDuLieuLichPT', 'phongVanController@getDuLieuLichPT')->name('getDuLieuLichPT');
Route::get('kiemTraGiaoVienphongVan', 'phongVanController@kiemTraGiaoVienphongVan')->name('kiemTraGiaoVienphongVan');


Route::get('nghi-phep', 'nghiPhepController@getNghiPhep')->name('getNghiPhep');
Route::post('postThemNghiPhep', 'nghiPhepController@postThemNghiPhep')->name('postThemNghiPhep');
Route::post('postCapNhatNghiPhep', 'nghiPhepController@postCapNhatNghiPhep')->name('postCapNhatNghiPhep');
Route::get('getXoaNghiPhep', 'nghiPhepController@getXoaNghiPhep')->name('getXoaNghiPhep');


Route::get('nghi-phep-nhan-vien', 'nghiPhepController@getNghiPhepNhanVien')->name('getNghiPhepNhanVien');
Route::post('postThemNghiPhepNhanVien', 'nghiPhepController@postThemNghiPhepNhanVien')->name('postThemNghiPhepNhanVien');
Route::post('postCapNhatNghiPhepNhanVien', 'nghiPhepController@postCapNhatNghiPhepNhanVien')->name('postCapNhatNghiPhepNhanVien');
Route::get('getXoaNghiPhepNhanVien', 'nghiPhepController@getXoaNghiPhepNhanVien')->name('getXoaNghiPhepNhanVien');

Route::get('searchNghiPhepNhanVien', 'nghiPhepController@searchNghiPhepNhanVien')->name('searchNghiPhepNhanVien');







Route::get('chuong-trinh-hoc', 'chuongTrinhController@getChuongTrinhHoc')->name('getChuongTrinhHoc');
Route::post('them-du-lieu-chuong-trinh-hoc', 'chuongTrinhController@postThemChuongTrinHoc')->name('postThemChuongTrinHoc');
Route::post('cap-nhat-du-lieu-chuong-trinh-hoc', 'chuongTrinhController@postCapNhatChuongTrinhHoc')->name('postCapNhatChuongTrinhHoc');
Route::get('xoa-chuong-trinh-hoc', 'chuongTrinhController@getXoaChuongTrinhHoc')->name('getXoaChuongTrinhHoc');
Route::get('search-chuong-trinh-hoc', 'chuongTrinhController@searchChuongTrinh')->name('searchChuongTrinh');


Route::get('khoa-hoc', 'khoaHocController@getKhoaHoc')->name('getKhoaHoc');
Route::post('them-du-lieu-khoa-hoc', 'khoaHocController@postThemKhoaHoc')->name('postThemKhoaHoc');
Route::post('sua-du-lieu-khoa-hoc', 'khoaHocController@postCapNhatKhoaHoc')->name('postCapNhatKhoaHoc');
Route::get('xoa-khoa-hoc', 'khoaHocController@getXoaKhoaHoc')->name('getXoaKhoaHoc');
Route::get('search-khoa-hoc', 'khoaHocController@searchKhoaHoc')->name('searchKhoaHoc');



Route::get('lop-hoc', 'lopHocController@getLopHoc')->name('getLopHoc');

Route::get('them-lop-hoc', 'lopHocController@getThemLopHoc')->name('getThemLopHoc');
Route::get('them-du-lieu-lop-hoc', 'lopHocController@postThemLopHoc')->name('postThemLopHoc');
Route::get('cap-nhat-lop-hoc', 'lopHocController@capNhatLopHoc')->name('capNhatLopHoc');
Route::get('postCapNhatLopHoc', 'lopHocController@postCapNhatLopHoc')->name('postCapNhatLopHoc');


Route::get('changeCTHThemLop', 'lopHocController@changeCTHThemLop')->name('changeCTHThemLop');
Route::get('changeKHThemLop', 'lopHocController@changeKHThemLop')->name('changeKHThemLop');
Route::get('kiem-tra-lop-hoc','lopHocController@kiemTraLopHoc')
    ->name('kiemTraLopHoc');


Route::get('changeChiNhanhThemLop', 'lopHocController@changeChiNhanhThemLop')->name('changeChiNhanhThemLop');


Route::get('searchLopHoc', 'lopHocController@searchLopHoc')->name('searchLopHoc');
Route::get('getXoaLopHoc', 'lopHocController@getXoaLopHoc')->name('getXoaLopHoc');

Route::get('hoc-vien-lop-hoc', 'hocVienLopHocController@getHocVienLopHoc')->name('getHocVienLopHoc');
Route::get('getKiemTraTrangThaiHocVien', 'hocVienLopHocController@getKiemTraTrangThaiHocVien')->name('getKiemTraTrangThaiHocVien');
Route::post('postThemHocVienVaoLop', 'hocVienLopHocController@postThemHocVienVaoLop')->name('postThemHocVienVaoLop');
Route::post('postDiemDanhHocVien', 'hocVienLopHocController@postDiemDanhHocVien')->name('postDiemDanhHocVien');

Route::get('getThongTinLopChuyen', 'hocVienLopHocController@getThongTinLopChuyen')->name('getThongTinLopChuyen');
Route::get('getXoaHocVienKhoiLopHoc', 'hocVienLopHocController@getXoaHocVienKhoiLopHoc')->name('getXoaHocVienKhoiLopHoc');

Route::get('getChuyenLopHoc', 'hocVienLopHocController@getChuyenLopHoc')->name('getChuyenLopHoc');





Route::get('cap-do', 'capDoController@getCapDoLopHoc')->name('getCapDoLopHoc');
Route::post('them-cap-do', 'capDoController@postThemCapDo')->name('postThemCapDo');
Route::post('cap-nhat-cap-do', 'capDoController@postCapNhatCapDo')->name('postCapNhatCapDo');
Route::get('xoa-cap-do', 'capDoController@getXoaCapDo')->name('getXoaCapDo');
Route::get('search-cap-do', 'capDoController@searchCapDo')->name('searchCapDo');


Route::get('cap-do-chi-tiet', 'capDoController@getCapDoChiTiet')->name('getCapDoChiTiet');
Route::post('them-cap-do-chi-tiet', 'capDoController@postThemCapDoChiTiet')->name('postThemCapDoChiTiet');
Route::post('cap-nhat-cap-do-chi-tiet', 'capDoController@postCapNhatCapDoChiTiet')->name('postCapNhatCapDoChiTiet');
Route::get('xoa-cap-do-chi-tiet', 'capDoController@getXoaCapDoChiTiet')->name('getXoaCapDoChiTiet');
Route::get('search-cap-do-chi-tiet', 'capDoController@searchCapDoChiTiet')->name('searchCapDoChiTiet');


Route::get('bai-giang', 'baiGiangController@getBaiGiang')->name('getBaiGiang');
Route::post('them-du-lieu-bai-giang', 'baiGiangController@postThemBaiDay')->name('postThemBaiDay');
Route::post('cap-nhat-du-lieu-bai-giang', 'baiGiangController@postChinhSuaBaiDay')->name('postChinhSuaBaiDay');
Route::get('xoa-bai-giang', 'baiGiangController@getXoaBaiGiang')->name('getXoaBaiGiang');
Route::get('them-bai-giang', 'baiGiangController@getThemBaiGiang')->name('getThemBaiGiang');
Route::get('cap-nhat-bai-giang', 'baiGiangController@getCapNhatBaiGiang')->name('getCapNhatBaiGiang');
Route::get('getValueXuatLichChiNhanh', 'xepLichChiNhanhController@getValueXuatLichChiNhanh')->name('getValueXuatLichChiNhanh');





Route::get('cho-mo-lop', 'choLopController@getChoMoLop')->name('getChoMoLop');
Route::get('search-CTH-cho-mo-lop', 'choLopController@searchCTHChoMoLop')->name('searchCTHChoMoLop');
Route::get('search-KH-cho-mo-lop', 'choLopController@searchKHChoMoLop')->name('searchKHChoMoLop');




Route::get('them-phieu-thu', 'phieuThuController@getThemPhieuThu')->name('getThemPhieuThu');
Route::get('search-CTHT-phieu-thu', 'phieuThuController@searchCTHThemPhieuThu')->name('searchCTHThemPhieuThu');
Route::get('search-KH-phieu-thu', 'phieuThuController@searchKHThemPhieuThu')->name('searchKHThemPhieuThu');
Route::get('searhTongTienGiaKhac', 'phieuThuController@searhTongTienGiaKhac')->name('searhTongTienGiaKhac');
Route::get('searhTongTienPhamTramGiaKmhac', 'phieuThuController@searhTongTienPhamTramGiaKmhac')->name('searhTongTienPhamTramGiaKmhac');

Route::post('them-du-lieu-phieu-thu', 'phieuThuController@postThemPhieuThu')->name('postThemPhieuThu');

Route::get('phieu-thu', 'phieuThuController@getPhieuThu')->name('getPhieuThu');
Route::get('cap-nhat-phieu-thu', 'phieuThuController@getCapNhatPhieuThu')->name('getCapNhatPhieuThu');

Route::get('changeLoaiPhieuThu', 'phieuThuController@changeLoaiPhieuThu')->name('changeLoaiPhieuThu');
Route::get('getXoaPhieuThu', 'phieuThuController@getXoaPhieuThu')->name('getXoaPhieuThu');
Route::get('searchDanhSachPhieuThu', 'phieuThuController@searchDanhSachPhieuThu')->name('searchDanhSachPhieuThu');




Route::get('loai-vat-pham', 'coSoVatChatController@getLoaiCoSoVatChat')->name('getLoaiCoSoVatChat');
Route::post('them-du-lieu-loai-vat-pham', 'coSoVatChatController@postThemLoaiCoSoVatChat')
->name('postThemLoaiCoSoVatChat');
Route::post('cap-nhat-du-lieu-loai-vat-pham', 'coSoVatChatController@postCapNhatLoaiCoSoVatChat')
->name('postCapNhatLoaiCoSoVatChat');

Route::get('xoa-loai-vat-pham', 'coSoVatChatController@getXoaLoaiCoSoVatChat')->name('getXoaLoaiCoSoVatChat');

Route::get('getExportLoaiSanPham', 'coSoVatChatController@getExportLoaiSanPham')->name('getExportLoaiSanPham');


Route::post('postImportLoaiSanPham', 'coSoVatChatController@postImportLoaiSanPham')
->name('postImportLoaiSanPham');

Route::get('getExportSanPham', 'coSoVatChatController@getExportSanPham')->name('getExportSanPham');


Route::post('postImportSanPham', 'coSoVatChatController@postImportSanPham')
->name('postImportSanPham');



Route::get('vat-pham', 'coSoVatChatController@getCoSoVatChat')->name('getCoSoVatChat');

Route::post('them-du-lieu-vat-pham', 'coSoVatChatController@postThemCoSoVatChat')
->name('postThemCoSoVatChat');
Route::post('cap-nhat-du-lieu-vat-pham', 'coSoVatChatController@postCapNhatCoSoVatChat')
->name('postCapNhatCoSoVatChat');

Route::get('xoa-vat-pham', 'coSoVatChatController@getXoaCoSoVatChat')->name('getXoaCoSoVatChat');

Route::get('searchCSVC', 'coSoVatChatController@searchCSVC')->name('searchCSVC');

Route::get('ton-kho', 'coSoVatChatController@getTonKho')->name('getTonKho');
Route::post('them-ton-kho-du-lieu', 'coSoVatChatController@postThemTonKho')->name('postThemTonKho');
Route::post('cap-nhat-ton-kho-du-lieu', 'coSoVatChatController@postCapNhatTonKho')->name('postCapNhatTonKho');
Route::get('searchSanPhamTonKhoChiNhanh', 'coSoVatChatController@searchSanPhamTonKhoChiNhanh')->name('searchSanPhamTonKhoChiNhanh');



Route::get('phieu-nhap-kho', 'nhapKhoController@getPhieuNhap')->name('getPhieuNhap');
Route::get('them-phieu-nhap-kho', 'nhapKhoController@getThemPhieuNhap')->name('getThemPhieuNhap');
Route::post('them-du-lieu-phieu-nhap-kho', 'nhapKhoController@postThemPhieuNhapKho')->name('postThemPhieuNhapKho');
Route::get('getChangChiNhanhPhieuNhap', 'nhapKhoController@getChangChiNhanhPhieuNhap')->name('getChangChiNhanhPhieuNhap');
Route::get('cap-nhat-phieu-nhap-kho', 'nhapKhoController@getCapNhatPhieuNhap')->name('getCapNhatPhieuNhap');
Route::post('postCapNhatSanPham', 'nhapKhoController@postCapNhatSanPham')->name('postCapNhatSanPham');
Route::get('xoa-phieu-nhap-kho', 'nhapKhoController@getXoaPhieuNhap')->name('getXoaPhieuNhap');
Route::get('getChiTietPhieuNhap', 'nhapKhoController@getChiTietPhieuNhap')->name('getChiTietPhieuNhap');
Route::get('searchPhieuNhapKho', 'nhapKhoController@searchPhieuNhapKho')->name('searchPhieuNhapKho');








Route::get('vat-pham-chi-nhanh', 'vatPhamChiNhanhController@getVatPhamChiNhanh')->name('getVatPhamChiNhanh');
Route::post('them-du-lieu-vat-pham-chi-nhanh', 'vatPhamChiNhanhController@postThemVatPhamChiNhanh')->name('postThemVatPhamChiNhanh');
Route::post('getCapnhatVatPhamChiNhanh', 'vatPhamChiNhanhController@getCapnhatVatPhamChiNhanh')->name('getCapnhatVatPhamChiNhanh');

Route::get('xoa-vat-pham-chi-nhanh', 'vatPhamChiNhanhController@getXoaVatPhamChiNhanh')->name('getXoaVatPhamChiNhanh');
Route::get('searchSanPhamChiNhanh', 'vatPhamChiNhanhController@searchSanPhamChiNhanh')->name('searchSanPhamChiNhanh');




Route::get('phieu-xuat-kho', 'xuatKhoController@getXuatKho')->name('getXuatKho');

Route::get('them-phieu-xuat-kho', 'xuatKhoController@getThemPhieuXuatKho')->name('getThemPhieuXuatKho');
Route::post('them-du-lieu-phieu-xuat-kho', 'xuatKhoController@postThemPhieuXuatKho')->name('postThemPhieuXuatKho');
Route::get('cap-nhat-phieu-xuat-kho', 'xuatKhoController@getCapNhatPhieuXuatKho')->name('getCapNhatPhieuXuatKho');
Route::post('cap-nhat-du-lieu-phieu-xuat-kho', 'xuatKhoController@postCapNhatPhieuXuatKho')->name('postCapNhatPhieuXuatKho');
Route::get('duyet-phieu-xuat-kho', 'xuatKhoController@getDuyetPhieuXuatKho')->name('getDuyetPhieuXuatKho');
Route::get('getChiTietPhieuXuat', 'xuatKhoController@getChiTietPhieuXuat')->name('getChiTietPhieuXuat');
Route::get('getChangeChiNhanhPhieuXuat', 'xuatKhoController@getChangeChiNhanhPhieuXuat')->name('getChangeChiNhanhPhieuXuat');
Route::get('getXoaPhieuXuat', 'xuatKhoController@getXoaPhieuXuat')->name('getXoaPhieuXuat');

Route::get('searchPhieuXuat', 'xuatKhoController@searchPhieuXuat')->name('searchPhieuXuat');



Route::get('phieu-xuat-kho-marketing', 'xuatKhoMarketingController@getXuatKhoMarketing')->name('getXuatKhoMarketing');
Route::get('them-phieu-xuat-kho-marketing', 'xuatKhoMarketingController@getThemPhieuXuatMarketingKho')->name('getThemPhieuXuatMarketingKho');
Route::post('postThemPhieuXuatMarketing', 'xuatKhoMarketingController@postThemPhieuXuatMarketing')->name('postThemPhieuXuatMarketing');
Route::get('cap-nhat-phieu-xuat-kho-marketing', 'xuatKhoMarketingController@getCapNhatPhieuXuatMarketingKho')->name('getCapNhatPhieuXuatMarketingKho');
Route::get('searchPhieuXuatMarketing', 'xuatKhoMarketingController@searchPhieuXuatMarketing')->name('searchPhieuXuatMarketing');




Route::get('co-so-vat-chat', 'vatPhamController@getVatPham')->name('getVatPham');
Route::post('them-co-so-vat-chat', 'vatPhamController@postThemVatPham')->name('postThemVatPham');
Route::post('cap-nhat-co-so-vat-chat', 'vatPhamController@postCapNhatVatPham')->name('postCapNhatVatPham');
Route::get('xoa-co-so-vat-chat', 'vatPhamController@getXoaVatPham')->name('getXoaVatPham');
Route::get('searchVatPham', 'vatPhamController@searchVatPham')->name('searchVatPham');






Route::get('co-so-vat-chat-chi-nhanh', 'chiNhanhVatPhamController@getChiNhanhVatPham')->name('getChiNhanhVatPham');
Route::post('postThemChiNhanhVatPham', 'chiNhanhVatPhamController@postThemChiNhanhVatPham')->name('postThemChiNhanhVatPham');
Route::get('getXoaChiNhanhVatPham', 'chiNhanhVatPhamController@getXoaChiNhanhVatPham')->name('getXoaChiNhanhVatPham');
Route::get('searchVatPhamChiNhanh', 'chiNhanhVatPhamController@searchVatPhamChiNhanh')->name('searchVatPhamChiNhanh');



Route::get('ton-kho-co-so-vat-chat', 'tonKhoVatPhamController@getTonKhoVatPham')->name('getTonKhoVatPham');
Route::get('searchTonkhoVatPham', 'tonKhoVatPhamController@searchTonkhoVatPham')->name('searchTonkhoVatPham');



Route::get('nhap-kho-co-so-vat-chat', 'phieuNhapVatPhamController@getPhieuNhapVatPham')->name('getPhieuNhapVatPham');
Route::get('them-nhap-kho-co-so-vat-chat', 'phieuNhapVatPhamController@getThemPhieuNhapVatPham')->name('getThemPhieuNhapVatPham');
Route::get('getChangChiNhanhPhieuNhapVatPham', 'phieuNhapVatPhamController@getChangChiNhanhPhieuNhapVatPham')->name('getChangChiNhanhPhieuNhapVatPham');
Route::post('postThemPhieuNhapVatPhamKho', 'phieuNhapVatPhamController@postThemPhieuNhapVatPhamKho')->name('postThemPhieuNhapVatPhamKho');
Route::get('cap-nhat-nhap-kho-co-so-vat-chat', 'phieuNhapVatPhamController@getCapNhatPhieuNhapVatPham')->name('getCapNhatPhieuNhapVatPham');
Route::post('postCapNhatPhieuNhapSanPham', 'phieuNhapVatPhamController@postCapNhatPhieuNhapSanPham')->name('postCapNhatPhieuNhapSanPham');
Route::get('getXoaPhieuNhapVatPham', 'phieuNhapVatPhamController@getXoaPhieuNhapVatPham')->name('getXoaPhieuNhapVatPham');
Route::get('getChiTietPhieuNhapVatPham', 'phieuNhapVatPhamController@getChiTietPhieuNhapVatPham')->name('getChiTietPhieuNhapVatPham');
Route::get('searchPhieuNhapVatPham', 'phieuNhapVatPhamController@searchPhieuNhapVatPham')->name('searchPhieuNhapVatPham');



Route::get('xuat-kho-co-so-vat-chat', 'phieuXuatVatPhamController@getXuatVatPham')->name('getXuatVatPham');
Route::get('them-xuat-kho-co-so-vat-chat', 'phieuXuatVatPhamController@getThemPhieuXuatVatPham')->name('getThemPhieuXuatVatPham');
Route::post('postThemPhieuXuatVatPham', 'phieuXuatVatPhamController@postThemPhieuXuatVatPham')->name('postThemPhieuXuatVatPham');
Route::get('cap-nhat-xuat-kho-co-so-vat-chat', 'phieuXuatVatPhamController@getCapNhatPhieuXuatVatPham')->name('getCapNhatPhieuXuatVatPham');
Route::post('postCapNhatPhieuXuatVatPham', 'phieuXuatVatPhamController@postCapNhatPhieuXuatVatPham')->name('postCapNhatPhieuXuatVatPham');
Route::get('getXoaPhieuXuatVatPham', 'phieuXuatVatPhamController@getXoaPhieuXuatVatPham')->name('getXoaPhieuXuatVatPham');

Route::get('getChiTietPhieuXuatVatPham', 'phieuXuatVatPhamController@getChiTietPhieuXuatVatPham')->name('getChiTietPhieuXuatVatPham');

Route::get('searchPhieuXuatVatPham', 'phieuXuatVatPhamController@searchPhieuXuatVatPham')->name('searchPhieuXuatVatPham');



Route::get('getChangeChiNhanhPhieuXuatVatPham', 'phieuXuatVatPhamController@getChangeChiNhanhPhieuXuatVatPham')->name('getChangeChiNhanhPhieuXuatVatPham');



Route::get('marketing', 'marketingController@getMarketing')->name('getMarketing');
Route::post('them-marketing', 'marketingController@postThemMarketing')->name('postThemMarketing');

Route::post('cap-nhat-marketing', 'marketingController@postCapNhatMarketing')->name('postCapNhatMarketing');

Route::get('xoa-marketing', 'marketingController@xoaMarketing')->name('xoaMarketing');
Route::get('search-marketing', 'marketingController@searchMarketing')->name('searchMarketing');
Route::get('search-page-marketing', 'marketingController@searchPageMarketing')->name('searchPageMarketing');




Route::get('khuyen-mai', 'chuongTrinhKhuyenMaiController@getChuongTrinhKM')->name('getChuongTrinhKM');
Route::get('them-khuyen-mai', 'chuongTrinhKhuyenMaiController@getThemChuongTrinhKM')->name('getThemChuongTrinhKM');
Route::post('them-du-lieu-khuyen-mai', 'chuongTrinhKhuyenMaiController@postThemKM')->name('postThemKM');
Route::get('cap-nhat-khuyen-mai', 'chuongTrinhKhuyenMaiController@getCapNhatChuongTrinhKM')->name('getCapNhatChuongTrinhKM');
Route::post('cap-nhat-du-lieu-khuyen-mai', 'chuongTrinhKhuyenMaiController@postCapNhatKM')->name('postCapNhatKM');
Route::get('xoa-khuyen-mai', 'chuongTrinhKhuyenMaiController@getXoaCTKM')->name('getXoaCTKM');

Route::get('search-khuyen-mai', 'chuongTrinhKhuyenMaiController@searchCTKM')->name('searchCTKM');



Route::get('ngay-le', 'ngayLeController@getNgayLe')->name('getNgayLe');
Route::post('them-du-lieu-ngay-le', 'ngayLeController@postThemNgayLe')->name('postThemNgayLe');
Route::post('cap-nhat-du-lieu-ngay-le', 'ngayLeController@postCapNhatNgayLe')->name('postCapNhatNgayLe');
Route::get('xoa-ngay-le', 'ngayLeController@getXoaNgayLe')->name('getXoaNgayLe');
Route::get('searchPageNgayLe', 'ngayLeController@searchPageNgayLe')->name('searchPageNgayLe');





Route::get('chi-nhanh', 'chiNhanhController@getChiNhanh')->name('getChiNhanh');
Route::get('them-chi-nhanh', 'chiNhanhController@getThemChinhanh')->name('getThemChinhanh');
Route::post('them-du-lieu-chi-nhanh', 'chiNhanhController@postThemChiNhanh')->name('postThemChiNhanh');
Route::get('cap-nhat-chi-nhanh', 'chiNhanhController@getCapNhatChiNhanh')->name('getCapNhatChiNhanh');
Route::post('cap-nhat-du-lieu-chi-nhanh', 'chiNhanhController@postCapNhatChiNhanh')->name('postCapNhatChiNhanh');
Route::get('xoa-chi-nhanh', 'chiNhanhController@getXoaChiNhanh')->name('getXoaChiNhanh');
Route::get('search-chi-nhanh', 'chiNhanhController@searchChiNhanh')->name('searchChiNhanh');


Route::get('phong-hoc', 'phongHocController@getPhongHoc')->name('getPhongHoc');
Route::post('them-du-lieu-phong-hoc', 'phongHocController@postThemPhongHoc')->name('postThemPhongHoc');
Route::post('cap-nhat-du-lieu-phong-hoc', 'phongHocController@postCapNhatPhongHoc')->name('postCapNhatPhongHoc');

Route::get('xoa-phong-hoc', 'phongHocController@getXoaPhongHoc')->name('getXoaPhongHoc');





Route::get('nhom-quyen', 'nhomQuyenController@getNhomQuyen')->name('getNhomQuyen');
Route::post('postThemNhomQuyen', 'nhomQuyenController@postThemNhomQuyen')->name('postThemNhomQuyen');
Route::post('postCapNhatNhomQuyen', 'nhomQuyenController@postCapNhatNhomQuyen')->name('postCapNhatNhomQuyen');
Route::get('getXoaNhomQuyen', 'nhomQuyenController@getXoaNhomQuyen')->name('getXoaNhomQuyen');
Route::get('nhom-quyen-chi-tiet', 'nhomQuyenController@getChiTietNhomQuyen')->name('getChiTietNhomQuyen');
Route::get('capNhatTrangThaiNhomQuyen', 'nhomQuyenController@capNhatTrangThaiNhomQuyen')->name('capNhatTrangThaiNhomQuyen');

Route::get('searchNhomQuyen', 'nhomQuyenController@searchNhomQuyen')->name('searchNhomQuyen');

Route::get('quyen-giao-vien', 'nhomQuyenController@getQuyenGiaoVien')->name('getQuyenGiaoVien');
Route::get('searchNhomQuyenGiaoVien', 'nhomQuyenController@searchNhomQuyenGiaoVien')->name('searchNhomQuyenGiaoVien');
Route::get('quyen-giao-vien-chi-tiet', 'nhomQuyenController@getChiTietNhomQuyenGiaoVien')->name('getChiTietNhomQuyenGiaoVien');


Route::get('capNhatTrangThaiNhomQuyenGiaoVien', 'nhomQuyenController@capNhatTrangThaiNhomQuyenGiaoVien')->name('capNhatTrangThaiNhomQuyenGiaoVien');




Route::get('chuc-vu', 'chucVuController@getChucVu')->name('getChucVu');
Route::post('postThemChucVu', 'chucVuController@postThemChucVu')->name('postThemChucVu');
Route::post('postCapNhatChucVu', 'chucVuController@postCapNhatChucVu')->name('postCapNhatChucVu');
Route::get('getXoaChucVu', 'chucVuController@getXoaChucVu')->name('getXoaChucVu');
Route::get('searchChucVu', 'chucVuController@searchChucVu')->name('searchChucVu');

Route::get('phong-ban', 'phongBanController@getPhongBan')->name('getPhongBan');
Route::post('postThemPhongBan', 'phongBanController@postThemPhongBan')->name('postThemPhongBan');
Route::post('postCapNhatPhongBan', 'phongBanController@postCapNhatPhongBan')->name('postCapNhatPhongBan');
Route::get('getXoaPhongBan', 'phongBanController@getXoaPhongBan')->name('getXoaPhongBan');
Route::get('searchPhongBan', 'phongBanController@searchPhongBan')->name('searchPhongBan');


Route::get('khung-gio', 'khungGioController@getKhungGio')->name('getKhungGio');
Route::post('postThemKhungGio', 'khungGioController@postThemKhungGio')->name('postThemKhungGio');
Route::post('postCapNhatKhungGio', 'khungGioController@postCapNhatKhungGio')->name('postCapNhatKhungGio');
Route::get('getXoaKhungGio', 'khungGioController@getXoaKhungGio')->name('getXoaKhungGio');
Route::get('searchKhungGio', 'khungGioController@searchKhungGio')->name('searchKhungGio');




Route::get('nhan-su', 'nhanSuController@getNhanSu')->name('getNhanSu');
Route::get('them-nhan-su', 'nhanSuController@getThemNhanSu')->name('getThemNhanSu');
Route::post('postThemNhanSu', 'nhanSuController@postThemNhanSu')->name('postThemNhanSu');
Route::get('cap-nhat-nhan-su', 'nhanSuController@getCapNhatNhanSu')->name('getCapNhatNhanSu');
Route::post('postCapNhatNhanSu', 'nhanSuController@postCapNhatNhanSu')->name('postCapNhatNhanSu');
Route::get('getXoaNhanSu', 'nhanSuController@getXoaNhanSu')->name('getXoaNhanSu');
Route::get('searchNhanSu', 'nhanSuController@searchNhanSu')->name('searchNhanSu');

Route::get('xep-lich-lop-hoc', 'xepLichLopHocController@getXepLichLopHoc')->name('getXepLichLopHoc');
Route::get('xep-lich-giao-vien-lop-hoc', 'xepLichLopHocController@getThemXepLichLopHoc')->name('getThemXepLichLopHoc');

Route::get('searchPhong', 'xepLichLopHocController@searchPhong')->name('searchPhong');
Route::get('kiemTraGiaoVienThem', 'xepLichLopHocController@kiemTraGiaoVienThem')->name('kiemTraGiaoVienThem');

Route::get('postThemXepLichLopHoc', 'xepLichLopHocController@postThemXepLichLopHoc')->name('postThemXepLichLopHoc');


Route::get('lich-van-phong', 'lichVanPhongController@getLichVanPhong')->name('getLichVanPhong');

Route::get('xep-lich-van-phong', 'lichVanPhongController@getXepLicVanPhong')->name('getXepLicVanPhong');

Route::post('postXepLichVanPhong', 'lichVanPhongController@postXepLichVanPhong')->name('postXepLichVanPhong');


Route::get('lich-van-phong-nhan-vien', 'lichVanPhongController@getXemLichVanPhong')->name('getXemLichVanPhong');

Route::get('lich-thang-van-phong-nhan-vien', 'lichVanPhongThangController@getXepLichThang')->name('getXepLichThang');
Route::post('postXepLichVanPhongThang', 'lichVanPhongThangController@postXepLichVanPhongThang')->name('postXepLichVanPhongThang');

Route::get('lich-tong-quat', 'lichVanPhongThangController@getLichTongQuat')->name('getLichTongQuat');








Route::get('xep-lich-nhan-vien', 'xepLichNhanVienController@getNhanVienLich')->name('getNhanVienLich');
Route::get('lich-lam-viec-nhan-vien', 'xepLichNhanVienController@getLichNhanVien')->name('getLichNhanVien');
Route::get('lich-lam-viec-nhan-vien-tuan', 'xepLichNhanVienController@getLichNhanVientuan')->name('getLichNhanVientuan');
Route::get('gio-lam-viec-nhan-vien', 'xepLichNhanVienController@getGioLamGiaoVien')->name('getGioLamGiaoVien');
Route::post('gio-lam-viec-nhan-vien', 'xepLichNhanVienController@postTimGioGiaoVien')->name('postTimGioGiaoVien');
Route::get('searchXepLichNhanVien', 'xepLichNhanVienController@searchXepLichNhanVien')->name('searchXepLichNhanVien');

Route::get('cap-nhat-lich-nhan-vien', 'xepLichNhanVienController@getXepLichGiaoVien')->name('getXepLichGiaoVien');
Route::get('getCapNhatDaiHanXepLichGiaoVien', 'xepLichNhanVienController@getCapNhatDaiHanXepLichGiaoVien')->name('getCapNhatDaiHanXepLichGiaoVien');
Route::get('getCapNhatXepLichGiaoVien', 'xepLichNhanVienController@getCapNhatXepLichGiaoVien')->name('getCapNhatXepLichGiaoVien');
Route::get('gui-mail', 'xepLichNhanVienController@html_email')->name('html_email');



Route::get('xep-lich-chi-nhanh', 'xepLichChiNhanhController@getLichChiNhanh')->name('getLichChiNhanh');
Route::get('xep-lich-chi-nhanh-chi-tiet', 'xepLichChiNhanhController@getLichChiNhanhChiTiet')->name('getLichChiNhanhChiTiet');
Route::get('xep-lich-chi-nhanh-chi-tiet-tuan', 'xepLichChiNhanhController@postLichChiNhanhTuan')->name('postLichChiNhanhTuan');

Route::get('gio-lam-viec-chi-nhanh', 'xepLichChiNhanhController@getGioLamChiNhanh')->name('getGioLamChiNhanh');

Route::post('gio-lam-viec-chi-nhanh', 'xepLichChiNhanhController@postTimGioChiNhanh')->name('postTimGioChiNhanh');


Route::post('postCapNhatLichDayNganHan', 'xepLichChiNhanhController@postCapNhatLichDayNganHan')->name('postCapNhatLichDayNganHan');





Route::get('getDanhSachLopXepLich', 'xepLichChiNhanhController@getDanhSachLopXepLich')->name('getDanhSachLopXepLich');

Route::get('getChangeLich', 'xepLichChiNhanhController@getChangeLich')->name('getChangeLich');

Route::get('getXuatLichGiaoVien', 'xepLichChiNhanhController@getXuatLichGiaoVien')->name('getXuatLichGiaoVien');





Route::get('tao-lich-lop-hoc', 'xepLichLopController@getXepLichLop')->name('getXepLichLop');

Route::get('tao-lich-lop-hoc-moi', 'xepLichLopController@getXepLichLopMoi')->name('getXepLichLopMoi');

Route::get('kiemTraXepLichLopHoc', 'xepLichLopController@kiemTraXepLichLopHoc')->name('kiemTraXepLichLopHoc');

Route::get('postXepLichLopHoc', 'xepLichLopController@postXepLichLopHoc')->name('postXepLichLopHoc');
Route::get('getLuuLich', 'xepLichLopController@getLuuLich')->name('getLuuLich');

Route::get('kiemTraLopHocXepLich', 'xepLichLopController@kiemTraLopHocXepLich')->name('kiemTraLopHocXepLich');


Route::get('gio-lam-viec', 'gioLamViecController@getGioLamVien')->name('getGioLamVien');
Route::get('getDuLieuGioLamViecChiNhanh', 'gioLamViecController@getDuLieuGioLamViecChiNhanh')->name('getDuLieuGioLamViecChiNhanh');
Route::get('getDuLieuGioLamGiaoVien', 'gioLamViecController@getDuLieuGioLamGiaoVien')->name('getDuLieuGioLamGiaoVien');



Route::get('loai-ket-qua-hoc-tap', 'ketQuaHocTapController@getLoaiKetQuaHocTap')->name('getLoaiKetQuaHocTap');
Route::post('postThemLoaiKetQuaHocTap', 'ketQuaHocTapController@postThemLoaiKetQuaHocTap')->name('postThemLoaiKetQuaHocTap');
Route::post('postCapNhatLoaiKetQuaHocTap', 'ketQuaHocTapController@postCapNhatLoaiKetQuaHocTap')->name('postCapNhatLoaiKetQuaHocTap');
Route::get('getXoaLoaiKetQuaHocTap', 'ketQuaHocTapController@getXoaLoaiKetQuaHocTap')->name('getXoaLoaiKetQuaHocTap');
Route::get('searchLoaiKetQuaHocTap', 'ketQuaHocTapController@searchLoaiKetQuaHocTap')->name('searchLoaiKetQuaHocTap');
Route::get('searchLoaiKetQuaHocTapHocVien', 'ketQuaHocTapController@searchLoaiKetQuaHocTapHocVien')->name('searchLoaiKetQuaHocTapHocVien');



Route::get('ket-qua-hoc-tap', 'ketQuaHocTapController@getKetQuaHocTap')->name('getKetQuaHocTap');
Route::post('postThemKetQuaHocTap', 'ketQuaHocTapController@postThemKetQuaHocTap')->name('postThemKetQuaHocTap');

Route::post('postCapNhatKetQuaHocTap', 'ketQuaHocTapController@postCapNhatKetQuaHocTap')->name('postCapNhatKetQuaHocTap');
Route::get('getXoaKetQuaHocTap', 'ketQuaHocTapController@getXoaKetQuaHocTap')->name('getXoaKetQuaHocTap');

Route::get('searchKetQuaHocTap', 'ketQuaHocTapController@searchKetQuaHocTap')->name('searchKetQuaHocTap');



Route::get('nhan-xet-ket-qua-hoc-tap', 'ketQuaHocTapController@getNhanXetKetQuaHocTap')->name('getNhanXetKetQuaHocTap');
Route::post('postThemNhanXetLoaiKetQuaHocTap', 'ketQuaHocTapController@postThemNhanXetLoaiKetQuaHocTap')
->name('postThemNhanXetLoaiKetQuaHocTap');
Route::post('postCapNhatNhanXetLoaiKetQuaHocTap', 'ketQuaHocTapController@postCapNhatNhanXetLoaiKetQuaHocTap')
->name('postCapNhatNhanXetLoaiKetQuaHocTap');

Route::get('getXoaNhanXetKetQuaHocTap', 'ketQuaHocTapController@getXoaNhanXetKetQuaHocTap')->name('getXoaNhanXetKetQuaHocTap');








Route::get('cap-nhat-ket-qua-hoc-tap', 'ketQuaHocTapLopHocController@getKetQuaHocTapHocVien')->name('getKetQuaHocTapHocVien');

Route::post('postCapNhatKetQuaHocVien', 'ketQuaHocTapLopHocController@postCapNhatKetQuaHocVien')->name('postCapNhatKetQuaHocVien');
Route::get('cap-nhat-loai-ket-qua-hoc-tap', 'ketQuaHocTapLopHocController@getLoaiKetQuaHocTapHocVien')->name('getLoaiKetQuaHocTapHocVien');
Route::get('exportKetQuaHocTap', 'ketQuaHocTapLopHocController@exportKetQuaHocTap')->name('exportKetQuaHocTap');


Route::get('danh-sach-hoc-vien-lop', 'ketQuaHocTapLopHocController@getDanhSachHocVienKetQuaHocTap')
->name('getDanhSachHocVienKetQuaHocTap');

Route::get('nhan-xet-hoc-vien-lop', 'ketQuaHocTapLopHocController@getNhanXetHocVien')
->name('getNhanXetHocVien');

Route::post('postNhanXetHocVien', 'ketQuaHocTapLopHocController@postNhanXetHocVien')
->name('postNhanXetHocVien');


Route::get('xuatKetQuaHocVien', 'ketQuaHocTapLopHocController@xuatKetQuaHocVien')->name('xuatKetQuaHocVien');










Route::get('thong-ke-doanh-thu', 'thongKeThuChiController@getThongKeThu')->name('getThongKeThu');
Route::get('searchThongKeThuThoiGian', 'thongKeThuChiController@searchThongKeThuThoiGian')->name('searchThongKeThuThoiGian');
Route::post('thong-ke-doanh-thu', 'thongKeThuChiController@searchThongKeThuKhoangThoiGian')->name('searchThongKeThuKhoangThoiGian');
Route::get('thong-ke-chi-phi', 'thongKeThuChiController@getThongKeChi')->name('getThongKeChi');
Route::post('thong-ke-chi-phi', 'thongKeThuChiController@searchThongKeChi')->name('searchThongKeChi');

Route::get('thong-ke-thu-chi', 'thongKeThuChiController@getThongKeThuChi')->name('getThongKeThuChi');
Route::get('searchTongThuChi', 'thongKeThuChiController@searchTongThuChi')->name('searchTongThuChi');



Route::get('thong-ke-nhap-san-pham', 'thongKeNhapXuatSanPhamController@getNhapSanPham')->name('getNhapSanPham');
Route::post('thong-ke-nhap-san-pham', 'thongKeNhapXuatSanPhamController@searchThongNhapSanPham')->name('searchThongNhapSanPham');

Route::get('thong-ke-xuat-san-pham', 'thongKeNhapXuatSanPhamController@getThongKeXuatSanPham')->name('getThongKeXuatSanPham');
Route::post('thong-ke-xuat-san-pham', 'thongKeNhapXuatSanPhamController@searchThongKeXuatSanPham')->name('searchThongKeXuatSanPham');

Route::get('getChiTietThongKePhieuXuat', 'thongKeNhapXuatSanPhamController@getChiTietThongKePhieuXuat')->name('getChiTietThongKePhieuXuat');

Route::get('thong-ke-hoc-vien', 'thongKeHocVienController@getThongKeHocVien')->name('getThongKeHocVien');
Route::post('thong-ke-hoc-vien', 'thongKeHocVienController@searchThongKeHocVien')->name('searchThongKeHocVien');









Route::get('lich-ca-nhan', 'lichCaNhanController@getLichCaNhan')->name('getLichCaNhan');
Route::get('lich-ca-nhan-tuan', 'lichCaNhanController@getLichCaNhanTuan')->name('getLichCaNhanTuan');


Route::get('thong-tin-ca-nhan', 'thongTinController@getThongTinCaNhan')->name('getThongTinCaNhan');
Route::post('postCapNhatCaNhanh', 'thongTinController@postCapNhatCaNhanh')->name('postCapNhatCaNhanh');
Route::get('doi-mat-khau', 'thongTinController@getDoiMatKhau')->name('getDoiMatKhau');
Route::post('postCapNhatMatKhau', 'thongTinController@postCapNhatMatKhau')->name('postCapNhatMatKhau');



Route::get('teamwork', 'teamworkController@getTeam')->name('getTeam');
Route::post('postThemTeam', 'teamworkController@postThemTeam')->name('postThemTeam');
Route::post('postCapNhatTeam', 'teamworkController@postCapNhatTeam')->name('postCapNhatTeam');
Route::get('getXoaTeam', 'teamworkController@getXoaTeam')->name('getXoaTeam');
Route::get('searchTeam', 'teamworkController@searchTeam')->name('searchTeam');
Route::get('nhan-vien-teamwork', 'teamworkController@getNhanVienTeam')->name('getNhanVienTeam');
Route::post('postThemTeamNhanVien', 'teamworkController@postThemTeamNhanVien')->name('postThemTeamNhanVien');
Route::get('getXoaTeamNhanVien', 'teamworkController@getXoaTeamNhanVien')->name('getXoaTeamNhanVien');
Route::get('searchTeamNhanVien', 'teamworkController@searchTeamNhanVien')->name('searchTeamNhanVien');



Route::get('danh-sach-thong-bao', 'thongBaoController@getThongBao')->name('getThongBao');
Route::get('them-thong-bao', 'thongBaoController@getThemThongBao')->name('getThemThongBao');
Route::post('postThemThongBao', 'thongBaoController@postThemThongBao')->name('postThemThongBao');
Route::get('cap-nhat-thong-bao', 'thongBaoController@getCapNhatThongBao')->name('getCapNhatThongBao');
Route::post('postCapNhatThongBao', 'thongBaoController@postCapNhatThongBao')->name('postCapNhatThongBao');

Route::get('changeLoaiChiNhanhThongBao', 'thongBaoController@changeLoaiChiNhanhThongBao')->name('changeLoaiChiNhanhThongBao');


Route::get('getXoaThongBao', 'thongBaoController@getXoaThongBao')->name('getXoaThongBao');
Route::get('getDuLieuNguoiNhanThongBao', 'thongBaoController@getDuLieuNguoiNhanThongBao')->name('getDuLieuNguoiNhanThongBao');

Route::get('searchThongBao', 'thongBaoController@searchThongBao')->name('searchThongBao');
Route::get('getCapNhatTrangThaiThongBao', 'thongBaoController@getCapNhatTrangThaiThongBao')->name('getCapNhatTrangThaiThongBao');


Route::get('thong-bao', 'thongBaoController@getThongBaoCaNhan')->name('getThongBaoCaNhan');
Route::get('searchThongBaoCaNhan', 'thongBaoController@searchThongBaoCaNhan')->name('searchThongBaoCaNhan');


Route::get('cong-viec', 'nhiemVuController@getNhiemVu')->name('getNhiemVu');
Route::get('them-cong-viec', 'nhiemVuController@getThemCongViec')->name('getThemCongViec');
Route::get('changeChiNhanhCongViec', 'nhiemVuController@changeChiNhanhCongViec')->name('changeChiNhanhCongViec');
Route::post('postThemNhiemVu', 'nhiemVuController@postThemNhiemVu')->name('postThemNhiemVu');
Route::get('cap-nhat-cong-viec', 'nhiemVuController@getCapNhatNhiemVu')->name('getCapNhatNhiemVu');
Route::post('postCapNhatNhiemVu', 'nhiemVuController@postCapNhatNhiemVu')->name('postCapNhatNhiemVu');
Route::get('getXoaNhiemVu', 'nhiemVuController@getXoaNhiemVu')->name('getXoaNhiemVu');
Route::get('getChiTietNhiemVu', 'nhiemVuController@getChiTietNhiemVu')->name('getChiTietNhiemVu');
Route::get('searchNhiemVu', 'nhiemVuController@searchNhiemVu')->name('searchNhiemVu');
Route::get('cong-viec-ca-nhan', 'nhiemVuController@getNhiemVuCaNhan')->name('getNhiemVuCaNhan');

Route::get('getCapNhatTrangThaiNhiemVu', 'nhiemVuController@getCapNhatTrangThaiNhiemVu')->name('getCapNhatTrangThaiNhiemVu');




Route::get('cap-nhat-cong-viec-chinh', 'nhiemVuController@getCapNhatNhiemVuLeader')->name('getCapNhatNhiemVuLeader');
Route::post('postCapNhatNhiemVuLeader', 'nhiemVuController@postCapNhatNhiemVuLeader')->name('postCapNhatNhiemVuLeader');

Route::get('nhan-xet', 'nhanXetController@getNhanXet')->name('getNhanXet');

Route::post('postThemNhanXet', 'nhanXetController@postThemNhanXet')->name('postThemNhanXet');
Route::post('postCapNhatNhanXet', 'nhanXetController@postCapNhatNhanXet')->name('postCapNhatNhanXet');

Route::get('getXoaNhanXet', 'nhanXetController@getXoaNhanXet')->name('getXoaNhanXet');
Route::get('searchNhanXet', 'nhanXetController@searchNhanXet')->name('searchNhanXet');



Route::get('nhan-xet-chi-tiet', 'nhanXetController@getNhanXetChiTiet')->name('getNhanXetChiTiet');

Route::post('postThemNhanXetChiTiet', 'nhanXetController@postThemNhanXetChiTiet')->name('postThemNhanXetChiTiet');
Route::post('postCapNhatNhanXetChiTiet', 'nhanXetController@postCapNhatNhanXetChiTiet')->name('postCapNhatNhanXetChiTiet');
Route::get('getXoaNhanXetChiTiet', 'nhanXetController@getXoaNhanXetChiTiet')->name('getXoaNhanXetChiTiet');
Route::get('searchNhanXetChiTiet', 'nhanXetController@searchNhanXetChiTiet')->name('searchNhanXetChiTiet');



Route::get('ket-qua-nhan-xet', 'nhanXetController@getDiemSoNhanXet')->name('getDiemSoNhanXet');
Route::post('postThemNhanXetDiemSo', 'nhanXetController@postThemNhanXetDiemSo')->name('postThemNhanXetDiemSo');

Route::post('postCapNhatNhanXetDiemSo', 'nhanXetController@postCapNhatNhanXetDiemSo')->name('postCapNhatNhanXetDiemSo');
Route::get('getXoaNhanXetDiemSo', 'nhanXetController@getXoaNhanXetDiemSo')->name('getXoaNhanXetDiemSo');
Route::get('searchNhanXetDiemSo', 'nhanXetController@searchNhanXetDiemSo')->name('searchNhanXetDiemSo');






});