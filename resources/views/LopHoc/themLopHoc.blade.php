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
                        <h4 class="card-title">Thêm lớp học</h4>
                        <br>
                        <form id="myform1" autocomplete="off" action=""  enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                    <label>Tên lớp học  <span style="color: red">*</span></label>
                                    <input required maxlength="100" class="form-control" name="ten" id="ten">
                                </div>
                               
                                
                                
                                <div class="col-lg-3 col-sm-6">
                                    <label>Chương trình học <span style="color: red">*</span></label>
                                   <select class="form-control" required id="chuongTrinh" name="chuongTrinh" onchange="changeCTH();">
                                       @foreach($chuongTrinhHoc as $item)
                                       <option value="{{$item->studyProgram_id}}">{{$item->studyProgram_name}}</option>
                                       @endforeach
                                   </select>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Khóa học <span style="color: red">*</span></label><div id="duLieuKhoaHoc">
                                    <select required class="form-control" id="khoaHoc" name="khoaHoc" onchange="changeKH();">
                                        
                                            @foreach($khoaHoc as $item)
                                            <option value="{{$item->course_id}}">{{$item->course_name}}</option>
                                            @endforeach
                                       
                                       
                                    </select>
                                </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Trạng thái</label>
                                    <select class="form-control" id="trangThai" name="trangThai">
                                        <option value="1">Waiting</option>
                                        <option value="0">Cancelled</option>
                                    </select>

                                </div>
                              
                                <div class="col-lg-3 col-sm-6">
                                    <label>Ngày bắt đầu <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <input type="text" required class="form-control" id="datepicker-autoclose" 
                                        name="ngayBatDau" placeholder="mm/dd/yyyy" onchange="kiemTraGioHoc();"> 
                                        <span class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="mdi mdi-calendar-check">
                                                    </i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Ngày kết thúc</label>
                                   <input class="form-control" readonly id="ngayKetThuc" name="ngayKetThuc">
                                </div>
                                
                                <div class="col-lg-3 col-sm-6">
                                    <label>Số giờ <span style="color: red">*</span></label>
                                   <input class="form-control" type="number" required id="soGio" name="soGio" value="{{$soGio}}" onkeyup="kiemTraGioHoc();">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Học phí <span style="color: red">*</span></label>
                                    <input required class="form-control" type="number" id="hocPhi" name="hocPhi" value="{{$hocPhi}}">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Số buổi học</label>
                                   <input class="form-control" readonly id="soBuoiHoc" name="soBuoiHoc" value="0"
                                   >
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                   
                                    <label>Giờ buổi học</label>
                                    <div class="input-group clockpicker">
                                        <input required type="text" class="form-control" value="{{ $gioBuoiHoc }}" onchange ="kiemTraGioHoc();"  name="gioBuoiHoc" id="gioBuoiHoc" > 
                                        <span class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-clock-o"></i></span></span>
                                    </div>
                                </div>

                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-2">
                                    Monday <br>
                                   &nbsp;<input   type="checkbox" name="thu2" id="thu2"> 
                                </div>
                              
                                <div class="col-lg-2 col-sm-6">
                                    <label>Start time</label>
                                    <div class="input-group clockpicker">
                                        <input required type="text" class="form-control" value="09:00" onchange ="kiemTraGioHoc();"  name="gioBatDau2" id="gioBatDau2" > 
                                        <span class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-clock-o"></i></span></span>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label>End time</label>
                                   
                                        <input required type="text" class="form-control" value="{{ $arrGioKetThuc[0]['gio'] }}"  readonly name="gioKetThuc2" id="gioKetThuc2" > 
                                       
                                    
                                </div>
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-12" style="padding: 5px"></div>
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-2">
                                   
                                    Tuesday <br>
                                   &nbsp;<input   type="checkbox" name="thu3" id="thu3"> 
                                </div>
                             
                                 <div class="col-lg-2 col-sm-6">
                                    <label>Start time</label>
                                    <div class="input-group clockpicker">
                                        <input required type="text" class="form-control" value="09:00" onchange ="kiemTraGioHoc();"  name="gioBatDau3" id="gioBatDau3" > 
                                        <span class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-clock-o"></i></span></span>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label>End time</label>
                                    
                                        <input required type="text" class="form-control" value="{{ $arrGioKetThuc[1]['gio'] }}"  readonly name="gioKetThuc3" id="gioKetThuc3" > 
                                       
                                </div>
                                 
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-12" style="padding: 5px"></div>
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-2">
                                    Wednesday <br>
                                   &nbsp;<input   type="checkbox" name="thu4" id="thu4"> 
                                </div>
                                
                                 <div class="col-lg-2 col-sm-6">
                                    <label>Start time</label>
                                    <div class="input-group clockpicker">
                                        <input required type="text" class="form-control" value="09:00" onchange ="kiemTraGioHoc();"  name="gioBatDau4" id="gioBatDau4" > 
                                        <span class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-clock-o"></i></span></span>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label>End time</label>
                                  
                                        <input required type="text" class="form-control" value="{{ $arrGioKetThuc[2]['gio'] }}"  readonly name="gioKetThuc4" id="gioKetThuc4" > 
                                        
                                </div>
                                 
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-12" style="padding: 5px"></div>
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-2">
                                    Thursday <br>
                                    &nbsp;<input   type="checkbox" name="thu5" id="thu5">  
                                </div>
                              
                                 <div class="col-lg-2 col-sm-6">
                                    <label>Start time</label>
                                    <div class="input-group clockpicker">
                                        <input required type="text" class="form-control" value="09:00" onchange ="kiemTraGioHoc();"  name="gioBatDau5" id="gioBatDau5" > 
                                        <span class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-clock-o"></i></span></span>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label>End time</label>
                                    
                                        <input required type="text" class="form-control" value="{{ $arrGioKetThuc[3]['gio'] }}"  readonly name="gioKetThuc5" id="gioKetThuc5" > 
                                       
                                </div>
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-12" style="padding: 5px"></div>
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-2">
                                  
                                    Friday<br>
                                   &nbsp;<input   type="checkbox" name="thu6" id="thu6"> 
                                </div>
                                
                                 <div class="col-lg-2 col-sm-6">
                                    <label>Start time</label>
                                    <div class="input-group clockpicker">
                                        <input required type="text" class="form-control" value="09:00" onchange ="kiemTraGioHoc();"  name="gioBatDau6" id="gioBatDau6" > 
                                        <span class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-clock-o"></i></span></span>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label>End time</label>
                            
                                    <input required type="text" class="form-control" value="{{ $arrGioKetThuc[4]['gio'] }}"  readonly name="gioKetThuc6" id="gioKetThuc6" > 
                                      
                                </div>
                                 
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-12" style="padding: 5px"></div>
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-2">
                                    Saturday <br>
                                   &nbsp;<input   type="checkbox" name="thu7" id="thu7"> 
                                </div>
                               
                                 <div class="col-lg-2 col-sm-6">
                                    <label>Start time</label>
                                    <div class="input-group clockpicker">
                                        <input required type="text" class="form-control" value="09:00" onchange ="kiemTraGioHoc();"  name="gioBatDau7" id="gioBatDau7" > 
                                        <span class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-clock-o"></i></span></span>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label>End time</label>  
                                        <input required type="text" class="form-control" value="{{ $arrGioKetThuc[5]['gio'] }}"  readonly name="gioKetThuc7" id="gioKetThuc7" > 
                                       
                                </div>
                                 
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-12" style="padding: 5px"></div>
                                <div class="col-lg-3">
                                    
                                </div>
                                <div class="col-lg-2">
                                    Sunday <br>
                                    &nbsp;<input   type="checkbox" name="thu8" id="thu8"> 
                                </div>
                              
                                 <div class="col-lg-2 col-sm-6">
                                    <label>Start time</label>
                                    <div class="input-group clockpicker">
                                        <input required type="text" class="form-control" value="09:00" onchange ="kiemTraGioHoc();"  name="gioBatDau8" id="gioBatDau8" > 
                                        <span class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-clock-o"></i></span></span>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label>End time</label>
                                  
                                        <input required type="text" class="form-control" value="{{ $arrGioKetThuc[6]['gio'] }}"  readonly name="gioKetThuc8" id="gioKetThuc8" > 
                                       
                                </div>
                                 
                                 
                        </div>
                            <br>
                                <div  style="text-align: center">
                                    <button type="submit" class="btn mb-1 btn-outline-success">Thêm mới</button>

                                </div>
                                <input hidden id="soLuongThemGiaoVien" name="soLuongThemGiaoVien" value="1">
                                <input hidden id="soLuongThemTroGiang" name="soLuongThemTroGiang" value="1">
                                <input hidden id="soLuongThemNhanVien" name="soLuongThemNhanVien" value="1">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
    
<script>

document.getElementById('thu2').onclick = function(e){
            kiemTraGioHoc();
        };
        document.getElementById('thu3').onclick = function(e){
            kiemTraGioHoc();
        };
        document.getElementById('thu4').onclick = function(e){
            kiemTraGioHoc();
        };
        document.getElementById('thu5').onclick = function(e){
            kiemTraGioHoc();
        };
        document.getElementById('thu6').onclick = function(e){
            kiemTraGioHoc();
        };
        document.getElementById('thu7').onclick = function(e){
            kiemTraGioHoc();
        };
        document.getElementById('thu8').onclick = function(e){
            kiemTraGioHoc();
        };

      
        $('#myform1').submit(function() {
       
     
           $soGio = parseInt($('#soGio').val());
           $ngayBatDau= $('#datepicker-autoclose').val();
           $ngayKetThuc= $('#ngayKetThuc').val();


       
         
       
          
        
       
           $gioBatDau = [];
           $gioketThuc =[];
           $id =  $('#id').val();
               $arrThu=[];
               $thoiGian=0;
               for ($i=2;$i<=8;$i++)
               {
                   $gioBatDauKiemTra = $('#gioBatDau'+$i).val();
                   $gioketThucKiemTra = $('#gioKetThuc'+$i).val();
                   var ischeck = $('#thu'+$i).is(":checked");
                   if(ischeck==true)
                   {
                     
                   
                        if($gioBatDauKiemTra>= $gioketThucKiemTra)
                        {
                            KiemTra("Warring","Start time must be less than end time!!!");
                            return;
                        }
                 
                       $arrThu.push(1);
                       $thoiGian=1;
                     
                       
                      // $arrNhanVien.push($nhanVien);
                   }
                   else
                   {
                     
                       $arrThu.push(0);
                    
                   }
                   $gioBatDau.push($gioBatDauKiemTra);

                   $gioketThuc.push($gioketThucKiemTra);
                   
               }

               if ($thoiGian==1 &&  $soGio>0 )
               {
                   

                       

                       $.ajax({
                       type: 'get',
                       url: '{{ route('kiemTraLopHoc')}}',
                       data: {
                               'soGio': $soGio,
                               'ngayBatDau':$ngayBatDau,
                               'thu':$arrThu,
                               'batDau':$gioBatDau,
                               'ketThuc':$gioketThuc,
                           },
                       success: function (data) {
                           if (data[0]['id']==1)
                           {
                               KiemTra("Warning",data[0]['text']);
                               
                           }
                           else
                           {

                               $khoaHoc = $('#khoaHoc').val();
                               $trangThai = $('#trangThai').val();
                               $ten = $('#ten').val();
                               $giaoTrinh = $('#giaoTrinh').val();
                               $hocPhi= $('#hocPhi').val();
                               
                               $.ajax({
                               type: 'get',
                               url: '{{route("postThemLopHoc")}}',
                               data:{
                                   'soGio': $soGio,
                                   'ngayBatDau':$ngayBatDau,
                                   'ngayKetThuc':$ngayKetThuc,
                                 
                                   'thu':$arrThu,
                                  
                                   'batDau':$gioBatDau,
                                   'ketThuc':$gioketThuc,
                                   'khoaHoc':$khoaHoc,
                                   'trangThai':$trangThai,
                                   'ten':$ten,
                                   'giaoTrinh':$giaoTrinh,
                                   'hocPhi':$hocPhi,
                                       },
                                   success: function(data) {
                                   if (data == 1) {
                                       ThemThanhCong("Success", "Thêm Lớp Thành công!!!");
                                       setTimeout(function() {
                                           window.location = "{{route('getLopHoc')}}";
                                       }, 2000);

                                   } else if (data == 2) {
                                       KiemTra("Warning", "Bạn chưa được cấp quyền!!!");
                                   }

                                   else {
                                       PhatHienLoi('Error', "Lỗi kết nối. vui lòng kiểm tra lại!!!");
                                   }

                                //   alert(data);
                               }
                           });
                           }
                       
                       //  alert(data);
                       }
                   });
                  
             
           }
           else
           {
               KiemTra("Warning","Vui lòng chọn thứ và số giờ lơn hơn không!!!");
           }
      

          
      
 

  
   return false;
});
    
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

    function changGio()
    {
        $gioBuoiHoc =  $('#gioBuoiHoc').val();
        for($i=2;$i<=8;$i++)
        {
           $gioBatDau = $('#gioBatDau'+$i).val();
          
           $gioketThuc = congGio($gioBatDau,$gioBuoiHoc);
           $('#gioKetThuc'+$i).val($gioketThuc);
        }

      
    }


    function changeCTH()
    {
        $chuongTrinh = $('#chuongTrinh').val();
        $.ajax({
            type: 'get',
            url: '{{route("changeCTHThemLop")}}',
            data: {
                'chuongTrinh': $chuongTrinh
            },
            success: function(data) {
                document.getElementById('duLieuKhoaHoc').innerHTML = data[0]['khoaHoc'];
                $('#soGio').val(data[0]['soGio']);
                $('#hocPhi').val(data[0]['hocPhi']);
               
              
                kiemTraGioHoc();
               

            }
        });
       
    }
    function changeKH()
    {
        $khoaHoc = $('#khoaHoc').val();
        $.ajax({
            type: 'get',
            url: '{{route("changeKHThemLop")}}',
            data: {
                'khoaHoc': $khoaHoc
            },
            success: function(data) {
                
                $('#soGio').val(data[0]['soGio']);
                $('#hocPhi').val(data[0]['hocPhi']);
                
                kiemTraGioHoc();
                
            }
        });
      
    }
    function kiemTraGioHoc()
        {
          
            changGio();

            $soGio = parseInt($('#soGio').val());
            $ngayBatDau= $('#datepicker-autoclose').val();
        if($ngayBatDau!="")
        {
            $gioBatDau=[];
            $gioketThuc=[];
            $id =  $('#id').val();
                $arrThu=[];
                $thoiGian=0;
                for ($i=2;$i<=8;$i++)
                {
                    var ischeck = $('#thu'+$i).is(":checked");
                    if(ischeck==true)
                    {
                      
                        $gioBatDauKiemTra = $('#gioBatDau'+$i).val();
                        $gioketThucKiemTra = $('#gioKetThuc'+$i).val();
                        $arrThu.push(1);
                        $thoiGian=1;
                        $gioBatDau.push($gioBatDauKiemTra);

                        $gioketThuc.push($gioketThucKiemTra);
                    }
                    else
                    {
                        
                        $arrThu.push(0);

                        $gioBatDau.push(0);

                        $gioketThuc.push(0);
                    }
                       
                }
                

                if ($thoiGian==1 &&  $soGio>0)
                {
                   
                        $.ajax({
                            type: 'get',
                            url: '{{ route('kiemTraLopHoc')}}',
                            data: {
                                'soGio': $soGio,
                                'ngayBatDau':$ngayBatDau,
                                
                                'thu':$arrThu,
                               
                                'batDau':$gioBatDau,
                                'ketThuc':$gioketThuc,
                               
                                
                            },
                            success: function (data) {
                                if (data[0]['id']==1)
                                {
                                    KiemTra('warring',data[0]['text']);
                                    $('#ngayKetThuc').val(data[0]['ngay']);
                                    $('#soBuoiHoc').val(data[0]['soBuoi']);
                                }
                                else
                                {
                                    $('#soBuoiHoc').val(data[0]['soBuoi']);
                                    $('#ngayKetThuc').val(data[0]['ngay']);
                                }
                                

                               
                            }
                        });
                   
                }
                else
                {
                    $('#ngayKetThuc').val($ngayBatDau);
                }
          
       
        }
          
           }
</script>


@endsection



