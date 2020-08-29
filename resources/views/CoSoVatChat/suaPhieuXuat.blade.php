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
                        <h4 class="card-title">Cập nhật phiếu xuất</h4>
                      
                    <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                        <div class="row">
                            <input hidden id="id" name="id" value="{{$phieuXuat->deliveryBill_id}}">
                            
                            <div class="col-lg-6 col-sm-6">
                                <label>Nội dung <span style="color: red">*</span></label>
                                <input maxlength="200   " required class="form-control" name="noiDung" value="{{$phieuXuat->deliveryBill_name}}">
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label>Chi nhánh <span style="color: red">*</span></label>
                                <input readonly class="form-control" value="{{$phieuXuat->branch_name}}">
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <br>
                                @if($phieuXuat->deliveryBill_status==1)
                                <input onclick="myFunction();" checked type="checkbox" name="loai" id="loai"> Nội bộ
                                @else 
                                <input onclick="myFunction();"  type="checkbox" name="loai" id="loai"> Nội bộ
                               
                                @endif
                                <br><br>
                            </div>
                        </div>
                        @if($phieuXuat->deliveryBill_status==1)
                            <div id="ngoaiBo" style="display: none">
                        @else 
                        <div id="ngoaiBo" style="display: block">
                        @endif
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Người nhận<span style="color: red">*</span></label>
                                        <input maxlength="30" value="{{ $phieuXuat->deliveryBill_receiver }}"  class="form-control" name="nguoiNhan">
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Phòng ban <span style="color: red">*</span></label>
                                        <input maxlength="30" value="{{ $phieuXuat->deliveryBill_partName }}" class="form-control" name="boPhan">
                                    </div>
                                </div>
                            </div>
                            @if($phieuXuat->deliveryBill_status==1)
                            <div id="noiBo">
                                @else 
                                <div id="noiBo" style="display: none">
                                @endif
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Người nhận<span style="color: red">*</span></label>
                                       <select class="js-example-responsive"  style="width:100%" name="nguoiNhan2" >
                                        @foreach($nhanVien as $item)
                                        @if($phieuXuat->deliveryBill_receiver == $item->employee_name)
                                        <option selected value="{{ $item->employee_name }}">{{ $item->employee_name }}</option>
                                        @else 
                                        <option value="{{ $item->employee_name }}">{{ $item->employee_name }}</option>
                                        
                                        @endif
                                        @endforeach
                                       </select>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Phòng ban <span style="color: red">*</span></label>
                                        <select class="js-example-responsive"  style="width:100%" name="boPhan2" >
                                            @foreach($phongBan as $item)
                                            @if($phieuXuat->deliveryBill_partName == $item->department_name)
                                            <option selected value="{{ $item->department_name }}">{{ $item->department_name }}</option>
                                            @else
                                            <option value="{{ $item->department_name }}">{{ $item->department_name }}</option>
                                            
                                            @endif
                                            @endforeach
                                           </select>
                                    </div>
                                </div>

                            </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-6">
                                <label>Ghi chú</label>
                                <textarea maxlength="30"  class="form-control" name="ghiChu">{{$phieuXuat->deliveryBill_note}}</textarea>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <label>Vật phẩm</label>
                                <select class="js-example-responsive" style="width:100%" id="sanPham" name="sanPham">
                                    @foreach($sanPham as $item)
                                    @php $soLuong = $item->inventory_amount; @endphp
                                        @foreach($chiTiet as $item1)
                                            @if ($item->facility_id==$item1->facility_id)
                                                @php $soLuong += $item1->deliveryBillDetail_amount; @endphp
                                            @endif
                                        @endforeach
                                    @if($item->inventory_amount>0)
                                    <option value="{{$item->facility_id}}">{{$item->facility_name}} ({{ $soLuong }})</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <label>Số Lượng</label>
                                <input class="form-control" id="soLuong" name="soLuong">

                            </div>
                            <div class="col-lg-4" style="padding: 30px;">
                                        
                                <button type="button" class="btn mb-1 btn-outline-success" onclick="btnThem();">Thêm</button>
                            </div>
                            <table class="table  table-bordered " id="danhSachSanPham">
                                <thead>
                                    <tr>
                                        <th>Sản Phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chiTiet as $item)
                                    <tr id="row{{$item->facility_id}}">
                                    <td id="sanPham{{$item->facility_id}}">{{$item->facility_name}}</td>

                                    <td id="soLuong1{{$item->facility_id}}">
                                        <input class='myInput'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='change({{$item->facility_id}});' style='width: 50%; text-align: right; '  id='soLuong{{$item->facility_id}}' name='soLuong{{$item->facility_id}}' value='{{$item->deliveryBillDetail_amount}}'>
                                        <button class='btn mb-1 btn-outline-primary'  type='button' onclick='themSanPham({{$item->facility_id}},1);' ><i class='fa fa-plus'></i></button>
                                        <button class='btn mb-1 btn-outline-danger' type='button' onclick='truSanPham({{$item->facility_id}},1);'><i class='fa fa-minus'></i></button>
                                    </td>
                                    <td id="xoa{{$item->facility_id}}"><a onclick='XoaTR({{$item->facility_id}});'><i class='fa fa-trash'></i></a></td>
                                   
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="col-lg-12 " style="text-align: center">
                                <button type="submit" class="btn mb-1 btn-outline-success" >Cập nhật</button>
                            
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        @foreach($sanPham as $item)   
            @php $soLuong = $item->inventory_amount; @endphp
             @foreach($chiTiet as $item1)
                @if ($item->facility_id==$item1->facility_id)
                @php $soLuong += $item1->deliveryBillDetail_amount; @endphp
                @endif
             @endforeach
        <input hidden id="tonKho{{$item->facility_id}}" value="  @php echo $soLuong; @endphp">
        @endforeach
    


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
            url: '{{ route("postCapNhatPhieuXuatKho")}}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    ThemThanhCong("Cập nhật phiếu xuất", "Cập nhật thành công!!!");
                    setTimeout(function() {
                        window.location = "{{route('getXuatKho')}}";
                    }, 2000);

                } else if (data== 2) {
                    KiemTra("Cập nhật phiếu xuất", "Bạn không có quyền cập nhật!!!");
                }
                else if (data== 3) {
                    KiemTra("Cập nhật phiếu xuất", "Số lượng tồn kho không đủ!!!");
                }
                else {
                    PhatHienLoi('Cập nhật phiếu xuất', "Lỗi Kết Nối!!!");
                }

                //   alert(data);
            }
        });
        return false;
    });
</script>
@endsection