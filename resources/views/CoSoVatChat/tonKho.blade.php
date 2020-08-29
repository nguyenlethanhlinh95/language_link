@extends('master.masterAdmin')
@section('title')
tồn kho
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Nhập kho</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id" name="id" hidden>
                        <label>Số lượng  <span style="color: red">*</span></label>
                        <input maxlength="30" type="number" class="form-control" required id="soLuong" name="soLuong">

                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-success">Cập nhật</button>
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
                        <h5 class="modal-title">Cập nhật tồn kho </h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                        <input id="id2" name="id2" hidden>
                        <label>Số lượng  <span style="color: red">*</span></label>
                        <input maxlength="30" type="number"  class="form-control" required id="soLuong2" name="soLuong2">
                        
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
                        <h4 class="card-title">Tồn kho {{$loaiCSVC->facilityType_name}}</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <label>Chi nhánh</label>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>
                           
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" 
                                    placeholder="Search tên vật phẩm" aria-label="Tìm marketing">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                @if(session('quyen2201')==1)    
                                <select class="form-control" name="chiNhanh" id="chiNhanh" onchange="search();">
                                   <option value="0">Tất cả</option>
                                    @foreach($chiNhanh as $item)
                                    <option value="{{ $item->branch_id }}">{{ $item->branch_name }}</option>
                                    @endforeach
                                </select>
                                @else
                                <input hidden id="chiNhanh" name="chiNhanh" value="{{ session('coSo') }}">
                                @endif
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
                                   
                                    <th>Tên {{$loaiCSVC->facilityType_name}}</th>
                                    <th>Số lượng</th>
                                    {{-- @if(session('quyen172')==1)
                                    <th>Nhập kho</th>
                                    @endif --}}
                                    {{-- @if(session('quyen173')==1)
                                    <th>Cập nhật kho</th>
                                    @endif --}}
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($tonKho as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                   
                                    <td>{{$item->branch_name}}</td>
                                  
                                    <td>{{$item->facility_name}}</td>
                                    <td>{{$item->inventory_amount}}</td>
                                  
                                    {{-- @if(session('quyen172')==1)
                                    <td><a class="btn"  data-toggle="modal" data-target="#basicModal"
                                        onclick="setValue('{{$item->inventory_id}}')">
                                            <i style="color: blue" class="fa  fa-sign-in"></i>
                                        </a>
                                    </td>
                                    
                                    @endif --}}
                                    {{-- @if(session('quyen173')==1)
                                    <td>
                                        <a class="btn"  data-toggle="modal" data-target="#basicModal2"
                                        onclick="setValue2('{{$item->inventory_id}}','{{$item->inventory_amount}}')">
                                            <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    @endif --}}
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



$chiNhanh = $('#chiNhanh').val();


document.getElementById('page1').className = "page-item active";
$('#pageSelect').val(1);
$idVatPham = {{$loaiCSVC->facilityType_id}};
$value = $('#valueSearch').val();
$.ajax({
    type: 'get',
    url: '{{ route("searchSanPhamTonKhoChiNhanh")}}',
    data: {
        'value': $value,
        'page': 1,
        'chiNhanh':$chiNhanh,
        'id':$idVatPham
    },
    success: function(data) {
        document.getElementById('duLieuSearch').innerHTML = data;

    }
});
}

function searchPage(page) {
    $idVatPham = {{$loaiCSVC->facilityType_id}};
    $chiNhanh = $('#chiNhanh').val();
$pageSelect = $('#pageSelect').val();
document.getElementById('page' + $pageSelect).className = "page-item";

document.getElementById('page' + page).className = "page-item active";
$('#pageSelect').val(page);
$value = $('#valueSearch').val();
$.ajax({
    type: 'get',
    url: '{{ route("searchSanPhamTonKhoChiNhanh")}}',
    data: {
        'value': $value,
        'page': page,
        'chiNhanh':$chiNhanh,
        'id':$idVatPham
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
                            url: '{{route("getXoaCoSoVatChat")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getCoSoVatChat')}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa tồn kho", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa tồn kho", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id) {
        $('#id').val(id);
    }
    function setValue2(id,soLuong) {
        $('#id2').val(id);
        $('#soLuong2').val(soLuong);
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemTonKho")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Nhập tồn kho", "Nhập thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getTonKho')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Nhập tồn kho", "Bạn không có quyền nhập!!!");
                }

                else {
                    PhatHienLoi('Nhập tồn kho', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatTonKho")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật tồn kho", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getTonKho')}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật tồn kho", "Bạn không có quyền cập nhật!!!");
                } 
               
                else {
                    PhatHienLoi('Thêm tồn kho', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection