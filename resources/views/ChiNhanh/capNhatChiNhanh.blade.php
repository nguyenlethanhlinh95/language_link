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
                        <h4 class="card-title">Cập nhật chi nhánh</h4>
                        <br>
                        <form id="myform1" action="{{route('postCapNhatChiNhanh')}}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            @php
                            $id = $_GET['id'];
                            $chiNhanh = Illuminate\Support\Facades\DB::table('st_branch')
                            ->where('branch_id',$id)->get()->first();
                            @endphp
                            <div class="row">
                            <input hidden class="form-control" name="id"
                             value="@php echo $chiNhanh->branch_id; @endphp">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Tên chi nhánh  <span style="color: red">*</span></label>
                                    <input required  maxlength="100" class="form-control" name="ten"
                                    value="@php echo $chiNhanh->branch_name; @endphp">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Mã chi nhánh <span style="color: red">*</span></label>
                                    <input required  maxlength="20" class="form-control" name="ma"
                                    value="@php echo $chiNhanh->branch_code; @endphp">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Logo (410 x 125 px)</label>
                                    <input  maxlength="100" type="file" class="form-control" name="logo">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Link ảnh (410 x 125 px)</label>
                                    <input  maxlength="100" class="form-control" name="link">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Số điện thoại <span style="color: red">*</span></label>
                                    <input required  maxlength="50" class="form-control" name="sdt"
                                    value="@php echo $chiNhanh->branch_phone; @endphp">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Email <span style="color: red">*</span></label>
                                    <input type="email" required  maxlength="100" class="form-control" name="mail"
                                    value="@php echo $chiNhanh->branch_mail; @endphp">
                                </div>
                                <div class="col-lg-12 col-sm-6">
                                    <label>Địa chỉ <span style="color: red">*</span></label>
                                    <input required  maxlength="100" class="form-control" name="diaChi"
                                    value="@php echo $chiNhanh->branch_address; @endphp">
                                </div>
                                <div class="col-lg-12 col-sm-6">
                                    <label>Nội dung chi tiết </label>
                                    <textarea name="chiTiet" id="chiTiet">@php echo $chiNhanh->branch_detail; @endphp</textarea>
                                </div>

                                <div class="col-lg-12 " style="text-align: center">
                                    <button type="submit" class="btn mb-1 btn-outline-success">Cập nhật</button>

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
        @if(isset($_GET['sms']))
            if ('@php echo $_GET["sms"];  @endphp' == "1") {
                ThemThanhCong("Cập nhật chi nhánh", "Cập nhật thành công!!!");
                setTimeout(function() {
                    window.location = "{{route('getChiNhanh')}}";
                }, 2000);

            } else if ('@php echo $_GET["sms"];  @endphp' == "2") {
                KiemTra("Cập nhật chi nhánh", "Bạn không có quyền Cập nhật!!!");
            } else if ('@php echo $_GET["sms"];  @endphp' == "0"){
                PhatHienLoi('Cập nhật chi nhánh', "Lỗi Kết Nối!!!");
            }
        @endif

    }

    CKEDITOR.replace('chiTiet');
</script>

@endsection