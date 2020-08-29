@extends('master.masterAdmin')
@section('title')
{{$loaiCSVC->facilityType_name}}
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
                        <h5 class="modal-title">Thêm {{$loaiCSVC->facilityType_name}}</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Tên {{$loaiCSVC->facilityType_name}}  <span style="color: red">*</span></label>
                        <select class=" form-control" id="vatPham" name="vatPham" required>
                            @foreach($vatPham as $item)
                            <option value="{{$item->facility_id}}">{{$item->facility_name}}</option>
                            @endforeach
                        </select>
                        {{-- <label>Giá mua</label>
                        <input maxlength="30" type="number" class="form-control" required id="giaMua" name="giaMua">
                        
                        <label>Giá bán</label>
                        <input maxlength="30" type="number" class="form-control" required id="gia" name="gia"> --}}
                        <input hidden id="loai" name="loai" value="{{$loaiCSVC->facilityType_id}}">
                        <label>Giá mua  <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="giaMua" name="giaMua">
                        <label>Giá bán <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="giaBan" name="giaBan">
                       @if(session('quyen2201')==1)
                       <label>Chi nhánh</label><br>
                       <div class="form-check mb-3">
                        <label class="form-check-label">
                            <input type="checkbox" id="checkAll" onclick="checkBoxAll();" class="form-check-input" >Tất cả</label>
                        </div>
                        <div class="row" style="padding-left:1rem">
                            @foreach($chiNhanh as $item)
                            
                            <div class="form-check mb-3 col-lg-6">
                                <label class="form-check-label">
                                    <input type="checkbox" id="check{{$item->branch_id}}"
                                     name="check{{$item->branch_id}}" class="form-check-input" onclick="kiemTraCheckBox({{$item->branch_id}})">
                                {{$item->branch_name}}</label>
                            </div>
                            @endforeach
                        </div>
                        <input hidden id="loaiThem" name="loaiThem" value="1">
                        @else
                        <input hidden id="loaiThem" name="loaiThem" value="0">
                       @endif
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
                        <h5 class="modal-title">Cập nhật {{$loaiCSVC->facilityType_name}}</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                        <input id="id" name="id" hidden>
                        <div id="duLieuCapNhat">
                        </div>
                         <label>Giá mua <span style="color: red">*</span></label>
                         <input maxlength="30" class="form-control" required id="giaMua2" name="giaMua2">
                         <label>Giá bán <span style="color: red">*</span></label>
                         <input maxlength="30" class="form-control" required id="giaBan2" name="giaBan2">
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
                        <h4 class="card-title">Vật phẩm chi nhánh: {{$loaiCSVC->facilityType_name}}</h4>
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
                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen202')==1)
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
                                    <th>Chi nhánh</th>
                                    <th>Tên {{$loaiCSVC->facilityType_name}}</th>
                                    <th>Giá mua</th>
                                    <th>Giá bán</th>
                                    
                                    @if(session('quyen203')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen204')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($sanPhamChiNhan as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->branch_name}}</td>
                                    <td>{{$item->facility_name}}</td>
                                    <td>{{number_format($item->facility_purchasePrice,0,"",".") }} đ</td>
                                    <td>{{number_format($item->facility_price,0,"",".") }} đ</td>
                                   
                                  
                                  
                                    @if(session('quyen203')==1)
                                    <td><a class="btn"  data-toggle="modal" data-target="#basicModal2"
                                        onclick="setValue('{{$item->inventory_id}}','{{$item->facility_name}}','{{$item->facility_price}}'
                                        ,'{{$item->facility_purchasePrice}}')">
                                            <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    
                                    @endif
                                    @if(session('quyen204')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->inventory_id}}');">
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
    function kiemTraCheckBox(id)
    {
        var checkBox = document.getElementById('check'+id);

        var isChecked = checkBox.checked;
        if(isChecked == true)
        {
            $kiemTra=0;
            @foreach($chiNhanh as $item)
                var checkBoxSub = document.getElementById('check{{$item->branch_id}}');
                var isSubChecked = checkBoxSub.checked;
                if(isSubChecked==false)
                $kiemTra=1;
            @endforeach
            if($kiemTra==0)
            {
                $( "#checkAll" ).prop( "checked", true );
            }
            else
            {
                $( "#checkAll" ).prop( "checked", false );
            }
        }
        else
        {
            $( "#checkAll" ).prop( "checked", false );
        }
    }

    function checkBoxAll()
    {
        var checkBoxAll = document.getElementById('checkAll');

        var isChecked = checkBoxAll.checked;

        if(isChecked == true)
        {
            @foreach($chiNhanh as $item)
            $( "#check{{$item->branch_id}}" ).prop( "checked", true );
            @endforeach
        }
        else
        {
            @foreach($chiNhanh as $item)
            $( "#check{{$item->branch_id}}" ).prop( "checked", false );
            @endforeach
        }
    }


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
    url: '{{ route("searchSanPhamChiNhanh")}}',
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
    url: '{{ route("searchSanPhamChiNhanh")}}',
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
                            url: '{{route("getXoaVatPhamChiNhanh")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getVatPhamChiNhanh')}}?id={{$loaiCSVC->facilityType_id}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa {{$loaiCSVC->facilityType_name}}", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa {{$loaiCSVC->facilityType_name}}", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id, ten,giaMua,giaBan) {
        $('#id').val(id);
        $('#giaMua2').val(giaMua);
        $('#giaBan2').val(giaBan);

        document.getElementById('duLieuCapNhat').innerHTML=' <label>Tên {{$loaiCSVC->facilityType_name}}: '+ten+'</label>';
      
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemVatPhamChiNhanh")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm {{$loaiCSVC->facilityType_name}} chi nhánh", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getVatPhamChiNhanh')}}?id={{$loaiCSVC->facilityType_id}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Thêm {{$loaiCSVC->facilityType_name}} chi nhánh", "Bạn không có quyền thêm!!!");
                }

                else if (data == 3) {
                    KiemTra("Thêm {{$loaiCSVC->facilityType_name}} chi nhánh", "Bạn không có quyền thêm nhiều chi nhánh!!!");
                }    
                else if (data == 4) {
                    KiemTra("Thêm {{$loaiCSVC->facilityType_name}} chi nhánh", "Vât phẩm đã có trong chi nhánh!!!");
                }                 else {
                    PhatHienLoi('Thêm {{$loaiCSVC->facilityType_name}}', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("getCapnhatVatPhamChiNhanh")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật {{$loaiCSVC->facilityType_name}}", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getVatPhamChiNhanh')}}?id={{$loaiCSVC->facilityType_id}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật {{$loaiCSVC->facilityType_name}}", "Bạn không có quyền cập nhật!!!");
                } 
               
                else {
                    PhatHienLoi('Thêm {{$loaiCSVC->facilityType_name}}', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection