@extends('master.masterAdmin')
@section('title')
Lớp học
@endsection
@section('contain')
<div class="content-body">
   
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
                            
                                    <a href="{{route('getLichCaNhanTuan')}}?tuan={{$tuan-1}}"> 
                                        <button type="button" class="btn mb-1 btn-outline-secondary"><i class="fa fa-chevron-left"></i></button></a>
                                     <a href="{{route('getLichCaNhanTuan')}}?tuan={{$tuan+1}}">
                                        <button type="button" class="btn mb-1 btn-outline-secondary"><i class="fa fa-chevron-right"></i></button></a>
                                 </div>
                            </div>
                            
                        </div>
                       
                      
                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr >
                                    <th style="width: 5px">No</th>
                                    <th style="width: 5px">Branch</th>
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
                                        <td>{{$lop[$i]['stt']}} </td>
                                        <td>{{$lop[$i]['chiNhanh']}}</td>
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
                                        <td ><b>{{$lich[$i]['giaoVien2']}}</b><br>
                                            <b>{{$lich[$i]['troGiang2']}}</b><br>
                                            @if($lich[$i]['noiDung2']!="")
                                            ({{$lich[$i]['noiDung2']}})
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe2 }}</td>
                                        @endif
                                        @if($ngayLe3=="")
                                        <td ><b>{{$lich[$i]['giaoVien3']}}</b><br>
                                            <b>{{$lich[$i]['troGiang3']}}</b><br>
                                            @if($lich[$i]['noiDung3']!="")
                                                ({{$lich[$i]['noiDung3']}})
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe3 }}</td>
                                        @endif
                                        @if($ngayLe4=="")
                                        <td ><b>{{$lich[$i]['giaoVien4']}}</b><br>
                                            <b>{{$lich[$i]['troGiang4']}}</b><br>
                                            @if($lich[$i]['noiDung4']!="")
                                                ({{$lich[$i]['noiDung4']}})
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe4 }}</td>
                                        @endif
                                        @if($ngayLe5=="")
                                        <td ><b>{{$lich[$i]['giaoVien5']}}</b><br>
                                            <b>{{$lich[$i]['troGiang5']}}</b><br>
                                            @if($lich[$i]['noiDung5']!="")
                                                ({{$lich[$i]['noiDung5']}})
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe5 }}</td>
                                        @endif
                                        @if($ngayLe6=="")
                                        <td ><b>{{$lich[$i]['giaoVien6']}}</b><br>
                                            <b>{{$lich[$i]['troGiang6']}}</b><br>
                                            @if($lich[$i]['noiDung6']!="")
                                                ({{$lich[$i]['noiDung6']}})
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe6 }}</td>
                                        @endif
                                        @if($ngayLe7=="")
                                        <td ><b>{{$lich[$i]['giaoVien7']}}</b><br>
                                            <b>{{$lich[$i]['troGiang7']}}</b><br>
                                            @if($lich[$i]['noiDung7']!="")
                                                ({{$lich[$i]['noiDung7']}})
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe7 }}</td>
                                        @endif
                                        @if($ngayLe8=="")
                                        <td ><b>{{$lich[$i]['giaoVien8']}}</b><br>
                                            <b>{{$lich[$i]['troGiang8']}}</b><br>
                                            @if($lich[$i]['noiDung8']!="")
                                                ({{$lich[$i]['noiDung8']}})
                                            @endif
                                        </td>
                                        @else 
                                        <td style="color: red;text-align:center;
                                        transform: rotate(90deg);">{{ $ngayLe8 }}</td>
                                        @endif
                                      
                                    </tr>
                                @endfor
                               
                                </tbody>
                        </table>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script src="js/select2.js"></script>
<script>
      $(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
});
 
  
   
   
    function xuatLich()
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
                '  <tbody>'+
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
                                    '<tr>'+
                                        '<td>{{$lop[$i]['stt']}}</td>'+
                                     
                                        @if($kiemTraTrung==0)
                                        '<td>{{$lop[$i]['TimeStart']}} {{$lop[$i]['TimeEnd']}}</td>'+
                                        @else 
                                            @if($soLanLapTrung==0)
                                            '<td rowspan="{{ $soLanTrung+1 }}">{{$lop[$i]['TimeStart']}} {{$lop[$i]['TimeEnd']}}</td>'+
                                            @endif
                                            @php $soLanLapTrung++ @endphp
                                            @if($soLanLapTrung>$soLanTrung)
                                            @php $soLanTrung=0; $soLanLapTrung=0;$kiemTraTrung=0; @endphp
                                            @endif
                                        @endif

                                        '<td>{{$lop[$i]['tenLop']}}</td>'+
                                        '<td>{{$lop[$i]['siSo']}}</td>'+
                                        '<td>{{$lop[$i]['phong']}}</td>'+
                                        '<td>{{$lop[$i]['Material']}}</td>'+
                                        '<td>{{$lop[$i]['ngayBatDau']}}</td>'+
                                        '<td>{{$lop[$i]['mid']}}</td>'+
                                        '<td>{{$lop[$i]['final']}}</td>'+
                                        '<td>{{$lop[$i]['ngayKetThuc']}}</td>'+
                                        @if($ngayLe2=="")
                                        '<td><b>{{$lich[$i]['giaoVien2']}}</b><br>'+
                                            '<b>{{$lich[$i]['troGiang2']}}</b><br>'+
                                            @if($lich[$i]['noiDung2']!="")
                                            '({{$lich[$i]['noiDung2']}})'+
                                            @endif
                                        '</td>'+
                                        @else 
                                        '<td style="color: red;text-align:center;'+
                                        'transform: rotate(90deg);">{{ $ngayLe2 }}</td>'+
                                        @endif
                                        @if($ngayLe3=="")
                                        '<td><b>{{$lich[$i]['giaoVien3']}}</b><br>'+
                                            '<b>{{$lich[$i]['troGiang3']}}</b><br>'+
                                            @if($lich[$i]['noiDung3']!="")
                                                '({{$lich[$i]['noiDung3']}})'+
                                            @endif
                                        '</td>'+
                                        @else 
                                        '<td style="color: red;text-align:center;'+
                                        'transform: rotate(90deg);">{{ $ngayLe3 }}</td>'+
                                        @endif
                                        @if($ngayLe4=="")
                                        '<td><b>{{$lich[$i]['giaoVien4']}}</b><br>'+
                                            '<b>{{$lich[$i]['troGiang4']}}</b><br>'+
                                            @if($lich[$i]['noiDung4']!="")
                                                '({{$lich[$i]['noiDung4']}})'+
                                            @endif
                                        '</td>'+
                                        @else 
                                        '<td style="color: red;text-align:center;'+
                                        'transform: rotate(90deg);">{{ $ngayLe4 }}</td>'+
                                        @endif
                                        @if($ngayLe5=="")
                                        '<td><b>{{$lich[$i]['giaoVien5']}}</b><br>'+
                                            '<b>{{$lich[$i]['troGiang5']}}</b><br>'+
                                            @if($lich[$i]['noiDung5']!="")
                                                '({{$lich[$i]['noiDung5']}})'+
                                            @endif
                                        '</td>'+
                                        @else 
                                        '<td style="color: red;text-align:center;'+
                                        'transform: rotate(90deg);">{{ $ngayLe5 }}</td>'+
                                        @endif
                                        @if($ngayLe6=="")
                                        '<td><b>{{$lich[$i]['giaoVien6']}}</b><br>'+
                                            '<b>{{$lich[$i]['troGiang6']}}</b><br>'+
                                            @if($lich[$i]['noiDung6']!="")
                                                '({{$lich[$i]['noiDung6']}})'+
                                            @endif
                                       '</td>'+
                                        @else 
                                        '<td style="color: red;text-align:center;'+
                                        'transform: rotate(90deg);">{{ $ngayLe6 }}</td>'+
                                        @endif
                                        @if($ngayLe7=="")
                                        '<td><b>{{$lich[$i]['giaoVien7']}}</b><br>'+
                                            '<b>{{$lich[$i]['troGiang7']}}</b><br>'+
                                            @if($lich[$i]['noiDung7']!="")
                                                '({{$lich[$i]['noiDung7']}})'+
                                            @endif
                                        '</td>'+
                                        @else 
                                        '<td style="color: red;text-align:center;'+
                                        'transform: rotate(90deg);">{{ $ngayLe7 }}</td>'+
                                        @endif
                                        @if($ngayLe8=="")
                                        '<td><b>{{$lich[$i]['giaoVien8']}}</b><br>'+
                                            '<b>{{$lich[$i]['troGiang8']}}</b><br>'+
                                            @if($lich[$i]['noiDung8']!="")
                                                '({{$lich[$i]['noiDung8']}})'+
                                            @endif
                                        '</td>'+
                                        @else 
                                        '<td style="color: red;text-align:center;'+
                                        'transform: rotate(90deg);">{{ $ngayLe8 }}</td>'+
                                        @endif
                                      
                                    '</tr>'+
                                @endfor
                              
                '  </tbody>'+
                '</table>'+
                         
                '</div>'
                +'</body>'
                +'</html>');
            printpage.document.close();
            printpage.focus();
    }
  
</script>
@endsection