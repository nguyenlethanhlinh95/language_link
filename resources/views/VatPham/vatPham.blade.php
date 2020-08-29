@extends('master.masterAdmin')
@section('title')
cơ sở vật chất
@endsection
@section('contain')
<div class="content-body">
    <style>
      
        .myCheckBox:after{
            border: 1px solid black !important;
        }
        </style>
    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm cơ sở vật chất</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Tên cơ sở vật chất <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten" name="ten">
                        {{-- <label>Giá mua</label>
                        <input maxlength="30" type="number" class="form-control" required id="giaMua" name="giaMua">
                        
                        <label>Giá bán</label>
                        <input maxlength="30" type="number" class="form-control" required id="gia" name="gia"> --}}
                        
                        <label>Đơn vị tính <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="donVi" name="donVi">
                        
                       
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
                        <h5 class="modal-title">Cập nhật cơ sở vật chất</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                        <input id="id" name="id" hidden>
                        <label>Tên cơ sở vật chất <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten2" name="ten2">
                        {{-- <label>Giá mua</label>
                        <input maxlength="30" type="number" class="form-control" required id="giaMua2" name="giaMua2">
                        <label>Giá bán</label>
                        <input maxlength="30" type="number" class="form-control" required id="gia2" name="gia2">
                         --}}
                        <label>Đơn vị tính <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="donVi2" name="donVi2">
                      
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
                        <h4 class="card-title">Cơ sở vật chất</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Tìm cơ sở vật chất" aria-label="Tìm cơ sở vật chất">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen212')==1)
                                <button type="button" class="btn mb-1 btn-outline-success" 
                                data-toggle="modal" data-target="#basicModal" style="float: right">Thêm mới</button>
                            @endif
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                            
                                    <th>Tên cơ sở vật chất</th>
                                
                                    <th>Đơn vị</th>
                                    @if(session('quyen213')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen214')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($vatPham as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->item_name}}</td>
                                    
                                  
                                    <td>{{$item->item_unit}}</td>
                                  
                                    @if(session('quyen213')==1)
                                    <td><a class="btn"  data-toggle="modal" data-target="#basicModal2"
                                        onclick="setValue('{{$item->item_id}}','{{$item->item_name}}'
                                        
                                        ,'{{$item->item_unit}}')">
                                            <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    
                                    @endif
                                    @if(session('quyen214')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->item_id}}');">
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
    url: '{{ route("searchVatPham")}}',
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
    url: '{{ route("searchVatPham")}}',
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
                            url: '{{route("getXoaVatPham")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getVatPham')}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa cơ sở vật chất", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa cơ sở vật chất", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id, ten,donVi) {
        $('#id').val(id);
        $('#ten2').val(ten);
       
        // $('#gia2').val(gia);
        $('#donVi2').val(donVi);
        // $('#giaMua2').val(giaMua);
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemVatPham")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm cơ sở vật chất", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getVatPham')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm cơ sở vật chất", "Bạn không có quyền thêm!!!");
                }

                else if (data == 3) {
                    KiemTra("Thêm cơ sở vật chất", "Mã cơ sở vật chất đã tồn tại!!!");
                }                 else {
                    PhatHienLoi('Thêm cơ sở vật chất', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatVatPham")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật cơ sở vật chất", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getVatPham')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật cơ sở vật chất", "Bạn không có quyền cập nhật!!!");
                } 
                else if (data == 3) {
                    KiemTra("Cập nhật cơ sở vật chất", "Mã cơ sở vật chất đã tồn tại!!!");
                } 
                else {
                    PhatHienLoi('Thêm cơ sở vật chất', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection