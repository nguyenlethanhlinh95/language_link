@extends('master.masterAdmin')
@section('title')
HỌC VIÊ<Nav></Nav>
@endsection
@section('contain')
<div class="content-body">
    <style>
        .table .table {
            background-color: white !important;
        }
    </style>

    <!-- <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    </ol>
                </div>
            </div> -->
    <div class="row page-titles mx-0" style="padding-bottom: 0px!important">
        <div class="col p-md-0">
            <ol class="breadcrumb" style="float:left!important">
                <li class="breadcrumb-item active" ><a href="{{ url()->previous() }}" class="btn mb-1 btn-rounded btn-outline-dark fa fa-backward">&nbsp;&nbsp;Back</a></li>
            </ol>
        </div>
    </div> 
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Thông tin học viên</h4>
                        <br>



                        <br>
                        <br>
                        <table class="table  table-bordered ">
                            <thead>
                            </thead>
                            <tbody id="duLieuSearch">
                                <tr>
                                    <td style="width:20%" rowspan="5">
                                        @if($hocVien->student_link!="")
                                        <img width="100%" src="https://drive.google.com/uc?id={{$hocVien->student_link}}" >
                                        @elseif($hocVien->student_img=="")
                                        <img width="100%" src="{{asset('images/user/form-user.png')}}">
                                        @else
                                        <img width="100%" src="{{asset('images/'.$hocVien->student_img)}}">
                                        @endif
                                    </td>
                                    <td><b>Tên HV:</b> {{$hocVien->student_firstName}} {{$hocVien->student_lastName}}</td>
                                    <td><b>Tên PH:</b> {{$hocVien->student_parentName}}</td>
                                </tr>
                                <tr>
                                    <td><b>Mã học Viên:</b> {{$maHocVien}}</td>
                                    <td><b>Nick name:</b> {{$hocVien->student_nickName}}</td>
                                </tr>
                                <tr>
                                    <td><b>Ngày sinh HV:</b> {{date('d/m/Y',strtotime($hocVien->student_birthDay)) }}</td>
                                    <td><b>Số đt PH:</b> {{$hocVien->student_parentPhone}}</td>
                                </tr>
                               
                                <tr>

                                    <td><b>Số đt HV:</b> {{$hocVien->student_phone}}</td>
                                    <td><b>Email:</b> {{$hocVien->student_email}}</td>
                                </tr>
                                <tr>

                                    <td ><b>Địa Chỉ:</b> {{$hocVien->student_address}}</td>
                                    <td ><b>Số dư:</b> {{number_format($hocVien->student_surplus,0,"",".") }}đ</td>
                                </tr>
                                <tr>
                                    <td><b>Bạn Biết LL qua:</b></td>
                                    <td colspan="2">
                                        <div class="row">
                                            @foreach($marketing as $item)
                                            @php $check =0; @endphp
                                            @foreach($khachHangMarketTing as $item1)
                                            @if($item1->marketing_id== $item->marketing_id)
                                            @php $check =1; @endphp
                                            @endif
                                            @endforeach
                                            @if($check==1)
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="form-check mb-3">
                                                    <label class="form-check-label">
                                                        <input checked name="marketing{{$item->marketing_id}}" type="checkbox" class="form-check-input">{{$item->marketing_name}}
                                                    </label>
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="form-check mb-3">
                                                    <label class="form-check-label">
                                                        <input name="marketing{{$item->marketing_id}}" type="checkbox" class="form-check-input">{{$item->marketing_name}}
                                                    </label>
                                                </div>
                                            </div>
                                            @endif

                                            @endforeach
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Phỏng Vấn:</b></td>
                                    <td colspan="2">
                                        <table class="table table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Thời gian phỏng vấn</th>
                                                    <th>Giáo viên</th>
                                                    <th>Khóa học</th>
                                                    <th>Kết quả</th>
                                                </tr>
                                            </thead>
                                            <tbody id="duLieuSearch">
                                                @php $i=1; @endphp
                                                @foreach($phongVan as $item)
                                                <tr>
                                                    <td>@php echo $i; @endphp</td>
                                                    <td>{{date("H:i d/m/Y", strtotime($item->placementTest_dateTime))}}</td>
                                                    <td>{{$item->employee_name}}</td>
                                                    <td>{{$item->studyProgram_name}}</td>
                                                    <td><a href="{{route('getCapNhatKetQuaPhongVan')}}?id={{$item->placementTest_id}}">Chi tiết</a></td>
                                                </tr>
                                                @php $i++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Khóa Học:</b></td>
                                    <td colspan="2">
                                        <table class="table table-bordered ">
                                            <thead>
                                                <tr>
                                                    
                                                    <th>Tên khóa học</th>
                                                    <th>Ngày khai giảng</th>
                                                    <th>Ngày kết khóa</th>
                                                    <th>Tình trạng</th>
                                                    <th>Học phí</th>
                                                </tr>
                                            </thead>
                                            <tbody id="duLieuSearch">
                                                @foreach($khoaHoc as $item)
                                                <tr>
                                                <td>{{$item['tenKhoaHoc']}}</td>
                                                <td>{{$item['ngayBatDau']}}</td>
                                                <td>{{$item['ngayKetThuc']}}</td>
                                                <td>{{$item['trangThai']}}</td>
                                                <td>{{$item['hocPhi']}}</td>
                                                </tr>
                                                @endforeach
                                               
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                       <div class="row">
                        <div class="col-lg-6 col-sm-6" style="text-align: center">
                        @if(session('quyen32')==1)
                                <a href="{{route('getThemPhongVan')}}?id={{$hocVien->student_id}}">
                                <button  type="button" class="btn mb-1 btn-outline-success">PT</button>
                            
                                </a>
                            @endif
                        </div>
                        <div class="col-lg-6 col-sm-6" style="text-align: center">
                        @if(session('quyen112')==1)
                            <a href="{{route('getThemPhieuThu')}}?id={{$hocVien->student_id}}">
                                    <button  type="button" class="btn mb-1 btn-outline-warning" >Phiếu thu</button>
                            </a>
                        @endif
                        </div>
    
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>


@endsection