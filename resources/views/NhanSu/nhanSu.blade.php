@extends('master.masterAdmin')
@section('title')
nhân viên
@endsection
@section('contain')
<div class="content-body">


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Nhân viên </h4>
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
                                    placeholder="Search tên nhân viên" aria-label="Tìm marketing">
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
                            <div class="col-lg-3 col-sm-6">
                                @if(session('quyen12')==1)
                                <a href="{{route('getThemNhanSu')}}">
                                    <button type="button" class="btn mb-1 btn-outline-success" style="float: right">Thêm mới</button>
                                </a>
                                @endif
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Họ và tên NV</th>
                                    <th>Ngày sinh</th>
                                    <th>Số đt</th>
                                    <th>Địa chỉ</th>
                                    <th>Email</th>
                                    <th>Chức vụ</th>
                                    <th>Ngày bắt đầu làm việc</th>
                                    <th>Loại hợp đồng</th>
                                    <th>Ngày ký lại HĐ</th>
                                    <th>Ngày nghỉ làm</th>
                                    @if(session('quyen13')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen14')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($nhanSu as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->employee_name}}</td>
                                    <td>{{date('d/m/Y',strtotime($item->employee_birthDay)) }}</td>
                                  
                                    <td>{{$item->employee_phone}}</td>
                                    <td>{{$item->employee_address}}</td>
                                    <td>{{$item->employee_email}}</td>
                                    <td>{{$item->position_name}}</td>
                                    <td>{{date('d/m/Y',strtotime($item->employee_startDay)) }}</td>
                                    @if($item->contractType_id==0)
                                    <td>Vô thời hạn</td>
                                    @elseif($item->contractType_id==1)
                                    <td>Có thời hạn </td>
                                    @elseif($item->contractType_id==2)
                                    <td>Part-time</td>
                                    @else
                                    <td>Thử việc</td>
                                    @endif
                                    @if($item->contractType_id==0)
                                    <td></td>
                                    @else
                                    <td>{{date('d/m/Y',strtotime($item->employee_endDay)) }}</td>
                                    @endif
                                    @if($item->employee_status==1)
                                    <td></td>
                                    @else   
                                    <td>{{date('d/m/Y',strtotime($item->employee_finishedDay)) }}</td>
                                    @endif
                                    @if(session('quyen13')==1)
                                    <td><a class="btn" href="{{route('getCapNhatNhanSu')}}?id={{$item->employee_id}}">
                                            <i style="color: blue" class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    @endif
                                    @if(session('quyen14')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->employee_id}}');">
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
                text: "HÀNH ĐỘNG NÀY SẼ XÓA TẤT CẢ LIÊN QUAN !!",
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
                            url: '{{route("getXoaNhanSu")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getNhanSu')}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa nhân viên", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa nhân viên", "Lỗi Kết kết nối!!!!");
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
        $chiNhanh = $('#chiNhanh').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchNhanSu")}}',
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
            url: '{{ route("searchNhanSu")}}',
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
</script>
@endsection