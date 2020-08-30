<div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by <a href="http://skytechkey.com/">Skytech Key</a> 2020</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
    

    <script src="./plugins/moment/moment.js"></script>
    
    <script src="./plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="./plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="./plugins/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
    <script src="./plugins/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
    <script src="./plugins/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="./plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="./plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="./plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="./plugins/toastr/js/toastr.min.js"></script>
    <script src="./plugins/toastr/js/toastr.init.js"></script>
    <script src="{{asset('plugins/sweetalert/js/sweetalert.min.js')}}"></script>
    {{-- <script src="{{asset('plugins/sweetalert/js/sweetalert.init.js')}}"></script> --}}


    <script src="./js/plugins-init/form-pickers-init.js"></script>

    <script src="./plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="./plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="./plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
    @stack('scripts')

    <script>
       
        function thongBaoTruocGio()
        {
          @php $thongBao = session()->get('thongBao');  $i=1;@endphp
          @foreach($thongBao as $item)
                var countDownDate{{ $i }} = new Date("{{ $item['thoiGian'] }}").getTime();
                var x{{ $i }} = setInterval(function() {
                var now{{ $i }} = new Date().getTime();
                var distance{{ $i }} = countDownDate{{ $i }} - now{{ $i }};
                var days{{ $i }} = Math.floor(distance{{ $i }} / (1000 * 60 * 60 * 24));
                var hours{{ $i }} = Math.floor((distance{{ $i }} % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes{{ $i }} = Math.floor((distance{{ $i }} % (1000 * 60 * 60)) / (1000 * 60));
                var seconds{{ $i }} = Math.floor((distance{{ $i }} % (1000 * 60)) / 1000);
              
                if (distance{{ $i }} < 0) {
                    clearInterval(x{{ $i }});
                    hienThiThongBao('{{ $item['ten'] }}','{{ $item['chiNhanh'] }}','{{ $item['id'] }}');
                }
                }, 1000);
                @php  $i++;@endphp
            @endforeach
        }
       function hienThiThongBao(vaLue,chiNhanh,id)
       {
        $.ajax({
            type: 'get',
            url: '{{ route("getCapNhatTrangThaiThongBao")}}',
            data: {
               'id':id
            },
            success: function(data) {
               
            }
        });
            var notify;
          
            if (Notification.permission == 'default')
            {
               // alert('Bạn phải cho phép thông báo trên trình duyệt mới có thể hiển thị nó.');
            }
            // Ngược lại đã cho phép
            else
            {
                // Tạo thông báo
                notify = new Notification(
                        'Bạn có một thông báo mới từ '+chiNhanh, // Tiêu đề thông báo
                        {
                            body: vaLue+'.', // Nội dung thông báo
                            icon: '{{ asset('images/logoLanguageLink.png') }}', // Hình ảnh
                            tag: '{{ route('getThongBao') }}' // Đường dẫn 
                        }
                );
                // Thực hiện khi nhấp vào thông báo
                notify.onclick = function () {
                    window.location.href = this.tag; // Di chuyển đến trang cho url = tag
                }
        }
       }
        window.onload = function(e){ 

           ketQuaBaiGiang();
          // thongBaoNhiemVu();
            thongBaoTruocGio();
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
                        //alert('Bạn đã không cho phép thông báo trên trình duyệt.');
                    }
                    // Ngược lại cho phép
                    else
                    {
                    
                    }
                });
            }
        }
         function ThemThanhCong($title,$sms){
        toastr.success($sms,$title,{
            timeOut:5e3,
            closeButton:!0,
            debug:!1,
            newestOnTop:!0,
            progressBar:!0,
            positionClass:"toast-top-right",
            preventDuplicates:!0,
            onclick:null,
            showDuration:"300",
            hideDuration:"1000",
            extendedTimeOut:"1000",
            showEasing:"swing",
            hideEasing:"linear",
            showMethod:"fadeIn",
            hideMethod:"fadeOut",
            tapToDismiss:!1
        })}

   function CapNhatThanhCong($title,$sms){
        toastr.info($sms,$title,
            {
                positionClass:"toast-top-right",
                timeOut:5e3,
                closeButton:!0,
                debug:!1,
                newestOnTop:!0,
                progressBar:!0,
                preventDuplicates:!0,
                onclick:null,
                showDuration:"300",
                hideDuration:"1000",
                extendedTimeOut:"1000",
                showEasing:"swing"
                ,hideEasing:"linear",
                showMethod:"fadeIn",
                hideMethod:"fadeOut",
                tapToDismiss:!1
            })
    }
    function PhatHienLoi($title,$sms){
        toastr.error($sms,$title,
            {
                positionClass:"toast-top-right",
                timeOut:5e3,
                closeButton:!0,
                debug:!1,
                newestOnTop:!0,
                progressBar:!0,
                preventDuplicates:!0,
                onclick:null,
                showDuration:"300",
                hideDuration:"1000",
                extendedTimeOut:"1000",
                showEasing:"swing"
                ,hideEasing:"linear",
                showMethod:"fadeIn",
                hideMethod:"fadeOut",
                tapToDismiss:!1
            })
    }
    function KiemTra($title,$sms){
        toastr.warning($sms,$title,
        {positionClass:"toast-top-right",timeOut:5e3,closeButton:!0,debug:!1
            ,newestOnTop:!0,progressBar:!0,preventDuplicates:!0,onclick:null,
            showDuration:"300",hideDuration:"1000",extendedTimeOut:"1000",
            showEasing:"swing",hideEasing:"linear",showMethod:"fadeIn",
            hideMethod:"fadeOut",tapToDismiss:!1})}

    </script>

</html>