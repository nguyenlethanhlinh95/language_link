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
                        <form id="myform1" action="{{route('postThemChiNhanh')}}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                    <label>Tên lớp học  <span style="color: red">*</span></label>
                                    <input hidden id="id" name="id" value="{{ $lopHoc->class_id }}">
                                    <input required maxlength="100" class="form-control" name="ten" id="ten" value="{{ $lopHoc->class_name }}">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Giáo viên <span style="color: red">*</span></label>
                                    <div class="input-group mb-3">
                                        <select required class="form-control" name="giaoVien1" id="giaoVien1" onchange="KiemTraGiaoVien(1);">
                                                @foreach($giaoVien as $item)
                                                    @if($giaoVienDau == $item->employee_id)
                                                        <option selected value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                                    @else 
                                                        <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                                    @endif
                                                @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-success" type="button" onclick="themGiaoVien();">
                                                <i class="fa fa-plus">
                                                </i>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="themGiaoVien">
                                        @php $i=1; @endphp
                                        @foreach($giaoVienDungLop as $item1)
                                        @if($i>1)
                                        <div id='TrangGiaoVien{{ $i }}'> 
                                            <div class="input-group mb-3">
                                                <select required class="form-control" name="giaoVien1" id="giaoVien1" onchange="KiemTraGiaoVien({{ $i }});">
                                                        @foreach($giaoVien as $item)
                                                            @if($item1->employee_id == $item->employee_id)
                                                                <option selected  value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                                            @else 
                                                                <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                                            @endif
                                                        @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <button class='btn btn-outline-danger' type='button' onclick='truGiaoVien({{ $i }});'>
                                                        <i class='fa fa-minus'> </i>  </button>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @php $i++; @endphp
                                        @endforeach
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Trợ giảng</label>
                                    <div class="input-group mb-3">
                                        <select required class="form-control" name="troGiang1" id="troGiang1" onchange="KiemTraGiaoVien(1);">
                                            @foreach($troGiang as $item)
                                            @if($TroGiangDau == $item->employee_id)
                                            <option selected value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                            @else
                                            <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                           
                                            @endif
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button   class="btn btn-outline-success" type="button" onclick="themTroGiang();">
                                                <i class="fa fa-plus">
                                                </i>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="themTroGiang">
                                        @php $i=1; @endphp
                                        @foreach($troGiangDungLop as $item1)
                                        @if($i>1)
                                        <div id='TrangTroGiang{{ $i }}'> 
                                        <div class="input-group mb-3">
                                            <select required class="form-control" name="giaoVien1" id="giaoVien1" onchange="KiemTraGiaoVien({{ $i }});">
                                                    @foreach($troGiang as $item)
                                                        @if($item1->employee_id == $item->employee_id)
                                                            <option selected  value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                                        @else 
                                                            <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                                        @endif
                                                    @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button class='btn btn-outline-danger' type='button' onclick='truTroGiang({{ $i }});'>
                                                    <i class='fa fa-minus'> </i>  </button>
                                            </div>
                                        </div>
                                        </div>
                                        @endif
                                        @php $i++; @endphp
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 col-sm-6">
                                    <label>NV đứng lớp</label>
                                  
                                    <div class="input-group mb-3">
                                        <select required class="form-control" id="nhanVien1" name="nhanVien1" onchange="KiemTraGiaoVien(0);">
                                            @foreach($NVDungLop as $item)
                                            @if($nhanVienDau == $item->employee_id)
                                            <option selected value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                            @else 
                                            <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                            
                                            @endif
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button   class="btn btn-outline-success" type="button" onclick="themNhanVien();">
                                                <i class="fa fa-plus">
                                                </i>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="themNhanVien">
                                        @php $i=1; @endphp
                                        @foreach($nhanVienDungLop as $item1)
                                        @if($i>1)
                                        <div id='TrangNhanVien{{ $i }}'> 
                                        <div class="input-group mb-3">
                                            <select required class="form-control" name="giaoVien1" id="giaoVien1" onchange="KiemTraGiaoVien(0);">
                                                    @foreach($NVDungLop as $item)
                                                        @if($item1->employee_id == $item->employee_id)
                                                            <option selected  value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                                        @else 
                                                            <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                                        @endif
                                                    @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button class='btn btn-outline-danger' type='button' onclick='truNhanVien({{ $i }});'>
                                                    <i class='fa fa-minus'> </i>  </button>
                                                </button>
                                            </div>
                                        </div>
                                        </div>
                                        @endif
                                        @php $i++; @endphp
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Chương trình học</label>
                                    <input class="form-control" value="{{ $lopHoc->studyProgram_name }}">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Khóa học</label><div id="duLieuKhoaHoc">
                                        <input class="form-control" value="{{ $lopHoc->course_name }}">
                                </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Phòng học</label>
                                    <div id="duLieuPhongHoc">
                                        <select class="form-control"  required id="phong" name="phong" onchange="kiemTraGioHoc();">
                                            @foreach($phongHoc as $item)
                                           <option value="{{$item['id']}}">{{$item['ten']}}</option>
                                           @endforeach
                                           </select>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Số giờ</label>
                                   <input class="form-control" type="number" required id="soGio" name="soGio" value="{{$soGio}}" onkeyup="kiemTraGioHoc();">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Ngày bắt đầu</label>
                                    <div class="input-group">
                                        <input type="text" required class="form-control" id="datepicker-autoclose"  value="{{ date('m/d/Y',strtotime($lopHoc->class_startDay)) }}"
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
                                   <input class="form-control" readonly id="ngayKetThuc" name="ngayKetThuc" value="{{ date('m/d/Y',strtotime($lopHoc->class_endDay)) }}">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Giờ bắt đầu</label>
                                    <div class="input-group clockpicker">
                                        <input required type="text" class="form-control" value="09:00" onchange ="kiemTraGioHoc();"  name="gioBatDau" id="gioBatDau" value="{{ $lopHoc->class_startHouse }}"> 
                                        <span class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-clock-o"></i></span></span>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Giờ kết thúc</label>
                                    <div class="input-group clockpicker">
                                        <input required type="text" class="form-control" value="11:00"  onchange="kiemTraGioHoc();" name="gioKetThuc" id="gioKetThuc" value="{{ $lopHoc->class_endHouse }}"> 
                                        <span class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-clock-o"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Giáo trình</label>
                                    <input required class=" form-control" required id="giaoTrinh" name="giaoTrinh" value="{{ $lopHoc->class_material }}">
                                </div>
                             

                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-lg-2">
                                </div>
                                
                                    <div class="col-lg-2">
                                        @if($buoiHoc->classDay_day2==1)
                                        <input checked type="checkbox" name="thu2" id="thu2">&nbsp;Thứ 2
                                        @else 
                                        <input   type="checkbox" name="thu2" id="thu2">&nbsp;Thứ 2
                                        @endif
                                    </div>
                                    <div class="col-lg-2">
                                        @if($buoiHoc->classDay_day3==1)
                                        <input checked type="checkbox" name="thu3" id="thu3">&nbsp; Thứ 3
                                        @else 
                                        <input  type="checkbox" name="thu3" id="thu3">&nbsp; Thứ 3
                                        @endif
                                    </div>
                                    <div class="col-lg-2">
                                        @if($buoiHoc->classDay_day4==1)
                                        <input checked type="checkbox" name="thu4" id="thu4">&nbsp; Thứ 4
                                        @else 
                                        <input  type="checkbox" name="thu4" id="thu4">&nbsp; Thứ 4
                                        @endif
                                    </div>
                                    <div class="col-lg-2">
                                        @if($buoiHoc->classDay_day5==1)
                                        <input checked type="checkbox" name="thu5" id="thu5">&nbsp; Thứ 5
                                        @else 
                                        <input  type="checkbox" name="thu5" id="thu5">&nbsp; Thứ 5
                                        @endif
                                    </div>
                                    <div class="col-lg-2">
                                    </div>
                                    <br><br>
                                    <div class="col-lg-2">
                                    </div>
                                    <div class="col-lg-2">
                                        @if($buoiHoc->classDay_day6==1)
                                        <input checked type="checkbox" name="thu6" id="thu6">&nbsp; Thứ 6
                                        @else 
                                        <input type="checkbox" name="thu6" id="thu6">&nbsp; Thứ 6
                                        @endif
                                    </div>
                                    <div class="col-lg-2">
                                        @if($buoiHoc->classDay_day7==1)
                                        <input checked type="checkbox" name="thu7" id="thu7">&nbsp; Thứ 7
                                        @else 
                                        <input  type="checkbox" name="thu7" id="thu7">&nbsp; Thứ 7
                                        @endif
                                    </div>
                                    <div class="col-lg-2">
                                        @if($buoiHoc->classDay_day8==1)
                                        <input checked  type="checkbox" name="thu8" id="thu8">&nbsp; Chủ Nhật
                                        @else 
                                        <input  type="checkbox" name="thu8" id="thu8">&nbsp; Chủ Nhật
                                        @endif
                                    </div>
                            </div>
                            <br>
                                <div  style="text-align: center">
                                    <button type="submit" class="btn mb-1 btn-outline-success">Thêm mới</button>

                                </div>
                                @if(count($giaoVienDungLop) >0)
                                <input hidden id="soLuongThemGiaoVien" name="soLuongThemGiaoVien" value="{{ count($giaoVienDungLop) }}">
                                @else 
                                <input hidden id="soLuongThemGiaoVien" name="soLuongThemGiaoVien" value="1">
                                @endif
                                @if(count($troGiangDungLop) >0)
                                <input hidden id="soLuongThemTroGiang" name="soLuongThemTroGiang" value="{{ count($troGiangDungLop) }}">
                                @else 
                                <input hidden id="soLuongThemTroGiang" name="soLuongThemTroGiang" value="1">
                                
                                @endif
                                @if(count($nhanVienDungLop) >0)
                                <input hidden id="soLuongThemNhanVien" name="soLuongThemNhanVien" value="{{ count($nhanVienDungLop) }}">
                                @else 
                                <input hidden id="soLuongThemNhanVien" name="soLuongThemNhanVien" value="1">
                                
                                @endif
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>

<script>
    function KiemTraGiaoVien(so)
    {
        $soLuongThemGiaoVien= $('#soLuongThemGiaoVien').val();
        $soLuongThemTroGiang= $('#soLuongThemTroGiang').val();
        $soLuongThemNhanVien= $('#soLuongThemNhanVien').val();
        $arrGiaoVien = new Array();
        $arrGiaoVienTen = new Array();
        for($i=1;$i<=$soLuongThemGiaoVien;$i++)
        {
            $arrGiaoVien.push($('#giaoVien'+$i).val());
            $arrGiaoVien.push($('#giaoVien'+$i+' option:selected').html());
        }
        $text="";
        for($i=1;$i<=$soLuongThemTroGiang;$i++)
        {
            $kiemTra=0;
           for ($j = 0; $j < $arrGiaoVien.length; $j++) {
                if($('#troGiang'+$i).val()>0)
               if($arrGiaoVien[$j]==$('#troGiang'+$i).val())
               {
                    $kiemTra=1;
               }

           }
           if($kiemTra==0)
           {
            $arrGiaoVien.push($('#troGiang'+$i).val());
            $arrGiaoVien.push($('#troGiang'+$i+' option:selected').html());
           }
           else
           {
               $text+="Nhân viên  "+ $('#troGiang'+$i+' option:selected').html()+ " tại trợ giảng đã bị trùng, ";
           }
        }
        for($i=1;$i<=$soLuongThemNhanVien;$i++)
        {
            $kiemTra=0;
           for ($j = 0; $j < $arrGiaoVien.length; $j++) {
            if($('#troGiang'+$i).val()>0)
               if($arrGiaoVien[$j]==$('#nhanVien'+$i).val())
               {
                    $kiemTra=1;
               }
           }
           if($kiemTra==0)
           {
            $arrGiaoVien.push($('#nhanVien'+$i).val());
            $arrGiaoVien.push($('#nhanVien'+$i+' option:selected').html());
           }
           else
           {
               $text+="Nhân Viên  "+ $('#nhanVien'+$i+' option:selected').html()+ " tại nhân viên đứng lớp đã bị trùng, ";
           }
        }
        if($text!="")
            KiemTra("Nhân viên",$text);


        $giaoVien = $('#giaoVien'+so).val();
        kiemTraGiaoVienThem( $giaoVien);
    }

    function KiemTraTruocThem()
    {
        $soLuongThemGiaoVien= $('#soLuongThemGiaoVien').val();
        $soLuongThemTroGiang= $('#soLuongThemTroGiang').val();
        $soLuongThemNhanVien= $('#soLuongThemNhanVien').val();
        $arrGiaoVien = new Array();
        $arrGiaoVienTen = new Array();
        for($i=1;$i<=$soLuongThemGiaoVien;$i++)
        {
            $arrGiaoVien.push($('#giaoVien'+$i).val());
            $arrGiaoVien.push($('#giaoVien'+$i+' option:selected').html());
        }
        $text="";
        for($i=1;$i<=$soLuongThemTroGiang;$i++)
        {
            $kiemTra=0;
           for ($j = 0; $j < $arrGiaoVien.length; $j++) {
                if($('#troGiang'+$i).val()>0)
               if($arrGiaoVien[$j]==$('#troGiang'+$i).val())
               {
                    $kiemTra=1;
               }

           }
           if($kiemTra==0)
           {
            $arrGiaoVien.push($('#troGiang'+$i).val());
            $arrGiaoVien.push($('#troGiang'+$i+' option:selected').html());
           }
           else
           {
               $text+="Nhân viên  "+ $('#troGiang'+$i+' option:selected').html()+ " tại trợ giảng đã bị trùng, ";
           }
        }
        for($i=1;$i<=$soLuongThemNhanVien;$i++)
        {
            $kiemTra=0;
           for ($j = 0; $j < $arrGiaoVien.length; $j++) {
            if($('#troGiang'+$i).val()>0)
               if($arrGiaoVien[$j]==$('#nhanVien'+$i).val())
               {
                    $kiemTra=1;
               }
           }
           if($kiemTra==0)
           {
            $arrGiaoVien.push($('#nhanVien'+$i).val());
            $arrGiaoVien.push($('#nhanVien'+$i+' option:selected').html());
           }
           else
           {
               $text+="Nhân Viên  "+ $('#nhanVien'+$i+' option:selected').html()+ " tại nhân viên đứng lớp đã bị trùng, ";
           }
        }
        
        return  $text;
    }

    function themGiaoVien()
    {
        $soLuongThemGiaoVien=parseInt($('#soLuongThemGiaoVien').val()) ;

        $arr = new Array();

        for($i=1;$i<=$soLuongThemGiaoVien;$i++)
        {
            $arr.push($('#giaoVien'+$i).val());
        }
        $duLieu="";
        @foreach($giaoVien as $item)
            $kiemTra=0;
          
            for( $i=0;$i<$arr.length;$i++ )
            {
                if($arr[$i]=={{$item->employee_id}})
                $kiemTra=1;
              
            }
            if($kiemTra ==0)
            $duLieu+='<option value="{{$item->employee_id}}">{{$item->employee_name}}</option>';
        @endforeach
        
        

        $duLieuTong = "<div id='TrangGiaoVien"+($soLuongThemGiaoVien+1)+"'> <div class='input-group mb-3'>"+
        "<select class='form-control' onchange='KiemTraGiaoVien("+($soLuongThemGiaoVien+1)+");' id='giaoVien"+($soLuongThemGiaoVien+1)+"' name='giaoVien"+($soLuongThemGiaoVien+1)+"'> "+
            $duLieu+"</select> <div class='input-group-append'>"+
                    "<button class='btn btn-outline-danger' type='button' onclick='truGiaoVien("+($soLuongThemGiaoVien+1)+");'>"+
                    " <i class='fa fa-minus'> </i>  </button> </div></div>";
        ;

        $data = document.getElementById('themGiaoVien').innerHTML;
        document.getElementById('themGiaoVien').innerHTML=$data+$duLieuTong;

        $('#soLuongThemGiaoVien').val(($soLuongThemGiaoVien+1));   
        KiemTraGiaoVien(); 
    }
    function truGiaoVien(id)
    {
        document.getElementById('TrangGiaoVien'+id).innerHTML="";
    }

    function themTroGiang()
    {
        $soLuongThemTroGiang=parseInt($('#soLuongThemTroGiang').val()) ;

        $arr = new Array();

        for($i=1;$i<=$soLuongThemTroGiang;$i++)
        {
            $arr.push($('#troGiang'+$i).val());
        }
        $duLieu="";
        @foreach($troGiang as $item)
            $kiemTra=0;
          
            for( $i=0;$i<$arr.length;$i++ )
            {
                if($arr[$i]=={{$item->employee_id}})
                $kiemTra=1;
              
            }
            if($kiemTra ==0)
            $duLieu+='<option value="{{$item->employee_id}}">{{$item->employee_name}}</option>';
        @endforeach
        
        

        $duLieuTong = "<div id='TrangTroGiang"+($soLuongThemTroGiang+1)+"'> <div class='input-group mb-3'>"+
        "<select class='form-control' onchange='KiemTraGiaoVien("+($soLuongThemTroGiang+1)+");' id='troGiang"+($soLuongThemTroGiang+1)+"' name='troGiang"+($soLuongThemTroGiang+1)+"'> "+
            $duLieu+"</select> <div class='input-group-append'>"+
                    "<button class='btn btn-outline-danger' type='button' onclick='truTroGiang("+($soLuongThemTroGiang+1)+");'>"+
                    " <i class='fa fa-minus'> </i>  </button> </div></div>";
        ;

        $data = document.getElementById('themTroGiang').innerHTML;
        document.getElementById('themTroGiang').innerHTML=$data+$duLieuTong;

        $('#soLuongThemTroGiang').val(($soLuongThemTroGiang+1));   
        KiemTraGiaoVien();  
    }
    function truTroGiang(id)
    {
        document.getElementById('TrangTroGiang'+id).innerHTML="";
    }

    function themNhanVien()
    {
        $soLuongThemGiaoVien=parseInt($('#soLuongThemNhanVien').val()) ;

        $arr = new Array();

        for($i=1;$i<=$soLuongThemGiaoVien;$i++)
        {
            $arr.push($('#nhanVien'+$i).val());
        }
        $duLieu="";
        @foreach($giaoVien as $item)
            $kiemTra=0;
          
            for( $i=0;$i<$arr.length;$i++ )
            {
                if($arr[$i]=={{$item->employee_id}})
                $kiemTra=1;
              
            }
            if($kiemTra ==0)
            $duLieu+='<option value="{{$item->employee_id}}">{{$item->employee_name}}</option>';
        @endforeach
        
        

        $duLieuTong = "<div id='TrangNhanVien"+($soLuongThemGiaoVien+1)+"'> <div class='input-group mb-3'>"+
        "<select class='form-control' onchange='KiemTraGiaoVien("+($soLuongThemGiaoVien+1)+");' id='nhanVien"+($soLuongThemGiaoVien+1)+"' name='nhanVien"+($soLuongThemGiaoVien+1)+"'> "+
            $duLieu+"</select> <div class='input-group-append'>"+
                    "<button class='btn btn-outline-danger' type='button' onclick='truNhanVien("+($soLuongThemGiaoVien+1)+");'>"+
                    " <i class='fa fa-minus'> </i>  </button> </div></div>";
        ;

        $data = document.getElementById('themNhanVien').innerHTML;
        document.getElementById('themNhanVien').innerHTML=$data+$duLieuTong;

        $('#soLuongThemNhanVien').val(($soLuongThemGiaoVien+1));    
        KiemTraGiaoVien(); 
    }
    function truNhanVien(id)
    {
        document.getElementById('TrangNhanVien'+id).innerHTML="";
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
            $soGio = parseInt($('#soGio').val());
            $ngayBatDau= $('#datepicker-autoclose').val();
            $soThu = $('#soThu').val();
            $phong = $('#phong').val();
            $giaoVien = $('#giaoVien').val();
            $gioBatDau = $('#gioBatDau').val();
            $gioketThuc = $('#gioKetThuc').val();
            $troGiang =  $('#troGian').val();
            $id =  $('#id').val();
                $arrThu=[];
                $thoiGian=0;
                for ($i=2;$i<=8;$i++)
                {
                    var ischeck = $('#thu'+$i).is(":checked");
                    if(ischeck==true)
                    {
                        $arrThu.push(1);
                        $thoiGian=1;
                    }
                    else
                        $arrThu.push(0);
                }
              //  alert($ngayBatDau);

                if ($thoiGian==1 &&  $soGio>0)
                {
                    if($gioBatDau< $gioketThuc)
                    {
                        $.ajax({
                            type: 'get',
                            url: '{{ route('kiemTraLopHoc')}}',
                            data: {
                                'soGio': $soGio,
                                'ngayBatDau':$ngayBatDau,
                                'soThu':$soThu,
                                'thu':$arrThu,
                                'phong':$phong,
                                'batDau':$gioBatDau,
                                'ketThuc':$gioketThuc,
                                'id':$id
                            },
                            success: function (data) {
                                if (data[0]['id']==1)
                                {
                                    KiemTra('Kiểm tra',data[0]['text']);
                                    $('#ngayKetThuc').val(data[0]['ngay']);
                                }
                                else
                                $('#ngayKetThuc').val(data[0]['ngay']);

                                searchPhong();
                            //  alert(data);
                            }
                        });
                    }
                    else
                    {
                        KiemTra("Kiểm tra lớp học","Giờ bắt đầu phải nhỏ hơn giờ kết thúc!!!");
                    }
                }
                else
                {
                    $('#ngayKetThuc').val($ngayBatDau);
                }
               
        }


    function searchPhong()
    {
            $soGio = parseInt($('#soGio').val());
            $ngayBatDau= $('#datepicker-autoclose').val();
            $soThu = $('#soThu').val();
            $phong = $('#phong').val();
            $giaoVien = $('#giaoVien').val();
            $gioBatDau = $('#gioBatDau').val();
            $gioketThuc = $('#gioKetThuc').val();
            $troGiang =  $('#troGian').val();
            $idChiNhanh = {{ $lopHoc->branch_id }};
            $id =  $('#id').val();
                $arrThu=[];
                $thoiGian=0;
                for ($i=2;$i<=8;$i++)
                {
                    var ischeck = $('#thu'+$i).is(":checked");
                    if(ischeck==true)
                    {
                        $arrThu.push(1);
                        $thoiGian=1;
                    }
                    else
                        $arrThu.push(0);
                }
              //  alert($ngayBatDau);

                if ($thoiGian==1 &&  $soGio>0)
                {
                    if($gioBatDau< $gioketThuc)
                    {
                        $.ajax({
                            type: 'get',
                            url: '{{ route('searchPhong')}}',
                            data: {
                                'soGio': $soGio,
                                'ngayBatDau':$ngayBatDau,
                                'soThu':$soThu,
                                'thu':$arrThu,
                                'batDau':$gioBatDau,
                                'ketThuc':$gioketThuc,
                                'idChiNhanh':$idChiNhanh,
                                'id':$id
                            },
                            success: function (data) {
                            $out = ' <select class="form-control"  required id="phong" name="phong" onchange="kiemTraGioHoc();">';
                             for($i=0;$i<data.length;$i++)
                             {
                                    $out+=' <option value="'+data[$i]['id']+'">'+data[$i]['ten']+'</option>';
                             }
                             $out+='</select>';
                            document.getElementById('duLieuPhongHoc').innerHTML=$out;
                            }
                        });
                    }
                    else
                    {
                        KiemTra("Kiểm tra lớp học","Giờ bắt đầu phải nhỏ hơn giờ kết thúc!!!");
                    }
                }
                else
                {
                    $('#ngayKetThuc').val($ngayBatDau);
                }
    }    

    function kiemTraGiaoVienThem(giaoVien)
    {
            $soGio = parseInt($('#soGio').val());
            $ngayBatDau= $('#datepicker-autoclose').val();
            $soThu = $('#soThu').val();
            $phong = $('#phong').val();
            $giaoVien = giaoVien;
            $gioBatDau = $('#gioBatDau').val();
            $gioketThuc = $('#gioKetThuc').val();
            $id = $('#id').val();
                $arrThu=[];
                $thoiGian=0;
                for ($i=2;$i<=8;$i++)
                {
                    var ischeck = $('#thu'+$i).is(":checked");
                    if(ischeck==true)
                    {
                        $arrThu.push(1);
                        $thoiGian=1;
                    }
                    else
                        $arrThu.push(0);
                }
              //  alert($ngayBatDau);

                if ($thoiGian==1 &&  $soGio>0)
                {
                    if($gioBatDau< $gioketThuc)
                    {
                        $.ajax({
                            type: 'get',
                            url: '{{ route('kiemTraGiaoVienThem')}}',
                            data: {
                                'soGio': $soGio,
                                'ngayBatDau':$ngayBatDau,
                                'soThu':$soThu,
                                'thu':$arrThu,
                                'batDau':$gioBatDau,
                                'ketThuc':$gioketThuc,
                                'giaoVien':$giaoVien,
                                'id':$id
                            },
                            success: function (data) {
                                if(data!="")
                            KiemTra('Kiểm tra lịch',data)
                           
                        }
                        });
                    }
                    else
                    {
                        KiemTra("Kiểm tra lớp học","Giờ bắt đầu phải nhỏ hơn giờ kết thúc!!!");
                    }
                }
                else
                {
                    $('#ngayKetThuc').val($ngayBatDau);
                }
               
    }

        window.onload = function () {
            var d = new Date();
            $ngay = d.getDate();
            $thang = d.getMonth();
            $nam = d.getFullYear();

            $thang =$thang+1;

            if($ngay<10)
            $ngay="0"+$ngay;

            
            if($thang<10)
            $thang="0"+$thang;
            
            $ngayBatDau = $thang+"/"+$ngay+"/"+$nam;
           $('#ngayKetThuc').val($ngayBatDau);
            $('#datepicker-autoclose').val($ngayBatDau);

            KiemTraGiaoVien();

            $giaoVien = $('#giaoVien1').val();
            $tenGiaoVien =  $('#giaoVien1').text();

         
            $troGiang = $('#troGiang1').val();
            $tenTroGiang =  $('#troGiang1').text();
            $soGio = parseInt($('#soGio').val());
            $ngayBatDau= $('#datepicker-autoclose').val();
            $soThu = $('#soThu').val();
            $phong = $('#phong').val();
            $gioBatDau = $('#gioBatDau').val();
            $gioketThuc = $('#gioKetThuc').val();
            $id = $('#id').val();
                $arrThu=[];
                $thoiGian=0;
                for ($i=2;$i<=8;$i++)
                {
                    var ischeck = $('#thu'+$i).is(":checked");
                    if(ischeck==true)
                    {
                        $arrThu.push(1);
                        $thoiGian=1;
                    }
                    else
                        $arrThu.push(0);
                }
        
                if ($thoiGian==1 &&  $soGio>0)
                {
                    if($gioBatDau< $gioketThuc)
                    {
                        $.ajax({
                            type: 'get',
                            url: '{{ route('kiemTraGiaoVienThem')}}',
                            data: {
                                'soGio': $soGio,
                                'ngayBatDau':$ngayBatDau,
                                'soThu':$soThu,
                                'thu':$arrThu,
                                'batDau':$gioBatDau,
                                'ketThuc':$gioketThuc,
                                'giaoVien':$giaoVien,
                                'id':$id
                            },
                            success: function (data) {
                                $.ajax({
                            type: 'get',
                            url: '{{ route('kiemTraGiaoVienThem')}}',
                            data: {
                                'soGio': $soGio,
                                'ngayBatDau':$ngayBatDau,
                                'soThu':$soThu,
                                'thu':$arrThu,
                                'batDau':$gioBatDau,
                                'ketThuc':$gioketThuc,
                                'giaoVien':$troGiang,
                                'id':$id
                            },
                            success: function (data1) {
                                if(data1!=""||data!="")
                                KiemTra('Kiểm tra lịch',data +". "+data1);
                            
                        }
                        });

                           



                        }
                        });
                    }
                    else
                    {
                        KiemTra("Kiểm tra lớp học","Giờ bắt đầu phải nhỏ hơn giờ kết thúc!!!");
                    }
                }
                else
                {
                    $('#ngayKetThuc').val($ngayBatDau);
                }
            
        };
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
        $kiemTra = KiemTraTruocThem();
       
        if($kiemTra=="")
        {
            $soGio = parseInt($('#soGio').val());
            $ngayBatDau= $('#datepicker-autoclose').val();
            $ngayKetThuc= $('#ngayKetThuc').val();
            $soThu = $('#soThu').val();
            $phong = $('#phong').val();
          
            $gioBatDau = $('#gioBatDau').val();
            $gioketThuc = $('#gioKetThuc').val();
         
          
                $arrThu=[];
                $thoiGian=0;
                for ($i=2;$i<=8;$i++)
                {
                    var ischeck = $('#thu'+$i).is(":checked");
                    if(ischeck==true)
                    {
                        $arrThu.push(1);
                        $thoiGian=1;
                    }
                    else
                        $arrThu.push(0);
                }
                $soLuongThemGiaoVien= $('#soLuongThemGiaoVien').val();
                $soLuongThemTroGiang= $('#soLuongThemTroGiang').val();
                $soLuongThemNhanVien= $('#soLuongThemNhanVien').val();
                $arrGiaoVien = new Array();
                $arrTroGiang = new Array();
                $arrNhanVien = new Array();
                for($i=1;$i<=$soLuongThemGiaoVien;$i++)
                {
                    $arrGiaoVien.push($('#giaoVien'+$i).val());
                }
                $text="";
                for($i=1;$i<=$soLuongThemTroGiang;$i++)
                {                
                    $arrTroGiang.push($('#troGiang'+$i).val());                   
                }
                for($i=1;$i<=$soLuongThemNhanVien;$i++)
                {                
                    $arrNhanVien.push($('#nhanVien'+$i).val());               
                }
                
                $khoaHoc = $('#khoaHoc').val();
                $trangThai = $('#trangThai').val();
                $ten = $('#ten').val();
                $giaoTrinh = $('#giaoTrinh').val();
                $hocPhi= $('#hocPhi').val();
                $id= $('#id').val();
                if ($thoiGian==1 &&  $soGio>0 )
                {
                    if($gioBatDau< $gioketThuc)
                    {
                        $.ajax({
                        type: 'get',
                        url: '{{ route('kiemTraLopHoc')}}',
                        data: {
                            'soGio': $soGio,
                            'ngayBatDau':$ngayBatDau,
                            'soThu':$soThu,
                            'thu':$arrThu,
                            'phong':$phong,
                            'batDau':$gioBatDau,
                            'ketThuc':$gioketThuc,
                            'id':$id
                        },
                        success: function (data) {
                             if (data[0]['id']==1)
                             {
                                 KiemTra("Kiểm tra phòng",data[0]['text']);
                                
                             }
                             else
                             {
                                $.ajax({
                                type: 'get',
                                url: '{{route("postThemXepLichLopHoc")}}',
                                data:{
                                            'soGio': $soGio,
                                            'ngayBatDau':$ngayBatDau,
                                            'ngayKetThuc':$ngayKetThuc,
                                            'thu':$arrThu,
                                            'phong':$phong,
                                            'giaoVien':$arrGiaoVien,
                                            'troGiang':$arrTroGiang,
                                            'nhanVien':$arrNhanVien,
                                            'gioBatDau':$gioBatDau,
                                            'gioKetThuc':$gioketThuc,
                                            'trangThai':$trangThai,
                                            'khoaHoc':$khoaHoc,
                                            'ten':$ten,
                                            'giaoTrinh':$giaoTrinh,
                                            'hocPhi':$hocPhi,
                                            'id':$id
                                        },
                                success: function(data) {
                                    if (data == 1) {
                                        ThemThanhCong("Xếp lịch", "Xếp lịch thành công!!!");
                                        setTimeout(function() {
                                            window.location = "{{route('getLopHoc')}}";
                                        }, 2000);

                                    } else if (data == 2) {
                                        KiemTra("Xếp lịch", "Bạn không có quyền này!!!");
                                    }

                                    else {
                                        PhatHienLoi('Xếp lịchc', "Lỗi Kết Nối!!!");
                                    }

                                     // alert(data);
                                }
                            });
                             }
                          
                          //  alert(data);
                        }
                    });
                    }
                    else
                    {
                        KiemTra("Kiểm tra lớp học","Giờ bắt đầu phải nhỏ hơn giờ kết thúc!!!");
                    }
                  
                }
                else
                {
                    KiemTra("Kiểm tra lớp học","Vui lòng chọn thứ và nhập số giờ lớn hơn kho!!!");
                }
           
        }
        else
        {
            KiemTra("Nhân viên",$kiemTra);
        }

       
        return false;
    });
</script>



@endsection