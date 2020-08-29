@extends('master.masterAdmin')
@section('title')
Chờ Mở Lớp
@endsection
@section('contain')
<div class="content-body">

    <!-- <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    </ol>
                </div>
            </div> -->
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Chờ mở lớp</h4>
                        <br>
                        <div class="row">

                            <div class="col-lg-3 col-sm-6">
                                <label>Chương trình học</label>
                                <select class="form-control" id="chuongTrinh" name="chuongTrinh" onchange="changeCTH();">
                                    @foreach($chuongTrinhHoc as $item)
                                    <option value="{{$item->studyProgram_id}}">{{$item->studyProgram_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <label>Khóa học</label>
                                <div id="duLieuKhoaHoc">
                                    <select class="form-control" id="khoaHoc" name="khoaHoc" onchange="changeKH();">
                                        @foreach($khoaHoc as $item)
                                        <option value="{{$item->course_id}}">{{$item->course_name}}</option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>

                            <div class="col-lg-3 col-sm-6">

                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Tên học viên</th>
                                    <th>Số đt HV</th>
                                    <th>Số đt PH</th>
                                    <th>Ngày sinh</th>
                                    <th>Địa chỉ</th>
                                    <th>Kết quả</th>
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($phongVan as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->student_firstName}} {{$item->student_lastName}}</td>
                                    <td>{{$item->student_phone}}</td>
                                    <td>{{$item->student_parentPhone}}</td>
                                    <td>{{date('d/m/Y',strtotime($item->student_birthDay)) }}</td>
                                    <td>{{$item->student_address}}</td>
                                    @if($item->course_id==$idkhoaHoc)
                                    <td>PT chính</td>
                                    @else
                                    <td>PT phụ</td>
                                    @endif
                                </tr>
                                @php $i++; @endphp
                                @endforeach
                                @foreach($hocThu as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->student_firstName}} {{$item->student_lastName}}</td>
                                    <td>{{$item->student_phone}}</td>
                                    <td>{{date('d/m/Y',strtotime($item->student_birthDay)) }}</td>
                                    <td>{{$item->student_address}}</td>
                                    <td>Học thử</td>
                                   
                                </tr>
                                @php $i++; @endphp
                                @endforeach

                                
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
    function changeCTH() {
        $chuongTrinhHoc = $('#chuongTrinh').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchCTHChoMoLop")}}',
            data: {
                'chuongTrinhHoc': $chuongTrinhHoc,
            },
            success: function(data) {
                document.getElementById('duLieuSearch').innerHTML = data[0]['duLieu'];
                document.getElementById('duLieuKhoaHoc').innerHTML = data[0]['khoaHoc'];
            }
        });
    }
    function changeKH() {
        $khoaHoc = $('#khoaHoc').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchKHChoMoLop")}}',
            data: {
                'khoaHoc': $khoaHoc,
            },
            success: function(data) {
                document.getElementById('duLieuSearch').innerHTML = data;
                 }
        });
    }
</script>

@endsection