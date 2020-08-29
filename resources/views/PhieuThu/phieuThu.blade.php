@extends('master.masterAdmin')
@section('title')
phiếu thu
@endsection
@section('contain')
<div class="content-body">


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Phiếu thu </h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" 
                                    placeholder="Search tên phiếu thu" aria-label="Tìm marketing">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
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
                                    <th>Nội dung</th>
                                    <th>Thời gian</th>
                                    <th>Người lập</th>
                                    <th>Học viên</th>
                                    <th>Tổng tiền</th>
                                    <th>Loại phiếu thu</th>
                                    @if(session('quyen313')==1)
                                    <th>Chi tiết</th>
                                    @endif
                                    @if(session('quyen314')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($phieuThu as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->branch_name}}</td>
                                    <td>{{$item->receipt_name}}</td>
                                    <td>{{date('H:i d/m/Y',strtotime($item->receipt_time)) }}</td>
                                    
                                    <td>{{$item->employee_name}}</td>
                                    <td>{{$item->student_firstName}} {{$item->student_lastName}}</td>
                                    <td>{{number_format($item->receipt_total,0,"",".") }}đ</td>
                                    @if($item->receipt_type==0)
                                    <td>Học phí</td>
                                    @elseif($item->receipt_type==-1)
                                    <td>Thu khác</td>
                                    @else
                                    @foreach($loai as $item1)
                                        @if($item->receipt_type==$item1->facilityType_id)
                                        <td>Bán {{ $item1->facilityType_name }}</td>
                                        @endif
                                    @endforeach
                                    @endif
                                    @if(session('quyen313')==1)
                                    <td><a class="btn" href="{{route('getCapNhatPhieuThu')}}?id={{$item->receipt_id}}">
                                           chi tiết {{-- <i style="color: blue" class="fa fa-search"></i> --}}
                                        </a>
                                    </td>
                                    @endif
                                    @if(session('quyen314')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->receipt_id}}');">
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
                            url: '{{route("getXoaPhieuThu")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getPhieuThu')}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa phiếu thu", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa phiếu thu", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function search() {

        $pageSelect = $('#pageSelect').val();
        document.getElementById('page' + $pageSelect).className = "page-item";

        document.getElementById('page1').className = "page-item active";
        $('#pageSelect').val(1);

        $value = $('#valueSearch').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchDanhSachPhieuThu")}}',
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
            url: '{{ route("searchDanhSachPhieuThu")}}',
            data: {
                'value': $value,
                'page': page
            },
            success: function(data) {
                document.getElementById('duLieuSearch').innerHTML = data;

            }
        });
    }
</script>
@endsection