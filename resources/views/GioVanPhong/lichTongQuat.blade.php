@extends('master.masterAdmin')
@section('title')
phòng học
@endsection
@section('contain')
<div class="content-body">
    <style type="text/css">
        #test{
           
            width:100%;
         
            overflow-x:auto;
            overflow-y:auto;
        }
        .accordion123 {
  cursor: pointer;
  transition: 0.4s;
}
.active, .accordion123:hover {
  background-color: #ccc;
}
.panel123 {
  display: block;
  overflow: hidden;
}
    </style>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="alert alert-success"">
                            <a href="#"class="alert-link">{{ $gioTuan }} </a>:hrs/w &nbsp;&nbsp;&nbsp;&nbsp; 
                            <a href="#"class="alert-link">{{ $ngayTuan }} </a>:day
                            &nbsp;&nbsp;&nbsp;&nbsp;
                               <a href="#"class="alert-link"> {{ $soTuan }} </a>:weeks
                                 &nbsp;&nbsp;&nbsp;&nbsp;<a href="#"class="alert-link">{{ $tongGioTuan }} </a>a>:hrs/m
                                 &nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="#"class="alert-link"> {{ date('d/m/Y',strtotime( $ngayBatDauChinh)) }} -  {{ date('d/m/Y',strtotime($ngayKetThucChinh))  }}
                                </a>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <a href="{{route('getLichTongQuat')}}?month={{$thang-1}}&year={{ $nam }}"> 
                                    <button type="button" class="btn mb-1 btn-outline-secondary"><i class="fa fa-chevron-left"></i></button></a>
                                 <a href="{{route('getLichTongQuat')}}?month={{$thang+1}}&year={{ $nam }}">
                                    <button type="button" class="btn mb-1 btn-outline-secondary"><i class="fa fa-chevron-right"></i></button></a>
                            
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                           
                            </div>
                        </div>

                        <br>
                        <br>
                        <div id="test" >
                            <table class="table  table-bordered ">
                                <thead>
                                  
                                   
                                </thead>
    
    
                           <tbody >
                            <tr>
                                <td rowspan="2" ></td>
                                @php $thoiGian1 = $thoiGian @endphp
                                @for($i=0;$i<$ngayTuan;$i++)
                                    <td colspan="3">{{ $thoiGian1->getTranslatedDayName('dddd/ddd') }} <br><br>
                                        <span style="text-decoration: underline;"> {{ date('d',strtotime($thoiGian)) }}</span>
                                    </td>
                                    @php  $thoiGian1->addDay(1); @endphp
                                @endfor
                                <td rowspan="2" colspan="6"></td>
                                
                            </tr>
                            <tr>
                               
                              
                                @for($i=0;$i<$ngayTuan;$i++)
                                    <td>1</td>
                                    <td>2</td>
                                    <td >3</td>
                                @endfor
                            </tr >
                            
                                @foreach($phongBan as $item)
                                <tr >
                                    <td style="background: #d6e8d6" >{{ $item->department_name }}</td>
                                    <td style="background: #d6e8d6" colspan="{{ $ngayTuan*3+6 }}"></td>
                                 </tr>
                                 @foreach($giaoVien as $item1)
                               
                                    @if($item->department_id==$item1->department_id)
                                        <tr   >
                                            @php $tongGioDay=0;$tongGioVanPhong=0; $tongGio=0; $tongGioLam =0; $tongGioNo =0;$tongGioNghi =0;$phanTram = 0; @endphp
                                            @foreach($arrNhanVien as $item2)
                                            @if($item2['idGiaoVien']==$item1->employee_id)
                                            @php 
                                            $tongGioVanPhong=$item2['soGioVanPhong']; 
                                            $tongGioDay=$item2['soGioDay'];
                                            $tongGio = $item2['soGioDay'] + $item2['tongGioVanPhong'] ; 
                                            $tongGioLam = $item2['thoiGianLam'];
                                            $tongGioNo = $item2['gioNo'];
                                            $tongGioNghi = $item2['tongGioNghi'];
                                            $phanTram = $item2['phanTram'];
                                            
                                             @endphp
                                            @endif
                                            @endforeach 
                                            <td rowspan="2" style="width:116px !important; " ><div style="width:116px !important;height:81px;position:absolute ;background:#eaeaea;color:#000000; text-align: center;vertical-align: middle; margin-top:-40px;margin-left:-12px;padding-top:20px;padding-left:2px;padding-right:2px;"> <b>{{ $item1->employee_name }}</b></div></td>
                                            @php $thoiGian1 = new Carbon\Carbon($nam."-".($thang-1)."-26"); @endphp
                                                @for($i=0;$i<$ngayTuan;$i++)
                                                    @php $gioCa1 ="";$gioCa2="";$gioCa3=""; @endphp
                                                    @foreach($arrGioGiaoVien as $item2)
                                                        @if($item2['idGiaoVien']==$item1->employee_id &&
                                                      $item2['thoiGian']==date('d/m/Y',strtotime($thoiGian1)) &&
                                                       $item2['ca']==1 )
                                                            @php $gioCa1= $item2['soGio'] @endphp
                                                        @endif
                                                        @if($item2['idGiaoVien']==$item1->employee_id &&
                                                        $item2['thoiGian']==date('d/m/Y',strtotime($thoiGian1)) &&
                                                        $item2['ca']==2 )
                                                                @php $gioCa2= $item2['soGio'] @endphp
                                                        @endif
                                                        @if($item2['idGiaoVien']==$item1->employee_id &&
                                                        $item2['thoiGian']==date('d/m/Y',strtotime($thoiGian1)) &&
                                                        $item2['ca']==3 )
                                                                 @php $gioCa3= $item2['soGio'] @endphp
                                                        @endif
                                                    @endforeach
                                                    <td>{{ $gioCa1 }}</td>
                                                    <td>{{ $gioCa2 }}</td>
                                                    <td>{{ $gioCa3 }}</td>
                                                @php  $thoiGian1->addDay(1); @endphp
                                                @endfor
                                                <td>{{ $tongGioDay }}</td>
                                                <td rowspan="2" >{{ $tongGio }}</td>
                                            <!--    <td rowspan="2" >{{ $tongGioLam }}</td>
                                                <td rowspan="2" >{{ $tongGioNo }}</td>
                                                <td rowspan="2" >{{ $tongGioNghi }}</td>
                                                <td rowspan="2" >{{ $phanTram }}</td>
                                            -->
                                        </tr>
                                        <tr >
                                            @php $thoiGian1 = new Carbon\Carbon($nam."-".($thang-1)."-26"); @endphp
                                            @for($i=0;$i<$ngayTuan;$i++)
                                                @php $gioCa1 ="";$gioCa2="";$gioCa3=""; @endphp
                                                @foreach($arrGioVanPhong as $item2)
                                                    @if($item2['idGiaoVien']==$item1->employee_id &&
                                                  $item2['thoiGian']==date('d/m/Y',strtotime($thoiGian1)) &&
                                                   $item2['ca']==1 )
                                                        @php $gioCa1= $item2['soGio'] @endphp
                                                    @endif
                                                    @if($item2['idGiaoVien']==$item1->employee_id &&
                                                    $item2['thoiGian']==date('d/m/Y',strtotime($thoiGian1)) &&
                                                    $item2['ca']==2 )
                                                            @php $gioCa2= $item2['soGio'] @endphp
                                                    @endif
                                                    @if($item2['idGiaoVien']==$item1->employee_id &&
                                                    $item2['thoiGian']==date('d/m/Y',strtotime($thoiGian1)) &&
                                                    $item2['ca']==3 )
                                                             @php $gioCa3= $item2['soGio'] @endphp
                                                    @endif
                                                @endforeach
                                                <td>{{ $gioCa1 }}</td>
                                                <td>{{ $gioCa2 }}</td>
                                                <td >{{ $gioCa3 }}</td>
                                            @php  $thoiGian1->addDay(1); @endphp
                                            @endfor
                                          
                                                <td >{{ $tongGioVanPhong }}</td>
                                        </tr>
                                    @endif
                                 @endforeach

                                @endforeach
                            
                           </tbody>
                            </table>
                        </div>
                        
                  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>

</script>
@endsection