@extends('master.masterAdmin')
@section('title')
Thông tin
@endsection
@section('contain')
<div class="content-body">


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Thông tin </h4>
                        <br>
                        <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <input hidden name="id" value="{{$nhanVien->employee_id}}">
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Họ và tên  <span style="color: red">*</span></label>
                                    <input class="form-control" required maxlength="100" name="ten" value="{{$nhanVien->employee_name}}">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Ngày sinh  <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <input required name="ngaySinh" type="text" value="{{date('m/d/Y',strtotime( $nhanVien->employee_birthDay))}}"
                                         class="form-control mydatepicker" placeholder="mm/dd/yyyy"> 
                                         <span class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="mdi mdi-calendar-check"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Số điện thoại  <span style="color: red">*</span></label>
                                    <input class="form-control" maxlength="30"  required type="text" name="sdt" value="{{$nhanVien->employee_phone}}">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Email <span style="color: red">*</span></label>
                                    <input class="form-control" maxlength="50"  required type="mail" name="mail" value="{{$nhanVien->employee_email}}">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Địa chỉ  <span style="color: red">*</span></label>
                                    <input type="text" required class="form-control"  maxlength="100" name="diaChi" value="{{$nhanVien->employee_address}}">
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
            document.getElementById('duLieuNgayKetThuc').innerHTML=' <label>Ngày kết thúc  <span style="color: red">*</span></label>'+
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
            url: '{{route("postCapNhatCaNhanh")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Cập nhật thông tin", "Cập nhật thành công!!!");
                 
                } else if (data == 2) {
                    KiemTra("Cập nhật thông tin", "Bạn không có quyền cập nhật!!!");
                }
                 else if (data == 3) {
                    KiemTra("Cập nhật thông tin", "Tài khoản đăng nhập đã tồn tại!!!");
                }  
                else {
                    PhatHienLoi('Cập nhật thông tin', "Lỗi Kết Nối!!!");
                }

               //  alert(data);
            }
        });
        return false;
    });
   
</script>
@endsection