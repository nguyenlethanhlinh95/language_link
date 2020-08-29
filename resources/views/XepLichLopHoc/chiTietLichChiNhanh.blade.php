@extends('master.masterAdmin')
@section('title')
Lớp học
@endsection
@section('contain')
<div class="content-body">
    <div class="modal fade bd-example-modal-lg" id="largeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xếp lịch </h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div >
                    <table class="table table-striped table-bordered ">
                        <thead>
                            <tr >
                                <th style="width: 5px">No</th>
                                <th style="width: 150px">Branch</th>
                                <th style="width: 150px">Class name</th>
                                <th style="width: 5px">Start date</th>
                                <th style="width: 5px">End date</th>
                                <th style="width: 5px">Scheduled</th>
                            </tr>
                        </thead>
                        <tbody id="duLieuMoLop">
                        </tbody>
                    </table>

                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <a href="{{ route('getXepLichLopMoi') }}?branch={{ $idChiNhanh }}">
                        <button type="button" style="color: white" class="btn btn-success">Mở lớp mới</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform2" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Change schedule</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id" value="" name="id" hidden>
                        <input id="khoangThoiGian" value="" name="khoangThoiGian" hidden>
                        <label>Date <span style="color: red">*</span></label>
                      
                            <div class="input-group">
                                <input type="text" required class="form-control" id="datepicker-autoclose"  value=""
                                name="ngayBatDau" placeholder="mm/dd/yyyy" > 
                                <span class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar-check">
                                            </i>
                                    </span>
                                </span>
                            </div>
                        <div class="row">
                            <div class="col-6">
                                <label>Start time <span style="color: red">*</span></label>
                                <div class="input-group clockpicker">
                                    <input required type="text" onchange="changeGio();" class="form-control"    name="gioBatDau" id="gioBatDau" value=""> 
                                    <span class="input-group-append"><span class="input-group-text">
                                        <i class="fa fa-clock-o"></i></span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label>End time <span style="color: red">*</span></label>
                                <div class="input-group clockpicker">
                                    <input required type="text" class="form-control" readonly   name="gioKetThuc" id="gioKetThuc" value=""> 
                                    <span class="input-group-append"><span class="input-group-text">
                                        <i class="fa fa-clock-o"></i></span></span>
                                </div>
                            </div>
                        </div>
                        <label>Room</label>
                        <select required class="js-example-responsive" style="width: 100%" id="phong" name="phong"  >
                            @foreach($phong as $item)
                                <option value="{{$item->room_id}}">{{$item->room_name}}</option>
                            @endforeach
                        </select>
                        <label>Teacher <span style="color: red">*</span></label>
                            <select required class="js-example-responsive" style="width: 100%" id="giaoVien" name="giaoVien"  >
                                @foreach($giaoVienThayDoi as $item)
                                    <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                @endforeach
                            </select>
                            <label>TA <span style="color: red">*</span></label>
                            <select required class="js-example-responsive" style="width: 100%" id="troGiang" name="troGiang"  >
                                <option value="0">None</option>
                                @foreach($troGiangThayDoi as $item)
                                    <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                @endforeach
                            </select>
                                         
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" style="color: white" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
   

    <div class="modal fade" id="basicModal2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Export schedule</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <label>Teacher</label>
                        <select class="js-example-responsive" style="width: 100%" id="giaoVienXuatLich" name="giaoVienXuatLich"  >
                            @foreach($giaoVienTong as $item)
                                <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                            @endforeach
                        </select>           
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" onclick="xuatLich();" style="color: white" class="btn btn-success">Export Branch</button>
                        <button type="button" onclick="xuatLichGiaoVien();" style="color: white" class="btn btn-success">Export Teacher</button>
                    </div>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body" >
                        <div style="text-align: center">
                            <h4 class="card-title">CLASSES SCHEDULE </h4>
                            <h4><b>({{date('M.d',strtotime($ngayBatDauChinh)) }} - {{date('M.d',strtotime($ngayKetThucChinh))}})</b></h4>
                            
                        </div>

                        <br>
                      
                        <div class="row">
                            <div class="col-lg-2 col-sm-6">
                                <br>
                                <br>
                                <div>
                            
                                    <a href="{{route('postLichChiNhanhTuan')}}?id={{$idChiNhanh}}&tuan={{$tuan-1}}&class={{ $idClass }}"> 
                                        <button type="button" class="btn mb-1 btn-outline-secondary"><i class="fa fa-chevron-left"></i></button></a>
                                     <a href="{{route('postLichChiNhanhTuan')}}?id={{$idChiNhanh}}&tuan={{$tuan+1}}&class={{ $idClass }}">
                                        <button type="button" class="btn mb-1 btn-outline-secondary"><i class="fa fa-chevron-right"></i></button></a>
                                 </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <label>Branch</label>
                               <select class="form-control" onchange="changeChiNhanh();" id="chiNhanh" name="chiNhanh"> 
                               
                                @foreach($chiNhanh as $item)
                                @if ( $item->branch_id==$idChiNhanh)
                                <option selected value="{{ $item->branch_id }}">{{ $item->branch_name}}</option>
                                @else 
                                <option value="{{ $item->branch_id }}">{{ $item->branch_name}}</option>
                                @endif
                               
                                @endforeach
                               </select>
                            </div>
                        </div>
                       
                      
                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr >
                                    <th style="width: 5px">No</th>
                                   
                                    <th style="width: 5px">Time</th>
                                    <th style="width: 5px">Class name</th>
                                    <th style="width: 5px">Number of Ss</th>
                                    <th style="width: 5px">Room</th>
                                    <th style="width: 5px">Material</th>
                                    <th style="width: 5px">Start date</th>
                                    <th style="width: 5px">Mid.</th>
                                    <th style="width: 5px">Final</th>
                                    <th style="width: 5px">End date</th>
                                    <th>Mon<br>{{date('M.d',strtotime($ngayBatDauChinh))}}</th>
                                    <th>Tue<br>{{date('M.d',strtotime($ngayThu3))}}</th>
                                    <th>Wed<br>{{date('M.d',strtotime($ngayThu4))}}</th>
                                    <th>Thu<br>{{date('M.d',strtotime($ngayThu5))}}</th>
                                    <th>Fri<br>{{date('M.d',strtotime($ngayThu6))}}</th>
                                    <th>Sat<br>{{date('M.d',strtotime($ngayThu7))}}</th>
                                    <th>Sun<br>{{date('M.d',strtotime($ngayKetThucChinh))}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php $soLanTrung=0; $soLanLapTrung=0;$kiemTraTrung=0; @endphp
                                   
                                @for($i=0;$i<count($lop);$i++)
                                    @if($kiemTraTrung==0)
                                        @for($j = 0; $j<count($arrTrungGio);$j++)
                                            @if($arrTrungGio[$j]['sttTrung']-2==$i)
                                                @php $kiemTraTrung=1; 
                                                $soLanTrung=$arrTrungGio[$j]['soLan']; 
                                              
                                                @endphp
                                            @endif
                                        @endfor
                                    @endif
                                    <tr>
                                        <td>{{$lop[$i]['stt'].$lop[$i]['soKem']}}  </td>
                                        @if($kiemTraTrung==0)
                                        <td>{{$lop[$i]['TimeStart']}} {{$lop[$i]['TimeEnd']}}</td>
                                        @else 
                                            @if($soLanLapTrung==0)
                                            <td rowspan="{{ $soLanTrung+1 }}">{{$lop[$i]['TimeStart']}} {{$lop[$i]['TimeEnd']}}</td>
                                            @endif
                                            
                                            @php $soLanLapTrung++ @endphp
                                            @if($soLanLapTrung>$soLanTrung)
                                            @php $soLanTrung=0; $soLanLapTrung=0;$kiemTraTrung=0; @endphp
                                            @endif
                                        @endif

                                        <td>{{$lop[$i]['tenLop']}}</td>
                                        <td>{{$lop[$i]['siSo']}}</td>
                                        <td>{{$lop[$i]['phong']}}</td>
                                        <td>{{$lop[$i]['Material']}}</td>
                                        <td>{{$lop[$i]['ngayBatDau']}}</td>
                                        <td>{{$lop[$i]['mid']}}</td>
                                        <td>{{$lop[$i]['final']}}</td>
                                        <td>{{$lop[$i]['ngayKetThuc']}}</td>
                                        @if($ngayLe2=="")
                                        <td onclick="changeLich('{{ $lich[$i]['idClassTime2'] }}','{{ date('m/d/Y',strtotime($ngayBatDauChinh)) }}'
                                        ,'{{$lop[$i]['TimeStart']}}','{{$lop[$i]['TimeEnd']}}','{{$lop[$i]['idPhong']}}');">
                                            <b>{{$lich[$i]['giaoVien2']}}</b><br>
                                            <b>{{$lich[$i]['troGiang2']}}</b><br>
                                            @if($lich[$i]['noiDung2']!="")
                                            @php echo $lich[$i]['noiDung2'] ;@endphp
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe2 }}</td>
                                        @endif
                                        @if($ngayLe3=="")
                                        <td  onclick="changeLich('{{ $lich[$i]['idClassTime3'] }}','{{ date('m/d/Y',strtotime($ngayThu3)) }}'
                                        ,'{{$lop[$i]['TimeStart']}}','{{$lop[$i]['TimeEnd']}}','{{$lop[$i]['idPhong']}}');">
                                            <b>{{$lich[$i]['giaoVien3']}}</b><br>
                                            <b>{{$lich[$i]['troGiang3']}}</b><br>
                                            @if($lich[$i]['noiDung3']!="")
                                            @php echo $lich[$i]['noiDung3'] ;@endphp
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe3 }}</td>
                                        @endif
                                        @if($ngayLe4=="")
                                        <td  onclick="changeLich('{{ $lich[$i]['idClassTime4'] }}','{{ date('m/d/Y',strtotime($ngayThu4)) }}'
                                        ,'{{$lop[$i]['TimeStart']}}','{{$lop[$i]['TimeEnd']}}','{{$lop[$i]['idPhong']}}');">
                                            <b>{{$lich[$i]['giaoVien4']}}</b><br>
                                            <b>{{$lich[$i]['troGiang4']}}</b><br>
                                            @if($lich[$i]['noiDung4']!="")
                                            @php echo $lich[$i]['noiDung4'] ;@endphp
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe4 }}</td>
                                        @endif
                                        @if($ngayLe5=="")
                                        <td  onclick="changeLich('{{ $lich[$i]['idClassTime5'] }}','{{ date('m/d/Y',strtotime($ngayThu5)) }}'
                                        ,'{{$lop[$i]['TimeStart']}}','{{$lop[$i]['TimeEnd']}}','{{$lop[$i]['idPhong']}}');">
                                            <b>{{$lich[$i]['giaoVien5']}}</b><br>
                                            <b>{{$lich[$i]['troGiang5']}}</b><br>
                                            @if($lich[$i]['noiDung5']!="")
                                            @php echo $lich[$i]['noiDung5'] ;@endphp
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe5 }}</td>
                                        @endif
                                        @if($ngayLe6=="")
                                        <td  onclick="changeLich('{{ $lich[$i]['idClassTime6'] }}','{{ date('m/d/Y',strtotime($ngayThu6)) }}'
                                        ,'{{$lop[$i]['TimeStart']}}','{{$lop[$i]['TimeEnd']}}','{{$lop[$i]['idPhong']}}');">
                                            <b>{{$lich[$i]['giaoVien6']}}</b><br>
                                            <b>{{$lich[$i]['troGiang6']}}</b><br>
                                            @if($lich[$i]['noiDung6']!="")
                                            @php echo $lich[$i]['noiDung6'] ;@endphp
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe6 }}</td>
                                        @endif
                                        @if($ngayLe7=="")
                                        <td  onclick="changeLich('{{ $lich[$i]['idClassTime7'] }}','{{ date('m/d/Y',strtotime($ngayThu7)) }}'
                                        ,'{{$lop[$i]['TimeStart']}}','{{$lop[$i]['TimeEnd']}}','{{$lop[$i]['idPhong']}}');">
                                            <b>{{$lich[$i]['giaoVien7']}}</b><br>
                                            <b>{{$lich[$i]['troGiang7']}}</b><br>
                                            @if($lich[$i]['noiDung7']!="")
                                            @php echo $lich[$i]['noiDung7'] ;@endphp
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe7 }}</td>
                                        @endif
                                        @if($ngayLe8=="")
                                        <td  onclick="changeLich('{{ $lich[$i]['idClassTime8'] }}','{{ date('m/d/Y',strtotime($ngayKetThucChinh)) }}'
                                        ,'{{$lop[$i]['TimeStart']}}','{{$lop[$i]['TimeEnd']}}','{{$lop[$i]['idPhong']}}');">
                                            <b>{{$lich[$i]['giaoVien8']}}</b><br>
                                            <b>{{$lich[$i]['troGiang8']}}</b><br>
                                          
                                            @php echo $lich[$i]['noiDung8'] ;@endphp
                                            
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe8 }}</td>
                                        @endif
                                      
                                    </tr>
                                @endfor
                                <tr>
                                    <td colspan="17">Total Students: <b>{{$tongHocVien}} student</b></td>
                                   
                                    
                                </tr>
                                </tbody>
                        </table>
                      <div class="row" style="text-align: center">
                        <div class="col-lg-4 col-sm-6">
                            @if(session('quyen4021')==1)
                            <button type="button" class="btn mb-1 btn-outline-success" data-toggle="modal" data-target="#largeModal" onclick="moLopMoi();">MỞ LỚP MỚI</button>
                            @endif
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            @if(session('quyen4021')==1)
                            <button type="button" class="btn mb-1 btn-outline-success" onclick="luuLich();">Lưu lịch</button>
                            @endif
                            
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div style="float: right">
                                @if(session('quyen4031')==1)
                                <button type="button" class="btn mb-1 btn-outline-success" onclick="XuatLichTong();">Xuất lịch</button>
                                @endif
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script src="js/select2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<script>
      $(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
});
    function changeChiNhanh()
    {
        $chiNhanh = $('#chiNhanh').val();
     
        window.location="{{route('postLichChiNhanhTuan')}}?id="+$chiNhanh+"&tuan={{$tuan}}&class={{ $idClass }}";
    }
    function moLopMoi()
    {
        $chiNhanh = $('#chiNhanh').val();
       
                        $.ajax({
                            type: 'get',
                            url: '{{route("getDanhSachLopXepLich")}}',
                            data: {
                                'id': $chiNhanh 
                            },
                            success: function(data) {
                               // alert(data);
                               document.getElementById('duLieuMoLop').innerHTML=data;
                              
                            }
                        });

    }
  
    function XuatLichTong()
    {
        $('#basicModal2').modal('show');
    }
    function xuatLichGiaoVien()
    {
        $tuan = {{ $tuan }};
        $giaoVien= $('#giaoVienXuatLich').val();
        $chiNhanh = $('#chiNhanh').val();
        $.ajax({
                            type: 'get',
                            url: '{{route("getXuatLichGiaoVien")}}',
                            data: {
                                'tuan': $tuan,
                                'giaoVien': $giaoVien,
                                'chiNhanh': $chiNhanh
                            },
                            success: function(data) {
                             xuatLichChiTietGiaoVien(data);
                              
                            }
                        });
    }
    function congGio($gioDau,$gioSau)
    {
        $gio1 = parseInt( $gioDau.substring(0, 2)) ;
        $phut1 =parseInt(  $gioDau.substring(3, 5)) ;

        $gio2 = parseInt( $gioSau.substring(0, 2)) ;
        $phut2 =parseInt(  $gioSau.substring(3, 5)) ;

       

        $phut3 = $phut1+$phut2;
        $gio3 = $gio1+ $gio2;

        if($phut3>=60)
        {
            $phut3= $phut3-60;
            $gio3++;
        }
        if($phut3<10)
        {
            $phut3="0"+$phut3;
        }
        if($gio3<10)
        {
            $gio3="0"+$gio3;
        }
     
        return $gio3+":"+$phut3;

    }

    function truGio($gioDau,$gioSau)
    {
        $gio1 = parseInt( $gioDau.substring(0, 2)) ;
        $phut1 =parseInt(  $gioDau.substring(3, 5)) ;

        $gio2 = parseInt( $gioSau.substring(0, 2)) ;
        $phut2 =parseInt(  $gioSau.substring(3, 5)) ;

       

        $phut3 = $phut2-$phut1;
        $gio3 = $gio2- $gio1;

        if($phut3>=60)
        {
            $phut3= $phut3-60;
            $gio3++;
        }
        if($phut3<10)
        {
            $phut3="0"+$phut3;
        }
        if($gio3<10)
        {
            $gio3="0"+$gio3;
        }
     
        return $gio3+":"+$phut3;

    }

    function xuatLichChiTietGiaoVien(data)
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
                    data
                +'</body>'
                +'</html>');
            printpage.document.close();
            printpage.focus();
    }
    function changeLich(idClassTime,ngay,batDau,ketThuc,phong)
    {
        if(idClassTime!=0)
        {
            $('#id').val(idClassTime);
            $('#datepicker-autoclose').val(ngay);
            $('#gioBatDau').val(batDau);
            $('#gioKetThuc').val(ketThuc);

            $gioGiua = truGio(batDau,ketThuc);
           
            $('#khoangThoiGian').val($gioGiua);
           
           
            $('#basicModal').modal('show');
        }
    }
    function changeGio()
    {
       $batDau =  $('#gioBatDau').val();
        $gioThem=    $('#khoangThoiGian').val();

        $gioKetThuc = congGio($batDau,$gioThem);
        $('#gioKetThuc').val($gioKetThuc);

    }
    
    function luuLich()
    {
        $chiNhanh = $('#chiNhanh').val();
        $tuan = {{ $tuan }};
        $idLop= {{ $idClass }};
        if($idLop==0)
        {
            KiemTra('Warning',"Nothing to save");
        }
        else
        {
            $.ajax({
                            type: 'get',
                            url: '{{route("getLuuLich")}}',
                            data: {
                                'idChiNhanh': $chiNhanh,
                                'tuan': $tuan,
                                'idLop': $idLop 
                            },
                            success: function(data) {
                             if(data==1)
                             {
                                ThemThanhCong("Success", "Save schedule successful!!!");
                                setTimeout(function() {
                                        window.location = "{{route('postLichChiNhanhTuan')}}?id="+$chiNhanh+"&tuan="+$tuan;
                                }, 2000);
                             }
                             else
                             {
                                KiemTra("Warning", "You are not authorized!!!");
                             }
                              
                            }
                        });
        }
    }
    $('#myform2').submit(function() {
     $chiNhanh = $('#chiNhanh').val();
     $tuan = {{ $tuan }};
     $lop = {{ $idClass }};
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatLichDayNganHan")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Update schedule", "Success!!!");
                    setTimeout(function() {
                        window.location = "{{route('postLichChiNhanhTuan')}}?id="+$chiNhanh+"&tuan="+$tuan+"&class="+$lop;
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Update schedule", "You are not authorized!!!");
                } 
                else if (data == 0) {
                    PhatHienLoi('Error!!!', "Connection errors!!!");
                }
                else
                KiemTra("Update schedule", data);

                //   alert(data);
            }
        });
        return false;
    });
    function xuatLichChiNhanh(data)
    {
        
                $chiNhanh = $("#chiNhanh :selected").text();

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
                        '  <div style="text-align: center">'+
                                    '<h4 class="card-title">CLASSES SCHEDULE</h4>'+
                                    '<h4><b>({{date('M.d',strtotime($ngayBatDauChinh)) }} - {{date('M.d',strtotime($ngayKetThucChinh))}})</b></h4>'+
                                    
                                '</div>'+

                                '<br>'+
                                '<div>'+
                                '<p><b>Branch:</b> '+$chiNhanh+'</p>'+
                                '</div>'+
                        '<div style="text-align: center;">' +
                        '<table style="width:100%">'+
                        '   <thead>'+
                                        '<tr >'+
                                            '<th style="width: 5px">No</th>'+
                                        
                                            '<th style="width: 5px">Time</th>'+
                                            '<th style="width: 5px">Class name</th>'+
                                            '<th style="width: 5px">Number of Ss</th>'+
                                            '<th style="width: 5px">Room</th>'+
                                            '<th style="width: 5px">Material</th>'+
                                            '<th style="width: 5px">Start date</th>'+
                                            '<th style="width: 5px">Mid.</th>'+
                                            '<th style="width: 5px">Final</th>'+
                                            '<th style="width: 5px">End date</th>'+
                                            '<th>Mon<br>{{date('M.d',strtotime($ngayBatDauChinh))}}</th>'+
                                            '<th>Tue<br>{{date('M.d',strtotime($ngayThu3))}}</th>'+
                                            '<th>Wed<br>{{date('M.d',strtotime($ngayThu4))}}</th>'+
                                            '<th>Thu<br>{{date('M.d',strtotime($ngayThu5))}}</th>'+
                                            '<th>Fri<br>{{date('M.d',strtotime($ngayThu6))}}</th>'+
                                            '<th>Sat<br>{{date('M.d',strtotime($ngayThu7))}}</th>'+
                                            '<th>Sun<br>{{date('M.d',strtotime($ngayKetThucChinh))}}</th>'+
                                        '</tr>'+
                                        '</thead>'+
                        '  <tbody>'+ data+
                            '  </tbody>'+
                        '</table>'+
                                
                        '</div>'
                        +'</body>'
                        +'</html>');
                    printpage.document.close();
                    printpage.focus();

    }

    function xuatLich()
    {
        
        $tuan = {{ $tuan }};
       
        $chiNhanh = $('#chiNhanh').val();
        $.ajax({
                            type: 'get',
                            url: '{{route("getValueXuatLichChiNhanh")}}',
                            data: {
                                'tuan': $tuan,
                                'chiNhanh': $chiNhanh
                            },
                            success: function(data) {
                                xuatLichChiNhanh(data);
                              
                            }
                        });
    }
  
</script>
@endsection