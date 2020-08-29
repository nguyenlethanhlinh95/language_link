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
                        <form id="myform1"  autocomplete="off" action="" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <label>Tên nhân sự <span style="color: red">*</span></label>
                                    <input class="form-control" required maxlength="100" name="ten">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Ngày sinh <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <input required name="ngaySinh" type="text"
                                         class="form-control mydatepicker" placeholder="mm/dd/yyyy"> 
                                         <span class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="mdi mdi-calendar-check"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Số điện thoại <span style="color: red">*</span></label>
                                    <input class="form-control" maxlength="30"  required type="text" name="sdt">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Email <span style="color: red">*</span></label>
                                    <input class="form-control" maxlength="50"  required type="mail" name="mail">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Hình ảnh (600 x 600 px)</label>
                                    <input class="form-control" maxlength="200"   type="file" name="images">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Link hình ảnh (600 x 600 px)</label>
                                    <input class="form-control" maxlength="200"   type="text" name="link">
                                </div>
                               
                                <div class="col-lg-6 col-sm-6">
                                    <label>Địa chỉ <span style="color: red">*</span></label>
                                    <input type="text" required class="form-control"  maxlength="100" name="diaChi">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Chi nhánh <span style="color: red">*</span></label>
                                    <select class="form-control" name="chiNhanh" required>
                                        @foreach($chiNhanh as $item)
                                           <option value="{{$item->branch_id}}">{{$item->branch_name}}</option>
                                       @endforeach
                                           
                                       </select>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Phòng Ban <span style="color: red">*</span></label>
                                        <select class="form-control" name="phongBan" required>
                                         @foreach($phongBan as $item)
                                            <option value="{{$item->department_id}}">{{$item->department_name}}</option>
                                        @endforeach
                                            
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-6 col-sm-6" style="padding-left: 35px">
                                        <label><label><br><br>
                                          
                                                <input type="checkbox" name="gioLamViec" id="gioLamViec">&nbsp; Giờ Làm việc văn phòng
                                    </div>
                                     <div class="col-lg-6 col-sm-6">
                                            <label>Giáo viên <span style="color: red">*</span></label>
                                            <select class="form-control" name="loaiGiaoVien" required>
                                           
                                            <option value="0">Việt Nam</option>
                                            <option value="1">Nước ngoài</option>
                                                
                                            </select>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Số giờ </label>
                                        <!--  onkeypress='validate(event)' trong the input sogio-->
                                       <input  class="form-control" name="soGio" id="soGio"   > 
                                    </div>
                                      
                                <div class="col-lg-6 col-sm-6">
                                    <label>Chức vụ  <span style="color: red">*</span></label>
                                    <select class="form-control" name="chucVu" required>
                                     @foreach($chucVu as $item)
                                        <option value="{{$item->position_id}}">{{$item->position_name}}</option>
                                    @endforeach
                                        
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Loại hợp đồng <span style="color: red">*</span></label>
                                    <select class="form-control" name="loaiHopDong" id="loaiHopDong" onchange="changLoaiHopDong();" required>
                                        <option value="0">Vô thời hạn</option>
                                        <option value="1">Có thời hạn</option>
                                        <option value="2">Part-time</option>
                                        <option value="3">Thử việc</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Ngày bắt đầu <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <input required name="ngayBatDau" type="text"
                                         class="form-control mydatepicker" placeholder="mm/dd/yyyy"> 
                                         <span class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="mdi mdi-calendar-check"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div id="duLieuNgayKetThuc">
                                        
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
                                    <label>Phân quyền <span style="color: red">*</span></label>
                                    <select class="form-control" name="quyen" required>
                                     
                                        @foreach($nhomQuyen as $item)
                                        <option value="{{$item->permissionGroup_id}}">{{$item->permissionGroup_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Tài khoản <span style="color: red">*</span></label>
                                    <input class="form-control" maxlength="30" required type="text" name="taiKhoan">
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Mật khẩu <span style="color: red">*</span></label>
                                    <input class="form-control" maxlength="30"  required type="password" name="matKhau">
                                </div>
                            </div>

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
<script>
function validate(evt) {
  var theEvent = evt || window.event;
 
  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
    function changLoaiHopDong()
    {
        $loaiHopDong = $('#loaiHopDong').val();
        if($loaiHopDong==0||$loaiHopDong==2)
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
            url: '{{ route('postThemNhanSu') }}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm nhân sự", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getNhanSu')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm nhân sự", "Bạn không có quyền thêm!!!");
                }

                else if (data == 3) {
                    KiemTra("Thêm nhân sự", "Mã nhân sự đã tồn tại!!!");
                }                 else {
                    PhatHienLoi('Thêm nhân sự', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });

    
   
</script>
@endsection