@extends('master.masterAdmin')
@section('title')
nhân sự
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
                        <h4 class="card-title">Nhân sự </h4>
                        <br>
                        <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <input hidden name="id" value="{{$nhanVien->employee_id}}">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Tên nhân sự <span style="color: red">*</span></label>
                                    <input class="form-control" required maxlength="100" name="ten" value="{{$nhanVien->employee_name}}">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Ngày sinh <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <input required name="ngaySinh" type="text" value="{{date('m/d/Y',strtotime( $nhanVien->employee_birthDay))}}"
                                         class="form-control mydatepicker" placeholder="mm/dd/yyyy"> 
                                         <span class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="mdi mdi-calendar-check"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Số điện thoại <span style="color: red">*</span></label>
                                    <input class="form-control" maxlength="30"  required type="text" name="sdt" value="{{$nhanVien->employee_phone}}">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Email <span style="color: red">*</span></label>
                                    <input class="form-control" maxlength="50"  required type="mail" name="mail" value="{{$nhanVien->employee_email}}">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Hình ảnh (600 x 600 px)</label>
                                    <input class="form-control" maxlength="200"   type="file" name="images">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Link hình ảnh (600 x 600 px)</label>
                                    <input class="form-control" maxlength="200"   type="text" name="link" value="{{$nhanVien->employee_link}}">
                                </div>
                               
                                <div class="col-lg-6 col-sm-6">
                                    <label>Địa chỉ <span style="color: red">*</span></label>
                                    <input type="text" required class="form-control"  maxlength="100" name="diaChi" value="{{$nhanVien->employee_address}}">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Chi nhánh <span style="color: red">*</span></label>
                                    <select class="form-control" name="chiNhanh" required>
                                        @foreach($chiNhanh as $item)
                                        @if($item->branch_id == $nhanVien->branch_id)
                                           <option selected value="{{$item->branch_id}}">{{$item->branch_name}}</option>
                                        @else
                                        <option value="{{$item->branch_id}}">{{$item->branch_name}}</option>
                                       
                                        @endif
                                           @endforeach
                                           
                                       </select>
                                    </div>


                                    <div class="col-lg-6 col-sm-6">
                                        <label>Phòng Ban <span style="color: red">*</span></label>
                                        <select class="form-control" name="phongBan" required>
                                         @foreach($phongBan as $item)
                                         @if($nhanVien->department_id == $item->department_id)
                                            <option selected value="{{$item->department_id}}">{{$item->department_name}}</option>
                                        @else 
                                        <option value="{{$item->department_id}}">{{$item->department_name}}</option>
                                       
                                        @endif
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-sm-6" style="padding-left: 35px">
                                        <label><label><br><br>
                                            @if($nhanVien->employee_office==1)
                                            <input checked type="checkbox" name="gioLamViec" id="gioLamViec">&nbsp; Giờ Làm việc văn phòng
                                           @else 
                                           <input type="checkbox" name="gioLamViec" id="gioLamViec">&nbsp; Giờ Làm việc văn phòng
                                           @endif
                                           
                                         </div>
                                         <div class="col-lg-6 col-sm-6">
                                            <label>Giáo viên <span style="color: red">*</span></label>
                                            <select class="form-control" name="loaiGiaoVien" required>
                                           @if($nhanVien->employee_type==0)
                                            <option selected value="0">Việt Nam</option>
                                            <option value="1">Nước ngoài</option>
                                                @else 
                                                <option value="0">Việt Nam</option>
                                                <option selected value="1">Nước ngoài</option>
                                                @endif
                                            </select>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Số giờ <span style="color: red">*</span></label>
                                       <input required class="form-control" value="{{ $nhanVien->employee_numberHours }}" name="soGio" id="soGio"  onkeypress='validate(event)' > 
                                    </div>     
                                <div class="col-lg-6 col-sm-6">
                                    <label>Chức vụ <span style="color: red">*</span></label>
                                    <select class="form-control" name="chucVu" required>
                                     @foreach($chucVu as $item)
                                     @if($item->position_id == $nhanVien->position_id)
                                        <option selected value="{{$item->position_id}}">{{$item->position_name}}</option>
                                        @else
                                        <option value="{{$item->position_id}}">{{$item->position_name}}</option>
                                        @endif
                                    @endforeach
                                        
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Loại hợp đồng <span style="color: red">*</span></label>
                                    <select class="form-control" name="loaiHopDong" id="loaiHopDong" onchange="changLoaiHopDong();" required>
                                       @if($nhanVien->contractType_id==0)
                                        <option selected value="0">Vô thời hạn</option>
                                        <option value="1">Có thời hạn</option>
                                        <option value="2">Part-time</option>
                                        <option value="3">Thử việc</option>
                                        @elseif($nhanVien->contractType_id==1)
                                        <option value="0">Vô thời hạn</option>
                                        <option selected value="1">Có thời hạn</option>
                                        <option value="2">Part-time</option>
                                        <option value="3">Thử việc</option>
                                        @elseif($nhanVien->contractType_id==2)
                                        <option value="0">Vô thời hạn</option>
                                        <option value="1">Có thời hạn</option>
                                        <option selected value="2">Part-time</option>
                                        <option value="3">Thử việc</option>
                                        @else 
                                        <option value="0">Vô thời hạn</option>
                                        <option value="1">Có thời hạn</option>
                                        <option  value="2">Part-time</option>
                                        <option selected value="3">Thử việc</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Ngày bắt đầu <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <input required name="ngayBatDau" type="text" value="{{date('m/d/Y',strtotime( $nhanVien->employee_startDay))}}"
                                         class="form-control mydatepicker" placeholder="mm/dd/yyyy"> 
                                         <span class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="mdi mdi-calendar-check"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div id="duLieuNgayKetThuc">
                                        @if($nhanVien->contractType_id!=0)
                                        <label>Ngày kết thúc <span style="color: red">*</span></label>
                                        <div class="input-group">
                                            <input required name="ngayKetThuc" type="text" value="{{date('m/d/Y',strtotime( $nhanVien->employee_endDay))}}"
                                             class="form-control mydatepicker" placeholder="mm/dd/yyyy">
                                             <span class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="mdi mdi-calendar-check"></i></span></span>
                                        </div>
                                        @endif
                                    </div>
                                   
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Trạng Thái <span style="color: red">*</span></label>
                                    <select class="form-control" name="trangThai" required>
                                        <option value="1">Hoạt động</option>
                                        <option value="0">Nghỉ việc</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Tài khoản <span style="color: red">*</span></label>
                                    <input class="form-control" readonly maxlength="30" required type="text" name="taiKhoan" value="{{$nhanVien->employee_account}}">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Mật khẩu <span style="color: red">*</span></label>
                                    <input class="form-control" maxlength="30"  required type="password" name="matKhau" value="{{$nhanVien->employee_password}}">
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
            url: '{{route("postCapNhatNhanSu")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Cập nhật nhân sự", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getNhanSu')}}";
                    }, 2000);
                } else if (data == 2) {
                    KiemTra("Cập nhật nhân sự", "Bạn không có quyền cập nhật!!!");
                }
                 else if (data == 3) {
                    KiemTra("Cập nhật nhân sự", "Tài khoản đăng nhập đã tồn tại!!!");
                }  
                else {
                    PhatHienLoi('Cập nhật nhân sự', "Lỗi Kết Nối!!!");
                }

               //  alert(data);
            }
        });
        return false;
    });
   
</script>
@endsection