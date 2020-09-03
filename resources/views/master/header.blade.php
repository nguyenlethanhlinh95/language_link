<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>LANGUAGE LINK -DA NANG -TAM KY</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <!-- Custom Stylesheet -->
    <link href="{{asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
    <!-- Page plugins css -->
    <link href="{{asset('plugins/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="{{asset('plugins/jquery-asColorPicker-master/css/asColorPicker.css')}}" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="{{asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <!-- Daterange picker plugins css -->
    <link href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/select2.css')}}" rel="stylesheet">


    <link href="{{asset('plugins/sweetalert/css/sweetalert.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/toastr/css/toastr.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    @stack('styles')
</head>

<body>
    <style>

[data-sidebar-style="full"][data-layout="vertical"] .menu-toggle .nk-sidebar .metismenu > li.mega-menu > ul.collapse:not(.in) {
    height: auto !important;
}
.nav-header .brand-logo a {
    padding: 0.607rem 1.8125rem;
    display: block;
}

        .table td,
        .table th {
            border-color: black;
        }

        .table-bordered {
            border: 1px solid black;
        }

        [data-sibebarbg="color_1"] .nk-sidebar .metismenu {
            background-color: black !important;
        }

        .nk-nav-scroll {
            background-color: black !important;
        }

        .nk-sidebar {
            background-color: black !important;
        }

        [data-sibebarbg="color_1"] .nk-sidebar .metismenu>li {
            color:
                white !important;
        }

        .nk-sidebar .metismenu {
            color: white !important;
        }

        .itemL {
            color: white !important;
        }
        .nk-sidebar .metismenu > li a > i {
    color: white !important;
}
.itemLi{
    color: white !important;
    background-color: black !important;
}
[data-sibebarbg="color_1"] .nk-sidebar .metismenu > li ul a {
    color: white!important;
    background-color: black !important;
}



.nk-sidebar .metismenu a:hover, .nk-sidebar .metismenu a:active, .nk-sidebar .metismenu a.active {
    text-decoration: none;
    background-color: #F3F1FA!important;
    color: black!important;
}



[data-headerbg="color_1"] .header {
    background-color: green     !important;
}
[data-nav-headerbg="color_1"] .nav-header {
    background-color: #ffffff     !important;
    }
.header-right .icons > a {
    color: white!important;
}
.hamburger .toggle-icon {
    color: white!important;
}

table{
    text-align: center;
}

th{
    text-transform: uppercase;
}

    </style>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo" style="padding: auto">
                <a href="trang-chu">
                    <b class="logo-abbr"><img width="100%" src="{{ asset('images/favicon.png') }}" alt=""> </b>
                    <span class="logo-compact">< width="100%" img src="images/favicon.png" alt=""></span>
                    <span class="brand-title">
                        <img width="100%" src="{{ asset('images/logo-text-skytech.png') }}" alt="">
                    </span>
                </a>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content clearfix">

                <div class="nav-control" onclick="changeMenu();">
                    <div class="hamburger">
                        <span class="toggle-icon"><i id="iconClass" class="icon-menu"></i></span>
                    </div>
                </div>
                <script>
                    function changeMenu()
                    {
                        if($('#valueIcon').val()==0)
                        {
                            document.getElementById('iconClass').className="fa fa-chevron-right";
                            $('#valueIcon').val(1);
                        }
                        else
                        {
                            document.getElementById('iconClass').className="icon-menu";
                            $('#valueIcon').val(0);
                        }
                    }
                </script>
                <input hidden id="valueIcon" value="0">
                <div class="header-left">

                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <!-- <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <i class="mdi mdi-email-outline"></i>
                                <span class="badge gradient-1 badge-pill badge-primary">3</span>
                            </a>
                            <div class="drop-down animated fadeIn dropdown-menu">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="">3 New Messages</span>

                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/1.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Saiful Islam</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/2.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Adam Smith</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Can you do me a favour?</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/3.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Barak Obama</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/4.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Hilari Clinton</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Hello</div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </li>
                        <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="badge badge-pill gradient-2 badge-primary">3</span>
                            </a>
                            <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="">2 New Notifications</span>

                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Events near you</h6>
                                                    <span class="notification-text">Within next 5 days</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Event Started</h6>
                                                    <span class="notification-text">One hour ago</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Event Ended Successfully</h6>
                                                    <span class="notification-text">One hour ago</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Events to Join</h6>
                                                    <span class="notification-text">After two days</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </li> -->
                        <li class="icons dropdown d-none d-md-flex">
                            <a href="javascript:void(0)" class="log-user"  data-toggle="dropdown">
                                <a  href="{{ route('getNhiemVuCaNhan') }}?status=1"><span style="color: aqua">Công Việc Mới: {{ session('ViecCho') }}</span></a>
                            </a>

                        </li>
                        <li class="icons dropdown d-none d-md-flex">
                            <a href="javascript:void(0)" class="log-user"  data-toggle="dropdown">
                                <a  href="{{ route('getNhiemVuCaNhan') }}?status=2"> <span style="color:  orange">Công Việc Đang Thực Hiện: {{ session('ViecDangLam') }}</span>  </a>
                            </a>

                        </li>
                        <li class="icons dropdown d-none d-md-flex">
                            <a href="javascript:void(0)" class="log-user"  data-toggle="dropdown">
                                <a  href="{{ route('getNhiemVuCaNhan') }}?status=3">  <span style="color: red">Công Việc Trể: {{ session('viecTre') }}</span>  </a>
                            </a>

                        </li>
                        <li class="icons dropdown d-none d-md-flex">
                            <a href="javascript:void(0)" class="log-user"  data-toggle="dropdown">
                                <a  href="{{ route('getNhiemVuCaNhan') }}?status=4"><span>Công Việc Đã Hoàn Thành: {{ session('viecHT') }}</span>  </a>
                            </a>

                        </li>
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                @if (session('userLink')=="")
                                <img src="{{asset('images/'.session('userImg'))}}" height="40" width="40" alt="">
                                @else
                                    <img src="https://drive.google.com/uc?id={{session('userLink')}}" height="40" width="40" alt="">
                                @endif

                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="{{ route('getThongTinCaNhan') }}"><i class="icon-user"></i> <span>Profile</span></a>
                                        </li>
                                        <li>
                                            <a href="email-inbox.html"><i class="icon-envelope-open"></i> <span>Inbox</span>
                                                <div class="badge gradient-3 badge-pill badge-primary">3</div>
                                            </a>
                                        </li>

                                        <hr class="my-2">
                                        <li>
                                            <a href="{{ route('getDoiMatKhau') }}"><i class="icon-lock"></i> <span>Change password</span></a>
                                        </li>
                                        <li><a href="{{route('getLogout')}}"><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li>
                        <a class="itemL" href="{{route('getTrangChu')}}" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Trang Chủ</span>
                        </a>
                    </li>
                    @if(session('quyen22')==1 || session('quyen21')==1 || session('quyen31')==1
                    ||session('quyen101')==1||session('quyen111')==1)
                        <li class="mega-menu mega-menu-sm">
                            <a class="itemL" class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="fa  fa-mortar-board "></i><span class="nav-text">QUẢN LÝ HỌC VIÊN</span>
                            </a>
                            <ul aria-expanded="false">
                                @if(session('quyen22')==1)
                                <li><a class="itemLi" href="{{route('getGhiDanhHocVien')}}">Ghi danh học viên</a></li>
                                @endif
                                @if(session('quyen21')==1)
                                <li><a class="itemLi" href="{{route('getHocVien')}}">Học viên</a></li>
                                @endif
                                @if(session('quyen31')==1)
                                <li><a class="itemLi" href="{{route('getPhongVan')}}">PT</a></li>
                                @endif
                                @if(session('quyen101')==1)
                                <li><a class="itemLi" href="{{route('getChoMoLop')}}">Chờ mở lớp</a></li>
                                @endif

                                @if(session('quyen111')==1)
                                <li><a class="itemLi" href="{{route('getPhieuThu')}}">Phiếu thu</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(session('quyen41')==1 || session('quyen61')==1 ||session('quyen411')==1)
                    <li class="mega-menu mega-menu-sm">
                        <a class="itemL" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa  fa-book "></i><span class="nav-text">QUẢN LÝ ĐÀO TẠO</span>
                        </a>
                        <ul aria-expanded="false">
                            @if(session('quyen41')==1)
                            <li><a class="itemLi" href="{{route('getChuongTrinhHoc')}}">Chương trình học</a></li>
                            @endif
                            {{-- @if(session('quyen61')==1)
                            <li><a class="itemLi" href="{{route('getCapDoLopHoc')}}">Cấp độ</a></li>
                            @endif --}}
                            @if(session('quyen61')==1)
                        <li><a class="itemLi" href="{{route('getLopHoc')}}">Lớp học</a></li>
                            @endif
                            @if(session('quyen411')==1)
                            <li><a class="itemLi" href="{{route('getNhanXet')}}">Nhận xét</a></li>
                                @endif

                        </ul>
                    </li>
                    @endif
                    @if(session('quyen11')==1 )
                    <li class="mega-menu mega-menu-sm">
                        <a class="itemL"  href="{{route('getNhanSu')}}" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa  fa-book "></i><span class="nav-text">NHÂN SỰ</span>
                        </a>
                        {{-- <ul aria-expanded="false">

                            <li><a class="itemLi">Nhân sự</a></li>

                        </ul> --}}
                    </li>
                    @endif

                    @if(session('quyen4011')==1 ||session('quyen4051')==1 )
                    <li class="mega-menu mega-menu-sm">
                        <a class="itemL" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa  fa-calendar "></i><span class="nav-text">LỊCH LỚP HỌC</span>
                        </a>
                        <ul aria-expanded="false">
                            {{-- @if(session('quyen4011')==1)
                            <li><a class="itemLi" href="{{route('getXepLichLopHoc')}}">Lớp học</a></li>
                            @endif

                            @if(session('quyen4021')==1)
                            <li><a class="itemLi" href="{{route('getNhanVienLich')}}">Nhân viên</a></li>
                            @endif --}}
                            @if(session('quyen4011')==1)
                            <li><a class="itemLi" href="{{route('getLichChiNhanhChiTiet')}}">Schedule</a></li>
                            @endif
                            @if(session('quyen4051')==1)
                            <li><a class="itemLi" href="{{route('getGioLamVien')}}">Time sheet</a></li>
                            @endif
                        </ul>
                    </li>
                    {{-- <li class="mega-menu mega-menu-sm">
                        <a class="itemL" class="has-arrow" href="{{ route('getLichCaNhan') }}" aria-expanded="false">
                            <i class="fa  fa-calendar "></i><span class="nav-text">LỊCH DẠY</span>
                        </a>
                    </li> --}}
                    @endif

                    @if(session('quyen4211')==1 )

                    <li class="mega-menu mega-menu-sm">
                        <a class="itemL" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa  fa-calendar "></i><span class="nav-text">LỊCH LÀM VIỆC</span>
                        </a>
                        <ul aria-expanded="false">
                            @if(session('quyen4211')==1)
                            <li><a class="itemLi" href="{{route('getLichVanPhong')}}">Lịch văn phòng </a></li>
                            @endif
                            @if(session('quyen151')==1)
                            <li><a class="itemLi" href="{{route('getLichTongQuat')}}">Lịch tháng </a></li>
                            @endif


                        </ul>
                    </li>
                    @endif


                    @if(session('quyen151')==1 || session('quyen161')==1
                    ||session('quyen201')==1 || session('quyen171')==1
                    ||session('quyen191')==1 || session('quyen181')==1 )
                    <li class="mega-menu mega-menu-sm">
                        <a class="itemL" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-gear menu-icon"></i><span class="nav-text">VẬT PHẨM</span>
                        </a>
                        <ul aria-expanded="false">
                            @if(session('quyen151')==1)
                            <li><a class="itemLi" href="{{route('getLoaiCoSoVatChat')}}">Các loại vật phẩm </a></li>
                            @endif
                            @if(session('quyen161')==1)
                                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Vật phẩm</a>
                                    <ul aria-expanded="false">
                                        @foreach(session('loaiVatPham') as $item)
                                        <li><a class="itemLi" href="{{route('getCoSoVatChat')}}?id={{$item['id']}}">{{$item['ten']}}</a></li>
                                        @endforeach

                                    </ul>
                                </li>
                            @endif
                            @if(session('quyen201')==1)
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Vật phẩm chi nhánh</a>
                                <ul aria-expanded="false">
                                    @foreach(session('loaiVatPham') as $item)
                                <li><a href="{{route('getVatPhamChiNhanh')}}?id={{$item['id']}}">{{$item['ten']}}</a></li>
                                    @endforeach

                                </ul>
                            </li>
                            @endif
                            @if(session('quyen171')==1)
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Số lượng tồn</a>
                                <ul aria-expanded="false">
                                    @foreach(session('loaiVatPham') as $item)
                                <li><a href="{{route('getTonKho')}}?id={{$item['id']}}">{{$item['ten']}}</a></li>
                                    @endforeach

                                </ul>
                            </li>
                            @endif

                            @if(session('quyen191')==1)
                            <li><a class="itemLi" href="{{route('getPhieuNhap')}}">Nhập kho</a></li>
                            @endif
                            @if(session('quyen181')==1)
                            <li><a class="itemLi" href="{{route('getXuatKho')}}">Xuất kho</a></li>
                            @endif


                        </ul>
                    </li>
                    @endif
                    @if(session('quyen211')==1 || session('quyen221')==1
                    ||session('quyen231')==1 || session('quyen241')==1
                    ||session('quyen251')==1 )
                    <li class="mega-menu mega-menu-sm">
                        <a class="itemL" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-gear menu-icon"></i><span class="nav-text">CƠ SỞ VẬT CHẤT</span>
                        </a>
                        <ul aria-expanded="false">
                            @if(session('quyen211')==1)
                            <li><a class="itemLi" href="{{route('getVatPham')}}">Cơ sở vật chất </a></li>
                            @endif
                            @if(session('quyen221')==1)
                            <li><a class="itemLi" href="{{route('getChiNhanhVatPham')}}">CSVC chi nhánh</a></li>
                            @endif
                            @if(session('quyen231')==1)
                            <li><a class="itemLi" href="{{route('getTonKhoVatPham')}}">Tồn kho </a></li>
                            @endif
                            @if(session('quyen241')==1)
                            <li><a class="itemLi" href="{{route('getPhieuNhapVatPham')}}">Nhập kho </a></li>
                            @endif
                            @if(session('quyen251')==1)
                            <li><a class="itemLi" href="{{route('getXuatVatPham')}}">Xuất kho </a></li>
                            @endif


                        </ul>
                    </li>
                    @endif
                    @if(session('quyen261')==1 )
                    <li class="mega-menu mega-menu-sm">
                        <a class="itemL"  href="{{route('getXuatKhoMarketing')}}" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa  fa-book "></i><span class="nav-text">MARKETING</span>
                        </a>
                        {{-- <ul aria-expanded="false">

                            <li><a class="itemLi">Nhân sự</a></li>

                        </ul> --}}
                    </li>
                    @endif
                    <li class="mega-menu mega-menu-sm">
                        <a class="itemL" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa  fa-book"></i><span class="nav-text">PHIẾU CHI</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a class="itemLi" href="{{route('payment.index')}}">Danh sách</a></li>
                            <li><a class="itemLi" href="{{route('payment.create')}}">Thêm mới</a></li>
                        </ul>
                        {{--<a class="itemL"  href="{{ route('payment.index') }}" class="has-arrow" href="javascript:void()" aria-expanded="false">--}}
                            {{--<i class="fa  fa-book "></i><span class="nav-text">Phiếu chi</span>--}}
                        {{--</a>--}}
                    </li>
                    @if(session('quyen7001')==1 || session('quyen7011')==1
                    ||session('quyen7021')==1 || session('quyen7031')==1
                    ||session('quyen7041')==1 ||session('quyen7051')==1)
                    <li class="mega-menu mega-menu-sm">
                        <a class="itemL" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa  fa-calendar "></i><span class="nav-text">THỐNG KÊ</span>
                        </a>
                        <ul aria-expanded="false">
                            @if(session('quyen7001')==1)
                            <li><a class="itemLi" href="{{route('getThongKeThuChi')}}">Tổng quát</a></li>
                            @endif
                            @if(session('quyen7011')==1)
                            <li><a class="itemLi" href="{{route('getThongKeThu')}}">Doanh Thu</a></li>
                            @endif
                            @if(session('quyen7021')==1)
                            <li><a class="itemLi" href="{{route('getThongKeChi')}}">Chi phí</a></li>
                            @endif
                            @if(session('quyen7031')==1)
                            <li><a class="itemLi" href="{{route('getNhapSanPham')}}">Nhập vật phẩm</a></li>
                            @endif
                            @if(session('quyen7041')==1)
                            <li><a class="itemLi" href="{{route('getThongKeXuatSanPham')}}">Xuất vật phẩm</a></li>
                            @endif
                            @if(session('quyen7051')==1)
                            <li><a class="itemLi" href="{{route('getThongKeHocVien')}}">Học Viên</a></li>
                            @endif

                        </ul>
                    </li>
                    @endif
                    @if(session('quyen501')==1)
                    <li class="mega-menu mega-menu-sm">
                        <a class="itemL" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa   fa-bullhorn "></i><span class="nav-text">THÔNG BÁO</span>
                        </a>
                        <ul aria-expanded="false">

                            <li><a class="itemLi" href="{{route('getThongBao')}}">DS thông báo</a></li>

                            <li><a class="itemLi" href="{{route('getThongBaoCaNhan')}}">Thông báo</a></li>
                        </ul>
                    </li>
                    @else
                    <li class="mega-menu mega-menu-sm">
                        <a class="itemL" href="{{route('getThongBaoCaNhan')}}" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa   fa-bullhorn "></i><span class="nav-text">THÔNG BÁO</span>
                        </a>
                    </li>
                    @endif
                    @if(session('quyen301')==1 || session('quyen311')==1
                    ||session('quyen321')==1 || session('quyen331')==1
                    ||session('quyen351')==1 ||session('quyen361')==1
                    ||session('quyen901')==1||session('quyen9021')==1)
                    <li class="mega-menu mega-menu-sm">
                        <a class="itemL" class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-gear menu-icon"></i><span class="nav-text">CÀI ĐẶT</span>
                        </a>
                        <ul aria-expanded="false">
                            @if(session('quyen301')==1)
                            <li><a class="itemLi" href="{{route('getMarketing')}}">Marketing</a></li>
                            @endif

                            @if(session('quyen311')==1)
                            <li><a class="itemLi" href="{{route('getChuongTrinhKM')}}">Chương Trình KM</a></li>
                            @endif
                            @if(session('quyen321')==1)
                            <li><a class="itemLi" href="{{route('getNgayLe')}}">Ngày lễ</a></li>
                            @endif
                            @if(session('quyen331')==1)
                            <li><a class="itemLi" href="{{route('getChiNhanh')}}">Chi nhánh</a></li>
                            @endif

                            @if(session('quyen351')==1)
                            <li><a class="itemLi" href="{{route('getChucVu')}}">Chức vụ</a></li>
                            @endif
                            @if(session('quyen381')==1)
                            <li><a class="itemLi" href="{{route('getPhongBan')}}">Phòng ban</a></li>
                            @endif
                            @if(session('quyen391')==1)
                            <li><a class="itemLi" href="{{route('getKhungGio')}}">Khung giờ</a></li>
                            @endif
                            @if(session('quyen401')==1)
                            <li><a class="itemLi" href="{{route('getNghiPhep')}}">Nghỉ phép</a></li>
                            @endif
                            @if(session('quyen511')==1)
                            <li><a class="itemLi" href="{{route('getNhiemVu')}}">Công việc</a></li>
                            @endif


                            @if(session('quyen361')==1)
                            <li><a class="itemLi" href="{{route('getTeam')}}">Teamwork</a></li>
                            @endif

                            @if(session('quyen901')==1||session('quyen9021')==1)
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Quyền Hạn</a>
                                <ul aria-expanded="false">
                                    @if(session('quyen901')==1)
                                    <li><a class="itemLi" href="{{route('getNhomQuyen')}}">Nhóm quyền</a></li>
                                    @endif
                                    @if(session('quyen9021')==1)
                                    <li><a class="itemLi" href="{{route('getQuyenGiaoVien')}}">Quyền nhân viên</a></li>
                                    @endif
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
