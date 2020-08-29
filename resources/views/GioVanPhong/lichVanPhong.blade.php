@extends('master.masterAdmin')
@section('title')
Khung giờ
@endsection
@section('contain')
<div class="content-body">
  

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                       
                        <br>
                        <div style="text-align: center">
                            <h4 class="card-title">WEEKLY TIMESHEET {{ count($arrLop) }}</h4>
                            <h5>{{ date('d/m/Y',strtotime($ngayBatDauChinh)) }} - {{ date('d/m/Y',strtotime($ngayKetThucChinh)) }}</h5>
                            <h5>STAFF NAME: {{$nhanVien->employee_name}}</h5>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-2 col-sm-6">
                                <br>
                                <br>
                                <div>
                            
                                    <a href="{{route('getXemLichVanPhong')}}?id={{$nhanVien->employee_id}}&week={{$tuan-1}}"> 
                                        <button type="button" class="btn mb-1 btn-outline-secondary"><i class="fa fa-chevron-left"></i></button></a>
                                     <a href="{{route('getXemLichVanPhong')}}?id={{$nhanVien->employee_id}}&week={{$tuan+1}}">
                                        <button type="button" class="btn mb-1 btn-outline-secondary"><i class="fa fa-chevron-right"></i></button></a>
                                 </div>
                            </div>
                        </div>
                        <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <input hidden id="id" name="id" value="{{ $nhanVien->employee_id }}">
                            <input hidden id="tuan" name="tuan" value="{{ $tuan }}">
                        <table class="table  table-bordered ">
                            <thead>
                                <th>Class code</th>
                                <th>Start Date</th>
                                <th>Location</th>
                                <th>Mon<br>({{ date('M.d',strtotime($ngayBatDauChinh)) }})</th>
                                <th>TUE	<br>({{ date('M.d',strtotime($ngayThu3)) }})</th>
                                <th>WED<br>({{ date('M.d',strtotime($ngayThu4)) }})</th>
                                <th>THU<br>({{ date('M.d',strtotime($ngayThu5)) }})</th>
                                <th>FRI<br>({{ date('M.d',strtotime($ngayThu6)) }})</th>
                                <th>SAT <br>({{ date('M.d',strtotime($ngayThu7)) }})</th>
                                <th>SUN<br>({{ date('M.d',strtotime($ngayKetThucChinh)) }})</th>
                            </thead>

                            <tbody>
                                @php $i=0; @endphp
                                @foreach($arrLop as $item)
                                <tr>
                                    <td>{{ $item['tenLop'] }}</td>
                                    <td>{{ $item['ngayBatDau'] }}</td>
                                    <td>{{ $item['phong'] }}</td>
                                    <td>{{ $arrLich[$i]['soGio2'] }}<br>{{ $arrLich[$i]['khoangThoiGian2'] }}</td>
                                    <td>{{ $arrLich[$i]['soGio3'] }}<br>{{ $arrLich[$i]['khoangThoiGian3'] }}</td>
                                    <td>{{ $arrLich[$i]['soGio4'] }}<br>{{ $arrLich[$i]['khoangThoiGian4'] }}</td>
                                    <td>{{ $arrLich[$i]['soGio5'] }}<br>{{ $arrLich[$i]['khoangThoiGian5'] }}</td>
                                    <td>{{ $arrLich[$i]['soGio6'] }}<br>{{ $arrLich[$i]['khoangThoiGian6'] }}</td>
                                    <td>{{ $arrLich[$i]['soGio7'] }}<br>{{ $arrLich[$i]['khoangThoiGian7'] }}</td>
                                    <td>{{ $arrLich[$i]['soGio8'] }}<br>{{ $arrLich[$i]['khoangThoiGian8'] }}</td>    
                                </tr>
                                
                                @php $i++; @endphp
                                @endforeach
                                <tr>
                                    <td colspan="3">Total Teaching Hours</td>
                                    <td>{{ $tongGioDay2 }}</td>
                                    <td>{{ $tongGioDay3 }}</td>
                                    <td>{{ $tongGioDay4 }}</td>
                                    <td>{{ $tongGioDay5 }}</td>
                                    <td>{{ $tongGioDay6 }}</td>
                                    <td>{{ $tongGioDay7 }}</td>
                                    <td>{{ $tongGioDay8 }}</td>
                                </tr>
                                <tr>
                                    <td>OFFICE</td>
                                    <td></td>
                                    <td>{{ $duLieuOFF2[0]['chiNhanh'] }}</td>
                                    <td>{{  $duLieuOFF2[0]['soGio']  }}<br>{{  $duLieuOFF2[0]['khoangThoiGian']  }}</td>
                                    <td>{{  $duLieuOFF3[0]['soGio']  }}<br>{{  $duLieuOFF3[0]['khoangThoiGian']  }}</td>
                                    <td>{{  $duLieuOFF4[0]['soGio']  }}<br>{{  $duLieuOFF4[0]['khoangThoiGian']  }}</td>
                                    <td>{{  $duLieuOFF5[0]['soGio']  }}<br>{{  $duLieuOFF5[0]['khoangThoiGian']  }}</td>
                                    <td>{{  $duLieuOFF6[0]['soGio']  }}<br>{{  $duLieuOFF6[0]['khoangThoiGian']  }}</td>
                                    <td>{{  $duLieuOFF7[0]['soGio']  }}<br>{{  $duLieuOFF7[0]['khoangThoiGian']  }}</td>
                                    <td>{{  $duLieuOFF8[0]['soGio']  }}<br>{{  $duLieuOFF8[0]['khoangThoiGian']  }}</td>
                                </tr>
                                <td colspan="3">Total Working Hours</td>
                                    <td>{{ $tongGioDay2+$duLieuOFF2[0]['soGio'] }}</td>
                                    <td>{{ $tongGioDay3+$duLieuOFF3[0]['soGio']  }}</td>
                                    <td>{{ $tongGioDay4+$duLieuOFF4[0]['soGio']  }}</td>
                                    <td>{{ $tongGioDay5+$duLieuOFF5[0]['soGio']  }}</td>
                                    <td>{{ $tongGioDay6+$duLieuOFF6[0]['soGio']  }}</td>
                                    <td>{{ $tongGioDay7+$duLieuOFF7[0]['soGio']  }}</td>
                                    <td>{{ $tongGioDay8+$duLieuOFF8[0]['soGio']  }}</td>
                            </tbody>
                        </table>

                       
                        <br>
                        <br>
                        
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>
      $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{ route("postXepLichVanPhong")}}',
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

                 
            }
        });
        return false;
    });
</script>
@endsection