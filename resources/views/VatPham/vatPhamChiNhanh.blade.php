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
                        <select class=" form-control" id="vatPham" name="vatPham" required>
                            @foreach($vatPham as $item)
                            <option value="{{$item->item_id}}">{{$item->item_name}}</option>
                            @endforeach
                        </select>
                        {{-- <label>Giá mua</label>
                        <input maxlength="30" type="number" class="form-control" required id="giaMua" name="giaMua">
                        
                        <label>Giá bán</label>
                        <input maxlength="30" type="number" class="form-control" required id="gia" name="gia"> --}}
                      
        
                       @if(session('quyen2221')==1)
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
                        <h5 class="modal-title">Cập nhật cơ sở vật chất</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       
                        <input id="id" name="id" hidden>
                        <div id="duLieuCapNhat">
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
                        <h4 class="card-title"> Cơ sở vật chất chi nhánh</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Tìm kiếm" aria-label="Tìm cơ sở vật chất">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen222')==1)
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
                                    <th>Tên cơ sở vật chất</th>
                                   
                                    
                                    {{-- @if(session('quyen223')==1)
                                    <th>Sửa</th>
                                    @endif --}}
                                    @if(session('quyen224')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($vatPhamChiNhanh as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->branch_name}}</td>
                                    <td>{{$item->item_name}}</td>
                                    {{-- @if(session('quyen223')==1)
                                    <td><a class="btn"  data-toggle="modal" data-target="#basicModal2"
                                        onclick="setValue('{{$item->inventoryItem_id}}','{{$item->item_name}}')">
                                            <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    
                                    @endif --}}
                                    @if(session('quyen224')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->inventoryItem_id}}');">
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

document.getElementById('page1').className = "page-item active";
$('#pageSelect').val(1);

$value = $('#valueSearch').val();
$.ajax({
    type: 'get',
    url: '{{ route("searchVatPhamChiNhanh")}}',
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
url: '{{ route("searchVatPhamChiNhanh")}}',
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
                            url: '{{route("getXoaChiNhanhVatPham")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getChiNhanhVatPham')}}";
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

    function setValue(id, ten,giaMua,giaBan) {
        $('#id').val(id);
        $('#giaMua2').val(giaMua);
        $('#giaBan2').val(giaBan);

        document.getElementById('duLieuCapNhat').innerHTML=' <label>Tên cơ sở vật chất: '+ten+'</label>';
      
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemChiNhanhVatPham")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm cơ sở vật chất chi nhánh", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getChiNhanhVatPham')}}";
                    }, 2200);

                } else if (data == 2) {
                    KiemTra("Thêm cơ sở vật chất chi nhánh", "Bạn không có quyền thêm!!!");
                }

                else if (data == 3) {
                    KiemTra("Thêm cơ sở vật chất chi nhánh", "Bạn không có quyền thêm nhiều chi nhánh!!!");
                }    
                else if (data == 4) {
                    KiemTra("Thêm cơ sở vật chất chi nhánh", "Vât phẩm đã có trong chi nhánh!!!");
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
            url: '{{route("getCapnhatVatPhamChiNhanh")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật cơ sở vật chất", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getChiNhanhVatPham')}}";
                    }, 2200);

                } else if (data == 2) {
                    KiemTra("Cập nhật cơ sở vật chất", "Bạn không có quyền cập nhật!!!");
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