@extends('master.masterAdmin')
@section('title')
phiếu xuất
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
             
                    <div class="modal-header">
                        <h5 class="modal-title">Chi tiết phiếu xuất</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:5px">STT</th>
                                    <th>Vật phẩm</th>
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody id="duLieuChiTiet">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                      
                    </div>
              
            </div>

        </div>
    </div>
    <div class="modal fade" id="basicModal2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform2" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật phiếu xuất</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                        <input id="id" name="id" hidden>
                        <label>Tên phiếu xuất  <span style="color: red">*</span></label>
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
                        <h4 class="card-title">Phiếu xuất Marketing</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search Dashboard" aria-label="Tìm phiếu xuất">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen262')==1)
                            <a href="{{route('getThemPhieuXuatMarketingKho')}}"><button type="button" class="btn mb-1 btn-outline-success" 
                                 style="float: right">Thêm mới</button></a>
                            @endif
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:5px">STT</th>
                                    <th>Nội dung</th>
                                    <th>Thời gian</th>
                                    <th>Người lập</th>
                                    <th>Người nhận</th>
                                    <th>Chi tiết</th>
                                    @if(session('quyen263')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen264')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($phieuXuat as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                   
                                    <td>{{$item->deliveryBill_name}}</td>
                                    <td>{{date('H:i d/m/Y',strtotime( $item->deliveryBill_time)) }}</td>
                                    <td>{{$item->employee_name}}</td>
                                    <td>{{$item->deliveryBill_receiver}}</td>
                                  
                                    <td><a class="btn" onclick="getChiTiet({{$item->deliveryBill_id}});"  data-toggle="modal" data-target="#basicModal">Chi tiết</a></td>
                                   
                                    @if(session('quyen263')==1)
                                    <td><a class="btn" href="{{route('getCapNhatPhieuXuatMarketingKho')}}?id={{$item->deliveryBill_id}}" >
                                                    <i style="color: blue" class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                    @endif
                                   
                                    @if(session('quyen264')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->deliveryBill_id}}');">
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
    function getChiTiet(id)
    {
        $.ajax({
            type: 'get',
            url: '{{route("getChiTietPhieuXuat")}}',
            data: {
                'id': id
            },
            success: function(data) {
                document.getElementById('duLieuChiTiet').innerHTML=data;
                }
            });

    }

    function duyet(id,trangThai)
    {
        $.ajax({
            type: 'get',
            url: '{{route("getDuyetPhieuXuatKho")}}',
            data: {
                'id': id,
                'trangThai':trangThai
            },
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Duyệt phiếu xuất", "Duyệt thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getXuatKho')}}";
                    }, 2000);

                }   
                else if (data == 2)
                {
                        KiemTra('Duyệt phiếu xuất','Bạn không có quyền duyệt!!!');
                }
                else if (data == 3)
                {
                        KiemTra('Duyệt phiếu xuất','Hàng tồn kho không đủ!!!');
                }
                else {
                    PhatHienLoi('Duyệt phiếu xuất', "Lỗi Kết Nối!!!");
                }
            }
        });
    }

    function search() {

$pageSelect = $('#pageSelect').val();
document.getElementById('page' + $pageSelect).className = "page-item";

document.getElementById('page1').className = "page-item active";
$('#pageSelect').val(1);

$value = $('#valueSearch').val();
$.ajax({
    type: 'get',
    url: '{{ route("searchPhieuXuatMarketing")}}',
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
    url: '{{ route("searchPhieuXuatMarketing")}}',
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
                            url: '{{route("getXoaPhieuXuat")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getXuatKhoMarketing')}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa phiếu xuất", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa phiếu xuất", "Lỗi Kết kết nối!!!!");
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
      
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemLoaiCoSoVatChat")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm phiếu xuất", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getLoaiCoSoVatChat')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm phiếu xuất", "Bạn không có quyền thêm!!!");
                }

                else if (data == 3) {
                    KiemTra("Thêm phiếu xuất", "Mã phiếu xuất đã tồn tại!!!");
                }                 else {
                    PhatHienLoi('Thêm phiếu xuất', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatLoaiCoSoVatChat")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật phiếu xuất", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getLoaiCoSoVatChat')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật phiếu xuất", "Bạn không có quyền cập nhật!!!");
                } 
                else if (data == 3) {
                    KiemTra("Cập nhật phiếu xuất", "Mã phiếu xuất đã tồn tại!!!");
                } 
                else {
                    PhatHienLoi('Thêm phiếu xuất', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection