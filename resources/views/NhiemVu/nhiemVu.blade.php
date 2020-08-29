@extends('master.masterAdmin')
@section('title')
Công việc
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              
                    <div class="modal-header">
                        <h5 class="modal-title">Công việc</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label id="tieuDe">Tiêu đề:</label>
                        <div class="row">
                            <div class="col-6">
                                <label id="startDate">Thời Gian Bắt Đầu</label>
                            </div>
                            <div class="col-6">
                                <label id="endDate">Thời Gian Kết thúc</label>
                            </div>
                            <div class="col-6">
                                <label id="leader">Người chính</label>
                            </div>
                            <div class="col-6">
                                <label id="nguoiNhan">Người tham gia</label>
                            </div>
                        </div>
                        <label id="noiDung">Nội dung</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                      
                    </div>
                
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Công việc</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search Công việc" aria-label="Tìm Công việc">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen512')==1)
                                <a href="{{ route('getThemCongViec') }}"><button type="button" class="btn mb-1 btn-outline-success"  style="float: right">Thêm mới</button></a>
                            @endif
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Tiêu đề</th>
                                    <th>Người chính</th>
                                    <th>Thời gian</th>
                                    <th>Trạng thái</th>
                                    <th>Người tạo</th>
                                    <th>Ghi chú</th>
                                    @if(session('quyen513')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen514')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($nhiemVu as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                     
                                    <td><a onclick="xemNhiemVu({{ $item->task_id }});"     class="btn" data-toggle="modal" data-target="#basicModal">{{$item->task_name}}</a></td>
                                    <td>{{$item->employee_name}}</td>
                                    <td>{{date('d/m/Y',strtotime($item->task_startDate))}} - {{date('d/m/Y',strtotime($item->task_endDate))}}</td>
                                   
                                    <td>{{ $arrTrangThai[$i-1]['trangThai'] }}</td>
                                    <td>{{ $arrTrangThai[$i-1]['nguoiTao'] }}</td>
                                    <td>{{ $item->task_note }}</td>
                                    @if(session('quyen513')==1)
                                    <td><a class="btn" href="{{ route('getCapNhatNhiemVu') }}?id={{ $item->task_id }}"> <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    @endif
                                    @if(session('quyen514')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->task_id}}');">
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
    function xemNhiemVu(id)
    {
        $.ajax({
            type: 'get',
            url: '{{ route("getChiTietNhiemVu")}}',
            data: {
                'id': id
            },
            success: function(data) {
                document.getElementById('tieuDe').innerHTML = "<b>Tiêu Đề:</b> " +data[0]['tieuDe'];
                document.getElementById('startDate').innerHTML = "<b>Ngày bắt đầu:</b> " +data[0]['ngayBatDau'];
                document.getElementById('endDate').innerHTML = "<b>Ngày kết thúc:</b> " +data[0]['ngayKetThuc'];
                document.getElementById('leader').innerHTML = "<b>Người chính:</b> " +data[0]['leader'];
                document.getElementById('nguoiNhan').innerHTML = "<b>Người tham gia:</b> " +data[0]['nguoiNhan'];
                document.getElementById('noiDung').innerHTML = "<b>Nội dung:</b> " +data[0]['noiDung'];
            }
        });
    }


    function ketQuaBaiGiang()
    {
        if({{ $sms }}==1)
        {
            ThemThanhCong('Công việc',"Thêm thành công");
        }
        else if({{ $sms }}==2)
        {
            KiemTra('Công việc',"Bạn chưa được cấp quyền");
        }
        else if({{ $sms }}==0)
        {
            PhatHienLoi('Công việc',"Lỗi kết nối vui lòng thực hiện lại!!");
        }
        else if({{ $sms }}==4)
        {
            CapNhatThanhCong('Công việc',"Cập nhật thành công");
        }
    }


     function search() {

$pageSelect = $('#pageSelect').val();
document.getElementById('page' + $pageSelect).className = "page-item";

document.getElementById('page1').className = "page-item active";
$('#pageSelect').val(1);

$value = $('#valueSearch').val();
$.ajax({
    type: 'get',
    url: '{{ route("searchNhiemVu")}}',
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
    url: '{{ route("searchNhiemVu")}}',
    data: {
        'value': $value,
        'page': page
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
                            url: '{{route("getXoaNhiemVu")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getNhiemVu')}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa Công việc", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa Công việc", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id, ten,ma, noiDung,so,chiNhanh) {
        $('#id').val(id);
        $('#ten2').val(ten);
        $('#ma2').val(ma);
        $('#noiDung2').val(noiDung);
        $('#so2').val(so);
        $('#chiNhanh2').val(chiNhanh);
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemChuongTrinHoc")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm Công việc", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getChuongTrinhHoc')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm Công việc", "Bạn không có quyền thêm!!!");
                }

                else if (data == 3) {
                    KiemTra("Thêm Công việc", "Mã Công việc đã tồn tại!!!");
                }                 else {
                    PhatHienLoi('Thêm Công việc', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatChuongTrinhHoc")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật Công việc", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getChuongTrinhHoc')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật Công việc", "Bạn không có quyền cập nhật!!!");
                } 
                else if (data == 3) {
                    KiemTra("Cập nhật Công việc", "Mã Công việc đã tồn tại!!!");
                } 
                else {
                    PhatHienLoi('Thêm Công việc', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection