@extends('master.masterAdmin')
@section('title')
Lớp học
@endsection
@section('contain')
<div class="content-body">

   
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Lớp học</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search Dashboard" aria-label="Tìm lớp học">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen62')==1)
                            <a href="{{route('getThemLopHoc')}}">
                                <button type="button" class="btn mb-1 btn-outline-success"
                                 style="float: right">Thêm mới</button>
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
                                    <th>Chương trình học</th>
                                    <th>Mã lớp học</th>
                                    <th>Tên lớp học</th>
                                    <th>Ngày khai giảng</th>
                                    <th>Ngày kết khóa</th>
                                    <th>Sĩ số</th>
                                    <th>Giáo viên</th>
                                    <th>Trợ giảng</th>
                                    <th>Quản lý lớp</th>
                                    <th>Số buổi còn lại</th>
                                    <th>Tình trạng lớp học</th>
                                    @if(session('quyen63')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen64')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=0; @endphp
                                @foreach($lopHoc as $item)
                                <tr>
                                    <td>@php echo $i+1; @endphp</td>
                                    <td>{{$item['chuongTrinh']}}</td>
                                    <td>{{$item['maLop']}}</td>
                                    @if(session('quyen71')==1)
                                    <td><a href="{{route('getHocVienLopHoc')}}?id={{$item['id']}}">{{$item['tenLop']}}</a></td>
                                    @else
                                    <td>{{$item['tenLop']}}</td>
                                    @endif
                                  
                                    <td>{{$item['ngayBatDau']}}</td>
                                    <td>{{$item['ngayKetKhoa']}}</td>
                                    <td>{{$item['siSo']}}</td>
                                    <td>{{$item['giaoVien']}}</td>
                                    <td>{{$item['troGiang']}}</td>
                                    <td>{{$item['nhanVien']}}</td>
                                    <td>{{$item['soBuoiConLai']}}</td>
                                     @if($item['tinhTrang']==1)
                                        <td>Waiting</td>
                                     @elseif($item['tinhTrang']==2)
                                        <td>Opening</td>
                                    @elseif($item['tinhTrang']==3)
                                        <td>Finished</td>
                                        @else
                                        <td>Canceled</td>
                                     @endif
                                    @if(session('quyen63')==1)
                                      <td>
                                            <a class="btn" href="{{ route('capNhatLopHoc') }}?id={{$item['id']}}">
                                                <i style="color: blue"  class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    @endif
                                    @if(session('quyen64')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item['id']}}');">
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

function quaHan()
{
    KiemTra("","Lớp học đã bắt đầu");
}

       function search() {

$pageSelect = $('#pageSelect').val();
document.getElementById('page' + $pageSelect).className = "page-item";

document.getElementById('page1').className = "page-item active";
$('#pageSelect').val(1);

$value = $('#valueSearch').val();
$.ajax({
    type: 'get',
    url: '{{ route("searchLopHoc")}}',
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
    url: '{{ route("searchLopHoc")}}',
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
                            url: '{{route("getXoaLopHoc")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getLopHoc')}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa lớp học", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa lớp học", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id, ten,ma, noiDung,so) {
        $('#id').val(id);
        $('#ten2').val(ten);
        $('#ma2').val(ma);
        $('#noiDung2').val(noiDung);
        $('#so2').val(so);
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
                    ThemThanhCong("Thêm lớp học", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getChuongTrinhHoc')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm lớp học", "Bạn không có quyền thêm!!!");
                }

                else if (data == 3) {
                    KiemTra("Thêm lớp học", "Mã lớp học đã tồn tại!!!");
                }                 else {
                    PhatHienLoi('Thêm lớp học', "Lỗi Kết Nối!!!");
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
                    CapNhatThanhCong("Cập nhật lớp học", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getChuongTrinhHoc')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật lớp học", "Bạn không có quyền cập nhật!!!");
                } 
                else if (data == 3) {
                    KiemTra("Cập nhật lớp học", "Mã lớp học đã tồn tại!!!");
                } 
                else {
                    PhatHienLoi('Thêm lớp học', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection