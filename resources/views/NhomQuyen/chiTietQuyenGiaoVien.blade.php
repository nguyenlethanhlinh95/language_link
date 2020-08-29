@extends('master.masterAdmin')
@section('title')
nhóm quyền
@endsection
@section('contain')
<div class="content-body">

  
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title">Giáo viên: {{$nhomQuyen->employee_name}}</h4>
                        <br>
                        <h5>Quyền cơ bản</h5>
                        <br>
                        <table class="table  table-bordered " style="text-align: center">
                            <thead>
                                <tr>
                                    <th style="width:200px">Tên quyền</th>
                                    @foreach($chiTietQuyen as $item)
                                    <th>{{$item->chiTietQuyen_ten}}</th>
                                    
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($nhomQuyenCoBan as $item)
                                <tr>
                                    <td>{{$item->quyen_ten}}</td>
                                    @foreach($chiTietQuyen as $item1)
                                        @php $trangThai =0; @endphp
                                            @foreach($quyenCoBan as $item2)
                                                @if($item2->quyen_id==$item->quyen_id 
                                                && $item2->chiTietQuyen_id == $item1->chiTietQuyen_id)
                                                     @php $trangThai =$item2->quyen_chiTietQuyen_trangThai; @endphp
                                                @endif
                                            @endforeach

                                         @if ($trangThai == 1)
                                            <td>
                                            <input checked type="checkbox" id="check{{$item->quyen_id}}{{$item1->chiTietQuyen_id}}"
                                            onclick="capNhatTrangThai('{{$item->quyen_id}}','{{$item1->chiTietQuyen_id}}');">
                                            </td>
                                            @else
                                            <td>
                                                <input type="checkbox" id="check{{$item->quyen_id}}{{$item1->chiTietQuyen_id}}"
                                                onclick="capNhatTrangThai('{{$item->quyen_id}}','{{$item1->chiTietQuyen_id}}');">
                                                </td>
                                         @endif   
                                       
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <h5>Quyền Nâng cao</h5>
                        <br>
                        <table class="table  table-bordered " style="text-align: center">
                            <thead>
                                <tr>
                                    <th style="width:500px">Tên quyền</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody id="duLieuSearch">
                                @php $i=1; @endphp
                                @foreach($nhomQuyenNangCao as $item)
                                <tr>
                                    <td>{{$item->quyen_ten}}</td>
                                        @php $trangThai =0; @endphp
                                            @foreach($quyenNangCao as $item2)
                                                @if($item2->quyen_id==$item->quyen_id 
                                                )
                                                     @php $trangThai =$item2->quyen_chiTietQuyen_trangThai; @endphp
                                                @endif
                                            @endforeach

                                         @if ($trangThai == 1)
                                            <td>
                                            <input checked type="checkbox" id="check{{$item->quyen_id}}1"
                                            onclick="capNhatTrangThai('{{$item->quyen_id}}','1');">
                                            </td>
                                            @else
                                            <td>
                                                <input type="checkbox" id="check{{$item->quyen_id}}1"
                                                onclick="capNhatTrangThai('{{$item->quyen_id}}','1');">
                                                </td>
                                         @endif   
                                </tr>
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
    function capNhatTrangThai(idQuyen,idChiTiet)
    {
        var checkBox = document.getElementById('check'+idQuyen+idChiTiet);

        var isChecked = checkBox.checked;
        if(isChecked==true)
            $trangThai = 1;
        else
            $trangThai = 0;

        $idNhomQuyen = {{$nhomQuyen->employee_id}};
            $.ajax({
            type: 'get',
            url: '{{ route("capNhatTrangThaiNhomQuyenGiaoVien")}}',
            data: {
                'idQuyen': idQuyen,
                'idChiTiet': idChiTiet,
                'trangThai':$trangThai,
                'idNhomQuyen':$idNhomQuyen
            },
            success: function(data) {
               if(data==1)
               {
                   ThemThanhCong('Cập nhật quyền', "Cập nhật thành công!!!");
               }
               else
               {
                    PhatHienLoi('Cập nhật quyền', "Phát hiện lỗi hệ thống!!!");
               }
            }
        }); 
    }
   
    // }
    


   
</script>
@endsection