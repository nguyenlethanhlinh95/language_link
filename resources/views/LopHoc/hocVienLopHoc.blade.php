@extends('master.masterAdmin')
@section('title')
Lớp học
@endsection
@section('contain')
<div class="content-body">
    <style>
      
        .myCheckBox:after{
            border: 1px solid black !important;
        }
        .select2-container {

    height: 45px;
}
        </style>
    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm học viên</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Học viên</label>
                        <input hidden id="id" name="id" value="{{$lopHoc->class_id}}">
                        <input hidden id="idKhoaHoc" name="idKhoaHoc" value="{{$lopHoc->course_id}}">
                        <select class="js-example-responsive" style="width: 100%" id="hocVien" name="hocVien" onchange="KiemTraHocVien();">
                            @foreach($danhSachHocVien as $item)
                            <option value="{{$item->student_id}}">{{$item->student_firstName}} {{$item->student_lastName}} - {{date('d/m/Y',strtotime( $item->student_birthDay))}}</option>
                            @endforeach
                        </select>
                        <label>Trạng thái</label>
                        <div id="duLieuTrangThai">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-success">Thêm mới</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="modal fade" id="basicModal2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform2" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Điểm danh học viên</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input hidden type="text" name="idHocVien" id="idHocVien">
                        <input hidden type="text" name="idClassTime" id="idClassTime">
                        <label id="tenHocVien">Học viên</label><br>
                        <label>Điểm danh</label>
                        <div class="basic-form">
                           
                                <div class="form-group">
                                    <label class="radio-inline mr-3">
                                        <input type="radio" checked name="trangThai" value="1" onclick="trangThaiDiemDanh(1);"> Attendance(/)</label>
                                    <label class="radio-inline mr-3">
                                        <input type="radio" name="trangThai" value="2" onclick="trangThaiDiemDanh(2);"> Absent(A)</label>
                                    <label class="radio-inline">
                                        <input  type="radio" name="trangThai" value="3" onclick="trangThaiDiemDanh(3);"> Late(L)</label>
                                </div>
                        </div>
                        <div id="duLieuLate">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-success">Điểm danh</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div class="modal fade" id="basicModal3" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
               
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm học viên</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Học viên</label>
                        <input hidden id="id" name="id" value="{{$lopHoc->class_id}}">
                        <input hidden id="idKhoaHoc" name="idKhoaHoc" value="{{$lopHoc->course_id}}">
                        <select class="js-example-responsive1" style="width: 100%" id="idClassStudent" name="idClassStudent" onchange="KiemTraHocVien();">
                            @foreach($arrHocVien as $item)
                            <option value="{{$item['idClassStudent']}}">{{$item['tenHocVien']}} - {{$item['ngaySinh']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="button" style="color: white" class="btn btn-success" onclick="exportKetQua();">Export</button>
                        <button type="button" style="color: white" class="btn btn-success" onclick="capNhatKetQuaHocTap();">Cập nhật</button>
                    </div>
                
            </div>

        </div>
    </div>

    <div class="modal fade" id="basicModal4" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform4" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="tenHocVien">HỌC VIÊN: </h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input hidden id="idLopHoc" name="idLopHoc" value="{{ $lopHoc->class_id }}">
                        <input hidden id="idHocVienChiTiet" name="idHocVienChiTiet" value="">
                        <div class="row">
                            <div class="col-6">
                                
                                <label>Lớp hiện tại</label>
                               <input class="form-control" value="{{ $lopHoc->class_name }}" readonly>
                               
                               <label>Học phí</label>
                               <input class="form-control" readonly value="{{number_format($lopHoc->class_price,0,"",".")  }}đ">
                               <label>Thời gian</label>
                               <input class="form-control" readonly value="{{date('d/m/Y',strtotime($lopHoc->class_startDay))  }} - {{date('d/m/Y',strtotime($lopHoc->class_endDay))  }}">
                            </div>
                            <div class="col-6">
                                <label>Lớp chuyển</label>
                                <select class="js-example-responsive" style="width:100%;height: 45px !important;" onchange="changeLopChuyen();" name="lopChuyen" id="lopChuyen">
                                    @foreach($lopHocDoi as $item)
                                    <option value="{{ $item->class_id }}">{{ $item->class_name }}</option>
                                    @endforeach
                                </select>
                                    <label>Học phí</label>
                                    <input class="form-control" readonly id="hocPhiChuyen" >
                                    <label>Thời gian</label>
                                    <input class="form-control" readonly id="thoiGianChuyen">
                            </div>
                        </div>
                        <div style="text-align: center">
                            <br>
                            <button type="button" onclick="chuyenLop();" style="color: white" class="btn btn-primary">Chuyển</button>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="button" onclick="xemChiTiet();" style="color: white" class="btn btn-success">Xem Chi tiết</button>
                        <button type="button" onclick="xoaHocVien();" style="color: white" class="btn btn-danger">Xóa</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
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
                        <h4 class="card-title">DANH SÁCH HỌC VIÊN LỚP: {{$lopHoc->class_name}}</h4>
                        <h4 class="card-title">Giáo viên: {{$tenGiaoVien}}</h4>
                        <div class="row">
                            <div class="col-lg-4 col-sm-6">
                                <h4 class="card-title">Ngày bắt đầu: {{date('d/m/Y',strtotime($lopHoc->class_startDay)) }}</h4>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <h4 class="card-title">Ngày kết khóa: {{date('d/m/Y',strtotime($lopHoc->class_endDay)) }}</h4>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                @if($tinhTrang==0)
                                <h4 class="card-title">Tình trạng: Cancelled</h4>
                                @elseif($tinhTrang==1)
                                <h4 class="card-title">Tình trạng: Waitting</h4>
                                @elseif($tinhTrang==2)
                                <h4 class="card-title">Tình trạng: Opening</h4>
                                @else
                                <h4 class="card-title">Tình trạng: Finished</h4>
                                @endif
                           
                            </div>
                            <br>
                            <br>

                            <div class="col-lg-4 col-sm-6">
                                <h4 class="card-title">Attendance (<span style="color: red"> / </span>)</h4>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <h4 class="card-title">Absent (<span style="color: red"> A </span>)</h4>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <h4 class="card-title">Late (<span style="color: red"> L </span>)</h4>
                            </div>
                        </div>

                       
                        <br>
                        <div class="row" style="text-align: center">
                            <div class="col-lg-4 col-sm-6">
                                @if(session('quyen3011')==1)
                                <button type="button" class="btn mb-1 btn-outline-success" onclick="xuatDanhSachHocVien();"
                                >XUẤT DANH SÁCH HV</button>
                                @endif
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                @if(session('quyen72')==1)
                                <button type="button" onclick="KiemTraHocVien();" data-toggle="modal" data-target="#basicModal" class="btn mb-1 btn-outline-success"
                                >THÊM HV</button>
                                @endif
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                @if(session('quyen3041')==1)
                                <a href="{{ route('getDanhSachHocVienKetQuaHocTap') }}?id={{$lopHoc->class_id }}"><button type="button" class="btn mb-1 btn-outline-success"  
                                >KẾT QUẢ HỌC TẬP</button></a>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search Dashboard" aria-label="Tìm học viên">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen62')==1)
                            <a href="{{route('getThemLopHoc')}}">
                                <button type="button" class="btn mb-1 btn-outline-success"
                                 style="float: right">Thêm mới</button>
                            </a>
                            @endif
                            </div> --}}
                        </div>

                        <br>
                        <br>
                        @for($j=1;$j<=$soBuoiHoc;$j++)
                        @php $soTT = 1;$ngayBatDau="";$ngayKetThuc=""; @endphp
                        @foreach($arrBuoiHoc as $item)
                            @if ($item['soBuoi']==$j)
                                @if($soTT==1)
                                @php $soTT=0; $ngayBatDau = $item['ngay']; @endphp
                                @endif
                                @php $ngayKetThuc = $item['ngay']; @endphp
                            @endif
                        @endforeach
                        @if($j==1)
                        <button onclick="HienThiDanhSach({{ $j }})" class="btn  btn-outline-primary " ><i id="icon{{ $j }}" class="fa  fa-chevron-down"></i> 
                         {{ $ngayBatDau }} - {{ $ngayKetThuc }}
                        </button>
                        <input hidden id="trangThai{{ $j }}" value="1">
                        <br>
                        <br>
                        <div id="the{{ $j }}" style="display: block">
                        @else 
                        <button onclick="HienThiDanhSach({{ $j }})" class="btn  btn-outline-primary"><i id="icon{{ $j }}" class="fa  fa-chevron-right"></i>
                            {{ $ngayBatDau }} - {{ $ngayKetThuc }}</button>
                            <input hidden id="trangThai{{ $j }}" value="0">
                        <br>
                        <br>
                        <div id="the{{ $j }}" style="display: none">
                        @endif
                        
                            @if(session('quyen3021')==1)
                            <button type="button" class="btn mb-1 btn-outline-success" style="float: right" onclick="xuatDiemDanh({{$j}});"
                            >XUẤT ĐIỂM DANH</button>
                            @endif
                            <table class="table table-striped table-bordered " >
                                <thead>
                                    <tr>
                                        <td rowspan="2" style="width: 5px;">STT</th>
                                        <td rowspan="2" style="width: 70px;">Số biên lai HP</th>
                                        <td rowspan="2" style="width: 150px;">Tên học viên</th>
                                        <td rowspan="2" style="width: 100px;">Nickname</th>
                                        <td colspan="10" style="text-align: center">ĐIỂM DANH</th>
                                    </tr>
                                    <tr>
                                        
                                        @foreach($arrBuoiHoc as $item)
                                        @if ($item['soBuoi']==$j)
                                        <td>{{$item['ngay']}}</td>
                                        @endif
                                   
                                        @endforeach
                                    
                                        
                                    </tr>
                                </thead>
                                <tbody id="duLieuSearch">
                                    @php $i=0; @endphp
                                    @foreach($arrHocVien as $item)
                                    <tr>
                                        <td>@php echo $i+1; @endphp</td>
                                        @if($item['idPhieu']!=0)
                                    <td><a href="{{route('getCapNhatPhieuThu')}}?id={{$item['idPhieu']}}">{{$item['trangThai']}}</a></td>
                                        @else 
                                        <td>{{$item['trangThai']}}</td>
                                        @endif
                                  
                                    <td><a style="cursor: pointer" onclick="setValueHocVien('{{$item['idHocVien']}}');" 
                                        data-toggle="modal" data-target="#basicModal4">{{$item['tenHocVien']}}</a></td>
                                    <td>{{$item['nickName']}}</td>
                                        @foreach($arrDiemDanh as $item2)
                                            @if($item['idHocVien']==$item2['idHocVien'] && $item2['soBuoi']==$j)
                                                
                                            <td style="text-align: center;font-size: 20px" onclick="diemDanh('{{$item['idHocVien']}}',
                                            '{{$item2['classTime_id']}}',
                                            '{{$item['tenHocVien']}}',
                                            '{{$item2['ngay']}}')" data-toggle="modal" data-target="#basicModal2">
                                               {{$item2['trangThai']}}
                                            </td>
                                              
                                                
                                            @endif
                                        
                                        @endforeach
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>
                           
                        @endfor
                        <br>
                      
                       
                        {{-- <div class="bootstrap-pagination">
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
                        <input hidden id="pageSelect" value="1"> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script src="js/select2.js"></script>
<script>
 function  chuyenLop()
 {
    $id =  $('#idHocVienChiTiet').val();
    $idLop = '{{ $lopHoc->class_id }}';
    $lopChuyen = $('#lopChuyen').val();

    $.ajax({
                type: 'get',
                url: '{{route("getChuyenLopHoc")}}',
                data: {
                    'idLopHoc':$idLop,
                    'idHocVien':$id,
                    'lopChuyen':$lopChuyen
                },
                success: function(data) {
                    if(data==1)
                    {
                        ThemThanhCong('Chuyển lớp','Chuyển lớp thành công!!!');
                        setTimeout(function() {
                            window.location = "{{route('getHocVienLopHoc')}}?id={{$lopHoc->class_id}}";
                        }, 500);
                    }
                    else if(data==2)
                    {
                        KiemTra("Học viên đã có trong lớp cần chuyển");
                    }
                    else
                    {
                        PhatHienLoi("ERROR","Lỗi kết nối!!!");
                    }
                
                    // alert(data);
                }
            });
 } 
 
 function xemChiTiet()
 {
    $id =  $('#idHocVienChiTiet').val();
    window.location="{{ route('getChiTietHocVien') }}?id="+$id;
 } 
 function xoaHocVien()
 {
    $id =  $('#idHocVienChiTiet').val();
    $idLop = '{{ $lopHoc->class_id }}';

    $.ajax({
                type: 'get',
                url: '{{route("getXoaHocVienKhoiLopHoc")}}',
                data: {
                    'idLopHoc':$idLop,
                    'idHocVien':$id
                },
                success: function(data) {
                    if(data==1)
                    {
                        ThemThanhCong('Xóa học viên','Xóa thành công!!!');
                        setTimeout(function() {
                            window.location = "{{route('getHocVienLopHoc')}}?id={{$lopHoc->class_id}}";
                        }, 500);
                    }
                    else
                    {
                        PhatHienLoi("ERROR","Lỗi kết nối!!!");
                    }
                
                    // alert(data);
                }
            });
 
 }

function changeLopChuyen()
{
    $lopHoc = $('#lopChuyen').val();
    $.ajax({
            type: 'get',
            url: '{{route("getThongTinLopChuyen")}}',
            data: {
                'idLopHoc':$lopHoc
            },
            success: function(data) {
                $('#hocPhiChuyen').val(data[0]['hocPhi']);
                $('#thoiGianChuyen').val(data[0]['thoiGian']);
               
                //   alert(data);
            }
        });

}
function setValueHocVien( id)
{
    $('#idHocVienChiTiet').val(id);
    
   
    changeLopChuyen();
}
function HienThiDanhSach(stt)
{
    $trangThai = $('#trangThai'+stt).val();
    if($trangThai==1)
    {
        $('#trangThai'+stt).val(0);
        document.getElementById('the'+stt).style="display: none";
        document.getElementById('icon'+stt).className="fa fa-chevron-right";
    }
    else
    {
        $('#trangThai'+stt).val(1);
        document.getElementById('the'+stt).style="display: block";
        document.getElementById('icon'+stt).className="fa fa-chevron-down";
    }
}

    $(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
});
$(".js-example-responsive1").select2({
    width: 'resolve' // need to override the changed default
});
function exportKetQua()
{
    $id = {{ $lopHoc->class_id }};
    window.location="{{route("exportKetQuaHocTap")}}?id="+$id;
   
   
}
function capNhatKetQuaHocTap()
{
    $idClassStudent = $('#idClassStudent').val();

    window.location='{{ route('getLoaiKetQuaHocTapHocVien') }}?id='+$idClassStudent;

}
    function trangThaiDiemDanh(trangThai)
    {
        if(trangThai==3)
            document.getElementById('duLieuLate').innerHTML="<input class='form-control' name='late' type='number' required>";
        else
        document.getElementById('duLieuLate').innerHTML="";
    }
    function xuatDanhSachHocVien()
    {
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
            printpage.document.write('<!DOCTYPE html><html><head><title></title></head>');
            printpage.document.write('<body onLoad="self.print()">'+
                '<style>\n' +
                '  table, th, td {\n' +
                '    border: 1px solid black;\n' +
                '    border-collapse: collapse;\n' +
                '  }\n' +
                '</style>'+
                '  <h4 class="card-title">DANH SÁCH HỌC VIÊN LỚP: {{$lopHoc->class_name}}</h4>'+
                '<h4 class="card-title">Giáo viên: {{$tenGiaoVien}}</h4>'+
               
                '<h4 class="card-title">Ngày bắt đầu: {{date('d/m/Y',strtotime($lopHoc->class_startDay)) }}</h4>'+
                          
                '<h4 class="card-title">Ngày kết khóa: {{date('d/m/Y',strtotime($lopHoc->class_endDay)) }}</h4>'+
                          
                '<div style="text-align: center;">' +
                '<table style="width:100%">'+
                '  <thead>' +
                ' <th style="width:10px">STT</th>' +
                ' <th style="width:200px">Tên học viên</th>' +
                ' <th style="width:100px">Nickname</th>' +
                ' <th style="width:100px">Số ĐT HV</th>' +
                ' <th style="width:200px">Tên PH</th>' +
                ' <th style="width:100px">Số ĐT PH</th>' +
                ' <th style="width:250px">Ghi chú</th>' +
                '  </thead>' +
                '  <tbody>'+
                @php $i=0; @endphp
                    @foreach($arrHocVien as $item)
                    '<tr>'+
                    '<td>@php echo $i+1; @endphp</td>'+
                    '<td>{{$item['tenHocVien']}}</td>'+
                    '<td>{{$item['nickName']}}</td>'+
                    '<td>{{$item['sdtHV']}}</td>'+
                    '<td>{{$item['phuHuynh']}}</td>'+
                    '<td>{{$item['sdtPH']}}</td>'+
                    '<td></td>'+
                    '</tr>'+
                    @php $i++; @endphp
                    @endforeach

                '  </tbody>'+
                '</table>'+
                         
                '</div>'
                +'</body>'
                +'</html>');
            printpage.document.close();
            printpage.focus();
        
    }

    

    function xuatDiemDanh(id)
    {
        var code = $("#code1").val();
            var ngayLay=$("#ngayLay").val();
            let current_datetime = new Date(ngayLay);
            let formatted_date = current_datetime.getDate() + "/"
                + (current_datetime.getMonth() + 1) + "/"
                + current_datetime.getFullYear();
            var display_setting="toolbar=yes,menubar=yes,";
            display_setting+="scrollbars=yes,width=1000, height=1000, left=100, top=0";
            var printpage=window.open("","",display_setting);
            $duLieu ="";
                    @php $i=0; @endphp
                    @foreach($arrHocVien as $item)
                    $duLieu +=   '<tr>'+
                    '<td>@php echo $i+1; @endphp</td>'+
                    '<td>{{$item['trangThai']}}</td>'+
                    '<td>{{$item['tenHocVien']}}</td>'+
                    '<td>{{$item['nickName']}}</td>';

                        @foreach($arrDiemDanh as $item2)
                            if({{$item['idHocVien']}}=={{$item2['idHocVien']}} && {{$item2['soBuoi']}}==id)
                            {
                                $duLieu += ' <td style="text-align: center;font-size: 20px">'+
                                               '{{$item2['trangThai']}}'+
                                            '</td>';
                            }           
                        @endforeach
                        @php $i++; @endphp
                  @endforeach

             $ngay = "";
             @foreach($arrBuoiHoc as $item)
                    if ({{$item['soBuoi']}}==id)
                    $ngay+='<td>{{$item['ngay']}}</td>';
                                                
            @endforeach               
            printpage.document.open();
            printpage.document.write('<!DOCTYPE html><html><head><title></title></head>');
            printpage.document.write('<body onLoad="self.print()">'+
                '<style>\n' +
                '  table, th, td {\n' +
                '    border: 1px solid black;\n' +
                '    border-collapse: collapse;\n' +
                '  }\n' +
                '</style>'+
                '  <h4 class="card-title">DANH SÁCH HỌC VIÊN LỚP: {{$lopHoc->class_name}}</h4>'+
                '<h4 class="card-title">Giáo viên: {{$tenGiaoVien}}</h4>'+
               
                '<h4 class="card-title">Ngày bắt đầu: {{date('d/m/Y',strtotime($lopHoc->class_startDay)) }}</h4>'+
                          
                '<h4 class="card-title">Ngày kết khóa: {{date('d/m/Y',strtotime($lopHoc->class_endDay)) }}</h4>'+
                          
                '<div style="text-align: center;">' +
                '<table style="width:100%">'+
                '  <thead> '+
                '<tr>' +
                ' <td rowspan="2" style="width: 10px;">STT</th>'+
                '<td rowspan="2" style="width: 70px;">Số biên lai HP</th>'+
                '<td rowspan="2" style="width: 200px;">Tên học viên</th>'+
                '<td rowspan="2" style="width: 100px;">Nickname</th>'+
                '<td colspan="10">ĐIỂM DANH</th>'+
                '</tr>' +
                '<tr>' +
                    $ngay+
                '</tr>' +
                '  </thead>' +
                '  <tbody>'+
                    $duLieu+

                '  </tbody>'+
                '</table>'+
                         
                '</div>'
                +'</body>'
                +'</html>');
            printpage.document.close();
            printpage.focus();
    }
    function diemDanh(idHocVien,classTime_id,ten,ngay)
    {
       
       $('#idHocVien').val(idHocVien);
       $('#idClassTime').val(classTime_id);
       document.getElementById('tenHocVien').innerHTML="Học viên: "+ten+"<br> Ngày: "+ngay;
        // var checkbox = document.getElementById($key);

      


    }
      function KiemTraHocVien()
      {
          $idHocVien = $('#hocVien').val();
          $idKhoaHoc = {{$lopHoc->course_id}};
          $.ajax({
            type: 'get',
            url: '{{route("getKiemTraTrangThaiHocVien")}}',
            data: {
                'idHocVien':$idHocVien,
                'idKhoaHoc':$idKhoaHoc
            },
            success: function(data) {
               
                document.getElementById('duLieuTrangThai').innerHTML=data;
                //   alert(data);
            }
        });

      }
      $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemHocVienVaoLop")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm học viên", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getHocVienLopHoc')}}?id={{$lopHoc->class_id}}";
                    }, 500);

                } else if (data == 2) {
                    KiemTra("Thêm học viên", "Bạn không có quyền thêm!!!");
                }

                else if (data == 3) {
                    KiemTra("Thêm học viên", "Học viên đã nằm trong lớp!!!");
                }                 else {
                    PhatHienLoi('Thêm học viên', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postDiemDanhHocVien")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Điểm danh học viên", "Điểm danh thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getHocVienLopHoc')}}?id={{$lopHoc->class_id}}";
                    }, 500);

                } else if (data == 2) {
                    KiemTra("Điểm danh học viên", "Bạn không có quyền Điểm danh!!!");
                } 
                else if (data == 3) {
                    KiemTra("Điểm danh học viên", "Mã học viên đã tồn tại!!!");
                } 
                else {
                    PhatHienLoi('Thêm học viên', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
   
    
  
</script>
@endsection