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
                        <h4 class="card-title">Nhân viên</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Tìm kiếm" aria-label="Tìm chương trình">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <select class="form-control" name="chiNhanh" id="chiNhanh" onchange="search();">
                                    <option value="0">Tất cả</option>
                                     @foreach($chiNhanh as $item)
                                     <option value="{{ $item->branch_id }}">{{ $item->branch_name }}</option>
                                     @endforeach
                                 </select>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                          
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr >
                                    <th style="width: 5px">STT</th>
                                    <th>Chi nhánh</th>
                                    <th>Tên nhân viên</th>
                                    <th>Số điện thoại</th>
                                    <th>Xem lịch</th>
                                    <th>Xếp lịch</th>
                                    <th>Giờ làm việc</th>
                                </tr>
                                </thead>
                                <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($nhanVien as $item)
                                    <tr>
                                        <td> @php echo $i; @endphp</td>
                                        <td>{{$item->branch_name}}</td>
                                        <td>{{$item->employee_name}}</td>
                                        <td>{{$item->employee_phone}}</td>
                                        <td><a class="btn"  href="{{ route('getLichNhanVien') }}?id={{ $item->employee_id }}"><i class="fa fa-calendar"></i></a></td>
                                        <td><a class="btn" href="{{ route('getXepLichGiaoVien') }}?id={{ $item->employee_id }}"><i class="fa fa-edit"></i></a></td>
                                        <td><a class="btn"  href="{{ route('getGioLamGiaoVien') }}?id={{ $item->employee_id }}"><i class="fa  fa-clock-o"></i></a></td>
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
        $chiNhanh = $('#chiNhanh').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchXepLichNhanVien")}}',
            data: {
                'value': $value,
                'chiNhanh': $chiNhanh,
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
        $chiNhanh = $('#chiNhanh').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchXepLichNhanVien")}}',
            data: {
                'value': $value,
                'chiNhanh': $chiNhanh,
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
            url: '{{route("postThemXepLichLopHoc")}}',
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