@extends(config('app.interface').'templates.lanhdao')
@section('main')
    <style>
        .table thead.head-table tr th {
            vertical-align: middle;
            text-align: center;
            font-weight:bold;
            border-bottom-width: 1px;
        }
        .nav-tabs {
            border-bottom: 1px solid #ddd;
        }

        .done{
            background: #0d9a0d;
            padding: 5px;
            white-space: nowrap;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .undeveloped{
            background: #bdb22b;
            padding: 5px;
            white-space: nowrap;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .inprogress{
            background: #2bb0bd;
            padding: 5px;
            white-space: nowrap;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .pause{
            background: #9e4848;
            padding: 5px;
            white-space: nowrap;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <?php
        $user = (object)session('user');
        $quy = select_Quy_Nam();
    ?>
    <div class="container container-list report-statistic">
        @include('flash::message')
        <div class="row">
            <div class="box-head">
                <h3>BẢNG THEO DÕI TIẾN ĐỘ CÔNG VIỆC</h3>
                <div>
                    <a class="btn btn-primary btn-filter-progress" style="margin-top: 7px;"><i style="position: unset; font-size: unset" class="fa fa-search" aria-hidden="true"></i></a>
                    <a class="btn btn-primary" style="margin-top: 7px;" href="javascript:;" onclick="xuatWord()"><i class="fa fa-file-word-o"></i> Tải về</a>
                    <a class="btn btn-success" style="margin-top: 7px;" href="javascript:;" onclick="xuatExcel()"><i class="fa fa-file-excel-o"></i> Tải về</a>
                    <button style="text-align:center; margin-top: 7px" onclick="showImportExcell()" type="button" class="btn btn-primary"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Import excel</button>
                    <a href="{{route('quanlytiendo.themmoi')}}" class="btn btn-primary" style="text-align:center; margin-top: 7px"><i class="fa fa-plus" aria-hidden="true"></i> Thêm mới</a>
                </div>
            </div>
            <form class="form-filter-bao-cao justify-content-end" action="" method="GET">
                <div class="d-flex justify-content-center">
                    <div class="mr-15">
                        <select name="tiendo" id="tiendo" class="form-control">
                            <option value="">-- Chọn tiến độ --</option>
                            <option value="0" {{$tiendo === '0' ? 'selected' : ''}}>Chưa triển khai</option>
                            <option value="1" {{$tiendo === '1' ? 'selected' : ''}}>Đang triển khai</option>
                            <option value="2" {{$tiendo === '2' ? 'selected' : ''}}>Hoàn thành</option>
                            <option value="3" {{$tiendo === '3' ? 'selected' : ''}}>Tạm hoãn</option>
                        </select>
                    </div>
                    @if($user->donvi_id == 136)
                        <div class="mr-15">
                            <span style="margin-right: 5px">Đơn vị</span>
                            <select name="donvi_id" id="donvi_id" class="chosen">
                                <option value="">-- Chọn đơn vị --</option>
                                @foreach($donvis as $donvi)
                                    <option {{ $donvi->id == $donvi_id ? 'selected' : '' }} value="{{ $donvi->id }}">{{ $donvi->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="mr-15" style="display: flex">
                        <select name="chon_loai" id="chon_loai" class="form-control">
                            <option value="thang" {{ $loai == 'thang' ? 'selected' : '' }}>Theo tháng</option>
                            <option value="quy" {{ $loai == 'quy' ? 'selected' : '' }}>Theo quý</option>
                        </select>
                    </div>
                    <div class="mr-15 chon_quy" style="display: {{$loai == 'quy' ? 'flex' : 'none'}}">
                        <span style="width: 100px; margin-top: 10px">Chọn quý</span>
                        <select name="quy" id="quy" class="form-control">
                            <option value="1" {{ $selected_quy == 1 ? 'selected' : '' }}>Quý 1</option>
                            <option value="2" {{ $selected_quy == 2 ? 'selected' : '' }}>Quý 2</option>
                            <option value="3" {{ $selected_quy == 3 ? 'selected' : '' }}>Quý 3</option>
                            <option value="4" {{ $selected_quy == 4 ? 'selected' : '' }}>Quý 4</option>
                        </select>
                    </div>
                    <div class="mr-15 chon_quy" style="display: {{$loai == 'quy' ? 'flex' : 'none'}}">
                       <input type="text" name="nam" style="width: 80%;" class="form-control input-nam" id="nam" value="{{ $selected_nam }}">
                    </div>
                    <div class="mr-15" id="chon_thang" style="display: {{$loai == 'quy' ? 'none' : ''}}">
                        Chọn tháng <input class="ml-5 input-date" id="datekt" type="text" name="start_time" value="{{ formatMY($start_time) }}">
                    </div>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Lọc</button>
                </div>
            </form>
            <br>
            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th width="120px">Đơn vị</th>
                        <th width="400px">Nội dung</th>
                        <th width="100px">CĂN CỨ</th>
                        <th width="100px">Tiến độ</th>
                        <th width="100px">Thời hạn</th>
                        <th>Minh chứng/ Nguyên nhân/ Dự kiến thời gian hoàn thành
                        </th>
                        @if($user->donvi_id == 136)
                            <th></th>
                        @endif
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @if(count($datas) > 0)
                    @foreach ($datas as $data)
                        <tr style="display: {{$data->count_all - $data->count_done == 0 ? 'none' : ''}}">
                            <td class="col-stt" rowspan="{{$data->count_all - $data->count_done}}"><b>{{ $data->name }}</b></td>
                        @foreach($data->array as $val)
                            @if($loai == 'quy')
                                @if($val->quy < $selected_nam.$selected_quy && $val->status != 2 || $val->quy == $selected_nam.$selected_quy)
                                    <td>{{ $val->content }}</td>
                                    <td>{{ $val->note }}</td>
                                    <td data-minhchung="{{$val->minhchung}}" data-id="{{$val->id}}" data-status="{{$val->status}}" class="change_status" data-toggle="tooltip" title="Bấm vào để cập nhật tiến độ công việc">
                                        @if($val->status == 0)
                                            <span class="undeveloped">Chưa triển khai</span>
                                        @elseif($val->status ==  1)
                                            <span class="inprogress">Đang triển khai</span>
                                        @elseif($val->status ==  2)
                                            <span class="done">Hoàn thành</span>
                                        @elseif($val->status ==  3)
                                            <span class="pause">Tạm hoãn</span>
                                        @endif
                                    </td>
                                    <td>{{$val->thoi_han}}</td>
                                    <td>{{ $val->minhchung }}</td>
                                    @if($user->donvi_id == 136)
                                        @if($val->loai_bo == 0)
                                            <td class="text-center"><a href="javascript:;" onclick="loaiTienDo({{$val->id}}, {{$val->loai_bo}})" title="Loại bỏ"><i class="fa fa-eye blue"></i></a></td>
                                        @else
                                            <td class="text-center"><a href="javascript:;" onclick="loaiTienDo({{$val->id}}, {{$val->loai_bo}})" title="Hủy loại bỏ"><i class="fa fa-eye-slash red"></i></a></td>
                                        @endif
                                    @endif
                                    @if($user->id == $val->user_nhap)
                                        <td class="text-center"><a href="{{ route('editquanlytiendo', [$val->id]) }}" title="Sửa đăng ký"><i class="fa fa-edit"></i></a></td>
                                        <td class="text-center"><a href="javascript:;" onclick="xoaTienDo({{$val->id}})" title="Hủy công việc"><i class="fa fa-trash red"></i></a></td>
                                    @endif
                                    </tr>
                                @endif
                            @else
                                @if(strtotime($val->thang) < strtotime($start_time) && $val->status != 2 || strtotime($val->thang) == strtotime($start_time))
                                    <td>{{ $val->content }}</td>
                                    <td>{{ $val->note }}</td>
                                    <td data-minhchung="{{$val->minhchung}}" data-id="{{$val->id}}" data-status="{{$val->status}}" class="change_status" data-toggle="tooltip" title="Bấm vào để cập nhật tiến độ công việc">
                                        @if($val->status == 0)
                                            <span class="undeveloped">Chưa triển khai</span>
                                        @elseif($val->status ==  1)
                                            <span class="inprogress">Đang triển khai</span>
                                        @elseif($val->status ==  2)
                                            <span class="done">Hoàn thành</span>
                                        @elseif($val->status ==  3)
                                            <span class="pause">Tạm hoãn</span>
                                        @endif
                                    </td>
                                    <td style="font-weight: bold">{{ formatDMY($val->thoi_han) }}</td>
                                    <td>{{ $val->minhchung }}</td>
                                    @if($user->donvi_id == 136)
                                        @if($val->loai_bo == 0)
                                            <td class="text-center"><a href="javascript:;" onclick="loaiTienDo({{$val->id}}, {{$val->loai_bo}})" title="Loại bỏ"><i class="fa fa-eye blue"></i></a></td>
                                        @else
                                            <td class="text-center"><a href="javascript:;" onclick="loaiTienDo({{$val->id}}, {{$val->loai_bo}})" title="Hủy loại bỏ"><i class="fa fa-eye-slash red"></i></a></td>
                                        @endif
                                    @endif
                                    @if($user->id == $val->user_nhap)
                                        <td class="text-center"><a href="{{ route('editquanlytiendo', [$val->id]) }}" title="Sửa đăng ký"><i class="fa fa-edit"></i></a></td>

                                        <td class="text-center"><a href="javascript:;" onclick="xoaTienDo({{$val->id}})" title="Hủy công việc"><i class="fa fa-trash red"></i></a></td>
                                    @endif
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center">Không có dữ liệu</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="pull-right">
                @include(config('app.interface').'pagination', ['paginator' => $donvichutris, 'interval' => 5])
            </div>
        </div>
    </div>

    <div id="ImportExcell" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 35%;">
            <div class="modal-content">
                <div class="modal-header " style="background:#1d589e;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title" style="color: white">Import danh sách tiến độ công việc</h3>
                </div>
                <div class="modal-body">
                    <form id="ImportExcell" action="{{url('import_update_bang_theo_doi_tien_do_cong_viec')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div>
                            @if($user->donvi_id == 136)
                               <div style="display: flex">
                                   <label style="width: 20%;">Đơn vị: </label>
                                   <select name="import_donvi" id="import_donvi" class="chosens" {{$user->donvi_id != 136 ? 'disabled' : ''}}>
                                       <option value="">-- Chọn đơn vị --</option>
                                       @foreach($donvis as $donvi)
                                           <option {{ $donvi->id == $donvi_id ? 'selected' : '' }} value="{{ $donvi->id }}">{{ $donvi->name }}</option>
                                       @endforeach
                                   </select>
                               </div>
                            @endif
                            <br>
                            <div style="display: flex">
                                <label style="width: 20%;">Chọn loại </label>
                                <select name="import_loai" id="import_loai" class="form-control" style="margin-left: 25px">
                                    <option value="thang">Theo tháng</option>
                                    <option value="quy">Theo quý</option>
                                </select>
                            </div>
                            <br>
                            <div style="display: flex" id="import_thang">
                                <label style="width: 20%;">Chọn tháng </label>
                                <input type="text" name="date" style="width: 80%;" class="form-control input-date" id="date" value="{{date('m/Y')}}">
                            </div>
                            <br>
                            <div style="display: none" class="import_quy">
                                <label style="width: 20%;">Chọn quý </label>
                                <select name="import_quy" id="import_quy" class="form-control" style="margin-left: 25px">
                                    <option value="1" {{$quy==1?'selected':''}}>Quý 1</option>
                                    <option value="2" {{$quy==2?'selected':''}}>Quý 2</option>
                                    <option value="3" {{$quy==3?'selected':''}}>Quý 3</option>
                                    <option value="4" {{$quy==4?'selected':''}}>Quý 4</option>
                                </select>
                            </div>
                            <br>
                            <div style="display: none" class="import_quy">
                                <label style="width: 20%;">Chọn năm </label>
                                <input type="text" name="import_nam" style="width: 80%;" class="form-control input-nam" id="date" value="{{date('Y')}}">
                            </div>
                        </div>
                        <div style="margin-top: 20px;">
                            <label>{{trans('common.str_select_file_excel')}}
                                <a href={{url('app/webroot/phpexcel/mau/mau_danh_sach_tien_do_cong_viec.xlsx')}} target="_blank" title="Click để dowload mẫu" style="color: blue">mẫu tại đây</a>
                            </label>
                        </div>
                        <div style="margin-top: 15px">
                            <input name="file" id="file" style="display: none;" class="inputfile" accept=".xlsx" type="file">
                            <label for="file" style="width: 100%; display: flex; cursor: pointer;">
                                <strong style="margin-right: 10px;">
                                    <svg width="20" height="17" viewBox="0 0 20 17">
                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                    </svg> {{ trans('common.txt_select_file') }}
                                </strong>
                                <span style="flex: 1;padding: 3px 10px;background-color: #ddd;text-align: left;"></span>
                            </label>
                        </div>
                        <div class="text-center" style="margin-top: 50px">
                            <button type="submit" class="btn btn-primary btn-import">{{trans('common.txt_import')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', width: '200px', search_contains:true});
        $('.chosens').chosen({no_results_text: 'Không tìm thấy kết quả', width: '80%', search_contains:true});

        $('.btn-filter-progress').click(function(event) {
            $('.form-filter-bao-cao').slideToggle();
        });

        function xuatWord() {
            let url = "<?php echo e(route('quanlytiendo.danhsach')); ?>";
            let params = <?php echo json_encode($_GET) ?>;
            let start_time =$("#datekt").val();
            let tiendo = $("#tiendo").val();
            let donvi_id = $("#donvi_id").val();
            let nam = $("#nam").val();
            let quy = $("#quy").val();
            let chon_loai = $("#chon_loai").val();
            let page = {{$donvichutris->currentPage()}};
            location.href = url+'?donvi_id='+donvi_id+'&tiendo='+tiendo+'&start_time='+start_time+'&export_word=1'+'&page='+page+'&quy='+quy+'&nam='+nam+'&chon_loai='+chon_loai;
        }

        function xuatExcel() {
            let url = "<?php echo e(route('quanlytiendo.danhsach')); ?>";
            let params = <?php echo json_encode($_GET) ?>;
            let start_time =$("#datekt").val();
            let nam = $("#nam").val();
            let quy = $("#quy").val();
            let chon_loai = $("#chon_loai").val();
            let tiendo = $("#tiendo").val();
            let donvi_id = $("#donvi_id").val();
            let page = {{$donvichutris->currentPage()}};
            location.href = url+'?donvi_id='+donvi_id+'&tiendo='+tiendo+'&start_time='+start_time+'&quy='+quy+'&nam='+nam+'&chon_loai='+chon_loai+'&export_excel=1'+'&page='+page;
        }

        function showImportExcell(){
            $('#ImportExcell').modal('show');
        }

        $('#ImportExcell').submit(function () {
            if($("#import_donvi").val() == ''){
                jAlert('Vui lòng chọn đơn vị','Thông báo');
                return false;
            }

            if($("#file").val() == ''){
                jAlert('Vui lòng chọn file excel cần nhập','Thông báo');
                return false;
            }

            if($("#file").val().split('.').pop() !== "xlsx"){
                jAlert('Vui lòng chọn đúng định dạng đuôi ".xlsx"','Thông báo');
                return false;
            }
        });
        $('.inputfile').change(function () {
            resetFilePickerCustom();
        });
        function resetFilePickerCustom() {
            files = $('.inputfile').prop('files');
            if (files && files.length > 0) {
                $('.inputfile + label > span').text(files[0].name);
            }
            else {
                $('.inputfile + label > span').text('');
            }
        }
        resetFilePickerCustom();

        $('.input-date').datetimepicker({
            format: 'MM-YYYY',
            useCurrent: false,
            maxDate : 'now'
        });

        $('.input-nam').datetimepicker({
            format: 'YYYY',
            useCurrent: false,
            maxDate : 'now'
        });

        function xoaTienDo(id, status) {
            let message = 'Bạn có muốn xóa tiến độ công việc này?';

            jConfirm(message, 'Thông báo', function(r) {
                if (r == true) {
                    let url = "{{ route('quanlytiendo.xoatiendocongviec') }}";
                    let token = '{{ csrf_token() }}';

                    loading_show();
                    $.post(url, {id:id, _token:token}, function(data) {
                        if (data.error){
                            jAlert(data.message, 'Thông báo')
                            loading_hide();
                        }else {
                            location.reload(true);
                        }
                    },'json');
                }
            });
        }

        function loaiTienDo(id, status) {
            var message;
            if (status == 1){
                message = 'Bạn có muốn mở tiến độ công việc này?';
            }else {
                message = 'Bạn có muốn loại bỏ tiến độ công việc này?';
            }

            jConfirm(message, 'Thông báo', function(r) {
                if (r == true) {
                    let url = "{{ route('quanlytiendo.loaitiendocongviec') }}";
                    let token = '{{ csrf_token() }}';

                    loading_show();
                    $.post(url, {id:id, status:status, _token:token}, function(data) {
                        if (data.error){
                            jAlert(data.message, 'Thông báo')
                            loading_hide();
                        }else {
                            location.reload(true);
                        }
                    },'json');
                }
            });
        }


        $('.change_status').click(function (){
            let status = $(this).data('status')
            let minhchung = $(this).data('minhchung')
            let id = $(this).data('id')
            var url = "{{url('cap-nhat-trang-thai-tien-do-cong-viec')}}";
            var token = '{{ csrf_token() }}';
            var selected_0 = '';
            if (status == 0){
                selected_0 = 'selected = "selected"';
            }
            var selected_1 = '';
            if (status == 1){
                selected_1 = 'selected = "selected"';
            }
            var selected_2 = '';
            if (status == 2){
                selected_2 = 'selected = "selected"';
            }
            var selected_3 = '';
            if (status == 3){
                selected_3 = 'selected = "selected"';
            }
            $.confirm({
                type: 'blue',
                title: 'Xử lý tiến độ công việc',
                columnClass: 'medium',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Tiến độ</label>' +
                    '<select name="status_change" id="status_change" class="form-control">' +
                    '<option value="0" '+selected_0+'>Chưa triển khai</option>' +
                    '<option value="1" '+selected_1+'>Đang triển khai</option>' +
                    '<option value="2" '+selected_2+'>Hoàn thành</option>' +
                    '<option value="3" '+selected_3+'>Tạm hoãn</option>' +
                    '</select>' +
                    '<br>'+
                    '<label>Minh chứng/Nguyên nhân/ Dự kiến thời gian hoàn thành</label>' +
                    '<textarea class="form-control text-area" rows="4" name="minhchung_change" id="minhchung_change">'+minhchung+'</textarea>' +
                    '<span style="display: none; margin-top: 5px;color: red; font-style: italic" id="error_minhchung">Vui lòng nhập minh chứng</span>' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Đồng ý',
                        btnClass: 'btn-blue',
                        action: function () {
                            let status_change = $('#status_change').val();
                            let minhchung_change = $('#minhchung_change').val();
                            if (minhchung_change == ''){
                                $('#error_minhchung').css('display', 'block');
                                return false
                            }else {
                                $.post(url, {
                                    id: id,
                                    status: status_change,
                                    minhchung: minhchung_change,
                                    _token: token
                                }, function (data) {
                                    if (data.error) {
                                        jAlert(data.message, 'Thông báo')
                                    } else {
                                        location.reload(true);
                                    }
                                }, 'json')
                            }
                        }
                    },
                    close: {
                        text: 'Hủy',
                        btnClass: 'btn-red',
                    },
                },
            });
        })

        $('#chon_loai').on('change', function (){
            let loai = $('#chon_loai').val();
            if (loai == 'quy'){
                $('.chon_quy').css('display','flex')
                $('#chon_thang').css('display','none')
            }else {
                $('.chon_quy').css('display','none')
                $('#chon_thang').css('display','block')
            }
        });
        $('#import_loai').on('change', function (){
            let loai = $('#import_loai').val();
            if (loai == 'quy'){
                $('.import_quy').css('display','flex')
                $('#import_thang').css('display','none')
            }else {
                $('.import_quy').css('display','none')
                $('#import_thang').css('display','flex')
            }
        });
    </script>
@endsection