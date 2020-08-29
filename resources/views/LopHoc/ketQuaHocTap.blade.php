@extends('master.masterAdmin')
@section('title')
kết quả học tập
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
    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật kết quả học tập</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input hidden id="id" name="id" >
                        <input hidden id="idClassStudent" name="idClassStudent" value="{{ $hocVien->classStudent_id }}" >
                        <label>Kết quả</label>
                        <div id="duLieuKetQua">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-success">Cập nhật</button>
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
                        <h4 class="card-title">Học viên: {{ $hocVien->student_firstName }} {{ $hocVien->student_lastName }}</h4>
                       
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Kết quả học tập</th>
                                    <th>Tối đa</th>
                                    <th>Nội dung</th>
                                    <th>Cập nhật</th>
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($arrKetQua as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item['learningOutcome_name']}}</td>
                                    @if($item['learningOutcome_type']==1)
                                    <td>{{$item['learningOutcome_point']}}</td>
                                    @else 
                                    <td></td>
                                    @endif

                                    <td>{{$item['learningOutcome_commnet']}}</td>
                                  
                                    <td><a class="btn" data-toggle="modal" data-target="#basicModal"
                                        onclick="setValue('{{$item['learningOutcome_id']}}',
                                        '{{$item['learningOutcome_name']}}','{{$item['learningOutcome_commnet']}}'
                                        ,'{{$item['learningOutcome_type']}}')"
                                        >
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
   

    function setValue(id, ten,commnet,loai) {
        $('#id').val(id);
        if(loai==1)
        {
            document.getElementById('duLieuKetQua').innerHTML="<input class='form-control' id='diem' name='diem' type='number' value='"+commnet+"'>";
        }
        else
        {
            document.getElementById('duLieuKetQua').innerHTML="<input class='form-control' id='diem' name='diem' type='text' value='"+commnet+"'>";
       
        }
       
    
    }
    
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatKetQuaHocVien")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật kết quả học tập", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getKetQuaHocTapHocVien')}}?id={{$id}}&type={{$type}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật kết quả học tập", "Bạn không có quyền cập nhật!!!");
                }
                else {
                    PhatHienLoi('Thêm kết quả học tập', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection