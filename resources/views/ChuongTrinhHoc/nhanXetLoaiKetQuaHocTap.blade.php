@extends('master.masterAdmin')
@section('title')
Bài Giảng
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm loại kết quả học tập</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id" name="id" hidden value="{{$ketQuaHocTap->learningOutcomeType_id}}">
                        <label>Nhận xét  <span style="color: red">*</span></label>
                        <select class="form-control" required name="nhanXet" id="nhanXet">
                            @foreach($nhanXet as $item)
                            <option value="{{ $item->commentDetail_id }}">{{ $item->comment_name }} - {{ $item->commentDetail_name }}</option>
                            @endforeach
                        </select>
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
                        <h5 class="modal-title">Cập nhật loại kết quả học tập</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id2" name="id2" hidden value="{{$ketQuaHocTap->learningOutcomeType_id}}">
                        <input id="id3" name="id3" hidden value="">
                        <label>Nhận xét  <span style="color: red">*</span></label>
                        <select class="form-control" required name="nhanXet2" id="nhanXet2">
                            @foreach($nhanXet as $item)
                            <option value="{{ $item->commentDetail_id }}">{{ $item->comment_name }} - {{ $item->commentDetail_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">kết quả học tập: {{$ketQuaHocTap->learningOutcomeType_name}}</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                {{-- <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search kết quả" aria-label="Tìm chương trình">
                                </div> --}}
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen142')==1)
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
                                    <th>Nhận Xét</th>
                                    <th>Chi tiết</th>
                                   
                                    @if(session('quyen143')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen144')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($nhanXetKetQua as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->comment_name}}</td>
                                    <td>{{$item->commentDetail_name}}</td>
                                  
                                    @if(session('quyen143')==1)
                                
                                    <td><a class="btn" data-toggle="modal" data-target="#basicModal2"
                                        onclick="setValue('{{ $item->learningOutcomeTypeComment_id }}','{{ $item->commentDetail_id }}');" >

                                            <i style="color: blue" 
                                             class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    @endif
                                    @if(session('quyen144')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->learningOutcomeTypeComment_id}}');">
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
    $idKhoaHoc = {{ $ketQuaHocTap->learningOutcomeType_id}};
    $.ajax({
        type: 'get',
        url: '{{route("searchLoaiKetQuaHocTap")}}',
        data: {
            'value': $value,
            'idKhoaHoc':$idKhoaHoc
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
                            url: '{{route("getXoaNhanXetKetQuaHocTap")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getNhanXetKetQuaHocTap')}}?id={{$ketQuaHocTap->learningOutcomeType_id}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa kết quả học tập", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa kết quả học tập", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id, ten) {
        $('#id3').val(id);
        $('#nhanXet2').val(ten);
      
      
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemNhanXetLoaiKetQuaHocTap")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm loại kết quả học tập", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getNhanXetKetQuaHocTap')}}?id={{$ketQuaHocTap->learningOutcomeType_id}}";
                    }, 2000);
                } else if (data == 2) {
                    KiemTra("Thêm loại kết quả học tập", "Bạn không có quyền thêm!!!");
                }      
                else if (data == 3) {
                    KiemTra("Thêm loại kết quả học tập", "Nhận xét đã tồn tại!!!");
                }            
                else {
                    PhatHienLoi('Thêm loại kết quả học tập', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatNhanXetLoaiKetQuaHocTap")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật loại kết quả học tập", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getNhanXetKetQuaHocTap')}}?id={{$ketQuaHocTap->learningOutcomeType_id}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật loại kết quả học tập", "Bạn không có quyền cập nhật!!!");
                } 
                else if (data == 3) {
                    KiemTra("Cập nhật loại kết quả học tập", "Nhận xét đã tồn tại!!!");
                } 
                else {
                    PhatHienLoi('Thêm loại kết quả học tập', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection