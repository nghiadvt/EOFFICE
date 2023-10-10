@extends(config('app.interface').'templates.lanhdao')
@section('main')
    <div class="page-wrapper">
        <div class="top-page-wrapper">
            <div class="title-page col-md-5 col-sm-5 col-xs-12 col-lg-12">
                <h2>Bảng danh sách theo dõi tiến độ công việc</h2>
            </div>
        </div>
        <div class="page-content col-md-12 col-sm-12">
            <div class="clearfix"></div>
            <div class="table-responsive" style="margin-top: 15px;">
                @if (!isset($error))
                    <div style="overflow: auto;">
                        <table class="table table-bordered table-striped bulk_action dragscroll tb-dragscroll" style="display: inline-table">
                            <thead>
                            <tr class="headings" style="text-align: center">
                                <th class="column-title col-index" style="text-align: center">STT</th>
                                <th class="column-title" style="text-align: center">Nội dung</th>
                                <th class="column-title"  style="text-align: center">căn cứ</th>
                                <th class="column-title"  style="text-align: center">tiến độ</th>
                                <th class="column-title" style="text-align: center">Minh chứng</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (sizeof($trackworkprogress))
                                <?php $i = '1' ?>
                                @foreach($trackworkprogress as $val)
                                    <tr class="even pointer">
                                        <td>{{$i++}}</td>
                                        <td>{{$val->content}}</td>
                                        <td>{{$val->note}}</td>
                                        <td>
                                            @if($val->status == 0)
                                                Chưa triển khai
                                            @elseif($val->status == 1)
                                                Đang triển khai
                                            @elseif($val->status == 2)
                                                Hoàn thành
                                            @else
                                                Đang tạm hoãn
                                            @endif
                                        </td>
                                        <td>{{$val->minhchung}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">{{ trans('common.txt_no_data') }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="search-page-form">
                        <div class="page-content">
                            @if (isset($trackworkprogress) && sizeof($trackworkprogress) > 0)
                                <div class="data-contaner">
                                    <?php $modelParent = $trackworkprogress[0];?>
                                    @foreach($trackworkprogress as $index => $val)
                                        <input class="progress" type="hidden"
                                               data-donvichutri="{{ $val->donvichutri }}"
                                               data-content="{{ $val->content }}"
                                               data-note="{{ $val->note }}"
                                               data-status="{{ $val->status }}"
                                               data-minhchung="{{ $val->minhchung }}"
                                               data-thang="{{ $val->thang }}"
                                               data-quy="{{ $val->quy }}"
                                               data-loai="{{ $val->loai }}"
                                               data-user_nhap="{{ $val->user_nhap }}"
                                        />
                                    @endforeach
                                </div>
                                <div class="number-record" style="padding-bottom: 10px;">
                                    @if($countMaCanBoEmpty !=0)
                                        <p style="margin-bottom: 10px; color: red;">{{trans('common.txt_have')}} {{$countMaCanBoEmpty}} {{trans('common.txt_users_who_have_a_tag_code_of_less_than_6_characters_are_not_added')}}.</p>
                                    @endif

                                    @if($total)
                                        <p>  {{trans('common.txt_have')}} {{$total}} việc làm được thêm vào.</p>
                                    @endif
                                </div>

                                @if ($total)
                                    <button class="btn btn-primary btn-insert">Lưu danh sách</button>
                                @elseif(!$total)
                                    <input type="button" value="Trở về" onclick="goBack()">
                                @endif

                                <div class="bg_ptr" style="display: none;">
                                    <div class="progress-status">Đang xử lý</div>
                                    <div>Đã thêm vào <span id="offset"></span>/<span
                                                id="total"></span></div>
                                    <div class="progress-bar-container">
                                        <span class="progress-bar"></span>
                                        <div class="process">
                                            <div class="percent_">
                                                <div class="dr_" style="color: #fff; font-size: 14px;">0%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: 35px; text-align: center;">
                                    <a class="btn btn-primary btn-done" href="{{ url('quan-ly-tien-do') }}"
                                       style="display: none;">Hoàn thành</a>
                                </div>
                            @else
                                <div style="margin-bottom: 10px; color: red;">Không có dữ liệu</div>
                            @endif
                        </div>
                    </div>
                @else
                    <div style="margin-bottom: 10px; color: red;">Lỗi dữ liệu</div>
                @endif

            </div>
            <div class="clearfix"></div>
        </div>
        <script>
            $(document).ready(function () {
                $(".btn-insert").click(function () {
                    $(this).prop('disabled', true);
                    $(".bg_ptr").css('display', 'block');
                    $(".btn-insert").hide();
                    $(".number-record").hide();
                    total = $('.progress').length;
                    process(0, total);
                });
            });


            function process(index, total) {
                itemProgress = $('.progress').eq(index);
                var url = "{{url('process_import_ds_tiendo')}}";
                var token = '{{ csrf_token() }}';
                $.post(url, {
                    index: index,
                    total: total,
                    donvichutri: itemProgress.data('donvichutri'),
                    content: itemProgress.data('content'),
                    note: itemProgress.data('note'),
                    status: itemProgress.data('status'),
                    minhchung: itemProgress.data('minhchung'),
                    thang: itemProgress.data('thang'),
                    quy: itemProgress.data('quy'),
                    loai: itemProgress.data('loai'),
                    user_nhap: itemProgress.data('user_nhap'),
                    _token: token
                }, function (data) {

                    nextIndex = data.next_index;
                    percent = data.percent;
                    total = data.total;
                    if (nextIndex < total) {
                        $('.progress-bar').css('width', percent + '%');
                        $("#offset").html(nextIndex);
                        $("#total").html(total);
                        $('.dr_').html((percent) + '%.').show('fast', function () {
                            process(nextIndex, total);
                        });
                    } else {
                        $('.progress-bar').css('width', '100%');
                        $('.percent_').css({width: '100%'});
                        $('.dr_').html('Hoàn thành');
                        $("#offset").html(total);
                        $("#total").html(total);
                        $(".progress-status").hide();
                        $(".btn-done").show();
                    }

                }, 'json');
            }
            function goBack() {
                window.history.back()
            }
        </script>
@endsection