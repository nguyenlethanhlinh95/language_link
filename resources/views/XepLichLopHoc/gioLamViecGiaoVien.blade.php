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

                    <div class="card-body">
                        <div style="text-align: center">
                            <h4 class="card-title">TEACHING HOURS</h4>
                        </div>
                        
                        <br>
                        <form id="myform1" autocomplete="off" action="{{ route('postTimGioGiaoVien') }}"  enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                        <div class="row"><input hidden id="id" name="id" value="{{ $giaoVien->employee_id }}">
                            <div class="col-lg-6 col-sm-6">
                               <p style="font-size: 20px">Teacher name: <b>{{ $giaoVien->employee_name }}</b></p>
                            </div>
                            <div class="col-lg-6 col-sm-6" >
                                <div style="float: right;"> 
                                <p style="font-size: 20px">Date: <b>From</b>: {{date('M.d',strtotime($ngayBatDauChinh )) }} <b>To</b> {{ date('M.d',strtotime($ngayKetThucChinh)) }} </p>
                                </div>
                            </div>
                           
                            <div class="col-lg-4 col-sm-6">
                                <div class="example">
                                    <h5 class="box-title m-t-30">Thời gian</h5>
                                    <input class="form-control input-daterange-datepicker" type="text" name="thoiGian" value="{{date('m/d/Y',strtotime($ngayBatDauChinh )) }} - {{date('m/d/Y',strtotime($ngayKetThucChinh )) }}">
                                </div>
                             </div>
                             <div class="col-lg-2 col-sm-6">
                                 <div style="padding-top: 30px">
                                <button type="submit" class="btn mb-1 btn-outline-success" >
                                    <i class="fa fa-search"></i> Tìm kiếm</button>
                                 </div>
                             </div>
                           
                             <div class="col-lg-6 col-sm-6" >
                                <div style="float: right">
                                    <button type="button" class="btn mb-1 btn-outline-success" onclick="xuatLich();">Xuất lịch</button>
                                 </div>
                             </div>
                           {{-- <a href="{{ route('html_email') }}"><button></button></a> --}}
                        </div>
                    </form>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr >
                                    <th style="width: 10px">STT</th>
                                    <th style="width: 100px">Date</th>
                                    <th style="width: 100px">Class name</th>
                                    <th style="width: 100px">Branch</th>
                                    <th style="width: 150px">Time</th>
                                    <th style="width: 150px">Teaching hour</th>
                                    <th>Notes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=1; @endphp
                             @foreach($arrGioLamViec as $item)
                                    <tr>
                                        <td> @php echo $i; @endphp</td>
                                        <td>{{date('M.d',strtotime($item['dateStart'])) }}</td>
                                        <td>{{$item['tenLop']}}</td>
                                        <td>{{$item['chiNhanh']}}</td>
                                        <td>{{date('H:s',strtotime($item['dateStart'])) }} - {{date('H:s',strtotime($item['dateEnd'])) }}</td>
                                        <td>{{$item['gio']}}</td>
                                        <td></td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                                <tr>
                                    <td colspan="5" ><b style="float: right">Total teaching hours</b></td>
                                    <td>{{$tongGio}}</td>
                                    <td></td>
                                </tr>
                               
                                </tbody>
                        </table>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>
    function xuatLich()
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
                '  <div style="text-align: center">'+
                            '<h4 class="card-title">TEACHING HOUR</h4>'+
                            
                        '</div>'+

                        '<br>'+
                        '<div style="display:inline-block;width:50%">'+
                            '<p style="font-size: 20px"><b>Teacher\'s name:</b> {{$giaoVien->employee_name}} </p>'+
                        '</div>'+
                        '<div style="display:inline-block;width:50%;float: right;">'+
                           
                            '<p style="font-size: 20px">Date: <b>From</b>: {{date('M.d',strtotime($ngayBatDauChinh )) }} <b>To</b> {{ date('M.d',strtotime($ngayKetThucChinh)) }} </p>'+
    
                        '</div>'+
                '<div style="text-align: center;">' +
                '<table style="width:100%">'+
                '   <thead>'+
                                '<tr >'+
                                    '<th style="width: 10px">STT</th>'+
                                    '<th style="width: 100px">Date</th>'+
                                    '<th style="width: 100px">Class name</th>'+
                                    '<th style="width: 100px">Branch</th>'+
                                    '<th style="width: 150px">Time</th>'+
                                    '<th style="width: 150px">Teaching hour</th>'+
                                    '<th>Notes</th>'+
                                '</tr>'+
                                '</thead>'+
                '  <tbody>'+
                    
                    @php $i=1; @endphp
                             @foreach($arrGioLamViec as $item)
                                    '<tr>'+
                                        '<td> @php echo $i; @endphp</td>'+
                                        '<td>{{date('M.d',strtotime($item['dateStart'])) }}</td>'+
                                        '<td>{{$item['tenLop']}}</td>'+
                                        '<td>{{$item['chiNhanh']}}</td>'+
                                        '<td>{{date('H:s',strtotime($item['dateStart'])) }} - {{date('H:s',strtotime($item['dateEnd'])) }}</td>'+
                                        '<td>{{$item['gio']}}</td>'+
                                        '<td></td>'+
                                    '</tr>'+
                                    @php $i++; @endphp
                                @endforeach
                                '<tr>'+
                                    '<td colspan="5" ><b style="float: right">Total teaching hours</b></td>'+
                                    '<td>{{$tongGio}}</td>'+
                                    '<td></td>'+
                                '</tr>'+
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