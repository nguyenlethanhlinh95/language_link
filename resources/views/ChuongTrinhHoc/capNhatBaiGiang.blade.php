@extends('master.masterAdmin')
@section('title')
khuyến mãi
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
                        <h4 class="card-title">Cập nhật bài giảng </h4>
                        <br>
                        <form id="myform1" autocomplete="off"  action="{{ route('postChinhSuaBaiDay') }}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-12 col-sm-6">
                                    <input id="id" name="id" hidden value="{{$baiGiang->course_id}}">
                                    <input id="id2" name="id2" hidden value="{{$baiGiang->pacingGuide_id}}">
                                    <label>Nội dung  <span style="color: red">*</span></label>
                                    <textarea name="ten" id="ten" required>{{$baiGiang->pacingGuide_name}}</textarea>
                                </div>
                            </div>

                            <br>
                            <br>
                            <div style="text-align: center">
                                <button type="submit" class="btn mb-1 btn-outline-success">Thêm mới</button>
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
<script>
   CKEDITOR.replace('ten');
   
</script>
@endsection