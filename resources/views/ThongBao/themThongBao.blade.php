@extends('master.masterAdmin')
@section('title')
thông báo
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Thông Báo </h4>
                        <br>
                        <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Chi nhánh <span style="color: red">*</span></label>
                                   <select class="form-control" id="chiNhanh" name="chiNhanh" required onchange="changeChiNhanh();">
                                    @foreach($chiNhanh as $item)
                                    <option value="{{ $item->branch_id }}">{{ $item->branch_name }}</option>
                                    @endforeach
                                   </select>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Loại thông báo <span style="color: red">*</span></label>
                                    <select class="form-control" id="loaiThongBao" name="loaiThongBao" required onchange="changeChiNhanh();">
                                        <option value="1">Nhân viên</option>
                                        <option value="2">Học viên</option>
                                        <option value="3">Lớp học</option>
                                        <option value="4">Teamwork</option>
                                    </select>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <label>Ngày <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <input required name="startDate" type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Giờ  <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group clockpicker">
                                            <input required name="startTime" type="text" class="form-control" value="09:30">
                                            <span class="input-group-append"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <label>Người xử lý chính <span style="color: red">*</span></label>
                                    <select class="js-example-responsive" style="width: 100%" id="leader" name="leader" required>
                                        @foreach($nhanVien as $item)
                                        <option value="{{ $item->employee_id }}">{{ $item->employee_name }}</option>
                                        @endforeach
                                       </select>
                                       </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Người nhận <span style="color: red">*</span></label>
                                    <select class="js-example-responsive" multiple="multiple" 
                                    style="width: 100%" id="nguoiNhan" name="nguoiNhan[]" required>
                                        <option value="0">ALL</option>
                                        @foreach($nhanVien as $item)
                                        <option value="{{ $item->employee_id }}">{{ $item->employee_name }}</option>
                                        @endforeach
                                       </select>
                                </div>
                                <div class="col-lg-12 col-sm-6">
                                <label>Nội dung <span style="color: red">*</span></label>
                                <textarea style="border: 1px solid thistle" required class="form-control" id="noiDung" name="noiDung"></textarea>
                                </div>
                            </div>
                            <table></table>
                            <br>
                            <br>
                            <div style="text-align: center">
                                <button type="submit" class="btn mb-1 btn-outline-success">Thêm mới</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script src="js/select2.js"></script>

<script>




     $(".js-example-responsive1").select2({
    width: 'resolve' // need to override the changed default
    });
    $(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
    });
  
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemThongBao")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm thông báo", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getThongBao')}}";
                    }, 2000);
                } else if (data == 2) {
                    KiemTra("Thêm thông báo", "Bạn không có quyền thêm!!!");
                }
                 else if (data == 3) {
                    KiemTra("Thêm thông báo", "Khuyến mãi cố định phải có số khóa!!!");
                }  
                else {
                    PhatHienLoi('Thêm thông báo', "Lỗi Kết Nối!!!");
                }

                //alert(data);
            }
        });
        return false;
    });
   function changeChiNhanh()
   {
       $chiNhanh = $('#chiNhanh').val();
       $loai = $('#loaiThongBao').val();
      
       $("#nguoiNhan").empty();
       $.ajax({
                            type: 'get',
                            url: '{{ route('changeLoaiChiNhanhThongBao')}}',
                            data: {
                                'chiNhanh': $chiNhanh,
                                'loai':$loai
                            },
                            success: function (data) {
                                document.getElementById('leader').innerHTML=data[0]['nguoiChinh'];
                                document.getElementById('nguoiNhan').innerHTML=data[0]['nguoiNhan'];
                            }
                        });

   }
</script>
@endsection