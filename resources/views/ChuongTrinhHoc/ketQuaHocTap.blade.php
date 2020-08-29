@extends('master.masterAdmin')
@section('title')
Bài Giảng
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm kết quả học tập</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id" name="id" hidden value="{{$loaiKetQuaHocTap->learningOutcomeType_id}}">
                        <label>Loại kết quả  <span style="color: red">*</span></label>
                        <select class="form-control" name="loai" id="loai" onchange="thayDoiLoai();">
                            <option value="1">Điểm số</option>
                            <option value="2">Nhận xét</option>
                        </select>
                        <label>Tên kết quả  <span style="color: red">*</span></label>
                        <input maxlength="100" class="form-control" required id="ten" name="ten">
                        <div id="duLieuLoai">
                            <label>Điểm số  <span style="color: red">*</span></label>
                            <input id="diemSo" name="diemSo" required type="number" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-success">Thêm mới</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="modal fade" id="basicModal2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform2" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật kết quả học tập</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id2" name="id2" hidden>
                        <label>Loại kết quả  <span style="color: red">*</span></label>
                        <select class="form-control" required name="loai2" id="loai2" onchange="thayDoiLoai2();">
                            <option value="1">Điểm số</option>
                            <option value="2">Nhận xét</option>
                        </select>
                        <label>Tên kết quả  <span style="color: red">*</span></label>
                        <input maxlength="100" class="form-control" required id="ten2" name="ten2">
                        <div id="duLieuLoai2">
                            <label>Điểm số <span style="color: red">*</span></label>
                            <input id="diemSo2" name="diemSo2" required  d type="number" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-primary">Cập nhật</button>
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
                        <h4 class="card-title">kết quả học tập: {{$loaiKetQuaHocTap->learningOutcomeType_name}} ({{$loaiKetQuaHocTap->course_name}})</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" placeholder="Search kết quả" aria-label="Tìm chương trình">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen122')==1)
                                <button type="button" class="btn mb-1 btn-outline-success" data-toggle="modal" data-target="#basicModal" style="float: right">Thêm mới</button>
                            @endif
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Kết quả học tập</th>
                                    <th>Loại kết quả học tập</th>
                                    <th>Điểm số</th>
                                    @if(session('quyen123')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen124')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($ketQuaHocTap as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->learningOutcome_name}}</td>
                                    @if($item->learningOutcome_type==1)
                                    <td>Điểm số</td>
                                    @else 
                                    <td>Nhận xét</td>
                                    @endif
                                    <td>{{$item->learningOutcome_point}}</td>
                                    @if(session('quyen123')==1)
                                    @if($item->learningOutcome_point!="")
                                    @php $diemSo =$item->learningOutcome_point;  @endphp
                                    @else
                                    @php $diemSo =0;  @endphp
                                    @endif
                                    <td><a class="btn" data-toggle="modal" data-target="#basicModal2"
                                        onclick="setValue('{{$item->learningOutcome_id}}','{{$item->learningOutcome_name}}','{{$item->learningOutcome_type}}','@php echo $diemSo @endphp');" >

                                            <i style="color: blue" 
                                             class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    @endif
                                    @if(session('quyen124')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->learningOutcome_id}}');">
                                            <i style="color: red" class="fa fa-close"></i>
                                        </a>
                                    </td>
                                    @endif
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
function search() {
    
    $value = $('#valueSearch').val();
    $idKhoaHoc = {{ $loaiKetQuaHocTap->learningOutcomeType_id}};
    $.ajax({
        type: 'get',
        url: '{{route("searchKetQuaHocTap")}}',
        data: {
            'value': $value,
            'idKhoaHoc':$idKhoaHoc
        },
        success: function(data) {
            document.getElementById('duLieuSearch').innerHTML = data;

        }
    });
}


    function thayDoiLoai()
    {
        $loai =$('#loai').val();

        duLieuLoai($loai,"");
    }

    function thayDoiLoai2()
    {
        $loai =$('#loai2').val();

        duLieuLoai2($loai,"");
    }

    function duLieuLoai2(loai,text)
    {
        if(loai==1)
        {
            document.getElementById('duLieuLoai2').innerHTML='<label>Điểm số <span style="color: red">*</span></label><input required id="diemSo2" name="diemSo2" type="number" value="'+text+'" class="form-control">';
        }
        else
        {
            document.getElementById('duLieuLoai2').innerHTML="";
        }
    }

    function duLieuLoai(loai,text)
    {
        if(loai==1)
        {
            document.getElementById('duLieuLoai').innerHTML='<label>Điểm số <span style="color: red">*</span></label><input required id="diemSo" name="diemSo" type="number" value="'+text+'" class="form-control">';
        }
        else
        {
            document.getElementById('duLieuLoai').innerHTML="";
        }
    }


    function xoa(id) {
        swal({
                title: "BẠN MUỐN XÓA ?",
                text: "HÀNH ĐỘNG NÀY SẼ XÓA TẤT CẢ LIỀN QUAN !!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes !!",
                cancelButtonText: "No !!",
                closeOnConfirm: !1,
                closeOnCancel: !1
            },
            function(e) {
                e ? swal(
                        $.ajax({
                            type: 'get',
                            url: '{{route("getXoaKetQuaHocTap")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getKetQuaHocTap')}}?id={{$loaiKetQuaHocTap->learningOutcomeType_id}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa kết quả học tập", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa kết quả học tập", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id, ten,loai,diem) {
        $('#id2').val(id);
        $('#ten2').val(ten);
        $('#loai2').val(loai);
        duLieuLoai2(loai,diem);

    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemKetQuaHocTap")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm kết quả học tập", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getKetQuaHocTap')}}?id={{$loaiKetQuaHocTap->learningOutcomeType_id}}";
                    }, 2000);
                } else if (data == 2) {
                    KiemTra("Thêm kết quả học tập", "Bạn không có quyền thêm!!!");
                }               
                else {
                    PhatHienLoi('Thêm kết quả học tập', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatKetQuaHocTap")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật kết quả học tập", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getKetQuaHocTap')}}?id={{$loaiKetQuaHocTap->learningOutcomeType_id}}";
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