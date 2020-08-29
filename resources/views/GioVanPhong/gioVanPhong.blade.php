@extends('master.masterAdmin')
@section('title')
Khung giờ
@endsection
@section('contain')
<div class="content-body">
    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm khung giờ</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Phòng ban  <span style="color: red">*</span></label>
                        <select class="form-control" name="phongBan" required id="phongBan">
                            @foreach($phongBan as $item)
                            <option value="{{ $item->department_id }}">{{ $item->department_name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label>Giờ bắt đầu  <span style="color: red">*</span></label>
                                <div class="input-group clockpicker">
                                    <input required type="text" class="form-control" value="09:00"    name="gioBatDau" id="gioBatDau" > 
                                    <span class="input-group-append"><span class="input-group-text">
                                        <i class="fa fa-clock-o"></i></span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label>Giờ kết thúc  <span style="color: red">*</span></label>
                                <div class="input-group clockpicker">
                                    <input required type="text" class="form-control" value="11:00"   name="gioKetThuc" id="gioKetThuc" > 
                                    <span class="input-group-append"><span class="input-group-text">
                                        <i class="fa fa-clock-o"></i></span></span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <label>Ca làm việc <span style="color: red">*</span></label>
                        <select class="form-control" name="ca" id="ca" required>
                            <option value="1">Ca 1</option>
                            <option value="2">Ca 2</option>
                            <option value="3">Ca 3</option>
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
                        <h5 class="modal-title">Cập nhật khung giờ</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                        <input id="id" name="id" hidden>
                        <label>Phòng ban <span style="color: red">*</span></label>
                        <select class="form-control" required name="phongBan2" id="phongBan2">
                            @foreach($phongBan as $item)
                            <option value="{{ $item->department_id }}">{{ $item->department_name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label>Giờ bắt đầu <span style="color: red">*</span></label>
                                <div class="input-group clockpicker">
                                    <input required type="text" class="form-control" value="09:00"    name="gioBatDau2" id="gioBatDau2" > 
                                    <span class="input-group-append"><span class="input-group-text">
                                        <i class="fa fa-clock-o"></i></span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label>Giờ kết thúc <span style="color: red">*</span></label>
                                <div class="input-group clockpicker">
                                    <input required type="text" class="form-control" value="11:00"   name="gioKetThuc2" id="gioKetThuc2" > 
                                    <span class="input-group-append"><span class="input-group-text">
                                        <i class="fa fa-clock-o"></i></span></span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <label>Ca làm việc <span style="color: red">*</span></label>
                        <select class="form-control" name="ca2" id="ca2" required>
                            <option value="1">Ca 1</option>
                            <option value="2">Ca 2</option>
                            <option value="3">Ca 3</option>
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
                        <h4 class="card-title">LỊCH VĂN PHÒNG</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                {{-- <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" 
                                    placeholder="Search tên nhân viên" aria-label="Tìm marketing">
                                </div> --}}
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                               
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Chi nhánh</th>
                                    <th>Phòng ban</th>
                                    <th>Nhân viên</th>
                                    @if(session('quyen4221')==1)
                                    <th>Lịch tháng</th>
                                    @endif
                                    @if(session('quyen4211')==1)
                                    <th>Lịch tuần</th>
                                    @endif
                                    @if(session('quyen441')==1)
                                    <th>Nghỉ phép</th>
                                    @endif
                                    @if(session('quyen4241')==1)
                                    <th>Xem lịch</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($nhanVien as $item)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $item->branch_code }}</td>
                                    <td>{{ $item->department_name }}</td>
                                    <td>{{ $item->employee_name }}</td>
                                    @if(session('quyen4221')==1)
                                    <td><a href="{{ route('getXepLichThang') }}?id={{ $item->employee_id }}"><i class="fa fa-calendar"></i></a></td>
                                    @endif
                                    @if(session('quyen4211')==1)
                                    <td><a href="{{ route('getXepLicVanPhong') }}?id={{ $item->employee_id }}"><i class="fa fa-calendar"></i></a></td>
                                    @endif
                                    @if(session('quyen441')==1)
                                    <td><a   href="{{ route('getNghiPhepNhanVien') }}?id={{ $item->employee_id }}"><i class="fa fa-calendar-plus-o  "></i></a></td>
                                    @endif
                                    @if(session('quyen4241')==1)
                                    <td><a href="{{ route('getXemLichVanPhong') }}?id={{ $item->employee_id }}"><i class="fa fa-search"></i></a></td>
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
    function setValue(id,phongBan,ca,gioBatDau,gioKetThuc)
    {
        $('#id').val(id);
        $('#phongBan2').val(phongBan);
        $('#ca2').val(ca);
        $('#gioBatDau2').val(gioBatDau);
        $('#gioKetThuc2').val(gioKetThuc);

        
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
                            url: '{{route("getXoaKhungGio")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getKhungGio')}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa khung giờ", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa khung giờ", "Lỗi Kết kết nối!!!!");
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
            url: '{{route("postThemKhungGio")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm khung giờ", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getKhungGio')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm khung giờ", "Bạn không có quyền thêm!!!");
                }

                else if (data == 3) {
                    KiemTra("Thêm khung giờ", "Mã khung giờ đã tồn tại!!!");
                }                 else {
                    PhatHienLoi('Thêm khung giờ', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatKhungGio")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật khung giờ", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getKhungGio')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật khung giờ", "Bạn không có quyền cập nhật!!!");
                } 
                else if (data == 3) {
                    KiemTra("Cập nhật khung giờ", "Mã khung giờ đã tồn tại!!!");
                } 
                else {
                    PhatHienLoi('Thêm khung giờ', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection