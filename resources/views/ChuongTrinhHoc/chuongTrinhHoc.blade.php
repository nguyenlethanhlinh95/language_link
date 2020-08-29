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
                        <label>Tên chương trình  <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten" name="ten">
                        <label>Mã chương trình  <span style="color: red">*</span></label>
                        <input maxlength="10" class="form-control" required id="ma" name="ma">
                        <label>Nội dung  <span style="color: red">*</span></label>
                        <input maxlength="100" class="form-control" required id="noiDung" name="noiDung">
                        <label>Số hiển thị  <span style="color: red">*</span></label>
                        <input type="number" class="form-control" required id="so" name="so">
                        <label>Chi nhánh  <span style="color: red">*</span></label>
                       <select class="form-control" id="chiNhanh" name="chiNhanh" required>
                           @foreach($chiNhanh as $item)
                        <option value="{{ $item->branch_id }}">{{ $item->branch_name }}</option>
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
                        <h5 class="modal-title">Cập nhật chương trình</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                        <input id="id" name="id" hidden>
                        <label>Tên chương trình  <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten2" name="ten2">
                        <label>Mã chương trình <span style="color: red">*</span></label>
                        <input maxlength="10" class="form-control" required id="ma2" name="ma2">
                        <label>Nội dung <span style="color: red">*</span></label>
                        <input maxlength="100" class="form-control" required id="noiDung2" name="noiDung2">
                        <label>Số hiển thị <span style="color: red">*</span></label>
                        <input type="number" class="form-control" required id="so2" name="so2">
                        <label>Chi nhánh <span style="color: red">*</span></label>
                        <select class="form-control" required id="chiNhanh2" name="chiNhanh2">
                            @foreach($chiNhanh as $item)
                         <option value="{{ $item->branch_id }}">{{ $item->branch_name }}</option>
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
                        <h4 class="card-title">Chương trình học</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search chương trình học" aria-label="Tìm chương trình">
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
                                    <th>Chi nhánh</th>
                                    <th>Tên chương trình</th>
                                    <th>Mã chương trình</th>
                                    <th>Nội dung</th>
                                    <th>Số hiển thị</th>
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
                                @foreach($chuongTrinh as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                     
                                    <td>{{$item->branch_code}}</td>
                                    @if(session('quyen51')==1)
                                    <td><a href="{{route('getKhoaHoc')}}?id={{$item->studyProgram_id}}">
                                    {{$item->studyProgram_name}}
                                    </a></td>
                                    @else
                                    <td>{{$item->studyProgram_name}}</td>
                                    @endif
                                   
                                    <td>{{$item->studyProgram_code}}</td>
                                    <td>{{$item->studyProgram_detail}}</td>
                                    <td>{{$item->studyProgram_number}}</td>
                                    @if(session('quyen43')==1)
                                    <td><a class="btn"  data-toggle="modal" data-target="#basicModal2"
                                        onclick="setValue('{{$item->studyProgram_id}}','{{$item->studyProgram_name}}',
                                      '{{$item->studyProgram_code}}','{{$item->studyProgram_detail}}'
                                      ,'{{$item->studyProgram_number}}','{{$item->branch_id}}')">
                                            <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    
                                    @endif
                                    @if(session('quyen44')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->studyProgram_id}}');">
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
     function search() {

$pageSelect = $('#pageSelect').val();
document.getElementById('page' + $pageSelect).className = "page-item";

document.getElementById('page1').className = "page-item active";
$('#pageSelect').val(1);

$value = $('#valueSearch').val();
$.ajax({
    type: 'get',
    url: '{{ route("searchChuongTrinh")}}',
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
    url: '{{ route("searchChuongTrinh")}}',
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
                            url: '{{route("getXoaChuongTrinhHoc")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getChuongTrinhHoc')}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa chương trình", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa chương trình", "Lỗi Kết kết nối!!!!");
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
                    ThemThanhCong("Thêm chương trình", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getChuongTrinhHoc')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm chương trình", "Bạn không có quyền thêm!!!");
                }

                else if (data == 3) {
                    KiemTra("Thêm chương trình", "Mã chương trình đã tồn tại!!!");
                }                 else {
                    PhatHienLoi('Thêm chương trình', "Lỗi Kết Nối!!!");
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
                    CapNhatThanhCong("Cập nhật chương trình", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getChuongTrinhHoc')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật chương trình", "Bạn không có quyền cập nhật!!!");
                } 
                else if (data == 3) {
                    KiemTra("Cập nhật chương trình", "Mã chương trình đã tồn tại!!!");
                } 
                else {
                    PhatHienLoi('Thêm chương trình', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection