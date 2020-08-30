<?php

namespace App\Http\Controllers;

use App\Model\Marketing;
use App\Model\Student;
use App\Services\BranchService;
use App\Services\MarketingService;
use App\Services\StudentService;
use Carbon\Carbon;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class khachHangController extends Controller
{
    /**
     * @var $studentService
     * @var $branchService
     */
    protected $studentService;
    protected $branchService;
    protected $marketingService;
    /**
     * @param StudentService            $studentService         StudentService
     * @param BranchService             $branchService          BranchService
     * @param MarketingService          $marketingService       MarketingService
     */
    public function __construct(StudentService $studentService, BranchService $branchService, MarketingService $marketingService)
    {
        $this->studentService = $studentService;
        $this->branchService = $branchService;
        $this->marketingService = $marketingService;
    }

    /**
     * Show list Student
     *
     * @return View
     */
    public function getHocVien(Request $request)
    {
        try {
            $quyen = new quyenController();
            $quyenXemKH = $quyen->getXemKhachHang();
            if ($quyenXemKH == 1) {
                $lay = $quyen->layDuLieu();
                $hocVien = $this->studentService->getTakeStudent($lay);
                $soHocVien = $this->studentService->getTotalStudent();
                $soTrang = (int) $soHocVien / $lay;
                if ($soHocVien % $lay > 0)
                    $soTrang++;
                $data = [
                    'hocVien' => $hocVien,
                    'soTrang' => $soTrang,
                    'page' => 1,
                    'branchName' => $this->branchService->getBranchNameFromUserLogin(),
                    'isAdmin'   => isAdmin()
                ];
                return view('KhachHang.khachHang', $data);
            } else
                return redirect()->back();
        } catch (\Exception $exception)
        {
            return redirect()->back();
        }
    }

    /**
     * Show Form Register Student
     *
     * @return View
     */
    public function getThemHocVien()
    {
        try {
            $quyen = new quyenController();
            $quyenThemKH = $quyen->getThemKhachHang();
            $user = getUserLogin();
            if ($quyenThemKH == 1) {
                $marketing = $this->marketingService->getAllMarketingByStatus($status=1);
                $data = [
                    'marketing' => $marketing,
                    'user'      => $user,
                    'branch'    => $this->branchService->getBranchNameFromUserLogin()
                ];
                return view('KhachHang.themKhachHang', $data);
            } else
                return redirect()->back();
        } catch (\Exception $exception)
        {
            abort(404);
        }
    }

    /**
     * Show Form Edit Student
     *
     * @return View
     */
    public function getCapNhatHocVien(Request $request)
    {
        try {
            $quyen = new quyenController();
            $quyenSuaKH = $quyen->getSuaKhachHang();
            if ($quyenSuaKH == 1) {
                $id = $request->get('id');
                $hocVien = $this->studentService->findStudentById($id);
                $marketings = $this->studentService->getAllMarketingByStudentId($id);
                $marketing = $this->marketingService->getAllMarketingByStatus($status=1);
                $data = [
                    'hocVien'               => $hocVien,
                    'khachHangMarketTing'   => $marketings,
                    'marketing'             => $marketing,
                    'branch'                => $this->branchService->getBranchNameFromUserLogin()
                ];
                return view('KhachHang.capNhatKhachHang',$data);
            } else
                return redirect()->back();
        } catch (\Exception $exception)
        {
            dd($exception->getMessage());
//            abort(404);
        }
    }
    function convert_vi_to_en($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
        return $str;
    }
    public function postThemHocVien(Request $request)
    {
        if ($request->ajax()) {
            $user = getUserLogin();
            $quyen = new quyenController();
            $quyenThemKH = $quyen->getThemKhachHang();
            if ($quyenThemKH == 1) {
                $sdtPH = "";
                $tenPH = "";
                $sdt = "";
                $link ="";
                $ho = $request->get('firtName');
                $ten = $request->get('lastName');
                $tenPH = $request->get('parentName');
                $sdtPH = $request->get('parentPhone');
                $email = $request->get('mail');
                $diaChi = $request->get('address');
                $sdt = $request->get('phone');
                $ngaySinh = $request->get('birthday');
                $nickname = $request->get('nickname');
                $link = $request->get('link');
                $trangThai = $request->get('trangThai');
                if($nickname=="")
                    $nickname="";
                if($email=="")
                    $email="";

                if($sdtPH=="")
                    $sdtPH = "";
                if($tenPH=="")
                    $tenPH = "";
                if($sdt=="")
                    $sdt = "";

                $now = Carbon::now('Asia/Ho_Chi_Minh');
                $tenKoDau = $this->convert_vi_to_en($ten);
                if ($sdt != "" || $sdtPH != "") {
                    $profileImage = "";
                    if ($files = $request->file('images')) {
                        $destinationPath = public_path('images');
                        $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                        $files->move($destinationPath, $profileImage);
                    }
                    $ngay = substr($ngaySinh, 3, 2);
                    $thang = substr($ngaySinh, 0, 2);
                    $nam = substr($ngaySinh, 6, 4);
                    $ngaySinhChinh = $nam . "-" . $thang . "-" . $ngay;

                    try {
                        $id = DB::table('st_student')
                            ->insertGetId([
                                'student_firstName' => $ho,
                                'student_lastName' => $ten,
                                'student_lastNameHidden' => $tenKoDau,
                                'student_parentName' => $tenPH,
                                'student_birthDay' => $ngaySinhChinh,
                                'student_parentPhone' => $sdtPH,
                                'student_phone' => $sdt,
                                'student_email' => $email,
                                'student_address' => $diaChi,
                                'student_img' => $profileImage,
                                'student_status' => $trangThai,
                                'student_dateTime' => $now,
                                'employee_id' => session('user'),
                                'student_nickName'=>$nickname,
                                'branch_id'=>$user['branch_id'],
                                'student_link'=>$link,
                                'student_surplus'=>0
                            ]);
                        $marketing = DB::table('st_marketing')
                            ->get();
                        foreach ($marketing as $item) {
                            $key = "marketing" . $item->marketing_id;
                            if ($request->get($key) == true) {
                                DB::table('st_student_marketing')
                                    ->insert([
                                        'student_id' => $id,
                                        'marketing_id' => $item->marketing_id
                                    ]);
                            }
                        }
                        $arr[] = [
                            'id' => $id,
                            'loai' => 1
                        ];
                        return response($arr);
                    } catch (QueryException $ex) {
                        $arr[] = [
                            'id' => 0,
                            'loai' => 0
                        ];
                        return response($arr);
                    }
                } else {
                    $arr[] = [
                        'id' => 3,
                        'loai' => 3
                    ];
                    return response($arr);
                }
            } else {
                $arr[] = [
                    'id' => 2,
                    'loai' => 2
                ];
                return response($arr);
            }
        }
    }
    public function postCapNhatHocVien(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenSuaKH = $quyen->getSuaKhachHang();
            if ($quyenSuaKH == 1) {

                $id = $request->get('id');
                $ho = $request->get('firtName');
                $ten = $request->get('lastName');
                $tenPH = $request->get('parentName');
                $sdtPH = $request->get('parentPhone');
                $email = $request->get('mail');
                $diaChi = $request->get('address');
                $sdt = $request->get('sdt');
                $ngaySinh = $request->get('birthday');
                $link = $request->get('link');
                $trangThai = $request->get('trangThai');
                $nickname = $request->get('nickname');
                if($nickname=="")
                    $nickname="";
                if($email=="")
                    $email="";

                if($sdtPH=="")
                    $sdtPH = "";
                if($tenPH=="")
                    $tenPH = "";
                if($sdt=="")
                    $sdt = "";
                $tenKoDau = $this->convert_vi_to_en($ten);
                if ($sdt != "" || $sdtPH != "") {
                    $profileImage = "";
                    if ($files = $request->file('images')) {
                        $destinationPath = public_path('images');
                        $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                        $files->move($destinationPath, $profileImage);
                    }
                    $ngay = substr($ngaySinh, 3, 2);
                    $thang = substr($ngaySinh, 0, 2);
                    $nam = substr($ngaySinh, 6, 4);
                    $ngaySinhChinh = $nam . "-" . $thang . "-" . $ngay;

                    $hocVien =  DB::table('st_student')
                        ->where('student_id', $id)
                        ->get()
                        ->first();
                    if ($hocVien->student_img != "") {
                        if (file_exists(public_path('images/' . $hocVien->student_img))) {
                            unlink(public_path('images/' . $hocVien->student_img));
                        }
                    }
                    try {
                        DB::table('st_student')
                            ->where('student_id', $id)
                            ->update([
                                'student_firstName' => $ho,
                                'student_lastName' => $ten,
                                'student_lastNameHidden' => $tenKoDau,
                                'student_parentName' => $tenPH,
                                'student_birthDay' => $ngaySinhChinh,
                                'student_parentPhone' => $sdtPH,
                                'student_phone' => $sdt,
                                'student_email' => $email,
                                'student_address' => $diaChi,
                                'student_img' => $profileImage,
                                'student_status' => $trangThai,
                                'student_nickName'=>$nickname,
                                'student_link'=>$link
                            ]);
                        $marketing = DB::table('st_marketing')
                            ->get();
                        DB::table('st_student_marketing')
                            ->where('student_id', $id)
                            ->delete();
                        foreach ($marketing as $item) {
                            $key = "marketing" . $item->marketing_id;
                            if ($request->get($key) == true) {
                                DB::table('st_student_marketing')
                                    ->insert([
                                        'student_id' => $id,
                                        'marketing_id' => $item->marketing_id
                                    ]);
                            }
                        }
                        return response(1);
                    } catch (QueryException $ex) {
                        return response(0);
                    }
                } else {
                    return response(3);
                }
            } else
                return response(2);
        }
    }
    public function getXoaHocVien(Request $request)
    {
        if ($request->ajax()) {
            $quyen = new quyenController();
            $quyenSuaKH = $quyen->getSuaKhachHang();
            if ($quyenSuaKH == 1) {

                $id = $request->get('id');
                // check if supper admin not delete
                if (isAdmin()) {
                    return 0;
                }
                try {
                    DB::table('st_student')
                        ->where('student_id', $id)
                        ->delete();

                    return response(1);
                } catch (QueryException $ex) {
                    return response(0);
                }
            } else
                return response(2);
        }
    }

    public function searchHocVien(Request $request)
    {
        try {
            $params = $request->all();
            $quyen = new quyenController();
            $students = $this->studentService->searchStudentView($params);
            $data = [
                'hocVien' => $students,
                'branchName' => $this->branchService->getBranchNameFromUserLogin(),
                'keyword' => $params['search_by_name']
            ];
            return view('KhachHang.search_student_by_result', $data);
        } catch (\Exception $exception)
        {
            abort(404);
        }

    }
    public function getThongTinGhiDanh(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->get('id');
            $hocVien = DB::table('st_student')
                ->where('student_id', $id)
                ->get();

            if (count($hocVien) > 0) {
                $out = "";
                $i = 1;

                foreach ($hocVien as $item) {

                    $out .= '<tr>
                        <td>' . $i . '</td>
                        <td><a href=\'' . route('getChiTietHocVien') . '?id=' . $item->student_id . '\'>' . $item->student_firstName . ' ' . $item->student_lastName . '</a></td>
                        <td>' . date('d/m/Y', strtotime($item->student_birthDay)) . '</td>
                        <td>' . $item->student_parentName . '</td>
                        <td>' . $item->student_parentPhone . '</td>
                        <td>' . $item->student_phone . '</td>
                        <td>' . $item->student_address . '</td>';
                    if (session('quyen32') == 1) {
                        $out .= '  <td>
                            <a class="btn" href=\'' . route('getThemPhongVan') . '?id=' . $item->student_id . '\'>
                                    <i style="color: blue" class="fa fa-pencil"></i>
                                </a>
                            </td>     ';
                    }


                    $out .= ' </tr>';
                    $i++;
                }

                return response($out);
            } else {
                return response(2);
            }
        }
    }
    public function searchHocVienGhiDanh(Request $request)
    {
        if ($request->ajax()) {


            $value = $request->get('value');

            if ($value == "") {

                return response(1);
            } else {
                $hocVien = DB::table('st_student')
                    ->where('student_firstName', 'like', '%' . $value . '%')
                    ->orwhere('student_lastName', 'like', '%' . $value . '%')
                    ->orwhere('student_lastNameHidden', 'like', '%' . $value . '%')
                    ->orwhere('student_phone', 'like', '%' . $value . '%')
                    ->orwhere('student_parentPhone', 'like', '%' . $value . '%')
                    ->orderByDesc('student_dateTime')
                    ->get();

                if (count($hocVien) > 0) {
                    $out = "";
                    $i = 1;

                    foreach ($hocVien as $item) {

                        $out .= '<tr>
                        <td>' . $i . '</td>
                        <td><a href=\'' . route('getChiTietHocVien') . '?id=' . $item->student_id . '\'>' . $item->student_firstName . ' ' . $item->student_lastName . '</a></td>
                        <td>' . date('d/m/Y', strtotime($item->student_birthDay)) . '</td>
                        <td>' . $item->student_parentName . '</td>
                        <td>' . $item->student_parentPhone . '</td>
                        <td>' . $item->student_phone . '</td>
                        <td>' . $item->student_address . '</td>';
                        if (session('quyen32') == 1) {
                            $out .= '  <td>
                            <a class="btn" href=\'' . route('getThemPhongVan') . '?id=' . $item->student_id . '\'>
                                    <i style="color: blue" class="fa fa-pencil"></i>
                                </a>
                            </td>     ';
                        }


                        $out .= ' </tr>';
                        $i++;
                    }

                    return response($out);
                } else {

                    return response(2);
                }
            }
        }
    }

    public function getChiTietHocVien(Request $request)
    {
        $quyen = new quyenController();
        $quyenXemKH = $quyen->getXemKhachHang();
        if ($quyenXemKH == 1) {
            $id = $request->get('id');

            $hocVien = DB::table('st_student')
                ->where('student_id', $id)
                ->get()->first();
            $khachHangMarketTing = DB::table('st_student_marketing')
                ->where('student_id', $id)
                ->get();
            $marketing = DB::table('st_marketing')
                ->get();
            $phongVan = DB::table('view_phong_van')
                ->where('student_id', $id)
                ->orderByDesc('placementTest_dateTime')
                ->get();
            $chiNhanh = DB::table('st_branch')
                ->where('branch_id',$hocVien->branch_id)
                ->get()->first();
            $maHocVien="";
            if(isset($chiNhanh))
            {
                $maHocVien=$chiNhanh->branch_code."_".$hocVien->student_id;
            }

            $khoaHoc = DB::table('st_course')
                ->join('st_receipt_detail','st_receipt_detail.course_id','=',
                    'st_course.course_id')
                ->join('st_receipt','st_receipt.receipt_id','=',
                    'st_receipt_detail.receipt_id')
                ->join('st_branch','st_branch.branch_id','=','st_receipt.branch_id')
                ->join('st_study_program','st_study_program.studyProgram_id','=',
                    'st_course.studyProgram_id')
                ->where('st_receipt.student_id',$id)
                ->get();

            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $arrKhoahoc=[];
            foreach($khoaHoc as $item)
            {
                if($item->class_id>0)
                {
                    $lopHoc = DB::table('view_class')
                        ->where('class_id',$item->class_id)
                        ->get()->first();

                    if(isset($lopHoc))
                    {
                        $chiNhanh = DB::table('st_branch')
                            ->where('branch_id',$item->branch_id)
                            ->get()->first();

                        if(isset($chiNhanh))
                        {
                            $maChiNhanh = $chiNhanh->branch_code;
                        }
                        else
                        {
                            $maChiNhanh="";
                        }
                        $tenKhoaHoc =  $maChiNhanh."_".$item->studyProgram_code."_".$item->course_name."_".$lopHoc->class_code;

                        $ngayBatDau = date('d/m/Y',strtotime($lopHoc->class_startDay)) ;
                        $ngayKetThuc = date('d/m/Y',strtotime($lopHoc->class_endDay)) ;

                        if($lopHoc->class_status==0)
                            $trangThai = "Canceled";
                        else
                        {
                            if($now < $lopHoc->class_startDay)
                                $trangThai="Waiting";
                            else if( $now >= $lopHoc->class_startDay && $now <= $lopHoc->class_endDay)
                                $trangThai="Opening";
                            else
                                $trangThai="Finished";
                        }
                    }
                    else
                    {
                        $tenKhoaHoc=$item->branch_id."_".$item->studyProgram_code."_".$item->course_name;
                        $ngayBatDau = "" ;
                        $ngayKetThuc ="";

                        $trangThai = "Waiting";
                    }

                }
                else
                {
                    $tenKhoaHoc=$item->branch_code."_".$item->studyProgram_code."_".$item->course_name;
                    $ngayBatDau = "" ;
                    $ngayKetThuc ="";
                    $trangThai = "Waiting";
                }
                $hocPhi= "Đã đóng";
                $arrKhoahoc[]=[
                    'tenKhoaHoc'=>$tenKhoaHoc,
                    'ngayBatDau'=>$ngayBatDau,
                    'ngayKetThuc'=>$ngayKetThuc,
                    'trangThai'=>$trangThai,
                    'hocPhi'=>$hocPhi
                ];
            }

            return view('KhachHang.chiTietKhachHang')
                ->with('hocVien', $hocVien)
                ->with('marketing', $marketing)
                ->with('khoaHoc', $arrKhoahoc)
                ->with('phongVan', $phongVan)
                ->with('maHocVien', $maHocVien)
                ->with('khachHangMarketTing', $khachHangMarketTing);
        } else
            return redirect()->back();
    }
    public function getGhiDanhHocVien(Request $request)
    {
        $quyen = new quyenController();
        $quyenThemKH = $quyen->getThemKhachHang();
        if ($quyenThemKH == 1) {
            $marketing = DB::table('st_marketing')
                ->get();
            return view('KhachHang.ghiDanh')
                ->with('marketing', $marketing);
        } else
            return redirect()->back();
    }
}
