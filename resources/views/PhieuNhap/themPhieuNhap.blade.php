@extends('master.masterAdmin')
@section('title')
phiếu nhập
@endsection
@section('contain')
<div class="content-body">
    <style>
        .myInput{
            width: 70%;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
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
                        <h4 class="card-title">Thêm phiếu nhập</h4>
                      
                    <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <label>Nội dung <span style="color: red">*</span></label>
                                <input maxlength="30" required class="form-control" name="noiDung">
                            </div>
                          
                            <div class="col-lg-6 col-sm-6">
                              
                                    <label>Chi nhánh <span style="color: red">*</span></label>
                                    <select class="form-control" name="chiNhanh" id="chiNhanh" onchange="thayDoiChiNhanh();">
                                        @foreach($chiNhanh as $item)    
                                        <option value="{{$item->branch_id}}">{{$item->branch_name}}</option>
                                        @endforeach
                                    </select>
                                   
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <br>
                                <input onclick="myFunction();" checked type="checkbox" name="loai" id="loai"> Nội bộ
                                <br><br>
                            </div>
                        </div>
                            <div id="ngoaiBo" style="display: none">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Người nhận<span style="color: red">*</span></label>
                                        <input maxlength="30"  class="form-control" name="nguoiNhan">
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Phòng ban <span style="color: red">*</span></label>
                                        <input maxlength="30"  class="form-control" name="boPhan">
                                    </div>
                                </div>
                            </div>
                            <div id="noiBo">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Người nhận<span style="color: red">*</span></label>
                                       <select class="js-example-responsive"  style="width:100%" name="nguoiNhan2" >
                                        @foreach($nhanVien as $item)
                                        <option value="{{ $item->employee_name }}">{{ $item->employee_name }}</option>
                                        @endforeach
                                       </select>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Phòng ban <span style="color: red">*</span></label>
                                        <select class="js-example-responsive"  style="width:100%" name="boPhan2" >
                                            @foreach($phongBan as $item)
                                            <option value="{{ $item->department_name }}">{{ $item->department_name }}</option>
                                            @endforeach
                                           </select>
                                    </div>
                                </div>

                            </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-6">
                                <label>Ghi chú</label>
                                <textarea maxlength="30"  class="form-control" name="ghiChu"></textarea>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <label>Vật phẩm</label>
                               

                                        <select class="js-example-responsive" style="width:100%" id="sanPham" name="sanPham">
                                            @foreach($sanPham as $item)
                                            <option value="{{$item->facility_id}}">{{$item->facility_name}}</option>
                                            @endforeach
                                        </select>
                                <div id="duLieuSanPham">
                                        @foreach($sanPham as $item)

                                        <input hidden id="tenSanPham{{$item->facility_id}}" value="{{$item->facility_name}}">
                                        <input hidden id="giaSanPham{{$item->facility_id}}" value="{{$item->facility_purchasePrice}}">
                                        @endforeach
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <label>Số Lượng</label>
                                <input class="form-control" id="soLuong" name="soLuong">

                            </div>
                            <div class="col-lg-4" style="padding: 30px;">
                                        
                                <button type="button" class="btn mb-1 btn-outline-success" onclick="btnThem();">Thêm</button>
                            </div>
                        </div>
                        <div id="duLieuTable">
                            <table class="table  table-bordered " id="danhSachSanPham">
                                <thead>
                                    <tr>
                                        <th>Sản Phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody id="duLieuNhap">
                                </tbody>
                            </table>
                        </div>
                            
                            <br>
                            <div style="text-align: center">
                                <button type="submit" class="btn mb-1 btn-outline-success" >Thêm mới</button>
                            
                            </div>
                       
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script src="js/select2.js"></script>
<script>

function myFunction() {
  var checkBox = document.getElementById("loai");

  if (checkBox.checked == true){

    document.getElementById('ngoaiBo').style="display: none";
    document.getElementById('noiBo').style="display: block";
  } else {
    document.getElementById('ngoaiBo').style="display: block";
    document.getElementById('noiBo').style="display: none";
  }
}


 $(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
    });

    function thayDoiChiNhanh()
    {
        $id = $('#chiNhanh').val();
   
        document.getElementById('duLieuTable').innerHTML='<table class="table  table-bordered " id="danhSachSanPham">'+
                                    '<thead>'+
                                        '<tr>'+
                                            '<th>Sản Phẩm</th>'+
                                            '<th>Đơn giá</th>'+
                                            '<th>Số lượng</th>'+
                                            '<th>Thành tiền</th>'+
                                            '<th>Xóa</th>'+
                                        '</tr>'+
                                    '</thead>'+
                                    '<tbody id="duLieuNhap">'+
                                    '</tbody>'+
                                '</table>';
  
        $.ajax({
            type: 'get',
            url: '{{ route("getChangChiNhanhPhieuNhap")}}',
            data:{
                'id':$id
            },
            success: function(data) {
               document.getElementById('sanPham').innerHTML=data[0]['duLieu'];
               document.getElementById('duLieuSanPham').innerHTML=data[0]['soLuong'];

               
                 //  alert(data);
            }
        });

        

    }
function btnThem()
    {
        $soLuong = $('#soLuong').val();
        $id = $('#sanPham').val();
        themSanPham($id,$soLuong)
    }
    function format2(n) {
  return  n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
}
     function themSanPham(id,soLuong1) {
            var sanPham = id;
            var soLuong = soLuong1;
            var dongia=0;
            var ten=0;
            var soLuongSanPham = $('#soLuongSanPham').val();
            
            if(soLuong>0)
                {
                    @foreach($sanPham as $item)
                          ten=$('#tenSanPham{{$item->facility_id}}').val();
                          dongia=$('#giaSanPham{{$item->facility_id}}').val();
                        if ($('#soLuong{{$item->facility_id}}').val()>=0 && sanPham == {{$item->facility_id }})
                        {
                            $soLuongThem =parseInt($('#soLuong{{$item->facility_id}}').val())+ parseInt(soLuong);
                         
                            $('#soLuong{{$item->facility_id}}').val($soLuongThem);
                            $('#thanhTien{{$item->facility_id}}').text(format2($soLuongThem*dongia)+"đ");
                        }
        
                        else
                        {
                            if (sanPham == {{$item->facility_id}}) {
                               
                                    var table = document.getElementById("danhSachSanPham");
                                    var row = table.insertRow();
                                    row.id = "row{{$item->facility_id}}";
                                    var cell1 = row.insertCell();
                                    var cell2 = row.insertCell();
                                    var cell3 = row.insertCell();
                                    var cell4 = row.insertCell();
                                    var cell5 = row.insertCell();
                                    cell1.innerHTML = ten;
                                    cell2.innerHTML = dongia;
                                    cell3.innerHTML = "<input class='myInput'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='change({{$item->facility_id}},{{$item->facility_purchasePrice}});' style='width: 50%; text-align: right; '  id='soLuong" + sanPham + "' name='soLuong" + sanPham + "' value='" + soLuong + "'>" +
                                        "<button class='btn mb-1 btn-outline-primary'  type='button' onclick='themSanPham({{$item->facility_id}},1);' ><i class='fa fa-plus'></i></button>" +
                                        "<button class='btn mb-1 btn-outline-danger' type='button' onclick='truSanPham({{$item->facility_id}},1);'><i class='fa fa-minus'></i></button>";
                                    cell4.innerHTML = format2(dongia * soLuong)+"đ  ";
                                    cell5.innerHTML = "<a onclick='XoaTR({{$item->facility_id}});'><i class='fa fa-trash'></i></a>";
                                    cell1.id = "sanPham" + sanPham;
                                    cell2.id = "donGia" + sanPham;
                                    cell3.id = "soLuong1" + sanPham;
                                    cell4.id = "thanhTien" + sanPham;
                                    cell5.id = "xoa" + sanPham;
                              
                            }

                        }
                        @endforeach
                
               }
        }
        function change(id,donGia)
        {
           
            $soLuong =$('#soLuong'+id).val();
            if($soLuong==0)
            {
                $('#soLuong'+id).val(1);
                $soLuong=1;
                $('#thanhTien'+id).text(format2($soLuong*donGia)+"đ");
            }
            else
            {
                $('#thanhTien'+id).text(format2($soLuong*donGia)+"đ");
            }
                   
        }

        function truSanPham(id,soLuong1) {
            var sanPham = id;
            var soLuong = soLuong1;
            var dongia=0;
            var ten=0;
            var soLuongSanPham = $('#soLuongSanPham').val();
            if(soLuong>0)
            {
                @foreach($sanPham as $item)
                ten=$('#tenSanPham{{$item->facility_id}}').val();
                          dongia=$('#giaSanPham{{$item->facility_id}}').val();
                if ( sanPham == {{$item->facility_id }})
                {
                    $soLuongThem =parseInt($('#soLuong{{$item->facility_id}}').val())- parseInt(soLuong);
                    if($soLuongThem>0)
                    {
                        $('#soLuong{{$item->facility_id}}').val($soLuongThem);
                         $('#thanhTien{{$item->facility_id}}').text(format2($soLuongThem*dongia)+"đ");
                    }
                }
                @endforeach
                  
            }
        }
        function XoaTR(id) {
            var row = document.getElementById("row"+id);
            row.parentNode.removeChild(row);
          
        }
   
      $('#myform1').submit(function() {
        $.ajax({
            type: 'Post',
            url: '{{ route("postThemPhieuNhapKho")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm phiếu nhập", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getPhieuNhap')}}";
                    }, 2000);

                } else if (data== 2) {
                    KiemTra("Thêm phiếu nhập", "Bạn không có quyền thêm!!!");
                }
                else if (data== 3) {
                    KiemTra("Thêm phiếu nhập", "Bạn không có quyền thêm tất cả chi nhánh!!!");
                }
                else {
                    PhatHienLoi('Thêm phiếu nhập', "Lỗi Kết Nối!!!");
                }

                 //  alert(data);
            }
        });
        return false;
    });
</script>
@endsection