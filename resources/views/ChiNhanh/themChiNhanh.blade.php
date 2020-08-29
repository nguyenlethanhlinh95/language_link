@extends('master.masterAdmin')
@section('title')
Chi nhánh
@endsection
@section('contain')
<div class="content-body">


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Thêm chi nhánh</h4>
                        <br>
                        <form id="myform1" action="{{route('postThemChiNhanh')}}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Tên chi nhánh  <span style="color: red">*</span></label>
                                    <input required  maxlength="100" class="form-control" name="ten">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Mã chi nhánh  <span style="color: red">*</span></label>
                                    <input required  maxlength="20" class="form-control" name="ma">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Logo (410 x 125 px)</label>
                                    <input  maxlength="100" type="file" class="form-control" name="logo">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Link ảnh (410 x 125px)</label>
                                    <input  maxlength="100" class="form-control" name="link">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Số điện thoại  <span style="color: red">*</span></label>
                                    <input required  maxlength="50" class="form-control" name="sdt">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Email  <span style="color: red">*</span></label>
                                    <input type="email" required  maxlength="100" class="form-control" name="mail">
                                </div>
                                <div class="col-lg-12 col-sm-6">
                                    <label>Địa chỉ  <span style="color: red">*</span></label>
                                    <input required  maxlength="100" class="form-control" name="diaChi">
                                </div>
                                <div class="col-lg-12 col-sm-6">
                                    <label>Nội dung chi tiết</label>
                                    <textarea name="chiTiet" id="chiTiet"></textarea>
                                </div>

                                <div class="col-lg-12 " style="text-align: center">
                                    <button type="submit" class="btn mb-1 btn-outline-success">Thêm mới</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>

<script>
 
    window.onload = function(e) {
        if ('{{$sms}}' == "1") {
            ThemThanhCong("Thêm chi nhánh", "Thêm thành công!!!");
            setTimeout(function() {
                window.location = "{{route('getChiNhanh')}}";
            }, 2000);

        } else if ('{{$sms}}' == "2") {
            KiemTra("Thêm chi nhánh", "Bạn không có quyền thêm!!!");
        } else if ('{{$sms}}' == "0"){
            PhatHienLoi('Thêm chi nhánh', "Lỗi Kết Nối!!!");
        }

       
    }

    CKEDITOR.replace('chiTiet');
</script>

@endsection