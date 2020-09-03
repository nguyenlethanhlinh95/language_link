@extends('master.masterAdmin')
@section('title')
    HỌC VIÊN
@endsection
@push('styles')
    <style>
        label {
            margin-top: 15px;
            margin-bottom: 0;
        }
        .err {
            border: 1px solid red;
        }
    </style>
@endpush
@section('contain')
    <div class="content-body">
        <div class="row page-titles mx-0" style="padding-bottom: 0px!important">
            <div class="col p-md-0">
                <ol class="breadcrumb" style="float:left!important">
                    <li class="breadcrumb-item active" ><a href="{{ url()->previous() }}" class="btn mb-1 btn-rounded btn-outline-dark fa fa-backward">&nbsp;&nbsp;Back</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Cập phiếu chi</h4>
                            <div class="grid-errors">
                                @if ( session('error') )
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <strong>{{ session('error') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <form action="{{ route('payment.update', ['id'=>$payment->payment_id]) }}" method="post" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <label>Tên phiếu chi<span style="color: red">*</span></label>
                                        <input value="{{ old('payment_title', $payment->payment_title) }}" required class="form-control @if ($errors->has('payment_title')) err @endif" name="payment_title" id="firtName">
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label>Nội dung chi</label>
                                        <textarea rows="3" maxlength="255" class="form-control @if ($errors->has('payment_content')) err @endif" name="payment_content">{{ old('payment_content', $payment->payment_content) }}</textarea>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label>Số tiền<span style="color: red">*</span></label>
                                        <input value="{{ old('payment_amount', $payment->payment_amount) }}" required class="form-control @if ($errors->has('payment_amount')) err @endif" name="payment_amount" id="payment_amount">
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label>Ngày tạo<span style="color: red">*</span></label>
                                        @php $date = \Carbon\Carbon::parse($payment->payment_created_day)->format('Y-m-d h:m:s') @endphp
                                        <input value="{{ old('payment_created_day', $date) }}" required class="form-control @if ($errors->has('payment_created_day')) err @endif" name="payment_created_day">
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label>Ghi chú</label>
                                        <textarea rows="3" maxlength="255" class="form-control @if ($errors->has('payment_note')) err @endif" name="payment_note">{{ old('payment_note', $payment->payment_note) }}</textarea>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn mb-1 btn-outline-success">Cập nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#payment_amount').keyup(function () {
                var _this = $(this);
                var value = _this.val();
            });

            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            }
        });
    </script>
@endpush