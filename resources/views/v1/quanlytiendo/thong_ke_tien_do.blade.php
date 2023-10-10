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
                <h3>THỐNG KÊ TIẾN ĐỘ CÔNG VIỆC</h3>
                <div>
                    <a class="btn btn-primary btn-filter-progress" style="margin-top: 7px;"><i style="position: unset; font-size: unset" class="fa fa-search" aria-hidden="true"></i></a>
                    <a class="btn btn-primary" style="margin-top: 7px;" href="javascript:;" onclick="xuatWord()"><i class="fa fa-file-word-o"></i> Tải về</a>
                </div>
            </div>
            <form class="form-filter-bao-cao justify-content-end" action="" method="GET">
                <div class="d-flex justify-content-center">
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
                            <option value="1" {{$selected_quy == 1 ? 'selected' : ''}}>Quý 1</option>
                            <option value="2" {{$selected_quy == 2 ? 'selected' : ''}}>Quý 2</option>
                            <option value="3" {{$selected_quy == 3 ? 'selected' : ''}}>Quý 3</option>
                            <option value="4" {{$selected_quy == 4 ? 'selected' : ''}}>Quý 4</option>
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
                        <th rowspan="3">TT</th>
                        <th rowspan="3" style="width: 400px">Đơn vị</th>
                        <th rowspan="3">Tổng công việc</th>
                        <th colspan="8">Tình trạng</th>
                    </tr>
                    <tr>
                        <th colspan="2">Hoàn thành</th>
                        <th colspan="2">Đang triển khai</th>
                        <th colspan="2">Chưa triển khai</th>
                        <th colspan="2">Tạm hoãn</th>
                    </tr>
                    <tr>
                        <th>Số lượng</th>
                        <th>Tỉ lệ</th>
                        <th>Số lượng</th>
                        <th>Tỉ lệ</th>
                        <th>Số lượng</th>
                        <th>Tỉ lệ</th>
                        <th>Số lượng</th>
                        <th>Tỉ lệ</th>
                    </tr>
                </thead>
                <tbody>
                <?php $stt = ($datas->currentPage() - 1) * $datas->perPage() + 1 ?>
                @if(count($datas) > 0)
                    @foreach ($datas as $key =>  $data)
                        <?php $tong = $data->hoanthanh + $data->danglam + $data->chualam + $data->tamhoan ?>
                        <tr>
                            <td>{{$stt++}}</td>
                            <td>{{$data->name}}</td>
                            <td class="text-center">{{$tong}}</td>
                            <td class="text-center">{{$data->hoanthanh}}</td>
                            <td class="text-center">{{ is_int(($data->hoanthanh) > 0 ? (( $data->hoanthanh) * 100 / ($tong)) : 0) ? (($data->hoanthanh) > 0 ? (( $data->hoanthanh) * 100 / ($tong)) : 0) : number_format((($data->hoanthanh) * 100 > 0 ? (( $data->hoanthanh) * 100 / ($tong)) : 0) ,2) }}%</td>
                            <td class="text-center">{{$data->danglam}}</td>
                            <td class="text-center">{{ is_int(($data->danglam) > 0 ? (( $data->danglam) * 100 / ($tong)) : 0) ? (($data->danglam) > 0 ? (( $data->danglam) * 100 / ($tong)) : 0) : number_format((($data->danglam) * 100 > 0 ? (( $data->danglam) * 100 / ($tong)) : 0) ,2) }}%</td>
                            <td class="text-center">{{$data->chualam}}</td>
                            <td class="text-center">{{ is_int(($data->chualam) > 0 ? (( $data->chualam) * 100 / ($tong)) : 0) ? (($data->chualam) > 0 ? (( $data->chualam) * 100 / ($tong)) : 0) : number_format((($data->chualam) * 100 > 0 ? (( $data->chualam) * 100 / ($tong)) : 0) ,2) }}%</td>
                            <td class="text-center">{{$data->tamhoan}}</td>
                            <td class="text-center">{{ is_int(($data->tamhoan) > 0 ? (( $data->tamhoan) * 100 / ($tong)) : 0) ? (($data->tamhoan) > 0 ? (( $data->tamhoan) * 100 / ($tong)) : 0) : number_format((($data->tamhoan) * 100 > 0 ? (( $data->tamhoan) * 100 / ($tong)) : 0) ,2) }}%</td>
                        </tr>
                    @endforeach
                @else
                    <td colspan="11" class="text-center">Không có dữ liệu</td>
                @endif
                </tbody>
            </table>
            <div class="pull-right">
                @include(config('app.interface').'pagination', ['paginator' => $datas, 'interval' => 5])
            </div>
        </div>
    </div>

    <script>
        $('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', width: '200px', search_contains:true});

        $('.btn-filter-progress').click(function(event) {
            $('.form-filter-bao-cao').slideToggle();
        });

        function xuatWord() {
            let url = "<?php echo e(route('quanlytiendo.thongke_tiendo')); ?>";
            let params = <?php echo json_encode($_GET) ?>;
            let start_time =$("#datekt").val();
            let donvi_id = $("#donvi_id").val();
            let nam = $("#nam").val();
            let quy = $("#quy").val();
            let chon_loai = $("#chon_loai").val();
            let page = {{$datas->currentPage()}};
            location.href = url+'?donvi_id='+donvi_id+'&start_time='+start_time+'&export_word=1'+'&page='+page+'&quy='+quy+'&nam='+nam+'&chon_loai='+chon_loai;
        }

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