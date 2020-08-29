@extends('master.masterAdmin')
@section('title')
Doanh thu
@endsection
@section('contain')
<div class="content-body">
<style>
.bg-red, .callout.callout-danger, .alert-danger, .alert-error, .label-danger, .modal-danger .modal-body {
    background-color: #dd4b39 !important;
}
.bg-blue, .callout.callout-danger, .alert-danger, .alert-error, .label-danger, .modal-danger .modal-body {
    background-color: dodgerblue !important;
}
.bg-green, .callout.callout-danger, .alert-danger, .alert-error, .label-danger, .modal-danger .modal-body {
    background-color: green !important;
}
.bg-red, .bg-yellow, .bg-aqua, .bg-blue, .bg-light-blue, .bg-green, .bg-navy, .bg-teal, .bg-olive, .bg-lime, .bg-orange, .bg-fuchsia, .bg-purple, .bg-maroon, .bg-black, .bg-red-active, .bg-yellow-active, .bg-aqua-active, .bg-blue-active, .bg-light-blue-active, .bg-green-active, .bg-navy-active, .bg-teal-active, .bg-olive-active, .bg-lime-active, .bg-orange-active, .bg-fuchsia-active, .bg-purple-active, .bg-maroon-active, .bg-black-active, .callout.callout-danger, .callout.callout-warning, .callout.callout-info, .callout.callout-success, .alert-success, .alert-danger, .alert-error, .alert-warning, .alert-info, .label-danger, .label-info, .label-warning, .label-primary, .label-success, .modal-primary .modal-body, .modal-primary .modal-header, .modal-primary .modal-footer, .modal-warning .modal-body, .modal-warning .modal-header, .modal-warning .modal-footer, .modal-info .modal-body, .modal-info .modal-header, .modal-info .modal-footer, .modal-success .modal-body, .modal-success .modal-header, .modal-success .modal-footer, .modal-danger .modal-body, .modal-danger .modal-header, .modal-danger .modal-footer {
    color: #fff !important;
}
.small-box {
    border-radius: 2px;
    position: relative;
    display: block;
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
.small-box>.inner {
    padding: 10px;
}
.small-box h3 {
    font-size: 38px;
    font-weight: bold;
    margin: 0 0 10px 0;
    white-space: nowrap;
    padding: 0;
}   
.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6, a {
    font-family: inherit;
    font-weight: 500;
    line-height: 1.1;
    color: inherit;
    font-family: 'Source Sans Pro',sans-serif;
}
.small-box p {
    font-size: 15px;
}
.small-box .icon {
    -webkit-transition: all .3s linear;
    -o-transition: all .3s linear;
    transition: all .3s linear;
    position: absolute;
    top: -10px;
    right: 10px;
    z-index: 0;
    font-size: 90px;
    color: rgba(0,0,0,0.15);
}
</style>
<div class="row page-titles mx-0" style="padding-bottom: 0px!important">
        <div class="col p-md-0">
            <ol class="breadcrumb" style="float:left!important">
                <li class="breadcrumb-item active" ><a href="{{ url()->previous() }}" class="btn mb-1 btn-rounded btn-outline-dark fa fa-backward">&nbsp;&nbsp;Back</a></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Thống kê Thu chi </h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <label>Người lập</label>
                                <div class="input-group icons">
                                    
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control"  value="{{ $tenNguoiLap }}"
                                    placeholder="Tìm kiếm" aria-label="Tìm marketing">
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <label>Thời gian</label>
                                <select class="form-control" id="thoiGian" name="thoiGian">
                                    @if($thoiGianTimkiem ==1)
                                    <option selected value="1">Hôm nay</option>
                                    @else
                                    <option value="1">Hôm nay</option>
                                    @endif
                                    @if($thoiGianTimkiem ==2)
                                    <option selected value="2">7 ngày trước</option>
                                    @else
                                    <option   value="2">7 ngày trước</option>
                                    @endif
                                    @if($thoiGianTimkiem ==3)
                                    <option  selected value="3">Tuần trước</option>
                                    @else
                                    <option   value="3">Tuần trước</option>
                                    @endif
                                    @if($thoiGianTimkiem ==4)
                                    <option  selected value="4">Tuần hiện tại</option>
                                    @else
                                    <option value="4">Tuần hiện tại</option>
                                    @endif
                                    @if($thoiGianTimkiem ==5)
                                    <option  selected value="5">30 ngày trước</option>
                                    @else
                                    <option value="5">30 ngày trước</option>
                                    @endif
                                    @if($thoiGianTimkiem ==6)
                                    <option  selected value="6">Tháng trước</option>
                                    @else
                                    <option value="6">Tháng trước</option>
                                    @endif
                                    @if($thoiGianTimkiem ==7)
                                    <option  selected value="7">Tháng hiện tại</option>
                                    @else
                                    <option value="7">Tháng hiện tại</option>
                                    @endif
                                    @if($thoiGianTimkiem ==8)
                                    <option  selected value="8">Năm trước</option>
                                    @else
                                    <option value="8">Năm trước</option>
                                    @endif
                                    @if($thoiGianTimkiem ==9)
                                    <option  selected value="9">Năm hiện tại</option>
                                    @else
                                    <option value="9">Năm hiện tại</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <label>&nbsp;</label>
                                <button class="btn mb-1 btn-outline-success" onclick="searchThoiGian();" style="display: block"><i class="fa fa-search"></i></button>
                            </div>


                            <div class="col-lg-3 col-sm-6">
                                <label>Chi nhánh</label>
                                <select class="form-control" id="chiNhanh" name="chiNhanh">
                                    <option value="0">Tất cả</option>
                                    @foreach($chiNhanh as $item)
                                    @if($item->branch_id == $chiNhanhTimKiem)
                                    <option selected value="{{ $item->branch_id }}">{{ $item->branch_name }}</option>
                                    @else 
                                    <option value="{{ $item->branch_id }}">{{ $item->branch_name }}</option>
                                    
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <label>Khoảng thời gian</label>
                                <input class="form-control input-daterange-datepicker" 
                                type="text" name="khoangThoiGian" id="khoangThoiGian" value="{{ date('m/d/Y',strtotime($ngayBatDau))}} - {{ date('m/d/Y',strtotime($ngayKetThuc)) }}">
                                        
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <label>&nbsp;</label>
                                <button onclick="searchKhoangThoiGian();" class="btn mb-1 btn-outline-success" style="display: block"><i class="fa fa-search"></i></button>
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <h3 id="tongThu">{{number_format( $phieuThu,0,"","." )}}đ</h3>
                                        <p>Tổng doanh thu</p>
                                        <a onclick="xemChiTietDoanhThu();"  class="small-box-footer btn">Xem Chi Tiết <i class="fa fa-arrow-circle-right"></i></a>
                               
                                    </div>
                                    <div class="icon">
                                        <i class="fa  fa-money"></i>
                                    </div>
                                    
                                    </div>
                                   
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <h3 id="tongChi">{{ number_format($phieuChi,0,"","." ) }}đ</h3>
                                        <p>Tổng chi phí</p>
                                        <a onclick="xemChiTietChiPhi();" class="small-box-footer btn">Xem Chi Tiết <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                    <div class="icon">
                                        <i class="fa  fa-money"></i>
                                    </div>
                                    
                                    </div>
                                    
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="small-box bg-blue">
                                    <div class="inner">
                                        <h3 id="nhapVatPham">{{ $nhapVatPham }}</h3>
                                        <p>Tổng Nhập sản phẩm</p>
                                        <a onclick="xemChiTietNhapSanPham();"  class="small-box-footer btn">Xem Chi Tiết <i class="fa fa-arrow-circle-right"></i></a>
                               
                                    </div>
                                    <div class="icon">
                                        <i class="fa  fa-money"></i>
                                    </div>
                                    
                                    </div>
                                   
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="small-box bg-blue">
                                    <div class="inner">
                                        <h3 id="xuatVatPham">{{ $xuatVatPham }}</h3>
                                        <p>Tổng xuất sản phẩm</p>
                                        <a onclick="xemChiTietPhieuXuat();" class="small-box-footer btn">Xem Chi Tiết <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                    <div class="icon">
                                        <i class="fa  fa-money"></i>
                                    </div>
                                    
                                    </div>
                                    
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h3 id="hocVien">{{ $hocVien }}</h3>
                                        <p>Tổng học viên</p>
                                        <a onclick="xemChiTietHocVien();" class="small-box-footer btn">Xem Chi Tiết <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                    <div class="icon">
                                        <i class="fa  fa-money"></i>
                                    </div>
                                    
                                    </div>
                                    
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="myform1" autocomplete="off" action="{{ route("searchThongKeThuKhoangThoiGian")}}" enctype="multipart/form-data" method="post">
    {{ csrf_field() }}
   
    <input hidden id="chiNhanhTimKiem" name="chiNhanhTimKiem" value="{{ $chiNhanhTimKiem }}">
    <input hidden id="tenNguoiLap" name="tenNguoiLap" value="{{ $tenNguoiLap }}">
    <input hidden id="thoiGianTimKiem" name="thoiGianTimKiem" value="{{ $thoiGianTimkiem }}">
    <input hidden id="khoangThoiGianTimKiem" name="khoangThoiGianTimKiem" value="{{ date('m/d/Y',strtotime($ngayBatDau))}} - {{ date('m/d/Y',strtotime($ngayKetThuc)) }}">
</form>
<form id="myform2" autocomplete="off" action="{{ route("searchThongKeChi")}}" enctype="multipart/form-data" method="post">
    {{ csrf_field() }}
   
    <input hidden id="chiNhanhTimKiem2" name="chiNhanhTimKiem2">
    <input hidden id="tenNguoiLap2" name="tenNguoiLap2">
    <input hidden id="thoiGianTimKiem2" name="thoiGianTimKiem2">
    <input hidden id="khoangThoiGianTimKiem2" name="khoangThoiGianTimKiem2">
</form>
<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>
    function xemChiTietDoanhThu()
    {
        $("#myform1").attr('action', '{{ route("searchThongKeThuKhoangThoiGian")}}');
        $('#myform1').submit();
    }
    function xemChiTietChiPhi()
    {
        $('#myform2').submit();
    }
    
    function xemChiTietNhapSanPham()
    {
        $("#myform1").attr('action', '{{ route("searchThongNhapSanPham")}}');
        
        $('#myform1').submit();
    }

    function xemChiTietPhieuXuat()
    {
        $("#myform1").attr('action', '{{ route("searchThongKeXuatSanPham")}}');
        
        $('#myform1').submit();
    }
    function xemChiTietHocVien()
    {
        $("#myform1").attr('action', '{{ route("searchThongKeHocVien")}}');
        
        $('#myform1').submit();
    }
    
    

    function searchThoiGian()
    {
        
        $value = $('#valueSearch').val();
        $chiNhanh = $('#chiNhanh').val();
        $thoiGian = $('#thoiGian').val();


        $('#chiNhanhTimKiem').val($chiNhanh);
        $('#tenNguoiLap').val($value);
        $('#thoiGianTimKiem').val($thoiGian);
        $('#khoangThoiGianTimKiem').val("");

        $('#chiNhanhTimKiem2').val($chiNhanh);
        $('#tenNguoiLap2').val($value);
        $('#thoiGianTimKiem2').val($thoiGian);
        $('#khoangThoiGianTimKiem2').val("");

        $.ajax({
            type: 'get',
            url: '{{ route("searchTongThuChi")}}',
            data: {
                'tenNguoiLap': $value,
                'chiNhanhTimKiem': $chiNhanh,
                'thoiGianTimKiem': $thoiGian,
                'khoangThoiGianTimKiem':""
            },
            success: function(data) {
                document.getElementById('tongThu').innerHTML = data[0]['phieuThu'];
                document.getElementById('tongChi').innerHTML = data[0]['phieuChi'];

                document.getElementById('nhapVatPham').innerHTML = data[0]['nhapVatPham'];
                document.getElementById('xuatVatPham').innerHTML = data[0]['xuatVatPham'];
                document.getElementById('hocVien').innerHTML = data[0]['hocVien'];
                
            }
        });
      //  alert($('#thoiGianTimKiem').val());
      //  $('#myform1').submit();
    }

    function searchKhoangThoiGian()
    {
        $value = $('#valueSearch').val();
        $chiNhanh = $('#chiNhanh').val();
        $khoangThoiGian = $('#khoangThoiGian').val();


        $('#chiNhanhTimKiem').val($chiNhanh);
        $('#tenNguoiLap').val($value);
        $('#thoiGianTimKiem').val("");
        $('#khoangThoiGianTimKiem').val($khoangThoiGian);

        $('#chiNhanhTimKiem2').val($chiNhanh);
        $('#tenNguoiLap2').val($value);
        $('#thoiGianTimKiem2').val("");
        $('#khoangThoiGianTimKiem2').val($khoangThoiGian);

        $.ajax({
            type: 'get',
            url: '{{ route("searchTongThuChi")}}',
            data: {
                'tenNguoiLap': $value,
                'chiNhanhTimKiem': $chiNhanh,
                'thoiGianTimKiem': "",
                'khoangThoiGianTimKiem':$khoangThoiGian
            },
            success: function(data) {
                document.getElementById('tongThu').innerHTML = data[0]['phieuThu'];
                document.getElementById('tongChi').innerHTML = data[0]['phieuChi'];

                document.getElementById('nhapVatPham').innerHTML = data[0]['nhapVatPham'];
                document.getElementById('xuatVatPham').innerHTML = data[0]['xuatVatPham'];
                document.getElementById('hocVien').innerHTML = data[0]['hocVien'];

            }
        });

      //  alert($('#thoiGianTimKiem').val());
       // $('#myform1').submit();
    }


</script>
@endsection