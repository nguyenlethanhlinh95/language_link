@extends('master.masterAdmin')
@section('title')
PHỎNG VẤN
@endsection
@push('styles')
    <style>
        label {
            margin-bottom: 0;
            margin-top: 15px;
        }
    </style>
@endpush
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
                            <h4 class="card-title">Kết quả phỏng vấn</h4>
                                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    <input hidden id="id" name="id" value="{{$phongVan->placementTest_id}}">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Tên học viên</label>
                                            <input maxlength="30" required class="form-control" readonly name="lastName" value="{{$phongVan->student_firstName}} {{$phongVan->student_lastName}}">
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Số điện thoại</label>
                                            <input maxlength="30" class="form-control" name="phone" readonly value="{{$phongVan->student_phone}}">
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Reading </label>
                                            <input maxlength="100" class="form-control" name="reading"  value="{{$phongVan->placementTest_reading}}">
                                        
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Writing</label>
                                            <div class="input-group">
                                            <input maxlength="100" class="form-control" name="writing"  value="{{$phongVan->placementTest_writing}}">
                                        
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Listening </label>
                                            <input maxlength="100" class="form-control" name="listening"  value="{{$phongVan->placementTest_listening}}">
                                        

                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Speaking</label>
                                            <input maxlength="100" class="form-control" name="speaking"  value="{{$phongVan->placementTest_speaking}}">
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Khóa học chính <span style="color: red">*</span></label>
                                            <select class="form-control" name="khoaHoc1">
                                              @foreach($khoaHoc as $item)
                                              @if($phongVan->course_id2==$item->course_id)
                                                <option selected value="{{$item->course_id}}">{{$item->studyProgram_code}} - {{$item->course_name}}</option>
                                              @else
                                                 <option value="{{$item->course_id}}">{{$item->studyProgram_code}} - {{$item->course_name}}</option>
                                              @endif
                                              @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Khóa học phụ <span style="color: red">*</span></label>
                                            <select class="form-control" name="khoaHoc2">
                                              @foreach($khoaHoc as $item)
                                              @if($phongVan->course_id2==$item->course_id)
                                                <option selected value="{{$item->course_id}}">{{$item->studyProgram_code}} - {{$item->course_name}}</option>
                                              @else
                                                 <option value="{{$item->course_id}}">{{$item->studyProgram_code}} - {{$item->course_name}}</option>
                                              @endif
                                              @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label>Tình trạng <span style="color: red">*</span></label>
                                            <select class="form-control" name="status" required>
                                                @if($phongVan->placementTest_status==2)
                                                <option value="1">Chờ mở lớp</option>
                                                <option selected value="2">Tạm hoãn</option>
                                                @else
                                                <option value="1">Chờ mở lớp</option>
                                                <option value="2">Tạm hoãn</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label>Ghi chú</label>
                                            <textarea class="form-control" name="detail">{{$phongVan->placementTest_reason}}</textarea>
                                        </div>
                                        @if(session('quyen2001')==1)
                                        <div class="col-lg-12 mt-4" style="text-align: center;padding: 10px">
                                            <button type="submit" class="btn mb-1 btn-outline-success">Cập nhật</button>
                                        </div>
                                        @endif
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
            url: '{{ route("postCapNhatKetQuaPhongVan")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Cập nhật kết quả phỏng vấn", "Cập nhật thành công!!!");
                    setTimeout(function(){
                        window.location = "{{route('getPhongVan')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật kết quả phỏng vấn", "Bạn không có quyền cập nhật!!!");
                }
                else {
                    PhatHienLoi('Cập nhật kết quả phỏng vấn', "Lỗi Kết Nối!!!");
                }
            }
        });
        return false;
    });
</script>
@endsection