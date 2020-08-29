@extends('master.masterAdmin')
@section('title')
HỌC VIÊ<Nav></Nav>
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
                        <h4 class="card-title">Ghi danh học viên</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <div class="input-group icons">
                                    <input id="valueSearch" type="search" class="form-control" placeholder="Search tên học viên" aria-label="Tìm marketing">
                                    <div class="input-group-prepend" style="padding: 5px">
                                        <button onclick="search();" type="button" class="btn mb-1 btn-outline-info">Tìm kiếm</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <br>
                        <div id="duLieuSearch">

                        </div>
                        <div id="duLieu" style="display: none">
                            <table class="table  table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th style="width:10px">STT</th>
                                        <th>Tên học viên</th>
                                        <th>Ngày sinh HV</th>
                                        <th>Tên PH</th>
                                        <th>Số đt PH</th>
                                        <th>Số đt HV</th>
                                        <th>Địa chỉ</th>
                                        @if(session('quyen32')==1)
                                        <th>Phỏng vấn</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="duLieuGhiDanh">

                                </tbody>
                            </table>
                        </div>
                        <div class="card-body">

                            <div id="accordion-three" class="accordion">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThree6" aria-expanded="false" aria-controls="collapseThree6">
                                            <i class="fa" aria-hidden="true"></i>
                                            Ghi danh học viên mới</h5>
                                    </div>
                                    <div id="collapseThree6" class="collapse" data-parent="#accordion-three">
                                        <div class="card-body">
                                            <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <label>Họ học viên <span style="color: red">*</span></label>
                                                        <input maxlength="30" required class="form-control" name="firtName" id="firtName">
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <label>Tên học viên <span style="color: red">*</span></label>
                                                        <input maxlength="30" required class="form-control" name="lastName" id="lastName">
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <label>Nickname </label>
                                                        <input maxlength="30"  class="form-control" name="nickname" id="nickname">
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <label>Tên phụ huynh </label>
                                                        <input maxlength="50" class="form-control" name="parentName" id="parentName">
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <label>Số điện thoại phụ huynh </label>
                                                        <input maxlength="30" class="form-control" name="parentPhone" id="parentPhone">
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <label>Email </label>
                                                        <input maxlength="50" type="email"  class="form-control" name="mail" id="mail">
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <label>Số điện thoại học viên </label>
                                                        <input maxlength="30" class="form-control" name="phone" id="phone">
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <label>Ngày sinh <span style="color: red">*</span></label>
                                                        <div class="input-group">
                                                            <input name="birthday" type="text" class="form-control mydatepicker" id="birthday" placeholder="mm/dd/yyyy">
                                                            <span class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <label>Trạng thái </label>
                                                       <select class="form-control" name="trangThai" required>
                                                           <option value="1">Hoạt động</option>
                                                           <option value="0">Đã nghỉ</option>
                                                        <select>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <label>Link ảnh (600 x 600 px)</label>
                                                        <input maxlength="200" name="link" type="text"  class="form-control" >
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <label>Hình ảnh (600 x 600 px)</label>
                                                        <input maxlength="50" name="images" type="file" class="form-control" id="images">
                                                    </div>
                                                    <div class="col-lg-12 ">
                                                        <label>Địa Chỉ <span style="color: red">*</span></label>
                                                        <input maxlength="100" required class="form-control" name="address" id="address">
                                                    </div>

                                                    <div class="col-lg-12 " style="padding: 10px">
                                                        <label>Bạn Biết LanguageLink qua(You now LL through) </label>
                                                    </div>


                                                    @foreach($marketing as $item)
                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="form-check mb-3">
                                                            <label class="form-check-label">
                                                                <input name="marketing{{$item->marketing_id}}" type="checkbox" class="form-check-input">{{$item->marketing_name}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach

                                                    <div class="col-lg-12 " style="text-align: center">
                                                        <button type="submit" class="btn mb-1 btn-outline-success">Thêm mới</button>

                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script>
    function lamMoi() {
        $('#firtName').val("");
        $('#lastName').val("");
        $('#parentName').val("");
        $('#parentPhone').val("");
        $('#mail').val("");
        $('#phone').val("");
        $('#birthday').val("");
        $('#images').val("");
        $('#address').val("");

        @foreach($marketing as $item)
        $("#marketing{{$item->marketing_id}}").prop("checked", false);
        @endforeach

    }
    $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{ route("postThemHocVien")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data[0]['loai'] == 1) {
                    ThemThanhCong("Thêm học viên", "Thêm thành công!!!");
                    lamMoi();
                    $.ajax({
                        type: 'get',
                        url: '{{ route("getThongTinGhiDanh")}}',
                        data: {
                            'id': data[0]['id']
                        },
                        success: function(data1) {
                            document.getElementById('duLieu').style="display: block";
                        document.getElementById('duLieuGhiDanh').innerHTML = data1;
                        document.getElementById('duLieuSearch').innerHTML =  "";
                        }
                    });

                } else if (data[0]['loai'] == 2) {
                    KiemTra("Thêm học viên", "Bạn không có quyền thêm!!!");
                } else if (data[0]['loai'] == 3) {
                    KiemTra("Thêm học viên", "Số đt HV và Số đt PH ít nhất có một!!!");
                } else {
                    PhatHienLoi('Thêm học viên', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
<script>
    function search() {

        $value = $('#valueSearch').val();
        $.ajax({
            type: 'get',
            url: '{{ route("searchHocVienGhiDanh")}}',
            data: {
                'value': $value
            },
            success: function(data) {
                if(data==1)
                {
                    document.getElementById('duLieuSearch').innerHTML =  "<div style='text-align:center;color:red;'><h3>Không Có Gì Để Tìm Kiếm</h3></div>";
                    document.getElementById('duLieu').style="display: none";
                }
                else if(data==2)
                {
                    document.getElementById('duLieuSearch').innerHTML =  "<div style='text-align:center;color:red;'><h3>Không Có Gì Để Tìm Kiếm</h3></div>";
                    document.getElementById('duLieu').style="display: none";
                }
                else
                {
                    document.getElementById('duLieu').style="display: block";
                    document.getElementById('duLieuGhiDanh').innerHTML = data;
                    document.getElementById('duLieuSearch').innerHTML =  "";
                }
            }
        });
    }
</script>

@endsection