@extends('master.masterAdmin')
@section('title')
Lớp học
@endsection
@section('contain')
<div class="content-body">
    <div class="modal fade" id="basicModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myform1" autocomplete="off" action="" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật lịch</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Tên Giáo Viên  <span style="color: red">*</span></p>
                        <select class="form-control" required id="giaoVien2" name="giaoVien2">
                            @foreach($giaoVien as $item)
                                <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                            @endforeach
                        </select>
                        <label>Ngày Bắt Đầu  <span style="color: red">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" name="ngayBatDau" id="ngayBatDau" required
                            placeholder="mm/dd/yyyy" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask> <span class="input-group-append">
                            <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                        </div>
                        <label>Ngày Kết Thúc  <span style="color: red">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker"  name="ngayKetThuc" id="ngayKetThuc" required
                            placeholder="mm/dd/yyyy" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask> <span class="input-group-append">
                            <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="color: white" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" style="color: white" class="btn btn-success">Cập nhật </button>
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
                        <h5 class="modal-title">Cập nhật lịch</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Tên Giáo Viên</p>
                        <select class="form-control" id="giaoVien" name="giaoVien">
                            @foreach($giaoVien as $item)
                                <option value="{{$item->employee_id}}">{{$item->employee_name}}</option>
                            @endforeach
                        </select>
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
                       
                        <div class="row">
                            <div class="col-lg-5">
                                <h4 class="card-title">Xếp lịch</h4>
                            </div>
                            <div class="col-lg-3">
                            </div>
                            <div class="col-lg-2" style="text-align: center; display: flex;">
                                <button data-toggle="modal" data-target="#basicModal"  class="btn btn-outline-success">Thay Đổi Dài Hạn</button>
                                
                            </div>
                            <div class="col-lg-2" style="text-align: center; display: flex;">
                                <button onclick="thayDoiNganHan();"  class="btn btn-outline-primary" >Thay Đổi Ngắn Hạn</button>
                            </div>
                        </div>
                        <br>
                        <table class="table table-striped table-bordered " >
                            <thead>
                                <tr >
                                    <th style="width:5px">STT</th>
                                    <th>Lớp</th>
                                    <th>Ngày</th>
                                    <th>Thời gian</th>
                                    <th>Chi nhánh</th>
                                    <th>Phòng</th>
                                    <th style="text-align: center">Chọn<br><input type="checkbox" id="chonAll" name="chonAll"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=1; @endphp
                               @foreach($lich as $item)
                                    <tr>
                                        <td> @php echo $i; @endphp</td>
                                        <td>{{$item->class_name}}</td>
                                        <td>{{date('d/m/Y', strtotime($item->classTime_startDate))}}</td>
                                        <td>{{date('H:i', strtotime($item->classTime_startDate))}}<br>
                                            {{date('H:i', strtotime($item->classTime_endDate))}}</td>
                                        <td>{{$item->branch_name}}</td>
                                        <td>{{$item->room_name}}</td>
                                        <td style="text-align: center"><input type="checkbox" id="lich{{$item->classTime_id}}" name="lich{{$item->classTime_id}}"></td>
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
     @foreach($lich as $item)
        document.getElementById('lich{{$item->classTime_id}}').onclick = function(e){
            changeSelect();
        };
        @endforeach
        document.getElementById('chonAll').onclick = function(e){
            if($('#chonAll').prop("checked") == true){
                @foreach($lich as $item)
                $('#lich{{$item->classTime_id}}').prop('checked', true);

                @endforeach
            }
            else
            {
                @foreach($lich as $item)
                $('#lich{{$item->classTime_id}}').prop('checked', false);

                @endforeach
            }

        };

        function changeSelect() {
            $lichChon=0;
            @foreach($lich as $item)
            if($('#lich{{$item->classTime_id}}').prop("checked") == true){
                $lichChon++;
            }
            @endforeach

            if ($lichChon=={{count($lich)}})
            {
                $('#chonAll').prop('checked', true);
            }
            else
            {
                $('#chonAll').prop('checked', false);
            }
        }

        $('#myform1').submit(function() {
            $nhanVien =$('#giaoVien2').val();
            $ngayBatDau= $('#ngayBatDau').val();
            $ngayKetThuc=$('#ngayKetThuc').val();
            $nhanVien1={{$nhanVien->employee_id}};
            $.ajax({
                type: 'get',
                url: '{{ route('getCapNhatDaiHanXepLichGiaoVien')}}',
                data: {
                    'nhanVien1':$nhanVien1,
                    'nhanVien': $nhanVien,
                    'ngayBatDau':$ngayBatDau,
                    'ngayKetThuc':$ngayKetThuc
                },
                success: function (data) {
                    if (data == 1) {
                      CapNhatThanhCong("Cập nhật lịch","Cập nhật thành công!!!");
                        window.location="{{route('getXepLichGiaoVien')}}?id={{$nhanVien->employee_id}}";

                    } else if (data == 0) {
                        PhatHienLoi("Cập nhật lịch","Hệ thống gặp sự cố. Vui lòng thử lại sau!!!")
                    }
                    else
                    KiemTra("Cập nhật lịch",data)
                }
            });
        return false;
    });
    function thayDoiNganHan() {
            $lichChon=0;
            @foreach($lich as $item)
            if($('#lich{{$item->classTime_id}}').prop("checked") == true){
                $lichChon++;
            }
            @endforeach
            if ($lichChon>0)
            {
                $('#basicModal2').modal('show');
            }
            else
                KiemTra("Cập nhật lịch",'Bạn Chưa Chọn Lịch Để Thay Đổi!!!');
        } 
        $('#myform2').submit(function() {
            $arrLich = [];
            @foreach($lich as $item)
            if($('#lich{{$item->classTime_id}}').prop("checked") == true){
                $arrLich.push({{$item->classTime_id}});
            }
            @endforeach
                $nhanVien =$('#giaoVien').val();
                $nhanVien1={{$nhanVien->employee_id}};
            $.ajax({
                type: 'get',
                url: '{{ route('getCapNhatXepLichGiaoVien')}}',
                data: {
                    'nhanVien': $nhanVien,
                    'lich':$arrLich,
                    'nhanVien1':$nhanVien1
                },
                success: function (data) {
                    if (data == 1) {
                      CapNhatThanhCong("Cập nhật lịch","Cập nhật thành công!!!");
                        window.location="{{route('getXepLichGiaoVien')}}?id={{$nhanVien->employee_id}}";

                    } else if (data == 0) {
                        PhatHienLoi("Cập nhật lịch","Hệ thống gặp sự cố. Vui lòng thử lại sau!!!")
                    }
                    else
                    KiemTra("Cập nhật lịch",data)
                   
                }
            });
        return false;
    });
      
</script>
@endsection