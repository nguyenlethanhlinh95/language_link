@extends('master.masterAdmin')
@section('title')
Xuất vật phẩm
@endsection
@section('contain')
<div class="content-body">
    <div class="row page-titles mx-0" style="padding-bottom: 0px!important">
        <div class="col p-md-0">
            <ol class="breadcrumb" style="float:left!important">
                <li class="breadcrumb-item active" ><a href="{{ url()->previous() }}" class="btn mb-1 btn-rounded btn-outline-dark fa fa-backward">&nbsp;&nbsp;Back</a></li>
            </ol>
        </div>
    </div>
    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
             
                    <div class="modal-header">
                        <h5 class="modal-title">Chi tiết phiếu nhập</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:5px">STT</th>
                                    <th>Vật phẩm</th>
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody id="duLieuChiTiet">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                      
                    </div>
              
            </div>

        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Thống kê xuất vật phẩm </h4>
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
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th> 
                                    <th>Chi nhánh</th>
                                    <th>Nội dung</th>
                                    <th>Người lập</th>
                                    <th>Thời gian </th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($phieuXuat as $item)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $item['branch'] }}</td>
                                    <td>{{ $item['noiDung'] }}</td>
                                    <td>{{ $item['employee'] }}</td>     
                                    <td>{{ date('H:i d/m/Y',strtotime($item['time'])) }}</td>
                                    <td><a class="btn" onclick="getChiTiet('{{$item['id']}}','{{$item['loaiPhieu']}}');"  data-toggle="modal" data-target="#basicModal">Chi tiết</a></td>
                                   
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
<form id="myform1" autocomplete="off" action="{{ route("searchThongKeXuatSanPham")}}" enctype="multipart/form-data" method="post">
    {{ csrf_field() }}
   
    <input hidden id="chiNhanhTimKiem" name="chiNhanhTimKiem">
    <input hidden id="tenNguoiLap" name="tenNguoiLap">
    <input hidden id="thoiGianTimKiem" name="thoiGianTimKiem">
    <input hidden id="khoangThoiGianTimKiem" name="khoangThoiGianTimKiem">
</form>
<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>
    function getChiTiet(id,loai)
    {
        $.ajax({
            type: 'get',
            url: '{{route("getChiTietThongKePhieuXuat")}}',
            data: {
                'id': id,
                'loai':loai
            },
            success: function(data) {
                document.getElementById('duLieuChiTiet').innerHTML=data;
            }
            });

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


      //  alert($('#thoiGianTimKiem').val());
        $('#myform1').submit();
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


      //  alert($('#thoiGianTimKiem').val());
        $('#myform1').submit();
    }

</script>
@endsection