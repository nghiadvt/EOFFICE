@extends(config('app.interface').'templates.lanhdao')
@section('main')

@php
    $user = (object) session('user');
@endphp

<style>
    .col-time-edit {
        color: blue;
    }
</style>
<div class="container container-list">
    @include('flash::message')
    <div class="row">
        <div class="row">
            <h3 class="col-md-9 text-left">{{ $user->duyetlichtuan? 'Duyệt thông tin đăng ký lịch tuần' : 'Thông tin đăng ký lịch tuần' }}</h3>
            <div class="col-md-3 text-right" style="margin-top: 15px">
                <a class="btn btn-primary" style="margin-bottom: 15px;" href="{{ route('phonghop.dangkylichtuan') }}"><i class="fa fa-pencil-square-o"></i> Đăng ký lịch tuần</a>
                <a class="btn btn-primary" style="margin-bottom: 15px;" href="javascript:;" onclick="xuatWord()"><i class="fa fa-file-word-o"></i> Tải về</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form class="form-filter" method="GET" action="{{ route('phonghop.danhsachdangkylichtuan') }}">
                    <div class="form-item">
                        <span class="form-item-l">Loại</span>
                        <div class="form-item-c">
                            @php $type = isset($_GET['type'])? $_GET['type'] : '' @endphp
                            <select name="type" class="form-control" id="type">
                                <option value="">Tất cả</option>
                                <option value="1" {{ $type == 1? 'selected' : '' }}>ĐHĐN</option>
                                <option value="2" {{ $type == 2? 'selected' : '' }}>Cơ quan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-item">
                        <span class="form-item-l">Trạng thái</span>
                        <div class="form-item-c">
                            @php $status = isset($_GET['status'])? $_GET['status'] : '' @endphp
                            <select name="status" class="form-control" id="status">
                                <option value="">Tất cả</option>
                                <option value="0" {{ $status === '0'? 'selected' : '' }}>Chưa duyệt</option>
                                <option value="1" {{ $status === '1'? 'selected' : '' }}>Đã duyệt</option>
                                <option value="2" {{ $status === '2'? 'selected' : '' }}>Không duyệt</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-item">
{{--                        <span class="form-item-l">Tuần: {{$weekInYear+ ($dataWeekOfYear->difference + 1)}} </span>--}}
                        <span class="form-item-l">Tuần: {{ $weekInYear > '30' ? ($weekInYear - 30) : ($dataWeekOfYear->difference + $weekInYear) }} </span>
                        <input type="hidden" id="difference" value="{{ $dataWeekOfYear->difference }}" />
                        <div class="form-item-c">
                            @php $date = isset($_GET['date'])? $_GET['date'] : date('Y-m-d'); @endphp
                            <input id="DateInput" type="hidden" name="date" value="{{ $date }}">
                            <input id="weeklyDatePicker" type="text" class="form-control" name="week" value="" style="width: 245px;">

                        </div>
                    </div>
                    <div class="form-item">
                        <div class="form-item-c">
                            @php $trungLich = isset($_GET['trung_lich'])? $_GET['trung_lich'] : '' @endphp
                            <select name="trung_lich" id="trung_lich" class="form-control">
                                <option value="">Tất cả</option>
                                <option value="1" {{ $trungLich === '1'? 'selected' : '' }}>Trùng lịch</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-item">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>

        @if ($type === '' || $type === '1')
            <div>
{{--                <h4 class="text-center">Lịch tuần Đại học Đà Nẵng - Tuần {{ $weekInYear+($dataWeekOfYear->difference +1) }}</h4>--}}
                <h4 class="text-center">Lịch tuần Đại học Đà Nẵng - Tuần {{ $weekInYear > '30' ? ($weekInYear - 30) : ($dataWeekOfYear->difference + $weekInYear) }}</h4>
            </div>

            <table class="table table-bordered" style="margin-bottom: 50px;">
                <thead class="head-table">
                    <tr>
                        <th class="col-stt">STT</th>
                        <th style="width: 150px;">Người đăng ký</th>
                        <th class="text-center" style="width: 100px;">Ngày</th>
                        <th class="text-center" style="width: 80px;">Giờ</th>
                        <th>Nội dung</th>
                        <th>Thành phần</th>
                        <th>Địa điểm</th>
                        <th>Chủ trì</th>
                        <th>Lần sửa cuối</th>
                        <th>Trạng thái</th>
                        @if ($user->duyetlichtuan)
                            <th></th>
                            <th></th>
                        @endif
                        <th>Sửa</th>
                        <th>Huỷ</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($dataDHDN) && sizeof($dataDHDN))
                    @php $stt = 1 @endphp
                    @foreach ($dataDHDN as $val)
                        <tr class="{{ $val->trung_lich? 'trung-lich' : '' }}">
                            <td class="col-stt">{{ $stt++ }}</td>
                            <td>
                                <span>{{ $val->creator? $val->creator->fullname : '' }}</span><br>
                                <span style="font-size: 11.5px;font-style: italic;">{{ $val->created_at }}</span>
                            </td>
                            <td class="text-center">{!! $val->ngay !!}</td>
                            <td class="text-center">{{ $val->gio }}</td>
                            <td>{!! nl2br($val->noidung) !!}</td>
                            <td>{!! nl2br($val->thanhphan) !!}</td>
                            <td>{{ (isset($val->phonghop) && $val->phonghop)? $val->phonghop->tenphonghop : $val->diadiem }}</td>
                            <td>{{ $val->chutriId != '' ? ($val->chucdanh == 'Giám đốc' ? 'Giám đốc ĐHĐN' : 'PGĐ ĐHĐN'. $val->tenchutri )  : $val->chutri}}</td>
                            <td class="col-time-edit">{{ $val->thoigiansuaView }}</td>
                            <td>
                                @if ($val->status == 0)
                                    <span class="label label-default">Chưa duyệt</span>
                                @elseif ($val->status == 1)
                                    <span class="label label-success">Đã duyệt</span>
                                @elseif ($val->status == 2)
                                    <span class="label label-danger">Không duyệt</span>
                                @endif
                            </td>
                            @if ($user->duyetlichtuan)
                                <td class="col-stt">
                                    <span style="padding:5px 10px"><a href="javascript:;" onclick="duyetPhong({{$val->id}}, 1)" title="Duyệt lịch tuần"><i class="fa fa-check-circle green"></i></a></span>
                                </td>
                                <td class="col-stt">
                                    <span style="padding:5px 10px"><a href="javascript:;" onclick="duyetPhong({{$val->id}}, 2)" title="Hủy lịch tuần"><i class="fa fa-exclamation-triangle red"></i></a></span>
                                </td>
                            @endif
                            <td class="col-stt">
                                @if ($user->duyetlichtuan || $val->creator->id == $user->id)
                                    <span style="padding:5px 10px"><a href="{{ route('editdangkylichtuan', [$val->id]) }}" title="Sửa đăng ký"><i class="fa fa-edit"></i></a></span>
                                @endif
                            </td>
                            <td class="col-stt">
                                @if ($user->duyetlichtuan || $val->creator->id == $user->id)
                                <span style="padding:5px 10px;cursor: pointer;"><a onclick="thuHoiLichTuan({{$val->id}})" title="Huỷ đăng kí"><i class="text-danger fa fa-window-close-o"> </i></a></span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        @if ($user->duyetlichtuan)
                            <td colspan="11" align="center"><i>Không có dữ liệu</i></td>
                        @else
                            <td colspan="11" align="center"><i>Không có dữ liệu</i></td>
                        @endif
                    </tr>
                @endif
                </tbody>
            </table>
        @endif

        @if ($type === '' || $type === '2')
            <div>
{{--                <h4 class="text-center">Lịch tuần Cơ quan - Tuần {{ $weekInYear+ ($dataWeekOfYear->difference +1)}}</h4>--}}
                <h4 class="text-center">Lịch tuần Cơ quan - Tuần {{ $weekInYear > '30' ? ($weekInYear - 30) : ($dataWeekOfYear->difference + $weekInYear) }}</h4>
            </div>

            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th class="col-stt">STT</th>
                        <th style="width: 150px;">Người đăng ký</th>
                        <th class="text-center" style="width: 100px;">Ngày</th>
                        <th class="text-center" style="width: 80px;">Giờ</th>
                        <th>Nội dung</th>
                        <th>Thành phần</th>
                        <th>Địa điểm</th>
                        <th>Chủ trì</th>
                        <th>Lần sửa cuối</th>
                        <th>Trạng thái</th>
                        @if ($user->duyetlichtuan)
                            <th></th>
                            <th></th>
                        @endif
                        <th>Sửa</th>
                        <th>Huỷ</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($dataCoquan) && sizeof($dataCoquan))
                    @php $stt = 1 @endphp
                    @foreach ($dataCoquan as $val)
                        <tr class="{{ $val->trung_lich? 'trung-lich' : '' }}">
                            <td class="col-stt">{{ $stt++ }}</td>
                            <td>
                                <span>{{ $val->creator? $val->creator->fullname : '' }}</span><br>
                                <span style="font-size: 11.5px;font-style: italic;">{{ $val->created_at }}</span>
                            </td>
                            <td class="text-center">{!! $val->ngay !!}</td>
                            <td class="text-center">{{ $val->gio }}</td>
                            <td>{!! nl2br($val->noidung) !!}</td>
                            <td>{!! nl2br($val->thanhphan) !!}</td>
                            <td>{{ (isset($val->phonghop) && $val->phonghop)? $val->phonghop->tenphonghop : $val->diadiem }}</td>
                            <td>{{ $val->chutriId != '' ? ($val->chucdanh == 'Giám đốc' ? 'Giám đốc ĐHĐN' :'PGĐ ĐHĐN' . $val->tenchutri )  : $val->chutri}}</td>
                            <td class="col-time-edit">{{ $val->thoigiansuaView }}</td>
                            <td>
                                @if ($val->status == 0)
                                    <span class="label label-default">Chưa duyệt</span>
                                @elseif ($val->status == 1)
                                    <span class="label label-success">Đã duyệt</span>
                                @elseif ($val->status == 2)
                                    <span class="label label-danger">Không duyệt</span>
                                @endif
                            </td>
                            @if ($user->duyetlichtuan)
                                <td class="col-stt">
                                    <span style="padding:5px 10px"><a href="javascript:;" onclick="duyetPhong({{$val->id}}, 1)" title="Duyệt lịch tuần"><i class="fa fa-check-circle green"></i></a></span>
                                </td>
                                <td class="col-stt">
                                    <span style="padding:5px 10px"><a href="javascript:;" onclick="duyetPhong({{$val->id}}, 2)" title="Hủy lịch tuần"><i class="fa fa-exclamation-triangle red"></i></a></span>
                                </td>
                            @endif
                            
                            <td class="col-stt">
                                @if ($user->duyetlichtuan || $val->creator->id == $user->id)
                                    <span style="padding:5px 10px"><a href="{{ route('editdangkylichtuan', [$val->id]) }}" title="Sửa đăng ký"><i class="fa fa-edit"></i></a></span>
                                @endif
                            </td>
                            <td class="col-stt">
                                    <span style="padding:5px 10px"><a href="#" title="Huỷ đăng kí"><i class="fa fa-window-close-o text-danger"></i></a></span>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        @if ($user->duyetlichtuan)
                            <td colspan="11" align="center"><i>Không có dữ liệu</i></td>
                        @else
                            <td colspan="11" align="center"><i>Không có dữ liệu</i></td>
                        @endif
                    </tr>
                @endif
                </tbody>
            </table>
        @endif
    </div>
</div>

<style>
    .bootstrap-datetimepicker-widget tr:hover {
        background-color: #ccc;
    }
    .bootstrap-datetimepicker-widget table td.day:hover {
        border-radius: 0;
    }
</style>

<script>
    // week picker

    var dd = moment('{{$date}}', "YYYY-MM-DD").format('DD/MM/YYYY');
    console.log(dd);
        $("#weeklyDatePicker").datetimepicker({
            calendarWeeks : true,
            format: 'DD/MM/YYYY',
            locale: 'vi',
            daysOfWeekDisabled: [0]
        });

        setTuanForCalendar(dd);

         $('#weeklyDatePicker').on('dp.change', function (e) {
             setTuanForCalendar(e.date);
         });

        function setTuanForCalendar(value) {
            let difference = parseInt($('#difference').val());
            let week = parseInt(moment(value, "DD/MM/YYYY").week());
            $('#numberWeek').html(difference+week);
            let firstDate = moment(value, "DD/MM/YYYY").day(1).format("DD/MM/YYYY");
            let lastDate =  moment(value, "DD/MM/YYYY").day(7).format("DD/MM/YYYY");
            $("#weeklyDatePicker").val(`${firstDate} - ${lastDate}`);
            $("#DateInput").val(moment(firstDate, "DD/MM/YYYY").format("YYYY-MM-DD"));
        }




    function xuatWord() {
        let url = "{{ route('phonghop.danhsachdangkylichtuan') }}";
        let params = <?php echo json_encode($_GET) ?>;
        let date = $("#DateInput").val();
        let type =$("#type").val();
        let status = $("#status").val();
        let trung_lich = $("#trung_lich").val();       ;
        location.href = url+'?type='+type+'&status='+status+'&date='+date+'&trung_lich='+trung_lich+'&export_word=1';
    }
    
    function duyetPhong(id, status) {
        let message = 'Bạn có muốn duyệt lịch tuần này?';
        if (status == 2) {
            message = 'Bạn có muốn hủy lịch tuần này?';
        }

        jConfirm(message, 'Thông báo', function(r) {
            if (r == true) {
                let url = "{{ route('phonghop.duyetdangkylichtuan') }}";
                let token = '{{ csrf_token() }}';

                loading_show();
                $.post(url, {id:id, status:status, _token:token}, function(data) {
                    location.reload(true);
                },'json');
            }
        });
    }
    function thuHoiLichTuan(id) {
            jConfirm('Bạn có muốn thu hồi lịch đăng kí này?', 'Thông báo', function (r) {
                if (r) {
                    loading_show();

                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.post("{{ route('phonghop.thuhoilichtuan') }}", {id:[id], _token:CSRF_TOKEN}, () => {
                       location.reload();
                    }, 'json');
                }
            });
        }

</script>
@endsection
