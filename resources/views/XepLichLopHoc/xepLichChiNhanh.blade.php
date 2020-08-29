@extends('master.masterAdmin')
@section('title')
Chi nhánh
@endsection
@section('contain')
<div class="content-body">

  
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Xếp lịch chi nhánh</h4>
                        <br>
                        {{-- <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search Dashboard" aria-label="Tìm chi nhánh">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen332')==1)
                            <a href="{{route('getThemChinhanh')}}">
                                <button type="button" class="btn mb-1 btn-outline-success" 
                                    style="float: right">Thêm mới</button>
                            </a>
                                
                            @endif
                            </div>
                        </div> --}}

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Tên chi nhánh</th>
                                    <th>Mã chi nhánh</th>
                                    <th>Địa chỉ</th>
                                    <th>Email</th>
                                    <th>Xem lịch</th>
                                    <th>Giờ làm việc</th>
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($chiNhanh as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                             
                                    <td>{{$item->branch_name}}</td>
                                   
                                    <td>{{$item->branch_code}}</td>
                                
                                    <td>{{$item->branch_address}}</td>
                                    <td>{{$item->branch_mail}}</td>
                                    <td><a class="btn"  href="{{ route('getLichChiNhanhChiTiet') }}?id={{ $item->branch_id }}"><i class="fa fa-calendar"></i></a></td>
                                    <td><a class="btn"  href="{{ route('getGioLamChiNhanh') }}?id={{ $item->branch_id }}"><i class="fa  fa-clock-o"></i></a></td>
                                
                                </tr>
                                @php $i++; @endphp
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>
    function search() {
    
        $value = $('#valueSearch').val();
        $.ajax({
            type: 'get',
            url: '{{route("searchChiNhanh")}}',
            data: {
                'value': $value
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
                            url: '{{route("getXoaChiNhanh")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getChiNhanh')}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa chi nhánh", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa chi nhánh", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }


</script>
@endsection