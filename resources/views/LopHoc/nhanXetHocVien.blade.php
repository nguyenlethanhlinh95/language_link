@extends('master.masterAdmin')
@section('title')
Lớp học
@endsection
@section('contain')
<div class="content-body">
    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Nhận xét</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label id="tenNhanXet">Nhận xét</label>
                        <input hidden id="id" name="id" value="{{ $classStudent->classStudent_id }}">
                        <input hidden id="id2" name="id2" value="">
                        <input hidden id="type" name="type" value="{{ $type }}">
                        <input class="form-control" id="nhanXet" name="nhanXet" value="">
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-success">Thêm mới</button>
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
                        <h4 class="card-title">Nhận xét học viên: {{ $classStudent->student_firstName }} {{ $classStudent->student_lastName }}</h4>
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
                                    <th>Nhận xét</th>
                                    <th>Chi tiết</th>
                                    <th>Kết quả</th>
                                    <th>Cập nhật</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=0; @endphp
                                @foreach($nhanXetLop as $item)
                                <tr>
                                    <td>@php echo $i+1; @endphp</td>
                                    <td>{{ $item->comment_name }}</td>
                                    <td>{{ $item->commentDetail_name }}</td>
                                    <td>{{ $ketQuaNhanXet[$i]['ketQua']}}</td>
                                    <td><a class="btn" data-toggle="modal" data-target="#basicModal" 
                                        onclick="setValue('{{ $item->commentDetail_id }}'
                                        ,'{{ $ketQuaNhanXet[$i]['ketQua'] }}' ,'{{ $item->commentDetail_name }}');">
                                        <i class="fa fa-edit"></i></a></td>
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
    function setValue(id,duLieu,ten)
    {
        $('#id2').val(id);
        $('#nhanXet').val(duLieu);
        document.getElementById('tenNhanXet').innerHTML="Nhận xét "+ten;
    }

    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postNhanXetHocVien")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Nhận xét học viên", "Nhận xét thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getNhanXetHocVien')}}?id={{$classStudent->classStudent_id}}&type={{ $type }}";
                    }, 500);

                } else if (data == 2) {
                    KiemTra("Nhận xét học viên", "Bạn không có quyền Nhận xét!!!");
                } 
               
                else {
                    PhatHienLoi('Thêm học viên', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection