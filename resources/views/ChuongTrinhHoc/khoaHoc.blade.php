@extends('master.masterAdmin')
@section('title')
chương trình
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm chương trình</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id" name="id" hidden value=" {{$chuongTrinhHoc->studyProgram_id}}">
                        <label>Tên khóa học <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten" name="ten">
                        <label>Thời lượng <span style="color: red">*</span></label>
                        <input type="number" class="form-control" required id="gio" name="gio">
                        <label>Giá học phí <span style="color: red">*</span></label>
                        <input type="number" class="form-control" required id="gia" name="gia">
                        <label>Số hiển thị <span style="color: red">*</span></label>
                        <input type="number" class="form-control" required id="so" name="so">
                        <label>Giáo trình </label>
                        <input type="text" class="form-control"  id="giaoTrinh" name="giaoTrinh">
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-success">Thêm mới</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="modal fade" id="basicModal2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform2" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật chương trình</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id2" name="id2" hidden>
                        <input id="idCT" name="idCT" hidden value=" {{$chuongTrinhHoc->studyProgram_id}}">
                        <label>Tên khóa học <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten2" name="ten2">
                        <label>Thời lượng <span style="color: red">*</span></label>
                        <input type="number" class="form-control" required id="gio2" name="gio2">
                       
                        <label>Giá học phí <span style="color: red">*</span></label>
                        <input type="number" class="form-control" required id="gia2" name="gia2">
                        <label>Số hiển thị <span style="color: red">*</span></label>
                        <input type="number" class="form-control" required id="so2" name="so2">
                        <label>Giáo trình </label>
                        <input type="text" class="form-control" id="giaoTrinh2" name="giaoTrinh2">
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
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
                        <h4 class="card-title">Chương trình học: {{$chuongTrinhHoc->studyProgram_name}}</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search Dashboard" aria-label="Tìm chương trình">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen52')==1)
                                <button type="button" class="btn mb-1 btn-outline-success" data-toggle="modal" data-target="#basicModal" style="float: right">Thêm mới</button>
                            @endif
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Mã chương trình</th>
                                    <th>Khóa học</th>
                                    <th>Thời lượng</th>
                                  
                                    <th>Giá học phí</th>
                                    <th>Số hiển thị</th>
                                    <th>Giáo rình</th>
                                    @if(session('quyen81')==1)
                                    <th>Bài giảng</th>
                                    @endif
                                    @if(session('quyen121')==1)
                                    <th>Kết quả</th>
                                    @endif
                                    @if(session('quyen53')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen54')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($khoaHoc as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->studyProgram_code}}</td>
                                    <td>{{$item->course_name}}</td>
                                    <td>{{$item->course_hours}}</td>
                                    
                                    <td>{{number_format($item->course_price,0,"",".") }}đ</td>
                                    <td>{{$item->course_number}}</td>
                                    <td>{{$item->course_material}}</td>
                                    @if(session('quyen81')==1)
                                    <td><a href="{{route('getBaiGiang')}}?id={{$item->course_id}}">Chi tiết</a></td>
                                    @endif
                                    @if(session('quyen121')==1)
                                    <td><a href="{{route('getLoaiKetQuaHocTap')}}?id={{$item->course_id}}">Chi tiết</a></td>
                                    @endif
                                    @if(session('quyen53')==1)

                                    <td><a class="btn">
                                            <i style="color: blue" data-toggle="modal" data-target="#basicModal2"
                                             onclick="setValue('{{$item->course_id}}','{{$item->course_name}}',
                                           '{{$item->course_hours}}','{{$item->course_price}}'
                                           ,'{{$item->course_number}}','{{$item->course_material}}')" class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    @endif
                                    @if(session('quyen54')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->course_id}}');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                                @php $i++; @endphp
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>
    function search() {
    
        $value = $('#valueSearch').val();
        $id = {{$chuongTrinhHoc->studyProgram_id}};
        $.ajax({
            type: 'get',
            url: '{{route("searchKhoaHoc")}}',
            data: {
                'value': $value,
                'id':$id
            },
            success: function(data) {
                document.getElementById('duLieuSearch').innerHTML = data;

            }
        });
    }
   
    function xoa(id) {
        swal({
                title: "BẠN MUỐN XÓA ?",
                text: "HÀNH ĐỘNG NÀY SẼ XÓA TẤT CẢ LIỀN QUAN !!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes !!",
                cancelButtonText: "No !!",
                closeOnConfirm: !1,
                closeOnCancel: !1
            },
            function(e) {
                e ? swal(
                        $.ajax({
                            type: 'get',
                            url: '{{route("getXoaKhoaHoc")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getKhoaHoc')}}?id={{$chuongTrinhHoc->studyProgram_id}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa khóa học", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa khóa học", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id, ten,ma, noiDung,so,giaoTrinh,thoiGian) {
        $('#id2').val(id);
        $('#ten2').val(ten);
        $('#gio2').val(ma);
        $('#gia2').val(noiDung);
        $('#so2').val(so);
        $('#giaoTrinh2').val(giaoTrinh);
        $('#thoiGian2').val(thoiGian);
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemKhoaHoc")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm khóa học", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getKhoaHoc')}}?id={{$chuongTrinhHoc->studyProgram_id}}";
                    }, 2000);
                } else if (data == 2) {
                    KiemTra("Thêm khóa học", "Bạn không có quyền thêm!!!");
                }               
                else {
                    PhatHienLoi('Thêm khóa học', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatKhoaHoc")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật khóa học", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getKhoaHoc')}}?id={{$chuongTrinhHoc->studyProgram_id}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật khóa học", "Bạn không có quyền cập nhật!!!");
                } 
                else {
                    PhatHienLoi('Thêm khóa học', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection