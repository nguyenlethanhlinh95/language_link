@extends('master.masterAdmin')
@section('title')
Marketing
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm marketing</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Tên marketing <span style="color: red">*</span></label>
                        <input class="form-control" required id="ten" name="ten">
                        <label>Trạng thái <span style="color: red">*</span></label>
                        <select class="form-control" name="trangThai" required>
                            <option value="1">Hoạt động</option>
                            <option value="0">Ngừng Hoạt động</option>

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
                        <h5 class="modal-title">Cập nhật marketing</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Tên marketing <span style="color: red">*</span></label>
                        <input id="id" name="id" hidden>
                        <input class="form-control" required id="ten2" name="ten2">
                        <label>Trạng thái <span style="color: red">*</span></label>
                        <div id="duLieu">
                            <select required class="form-control" id="trangThai2" name="trangThai2">
                                <option value="1">Hoạt động</option>
                                <option value="0">Ngừng Hoạt động</option>
                            </select>
                        </div>
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
                        <h4 class="card-title">Marketing</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search Dashboard" aria-label="Tìm marketing">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen302')==1)
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
                                    <th>Tên marketing</th>
                                    <th>Trạng thái</th>
                                    @if(session('quyen303')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen304')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($marketing as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->marketing_name}}</td>
                                    @if($item->marketing_status==1)
                                    <td>Hoạt động</td>
                                    @else
                                    <td>Ngừng Hoạt Động</td>
                                    @endif
                                    @if(session('quyen303')==1)
                                    <td><a class="btn">
                                            <i style="color: blue" data-toggle="modal" data-target="#basicModal2" onclick="setValue('{{$item->marketing_id}}','{{$item->marketing_name}}',
                                            '{{$item->marketing_status}}')" class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    
                                    @endif
                                    @if(session('quyen304')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->marketing_id }}');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                                @php $i++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <div class="bootstrap-pagination">
                            <nav>
                                <ul class="pagination justify-content-end">
                                    @if($page==1)
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>

                                    </li>
                                    @else <li class="page-item ">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>

                                    </li>
                                    @endif
                                    @for($i=1;$i<=$soTrang;$i++) 
                                    @if($i==$page) 
                                        <li id="page{{$i}}" class="page-item active">
                                            <a onclick="searchPage('{{$i}}')" class="page-link" >{{$i}}</a>
                                        </li>
                                        @else
                                        <li id="page{{$i}}" class="page-item">
                                            <a onclick="searchPage('{{$i}}')" class="page-link">{{$i}}</a>
                                        </li>
                                        @endif
                                        @endfor

                                        @if($page==1)
                                        <li class="page-item disabled">
                                            <a class="page-link">Next</a>
                                        </li>
                                        @else 
                                        <li class="page-item">
                                            <a class="page-link" >Next</a>
                                        </li>
                                        @endif
                                </ul>
                            </nav>
                        </div>
                        <input hidden id="pageSelect" value="1">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>
    function search() {
        
        $pageSelect = $('#pageSelect').val();
        $value = $('#valueSearch').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchPageMarketing")}}',
            data: {
                'value': $value,
                'page': $pageSelect
            },
            success: function(data) {
                document.getElementById('duLieuSearch').innerHTML = data;

            }
        });
    }
    function searchPage(page) {
        $pageSelect = $('#pageSelect').val();
        document.getElementById('page'+$pageSelect).className="page-item";

        document.getElementById('page'+page).className="page-item active";
        $('#pageSelect').val(page);
        $value = $('#valueSearch').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchPageMarketing")}}',
            data: {
                'value': $value,
                'page':page
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
                            url: '{{ route("xoaMarketing")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getMarketing')}}";
                                } else if (data == 1) {
                                    KiemTra("Xóa marketing", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa marketing", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id, ten, trangThai) {
        $('#id').val(id);
        $('#ten2').val(ten);
        $('#trangThai2').val(trangThai);
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{ route("postThemMarketing")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm marketing", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getMarketing')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm marketing", "Bạn không có quyền thêm!!!");
                } else {
                    PhatHienLoi('Thêm marketing', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{ route("postCapNhatMarketing")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật marketing", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getMarketing')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật marketing", "Bạn không có quyền cập nhật!!!");
                } else {
                    PhatHienLoi('Thêm marketing', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection