@extends('master.masterAdmin')
@section('title')
cấp độ
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm cấp độ</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Tên cấp độ <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten" name="ten">
                        <label>Mã cấp độ <span style="color: red">*</span></label>
                        <input maxlength="10" class="form-control" required id="ma" name="ma">
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
                        <h5 class="modal-title">Cập nhật cấp độ</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input id="id" name="id" hidden>
                        <label>Tên cấp độ <span style="color: red">*</span></label>
                        <input maxlength="30" class="form-control" required id="ten2" name="ten2">
                        <label>Mã cấp độ <span style="color: red">*</span></label>
                        <input maxlength="10" class="form-control" required id="ma2" name="ma2">
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div style="text-align: center">
                            <h4 class="card-title">TEACHING HOURS</h4>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                               <label>Branch</label>
                               
                                <select class="js-example-responsive" style="width: 100%" id="chiNhanh" name="chiNhanh" onchange="getLichChiNhanh();">
                                    <option value="0">ALL</option>
                                    @foreach($chiNhanh as $item)
                                    <option value="{{$item->branch_id}}">{{$item->branch_name}}</option>
                                    @endforeach
                               </select>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <label>Teacher</label>
                                <select class="js-example-responsive" style="width: 100%" id="giaoVien" name="giaoVien" onchange="getLichGiaoVien();">
                                    <option value="0">ALL</option>
                                    @foreach($giaoVien as $item)
                                    <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="example">
                                    <h5 class="box-title m-t-30">Time</h5>
                                    <input class="form-control input-daterange-datepicker" type="text" id="thoiGian" onchange="thoiGian();"
                                    name="thoiGian" value="{{date('m/d/Y',strtotime($ngayBatDauChinh )) }} - {{date('m/d/Y',strtotime($ngayKetThucChinh )) }}">
                                </div>
                             </div>
                            
                            
                        </div>
                        <br>
                        <div id="trangChiNhanh">
                            <div class="row">
                                <div class="col-lg-4 col-sm-4">
                                    <p style="font-size: 20px" id="tenChiNhanh"><b>Branch:</b> ALL</p>
                                 </div>
                                 <div class="col-lg-4 col-sm-4" >
                                     <div style="text-align: center;"> 
                                     <p style="font-size: 20px" id="thoiGianChiNhanh">Date: <b>From</b>: {{date('M.d',strtotime($ngayBatDauChinh )) }} <b>To</b> {{ date('M.d',strtotime($ngayKetThucChinh)) }} </p>
                                     </div>
                                 </div>
                                 <div class="col-lg-4 col-sm-4" >
                                    <div style="float: right">
                                        <button type="button" class="btn mb-1 btn-outline-success" onclick="xuatLichChiNhanh();">Export Time</button>
                                     </div>
                                 </div>
                            </div>
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr >
                                        <th style="width: 10px">STT</th>
                                        <th style="width: 100px">Date</th>
                                        <th style="width: 100px">Class name</th>
                                      
                                        <th style="width: 150px">Time</th>
                                        <th style="width: 120px">Teaching hour</th>
                                        <th style="width: 200px">Teacher's name</th>
                                        <th>Notes</th>
                                    </tr>
                                    </thead>
                                    <tbody id="duLieuChiTietChiNhanh">
                                    @php $i=1; @endphp
                                    @foreach($arrGioLamViec as $item)
                                            <tr>
                                                <td> @php echo $i; @endphp</td>
                                                <td>{{date('M.d',strtotime($item['dateStart'])) }}</td>
                                                <td>{{$item['tenLop']}}</td>
                                            
                                                <td>{{date('H:i',strtotime($item['dateStart'])) }} - {{date('H:i',strtotime($item['dateEnd'])) }}</td>
                                                <td>{{$item['gio']}}</td>
                                                <td>{{$item['giaoVien']}}</td>
                                                <td></td>
                                            </tr>
                                            @php $i++; @endphp
                                        @endforeach
                                    <tr>
                                        <td colspan="4" ><b style="float: right">Total teaching hours</b></td>
                                        <td>{{$tongGio}} hours</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                   
                                    </tbody>
                            </table>
                        </div>
                        <div id="trangGiaoVien" style="display: none">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                    <p style="font-size: 20px" id="tenGiaoVien"><b>Teacher name:</b></p>
                                 </div>
                                 <div class="col-lg-4 col-sm-6" >
                                     <div style="text-align: center;"> 
                                     <p style="font-size: 20px" id="thoiGianGiaoVien">Date: <b>From</b>: </p>
                                     </div>
                                 </div>
                                 <div class="col-lg-4 col-sm-4" >
                                    <div style="float: right">
                                        <button type="button" class="btn mb-1 btn-outline-success" onclick="xuatLichGiaoVien();">Export Time</button>
                                     </div>
                                 </div>
                            </div>
                           

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
                                    <tbody id="duLieuGiaoVien">
                                    </tbody>
                             </table>
                        </div>
                        <br>
                        <br>
                       

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input hidden id="loai" name="loai" value="1">
<input hidden id="duLieuLichChiNhanh" name="duLieuLichChiNhanh" value="{{ $out }}">
<input hidden id="thoiGianLich" name="thoiGianLich" value="Date: <b>From</b>: {{date('M.d',strtotime($ngayBatDauChinh )) }} <b>To</b> {{ date('M.d',strtotime($ngayKetThucChinh)) }} ">
<input hidden id="duLieuLichGiaoVien" name="duLieuLichGiaoVien" value="">

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script src="js/select2.js"></script>
<script>
      $(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
    });
    function getLichChiNhanh()
    {
        document.getElementById('trangChiNhanh').style='display:block';
        document.getElementById('trangGiaoVien').style='display:none';
        $('#loai').val(1);
       $tenChiNhanh= $("#chiNhanh :selected").text();
       document.getElementById('tenChiNhanh').innerHTML="<b>Branch:</b> "+$tenChiNhanh;
       getDuLieuChiNhanh(); 
    }
    function getLichGiaoVien()
    {
        document.getElementById('trangChiNhanh').style='display:none';
        document.getElementById('trangGiaoVien').style='display:block';
        $('#loai').val(2);
        $tenGiaoVien= $("#giaoVien :selected").text();
       document.getElementById('tenGiaoVien').innerHTML="<b>Teacher name:</b> "+$tenGiaoVien;
       getDuLieuGiaoVien();
    }
    function thoiGian()
    {
        $loai =   $('#loai').val();
        if($loai==1)
        {
            getDuLieuChiNhanh();
        }
        else
        {
            getDuLieuGiaoVien();
        }
    }
    function getDuLieuChiNhanh()
    {
        $chiNhanh = $('#chiNhanh').val();
        $thoiGian = $('#thoiGian').val();
        $.ajax({
            type: 'get',
            url: '{{route("getDuLieuGioLamViecChiNhanh")}}',
            data: {
                'chiNhanh': $chiNhanh,
                'thoiGian':$thoiGian
            },
            success: function(data) {
                document.getElementById('duLieuChiTietChiNhanh').innerHTML = data[0]['duLieu'];
                document.getElementById('thoiGianChiNhanh').innerHTML='Date: <b>From</b>: '+data[0]['ngayBatDau'] +' <b>To</b> '+data[0]['ngayKetThuc']  ;
                $('#duLieuLichChiNhanh').val( data[0]['duLieu']);
                $('#thoiGianLich').val( 'Date: <b>From</b>: '+data[0]['ngayBatDau'] +' <b>To</b> '+data[0]['ngayKetThuc'] );
            }
        });
    }

    function getDuLieuGiaoVien()
    {
        $giaoVien = $('#giaoVien').val();
        $thoiGian = $('#thoiGian').val();
        $.ajax({
            type: 'get',
            url: '{{route("getDuLieuGioLamGiaoVien")}}',
            data: {
                'giaoVien': $giaoVien,
                'thoiGian':$thoiGian
            },
            success: function(data) {
                document.getElementById('duLieuGiaoVien').innerHTML = data[0]['duLieu'];
                document.getElementById('thoiGianGiaoVien').innerHTML='Date: <b>From</b>: '+data[0]['ngayBatDau'] +' <b>To</b> '+data[0]['ngayKetThuc']  ;
                $('#duLieuLichGiaoVien').val( data[0]['duLieu']);
                $('#thoiGianLich').val( 'Date: <b>From</b>: '+data[0]['ngayBatDau'] +' <b>To</b> '+data[0]['ngayKetThuc'] );
           
            }
        });
    }

    function xuatLichChiNhanh()
    {
        var code = $("#code1").val();
           
        $duLieuChiNhanh = $('#duLieuLichChiNhanh').val();
        $thoiGian = $('#thoiGianLich').val();
        $tenChiNhanh= $("#chiNhanh :selected").text();

            let current_datetime = new Date();
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
                            '<p style="font-size: 20px"><b>Branch:</b>'+$tenChiNhanh+'</p>'+
                        '</div>'+
                        '<div style="display:inline-block;width:50%;float: right;">'+
                           
                            '<p style="font-size: 20px">'+$thoiGian+'</p>'+
    
                        '</div>'+
                '<div style="text-align: center;">' +
                '<table style="width:100%">'+
                '   <thead>'+
                                '<tr >'+
                                    '<th style="width: 10px">STT</th>'+
                                    '<th style="width: 100px">Date</th>'+
                                    '<th style="width: 100px">Class name</th>'+
                                 
                                    '<th style="width: 150px">Time</th>'+
                                    '<th style="width: 120px">Teaching hour</th>'+
                                    '<th style="width: 200px">Teacher\'s name</th>'+
                                    '<th>Notes</th>'+
                                '</tr>'+
                                '</thead>'+
                '  <tbody>'+
                    
                  $duLieuChiNhanh+
                '  </tbody>'+
                '</table>'+
                         
                '</div>'
                +'</body>'
                +'</html>');
            printpage.document.close();
            printpage.focus();
    }

    function xuatLichGiaoVien()
    {
        $duLieuGiaoVien = $('#duLieuLichGiaoVien').val();
        $thoiGian = $('#thoiGianLich').val();
        $tenGiaoVien= $("#giaoVien :selected").text();

        let current_datetime = new Date();
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
                            '<p style="font-size: 20px"><b>Teacher\'s name:</b> '+$tenGiaoVien+' </p>'+
                        '</div>'+
                        '<div style="display:inline-block;width:50%;float: right;">'+
                           
                            '<p style="font-size: 20px">'+$thoiGian+'</p>'+
    
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
                  $duLieuGiaoVien+
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