@extends('master.masterAdmin')
@section('title')
HỌC VIÊN
@endsection
@section('contain')
<div class="content-body">

    <div class="row page-titles mx-0" style="padding-bottom: 0px!important">
        <div class="col p-md-0">
            <ol class="breadcrumb" style="float:left!important">
                <li class="breadcrumb-item active" ><a href="{{ url()->previous() }}" class="btn mb-1 btn-rounded btn-outline-dark fa fa-backward">&nbsp;&nbsp;Back</a></li>
            </ol>
        </div>
    </div> 
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Thêm học viên</h4>
                      
                    <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-4 col-sm-6">
                                <label>Họ học viên <span style="color: red">*</span></label>
                                <input maxlength="30" required class="form-control" name="firtName" id="firtName">
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <label>Tên học viên <span style="color: red">*</span></label>
                                <input maxlength="30" required class="form-control" name="lastName" id="lastName">
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <label>Nickname </label>
                                <input maxlength="30"  class="form-control" name="nickname" id="nickname">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Tên phụ huynh </label>
                                <input maxlength="50" class="form-control" name="parentName">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Số điện thoại phụ huynh </label>
                                <input maxlength="30" class="form-control" name="parentPhone">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Email </label>
                                <input maxlength="50" type="email" required class="form-control" name="mail">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Số điện thoại học viên </label>
                                <input maxlength="30" class="form-control" name="phone" id="phone">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Ngày sinh <span style="color: red">*</span></label>
                                <div class="input-group">
                                                <input name="birthday" type="text" class="form-control mydatepicker" 
												placeholder="mm/dd/yyyy"> <span class="input-group-append">
												<span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Trạng thái </label>
                               <select class="form-control" name="trangThai" required>
                                   <option value="1">Hoạt động</option>
                                   <option value="0">Đã nghỉ</option>
                                <select>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Link ảnh (600 x 600 px)</label>
                                <input maxlength="200" name="link" type="text"  class="form-control" >
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Hình ảnh (600 x 600 px)</label>
                                <input maxlength="50" name="images" type="file"  class="form-control" >
                            </div>
                            <div class="col-lg-12 ">
                                <label>Địa Chỉ <span style="color: red">*</span></label>
                                <input maxlength="100" required class="form-control" name="address">
                            </div>
                        
                            <div class="col-lg-12 " style="padding: 10px">
                                <label>Bạn Biết LanguageLink qua(You now LL through) </label>
                            </div>
                        
                            
                                @foreach($marketing as $item)
                                <div class="col-lg-3 col-sm-6">
                                    <div class="form-check mb-3">
                                        <label class="form-check-label">
                                            <input name="marketing{{$item->marketing_id}}" type="checkbox" class="form-check-input" >{{$item->marketing_name}}
                                        </label>
                                    </div>
                                </div>
                                @endforeach

                                <div class="col-lg-12 " style="text-align: center">
                                <button type="submit" class="btn mb-1 btn-outline-success" >Thêm mới</button>
                            
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
<script>
      $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{ route("postThemHocVien")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data[0]['loai'] == 1) {
                    ThemThanhCong("Thêm học viên", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getChiTietHocVien')}}?id="+data[0]['id'];
                    }, 2000);

                } else if (data[0]['loai'] == 2) {
                    KiemTra("Thêm học viên", "Bạn không có quyền thêm!!!");
                }
                else if (data[0]['loai'] == 3) {
                    KiemTra("Thêm học viên", "Số đt HV và Số đt PH ít nhất có một!!!");
                }  
                else {
                    PhatHienLoi('Thêm học viên', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection