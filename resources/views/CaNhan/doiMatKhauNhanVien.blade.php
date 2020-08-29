@extends('master.masterAdmin')
@section('title')
Đổi mật khẩu
@endsection
@section('contain')
<div class="content-body">


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Đổi mật khẩu</h4>
                        <br>
                        <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                               
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Mật khẩu củ <span style="color: red">*</span> </label>
                                    <input class="form-control" type="password" required maxlength="100" name="matKhauCu" value="">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Mật khẩu mới <span style="color: red">*</span></label>
                                    <input class="form-control" type="password" required maxlength="100" name="matKhauMoi" value="">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Nhập lại mật khẩu  <span style="color: red">*</span></label>
                                    <input class="form-control" type="password" maxlength="30"  required type="text" name="reMatKhauMoi" value="">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                            </div>

                            <br>
                            <br>
                            <div style="text-align: center">
                                <button type="submit" class="btn mb-1 btn-outline-success">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>

    function changLoaiHopDong()
    {
        $loaiHopDong = $('#loaiHopDong').val();
        if($loaiHopDong==0)
        {
            document.getElementById('duLieuNgayKetThuc').innerHTML="";
        }
        else
        {
            document.getElementById('duLieuNgayKetThuc').innerHTML=' <label>Ngày kết thúc</label>'+
                                        '<div class="input-group">'+
                                            '<input required name="ngayKetThuc" type="text"'+
                                             'class="form-control mydatepicker" placeholder="mm/dd/yyyy">'+
                                             '<span class="input-group-append">'+
                                                '<span class="input-group-text">'+
                                                    '<i class="mdi mdi-calendar-check"></i></span></span>'+
                                        '</div>';
            jQuery('.mydatepicker, #datepicker').datepicker();
            jQuery('#datepicker-autoclose').datepicker({
                autoclose: true,
                todayHighlight: true
            });
        }
    }

    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatMatKhau")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Cập nhật mật khẩu", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getDoiMatKhau')}}";
                    }, 2000);
                } else if (data == 2) {
                    KiemTra("Cập nhật mật khẩu", "Mật khẩu mới không khớp!!!");
                }
                 else if (data == 3) {
                    KiemTra("Cập nhật mật khẩu", "Mật khẩu củ không chính xác!!!");
                }  
                else {
                    PhatHienLoi('Cập nhật mật khẩu', "Lỗi Kết Nối!!!");
                }

               //  alert(data);
            }
        });
        return false;
    });
   
</script>
@endsection