@extends('master.masterAdmin')
@push('styles')
    <style>
        .card-body nav {
            display: flex;
            flex-direction: row-reverse;
            margin-right: 30px;
        }
        .input-group-text i {
            font-size: 24px;
        }
        .input-group-prepend {
            margin-left: 26px;
        }
        .input-group-prepend:hover {
            cursor: pointer;
        }
        .submit {
            background: transparent;
            border: none;
            cursor: pointer;
        }
        .submit:focus {
            outline: none;
        }
    </style>
@endpush
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
                            <h4 class="card-title">Học viên | @if (isAdmin()) Tất cả chi nhánh @else Chi nhánh {{ $branchName }} @endif</h4>
                            <br>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <form action="{{ route('searchHocVien') }}" method="get">
                                        @csrf
                                        <div class="input-group icons">
                                            <div class="input-group-prepend">
                                                <button class="submit" type="submit" title="Tìm kiếm">
                            <span class="input-group-text h5 p-0 bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i
                                        class="mdi mdi-magnify"></i></span>
                                                </button>
                                            </div>
                                            <input value="{{ $keyword ? $keyword : '' }}" name="search_by_name" id="search_by_name" type="search" class="form-control"
                                                   placeholder="Tìm theo tên học viên" aria-label="Tìm marketing">
                                        </div>
                                    </form>
                                </div>

                                <div class="col-lg-6 col-sm-12 text-right">
                                    @if(session('quyen22')==1)
                                        <a href="{{route('getThemHocVien')}}">
                                            <button type="button" class="btn mb-1 mr-0 mr-md-4 btn-outline-success">Thêm mới</button>
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
                            {!! $hocVien->links(); !!}
                            {{--<input hidden id="pageSelect" value="1">--}}
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