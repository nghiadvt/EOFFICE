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
                <h3>Báo cáo thống kê văn bản đi - <small>Thời điểm xuất báo cáo: {{date('d/m/Y')}}</small></h3>
                <div>
                    <a class="btn btn-primary" style="margin-top: 7px;" href="javascript:;" onclick="xuatWord()"><i class="fa fa-file-word-o"></i> Tải về</a>
                </div>
            </div>
            <input type="hidden" id="donvi_id" value="{{$donvi_id}}">
            <div><h4>Đơn vị: {{$donviName ? $donviName : ''}}</h4></div>
            <table class="table table-bordered">
                <thead class="head-table">
                <tr>
                    <th class="col-stt" >TT</th>
                    <th>Tên cán bộ</th>
                </tr>
                </thead>
                <tbody>
                <?php $stt = ($data->currentPage() - 1) * $data->perPage() + 1 ?>
                @foreach ($data as $val)
                    <tr>
                        <td class="col-stt">{{ $stt++ }}</td>
                        <td class="cursor-pointer detail-donvi">{{ $val->fullname }}</td>
                    </tr>
                @endforeach
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

        function xuatWord() {
            let url = "<?php echo e(route('thongke.vanbandicanhan')); ?>";
            let params = <?php echo json_encode($_GET) ?>;
            let page = {{$data->currentPage()}};
            let donvi_id = $("#donvi_id").val();
            location.href = url+'?donvi_id='+donvi_id+'&export_word=1'+'&page='+page;
        }
    </script>

@endsection