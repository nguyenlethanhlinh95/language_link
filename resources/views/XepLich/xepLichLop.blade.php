@extends('master.masterAdmin')
@section('title')
Lớp học
@endsection
@section('contain')
<div class="content-body">
<style>
    input[type="checkbox"]:after {
 
    border: 1px solid  #482424 !important;
  
}
   
</style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Schedule</h4>
                        <br>
                        <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                    <label>Class name <span style="color: red">*</span></label>
                                    <input hidden id="id" name="id" value="{{ $lop->class_id }}">
                                    <input required maxlength="100" class="form-control" name="ten" id="ten" value="{{ $lop->class_name }}">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>branch <span style="color: red">*</span></label>
                                    <input hidden id="chiNhanh" name="chiNhanh" value="{{ $chiNhanh->branch_id }}">
                                    <input readonly class="form-control" value="{{ $chiNhanh->branch_name }}">
                               </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Study program  <span style="color: red">*</span></label>

                                    <div id="duLieuCTH">
                                        <select class="form-control" id="chuongTrinh" name="chuongTrinh" onchange="changeCTH();" required>
                                            @foreach($chuongTrinhHoc as $item)
                                            @if($CTDau->studyProgram_id== $item->studyProgram_id)
                                            <option selected value="{{$item->studyProgram_id}}">{{$item->studyProgram_name}}</option>
                                            @else 
                                            <option value="{{$item->studyProgram_id}}">{{$item->studyProgram_name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                <label>Course <span style="color: red">*</span></label>
                                    <div id="duLieuKhoaHoc">
                                        <select required class="form-control" id="khoaHoc" name="khoaHoc" onchange="changeKH();">
                                            
                                                @foreach($khoaHoc as $item)
                                                @if($CTDau->course_id== $item->course_id)
                                                <option selected value="{{$item->course_id}}">{{$item->course_name}}</option>
                                                @else 
                                                <option value="{{$item->course_id}}">{{$item->course_name}}</option>
                                                @endif
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Room <span style="color: red">*</span></label>
                                    <div id="duLieuPhongHoc">
                                        <select class="form-control"  required id="phong" name="phong" onchange="kiemTraGioHoc();">
                                            @foreach($phongHoc as $item)
                                            <option value="{{$item->room_id}}">{{$item->room_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Hours <span style="color: red">*</span></label>
                                   <input class="form-control" type="number" required id="soGio" name="soGio" value="{{ $soGio }}" onkeyup="kiemTraGioHoc();">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Start date <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <input type="text" required class="form-control" id="datepicker-autoclose"  value="{{ date('m/d/Y',strtotime($lop->class_startDay)) }}"
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
                                    <label>End date</label>
                                   <input class="form-control" readonly id="ngayKetThuc" name="ngayKetThuc" value="{{ date('m/d/Y',strtotime($lop->class_endDay)) }}">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Material <span style="color: red">*</span></label>
                                    <input required class=" form-control" required id="giaoTrinh" name="giaoTrinh" value="{{ $giaoTrinh }}">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>Number of lessons</label>
                                    <input hidden  class=" form-control"  id="hocPhi" name="hocPhi" value="{{ $hocPhi }}">
                                    <input  readonly class=" form-control"  id="soBuoiHoc" name="soBuoiHoc" value="0">
                                </div>
                               
                                <div class="col-lg-3 col-sm-6">
                                    <label>Status <span style="color: red">*</span></label>
                                   <select class="form-control" id="trangThai" name="trangThai" required>
                                       @if($lop->class_status==1)
                                        <option selected value="1">Waiting</option>
                                        <option value="0">Canceled</option>
                                        @else 
                                        <option value="1">Waiting</option>
                                        <option selected value="0">Canceled</option>
                                        @endif
                                   </select>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label>EC <span style="color: red">*</span></label> 
                                    <select class="js-example-responsive" style="width: 100%" id="nhanVien2" name="nhanVien2"  onchange="kiemTraGiaoVienTrung();">
                                        @foreach($NVDungLop as $item)
                                        <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                        @endforeach
                                        </select>
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
                               
                                    <div class="col-lg-2">
                                        Monday <br>
                                       &nbsp;
                                       @if($thuNgay->classDay_day2==1)
                                       <input checked  type="checkbox" name="thu2" id="thu2"> 
                                       @else 
                                       <input   type="checkbox" name="thu2" id="thu2"> 
                                       @endif
                                    </div>
                                    <div class="col-lg-3">
                                       <label>Teacher</label>
                                       <select class="js-example-responsive" style="width: 100%" id="giaoVien2" name="giaoVien2" onchange="kiemTraGioHoc();">
                                        @foreach($giaoVien as $item)
                                        <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>TA</label> 
                                        <select class="js-example-responsive" style="width: 100%" id="troGiang2" name="troGiang2"  onchange="kiemTraGioHoc();">
                                            <option value="0">Không<option>
                                            @foreach($troGiang as $item)
                                            <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                            @endforeach
                                            </select>
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <label>Start time</label>
                                        <div class="input-group clockpicker">
                                            <input required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_startTime2 }}" onchange ="kiemTraGioHoc();"  name="gioBatDau2" id="gioBatDau2" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                       
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <label>End time</label>
                                        <div class="input-group clockpicker">
                                            <input readonly required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_endTime2 }}"  onchange="kiemTraGioHoc();" name="gioKetThuc2" id="gioKetThuc2" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12" style="padding: 5px"></div>
                                   
                                    <div class="col-lg-2">
                                       
                                        Tuesday <br>
                                       &nbsp; @if($thuNgay->classDay_day3==1)
                                       <input checked  type="checkbox" name="thu3" id="thu3"> 
                                       @else 
                                       <input   type="checkbox" name="thu3" id="thu3"> 
                                       @endif
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Teacher</label>
                                        <select class="js-example-responsive" style="width: 100%" id="giaoVien3" name="giaoVien3"  onchange="kiemTraGioHoc();">
                                         @foreach($giaoVien as $item)
                                         <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                         @endforeach
                                         </select>
                                     </div>
                                     <div class="col-lg-3">
                                         <label>TA</label> 
                                         <select class="js-example-responsive" style="width: 100%" id="troGiang3" name="troGiang3"  onchange="kiemTraGioHoc();">
                                            <option value="0">Không<option> 
                                            @foreach($troGiang as $item)
                                             <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                             @endforeach
                                             </select>
                                     </div>
                                     <div class="col-lg-2 col-sm-6">
                                        <label>Start time</label>
                                        <div class="input-group clockpicker">
                                            <input required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_startTime3 }}" onchange ="kiemTraGioHoc();"  name="gioBatDau3" id="gioBatDau3" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                       
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <label>End time</label>
                                        <div class="input-group clockpicker">
                                            <input readonly required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_endTime3 }}"  onchange="kiemTraGioHoc();" name="gioKetThuc3" id="gioKetThuc3" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                    </div>
                                     
                                     <div class="col-lg-12" style="padding: 5px"></div>
                                     
                                    <div class="col-lg-2">
                                        Wednesday <br>
                                       &nbsp; @if($thuNgay->classDay_day2==1)
                                       <input checked  type="checkbox" name="thu4" id="thu4"> 
                                       @else 
                                       <input   type="checkbox" name="thu4" id="thu4"> 
                                       @endif
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Teacher</label>
                                        <select class="js-example-responsive" style="width: 100%" id="giaoVien4" name="giaoVien4"  onchange="kiemTraGioHoc();">
                                        
                                            @foreach($giaoVien as $item)
                                         <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                         @endforeach
                                         </select>
                                     </div>
                                     <div class="col-lg-3">
                                         <label>TA</label> 
                                         <select class="js-example-responsive" style="width: 100%" id="troGiang4" name="troGiang4"  onchange="kiemTraGioHoc();">
                                            <option value="0">Không<option>
                                            @foreach($troGiang as $item)
                                             <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                             @endforeach
                                             </select>
                                     </div>
                                     <div class="col-lg-2 col-sm-6">
                                        <label>Start time</label>
                                        <div class="input-group clockpicker">
                                            <input required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_startTime4}}" onchange ="kiemTraGioHoc();"  name="gioBatDau4" id="gioBatDau4" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                       
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <label>End time</label>
                                        <div class="input-group clockpicker">
                                            <input readonly required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_endTime4 }}"  onchange="kiemTraGioHoc();" name="gioKetThuc4" id="gioKetThuc4" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                    </div>
                                     
                                     <div class="col-lg-12" style="padding: 5px"></div>
                                     
                                    <div class="col-lg-2">
                                        Thursday <br>
                                        &nbsp; @if($thuNgay->classDay_day5==1)
                                        <input checked  type="checkbox" name="thu5" id="thu5"> 
                                        @else 
                                        <input   type="checkbox" name="thu5" id="thu5"> 
                                        @endif
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Teacher</label>
                                        <select class="js-example-responsive" style="width: 100%" id="giaoVien5" name="giaoVien5"  onchange="kiemTraGioHoc();">
                                         @foreach($giaoVien as $item)
                                         <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                         @endforeach
                                         </select>
                                     </div>
                                     <div class="col-lg-3">
                                         <label>TA</label> 
                                         <select class="js-example-responsive" style="width: 100%" id="troGiang5" name="troGiang5"  onchange="kiemTraGioHoc();">
                                            <option value="0">Không<option>
                                            @foreach($troGiang as $item)
                                             <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                             @endforeach
                                             </select>
                                     </div>
                                     <div class="col-lg-2 col-sm-6">
                                        <label>Start time</label>
                                        <div class="input-group clockpicker">
                                            <input required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_startTime5 }}" onchange ="kiemTraGioHoc();"  name="gioBatDau5" id="gioBatDau5" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                       
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <label>End time</label>
                                        <div class="input-group clockpicker">
                                            <input readonly required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_endTime5 }}"  onchange="kiemTraGioHoc();" name="gioKetThuc5" id="gioKetThuc5" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                    </div>
                                     
                                     <div class="col-lg-12" style="padding: 5px"></div>
                                    
                                    <div class="col-lg-2">
                                      
                                        Friday<br>
                                       &nbsp; @if($thuNgay->classDay_day6==1)
                                       <input checked  type="checkbox" name="thu6" id="thu6"> 
                                       @else 
                                       <input   type="checkbox" name="thu6" id="thu6"> 
                                       @endif
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Teacher</label>
                                        <select class="js-example-responsive" style="width: 100%" id="giaoVien6" name="giaoVien6"  onchange="kiemTraGioHoc();">
                                         @foreach($giaoVien as $item)
                                         <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                         @endforeach
                                         </select>
                                     </div>
                                     <div class="col-lg-3">
                                         <label>TA</label> 
                                         <select class="js-example-responsive" style="width: 100%" id="troGiang6" name="troGiang6" onchange="kiemTraGioHoc();" >
                                            <option value="0">Không<option>
                                            @foreach($troGiang as $item)
                                             <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                             @endforeach
                                             </select>
                                     </div>
                                     <div class="col-lg-2 col-sm-6">
                                        <label>Start time</label>
                                        <div class="input-group clockpicker">
                                            <input  required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_startTime6 }}" onchange ="kiemTraGioHoc();"  name="gioBatDau6" id="gioBatDau6" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                       
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <label>End time</label>
                                        <div class="input-group clockpicker">
                                            <input  readonly required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_endTime6 }}"  onchange="kiemTraGioHoc();" name="gioKetThuc6" id="gioKetThuc6" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                    </div>
                                     
                                     <div class="col-lg-12" style="padding: 5px"></div>
                                    
                                    <div class="col-lg-2">
                                        Saturday <br>
                                       &nbsp; @if($thuNgay->classDay_day7==1)
                                       <input checked  type="checkbox" name="thu7" id="thu7"> 
                                       @else 
                                       <input   type="checkbox" name="thu7" id="thu7"> 
                                       @endif
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Teacher</label>
                                        <select class="js-example-responsive" style="width: 100%" id="giaoVien7" name="giaoVien7" onchange="kiemTraGioHoc();" >
                                         @foreach($giaoVien as $item)
                                         <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                         @endforeach
                                         </select>
                                     </div>
                                     <div class="col-lg-3">
                                         <label>TA</label> 
                                         <select class="js-example-responsive" style="width: 100%" id="troGiang7" name="troGiang7" onchange="kiemTraGioHoc();" >
                                            <option value="0">Không<option>  
                                            @foreach($troGiang as $item)
                                             <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                             @endforeach
                                             </select>
                                     </div>
                                     <div class="col-lg-2 col-sm-6">
                                        <label>Start time</label>
                                        <div class="input-group clockpicker">
                                            <input  required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_startTime7 }}" onchange ="kiemTraGioHoc();"  name="gioBatDau7" id="gioBatDau7" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                       
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <label>End time</label>
                                        <div class="input-group clockpicker">
                                            <input readonly required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_endTime7 }}"  onchange="kiemTraGioHoc();" name="gioKetThuc7" id="gioKetThuc7" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                    </div>
                                     
                                     <div class="col-lg-12" style="padding: 5px"></div>
                                     
                                    <div class="col-lg-2">
                                        Sunday <br>
                                        &nbsp; @if($thuNgay->classDay_day8==1)
                                        <input checked  type="checkbox" name="thu8" id="thu8"> 
                                        @else 
                                        <input   type="checkbox" name="thu8" id="thu8"> 
                                        @endif 
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Teacher</label>
                                        <select class="js-example-responsive" style="width: 100%" id="giaoVien8" name="giaoVien8"  onchange="kiemTraGioHoc();">
                                         @foreach($giaoVien as $item)
                                         <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                         @endforeach
                                         </select>
                                     </div>
                                     <div class="col-lg-3">
                                         <label>TA</label> 
                                         <select class="js-example-responsive" style="width: 100%" id="troGiang8" name="troGiang8" onchange="kiemTraGioHoc();" >
                                            <option value="0">Không<option>
                                            @foreach($troGiang as $item)
                                             <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                             @endforeach
                                             </select>
                                     </div>
                                     <div class="col-lg-2 col-sm-6">
                                        <label>Start time</label>
                                        <div class="input-group clockpicker">
                                            <input required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_startTime8 }}" onchange ="kiemTraGioHoc();"  name="gioBatDau8" id="gioBatDau8" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                       
                                    </div>
                                    <div class="col-lg-2 col-sm-6">
                                        <label>End time</label>
                                        <div class="input-group clockpicker">
                                            <input readonly required type="text" class="form-control" value="{{ $gioDefault->classTimeDefault_endTime8 }}"  onchange="kiemTraGioHoc();" name="gioKetThuc8" id="gioKetThuc8" value=""> 
                                            <span class="input-group-append"><span class="input-group-text">
                                                <i class="fa fa-clock-o"></i></span></span>
                                        </div>
                                    </div>
                                     
                                     
                            </div>
                            <h3>Change calendar</h3>
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>Start date</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" name="ngayBatDauDoi" id="ngayBatDauDoi" 
                                        placeholder="mm/dd/yyyy" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask> <span class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label>End date</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker"  name="ngayKetThucDoi" id="ngayKetThucDoi" 
                                        placeholder="mm/dd/yyyy" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask> <span class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label>Teacher from</label>
                                    <select class="js-example-responsive" style="width: 100%" id="giaoVienCanDoi" name="giaoVienCanDoi" >
                                        @foreach($giaoVienTong as $item)
                                        <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                        @endforeach
                                        </select>
                                </div>
                                <div class="col-lg-3">
                                    <label>Teacher to</label>
                                    <select class="js-example-responsive" style="width: 100%" id="giaoVienDoi" name="giaoVienDoi" >
                                        @foreach($giaoVienTong as $item)
                                        <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                                        @endforeach
                                        </select>
                                </div>
                            </div>
                            <br>
                                <div  style="text-align: center">
                                    <button type="submit" class="btn mb-1 btn-outline-success">Add new</button>

                                </div>
                              
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
<script src="js/select2.js"></script>

<script>
    $(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
    });
    function changeCoSo()
    {
        $chiNhanh = $('#chiNhanh').val();
        $.ajax({
            type: 'get',
            url: '{{route("changeChiNhanhThemLop")}}',
            data: {
                'chiNhanh': $chiNhanh
            },
            success: function(data) {
                document.getElementById('duLieuKhoaHoc').innerHTML = data[0]['khoaHoc'];
                $('#soGio').val(data[0]['soGio']);
                $('#hocPhi').val(data[0]['hocPhi']);
                $('#giaoTrinh').val(data[0]['sach']);
                document.getElementById('duLieuCTH').innerHTML = data[0]['CTH'];
               
                kiemTraGioHoc();
            }
        });
       
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
                $('#giaoTrinh').val(data[0]['sach']);
               
                kiemTraGioHoc();
            }
        });
       
    }
    function thu($i)
    {
        if($i==2)
        {
            return "monday";
        }
        else if($i==3)
        {
            return "tuesday";
        }
        else if($i==4)
        {
            return "wednesday";
        }
        else if($i==5)
        {
            return "thursday";
        }
        else if($i==6)
        {
            return "friday";
        }
        else if($i==7)
        {
            return "saturday";
        }
        else
        return "sunday";
    }
    function KiemTraGiaoVienBiTrung()
    {
        $duLieuKiemTra = "";
        for($i=2;$i<=8;$i++)
        {
            var checkBox = document.getElementById('thu'+$i);
            var isCheck = checkBox.checked;
            if(isCheck==true)
            {
                $giaoVien = $('#giaoVien'+$i).val();               
                $troGiang = $('#troGiang'+$i).val();
                $nhanVien = $('#nhanVien2').val();

                if($giaoVien==$troGiang || $giaoVien == $nhanVien)
                {
                    $tenGiaoVien=$("#giaoVien"+$i+" option:selected").text();
                    $duLieuKiemTra+= $tenGiaoVien+" at " + thu($i)+" was repeated.    ";
                }
                if($nhanVien==$troGiang )
                {
                    $tenGiaoVien=$("#troGiang"+$i+" option:selected").text();
                    $duLieuKiemTra+= $tenGiaoVien+" at " + thu($i)+" was repeated.    ";
                }
            }
        }
        return $duLieuKiemTra;
    }

    function kiemTraGiaoVienTrung()
    {
       $duLieuKiemTra = KiemTraGiaoVienBiTrung();
        if($duLieuKiemTra!="")
        {
            KiemTra("Warning",$duLieuKiemTra);
        }
       // KiemTra("Kiểm tra giáo viên",$duLieuKiemTra);
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
                $('#giaoTrinh').val(data[0]['sach']);
               
                kiemTraGioHoc();
            }
        });
      
    }
    function kiemTraGioHoc()
        {
            changGio();
            $soGio = parseInt($('#soGio').val());
            $ngayBatDau= $('#datepicker-autoclose').val();
            $soThu = $('#soThu').val();
            $phong = $('#phong').val();
           
            
            $giaoVienCanDoi = $('#giaoVienCanDoi').val();
            $giaoVienDoi = $('#giaoVienDoi').val();


            $ngayBatDauDoi = $('#ngayBatDauDoi').val();
            $ngayKetThucDoi = $('#ngayKetThucDoi').val();

            $arrGiaoVien=[];
            $arrNhanVien=$('#nhanVien2').val();
            $arrTroGiang=[];
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
                        $giaoVien = $('#giaoVien'+$i).val();               
                       $troGiang = $('#troGiang'+$i).val();
                        //$nhanVien = $('#nhanVien'+$i).val();
                        $gioBatDauKiemTra = $('#gioBatDau'+$i).val();
                        $gioketThucKiemTra = $('#gioKetThuc'+$i).val();
                        if($gioBatDauKiemTra >= $gioketThucKiemTra)
                        {
                            KiemTra("Warring","Start time must be less than end time!!!");
                            return;
                        }


                        $arrThu.push(1);
                        $thoiGian=1;
                        $arrGiaoVien.push($giaoVien);
                        $arrTroGiang.push($troGiang);
                       // $arrNhanVien.push($nhanVien);
                        $gioBatDau.push($gioBatDauKiemTra);
                        $gioketThuc.push($gioketThucKiemTra);

                    }
                    else
                    {
                        $arrGiaoVien.push(0);
                     $arrTroGiang.push(0);
                      //  $arrNhanVien.push(0);
                        $arrThu.push(0);

                        $gioBatDau.push(0);

                        $gioketThuc.push(0);
                    }
                       
                }
                

                if ($thoiGian==1 &&  $soGio>0)
                {
                   
                        $.ajax({
                            type: 'get',
                            url: '{{ route('kiemTraXepLichLopHoc')}}',
                            data: {
                                'soGio': $soGio,
                                'ngayBatDau':$ngayBatDau,
                                'soThu':$soThu,
                                'thu':$arrThu,
                                'phong':$phong,
                                'batDau':$gioBatDau,
                                'ketThuc':$gioketThuc,
                                'arrGiaoVien':$arrGiaoVien,
                                'arrTroGiang':$arrTroGiang,
                                'arrNhanVien':$arrNhanVien,
                                 'giaoVienCanDoi':$giaoVienCanDoi,
                                'giaoVienDoi':$giaoVienDoi,
                                 'ngayBatDauDoi':$ngayBatDauDoi,
                                'ngayKetThucDoi':$ngayKetThucDoi
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
                                

                                
                                searchPhong();
                            //  alert(data);
                            }
                        });
                   
                }
                else
                {
                    $('#ngayKetThuc').val($ngayBatDau);
                }
            kiemTraGiaoVienTrung();   
        }


    
    
    
    
    
    function searchPhong()
    {
            $soGio = parseInt($('#soGio').val());
            $ngayBatDau= $('#datepicker-autoclose').val();
            $soThu = $('#soThu').val();
            $phong = $('#phong').val();
            $giaoVien = $('#giaoVien').val();
            $gioBatDau=[];
            $gioketThuc=[];
            $troGiang =  $('#troGian').val();
            $idChiNhanh = $('#chiNhanh').val();
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
                        $gioBatDauKiemTra = $('#gioBatDau'+$i).val();
                        $gioketThucKiemTra = $('#gioKetThuc'+$i).val();
                        if($gioBatDauKiemTra>= $gioketThucKiemTra)
                        {
                            KiemTra("Warring","Start time must be less than end time!!!");
                            return;
                        }
                        $gioBatDau.push($gioBatDauKiemTra);

                        $gioketThuc.push($gioketThucKiemTra);
                    }
                    else{
                        $arrThu.push(0);
                        $gioBatDau.push(0);
                        $gioketThuc.push(0);
                    }
                      
                }
            //  alert($gioBatDau);

                if ($thoiGian==1 &&  $soGio>0)
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
       
            $kiemTraTrung = KiemTraGiaoVienBiTrung();
            if($kiemTraTrung=="")
            {
                $soGio = parseInt($('#soGio').val());
                $ngayBatDau= $('#datepicker-autoclose').val();
                $ngayKetThuc= $('#ngayKetThuc').val();


                $soThu = $('#soThu').val();
                $phong = $('#phong').val();
              
                
                $giaoVienCanDoi = $('#giaoVienCanDoi').val();
                $giaoVienDoi = $('#giaoVienDoi').val();


                $ngayBatDauDoi = $('#ngayBatDauDoi').val();
                $ngayKetThucDoi = $('#ngayKetThucDoi').val();
                $chiNhanh = $('#chiNhanh').val();
                $arrGiaoVien=[];
                $arrNhanVien=$('#nhanVien2').val();;
                $arrTroGiang=[];
                $gioBatDau = [];
                $gioketThuc =[];
                $id =  $('#id').val();
                    $arrThu=[];
                    $thoiGian=0;
                    for ($i=2;$i<=8;$i++)
                    {
                        $gioBatDauKiemTra = $('#gioBatDau'+$i).val();
                        $gioketThucKiemTra = $('#gioKetThuc'+$i).val();
                        $gioBatDau.push($gioBatDauKiemTra);
                        $gioketThuc.push($gioketThucKiemTra);
                        var ischeck = $('#thu'+$i).is(":checked");
                        if(ischeck==true)
                        {
                            $giaoVien = $('#giaoVien'+$i).val();               
                            $troGiang = $('#troGiang'+$i).val();
                          //  $nhanVien = $('#nhanVien'+$i).val();
                        
                                if($gioBatDauKiemTra>= $gioketThucKiemTra)
                                {
                                    KiemTra("Warring","Start time must be less than end time!!!");
                                    return;
                                }
                       
                            $arrThu.push(1);
                            $thoiGian=1;
                            $arrGiaoVien.push($giaoVien);
                            $arrTroGiang.push($troGiang);
                            
                           // $arrNhanVien.push($nhanVien);
                        }
                        else
                        {
                            $arrGiaoVien.push(0);
                            $arrTroGiang.push(0);
                          //  $arrNhanVien.push(0);
                            $arrThu.push(0);
                           
                        }
                       
                    }

                    if ($thoiGian==1 &&  $soGio>0 )
                    {
                            $.ajax({
                            type: 'get',
                            url: '{{ route('kiemTraXepLichLopHoc')}}',
                            data: {
                                    'soGio': $soGio,
                                    'ngayBatDau':$ngayBatDau,
                                    'soThu':$soThu,
                                    'thu':$arrThu,
                                    'phong':$phong,
                                    'chiNhanh':$chiNhanh,
                                    'batDau':$gioBatDau,
                                    'ketThuc':$gioketThuc,
                                    'arrGiaoVien':$arrGiaoVien,
                                    'arrTroGiang':$arrTroGiang,
                                    'arrNhanVien':$arrNhanVien,
                                    'giaoVienCanDoi':$giaoVienCanDoi,
                                    'giaoVienDoi':$giaoVienDoi,
                                    'ngayBatDauDoi':$ngayBatDauDoi,
                                    'ngayKetThucDoi':$ngayKetThucDoi,
                                    'id':$id
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
                                    url: '{{route("postXepLichLopHoc")}}',
                                    data:{
                                        'soGio': $soGio,
                                        'ngayBatDau':$ngayBatDau,
                                        'ngayKetThuc':$ngayKetThuc,
                                        'soThu':$soThu,
                                        'thu':$arrThu,
                                        'phong':$phong,
                                        'batDau':$gioBatDau,
                                        'ketThuc':$gioketThuc,
                                        'arrGiaoVien':$arrGiaoVien,
                                        'arrTroGiang':$arrTroGiang,
                                        'arrNhanVien':$arrNhanVien,
                                        'giaoVienCanDoi':$giaoVienCanDoi,
                                        'giaoVienDoi':$giaoVienDoi,
                                        'ngayBatDauDoi':$ngayBatDauDoi,
                                        'ngayKetThucDoi':$ngayKetThucDoi,
                                        'khoaHoc':$khoaHoc,
                                        'trangThai':$trangThai,
                                        'ten':$ten,
                                        'giaoTrinh':$giaoTrinh,
                                        'hocPhi':$hocPhi,
                                        'chiNhanh':$chiNhanh,
                                        'id':$id
                                            },
                                        success: function(data) {
                                        if (data[0]['loai'] == 1) {
                                            ThemThanhCong("Success", "Schedule successful!!!");
                                            setTimeout(function() {
                                                window.location = "{{route('postLichChiNhanhTuan')}}?id="+$chiNhanh+"&tuan="+data[0]['tuan']+"&class="+data[0]['id'];
                                            }, 2000);

                                        } else if (data[0]['loai'] == 2) {
                                            KiemTra("Warning", "You are not authorized!!!");
                                        }

                                        else {
                                            PhatHienLoi('Error', "Connection errors!!!");
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
                    KiemTra("Warning","Please select a day of the week and hours is greater than zero!!!");
                }
            }
            else
            {
                KiemTra("Warning",$kiemTraTrung);
            }

               
           
      

       
        return false;
    });
</script>




@endsection