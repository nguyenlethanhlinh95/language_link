@extends('master.masterAdmin')
@section('title')
Nghỉ phép
@endsection
@section('contain')
<div class="content-body">
    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm nghỉ phép</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Phòng ban <span style="color: red">*</span></label>
                        <select class="form-control" name="phongBan" id="phongBan" required>
                            @foreach($phongBan as $item)
                            <option value="{{ $item->department_id }}">{{ $item->department_name }}</option>
                            @endforeach
                        </select>
                       <label>Tên nghỉ phép <span style="color: red">*</span></label>
                       <input required class="form-control" name="ten" id="ten" maxlength="200">
                       <label>Mã <span style="color: red">*</span></label>
                       <input required class="form-control" name="ma" id="ma" maxlength="200">
                       <label>Giờ nghỉ <span style="color: red">*</span></label>
                       <input required type="number" class="form-control" name="gio" id="gio" >
                        <br>

                        <div class="row">
                            <div class="col-6">
                                <input   type="checkbox" name="ngayLe" id="ngayLe">&nbsp; Ngày lễ
                            </div>
                            <div class="col-6">
                                <input   type="checkbox" name="motNgay" id="motNgay">&nbsp; Một ngày
                            </div>
                         </div>
                        
                        
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
                        <h5 class="modal-title">Cập nhật nghỉ phép</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                        <input id="id" name="id" hidden>
                        <label>Phòng ban</label>
                        <select class="form-control" name="phongBan2" id="phongBan2">
                            @foreach($phongBan as $item)
                            <option value="{{ $item->department_id }}">{{ $item->department_name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <label>Tên nghỉ phép <span style="color: red">*</span></label>
                       <input class="form-control" name="ten2" id="ten2" maxlength="200">
                       <label>Mã <span style="color: red">*</span></label>
                       <input class="form-control" name="ma2" id="ma2" maxlength="200">
                       <label>Giờ nghỉ <span style="color: red">*</span></label>
                       <input type="number" class="form-control" name="gio2" id="gio2" >
                        <br>

                         <div class="row">
                            <div class="col-6">
                                <input   type="checkbox" name="ngayLe2" id="ngayLe2">&nbsp; Ngày lễ
                            </div>
                            <div class="col-6">
                                <input   type="checkbox" name="motNgay2" id="motNgay2">&nbsp; Một ngày
                            </div>
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
                        <h4 class="card-title">Nghỉ phép </h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" 
                                    placeholder="Search tên phòng ban" aria-label="Tìm marketing">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                @if(session('quyen402')==1)
                                <a data-toggle="modal" data-target="#basicModal">
                                    <button type="button" class="btn mb-1 btn-outline-success" style="float: right">Thêm mới</button>
                                </a>
                                @endif
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Phòng ban</th>
                                    <th>Tên</th>
                                    <th>Mã</th>
                                    <th>Số giờ</th>
                                    <th>Ngày lễ</th>
                                    <th>Một ngày</th>
                                    @if(session('quyen403')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen404')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($nghiPhep as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->department_name}}</td>
                                    <td> {{ $item->applicationLeave_name }}</td>
                                  
                                    <td>{{ $item->applicationLeave_code }}</td>
                                    <td>{{ $item->applicationLeave_number }}</td>
                                    @if($item->applicationLeave_type==1 )
                                    <td><input checked disabled type="checkbox" ></td>
                                    @else 
                                    <td><input type="checkbox" disabled></td>
                                    @endif
                                    @if($item->applicationLeave_isDate==1 )
                                    <td><input checked disabled type="checkbox" ></td>
                                    @else 
                                    <td><input type="checkbox" disabled></td>
                                    @endif
                                    @if(session('quyen403')==1)
                                    <td><a class="btn" data-toggle="modal" data-target="#basicModal2"  
                                        onclick="setValue('{{$item->applicationLeave_id}}','{{$item->department_id}}','{{$item->applicationLeave_name}}'
                                        ,'{{$item->applicationLeave_code}}','{{$item->applicationLeave_number}}'
                                        ,'{{$item->applicationLeave_type}}','{{ $item->applicationLeave_isDate }}');">
                                            <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    @endif
                                    @if(session('quyen404')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->applicationLeave_id}}');">
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
                                    @for($i=1;$i<=$soTrang;$i++) @if($i==$page) <li id="page{{$i}}" class="page-item active">
                                        <a onclick="searchPage('{{$i}}')" class="page-link">{{$i}}</a>
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
                                            <a class="page-link">Next</a>
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
    function setValue(id,phongBan,ca,gioBatDau,gioKetThuc,thu,ngay)
    {
        $('#id').val(id);
        $('#phongBan2').val(phongBan);
        $('#ten2').val(ca);
        $('#ma2').val(gioBatDau);
        $('#gio2').val(gioKetThuc);
       if(thu==1)
        $('#ngayLe2').prop('checked', true);
        else
        $('#ngayLe2').prop('checked', false);

        if(ngay==1)
        $('#motNgay2').prop('checked', true);
        else
        $('#motNgay2').prop('checked', false);
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
                            url: '{{route("getXoaNghiPhep")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getNghiPhep')}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa nghỉ phép", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa nghỉ phép", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function search() {

        $pageSelect = $('#pageSelect').val();
        document.getElementById('page' + $pageSelect).className = "page-item";

        document.getElementById('page1').className = "page-item active";
        $('#pageSelect').val(1);

        $value = $('#valueSearch').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchKhungGio")}}',
            data: {
                'value': $value,
                'page': 1
            },
            success: function(data) {
                document.getElementById('duLieuSearch').innerHTML = data;

            }
        });
    }

    function searchPage(page) {
        $pageSelect = $('#pageSelect').val();
        document.getElementById('page' + $pageSelect).className = "page-item";

        document.getElementById('page' + page).className = "page-item active";
        $('#pageSelect').val(page);
        $value = $('#valueSearch').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchKhungGio")}}',
            data: {
                'value': $value,
                'page': page
            },
            success: function(data) {
                document.getElementById('duLieuSearch').innerHTML = data;

            }
        });
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemNghiPhep")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm nghỉ phép", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getNghiPhep')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm nghỉ phép", "Bạn không có quyền thêm!!!");
                }

                else if (data == 3) {
                    KiemTra("Thêm nghỉ phép", "Mã nghỉ phép đã tồn tại!!!");
                }                 else {
                    PhatHienLoi('Thêm nghỉ phép', "Lỗi Kết Nối!!!");
                }

                //  alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatNghiPhep")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật nghỉ phép", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getNghiPhep')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật nghỉ phép", "Bạn không có quyền cập nhật!!!");
                } 
                else if (data == 3) {
                    KiemTra("Cập nhật nghỉ phép", "Mã nghỉ phép đã tồn tại!!!");
                } 
                else {
                    PhatHienLoi('Thêm nghỉ phép', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection