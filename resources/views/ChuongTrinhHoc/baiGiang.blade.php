@extends('master.masterAdmin')
@section('title')
Bài Giảng
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="{{ route('postThemBaiDay') }}" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm bài giảng</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id" name="id" hidden value="{{$khoaHoc->course_id}}">
                        <label>Nội dung  <span style="color: red">*</span></label>
                        {{-- <input maxlength="100" class="form-control" required id="ten" name="ten"> --}}
                        <textarea name="ten" required id="ten"></textarea>
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
                        <h5 class="modal-title">Cập nhật bài giảng</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id2" name="id2" hidden>
                        <label>Nội dung  <span style="color: red">*</span></label>
                        {{-- <input maxlength="100" class="form-control" required id="ten2" name="ten2"> --}}
                        <textarea  maxlength="200" class="form-control" required id="ten2" name="ten2"></textarea>
                  
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
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
                        <h4 class="card-title">Bài giảng : {{$khoaHoc->course_name}}</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                            @if(session('quyen82')==1)
                                <a href="{{ route('getThemBaiGiang') }}?id={{$khoaHoc->course_id}}"><button type="button" class="btn mb-1 btn-outline-success" style="float: right">Thêm mới</button></a>
                            @endif
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Nội dung</th>
                                    @if(session('quyen83')==1)
                                    <th>Sửa</th>
                                    @endif
                                    @if(session('quyen84')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($baiGiang as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>@php echo $item->pacingGuide_name;  @endphp </td>
                                   
                                    @if(session('quyen83')==1)
                                    <td><a class="btn" href="{{ route('getCapNhatBaiGiang') }}?id={{ $item->pacingGuide_id }}">
                                            <i style="color: blue"
                                             class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    @endif
                                    @if(session('quyen84')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->pacingGuide_id}}');">
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
<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
<script>
      CKEDITOR.replace('ten');
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
                            url: '{{route("getXoaBaiGiang")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getBaiGiang')}}?id={{$khoaHoc->course_id}}";
                                } else if (data == 2) {
                                    KiemTra("Xóa bài giảng", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa bài giảng", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function setValue(id, ten) {
        $('#id2').val(id);
        $('#ten2').val(ten);
      
    }

    function ketQuaBaiGiang()
    {
        if({{ $sms}} ==1 )
        {
            ThemThanhCong('Bài Giảng',"Cập nhật bài giảng thành công!!!");
        }
        else if({{ $sms}} ==2  )
        {
            KiemTra('Bài Giảng',"Bạn chưa được phân quyền!!!")
        }
        else if({{ $sms}} == 0  )
        {
            PhatHienLoi('Bài Giảng',"Lỗi kết nối. vui lòng thử lại!!!")
        }
    }
    // $('#myform1').submit(function() {
    //     $.ajax({
    //         type: 'Post',
    //         url: '{{route("postThemBaiDay")}}',
    //         data: new FormData(this),
    //         contentType: false,
    //         cache: false,
    //         processData: false,
    //         success: function(data) {
    //             if (data == 1) {
    //                 ThemThanhCong("Thêm bài giảng", "Thêm thành công!!!");
    //                 setTimeout(function() {
    //                     window.location = "{{route('getBaiGiang')}}?id={{$khoaHoc->course_id}}";
    //                 }, 2000);
    //             } else if (data == 2) {
    //                 KiemTra("Thêm bài giảng", "Bạn không có quyền thêm!!!");
    //             }               
    //             else {
    //                 PhatHienLoi('Thêm bài giảng', "Lỗi Kết Nối!!!");
    //             }

    //             //   alert(data);
    //         }
    //     });
    //     return false;
    // });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postChinhSuaBaiDay")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật bài giảng", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getBaiGiang')}}?id={{$khoaHoc->course_id}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật bài giảng", "Bạn không có quyền cập nhật!!!");
                } 
                else {
                    PhatHienLoi('Thêm bài giảng', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection