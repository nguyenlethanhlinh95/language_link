@extends('master.masterAdmin')
@section('title')
phòng học
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm phòng học</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id" name="id" hidden value="{{$chiNhanh->branch_id}}">
                        <label>Tên phòng học <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten" name="ten">
                      
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
                        <h5 class="modal-title">Cập nhật phòng học</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                        <input id="id2" name="id2" hidden>
                        <label>Tên phòng học <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten2" name="ten2">
                     
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
                        <h4 class="card-title">Chi nhánh: {{$chiNhanh->branch_name}} </h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                {{-- <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search Dashboard" aria-label="Tìm phòng học">
                                </div> --}}
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen342')==1)
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
                                   
                                    <th>Tên phòng học</th>
                                    @if(session('quyen343')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen344')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($phongHoc as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>                        
                                
                                    <td>{{$item->room_name}}</td>
                                  
                                    @if(session('quyen343')==1)
                                    <td><a class="btn" data-toggle="modal" data-target="#basicModal2"
                                        onclick="setValue('{{$item->room_id}}','{{$item->room_name}}')">
                                            <i style="color: blue"  class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    
                                    @endif
                                    @if(session('quyen344')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->room_id}}');">
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
        $.ajax({
            type: 'get',
            url: '{{route("searchChuongTrinh")}}',
            data: {
                'value': $value
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
                            url: '{{route("getXoaPhongHoc")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getPhongHoc')}}?id={{$chiNhanh->branch_id}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa phòng học", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa phòng học", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id, ten,ma, noiDung,so) {
        $('#id2').val(id);
        $('#ten2').val(ten);
       
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemPhongHoc")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm phòng học", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getPhongHoc')}}?id={{$chiNhanh->branch_id}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm phòng học", "Bạn không có quyền thêm!!!");
                }

                           else {
                    PhatHienLoi('Thêm phòng học', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatPhongHoc")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật phòng học", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getPhongHoc')}}?id={{$chiNhanh->branch_id}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật phòng học", "Bạn không có quyền cập nhật!!!");
                } 
                else if (data == 3) {
                    KiemTra("Cập nhật phòng học", "Mã phòng học đã tồn tại!!!");
                } 
                else {
                    PhatHienLoi('Thêm phòng học', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection