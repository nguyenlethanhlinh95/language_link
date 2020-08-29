@extends('master.masterAdmin')
@section('title')
    HỌC VIÊN<Nav></Nav>
@endsection
@section('contain')
<div class="content-body">

    
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">

<div class="card-body">
    <h4 class="card-title">Học viên</h4>
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
            @if(session('quyen22')==1)
            <a href="{{route('getThemHocVien')}}">
            <button  type="button" class="btn mb-1 btn-outline-success" style="float: right">Thêm mới</button>
            </a>
            @endif

        </div>
    </div>

    <br>
    <br>
    <table class="table table-striped table-bordered zero-configuration">
        <thead>
            <tr>
                <th style="width:10px">STT</th>
                <th>Tên học viên</th>
                <th>Nickname</th>
                <th>Ngày sinh HV</th>
                <th>Tên PH</th>
                <th>Số đt PH</th>
                <th>Số đt HV</th>
                <th>Địa chỉ</th>
                @if(session('quyen23')==1)
                <th>Sửa</th>
                @endif
                @if(session('quyen24')==1)
                <th>Xóa</th>
                @endif
            </tr>
        </thead>
        <tbody id="duLieuSearch">
            @php $i=1; @endphp
            @foreach($hocVien as $item)
            <tr>
                <td>@php echo $i; @endphp</td>
                <td><a href="{{route('getChiTietHocVien')}}?id={{$item->student_id}}">{{$item->student_firstName}} {{$item->student_lastName}}</a> </td>
                <td>{{$item->student_nickName}}</td>
                <td>{{date('d/m/Y',strtotime( $item->student_birthDay))}}</td>
                <td>{{$item->student_parentName}}</td>
              
               
               
                <td>{{$item->student_parentPhone}}</td>
                <td>{{$item->student_phone}}</td>
                <td>{{$item->student_address}}</td>
                @if(session('quyen23')==1)
                <td><a class="btn" href="{{route('getCapNhatHocVien')}}?id={{$item->student_id}}">
                        <i style="color: blue"  class="fa fa-edit"></i>
                    </a></td>
              
                @endif
                @if(session('quyen24')==1)
                <td>
                    <a class="btn" onclick="xoa('{{$item->student_id }}');">
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
            url: '{{ route("searchHocVien")}}',
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
            url: '{{ route("searchHocVien")}}',
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
                            url: '{{ route("getXoaHocVien")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getHocVien')}}";
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