@extends('master.masterAdmin')
@section('title')
Bài Giảng
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
                        <h5 class="modal-title">Thêm loại kết quả học tập</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id" name="id" hidden value="{{$khoaHoc->course_id}}">
                        <label>Loại kết quả  <span style="color: red">*</span></label>
                        <input class="form-control" id="loai" name="loai" required>
                        <label>Phần trăm  <span style="color: red">*</span></label>
                        <input id="phanTram" name="phanTram" required type="number" class="form-control">
                       
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
                        <h5 class="modal-title">Cập nhật loại kết quả học tập</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="id2" name="id2" hidden>
                        <label>Loại kết quả <span style="color: red">*</span></label>
                        <input class="form-control" required id="loai2" name="loai2">
                        <label>Phần trăm <span style="color: red">*</span></label>
                        <input id="phanTram2" name="phanTram2" required type="number" class="form-control">
                       
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
                        <h4 class="card-title">kết quả học tập: {{$khoaHoc->course_name}}</h4>
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
                          
                            </div>
                        </div>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:10px">STT</th>
                                    <th>Loại kết quả</th>
                                    <th>Phần trăm</th>
                                    <th>Kết quả</th>
                                    <th>Chi tiết</th>
                                    <th>Nhận xét</th>
                                    
                                    <th>Xuất kết quả</th>
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($ketQuaHocTap as $item)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{$item->learningOutcomeType_name}}</td>
                                    <td>{{$item->learningOutcomeType_percent}}</td>       
                                    <td>{{ $arrKetQua[$i-1]['phanTram'] }}</td>                       
                                    <td><a class="btn" 
                                        href="{{route('getKetQuaHocTapHocVien')}}?id={{$id}}&type={{$item->learningOutcomeType_id}}">
                                        <i class="fa fa-list"></i></a>
                                    </td>
                                    <td><a href="{{ route('getNhanXetHocVien') }}?id={{$id}}&type={{$item->learningOutcomeType_id}}"><i class="fa fa-edit"></i></a></td>
                                    <td><a class="btn" onclick="xuatKetQua('{{$id}}','{{$item->learningOutcomeType_id}}')"><i class="fa fa-print"></i></a></td>
                                    
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
     function xuatKetQua(id,type)
    {
    
        $.ajax({
            type: 'get',
            url: '{{route("xuatKetQuaHocVien")}}',
            data: 
            {
                'id':id,
                'type':type
            },
            success: function(data) {

               
                xuatLichChiTietGiaoVien(data[0]['tenLoai'],
                data[0]['CTH'],
                data[0]['duLieuNhanXet'],
                data[0]['tenHV']
                ,
                data[0]['lop']
                ,
                data[0]['thoiGian']
                ,
                data[0]['diemSo'] ,
                data[0]['diem'] ,
                data[0]['tongDiem']
                );

            }
        });
    }

    function xuatLichChiTietGiaoVien(tenLoai,CTH,data,tenHV,lop,thoiGian,diemSo,diem,tongDiem)
    {
        var code = $("#code1").val();
            var ngayLay=$("#ngayLay").val();
            let current_datetime = new Date(ngayLay);
            let formatted_date = current_datetime.getDate() + "/"
                + (current_datetime.getMonth() + 1) + "/"
                + current_datetime.getFullYear();
            var display_setting="toolbar=yes,menubar=yes,";
            display_setting+="scrollbars=yes,width=1000, height=1000, left=100, top=0";
            var printpage=window.open("","",display_setting);      
            printpage.document.open();
            printpage.document.write('<!DOCTYPE html><html><head><title></title></head>');
            printpage.document.write('<body onLoad="self.print()">'+
                '<style>\n' +
                '  table, th, td {\n' +
                '    border: 1px solid black;\n' +
                '    border-collapse: collapse;\n' +
                '  }\n' +
                '</style>'+
                '<div style="text-align:center">'+
                    CTH + ' - ' + tenLoai + ' REPORT'+  
                '</div>'+
                '<div>'+
                'Student name/Tên học sinh: '+ tenHV+
                '<br>Class level/Trình độ: '+ lop+
                '<br>Duration/Thời gian:: '+ thoiGian+"<br><br>"+
                diemSo+		

                '</div>'+
                    data
                +'</body>'
                +'</html>');
            printpage.document.close();
            printpage.focus();
    }


function search() {
    
    $value = $('#valueSearch').val();
    $idKhoaHoc = {{ $khoaHoc->course_id}};
    $.ajax({
        type: 'get',
        url: '{{route("searchLoaiKetQuaHocTapHocVien")}}',
        data: {
            'value': $value,
            'idKhoaHoc':$idKhoaHoc
        },
        success: function(data) {
            document.getElementById('duLieuSearch').innerHTML = data;

        }
    });
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
                            url: '{{route("getXoaLoaiKetQuaHocTap")}}',
                            data: {
                                'id': id
                            },
                            success: function(data) {
                                if (data == 1) {
                                    swal("Deleted !!", "Xóa thành công!!", "success")
                                    window.location = "{{route('getLoaiKetQuaHocTap')}}?id={{$khoaHoc->course_id}}";
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

    function setValue(id, ten,phanTram) {
        $('#id2').val(id);
        $('#phanTram2').val(phanTram);
        $('#loai2').val(ten);
      
    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postThemLoaiKetQuaHocTap")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm loại kết quả học tập", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getLoaiKetQuaHocTap')}}?id={{$khoaHoc->course_id}}";
                    }, 2000);
                } else if (data == 2) {
                    KiemTra("Thêm loại kết quả học tập", "Bạn không có quyền thêm!!!");
                }               
                else {
                    PhatHienLoi('Thêm loại kết quả học tập', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
    $('#myform2').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{route("postCapNhatLoaiKetQuaHocTap")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    CapNhatThanhCong("Cập nhật loại kết quả học tập", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getLoaiKetQuaHocTap')}}?id={{$khoaHoc->course_id}}";
                    }, 2000);

                } else if (data == 2) {
                    KiemTra("Cập nhật loại kết quả học tập", "Bạn không có quyền cập nhật!!!");
                } 
                else {
                    PhatHienLoi('Thêm loại kết quả học tập', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection