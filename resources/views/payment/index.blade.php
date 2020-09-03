@extends('master.masterAdmin')
@section('title')
    Phỏng Vấn
@endsection

@push('styles')
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function () {
            $('.alert').delay(2000).slideUp(500);
        });
    </script>
@endpush
@section('contain')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title ml-4">Danh sách phiếu chi</h4>
                            <div class="">
                                @if (\Session::has('suc'))
                                    <div class="alert alert-success">
                                        {!! \Session::get('suc') !!}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    {{--<div class="input-group icons">--}}
                                        {{--<div class="input-group-prepend">--}}
                                            {{--<span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>--}}
                                        {{--</div>--}}
                                        {{--<input id="valueSearch" type="search" class="form-control" placeholder="Tìm kiếm phiếu chi" aria-label="Tìm marketing">--}}
                                    {{--</div>--}}
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                </div>

                                <div class="col-lg-3 col-sm-12">
                                    <a href="{{route('payment.create')}}">
                                        <button type="button" class="btn mb-1 mr-0 mr-lg-4 btn-outline-success" style="float: right">Thêm mới</button>
                                    </a>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Tên phiếu chi</th>
                                    <th>Nội dung</th>
                                    <th>Số tiền</th>
                                    <th>Ghi chú</th>
                                    <th>Người tạo</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                    {{--@if(session('quyen2001')==1)--}}
                                        {{--<th>Kết quả</th>--}}
                                    {{--@endif--}}
                                    {{--@if(session('quyen33')==1)--}}
                                        {{--<th>Sửa</th>--}}
                                    {{--@endif--}}
                                    {{--@if(session('quyen34')==1)--}}
                                        {{--<th>Xóa</th>--}}
                                    {{--@endif--}}
                                </tr>
                                </thead>
                                <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($payments as $pay)
                                    <tr>
                                        <td>@php echo $i; @endphp</td>
                                        <td>{{ $pay->payment_title }}</td>
                                        <td>{{ $pay->payment_content }}</td>
                                        <td>{{ formatCurrency($pay->payment_amount) }} VNĐ</td>
                                        <td>{{ $pay->payment_note}}</td>
                                        <td>{{ 213 }}</td>
                                        @php $date = \Carbon\Carbon::parse($pay->payment_created_day)->format('Y-m-d h:m:s') @endphp
                                        <td width="110px">{{ $date }}</td>
                                        <td width="57px">
                                            <a class="btn p-0" href="{{ route('payment.edit', ['id'=>$pay->payment_id ]) }}">
                                                <i style="color: blue"  class="fa fa-edit"></i>
                                            </a> |
                                            <a class="btn p-0" href="{{ route('payment.show', ['id'=>$pay->payment_id]) }}">
                                                <i style="color: red" class="fa fa-close"></i>
                                            </a>
                                        </td>
                                {{--@if(session('quyen33')==1)--}}
                                            {{--<td><a class="btn" href="{{route('getCapNhatPhongVan')}}?id={{$item->placementTest_id}}">--}}
                                                    {{--<i style="color: blue"  class="fa fa-edit"></i>--}}
                                                {{--</a></td>--}}

                                        {{--@endif--}}
                                        {{--@if(session('quyen34')==1)--}}
                                            {{--<td>--}}
                                                {{--<a class="btn" onclick="xoa('{{$item->placementTest_id }}');">--}}
                                                    {{--<i style="color: red" class="fa fa-close"></i>--}}
                                                {{--</a>--}}
                                            {{--</td>--}}
                                        {{--@endif--}}
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                                </tbody>
                            </table>
                            {{ $payments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection