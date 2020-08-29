@extends('master.masterAdmin')
@section('title')
Lớp học
@endsection
@section('contain')
<div class="content-body">
<div class="row page-titles mx-0" style="padding-bottom: 0px!important">
        <div class="col p-md-0">
            <ol class="breadcrumb" style="float:left!important">
                <li class="breadcrumb-item active" ><a href="{{ url()->previous() }}" class="btn mb-1 btn-rounded btn-outline-dark fa fa-backward">&nbsp;&nbsp;Back</a></li>
            </ol>
        </div>
    </div>
   
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Kết quả học tập lớp: {{ $lop->class_name }}</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                               
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                          
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Học viên</th>
                                    <th>Nickname</th>
                                    <th>Kết quả học tập</th>
                                   
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=0; @endphp
                                @foreach($hocVien as $item)
                                <tr>
                                    <td>@php echo $i+1; @endphp</td>
                                    <td>{{ $item->student_firstName }} {{ $item->student_lastName }}</td>
                                    <td>{{ $item->student_nickName }}</td>
                                    <td><a href="{{ route('getLoaiKetQuaHocTapHocVien') }}?id={{ $item->classStudent_id }}"><i class="fa fa-edit"></i></a></td>
                                   
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
   
</script>
@endsection