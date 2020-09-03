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
                            <h4 class="card-title">Thêm mới phiếu chi</h4>
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
                            <form action="{{ route('payment.store') }}" method="post" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <label>Tên phiếu chi<span style="color: red">*</span></label>
                                        <input required class="form-control @if ($errors->has('payment_title')) err @endif" name="payment_title" id="firtName">
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label>Nội dung chi</label>
                                        <textarea rows="3" maxlength="255" class="form-control @if ($errors->has('payment_content')) err @endif" name="payment_content"></textarea>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label>Số tiền<span style="color: red">*</span></label>
                                        <input type="text" required class="form-control currency-field @if ($errors->has('payment_amount')) err @endif" name="payment_amount" id="payment_amount">
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label>Ngày tạo<span style="color: red">*</span></label>
                                        <input required type="datetime-local" class="form-control @if ($errors->has('payment_created_day')) err @endif" name="payment_created_day">
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <label>Ghi chú</label>
                                        <textarea rows="3" maxlength="255" class="form-control @if ($errors->has('payment_note')) err @endif" name="payment_note"></textarea>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn mb-1 btn-outline-success">Thêm mới</button>
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
           $('#payment_amount').on({
               keyup: function() {
                   formatCurrency($(this));
               },
               blur: function() {
                   formatCurrency($(this), "blur");
               }
           });

            function formatNumber(n) {
                // format number 1000000 to 1,234,567
                return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }

            function formatCurrency(input, blur) {
                // appends $ to value, validates decimal side
                // and puts cursor back in right position.

                // get input value
                var input_val = input.val();

                // don't validate empty input
                if (input_val === "") { return; }

                // original length
                var original_len = input_val.length;

                // initial caret position
                var caret_pos = input.prop("selectionStart");

                // check for decimal
                if (input_val.indexOf(",") >= 0) {

                    // get position of first decimal
                    // this prevents multiple decimals from
                    // being entered
                    var decimal_pos = input_val.indexOf(",");

                    // split number by decimal point
                    var left_side = input_val.substring(0, decimal_pos);
                    var right_side = input_val.substring(decimal_pos);

                    // add commas to left side of number
                    left_side = formatNumber(left_side);

                    // validate right side
                    right_side = formatNumber(right_side);

                    // On blur make sure 2 numbers after decimal
                    if (blur === "blur") {
                        right_side += "00";
                    }

                    // Limit decimal to only 2 digits
                    right_side = right_side.substring(0, 2);

                    // join number by .
                    input_val = left_side + "." + right_side + " VNĐ";

                } else {
                    // no decimal entered
                    // add commas to number
                    // remove all non-digits
                    input_val = formatNumber(input_val);
                    input_val = input_val + " VNĐ";

                    // final formatting
                    if (blur === "blur") {
                        // input_val += ",00";
                    }
                }

                // send updated string to input
                input.val(input_val);

                // put caret back in the right position
                var updated_len = input_val.length;
                caret_pos = updated_len - original_len + caret_pos;
                input[0].setSelectionRange(caret_pos, caret_pos);
            }
        });
    </script>
@endpush