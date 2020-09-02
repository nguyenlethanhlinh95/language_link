@extends('master.masterAdmin')
@section('title')
PT
@endsection
@push('styles')
    <style>
        label{
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

                        <div class="row">
                           
                            <div class="col-lg-6 col-sm-6">
                            <h4 class="card-title">Cập nhật PT</h4>
                                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    <input hidden id="id" name="id" value="{{$phongVan->placementTest_id}}">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-6">
                                            <label>Tên học viên</label>
                                            <input maxlength="30" required class="form-control" readonly name="lastName" value="{{$phongVan->student_firstName}} {{$phongVan->student_lastName}}">
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label>Số điện thoại</label>
                                            <input maxlength="30" class="form-control" name="phone" readonly value="{{$phongVan->student_phone}}">
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label>Ngày phỏng vấn <span style="color: red">*</span></label>
                                            <div class="input-group">
                                                <input require name="date" id="date" type="text" onchange="getDuLieuLichGiaoVien();"
                                                 class="form-control mydatepicker" placeholder="mm/dd/yyyy" value="{{date('m/d/Y',strtotime($phongVan->placementTest_dateTime))}}"> <span class="input-group-append">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label>Thời Gian <span style="color: red">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group clockpicker">
                                                    <input require name="time" id="time" type="text" class="form-control" value="{{date('H:i',strtotime($phongVan->placementTest_dateTime))}}"> 
                                                    <span class="input-group-append"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label>Giáo viên phỏng vấn <span style="color: red">*</span></label>
                                            <select class="form-control" name="giaoVien" id="giaoVien" onchange="kiemTraGiaoVien();">
                                                @foreach($giaoVien as $item)
                                                    @if($item->employee_id==$phongVan->employee_id)
                                                    <option selected value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                                    @else
                                                    <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label>Khóa học <span style="color: red">*</span></label>
                                            <select class="form-control" name="khoaHoc" id="khoaHoc">
                                                @foreach($chuongTrinhHoc as $item)
                                                    @if($item->studyProgram_id==$phongVan->studyProgram_id)
                                                    <option selected value="{{$item->studyProgram_id}}">{{$item->studyProgram_name}}</option>
                                                    @else
                                                    <option value="{{$item->studyProgram_id}}">{{$item->studyProgram_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label>Nội dung</label>
                                            <textarea class="form-control" id="note" name="note">{{$phongVan->placementTest_note}}</textarea>
                                        </div>
                                        <div class="col-lg-12 " style="text-align: center;padding: 10px">
                                            <button type="submit" class="btn mb-1 btn-outline-success">Cập nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <h4 class="card-title">Lịch giáo viên</h4>

                                <table class="table table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Giáo viên</th>
                                            <th>Công việc</th>
                                            <th>Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody id="duLieuSearch">

                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>
    $('#myform1').submit(function() {
        $giaoVien = $('#giaoVien').val();
        $thoiGian = $('#date').val();
        $time = $('#time').val();
        $.ajax({
            type: 'get',
            url: '{{ route("kiemTraGiaoVienphongVan")}}',
            data: 
            {
                'giaoVien':$giaoVien,
                'thoiGian':$thoiGian,
                'time':$time
            }
            ,
            success: function(data) {
             if(data==0)
             {
                 KiemTra("Cập nhật PT","Giáo viên đã trùng lịch")
             }
             else
             {
                $id = $('#id').val();
                $khoaHoc = $('#khoaHoc').val();
                $note = $('#note').val();
             

                $.ajax({
            type: 'get',
            token: "{!! @csrf_token() !!}",
            url: '{{ route("postCapNhatPhongVan")}}',
            data:{
                'giaoVien':$giaoVien,
                'date':$thoiGian,
                'time':$time,
                'id':$id,
                'khoaHoc':$khoaHoc,
                'note':$note
            },
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Cập nhật PT", "Cập nhật thành công!!!");
                    setTimeout(function(){
                        window.location = "{!! route('getPhongVan') !!}";
                    }, 2000);
                } else if (data == 2) {
                    KiemTra("Cập nhật PT", "Bạn không có quyền Cập nhật!!!");
                }  else {
                    PhatHienLoi('Cập nhật PT', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
             }
            }
        });
        
        return false;
    });
    function getDuLieuLichGiaoVien()
    {
        $thoiGian = $('#date').val();
        $.ajax({
            type: 'get',
            url: '{{ route("getDuLieuLichPT")}}',
            data: 
            {
                'thoiGian':$thoiGian
            }
            ,
            success: function(data) {
               document.getElementById('duLieuSearch').innerHTML=data;

                //   alert(data);
            }
        });
    }

    function kiemTraGiaoVien()
    {
        $giaoVien = $('#giaoVien').val();
        $thoiGian = $('#date').val();
        $time = $('#time').val();
        $.ajax({
            type: 'get',
            url: '{{ route("kiemTraGiaoVienphongVan")}}',
            data: 
            {
                'giaoVien':$giaoVien,
                'thoiGian':$thoiGian,
                'time':$time
            }
            ,
            success: function(data) {
             if(data==0)
             {
                 KiemTra("Cập nhật PT","Giáo viên đã trùng lịch")
             }
            }
        });
    }
</script>
@endsection