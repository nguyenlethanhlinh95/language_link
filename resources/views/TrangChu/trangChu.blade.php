@extends('master.masterAdmin')
@section('title')
Trang Chủ
@endsection
@section('contain')
<div class="content-body">

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-1">
                    <div class="card-body">
                        <h3 class="card-title text-white">Tư vấn hôm nay</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">10</h2>
                            <p class="text-white mb-0">Jan - March 2020</p>
                        </div>
                        <span class="float-right display-5 opacity-5">
                        <i class="fa fa-angle-double-up"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-2">
                    <div class="card-body">
                        <h3 class="card-title text-white">Chờ mở lớp</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">3</h2>
                            <p class="text-white mb-0">Jan - March 2020</p>
                        </div>
                        <span class="float-right display-5 opacity-5">
                        <i class="fa fa-angle-double-down"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-3">
                    <div class="card-body">
                        <h3 class="card-title text-white">Sinh nhật</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">2</h2>
                            <p class="text-white mb-0">Jan - March 2020</p>
                        </div>
                        <span class="float-right display-5 opacity-5">
                        <i class="fa fa-chain"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-4">
                    <div class="card-body">
                        <h3 class="card-title text-white">Tư vấn ngày mai</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">9</h2>
                            <p class="text-white mb-0">Jan - March 2020</p>
                        </div>
                        <span class="float-right display-5 opacity-5">
                        <i class="fa fa-table"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection