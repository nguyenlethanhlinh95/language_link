<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>LANGUAGE LINK</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="css/style.css" rel="stylesheet">
    <link href="{{asset('plugins/toastr/css/toastr.min.css')}}" rel="stylesheet">
</head>

<body class="h-100">

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




    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="index.html">
                                    <h4>Login</h4>
                                </a>

                                <form class="mt-5 mb-5 login-input" id="myform1" 
                                action="{{ route('postLogin')}}" 
                                enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input type="text" name="userName" class="form-control" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                    <button class="btn login-form__btn submit w-100">Sign In</button>
                                </form>
                                <!-- <p class="mt-5 login-form__footer">Dont have account? <a href="page-register.html" class="text-primary">Sign Up</a> now</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{asset('plugins/common/common.min.js')}}"></script>
    <script src="{{asset('js/custom.min.js')}}"></script>
    <script src="{{asset('js/settings.js')}}"></script>
    <script src="{{asset('js/gleek.js')}}"></script>
    <script src="{{asset('js/styleSwitcher.js')}}"></script>
    <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
    <script src="{{asset('plugins/toastr/js/toastr.min.js')}}"></script>
    <script src="{{asset('plugins/toastr/js/toastr.init.js')}}"></script>
    <script>
//          $('#myform1').submit(function() {

// $.ajax({
//     type: 'Post',
//     url: '{{ route("postLogin")}}',
//     data: new FormData(this),
//     contentType: false,
//     cache: false,
//     processData: false,
//     success: function(data) {
//         if (data == 1) {
//             dangNhapThanhCong();
//             window.location = "{{route('getTrangChu')}}";
//         } else
//         if (data == 2) {
//             kiemTra();
//         } else
//             dangNhapThatBai();
//         //  alert(data);
//     }
// });
// return false;
// });
        window.onload = function(e){ 
        
            e.preventDefault();
 
            // Nếu trình duyệt không hỗ trợ thông báo
            if (!window.Notification)
            {
                alert('Trình duyệt của bạn không hỗ trợ chức năng này.');
            }
            else
            {
                // Gửi lời mời cho phép thông báo
                Notification.requestPermission(function (p) {
                    // Nếu không cho phép
                    if (p === 'denied')
                    {
                       // alert('Bạn đã không cho phép thông báo trên trình duyệt.');
                    }
                    // Ngược lại cho phép
                    else
                    {
                       
                    }
                });
            }




          if({{$sms}}==0)
          dangNhapThatBai();
          else
          if({{$sms}}==2)
          kiemTra();
        }

        function dangNhapThanhCong() {
            toastr.success("Đăng nhập thành công!!!", "Đăng nhập", {
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                positionClass: "toast-top-right",
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            })
        }

        function dangNhapThatBai() {
            toastr.error("Tài khoản hoặc mật khẩu không chính xác!!!", "Đăng nhập", {
                positionClass: "toast-top-right",
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            });
        }

        function kiemTra() {
            toastr.warning("Tài khoản hiện tại bị khóa.", "Đăng nhập", {
                positionClass: "toast-top-right",
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            })
        }
    </script>
</body>

</html>