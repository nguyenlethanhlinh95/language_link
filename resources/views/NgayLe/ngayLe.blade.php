@extends('master.masterAdmin')
@section('title')
ngày lễ
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm ngày lễ</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Tên ngày lễ <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten" name="ten">
                        
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <label>Ngày bắt đầu <span style="color: red">*</span></label>
                                <div class="input-group">
                                    <input type="text" required class="form-control" id="ngayBatDau"  
                                    name="ngayBatDau" placeholder="mm/dd/yyyy" > 
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="mdi mdi-calendar-check">
                                                </i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                         
                            <div class="col-lg-16 col-sm-6">
                                <label>Ngày kết thúc <span style="color: red">*</span></label>
                                <div class="input-group">
                                    <input type="text" required class="form-control" id="ngayKetThuc" 
                                    name="ngayKetThuc" placeholder="mm/dd/yyyy" > 
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="mdi mdi-calendar-check">
                                                </i>
                                        </span>
                                    </span>
                                </div>
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
                        <h5 class="modal-title">Cập nhật ngày lễ</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                        <input id="id" name="id" hidden>
                        <label>Tên ngày lễ <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten2" name="ten2">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <label>Ngày bắt đầu <span style="color: red">*</span></label>
                                <div class="input-group">
                                    <input type="text" required class="form-control" id="ngayBatDau2"  
                                    name="ngayBatDau2" placeholder="mm/dd/yyyy" > 
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="mdi mdi-calendar-check">
                                                </i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                         
                            <div class="col-lg-16 col-sm-6">
                                <label>Ngày kết thúc <span style="color: red">*</span></label>
                                <div class="input-group">
                                    <input type="text" required class="form-control" id="ngayKetThuc2" 
                                    name="ngayKetThuc2" placeholder="mm/dd/yyyy" > 
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="mdi mdi-calendar-check">
                                                </i>
                                        </span>
                                    </span>
                                </div>
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
                        <h4 class="card-title">Ngày lễ</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Tìm ngày lễ" aria-label="Tìm marketing">
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
                                    <th>Tên ngày lễ</th>
                                    <th>Ngày bắt đầu </th>
                                    <th>Ngày kết thuc </th>
                                    @if(session('quyen323')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen324')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($ngayLe as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                  
                                    <td>{{$item->holiday_name}}</td>
                                   
                                    <td>{{date('d/m/Y',strtotime($item->holiday_startDate)) }}</td>
                                    <td>{{date('d/m/Y',strtotime($item->holiday_endDate))}}</td>
                                    @if(session('quyen323')==1)
                                    <td><a class="btn" data-toggle="modal" data-target="#basicModal2"
                                             onclick="setValue('{{$item->holiday_id}}','{{$item->holiday_name}}',
                                           '{{date('m/d/Y',strtotime($item->holiday_startDate))}}','{{date('m/d/Y',strtotime($item->holiday_endDate))}}')">
                                            <i style="color: blue"  class="fa fa-edit"></i>
                                        </a>        
                                    </td>
                                    
                                    @endif
                                    @if(session('quyen324')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->holiday_id}}');">
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
<script src="{{asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    
<script>

(function($) {
    "use strict"

    jQuery('.mydatepicker, #datepicker').datepicker();
        jQuery('#ngayBatDau').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#ngayKetThuc').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#ngayBatDau2').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#ngayKetThuc2').datepicker({
            autoclose: true,
            todayHighlight: true
        });
})(jQuery);
function search() {
        
        $pageSelect = $('#pageSelect').val();
        $value = $('#valueSearch').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchPageNgayLe")}}',
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
            url: '{{ route("searchPageNgayLe")}}',
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
                            url: '{{route("getXoaNgayLe")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getNgayLe')}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa ngày lễ", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa ngày lễ", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id, ten,ngay, thang) {
        $('#id').val(id);
        $('#ten2').val(ten);
        $('#ngayBatDau2').val(ngay);
        $('#ngayKetThuc2').val(thang);
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemNgayLe")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm ngày lễ", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getNgayLe')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm ngày lễ", "Bạn không có quyền thêm!!!");
                }
                else {
                    PhatHienLoi('Thêm ngày lễ', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatNgayLe")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật ngày lễ", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getNgayLe')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật ngày lễ", "Bạn không có quyền cập nhật!!!");
                } 
                else if (data == 3) {
                    KiemTra("Cập nhật ngày lễ", "Mã ngày lễ đã tồn tại!!!");
                } 
                else {
                    PhatHienLoi('Thêm ngày lễ', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection