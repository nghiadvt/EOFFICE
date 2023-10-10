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
    </style>
    <div class="container container-list report-statistic">
        @include('flash::message')
        <div class="row">
            <div class="box-head">
                <h3>Báo cáo thống kê văn bản đến - <small>Thời điểm xuất báo cáo: {{date('d/m/Y')}}</small></h3>
                <div>
                    <a style="position: absolute; right: 100px; top: 25px;"><i class="fa fa-search btn-filter-statistic btn btn-primary" aria-hidden="true"></i></a>
                    <a class="btn btn-primary" style="margin-top: 7px;" href="javascript:;" onclick="xuatWord()"><i class="fa fa-file-word-o"></i> Tải về</a>
                </div>
            </div>
            <div><h4>Đơn vị: {{$donviName}}</h4></div>
            <form class="form-filter-bao-cao justify-content-end" action="" method="GET">
                <input type="hidden" name="donvi_id" id="donvi_id" value="{{ $donvi_id  }}">
                <div class="d-flex justify-content-center">
                    <div class="mr-15">
                        Từ ngày <input class="ml-5" id="ngaybd" type="text" name="start_time" value="{{ formatdmYY($start_time) }}">
                    </div>
                    <div class="mr-15">
                        Đến ngày <input class="ml-5" id="ngaykt" type="text" name="end_time" value="{{ formatdmYY($end_time) }}">
                    </div>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Thống kê</button>
                </div>
            </form>
            <br>
            <table class="table table-bordered">
                <thead class="head-table">
                <tr>
                    <th class="col-stt" rowspan="3">TT</th>
                    <th rowspan="3">Cán bộ</th>
                    <th rowspan="3">Văn bản chủ trì</th>
                    <th rowspan="3">Văn bản phối hợp</th>
                    <th colspan="6">Tình trạng</th>
                </tr>
                <tr>
                    <th colspan="2">Hoàn thành đúng hạn</th>
                    <th colspan="2">Hoàn thành quá hạn</th>
                    <th colspan="2">Chưa hoàn thành</th>
                </tr>
                <tr>
                    <th>Số lượng</th>
                    <th>Tỉ lệ</th>
                    <th>Số lượng</th>
                    <th>Tỉ lệ</th>
                    <th>Số lượng</th>
                    <th>Tỉ lệ</th>
                </tr>
                </thead>
                <tbody>
                <?php $stt = ($data->currentPage() - 1) * $data->perPage() + 1 ?>
                @if(count($data) > 0)
                    @foreach ($data as $val)
                        <tr data-user-id="{{ $val->user_id }}">
                            <td class="col-stt">{{ $stt++ }}</td>
                            <td>{{ $val->fullname }}</td>
                            <td data-toggle="tooltip" title="Bấm vào để xem danh sách văn bản" class="cursor-pointer ds-bao-cao" data-type="1">{{ $val->tongVBChuTri }}</td>
                            <td data-toggle="tooltip" title="Bấm vào để xem danh sách văn bản" class="cursor-pointer ds-bao-cao" data-type="2">{{ $val->tongVBPhoiHop }}</td>
                            <td data-toggle="tooltip" title="Bấm vào để xem danh sách văn bản" class="cursor-pointer bg-success ds-bao-cao" data-type="3">{{ $val->tongVBHoanThanhDungHan }}</td>
                            <td class="text-center">{{ is_int(($val->tongVBHoanThanhDungHan) * 100 > 0 ? (( $val->tongVBHoanThanhDungHan) * 100 / ($val->tongVBChuTri)) : 0) ? (($val->tongVBHoanThanhDungHan) * 100 > 0 ? (( $val->tongVBHoanThanhDungHan) * 100 / ($val->tongVBChuTri)) : 0) : number_format((($val->tongVBHoanThanhDungHan) * 100 > 0 ? (( $val->tongVBHoanThanhDungHan) * 100 / ($val->tongVBChuTri)) : 0) ,2) }}%</td>
                            <td data-toggle="tooltip" title="Bấm vào để xem danh sách văn bản" class="cursor-pointer bg-warning ds-bao-cao" data-type="4">{{ $val->tongVBHoanThanhQuaHan }}</td>
                            <td class="text-center">{{ is_int(($val->tongVBHoanThanhQuaHan) * 100 > 0 ? (( $val->tongVBHoanThanhQuaHan) * 100 / ($val->tongVBChuTri)) : 0) ? (($val->tongVBHoanThanhQuaHan) * 100 > 0 ? (( $val->tongVBHoanThanhQuaHan) * 100 / ($val->tongVBChuTri)) : 0) : number_format((($val->tongVBHoanThanhQuaHan) * 100 > 0 ? (( $val->tongVBHoanThanhQuaHan) * 100 / ($val->tongVBChuTri)) : 0) ,2) }}%</td>
                            <td data-toggle="tooltip" title="Bấm vào để xem danh sách văn bản" class="cursor-pointer bg-danger ds-bao-cao" data-type="5">{{ $val->tongVBChuaHoanThanh + $val->tongVBChuaHT}}</td>
                            <td class="text-center">{{ is_int(($val->tongVBChuaHoanThanh + $val->tongVBChuaHT) * 100 > 0 ? (( $val->tongVBChuaHoanThanh + $val->tongVBChuaHT) * 100 / ($val->tongVBChuTri)) : 0) ? (($val->tongVBChuaHoanThanh + $val->tongVBChuaHT) * 100 > 0 ? (( $val->tongVBChuaHoanThanh + $val->tongVBChuaHT) * 100 / ($val->tongVBChuTri)) : 0) : number_format((($val->tongVBChuaHoanThanh + $val->tongVBChuaHT) * 100 > 0 ? (( $val->tongVBChuaHoanThanh + $val->tongVBChuaHT) * 100 / ($val->tongVBChuTri)) : 0) ,2) }}%</td>
                        </tr>
                    @endforeach
                @else
                    <td class="text-center" colspan="10">Không có dữ liệu</td>
                @endif
                </tbody>
            </table>
            <div class="pull-right">
                @include(config('app.interface').'pagination', ['paginator' => $data, 'interval' => 5])
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include(config('app.interface').'baocaos._modal_danh_sach_van_ban')

    <script type="text/javascript">

        $('.btn-filter-statistic').click(function(event) {
            $('.form-filter-bao-cao').slideToggle();
        });

        $('.ds-bao-cao').click(function(event) {
            let user_id = $(this).closest('tr').data('user-id');
            let type = $(this).data('type');
            let start_time = $('.form-filter-bao-cao input[name="start_time"]').val();
            let end_time = $('.form-filter-bao-cao input[name="end_time"]').val();

            if(type == 1) $('#list-docs .modal-title').text('Danh sách văn bản chủ trì - cá nhân');
            else if(type == 2) $('#list-docs .modal-title').text('Danh sách văn bản phối hợp - cá nhân');
            else if(type == 3) $('#list-docs .modal-title').text('Danh sách văn bản hoàn thành đúng hạn - cá nhân');
            else if(type == 4) $('#list-docs .modal-title').text('Danh sách văn bản hàn thành quá hạn - cá nhân');
            else if(type == 5) $('#list-docs .modal-title').text('Danh sách văn bản chưa hoàn thành - cá nhân');
            loading_show();

            $.getJSON('{{ route("baocaothongke.danhsach") }}', {user_id: user_id, type: type, start_time: start_time, end_time: end_time}, function(json, textStatus) {
                loading_hide();
                if(textStatus !== 'success') return alert('Có lổi phía máy chủ!');
                let tr = '';
                if(json.length == 0) {
                    tr += '<tr><td colspan="5">Không có dữ liệu</td></tr>';
                }else{
                    $.each(json, function(index, val) {
                        tr += `
                    <tr>
                    <th scope="row">${++index}</th>
                    <td><a href="{{url('vanban/chi-tiet-van-ban-den')}}/${val.id}" target="_blank">${val.title}</a></td>
                    <td>${val.ngaychuyentiep}</td>
                    <td>${val.ngayxuly}</td>
                    <td>
                    <span class="badge-${val.status == 1 ? 'secondary' : (val.status == 2 ? 'warning' : 'success')}">
                    ${ val.status == 1 ? 'Chưa xử lý' : (val.status == 2 ? 'Đang xử lý' : (val.status == 3 ? 'Đã xử lý' : 'N/A')) }
                    </span>
                    </td>
                    </tr>
                    `;
                    });
                }
                $('#list-docs table tbody').html(tr);
                $('#list-docs').modal('show');
            });
        });

        function xuatWord() {
            let url = "<?php echo e(route('thongke.vanbandencanhan')); ?>";
            let params = <?php echo json_encode($_GET) ?>;
            let start_time =$("#ngaybd").val();
            let end_time = $("#ngaykt").val();
            let donvi_id = $("#donvi_id").val();
            let page = {{$data->currentPage()}};
            location.href = url+'?start_time='+start_time+'&end_time='+end_time+'&donvi_id='+donvi_id+'&export_word=1'+'&page='+page;
        }
    </script>
@endsection