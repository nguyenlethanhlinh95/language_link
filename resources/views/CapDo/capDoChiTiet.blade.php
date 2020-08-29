@extends('master.masterAdmin')
@section('title')
cấp độ chi tiết
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm cấp độ chi tiết</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <input id="id" name="id" hidden value="{{$capDo->level_id}}">
                        <label>Tên cấp độ chi tiết  <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten" name="ten">
                        <label>Mã cấp độ chi tiết  <span style="color: red">*</span></label>
                        <input maxlength="10" class="form-control" required id="ma" name="ma">
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
                        <h5 class="modal-title">Cập nhật cấp độ chi tiết</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input id="id2" name="id2" hidden>
                        <label>Tên cấp độ chi tiết  <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten2" name="ten2">
                        <label>Mã cấp độ chi tiết  <span style="color: red">*</span></label>
                        <input maxlength="10" class="form-control" required id="ma2" name="ma2">
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
                        <h4 class="card-title">cấp độ: {{$capDo->level_name}}</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search Dashboard" aria-label="Tìm cấp độ chi tiết">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen42')==1)
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
                                    <th>Tên cấp độ</th>
                                    <th>Tên cấp độ chi tiết</th>
                                    <th>Mã cấp độ chi tiết</th>
                                    @if(session('quyen43')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen44')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($capDoChiTiet as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                  
                                    <td>{{$item->level_name}}</td>
                                    <td>{{$item->levelDetail_name}}</td>
                                    <td>{{$item->levelDetail_number}}</td>
                                    @if(session('quyen43')==1)
                                    <td><a class="btn" data-toggle="modal" data-target="#basicModal2"
                                             onclick="setValue('{{$item->levelDetail_id}}','{{$item->levelDetail_name}}',
                                           '{{$item->levelDetail_number}}')">
                                            <i style="color: blue"  class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    
                                    @endif
                                    @if(session('quyen44')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->levelDetail_id}}');">
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
        $id = {{$capDo->level_id}};
        $.ajax({
            type: 'get',
            url: '{{route("searchCapDoChiTiet")}}',
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
                            url: '{{route("getXoaCapDoChiTiet")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getCapDoChiTiet')}}?id={{$capDo->level_id}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa cấp độ chi tiết", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa cấp độ chi tiết", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id, ten,ma) {
        $('#id2').val(id);
        $('#ten2').val(ten);
        $('#ma2').val(ma);
    
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemCapDoChiTiet")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm cấp độ chi tiết", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getCapDoChiTiet')}}?id={{$capDo->level_id}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm cấp độ chi tiết", "Bạn không có quyền thêm!!!");
                }

                else if (data == 3) {
                    KiemTra("Thêm cấp độ chi tiết", "Mã cấp độ chi tiết đã tồn tại!!!");
                }                 else {
                    PhatHienLoi('Thêm cấp độ chi tiết', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatCapDoChiTiet")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật cấp độ chi tiết", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getCapDoChiTiet')}}?id={{$capDo->level_id}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật cấp độ chi tiết", "Bạn không có quyền cập nhật!!!");
                } 
                else if (data == 3) {
                    KiemTra("Cập nhật cấp độ chi tiết", "Mã cấp độ chi tiết đã tồn tại!!!");
                } 
                else {
                    PhatHienLoi('Thêm cấp độ chi tiết', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection