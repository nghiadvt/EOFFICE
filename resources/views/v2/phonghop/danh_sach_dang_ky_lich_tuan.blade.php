@extends(config('app.interface') . 'templates.lanhdao')
@section('title', 'Danh sách văn bản đến')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/v2/dang_ky_lich_tuan.css') }}">
@endsection

@php
    $user = (object) session('user');
    // dd($user);
@endphp

@section('content')
    <div class="container-flud income-pages mx-0  col-md-12">
        <!-- Link and search bar -->
        <div class="row group-function mx-0 col-md-12">
            <div class="col-md-8 offset-sx-12 breadcrumbs mx-0 px-0">
                <div class="breadcrumbs-link">
                    <div><a href="" class="txt-link">Điều hành tác nghiệp</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">Đăng ký lịch tuần</a></div>
                </div>
                <div class="title-page">Thông tin đăng ký lịch tuần</div>
            </div>
            <div class="col-md-4 col-sx-12  mx-0 px-0 d-flex justify-content-end">
                <a type="button" href="{{ route('phonghop.dangkylichtuan') }}" class="btn btn-primary me-1">Đăng ký lịch
                    tuần</a>
                <a type="button" class="btn btn-primary" href="javascript:;" onclick="xuatWord()"><i
                        class="fa fa-file-word-o"></i> Tải về</a>
                {{-- <div class="btn btn-primary" id="btn-filter-form"><img src="{{asset('img/assets/icon/icon-filter.svg')}}" class="icon"><span class="txt-hidden">Lọc</span></div> --}}
            </div>
        </div>
        <div class="row group-function mx-0 search-form">
            <div class="col-md-12">
                <form class="form-filter" method="GET" action="{{ route('phonghop.danhsachdangkylichtuan') }}">
                    <div class="form-item">
                        <span class="form-item-l">Loại</span>
                        <div class="form-item-c">
                            <?php $type = isset($_GET['type']) ? $_GET['type'] : ''; ?>
                            <select name="type" class="form-control" id="type">
                                <option value="">Tất cả</option>
                                <option value="1" {{ $type == 1 ? 'selected' : '' }}>ĐHĐN</option>
                                <option value="2" {{ $type == 2 ? 'selected' : '' }}>Cơ quan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-item">
                        <span class="form-item-l">Trạng thái</span>
                        <div class="form-item-c">
                            @php $status = isset($_GET['status'])? $_GET['status'] : '' @endphp
                            <select name="status" class="form-control" id="status">
                                <option value="">Tất cả</option>
                                <option value="0" {{ $status === '0' ? 'selected' : '' }}>Chưa duyệt</option>
                                <option value="1" {{ $status === '1' ? 'selected' : '' }}>Đã duyệt</option>
                                <option value="2" {{ $status === '2' ? 'selected' : '' }}>Không duyệt</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-item">
                        {{--                        <span class="form-item-l">Tuần: {{$weekInYear+ ($dataWeekOfYear->difference + 1)}} </span> --}}
                        <span class="form-item-l">Tuần:
                            {{ $weekInYear > '30' ? $weekInYear - 30 : $dataWeekOfYear->difference + $weekInYear }}
                        </span>
                        <input type="hidden" id="difference" value="{{ $dataWeekOfYear->difference }}" />
                        <div class="form-item-c " style="position: relative">
                            @php $date = isset($_GET['date'])? $_GET['date'] : date('Y-m-d'); @endphp
                            <input id="DateInput" type="hidden" name="date" value="{{ $date }}">
                            <input id="weeklyDatePicker" type="text" class="form-control" name="week" value=""
                                style="width: 245px;">
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="form-item-c">
                            @php $trungLich = isset($_GET['trung_lich'])? $_GET['trung_lich'] : '' @endphp
                            <select name="trung_lich" id="trung_lich" class="form-control">
                                <option value="">Tất cả</option>
                                <option value="1" {{ $trungLich === '1' ? 'selected' : '' }}>Trùng lịch</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-item">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- lịch tuần đại học đà nẵng --}}
        @if ($type === '' || $type == '1')
            <div>
                <h4 class="text-center">Lịch công tác của lãnh đạo ĐHĐN - Tuần
                    {{ $weekInYear > '30' ? $weekInYear - 30 : $dataWeekOfYear->difference + $weekInYear }}</h4>
            </div>
            <!-- table list document -->
            <div class="row table-list-documents mx-0">
                <table class="table-content">
                    <thead>
                        <tr class="field-title">
                            <th scope="col">STT</th>
                            <th scope="col">Người đăng ký</th>
                            <th scope="col">Ngày</th>
                            <th scope="col">Giờ</th>
                            <th scope="col">Nội dung</th>
                            <th scope="col">Thành phần</th>
                            <th scope="col">Địa điểm</th>
                            <th scope="col">Chủ chì</th>
                            <th scope="col">Lần sửa cuối</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($dataDHDN) && sizeof($dataDHDN))
                            <?php $stt = 1; ?>
                            @foreach ($dataDHDN as $val)
                                <tr class="{{ $val->trung_lich ? 'trung-lich' : '' }}">
                                    <td class="attribute field-num">{{ $stt++ }}</td>
                                    <td class="attribute field-num">
                                        <span>{{ $val->creator ? $val->creator->fullname : '' }}</span>
                                        <span style="font-size: 11.5px;font-style: italic;">{{ $val->created_at }}</span>
                                    </td>
                                    <td class="attribute field-num">
                                        <span>{!! $val->ngay !!}</span>
                                    </td>
                                    <td class="attribute field-num">{{ $val->gio }}</td>
                                    <td class="attribute field-num">{!! nl2br($val->noidung) !!}</td>
                                    <td class="attribute field-num">{!! nl2br($val->thanhphan) !!}</td>
                                    <td class="attribute field-num">
                                        {{ isset($val->phonghop) && $val->phonghop ? $val->phonghop->tenphonghop : $val->diadiem }}
                                    </td>
                                    <td class="attribute field-num">
                                        {{ $val->chutriId != '' ? ($val->chucdanh == 'Giám đốc' ? 'Giám đốc ĐHĐN' : 'PGĐ ĐHĐN' . $val->tenchutri) : $val->chutri }}
                                    </td>
                                    <td class="attribute field-num"> {{ $val->thoigiansuaView }}</td>
                                    <td class="attribute field-num">
                                        {{-- <span class="label label-success status">Đã duyệt</span> --}}

                                        @if ($val->status == 0)
                                            <span class="label label-default">Chưa duyệt</span>
                                        @elseif ($val->status == 1)
                                            <span class="label label-success">Đã duyệt</span>
                                        @elseif ($val->status == 2)
                                            <span class="label label-danger">Không duyệt</span>
                                        @endif
                                    </td>
                                    <td class="attribute field-action" data-name="">
                                        <div class="dropdown">
                                            <button class="btn btn-menu" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <img src="{{ asset('img/assets/icon/menu-ver.svg') }}"
                                                    class="img-action">
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if ($user->duyetlichtuan || $val->creator->id == $user->id)
                                                    <li><a class="dropdown-item edit-item" title="Xóa" href=""
                                                            onclick="thuHoiLichTuan({{ $val->id }})"
                                                            title="Huỷ đăng kí"><i class="fa-solid fa-trash-can"></i>
                                                            Xóa</a></span>
                                                @endif
                                                @if ($user->duyetlichtuan || $val->creator->id == $user->id)
                                                    <li><a href="{{ route('editdangkylichtuan', [$val->id]) }}"
                                                            class="dropdown-item edit-item" title="Sửa"><i
                                                                class="fa-solid fa-pen-to-square"></i></i> Sửa</a></span>
                                                @endif
                                            </ul>
                                        </div>
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
            </div>
        @endif
        <div style="margin-top: 30px">
            @if ($type === '' || $type == '1')
                <div>
                    <h4 class="text-center">Lịch tuần ĐHĐN - Tuần
                        {{ $weekInYear > '30' ? $weekInYear - 30 : $dataWeekOfYear->difference + $weekInYear }}</h4>
                </div>
                <div class="row table-list-documents mx-0">
                    <table class="table-content">
                        <thead>
                            <tr class="field-title">
                                <th scope="col">STT</th>
                                <th scope="col">Người đăng ký</th>
                                <th scope="col">Ngày</th>
                                <th scope="col">Giờ</th>
                                <th scope="col">Nội dung</th>
                                <th scope="col">Thành phần</th>
                                <th scope="col">Địa điểm</th>
                                <th scope="col">Chủ chì</th>
                                <th scope="col">Lần sửa cuối</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $stt = 1;
                            @endphp
                            @if (isset($dataCoquan) && sizeof($dataCoquan))
                                @foreach ($dataCoquan as $val)
                                    <tr class="{{ $val->trung_lich ? 'trung-lich' : '' }}">
                                        <td class="attribute field-num">{{ $stt++ }}</td>
                                        <td class="attribute field-num">
                                            <span>{{ $val->creator ? $val->creator->fullname : '' }}</span>
                                            <span
                                                style="font-size: 11.5px;font-style: italic;">{{ $val->created_at }}</span>
                                        </td>
                                        <td class="attribute field-num">
                                            <span>{!! $val->ngay !!}</span>
                                        </td>
                                        <td class="attribute field-num">{{ $val->gio }}</td>
                                        <td class="attribute field-num">{!! nl2br($val->noidung) !!}</td>
                                        <td class="attribute field-num">{!! nl2br($val->thanhphan) !!}</td>
                                        <td class="attribute field-num">
                                            {{ isset($val->phonghop) && $val->phonghop ? $val->phonghop->tenphonghop : $val->diadiem }}
                                        </td>
                                        <td class="attribute field-num">
                                            {{ $val->chutriId != '' ? ($val->chucdanh == 'Giám đốc' ? 'Giám đốc ĐHĐN' : 'PGĐ ĐHĐN' . $val->tenchutri) : $val->chutri }}
                                        </td>
                                        <td class="attribute field-num"> {{ $val->thoigiansuaView }}</td>
                                        <td class="attribute field-num">
                                            {{-- <span class="label label-success status">Đã duyệt</span> --}}
                                            @if ($val->status == 0)
                                                <span class="label label-default">Chưa duyệt</span>
                                            @elseif ($val->status == 1)
                                                <span class="label label-success">Đã duyệt</span>
                                            @elseif ($val->status == 2)
                                                <span class="label label-danger">Không duyệt</span>
                                            @endif
                                        </td>
                                        <td class="attribute field-action" data-name="">
                                            <div class="dropdown">
                                                <button class="btn btn-menu" type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <img src="{{ asset('img/assets/icon/menu-ver.svg') }}"
                                                        class="img-action">
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @if ($user->duyetlichtuan || $val->creator->id == $user->id)
                                                        <li><a class="dropdown-item edit-item" title="Xóa"
                                                                href=""
                                                                onclick="thuHoiLichTuan({{ $val->id }})"
                                                                title="Huỷ đăng kí"><i class="fa-solid fa-trash-can"></i>
                                                                Xóa</a></span>
                                                    @endif
                                                    @if ($user->duyetlichtuan || $val->creator->id == $user->id)
                                                        <li><a href="{{ route('editdangkylichtuan', [$val->id]) }}"
                                                                class="dropdown-item edit-item" title="Sửa"><i
                                                                    class="fa-solid fa-pen-to-square"></i></i>
                                                                Sửa</a></span>
                                                    @endif
                                                </ul>
                                            </div>
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
                </div>
            @endif
            <!-- Pagination -->
            <div class="row pagination-page mx-0">
                <div class="pagination">
                    {{-- {{$vanbans->links()}} --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var dd = moment('{{ $date }}', "YYYY-MM-DD").format('DD/MM/YYYY');
        console.log(dd);
        $("#weeklyDatePicker").datetimepicker({
            calendarWeeks: true,
            format: 'DD/MM/YYYY',
            locale: 'vi',
            daysOfWeekDisabled: [0]
        });

        setTuanForCalendar(dd);

        $('#weeklyDatePicker').on('dp.change', function(e) {
            setTuanForCalendar(e.date);
        });

        function setTuanForCalendar(value) {
            let difference = parseInt($('#difference').val());
            let week = parseInt(moment(value, "DD/MM/YYYY").week());
            $('#numberWeek').html(difference + week);
            let firstDate = moment(value, "DD/MM/YYYY").day(1).format("DD/MM/YYYY");
            let lastDate = moment(value, "DD/MM/YYYY").day(7).format("DD/MM/YYYY");
            $("#weeklyDatePicker").val(`${firstDate} - ${lastDate}`);
            $("#DateInput").val(moment(firstDate, "DD/MM/YYYY").format("YYYY-MM-DD"));
        }

        function xuatWord() {
            let url = "{{ route('phonghop.danhsachdangkylichtuan') }}";
            let params = @php echo json_encode($_GET); @endphp;
            let date = $("#DateInput").val();
            let type = $("#type").val();
            let status = $("#status").val();
            let trung_lich = $("#trung_lich").val();
            location.href = url + '?type=' + type + '&status=' + status + '&date=' + date + '&trung_lich=' + trung_lich +
                '&export_word=1';
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
                    $.post(url, {
                        id: id,
                        status: status,
                        _token: token
                    }, function(data) {
                        location.reload(true);
                    }, 'json');
                }
            });
        }

        function thuHoiLichTuan(id) {

            // jConfirm('Bạn có muốn thu hồi lịch đăng kí này?', 'Thông báo', function(r) {
            // if (r) {
            // loading_show();
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.post("{{ route('phonghop.thuhoilichtuan') }}", {
                id: [id],
                _token: CSRF_TOKEN,
            }, function() {
                location.reload();
            }, 'json');
        }
    </script>
@endsection
