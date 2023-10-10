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
    <?php
    $user = (object) session('user');
    ?>
    <div class="container container-list report-statistic">
        @include('flash::message')
        <div class="row">
            <div class="box-head">
                <h3>Báo cáo thống kê văn bản đi - <small>Thời điểm xuất báo cáo: {{date('d/m/Y')}}</small></h3>
                <div>
                    <a style="position: absolute; right: 100px; top: 25px;"><i class="fa fa-search btn-filter-statistic btn btn-primary" aria-hidden="true"></i></a>
                    <a class="btn btn-primary" style="margin-top: 7px;" href="javascript:;" onclick="xuatWord()"><i class="fa fa-file-word-o"></i> Tải về</a>
                </div>
            </div>
            <form class="form-filter-bao-cao justify-content-end" action="" method="GET">
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
                    <th class="col-stt" >TT</th>
                    <th>Đơn vị soạn thảo</th>
                    <th>Số văn bản ban hành</th>
                </tr>
                </thead>
                <tbody>
                <?php $stt = ($data->currentPage() - 1) * $data->perPage() + 1 ?>
                @if(count($data) > 0)
                    @foreach ($data as $val)
                        <tr data-donvi-id="{{ $val->donvi_id }}">
                            <td class="col-stt">{{ $stt++ }}</td>
                            <td class="cursor-pointer detail-donvi"><a href="{{$user->donvi_id == 136 || $user->donvi_id == $val->donvi_id ? route('thongke.vanbandicanhan', ['donvi_id' => $val->donvi_id]) : ''}}">{{ $val->tenDonviBH }}</a></td>
                            <td data-toggle="tooltip" title="Bấm vào để xem danh sách văn bản" class="cursor-pointer bg-success {{$user->donvi_id == 136 || $user->donvi_id == $val->donvi_id ? 'ds-bao-cao' : ''}}">{{ $val->tongVBBanHanh }}</td>
                        </tr>
                    @endforeach
                @else
                    <td class="text-center" colspan="3">Không có dữ liệu</td>
                @endif
                </tbody>
            </table>
            <div class="pull-right">
                @include(config('app.interface').'pagination', ['paginator' => $data, 'interval' => 5])
            </div>
        </div>
    </div>
    <!-- Modal -->
    @include(config('app.interface').'thongke._modal_danh_sach_van_ban_di')

    <script type="text/javascript">
        $('.btn-filter-statistic').click(function(event) {
            $('.form-filter-bao-cao').slideToggle();
        });


        $('.ds-bao-cao').click(function(event) {
            let donvi_id = $(this).closest('tr').data('donvi-id');
            let start_time = $('.form-filter-bao-cao input[name="start_time"]').val();
            let end_time = $('.form-filter-bao-cao input[name="end_time"]').val();

            $('#list-docs .modal-title').text('Danh sách văn bản đã ban hành');
            // loading_show();

            $.getJSON('{{ route("thongke.vanbandi.danhsach") }}', {donvi_id: donvi_id, start_time: start_time, end_time: end_time}, function(json, textStatus) {
                loading_hide();
                if(textStatus !== 'success') return alert('Có lổi phía máy chủ!');
                let tr = '';
                if(json.length == 0) {
                    tr += '<tr><td colspan="5">Không có dữ liệu</td></tr>';
                }else{
                    $.each(json, function(index, val) {
                        tr += `
                    <tr class="$">
                    <th scope="row">${++index}</th>
                    <td><a href="{{url('vanban/chi-tiet-van-ban-di')}}/${val.id}" target="_blank">${val.title}</a></td>
                    <td>${val.ngayky}</td>
                    </tr>
                    `;
                    });
                }
                $('#list-docs table tbody').html(tr);
                $('#list-docs').modal('show');
            });
        });

        function xuatWord() {
            let url = "<?php echo e(route('thongke.vanbandi')); ?>";
            let params = <?php echo json_encode($_GET) ?>;
            let start_time =$("#ngaybd").val();
            let end_time = $("#ngaykt").val();
            let page = {{$data->currentPage()}};
            location.href = url+'?start_time='+start_time+'&end_time='+end_time+'&export_word=1'+'&page='+page;
        }
    </script>

@endsection