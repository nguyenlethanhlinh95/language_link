@extends('master.masterAdmin')
@section('title')
    Phỏng Vấn
@endsection
@section('contain')
<div class="content-body">

    <!-- <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    </ol>
                </div>
            </div> -->
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">

<div class="card-body">
    <h4 class="card-title">PT</h4>
    <br>
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="input-group icons">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                </div>
                <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search tên học viên" aria-label="Tìm marketing">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
        </div>

        <div class="col-lg-3 col-sm-6">
            <!-- @if(session('quyen32')==1)
            <a href="{{route('getThemPhongVan')}}">
            <button  type="button" class="btn mb-1 btn-outline-success" style="float: right">Thêm mới</button>
            </a>
            @endif -->
        </div>
    </div>

    <br>
    <br>
    <table class="table table-striped table-bordered zero-configuration">
        <thead>
            <tr>
                <th style="width:10px">STT</th>
                <th>Tên học viên</th>
                <th>Số đt</th>
                <th>Chương trình học</th>
                <th>Thời gian</th>
                <th>Giáo viên</th>
                @if(session('quyen2001')==1)
                <th>Kết quả</th>
                @endif
                @if(session('quyen33')==1)
                <th>Sửa</th>
                @endif
                @if(session('quyen34')==1)
                <th>Xóa</th>
                @endif
            </tr>
        </thead>
        <tbody id="duLieuSearch">
            @php $i=1; @endphp
            @foreach($phongVan as $item)
            <tr>
                <td>@php echo $i; @endphp</td>
                <td>
                    <a href="{{route('getChiTietHocVien')}}?id={{$item->student_id}}">
                        {{$item->student_firstName}} {{$item->student_lastName}}</a> 
                    </td>
                    <td>{{$item->student_phone}}</td>
                    <td>{{$item->studyProgram_name}}</td>
                <td>{{date('H:i d/m/Y',strtotime( $item->placementTest_dateTime))}}</td>
               
                <td>{{$item->employee_name}}</td>
                <td><a href="{{route('getCapNhatKetQuaPhongVan')}}?id={{$item->placementTest_id}}">Chi tiết</a></td>
                @if(session('quyen33')==1)
                   <td><a class="btn" href="{{route('getCapNhatPhongVan')}}?id={{$item->placementTest_id}}">
                        <i style="color: blue"  class="fa fa-edit"></i>
                    </a></td>
              
                @endif
                @if(session('quyen34')==1)
                <td>
                    <a class="btn" onclick="xoa('{{$item->placementTest_id }}');">
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
<script>
     function search() {
        
        $pageSelect = $('#pageSelect').val();
        document.getElementById('page'+$pageSelect).className="page-item";

        document.getElementById('page1').className="page-item active";
        $('#pageSelect').val(1);

        $value = $('#valueSearch').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchPhongVan")}}',
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
        document.getElementById('page'+$pageSelect).className="page-item";

        document.getElementById('page'+page).className="page-item active";
        $('#pageSelect').val(page);
        $value = $('#valueSearch').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchPhongVan")}}',
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
                            url: '{{ route("getXoaPhongVan")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getPhongVan')}}";
                                } else if (data == 1) {
                                    KiemTra("Xóa marketing", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa marketing", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }
</script>

@endsection