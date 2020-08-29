@extends('master.masterAdmin')
@section('title')
team
@endsection
@section('contain')
<div class="content-body">

    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm nhân viên</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Nhân viên <span style="color: red">*</span></label>
                        <input hidden id="id" name="id" value="{{ $team->team_id }}">
                        <select required class="js-example-responsive" style="width: 100%" id="nhanVien" name="nhanVien"  >
                            @foreach($nhanVien as $item)
                            <option value="{{ $item->employee_id }}">{{ $item->employee_name }}</option>
                            @endforeach
                        </select>
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
                        <h4 class="card-title">Team {{ $team->team_name }}</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="input-group icons">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <input id="valueSearch" onkeyup="search();" type="search" class="form-control" 
                                    placeholder="Search tên team" aria-label="Tìm marketing">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                @if(session('quyen372')==1)
                                
                                    <button type="button" data-toggle="modal" data-target="#basicModal" class="btn mb-1 btn-outline-success" style="float: right">Thêm mới</button>
                               
                                @endif
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Nhân viên</th>
                                    @if(session('quyen374')==1)
                                    <th>Xóa</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($teamNhanVien as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->employee_name}}</td>
                                
                                    @if(session('quyen374')==1)
                                    <td>
                                        <a class="btn" onclick="xoa('{{$item->teamEmployee_id}}');">
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
<script src="js/select2.js"></script>
<script>
     $(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
    });
   
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
                            url: '{{route("getXoaTeamNhanVien")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getNhanVienTeam')}}?id={{ $team->team_id }}";
                                } else if (data == 2) {
                                    KiemTra("Xóa team", "Bạn không có quyền xóa!!!!");
                                } else
                                    PhatHienLoi("Xóa team", "Lỗi Kết kết nối!!!!");
                            }
                        })
                    ) :
                    swal("Cancelled !!", "Bạn đã hủy!!", "error")
            }
        )
    }

    function search() {

       
        $id = {{ $team->team_id }};
        $value = $('#valueSearch').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchTeamNhanVien")}}',
            data: {
                'value': $value,
                'page': 1,
                'id':$id
            },
            success: function(data) {
                document.getElementById('duLieuSearch').innerHTML = data;

            }
        });
    }

   

    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemTeamNhanVien")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm teamwork", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getNhanVienTeam')}}?id={{ $team->team_id }}";
                    }, 2000);
                } else if (data == 2) {
                    KiemTra("Thêm teamwork", "Bạn không có quyền thêm!!!");
                }    
                else if (data == 3) {
                    KiemTra("Thêm teamwork", "Nhân viên đã tồn tại!!!");
                }               
                else {
                    PhatHienLoi('Thêm teamwork', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
   


</script>
@endsection