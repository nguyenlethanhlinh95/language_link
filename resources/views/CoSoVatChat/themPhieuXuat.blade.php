@extends('master.masterAdmin')
@section('title')
phiếu xuất
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
                        <h4 class="card-title">Thêm phiếu xuất</h4>
                      
                    <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <label>Nội dung <span style="color: red">*</span></label>
                                <input maxlength="200" required class="form-control" name="noiDung">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                
                                <label>Chi nhánh <span style="color: red">*</span></label>
                               <select required class="form-control" name="chiNhanh" id="chiNhanh" onchange="thayDoiChiNhanh();">
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
                                
                                <select  class="js-example-responsive" style="width:100%"  id="sanPham" name="sanPham">
                                    @foreach($sanPham as $item)
                                    @if($item->inventory_amount>0)
                                    <option value="{{$item->facility_id}}">{{$item->facility_name}} ({{$item->inventory_amount}})</option>
                                    @endif
                                    @endforeach
                                </select>
                                <div id="duLieuSanPham">
                                    @foreach($sanPham as $item)   
                                    <input hidden id="tonKho{{$item->facility_id}}" value="{{$item->inventory_amount}}">
                                    <input hidden id="tenSanPham{{$item->facility_id}}" value="{{$item->facility_name}}"> 
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
                                    <th>Số lượng</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
                            <br>
                            <div class="col-lg-12 " style="text-align: center">
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
                                           
                                            '<th>Số lượng</th>'+
                                          
                                            '<th>Xóa</th>'+
                                        '</tr>'+
                                    '</thead>'+
                                    '<tbody id="duLieuNhap">'+
                                    '</tbody>'+
                                '</table>';
  
        $.ajax({
            type: 'get',
            url: '{{ route("getChangeChiNhanhPhieuXuat")}}',
            data:{
                'id':$id
            },
            success: function(data) {
               document.getElementById('duLieuSanPham').innerHTML=data[0]['tonKho'];
               document.getElementById('sanPham').innerHTML=data[0]['sanPham'];
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

     function themSanPham(id,soLuong1) {
            var sanPham = id;
            var soLuong = soLuong1;
            var dongia=0;
            var ten=0;
            var soLuongSanPham = $('#soLuongSanPham').val();
            
            if(soLuong>0)
                {
                    @foreach($sanPham as $item)
                          ten="{{$item->facility_name}}";
                        if ($('#soLuong{{$item->facility_id}}').val()>=0 && sanPham == {{$item->facility_id }})
                        {
                            $soLuongThem =parseInt($('#soLuong{{$item->facility_id}}').val())+ parseInt(soLuong);
                           if ($soLuongThem <= $('#tonKho{{$item->facility_id}}').val())
                           {
                               $('#soLuong{{$item->facility_id}}').val($soLuongThem);
                           }
                           else
                                KiemTra("Quà Tặng","Số lượng không đủ");
                            }
        
                        else
                        {
                            if (sanPham == {{$item->facility_id}}) {
                                if (parseInt(soLuong)  <=parseInt( $('#tonKho{{$item->facility_id}}').val())) {
                                    var table = document.getElementById("danhSachSanPham");
                                    var row = table.insertRow();
                                    row.id = "row{{$item->facility_id}}";
                                    var cell1 = row.insertCell();
                                    var cell3 = row.insertCell();
                                    var cell5 = row.insertCell();
                                    cell1.innerHTML = ten;
                                    cell3.innerHTML = "<input class='myInput'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='change({{$item->facility_id}});' style='width: 50%; text-align: right; '  id='soLuong" + sanPham + "' name='soLuong" + sanPham + "' value='" + soLuong + "'>" +
                                        "<button class='btn mb-1 btn-outline-primary'  type='button' onclick='themSanPham({{$item->facility_id}},1);' ><i class='fa fa-plus'></i></button>" +
                                        "<button class='btn mb-1 btn-outline-danger' type='button' onclick='truSanPham({{$item->facility_id}},1);'><i class='fa fa-minus'></i></button>";
                                  
                                    cell5.innerHTML = "<a onclick='XoaTR({{$item->facility_id}});'><i class='fa fa-trash'></i></a>";
                                    cell1.id = "sanPham" + sanPham;
                                    cell3.id = "soLuong1" + sanPham;
                                    cell5.id = "xoa" + sanPham;
                                } else
                                   KiemTra("Quà Tặng","Số lượng không đủ");
                            }

                        }
                        @endforeach
                
               }
        }
        function change(id)
        {
                    $soLuong =$('#soLuong'+id).val();
                    if($soLuong==0)
                    {
                        $('#soLuong'+id).val(1);
                        $soLuong=1;
                    }
                   
                    if ( parseInt($soLuong) <= parseInt($('#tonKho'+id).val()))
                    {
                       
                    }
                    else
                    {

                        KiemTra("Quà Tặng","Số lượng không đủ");
                        $('#soLuong'+id).val($('#tonKho'+id).val());
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
                  
                ten="{{$item->facility_name}}";
                if ( sanPham == {{$item->facility_id }})
                {
                    $soLuongThem =parseInt($('#soLuong{{$item->facility_id}}').val())- parseInt(soLuong);
                    if($soLuongThem>0)
                    {
                        $('#soLuong{{$item->facility_id}}').val($soLuongThem);
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
            url: '{{ route("postThemPhieuXuatKho")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Thêm phiếu xuất", "Thêm thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getXuatKho')}}";
                    }, 2000);

                } else if (data== 2) {
                    KiemTra("Thêm phiếu xuất", "Bạn không có quyền thêm!!!");
                }
                else if (data== 3) {
                    KiemTra("Thêm phiếu xuất", "Số lượng tồn kho không đủ!!!");
                }
                else {
                    PhatHienLoi('Thêm phiếu xuất', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection