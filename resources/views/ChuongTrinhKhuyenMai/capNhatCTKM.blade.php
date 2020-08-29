@extends('master.masterAdmin')
@section('title')
khuyến mãi
@endsection
@section('contain')
<div class="content-body">


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Chương trình khuyến mãi </h4>
                        <br>
                        <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Tên khuyến mãi  <span style="color: red">*</span></label>
                                    <input hidden id="id" name="id" value="{{$khuyenMai->promotions_id}}">
                                    <input class="form-control" required maxlength="100" name="ten" value="{{$khuyenMai->promotions_name}}">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Giá khuyến mãi (%)  <span style="color: red">*</span></label>
                                    <input class="form-control" required type="number" name="gia" value="{{$khuyenMai->promotions_discount}}">
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <label>Ngày bắt đầu  <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <input required name="startDate" type="text" class="form-control mydatepicker" value="{{date('m/d/Y',strtotime($khuyenMai->promotions_startDate)) }}"
                                        placeholder="mm/dd/yyyy"> <span class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Giờ bắt đầu  <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group clockpicker">
                                            <input required name="startTime" type="text" class="form-control"  value="{{date('H:i',strtotime($khuyenMai->promotions_startDate)) }}"> 
                                            <span class="input-group-append"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Ngày kết thúc  <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <input required name="endDate" type="text" class="form-control mydatepicker" value="{{date('m/d/Y',strtotime($khuyenMai->promotions_endDate)) }}"
                                        placeholder="mm/dd/yyyy"> <span class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Giờ kết thúc  <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group clockpicker">
                                            <input required name="endTime" type="text" class="form-control"  value="{{date('H:i',strtotime($khuyenMai->promotions_endDate)) }}">
                                            <span class="input-group-append"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Số khóa</label>
                                    <input type="number" class="form-control"  maxlength="100" name="so" value="{{$khuyenMai->promotions_number}}">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Loại Khuyến mãi  <span style="color: red">*</span></label>
                                    <select required class="form-control" name="loai">
                                        @if($khuyenMai->promotions_type==0)
                                        <option selected value="0">KM cố định</option>
                                        <option value="1">KM khác</option>
                                        @else
                                        <option value="0">KM cố định</option>
                                        <option selected value="1">KM khác</option>
                                        @endif
                                    </select>
                                   
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
  
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatKM")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Cập nhật khuyến mãi", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getChuongTrinhKM')}}";
                    }, 2000);
                } else if (data == 2) {
                    KiemTra("Cập nhật khuyến mãi", "Bạn không có quyền Cập nhật!!!");
                }
                 else if (data == 3) {
                    KiemTra("Cập nhật khuyến mãi", "Khuyến mãi cố định phải có số khóa!!!");
                }  
                else {
                    PhatHienLoi('Cập nhật khuyến mãi', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
   
</script>
@endsection