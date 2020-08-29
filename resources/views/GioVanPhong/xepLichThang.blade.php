@extends('master.masterAdmin')
@section('title')
Khung giờ
@endsection
@section('contain')
<div class="content-body">
  
    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm giờ</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input hidden id="caChon" name="caChon">
                        <input hidden id="thuChon" name="thuChon">
                        <label>Thời Gian</label>
                        <div class="row">
                            <div class="col-6">
                                <label>Giờ bắt đầu </label>
                                <div class="input-group clockpicker">
                                    <input required type="text" class="form-control" value="09:00"    name="gioBatDau2" id="gioBatDau2" > 
                                    <span class="input-group-append"><span class="input-group-text">
                                        <i class="fa fa-clock-o"></i></span></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label>Giờ kết thúc</label>
                                <div class="input-group clockpicker">
                                    <input required type="text" class="form-control" value="11:00"   name="gioKetThuc2" id="gioKetThuc2" > 
                                    <span class="input-group-append"><span class="input-group-text">
                                        <i class="fa fa-clock-o"></i></span></span>
                                </div>
                            </div>
                        </div>
                        <label>Khung giờ</label>
                        <select class="form-control" name="khungGio" id="khungGio" onchange="changeKhungGio();">

                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button onclick="themGio();" type="submit" style="color: white" class="btn btn-success">Thêm mới</button>
                    </div>
              
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">XẾP LỊCH VĂN PHÒNG NHÂN VIÊN: {{ $nhanVien->employee_name }}</h4>
                        <br>
                        <div style="text-align: center">
                            <h4 class="card-title">THỜI GIAN </h4>
                            <p>({{ $thang }}/{{ $nam }})</p>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 col-sm-6">
                                <br>
                                <br>
                                <div>
                                    
                                    <a href="{{route('getXepLichThang')}}?id={{$nhanVien->employee_id}}&month={{$thang-1}}&year={{ $nam }}"> 
                                        <button type="button" class="btn mb-1 btn-outline-secondary"><i class="fa fa-chevron-left"></i></button></a>
                                     <a href="{{route('getXepLichThang')}}?id={{$nhanVien->employee_id}}&month={{$thang+1}}&year={{ $nam }}">
                                        <button type="button" class="btn mb-1 btn-outline-secondary"><i class="fa fa-chevron-right"></i></button></a>
                                
                             </div>
                            </div>
                        </div>
                        
                        <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <input hidden id="id" name="id" value="{{ $nhanVien->employee_id }}">
                            <input hidden id="thang" name="thang" value="{{ $thang }}">
                            <input hidden id="nam" name="nam" value="{{ $nam }}">
                        <table class="table  table-bordered ">
                            <thead>
                                <th></th>
                                <th>T2</th>
                                <th>T3</th>
                                <th>T4</th>
                                <th>T5</th>
                                <th>T6</th>
                                <th>T7</th>
                                <th>CN</th>
                            </thead>
                       
                            <tbody>
                                <tr>
                                    <td>Ca 1</td>
                                    @for($i=2;$i<=8;$i++)
                                    <td>
                                        @php $gioBatDau =""; $gioKetThuc =""; @endphp
                                       @foreach($khungGioCa as $item)
                                            @if($item->calendarMonth_shift==1 && $item->calendarMonth_dayOfWeek==$i)
                                            @php $gioBatDau =$item->calendarMonth_startTime." - ".$item->calendarMonth_endTime; @endphp
                                            @endif
                                       @endforeach
                                       
                                  <input onclick="layDuLieu('1','{{ $i }}');" type="text" class="form-control" value="{{ $gioBatDau }}" readonly name="gioCa1T{{ $i }}" id="gioCa1T{{ $i }}">   
                                    </td>
                                    @endfor
                                </tr>
                                <tr> 
                                    <td>Ca 2</td>
                                    @for($i=2;$i<=8;$i++)
                                    <td>

                                        @php $gioBatDau =""; $gioKetThuc =""; @endphp
                                        @foreach($khungGioCa as $item)
                                             @if($item->calendarMonth_shift==2 && $item->calendarMonth_dayOfWeek==$i)
                                             @php $gioBatDau =$item->calendarMonth_startTime." - ".$item->calendarMonth_endTime; @endphp
                                             @endif
                                        @endforeach
                                        
                                   <input onclick="layDuLieu('2','{{ $i }}');" type="text" class="form-control" value="{{ $gioBatDau }}" readonly name="gioCa2T{{ $i }}" id="gioCa2T{{ $i }}">   
                                    
                                    </td>
                                    @endfor

                                </tr>
                                <tr>
                                    <td>Ca 3</td>
                                    @for($i=2;$i<=8;$i++)
                                    <td>
                                        @php $gioBatDau =""; $gioKetThuc =""; @endphp
                                       @foreach($khungGioCa as $item)
                                            @if($item->calendarMonth_shift==3 && $item->calendarMonth_dayOfWeek==$i)
                                            @php $gioBatDau =$item->calendarMonth_startTime." - ".$item->calendarMonth_endTime; @endphp
                                            @endif
                                       @endforeach
                                       
                                  <input onclick="layDuLieu('3','{{ $i }}');" type="text" class="form-control" value="{{ $gioBatDau }}" readonly name="gioCa3T{{ $i }}" id="gioCa3T{{ $i }}">   
                                   
                                    </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>

                       
                        <br>
                        <br>
                        <div style="text-align: center">
                            @if(session('quyen4251')==1)
                            <button type="submit" class="btn mb-1 btn-outline-success" >Cập nhật</button>
                            @endif
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>
    function themGio()
    {
      $ca=  $('#caChon').val();
      $thu= $('#thuChon').val();
      $gioBatDau = $('#gioBatDau2').val();
      $gioKetThuc =  $('#gioKetThuc2').val();

     if($gioBatDau=="" || $gioKetThuc=="")   
     $('#gioCa'+$ca+'T'+$thu).val("");
      else  
    $('#gioCa'+$ca+'T'+$thu).val($gioBatDau + " - "+ $gioKetThuc);
    $('#basicModal').modal('hide');
    }

    function changeKhungGio()
    {
        $khungGio = $('#khungGio').val();
        $gioBatDau = $khungGio.substring(0, 5);
        $gioKetThuc = $khungGio.substring(8, 13);
        $('#gioBatDau2').val($gioBatDau);
        $('#gioKetThuc2').val($gioKetThuc);
    }
    function layDuLieu(ca,thu)
    {
        $khungGio =   $('#gioCa'+ca+'T'+thu).val();
        $gioBatDau = $khungGio.substring(0, 5);
        $gioKetThuc = $khungGio.substring(8, 13);
        $('#gioBatDau2').val($gioBatDau);
        $('#gioKetThuc2').val($gioKetThuc);


       $('#caChon').val(ca);
       $('#thuChon').val(thu);
       $('#basicModal').modal('show');
        $out ="<option value='0'>Không</option>";
        
        @foreach( $khungGioCa1 as $item)
        if(thu==2)
        {
            $trangThaiThu = {{ $item->timeSlot_day2 }};
        }
        else if(thu==3)
        {
            $trangThaiThu = {{ $item->timeSlot_day3 }};
        }
        else if(thu==4)
        {
            $trangThaiThu = {{ $item->timeSlot_day4 }};
        }
        else if(thu==5)
        {
            $trangThaiThu = {{ $item->timeSlot_day5 }};
        }
        else if(thu==6)
        {
            $trangThaiThu = {{ $item->timeSlot_day6 }};
        }
        else if(thu==7)
        {
            $trangThaiThu = {{ $item->timeSlot_day7}};
        }
        else
        {
            $trangThaiThu = {{ $item->timeSlot_day8 }};
        }


        if(ca == {{ $item->timeSlot_shift }} && $trangThaiThu==1)
        {
            $out+="<option value='{{ $item->timeSlot_startTime }} - {{ $item->timeSlot_endTime }}'>{{ $item->timeSlot_name }} - ({{ $item->timeSlot_startTime }} - {{ $item->timeSlot_endTime }})</option>";
        }
        @endforeach

        document.getElementById('khungGio').innerHTML=$out;
    }
      $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{ route("postXepLichVanPhongThang")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                 if (data == 1) {
                    ThemThanhCong("Xếp lịch văn phòng", "Cập nhật thành công!!!");
                 }
                else if (data == 0){
                    PhatHienLoi('Xếp lịch văn phòng', "Lỗi Kết Nối!!!");
                }
                else 
                KiemTra('Xếp lịch văn phòng',data);

                //    alert(data);
                 
            }
        });
        return false;
    });
</script>
@endsection