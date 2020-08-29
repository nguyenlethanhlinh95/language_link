@extends('master.masterAdmin')
@section('title')
thông báo
@endsection
@section('contain')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Công việc </h4>
                        <br>
                        <form id="myform1" autocomplete="off" action="{{ route('postThemNhiemVu') }}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Chi nhánh <span style="color: red">*</span></label>
                                   <select class="form-control" id="chiNhanh" name="chiNhanh" required onchange="changeChiNhanh();">
                                   <option>Tất cả</option>
                                    @foreach($chiNhanh as $item)
                                    <option value="{{ $item->branch_id }}">{{ $item->branch_name }}</option>
                                    @endforeach
                                   </select>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Tiêu đề <span style="color: red">*</span></label>
                                    <input required class="form-control" name="tieuDe" id="tieuDe">
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <label>Ngày bắt đầu <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <input required name="startDate" type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Ngày kết thúc  <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <input required name="endDate" type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
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
                                    <label>Người nhận</label>
                                    <select class="js-example-responsive" multiple="multiple" 
                                    style="width: 100%" id="nguoiNhan" name="nguoiNhan[]" >
                                        <option value="0">ALL</option>
                                        @foreach($nhanVien as $item)
                                        <option value="{{ $item->employee_id }}">{{ $item->employee_name }}</option>
                                        @endforeach
                                       </select>
                                </div>
                                <div class="col-lg-12 col-sm-6">
                                <label>Nội dung <span style="color: red">*</span></label>
                                <textarea name="noiDung" id="noiDung" required></textarea>
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
<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
<script>




     $(".js-example-responsive1").select2({
    width: 'resolve' // need to override the changed default
    });
    $(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
    });
    
   CKEDITOR.replace('noiDung');
   

   function changeChiNhanh()
   {
       $chiNhanh = $('#chiNhanh').val();
       $("#nguoiNhan").empty();
       $("#leader").empty();
       $.ajax({
                type: 'get',
                url: '{{ route('changeChiNhanhCongViec')}}',
                data: {
                        'chiNhanh': $chiNhanh 
                    },
                    success: function (data) {
                                document.getElementById('leader').innerHTML=data[0]['leader'];
                                document.getElementById('nguoiNhan').innerHTML=data[0]['nguoiNhan'];
                            }
                    });

   }
</script>
@endsection