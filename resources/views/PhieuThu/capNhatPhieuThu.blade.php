@extends('master.masterAdmin')
@section('title')
PHIẾU THU
@endsection
@section('contain')
<div class="content-body">
    <style>
        
        .myInput{
            width: 70%;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
    <!-- <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    </ol>
                </div>
            </div> -->
    <!-- row -->
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
                        @php  $quaTang="";  @endphp
                        <h4 class="card-title">Chi tiết phiếu thu</h4>
                        <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6 ">
                                    <label>Học viên</label>
                                    <input id="id" name="id" hidden value="{{$phieuThu->student_id }}">
                                    <input readonly class="form-control" value="{{$phieuThu->student_firstName }} {{$phieuThu->student_lastName }}">
                                </div>
                                <div class="col-lg-6 ">
                                    <label>Loại Phiếu Thu</label>
                                    <select class="form-control" id="loai" name="loai" required>
                                        @if($phieuThu->receipt_type==0)
                                        <option selected value="0">Thu học phí</option>
                                        @else 
                                        <option selected value="0">Thu học phí</option>
                                        @endif
                                        @foreach($loai as $item)
                                            @if($item->facilityType_id==$phieuThu->receipt_type)
                                            <option selected value="{{ $item->facilityType_id }}">{{ $item->facilityType_name}}</option>
                                            @else 
                                            <option  value="{{ $item->facilityType_id }}">{{ $item->facilityType_name }}</option>
                                            @endif
                                        @endforeach

                                        @if($phieuThu->receipt_type==-1)   
                                        <option selected value="-1">Thu khác</option>
                                        @else 
                                        <option  value="-1">Thu khác</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div id="hocPhi">
                                @if($phieuThu-> receipt_type==0)
                                    <div class="row">
                                        <div class="col-lg-3 ">
                                            <label>Chương trình học</label>
                                            <select class="form-control" id="chuongTrinh" name="chuongTrinh" onchange="changeCTH();"  required>
                                                @foreach($chuongTrinhHoc as $item)
                                                @if ($idCT==$item->studyProgram_id)
                                                <option selected value="{{$item->studyProgram_id}}">{{$item->studyProgram_name}}</option>
                                                @else   
                                                <option value="{{$item->studyProgram_id}}">{{$item->studyProgram_name}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 ">
                                            <label>Khóa học</label>
                                            <div id="duLieuKhoaHoc">

                                                <select class="form-control" id="khoaHoc" name="khoaHoc" onchange="changeKH();"  required>
                                                    @foreach($khoaHoc as $item)
                                                    @if ($khoaDau==$item->course_id)
                                                    <option selected value="{{$item->course_id}}">{{$item->course_name}}</option>
                                                    @else 
                                                    <option value="{{$item->course_id}}">{{$item->course_name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 ">
                                            <label>Số khóa</label>
                                        <input required class="form-control" type="number" name="soKhoa" id="soKhoa" onkeyup="changeKH();" value="{{count($KhoaHocPhieuThu)}}">
                                        </div>
                                        <div class="col-lg-3 ">
                                            <label>Học phí</label>
                                            <input readonly class="form-control" name="tongHocPhi" id="tongHocPhi" value="{{number_format($phieuThu->receipt_price,0,"",".")}}" >
                                          
                                        </div>
                                        <div class="col-lg-3 ">
                                            <label>Giảm giá cố định</label>
                                        <input readonly class="form-control" name="tenGiamGiaCoDinh" id="tenGiamGiaCoDinh" value="{{$tenGiamGiaCoDinh}}">
                                        </div>
                                        <div class="col-lg-3 ">
                                            <label>Phần trăm</label>
                                            <input readonly class="form-control" name="giamGiaCoDinh" id="giamGiaCoDinh" name="{{$phanTramGGCD}}">
                                        </div>
                                        <div class="col-lg-3 ">
                                            <label>Ưu Đãi</label>
                                            <select class="form-control" id="nhanKhuyenMaiCD" name="nhanKhuyenMaiCD" onchange="changeKH();"  required>
                                              @if($phieuThu->receipt_promotion==1)
                                                <option selected value="1">Nhận ưu đãi</option>
                                                <option value="0">Không ưu đãi</option>
                                                @else 
                                                <option value="1">Nhận ưu đãi</option>
                                                <option selected value="0">Không ưu đãi</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-lg-3 ">
                                            <label>Tổng Tiền</label>
                                            <input readonly class="form-control" name="tongTien" id="tongTien" value="{{number_format($phieuThu->receipt_discount,0,"",".")}}">
                                            <input hidden class="form-control" name="tongTienAn" id="tongTienAn" value="{{$phieuThu->receipt_price}}">
                                        </div>
                                        <div class="col-lg-3 ">
                                            <label>Giảm giá khác</label>
                                            {{-- <select class="form-control" id="tenGiamGiaKhac" name="tenGiamGiaKhac" onchange="changeGiamGiaKhac();">
                                                @foreach($chuongTrinhKhuyenMai as $item)
                                                @if($tenGiamKhach == $item->promotions_id)
                                                <option selected value="{{$item->promotions_id}}">{{$item->promotions_name}}</option>
                                                @else 
                                                <option value="{{$item->promotions_id}}">{{$item->promotions_name}}</option>
                                                @endif 
                                                @endforeach
                                            </select> --}}
                                            <input readonly class="form-control" name="tenGiamGiaKhac" id="tenGiamGiaKhac" value="{{$tenGiamKhach}}">
                                        
                                        </div>
                                        <div class="col-lg-3 ">
                                            <label>Phần trăm</label>
                                            <input class="form-control" type="number" name="giamGiaKhac" id="giamGiaKhac" value="{{$phanTramKhac}}">
                                        </div>
                                        <div class="col-lg-3 ">
                                            <label>Ưu Đãi</label>
                                            <select class="form-control" id="nhanKhuyenMaiKhac" name="nhanKhuyenMaiKhac" onchange="changeKH();"  required>
                                                @if($phieuThu->receipt_promotion==1)
                                                <option selected value="1">Nhận ưu đãi</option>
                                                <option value="0">Không ưu đãi</option>
                                                @else 
                                                <option value="1">Nhận ưu đãi</option>
                                                <option selected value="0">Không ưu đãi</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-lg-3 ">
                                            <label>Số dư</label>

                                            <input readonly class="form-control" type="number" name="giamGiaKhac" id="giamGiaKhac" value="{{$soDu}}">
                                       
                                            
                                        </div>
                                        <div class="col-lg-3 ">
                                            <label>Thanh toán</label>
                                            <input class="form-control" type="number" name="thanhToan" id="thanhToan" value="{{$phieuThu->receipt_total}}">
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Ghi chú</label>
                                            <textarea class="form-control" id="ghiChu" name="ghiChu">{{$phieuThu->receipt_note}}</textarea>
                                        </div>
                                    </div>                               
                                    <br>
                                    {{-- <h3>Quà tặng kèm</h3>
                                    <div class="row">
                                        <div class="col-lg-4 ">
                                            <label>Sản phẩm</label>
                                        <select class="form-control" id="sanPham" name="sanPham">
                                            @foreach($sanPham as $item)   
                                                <option value="{{$item->facility_id}}">{{$item->facility_name}}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <label>Số lượng</label>
                                            <input class="form-control" type="number" id="soLuong" name="soLuong">
                                        </div>
                                        <div class="col-lg-4" style="padding: 30px;">
                                            
                                            <button type="button" class="btn mb-1 btn-outline-success" onclick="btnThem();">Thêm</button>
                                        </div>
                                    </div> --}}
                                    <br>
                                    <h3><i class="fa fa-list"></i> Danh sách khóa học</h3>
                                    <table class="table  table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th style="width:5px">STT</th>
                                                <th>Chương trình học</th>
                                                <th>Khóa học</th>
                                                <th>Học phí</th>
                                            </tr>
                                        </thead>
                                        <tbody id="duLieuSearch">
                                            @php $i=1; @endphp
                                            @foreach ($KhoaHocPhieuThu as $item)
                                                <tr>
                                                    <td> @php echo $i; @endphp</td>
                                                    <td>{{$item->studyProgram_code}}</td>
                                                    <td>{{$item->course_name}}</td>
                                                    <td>{{number_format( $item->receiptDeatil_price,0,"",".")}}</td>
                                                </tr>
                                            @php $i++; @endphp
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <h3><i class="fa fa-list"></i> Danh sách quà tặng</h3>
                                    <div id="duLieuQuaTang">
                                        <table class="table  table-bordered " id="danhSachSanPham">
                                            <thead>
                                                <tr>
                                                    <th style="width:5px">STT</th>
                                                    <th>Sản Phẩm</th>
                                                    <th>Số lượng</th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody >
                                                @php $i=1; $quaTang="";  @endphp
                                                
                                                @foreach ($sanPhamPhieuThu as $item)
                                                    <tr >
                                                        <td> @php echo $i; @endphp</td>
                                                        <td>{{$item->facility_name}}</td>
                                                        <td>{{$item->receiptFacility_number}}</td>
                                                        </tr>

                                                        @php $quaTang.= $item->receiptFacility_number ." ". $item->facility_name.". "; @endphp
                                                @php $i++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            <div id="banSach" >
                                @if($phieuThu-> receipt_type>0)
                                <div class="row">
                                   
                                
                                    <div class="col-lg-8">
                                     <label>Nội dung thu</label>
                                        <input required class="form-control" id="noiDungThuBanSach" name="noiDungThuBanSach" value="{{$phieuThu->receipt_name}}">
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Tổng tiền</label>
                                        <input readonly class="form-control" id="tongTienBanSach" name="tongTienBanSach" value="{{$phieuThu->receipt_total}}">
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Ghi chú</label>
                                        <textarea class="form-control" id="ghiChuBanSach" name="ghiChuBanSach">{{$phieuThu->receipt_note}}</textarea>
                                    </div>
                                </div>
                                <br>
                                <h3><i class="fa fa-list"></i> Danh sách vật phẩm</h3>
                                <div id="duLieuBanSach">
                                    <table class="table  table-bordered " id="danhSachSanPhamBanSach">
                                        <thead>
                                            <tr>
                                                <th>Sản Phẩm</th>
                                                <th>Số lượng</th>
                                                <th>Đơn giá</th>
                                                <th>Thành tiền</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @php $i=1; $quaTang=""; @endphp
                                            @foreach ($sanPhamPhieuThu as $item)
                                                <tr >
                                                    <td>{{$item->facility_name}}</td>
                                                    <td>{{$item->receiptFacility_number}}</td>
                                                    <td>{{number_format($item->receiptFacility_price,0,"",".")}}</td>
                                                    <td>{{number_format($item->receiptFacility_number * $item->receiptFacility_price,0,"",".")}}</td>
                                                    </tr>
                                            @php $i++; @endphp
                                            @php $quaTang.= $item->receiptFacility_number ." ". $item->facility_name.". "; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                                
                            </div>

                            <div id="thuKhac" >
                                @if($phieuThu-> receipt_type==-1)
                                <div class="row"> <div class="col-lg-8">
                                    <label>Nội dung thu</label>
                                    <input required class="form-control" id="noiDungThuKhac" name="noiDungThuKhac" value="{{$phieuThu->receipt_name}}">
                                  </div>
                                  
                                  <div class="col-lg-4">
                                      <label>Tiền thu</label>
                                      <input required class="form-control" id="tienThuKhac" name="tienThuKhac" value="{{$phieuThu->receipt_total}}">
                                  </div>
                                  <div class="col-lg-12">
                                      <label>Ghi chú</label>
                                      <textarea class="form-control" id="ghiChuThuKhac" name="ghiChuThuKhac">{{$phieuThu->receipt_note}}</textarea>
                                  </div>
                                  </div>
                                @endif
                               
                            </div>
                            <div style="text-align: center;padding:10px">
                                <div class="row">
                                <div class="col-lg-4">
                                    </div>
                                <div class="col-lg-4">
                                @if (session('quyen3031')==1)
                                    
        
                                    <button id="btnXuatPhieuThu" type="button"  onclick="xuatPhieuThu();"  class="btn mb-1 btn-outline-primary">XUẤT PHIẾU THU</button>
                              
                                @endif
                            </div>
                                <div class="col-lg-4">
                                  </div>
                                </div>
                            </div>
                            <input hidden id="themMoi" value="0">
                            <input hidden id="soPhieu" value="{{$phieuThu->receipt_number}}">
                            <input hidden id="noiDung" value="{{ $phieuThu->receipt_name}}">
                            <input hidden id="soTien" value="{{number_format($phieuThu->receipt_total,0,"",".")}}">
                            <input hidden id="bangChu" value="{{$bangChu}} đồng">
                            <input hidden id="quaTang" value="{{$quaTang}}">
                            <input hidden id="tienGoc" value="{{number_format($phieuThu->receipt_price,0,"",".")}}">
                        <input hidden id="bangChuTienGoc" value="{{$bangChuTienGoc}} đồng">
                        <input hidden id="tenKM" value="{{$tenGiamGiaCoDinh}}. {{$tenGiamKhach}}">
                        <input hidden id="ghiChuPhieuThu" value="{{$phieuThu->receipt_note}}">
                    </div>
                    </form>


                    @foreach($sanPham as $item)   
                            <input hidden id="tonKho{{$item->facility_id}}" value="{{$item->inventory_amount}}">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<input hidden id="tongTienSP" value="0">
<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>
    function btnXoaDuLieu()
    {
        $loai = $('#loai').val();
        if($loai==0)
        {
        $('#soKhoa').val("");
        $('#tenGiamGiaCoDinh').val("");
        $('#giamGiaCoDinh').val("");
        $('#tongTien').val("0");
        $('#giamGiaKhac').val(0);
        $('#thanhToan').val("");
        $('#ghiChu').val("");
       document.getElementById('duLieuSearch').innerHTML="";


       document.getElementById('duLieuQuaTang').innerHTML=' <table class="table  table-bordered " id="danhSachSanPham">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>Sản Phẩm</th>'+
                                                '<th>Số lượng</th>'+
                                                '<th>Xóa</th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody >'+
                                        '</tbody>'+
                                    '</table>';

        }else if($loai==1)
        {
       $('#noiDungThuBanSach').val("");
        $('#tongTienBanSach').val("");
        $('#ghiChuBanSach').val("");
        document.getElementById('duLieuBanSach').innerHTML='<table class="table  table-bordered " id="danhSachSanPhamBanSach">'+
                                    '<thead>'+
                                        '<tr>'+
                                            '<th>Sản Phẩm</th>'+
                                            '<th>Số lượng</th>'+
                                            '<th>Đơn giá</th>'+
                                            '<th>Thành tiền</th>'+
                                            '<th>Xóa</th>'+
                                       '</tr>'+
                                    '</thead>'+
                                    '<tbody >'+
                                    '</tbody>'+
                                '</table>';
        }else
        {
            $('#noiDungThuKhac').val("");
            $('#tienThuKhac').val("");
            $('#ghiChuThuKhac').val("");
           
        }

      
        $('#themMoi').val(0);
        $('#btnLuuPhieuThu').prop('disabled', false);
        $('#btnXuatPhieuThu').prop('disabled', true);
    }
    function xuatPhieuThu()
    {
                $loai = $('#themMoi').val();
                $soPhieu = $('#soPhieu').val();
                $noiDung = $('#noiDung').val();
                $soTien = $('#soTien').val();
                $bangChu = $('#bangChu').val();
                $quaTang = $('#quaTang').val();

                $tienGoc = $('#tienGoc').val();
                $bangChuTienGoc = $('#bangChuTienGoc').val();
                $tenKM = $('#tenKM').val();
                $ghiChuPhieuThu = $('#ghiChuPhieuThu').val();


      
            var code = $("#code1").val();
            var ngayLay=$("#ngayLay").val();
            let current_datetime = new Date(ngayLay);
            let formatted_date = current_datetime.getDate() + "/"
                + (current_datetime.getMonth() + 1) + "/"
                + current_datetime.getFullYear();
            var display_setting="toolbar=yes,menubar=yes,";
            display_setting+="scrollbars=yes,width=1000, height=1000, left=100, top=0";
            var printpage=window.open("","",display_setting);


            printpage.document.open();
            printpage.document.write('<!DOCTYPE html><html><head><title></title><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"></head>');
            printpage.document.write('<body onLoad="self.print()">'+
                '<style>\n' +
                'span{'+
                  'display:block;font-size:19px'+  
                '}'+
                '</style>'+
              
            '<div style="height : 510px">'+         
                '<div style="display:inline-block;width:30%">' +
                    @if($chiNhanh->branch_link=="")
                   ' <img style="width: 200px;height:75px" src="{{asset('images/'.$chiNhanh->branch_logo)}}"><br>'+
                   @else
                   ' <img style="width: 200px;height:75px" src="https://drive.google.com/uc?id={{$chiNhanh->branch_link}}"><br>'+
                   @endif
                    '<i class="fa fa-map-marker"></i> {{$chiNhanh->branch_address}}<br>'+
                    '<i class="fa fa-phone"></i> {{$chiNhanh->branch_address}}<br>'+
                    '<i class="fa fa-envelope"></i> {{$chiNhanh->branch_mail}}<br>'+
                    '<i class="fa fa-facebook"></i> {{$chiNhanh->branch_name}}<br>'+
                '</div>'+
                '<div style="display:inline-block;width:40%;text-align: center">' +
                    '<span style="font-size: 25px;">PHIẾU THU</span>'+
                    '<span>Ngày {{date("d"),strtotime($thoiGian)}} Tháng {{date("m"),strtotime($thoiGian)}} Năm {{date("Y"),strtotime($thoiGian)}}</span>'+
               '</div>'+
               '<div style="display:inline-block;width:30%">' +
                '<span style="font-size: 25px;">Số: {{$chiNhanh->branch_code}}_'+$soPhieu+'</span>'+
                         
               '</div>'+
               '<div>'+
               '<span style="font-size: 19px">Họ tên người nộp tiền: {{$phieuThu->student_firstName }} {{$phieuThu->student_lastName }}</span>'+
               '<span style="font-size: 19px">Địa chỉ: {{$phieuThu->student_address }}</span>'+
               '<span style="font-size: 19px">Lý do nộp: '+$noiDung+'</span>'+
               '<span style="font-size: 19px">Số tiền:  '+$tienGoc+'   ( '+$bangChuTienGoc+' đồng )</span>'+
               '<span style="font-size: 19px">Ưu đãi: '+$tenKM+'</span>'+
               '<span style="font-size: 19px">Số tiền cần nộp:  '+$soTien+'   ( '+$bangChu+' đồng )</span>'+
               '</div>'+
               '<div style="display:inline-block;width:50%"><span style="font-size: 19px">Quà tặng:   '+$quaTang+'</span></div>'+
               '<div style="display:inline-block;width:50%"><span style="font-size: 19px">  Ghi chú: '+$ghiChuPhieuThu+'</span></div>'+
               
               '<div style="display:inline-block;width:25%;text-align:center">' +
                '<span style="font-size: 19px"><b>Tổng giám đốc</b></span>'+
                '<span>(ký,họ tên, đóng dấu)</span>'+
                '</div>'+
                '<div style="display:inline-block;width:25%;text-align:center">' +
                    '<span style="font-size: 19px"><b>Người nộp</b></span>'+
                '<span>(ký,họ tên)</span>'+
                '</div>'+
                '<div style="display:inline-block;width:25%;text-align:center">' +
                    '<span style="font-size: 19px"><b>Người lập phiếu</b></span>'+
                '<span>(ký,họ tên)</span>'+
                '</div>'+
                '<div style="display:inline-block;width:25%;text-align:center">' +
                    '<span style="font-size: 19px"><b>Thủ quỹ</b></span>'+
                '<span>(ký,họ tên)</span>'+
                '</div>'+

            '</div>'+    
            '<hr style="border-top: 3px dashed red;width: 55%">'+
            '<div>'+         
                '<div style="display:inline-block;width:30%">' +
                    @if($chiNhanh->branch_link=="")
                   ' <img style="width: 200px;height:75px" src="{{asset('images/'.$chiNhanh->branch_logo)}}"><br>'+
                   @else
                   ' <img style="width: 200px;height:75px" src="https://drive.google.com/uc?id={{$chiNhanh->branch_link}}"><br>'+
                   @endif
                    '<i class="fa fa-map-marker"></i> {{$chiNhanh->branch_address}}<br>'+
                    '<i class="fa fa-phone"></i> {{$chiNhanh->branch_address}}<br>'+
                    '<i class="fa fa-envelope"></i> {{$chiNhanh->branch_mail}}<br>'+
                    '<i class="fa fa-facebook"></i> {{$chiNhanh->branch_name}}<br>'+
                '</div>'+
                '<div style="display:inline-block;width:40%;text-align: center">' +
                    '<span style="font-size: 25px;">PHIẾU THU</span>'+
                    '<span>Ngày {{date("d"),strtotime($thoiGian)}} Tháng {{date("m"),strtotime($thoiGian)}} Năm {{date("Y"),strtotime($thoiGian)}}</span>'+
               '</div>'+
               '<div style="display:inline-block;width:30%">' +
                '<span style="font-size: 25px;">Số: {{$chiNhanh->branch_code}}_'+$soPhieu+'</span>'+
                         
               '</div>'+
               '<div>'+
               '<span style="font-size: 19px">Họ tên người nộp tiền: {{$phieuThu->student_firstName }} {{$phieuThu->student_lastName }}</span>'+
               '<span style="font-size: 19px">Địa chỉ: {{$phieuThu->student_address }}</span>'+
               '<span style="font-size: 19px">Lý do nộp: '+$noiDung+'</span>'+
               '<span style="font-size: 19px">Số tiền:  '+$tienGoc+'   ( '+$bangChuTienGoc+' đồng )</span>'+
               '<span style="font-size: 19px">Ưu đãi: '+$tenKM+'</span>'+
               '<span style="font-size: 19px">Số tiền cần nộp:  '+$soTien+'   ( '+$bangChu+' đồng )</span>'+
               '</div>'+
               '<div style="display:inline-block;width:50%"><span style="font-size: 19px">Quà tặng:   '+$quaTang+'</span></div>'+
               '<div style="display:inline-block;width:50%"><span style="font-size: 19px">  Ghi chú: '+$ghiChuPhieuThu+'</span></div>'+
               
               '<div style="display:inline-block;width:25%;text-align:center">' +
                '<span style="font-size: 19px"><b>Tổng giám đốc</b></span>'+
                '<span>(ký,họ tên, đóng dấu)</span>'+
                '</div>'+
                '<div style="display:inline-block;width:25%;text-align:center">' +
                    '<span style="font-size: 19px"><b>Người nộp</b></span>'+
                '<span>(ký,họ tên)</span>'+
                '</div>'+
                '<div style="display:inline-block;width:25%;text-align:center">' +
                    '<span style="font-size: 19px"><b>Người lập phiếu</b></span>'+
                '<span>(ký,họ tên)</span>'+
                '</div>'+
                '<div style="display:inline-block;width:25%;text-align:center">' +
                    '<span style="font-size: 19px"><b>Thủ quỹ</b></span>'+
                '<span>(ký,họ tên)</span>'+
                '</div>'+

            '</div>'+    
                '</body>'+
                '</html>');
            printpage.document.close();
            printpage.focus();

          
    }



    function btnThem()
    {
        $soLuong = $('#soLuong').val();
        $id = $('#sanPham').val();
        themSanPham($id,$soLuong)
    }

     function themSanPham(id,soLuong1) {
            var sanPham = id;
            var soLuong = soLuong1;
            var dongia=0;
            var ten=0;
            var soLuongSanPham = $('#soLuongSanPham').val();
            
            if(soLuong>0)
                {
                    @foreach($sanPham as $item)
                          ten="{{$item->facility_name}}";
                        if ($('#soLuong{{$item->facility_id}}').val()>=0 && sanPham == {{$item->facility_id }})
                        {
                            $soLuongThem =parseInt($('#soLuong{{$item->facility_id}}').val())+ parseInt(soLuong);
                           if ($soLuongThem <= $('#tonKho{{$item->facility_id}}').val())
                           {
                               $('#soLuong{{$item->facility_id}}').val($soLuongThem);
                           }
                           else
                                KiemTra("Quà Tặng","Số lượng không đủ");
                            }
        
                        else
                        {
                            if (sanPham == {{$item->facility_id}}) {
                                if (parseInt(soLuong)  <=parseInt( $('#tonKho{{$item->facility_id}}').val())) {
                                    var table = document.getElementById("danhSachSanPham");
                                    var row = table.insertRow();
                                    row.id = "row{{$item->facility_id}}";
                                    var cell1 = row.insertCell();
                                    var cell3 = row.insertCell();
                                    var cell5 = row.insertCell();
                                    cell1.innerHTML = ten;
                                    cell3.innerHTML = "<input class='myInput'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='change({{$item->facility_id}});' style='width: 50%; text-align: right; '  id='soLuong" + sanPham + "'  name='soLuong" + sanPham + "' value='" + soLuong + "'>" +
                                        "<button class='btn mb-1 btn-outline-primary'  type='button' onclick='themSanPham({{$item->facility_id}},1);' ><i class='fa fa-plus'></i></button>" +
                                        "<button class='btn mb-1 btn-outline-danger' type='button' onclick='truSanPham({{$item->facility_id}},1);'><i class='fa fa-minus'></i></button>";
                                  
                                    cell5.innerHTML = "<a onclick='XoaTR({{$item->facility_id}});'><i class='fa fa-trash'></i></a>";
                                    cell1.id = "sanPham" + sanPham;
                                    cell3.id = "soLuong1" + sanPham;
                                    cell5.id = "xoa" + sanPham;
                                } else
                                   KiemTra("Quà Tặng","Số lượng không đủ");
                            }

                        }
                        @endforeach
                
               }
        }
        function change(id)
        {
                    $soLuong =$('#soLuong'+id).val();
                    if ( parseInt($soLuong) <= parseInt($('#tonKho'+id).val()))
                    {
                       
                    }
                    else
                    {

                        KiemTra("Quà Tặng","Số lượng không đủ");
                        $('#soLuong'+id).val($('#tonKho'+id).val());
                    }
        }

        function truSanPham(id,soLuong1) {
            var sanPham = id;
            var soLuong = soLuong1;
            var dongia=0;
            var ten=0;
            var soLuongSanPham = $('#soLuongSanPham').val();
            if(soLuong>0)
            {
                @foreach($sanPham as $item)
                  
                ten="{{$item->facility_name}}";
                if ( sanPham == {{$item->facility_id }})
                {
                    $soLuongThem =parseInt($('#soLuong{{$item->facility_id}}').val())- parseInt(soLuong);
                    if($soLuongThem>0)
                    {
                        $('#soLuong{{$item->facility_id}}').val($soLuongThem);
                    }
                }
                @endforeach
                  
            }
        }
        function XoaTR(id) {
            var row = document.getElementById("row"+id);
            row.parentNode.removeChild(row);
          
        }
    function changeLoaiThu() {
        $loai = $('#loai').val();
        if($loai==0)
        {
            document.getElementById('hocPhi').innerHTML=' <div class="row">'+
                                    '<div class="col-lg-4 ">'+
                                        '<label>Chương trình học</label>'+
                                        '<select class="form-control" id="chuongTrinh" name="chuongTrinh" onchange="changeCTH();" required>'+
                                            @foreach($chuongTrinhHoc as $item)
                                            '<option value="{{$item->studyProgram_id}}">{{$item->studyProgram_name}}</option>'+
                                            @endforeach
                                        '</select>'+
                                    '</div>'+
                                    '<div class="col-lg-4 ">'+
                                        '<label>Khóa học</label>'+
                                        '<div id="duLieuKhoaHoc">'+
                                            '<select class="form-control" id="khoaHoc" name="khoaHoc" onchange="changeKH();" required>'+
                                                @foreach($khoaHoc as $item)
                                                '<option value="{{$item->course_id}}">{{$item->course_name}}</option>'+
                                                @endforeach
                                            '</select>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-lg-4 ">'+
                                        '<label>Số khóa</label>'+
                                        '<input required class="form-control" type="number" name="soKhoa" id="soKhoa" onkeyup="changeKH();">'+
                                    '</div>'+

                                    '<div class="col-lg-4 ">'+
                                        '<label>Giảm giá cố định</label>'+
                                        '<input readonly class="form-control" name="tenGiamGiaCoDinh" id="tenGiamGiaCoDinh">'+
                                    '</div>'+
                                    '<div class="col-lg-4 ">'+
                                        '<label>Phần trăm</label>'+
                                        '<input readonly class="form-control" name="giamGiaCoDinh" id="giamGiaCoDinh">'+
                                    '</div>'+
                                    '<div class="col-lg-4 ">'+
                                        '<label>Tổng Tiền</label>'+
                                        '<input readonly class="form-control" name="tongTien" id="tongTien">'+
                                        '<input hidden class="form-control" name="tongTienAn" id="tongTienAn">'+
                                    '</div>'+
                                    '<div class="col-lg-4 ">'+
                                        '<label>Giảm giá khác</label>'+
                                        '<select class="form-control" id="tenGiamGiaKhac" name="tenGiamGiaKhac" onchange="changeGiamGiaKhac();">'+
                                            @foreach($chuongTrinhKhuyenMai as $item)
                                            '<option value="{{$item->promotions_id}}">{{$item->promotions_name}}</option>'+
                                            @endforeach
                                        '</select>'+
                                    '</div>'+
                                   '<div class="col-lg-4 ">'+
                                        '<label>Phần trăm</label>'+
                                        '<input class="form-control" type="number" name="giamGiaKhac" id="giamGiaKhac">'+
                                    '</div>'+
                                    '<div class="col-lg-4 ">'+
                                        '<label>Thanh toán</label>'+
                                        '<input class="form-control" type="number" name="thanhToan" id="thanhToan">'+
                                    '</div>'+
                                    '<div class="col-lg-12">'+
                                        '<label>Ghi chú</label>'+
                                        '<textarea class="form-control" id="ghiChu" name="ghiChu"></textarea>'+
                                    '</div>'+
                                '</div>'+
                                '<br>'+
                                '<h3>Quà tặng kèm</h3>'+
                                '<div class="row">'+
                                    '<div class="col-lg-4 ">'+
                                        '<label>Sản phẩm</label>'+
                                       '<select class="form-control" id="sanPham" name="sanPham">'+
                                        @foreach($sanPham as $item)   
                                            '<option value="{{$item->facility_id}}">{{$item->facility_name}}</option>'+
                                        @endforeach
                                       '</select>'+
                                    '</div>'+
                                    '<div class="col-lg-4 ">'+
                                        '<label>Số lượng</label>'+
                                        '<input class="form-control" type="number" id="soLuong" name="soLuong">'+
                                    '</div>'+
                                    '<div class="col-lg-4" style="padding: 30px;">'+
                                        
                                        '<button type="button" class="btn mb-1 btn-outline-success" onclick="btnThem();">Thêm</button>'+
                                    '</div>'+
                                '</div>'+
                                '<br>'+
                                '<h3><i class="fa fa-list"></i> Danh sách khóa học</h3>'+
                                '<table class="table  table-bordered zero-configuration">'+
                                    '<thead>'+
                                        '<tr>'+
                                            '<th>STT</th>'+
                                            '<th>Chương trình học</th>'+
                                            '<th>Khóa học</th>'+
                                            '<th>Học phí</th>'+
                                        '</tr>'+
                                    '</thead>'+
                                    '<tbody id="duLieuSearch">'+
                                    '</tbody>'+
                                '</table>'+
                                '<h3><i class="fa fa-list"></i> Danh sách quà tặng</h3>'+
                                '<div id="duLieuQuaTang">'+
                                    '<table class="table  table-bordered " id="danhSachSanPham">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>Sản Phẩm</th>'+
                                                '<th>Số lượng</th>'+
                                                '<th>Xóa</th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody >'+
                                        '</tbody>'+
                                    '</table>'+
                                '</div>';

             document.getElementById('banSach').innerHTML = "";
             document.getElementById('thuKhac').innerHTML = "";             
        }
        else  if($loai==1)
        {
            document.getElementById('banSach').innerHTML = '<div class="row">'+
                                   
                                
                                   '<div class="col-lg-8">'+
                                    '<label>Nội dung thu</label>'+
                                       '<input required class="form-control" id="noiDungThuBanSach" name="noiDungThuBanSach">'+
                                   '</div>'+
                                   '<div class="col-lg-4">'+
                                       '<label>Tổng tiền</label>'+
                                       '<input readonly class="form-control" id="tongTienBanSach" name="tongTienBanSach">'+
                                   '</div>'+
                                   '<div class="col-lg-12">'+
                                       '<label>Ghi chú</label>'+
                                       '<textarea class="form-control" id="ghiChuBanSach" name="ghiChuBanSach"></textarea>'+
                                   '</div>'+
                               '</div>'+
                               '<br>'+
                               '<div class="row">'+
                                   '<div class="col-lg-4 ">'+
                                       '<label>Sản phẩm</label>'+
                                      '<select class="form-control" id="sanPhamBanSach" name="sanPhamBanSach">'+
                                       @foreach($sanPham as $item)   
                                           '<option value="{{$item->facility_id}}">{{$item->facility_name}}</option>'+
                                       @endforeach
                                      '</select>'+
                                   '</div>'+
                                   '<div class="col-lg-4 ">'+
                                       '<label>Số lượng</label>'+
                                       '<input class="form-control" type="number" id="soLuongBanSach" name="soLuongBanSach">'+
                                   '</div>'+
                                   '<div class="col-lg-4" style="padding: 30px;">'+
                                       
                                       '<button type="button" class="btn mb-1 btn-outline-success" onclick="btnThemBanSach();">Thêm</button>'+
                                   '</div>'+
                               '</div>'+

                               '<h3><i class="fa fa-list"></i> Danh sách vật phẩm</h3>'+
                               '<div id="duLieuBanSach">'+
                                   '<table class="table  table-bordered " id="danhSachSanPhamBanSach">'+
                                       '<thead>'+
                                           '<tr>'+
                                               '<th>Sản Phẩm</th>'+
                                               '<th>Số lượng</th>'+
                                               '<th>Đơn giá</th>'+
                                               '<th>Thành tiền</th>'+
                                               '<th>Xóa</th>'+
                                           '</tr>'+
                                       '</thead>'+
                                       '<tbody >'+
                                       '</tbody>'+
                                   '</table>'+
                               '</div>';
             document.getElementById('hocPhi').innerHTML = "";
             document.getElementById('thuKhac').innerHTML = "";     
        }
        else
        {
             document.getElementById('thuKhac').innerHTML = ' <div class="row"> <div class="col-lg-8">'+
                                  '<label>Nội dung thu</label>'+
                                  '<input required class="form-control" id="noiDungThuKhac" name="noiDungThuKhac">'+
                                '</div>'+
                                
                                '<div class="col-lg-4">'+
                                    '<label>Tiền thu</label>'+
                                    '<input required class="form-control" id="tienThuKhac" name="tienThuKhac">'+
                                '</div>'+
                                '<div class="col-lg-12">'+
                                    '<label>Ghi chú</label>'+
                                    '<textarea class="form-control" id="ghiChuThuKhac" name="ghiChuThuKhac"></textarea>'+
                                '</div>'+
                                '</div>';
             document.getElementById('hocPhi').innerHTML = "";
             document.getElementById('banSach').innerHTML = "";  
        }

        // if ($loai == 0) {
        //     document.getElementById('hocPhi').style = "display: block";
        //     document.getElementById('banSach').style = "display: none";
        //     document.getElementById('thuKhac').style = "display: none";
        // } else if ($loai == 1) {
        //     document.getElementById('hocPhi').style = "display: none";
        //     document.getElementById('banSach').style = "display: block";
        //     document.getElementById('thuKhac').style = "display: none";
        // } else {
        //     document.getElementById('hocPhi').style = "display: none";
        //     document.getElementById('banSach').style = "display: none";
        //     document.getElementById('thuKhac').style = "display: block";
        // }
    }

    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{ route("postThemPhieuThu")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data[0]['loai']== 1) {
                    ThemThanhCong("Thêm phiếu thu", "Thêm thành công!!!");
                    $('#themMoi').val(1);
                    $('#soPhieu').val(data[0]['soPhieuThu']);
                    $('#noiDung').val(data[0]['noiDung']);
                    $('#soTien').val(data[0]['soTien']);
                    $('#bangChu').val(data[0]['bangChu']);
                    $('#quaTang').val(data[0]['quaTang']);


                    $('#tienGoc').val(data[0]['tienGoc']);
                    $('#bangChuTienGoc').val(data[0]['bangChuTienGoc']);
                    $('#tenKM').val(data[0]['tenKM']);

                  
                    $('#btnXuatPhieuThu').prop('disabled', false);

                } else if (data[0]['loai'] == 2) {
                    KiemTra("Thêm phiếu thu", "Bạn không có quyền thêm!!!");
                } else if (data[0]['loai'] == 3) {
                    KiemTra("Thêm phiếu thu", "Số đt HV và Số đt PH ít nhất có một!!!");
                } else {
                    PhatHienLoi('Thêm phiếu thu', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });

    function changeCTH() {
        $chuongTrinhHoc = $('#chuongTrinh').val();
        $khoaHoc = $('#khoaHoc').val();
        $soKhoa = $('#soKhoa').val();

        $tenGiamGiaKhac = $('#tenGiamGiaKhac').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchCTHThemPhieuThu")}}',
            data: {
                'chuongTrinhHoc': $chuongTrinhHoc,
                'khoaHoc': $khoaHoc,
                'soKhoa': $soKhoa,
                'tenGiamGiaKhac': $tenGiamGiaKhac
            },
            success: function(data) {
                document.getElementById('duLieuKhoaHoc').innerHTML = data[0]['khoaHoc'];
                document.getElementById('duLieuSearch').innerHTML = data[0]['khoaChon'];
                $('#tongTien').val(data[0]['tongTienformat']);
                $('#tongTienAn').val(data[0]['tongTien']);


                $('#tenGiamGiaCoDinh').val(data[0]['tenKM']);
                $('#giamGiaCoDinh').val(data[0]['phanTram'] + "% - " + data[0]['soKhoa'] + " khóa");
                $('#thanhToan').val(data[0]['thanhToan']);
                $('#giamGiaKhac').val(data[0]['phanTramKMK']);

            }
        });

    }

    function changeKH() {
        $chuongTrinhHoc = $('#chuongTrinh').val();
        $khoaHoc = $('#khoaHoc').val();
        $soKhoa = $('#soKhoa').val();

        $tenGiamGiaKhac = $('#tenGiamGiaKhac').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchKHThemPhieuThu")}}',
            data: {
                'chuongTrinhHoc': $chuongTrinhHoc,
                'khoaHoc': $khoaHoc,
                'soKhoa': $soKhoa,
                'tenGiamGiaKhac': $tenGiamGiaKhac
            },
            success: function(data) {
                document.getElementById('duLieuSearch').innerHTML = data[0]['khoaChon'];
                $('#tongTien').val(data[0]['tongTienformat']);
                $('#tongTienAn').val(data[0]['tongTien']);

                $('#tenGiamGiaCoDinh').val(data[0]['tenKM']);
                $('#giamGiaCoDinh').val(data[0]['phanTram'] + "% - " + data[0]['soKhoa'] + " khóa");

                $('#thanhToan').val(data[0]['thanhToan']);
                $('#giamGiaKhac').val(data[0]['phanTramKMK']);



            }
        });

    }

    function changeGiamGiaKhac() {
        $tenGiamGiaKhac = $('#tenGiamGiaKhac').val();
        $tongTien = $('#tongTienAn').val();
        $khoaHoc = $('#khoaHoc').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searhTongTienGiaKhac")}}',
            data: {
                'tongTien': $tongTien,
                'tenGiamGiaKhac': $tenGiamGiaKhac,
                'khoaHoc': $khoaHoc
            },
            success: function(data) {

                $('#thanhToan').val(data[0]['thanhToan']);
                $('#giamGiaKhac').val(data[0]['phanTram']);



            }
        });
    }

    function btnThemBanSach()
    {
        $id= $('#sanPhamBanSach').val();
        $soLuong = $('#soLuongBanSach').val();
        themSanPhamBanSach($id,$soLuong);
       
    }
    function  format_curency(money) {
        money = money.toString().replace(/(\d)(?=(\d{3})(?!\d))/g, "$1.");
    return money;
    }
    function tinhTong() {
            $tongTien = 0;
            @foreach($sanPham as $item)
            if($('#soLuongBanSach{{$item->facility_id}}').length > 0 
            && $('#soLuongBanSach{{$item->facility_id}}').val() != '')
            {

                $tongTien+=$('#soLuongBanSach{{$item->facility_id}}').val()*{{$item->facility_price}};
            }
            @endforeach


           $('#tongTienBanSach').val($tongTien);
        
        }
    function themSanPhamBanSach(id,soLuong1) {
            var sanPham = id;
            var soLuong = soLuong1;
            var dongia=0;
            var ten=0;
            var soLuongSanPham = $('#soLuongSanPham').val();
            if(soLuong>0)
                {
                    @foreach($sanPham as $item)

                        dongia={{$item->facility_price}};
                          ten="{{$item->facility_name}}";
                        if ($('#soLuongBanSach{{$item->facility_id}}').val()>=0 && sanPham == {{$item->facility_id }})
                        {
                            $soLuongThem =parseInt($('#soLuongBanSach{{$item->facility_id}}').val())
                            + parseInt(soLuong);
                           if ($soLuongThem <= $('#tonKho{{$item->facility_id}}').val())
                           {
                               $('#soLuongBanSach{{$item->facility_id}}').val($soLuongThem);
                               $('#thanhTienBanSach{{$item->facility_id}}').text( format_curency($soLuongThem*dongia)+" đ");
                               $tongTienThem = parseInt($('#tongTienSP').val())+ parseInt(soLuong) * parseInt(dongia);
                               $('#tongTienSP').val($tongTienThem);
                           }
                           else
                           KiemTra("Sản phẩm","Số lượng không đủ");
                        }
                
                        else
                        {
                            if (sanPham == {{$item->facility_id}}) {
                                if (parseInt(soLuong)  <=parseInt( $('#tonKho{{$item->facility_id}}').val())) {
                                    var table = document.getElementById("danhSachSanPhamBanSach");
                                    var row = table.insertRow();
                                    row.id = "rowBanSach{{$item->facility_id}}";
                                    var cell1 = row.insertCell();
                                    var cell2 = row.insertCell();
                                    var cell3 = row.insertCell();
                                    var cell4 = row.insertCell();
                                    var cell5 = row.insertCell();
                                    cell1.innerHTML = ten;
                                    cell2.innerHTML = format_curency(dongia)+" đ";
                                    cell3.innerHTML = "<input class='myInput'   onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='changeBanSach({{$item->facility_id}});' style='width: 50%; text-align: right; '  id='soLuongBanSach" + sanPham + "' name='soLuongBanSach" + sanPham + "' value='" + soLuong + "'>" +
                                        "<button  class='btn mb-1 btn-outline-primary' onclick='themSanPhamBanSach({{$item->facility_id}},1);' ><i class='fa fa-plus'></i></button>" +
                                        "<button class='btn mb-1 btn-outline-danger' onclick='truSanPhamBanSach({{$item->facility_id}},1);'><i class='fa fa-minus'></i></button>";
                                    cell4.innerHTML = format_curency(soLuong*dongia)+" đ";
                                    cell5.innerHTML = "<a href='#' onclick='XoaTRBanSach({{$item->facility_id}});'><i class='fa fa-trash'></i></a>";
                                    cell1.id = "sanPhamBanSach" + sanPham;
                                    cell2.id = "donGiaBanSach" + sanPham;
                                    cell3.id = "soLuong1BanSach" + sanPham;
                                    cell4.id = "thanhTienBanSach" + sanPham;
                                    cell5.id = "xoaBanSach" + sanPham;
                                    $('#tongTienSP').val(parseInt($('#tongTienSP').val()) + parseInt(soLuong) * parseInt(dongia));

                                } else
                                KiemTra("Sản phẩm","Số lượng không đủ");
                            }

                        }
                        @endforeach
                        tinhTong();
               }
        }

        function truSanPhamBanSach(id,soLuong1) {
            var sanPham = id;
            var soLuong = soLuong1;
            var dongia=0;
            var ten=0;
            var soLuongSanPham = $('#soLuongSanPham').val();
            if(soLuong>0)
            {
                @foreach($sanPham as $item)
                    dongia={{$item->facility_price}};
                ten="{{$item->facility_name}}";
                if ( sanPham == {{$item->facility_id }})
                {
                    $soLuongThem =parseInt($('#soLuongBanSach{{$item->facility_id}}').val())- parseInt(soLuong);
                    if($soLuongThem>0)
                    {
                        $('#soLuongBanSach{{$item->facility_id}}').val($soLuongThem);
                        $('#thanhTienBanSach{{$item->facility_id}}').text(format_curency($soLuongThem*dongia)+" đ");
                        $('#tongTienSP').val(parseInt($('#tongTienSP').val())+ parseInt(soLuong) * parseInt(dongia));
                    }
                }
                @endforeach
                   tinhTong();
            }
        }
        function changeBanSach(id) {
            @foreach($sanPham as $item)
                if(id=={{$item->facility_id}})
                {
                    $soLuong =$('#soLuongBanSach{{$item->facility_id}}').val();
                    if ( parseInt($soLuong) <= parseInt($('#tonKho{{$item->facility_id}}').val()))
                    {
                        $dongia ={{$item->facility_price}};
                        $('#thanhTienBanSach{{$item->facility_id}}').text(format_curency($soLuong * $dongia) + " đ");
                    }
                    else
                    {

                        KiemTra("Sản phẩm","Số lượng không đủ");
                        $soLuong=$('#tonKho{{$item->facility_id}}').val();
                        $('#soLuongBanSach{{$item->facility_id}}').val($soLuong);
                        $dongia ={{$item->facility_price}};
                        $('#thanhTienBanSach{{$item->facility_id}}').text(format_curency($soLuong * $dongia) + " đ");
                    }
                }
                @endforeach
            tinhTong();
        }

        
      
</script>

<!-- <script>

    function btnThemBanSach()
    {
        $id= $('#sanPhamBanSach').val();
        $soLuong = $('#soLuongBanSach').val();
        themSanPhamBanSach($id,$soLuong);
    }
     function XoaTRBanSach(id) 
     {
            var row = document.getElementById("rowBanSach"+id);
            row.parentNode.removeChild(row);
            tinhTong();
    }
    function changeBanSach(id) {
            @foreach($sanPham as $item)
                if(id=={{$item->facility_id}})
                {
                    $soLuong =$('#soLuong{{$item->facility_id}}').val();
                    if ( parseInt($soLuong) <= parseInt($('#tonKho{{$item->facility_id}}').val()))
                    {
                        $dongia ={{$item->facility_price}};
                        $('#thanhTien{{$item->facility_id}}').text(format_curency($soLuong * $dongia) + " đ");
                    }
                    else
                    {

                        alert("Hàng Tồn Không Đủ");
                        $soLuong=$('#tonKho{{$item->facility_id}}').val();
                        $('#soLuong{{$item->facility_id}}').val($soLuong);
                        $dongia ={{$item->facility_price}};
                        $('#thanhTien{{$item->facility_id}}').text(format_curency($soLuong * $dongia) + " đ");
                    }
                }
                @endforeach
            tinhTong();
        }

        function tinhTong() {
            $tongTien = 0;
            @foreach($sanPham as $item)
            if($('#soLuong{{$item->facility_id}}').length > 0 && $('#soLuong{{$item->facility_id}}').val() != '')
            {

                $tongTien+=$('#soLuong{{$item->facility_id}}').val()*{{$item->facility_price}};
            }
            @endforeach


            $tienGiam =  $tongTien* parseInt($('#giaUuDai').val())/100;
            $thanhToan =$tongTien-  $tongTien* parseInt($('#giaUuDai').val())/100;
            document.getElementById('tongTien').innerHTML="Tổng Tiền: "+ format_curency($tongTien) +" đ";
            document.getElementById('thanhToan').innerHTML="Thanh Toán: "+ format_curency($thanhToan)+" đ";
            document.getElementById('giamGia').innerHTML="Giảm Giá: "+format_curency($tienGiam) +" đ";
        }


        function themSanPhamBanSach(id,soLuong1) {
            var sanPham = id;
            var soLuong = soLuong1;
            var dongia=0;
            var ten=0;
            var soLuongSanPham = $('#soLuongSanPham').val();
            if(soLuong>0)
                {
                    @foreach($sanPham as $item)
                        dongia={{$item->facility_price}};
                          ten="{{$item->facility_name}}";
                        if ($('#soLuong{{$item->facility_id}}').val()>=0 && sanPham == {{$item->facility_id }})
                        {
                            $soLuongThem =parseInt($('#soLuong{{$item->facility_id}}').val())+ parseInt(soLuong);
                           if ($soLuongThem <= $('#tonKho{{$item->facility_id}}').val())
                           {
                               $('#soLuong{{$item->facility_id}}').val($soLuongThem);
                               $('#thanhTien{{$item->facility_id}}').text( format_curency($soLuongThem*dongia)+" đ");
                               $tongTienThem = parseInt($('#tongTienSP').val())+ parseInt(soLuong) * parseInt(dongia);

                               $('#tongTienSP').val($tongTienThem);
                           }
                           else
                               alert("Hàng Tồn Không Đủ");
                            }
        
                        else
                        {
                            if (sanPham == {{$item->facility_id}}) {
                                if (soLuong <= $('#tonKho{{$item->facility_id}}').val()) {
                                    var table = document.getElementById("danhSachSanPham");
                                    var row = table.insertRow();
                                    row.id = "rowBanSach{{$item->facility_id}}";
                                    var cell1 = row.insertCell();
                                    var cell2 = row.insertCell();
                                    var cell3 = row.insertCell();
                                    var cell4 = row.insertCell();
                                    var cell5 = row.insertCell();
                                    cell1.innerHTML = ten;
                                    cell2.innerHTML = format_curency(dongia)+" đ";
                                    cell3.innerHTML = "<input  onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='change({{$item->facility_id}});' style='width: 50%; text-align: right; '  id='soLuong" + sanPham + "' value='" + soLuong + "'>" +
                                        "<button onclick='themSanPhamBanSach({{$item->facility_id}},1);' style='margin: 10px'><i class='fa fa-plus'></i></button>" +
                                        "<button onclick='truSanPhamBanSach({{$item->facility_id}},1);'><i class='fa fa-minus'></i></button>";
                                    cell4.innerHTML = format_curency(soLuong*dongia)+" đ";
                                    cell5.innerHTML = "<a href='#' onclick='XoaTRBanSach({{$item->facility_id}});'><i class='fa fa-trash'></i></a>";
                                    cell1.id = "sanPhamBanSach" + sanPham;
                                    cell2.id = "donGiaBanSach" + sanPham;
                                    cell3.id = "soLuong1BanSach" + sanPham;
                                    cell4.id = "thanhTienBanSach" + sanPham;
                                    cell5.id = "xoaBanSach" + sanPham;
                                    $('#tongTienSP').val(parseInt($('#tongTienSP').val()) + parseInt(soLuong) * parseInt(dongia));

                                } else
                                    alert("Hàng Tồn Không Đủ");
                            }

                        }
                        @endforeach
                        tinhTong();
               }
        }
        function truSanPhamBanSach(id,soLuong1) {
            var sanPham = id;
            var soLuong = soLuong1;
            var dongia=0;
            var ten=0;
            var soLuongSanPham = $('#soLuongSanPham').val();
            if(soLuong>0)
            {
                @foreach($sanPham as $item)
                    dongia={{$item->facility_price}};
                ten="{{$item->facility_name}}";
                if ( sanPham == {{$item->facility_id }})
                {
                    $soLuongThem =parseInt($('#soLuong{{$item->facility_id}}').val())- parseInt(soLuong);
                    if($soLuongThem>=0)
                    {
                        $('#soLuong{{$item->facility_id}}').val($soLuongThem);
                        $('#thanhTien{{$item->facility_id}}').text(format_curency($soLuongThem*dongia)+" đ");
                        $('#tongTienSP').val(parseInt($('#tongTienSP').val())+ parseInt(soLuong) * parseInt(dongia));
                    }
                }
                @endforeach
                   tinhTong();
            }
        }
</script> -->
@endsection