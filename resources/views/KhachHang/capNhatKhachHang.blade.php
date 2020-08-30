@extends('master.masterAdmin')
@section('title')
HỌC VIÊN
@endsection
@section('contain')
<div class="content-body">

    <!-- <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    </ol>
                </div>
            </div> -->
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
                        <h4 class="card-title">Cập nhật học viên @if (! isAdmin()) | {{ $branch }} @else {{ trans('student.no_support_admin') }} @endif</h4>
                      
                    <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                        <div class="row">
                            <input hidden id="id" name="id" value="{{$hocVien->student_id}}">
                            <div class="col-lg-4 col-sm-6">
                                <label>Họ học viên <span style="color: red">*</span></label>
                                <input maxlength="30" required class="form-control" name="firtName" value="{{$hocVien->student_firstName}}">
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <label>Tên học viên <span style="color: red">*</span></label>
                                <input maxlength="30" required class="form-control" name="lastName" value="{{$hocVien->student_lastName}}">
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <label>Nickname </label>
                                <input maxlength="30"  class="form-control" name="nickname" id="nickname" value="{{$hocVien->student_nickName}}">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Tên phụ huynh </label>
                                <input maxlength="50" class="form-control" name="parentName" value="{{$hocVien->student_parentName}}">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Số điện thoại phụ huynh </label>
                                <input maxlength="30" class="form-control" name="parentPhone" value="{{$hocVien->student_parentPhone}}">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Email </label>
                                <input maxlength="50" type="email" required class="form-control" name="mail" value="{{$hocVien->student_email}}">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Số điện thoại học viên </label>
                                <input maxlength="30" class="form-control" name="phone" value="{{$hocVien->student_phone}}">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Ngày sinh <span style="color: red">*</span></label>
                                <div class="input-group">
                                                <input name="birthday" type="text" class="form-control mydatepicker" value="{{date('m/d/Y',strtotime( $hocVien->student_birthDay))}}" 
												placeholder="mm/dd/yyyy"> <span class="input-group-append" >
												<span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Trạng thái </label>
                               <select class="form-control" name="trangThai" required>
                                   @if($hocVien->student_status==1)
                                   <option selected value="1">Hoạt động</option>
                                   <option value="0">Đã nghỉ</option>
                                   @else 
                                   <option value="1">Hoạt động</option>
                                   <option selected value="0">Đã nghỉ</option>
                                    @endif
                                <select>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Link ảnh (600 x 600 px)</label>
                                <input maxlength="50" name="link" type="text"  class="form-control" value="{{ $hocVien->student_link }}">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Hình ảnh (600 x 600 px)</label>
                                <input maxlength="50" name="images" type="file"  class="form-control" >
                            </div>
                            <div class="col-lg-12 ">
                                <label>Địa Chỉ <span style="color: red">*</span></label>
                                <input maxlength="100" required class="form-control" name="address" value="{{$hocVien->student_address}}">
                            </div>
                        
                            <div class="col-lg-12 " style="padding: 10px">
                                <label>Bạn Biết LanguageLink qua(You now LL through) </label>
                            </div>
                        
                            
                                @foreach($marketing as $item)
                                @php $check =0; @endphp
                                    @foreach($khachHangMarketTing as $item1)
                                        @if($item1->marketing_id== $item->marketing_id)
                                        @php $check =1; @endphp
                                        @endif
                                    @endforeach
                                    @if($check==1)
                                    <div class="col-lg-3 col-sm-6">
                                    <div class="form-check mb-3">
                                        <label class="form-check-label">
                                            <input checked name="marketing{{$item->marketing_id}}" type="checkbox" class="form-check-input" >{{$item->marketing_name}}
                                        </label>
                                    </div>
                                </div>
                                    @else
                                    <div class="col-lg-3 col-sm-6">
                                    <div class="form-check mb-3">
                                        <label class="form-check-label">
                                            <input name="marketing{{$item->marketing_id}}" type="checkbox" class="form-check-input" >{{$item->marketing_name}}
                                        </label>
                                    </div>
                                </div>
                                    @endif
                                
                                @endforeach

                                <div class="col-lg-12 " style="text-align: center">
                                @if (!isAdmin())
                                <button type="submit" class="btn mb-1 btn-outline-success" >Cập nhật</button>
                                @endif
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
@if (!isAdmin())
<script>
      $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{ route("postCapNhatHocVien")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Câp nhật học viên", "Cập nhật thành công!!!");


                } else if (data == 2) {
                    KiemTra("Cập nhật học viên", "Bạn không có quyền cập nhật!!!");
                }
                else if (data == 3) {
                    KiemTra("Cập nhật học viên", "Số đt HV và số đt PH ít nhất có một!!!");
                }
                else {
                    PhatHienLoi('Cập nhật học viên', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endif
@endsection