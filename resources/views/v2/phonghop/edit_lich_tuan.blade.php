@extends(config('app.interface') . 'templates.lanhdao')
@section('title', 'Danh sách văn bản đến')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/v2/dang_ky_lich_tuan.css') }}">
@endsection

@php
    $user = (object) session('user');
@endphp

@section('content')
    <div class="container-flud income-pages mx-0">
        <div class="row group-function mx-0">
            <div class="col-md-10 offset-sx-12 breadcrumbs mx-0 px-0">
                <div class="breadcrumbs-link">
                    <div><a href="" class="txt-link">Điều hành tác nghiệp</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">Thông tin đăng ký lịch tuần</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">Chỉnh sửa đăng ký lịch tuần</a></div>
                </div>
                <div class="title-page">Chỉnh sửa đăng ký lịch tuần</div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 table-bordered" style="margin-top: 20px">
                    <div style="text-align: center; margin-top: 20px">
                        <i><label>Lưu ý:</label> Các trường có dấu <em class="flag-require">*</em> bắt buộc nhập thông
                            tin</i>
                    </div>
                    <form id="FormEdit" class="form" action="{{ route('phonghop.savedangkylichtuan') }}" method="POST"
                        style="margin-top: 20px">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ $lichtuan->id }}">

                        <!-- thông tin lịch -->
                        <div class="form-row">
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label ">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;"
                                            class="label-content">Loại</label>
                                    </div>
                                </label>
                                <div class="col-sm-10">
                                    <div class="radio">
                                        <label><input type="radio" name="type" value="1"
                                                {{ $lichtuan->type == 1 ? 'checked' : '' }}>Lịch công tác của lãnh đạo ĐHĐN</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="type" value="2"
                                                {{ $lichtuan->type == 2 ? 'checked' : '' }}>Lịch tuần ĐHĐN</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">
                                    <div class="col-md-2 label-content" style="text-align: right;">
                                        <label style="padding-top:7px;" >Ngày</label>(<em class="flag-require" style="color: red">*</em> )

                                    </div>
                                </label>
                                <div class="col-sm-10">
            
                                    <input type="text" class="form-control date-picker" name="time"
                                        value="{{ date('d-m-Y', strtotime($lichtuan->time)) }}" id="tungay">

                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">
                                    <div class="col-md-2 label-content" style="text-align: right;">
                                        <label style="padding-top:7px;" >Giờ</label>(<em class="flag-require" style="color: red">*</em> )
                                    </div>
                                </label>
                                <div class="col-sm-10">
            
                                    <input type="text" class="form-control date-picker-gio" name="time_gio"
                                        value="{{ date('H:i', strtotime($lichtuan->time)) }}" id="tugio">

                                </div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">
                                    <div class="col-md-2 label-content" style="text-align: right; ">
                                        <label style="padding-top:7px; text-align: right;">Địa
                                            điểm( </label><em class="flag-require" style="color: red">*</em> )
                                    </div>
                                </label>
                                <div class="col-sm-10">
                                    <div style="display: flex; flex-direction: column-reverse;">
                                        <select class="chosen form-control phonghop_id" name="phonghop_id">
                                            <option value="">Hãy chọn phòng họp</option>
                                            @foreach ($phonghopcoquan as $val)
                                                <option value="{{ $val->id }}"
                                                    {{ $lichtuan->phonghop_id == $val->id ? 'selected' : '' }}>
                                                    {{ $val->tenphonghop }}</option>
                                            @endforeach
                                            <option {{ $lichtuan->phonghop_id == null ? 'selected' : '' }} value="other">
                                                Khác</option>
                                        </select>

                                    </div>
                                    <div class="{{ $lichtuan->phonghop_id == null ? '' : 'hidden' }}"
                                        style="margin-top: 10px">
                                        <input placeholder="Nhập địa điểm khác" type="text" class="form-control"
                                            name="diadiem" value="{{ $lichtuan->diadiem }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;" class="label-content">Nội
                                            dung</label>
                                    </div>
                                </label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="noidung" id="noidung" cols="30" rows="5"
                                        placeholder="Nội dung cuộc họp">{{ $lichtuan->noidung }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">
                                    <div class="col-md-2 label-content" style="text-align: right;">
                                        <label style="padding-top:7px;">Thành phần</label> (<em
                                            class="flag-require" style="color: red">*</em> )
                                    </div>
                                </label>
                                <div class="col-sm-10">

                                    <textarea class="form-control" name="thanhphan" id="thanhphan" cols="30" rows="5"
                                        placeholder="Nhập thành phần tham gia">{{ $lichtuan->thanhphan }}</textarea>

                                </div>
                            </div>
                        </div>



                        <div class="form-row">
                            <div class="mb-3 row">
                                <div class="col-sm-2" style="text-align: right;">
                                    <label style="padding-top:7px;">Chủ trì</label> (<em class="flag-require" style="color:red">*</em> )
                                </div>
                                <div class="col-sm-4">

                                    <select class="chosen form-control chutriId" name="chutriId" id="chutriId">
                                        <option value="">Chọn</option>
                                        @foreach ($banGD as $data)
                                            <option {{ $data['id'] == $lichtuan->chutriId ? 'selected' : '' }}
                                                value="{{ $data['id'] }}">
                                                {{ $data->chucdanh == 'Giám đốc' ? 'Giám đốc ĐHĐN' : 'PGĐ ĐHĐN ' . $data->fullname }}
                                            </option>
                                        @endforeach
                                        <option value="khac">Khác</option>
                                    </select>
                                    <div class="{{ $lichtuan->chutriId == '' ? '' : 'hidden' }}"
                                        style="margin-top: 10px">
                                        <input placeholder="Nhập tên người chủ trì" type="text" class="form-control"
                                            name="chutri" value="{{ $lichtuan->chutri }}" />
                                    </div>
                                </div>
                                <div class="col-sm-2" style="text-align: right;">
                                    <label style="padding-top:7px;">Số người tham gia</label>
                                </div>
                                <div class="col-sm-4">
                                    {{-- <input type="number" class="form-control" name="songuoithamgia" id="songuoithamgia"
                                        min="1" placeholder="Nhập số người tham gia"> --}}
                                    <input type="number" class="form-control" name="songuoithamgia"
                                        value="{{ $lichtuan->songuoithamgia == 0 ? '' : $lichtuan->songuoithamgia }}"
                                        id="songuoithamgia" placeholder="Nhập số người tham gia">

                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 row">

                                <div class="col-sm-2" style="text-align: right;">
                                    <label style="padding-top:7px; text-align: right;">Người đăng ký</label>

                                </div>

                                <div class="col-sm-4">
                                    {{-- <input type="text" class="form-control" name="nguoidangky" id="nguoidangky"
                                        value="{{ $user->fullname }}" placeholder="Nhập tên người đăng ký"> --}}
                                    <input type="text" class="form-control" name="nguoidangky" id="nguoidangky"
                                        value="{{ $lichtuan->nguoidangky }}" placeholder="Nhập tên người đăng ký">

                                </div>

                                <div class="col-sm-2" style="text-align: right;">
                                    <label style="padding-top:7px;">Đơn vị</label>

                                </div>

                                <div class="col-sm-4">
                                    {{-- <input type="text" class="form-control" name="donvi" id="donvi"
                                        value="{{ $donvi->name }}" placeholder="Nhập đơn vị"> --}}
                                    <input type="text" class="form-control" name="donvi" id="donvi"
                                        value="{{ $lichtuan->donvi }}" placeholder="Nhập đơn vị">

                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="mb-3 row">

                                <div class="col-sm-2" style="text-align: right;">
                                    {{-- <label style="padding-top:7px; text-align: right;">Người đăng ký</label> --}}
                                    <label style="padding-top:7px;">Số điện thoại</label>

                                </div>

                                <div class="col-sm-4">
                                    {{-- <input type="text" class="form-control" name="nguoidangky" id="nguoidangky"
									value="{{ $user->fullname }}" placeholder="Nhập tên người đăng ký"> --}}
                                    {{-- <input type="digits" class="form-control" name="sodienthoai" id="sodienthoai"
                                        value="{{ $user->phone }}" autocomplete="off" placeholder="Nhập số điện thoại"> --}}
                                    <input type="digits" class="form-control" name="sodienthoai" id="sodienthoai"
                                        value="{{ $lichtuan->sodienthoai }}" placeholder="Nhập số điện thoại">

                                </div>

                                <div class="col-sm-2" style="text-align: right;">
                                    {{-- <label style="padding-top:7px;">Đơn vị</label> --}}
                                    <label style="padding-top:7px;">Email</label>

                                </div>

                                <div class="col-sm-4">
                                    {{-- <input type="email" class="form-control" name="email" id="email"
                                        value="{{ $user->email }}" placeholder="Nhập Email" autocomplete="off"> --}}
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ $lichtuan->email }}" placeholder="Nhập Email">

                                </div>
                            </div>
                        </div>


                        {{-- </div> --}}

                        <!-- thông tin người đăng ký -->
                        <div class="form-row">
                            <div class="col-md-12 vanban" style="text-align: right; margin-top: 25px;">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" style="margin-bottom: 15px"
                                        href="{{ route('phonghop.dangkylichtuan') }}">
                                        <span class="glyphicon glyphicon-floppy-saved"></span> Lưu thay đổi
                                    </button>
                                    {{-- <a class="btn btn-danger" style="margin-bottom: 15px;"
                                        href="{{ route('phonghop.danhsachphonghop') }}"><i
                                            class="glyphicon glyphicon glyphicon-remove"></i> Thoát</a> --}}
                                    <a class="btn btn-danger" style="margin-bottom: 15px;"
                                        href="{{ route('phonghop.danhsachdangkylichtuan') }}"><i
                                            class="glyphicon glyphicon glyphicon-remove"></i> Thoát</a>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const chosenElements = document.querySelectorAll(".chosen");

            chosenElements.forEach(function(element) {
                new Choices(element, {
                    noResultsText: 'Không tìm thấy kết quả',
                    searchResultLimit: 10,
                });
            });

            $('#FormEdit').validate({
                rules: {
                    phonghop_id: {
                        required: true
                    },
                    diadiem: {
                        required: true
                    },
                    sodienthoai: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    time: {
                        required: true,
                        currentDate: true
                    },
                    noidung: {
                        required: true
                    },
                    chutri: {
                        required: true
                    },
                    thanhphan: {
                        required: true
                    }
                },
                messages: {
                    phonghop_id: {
                        required: "Hãy chọn phòng họp"
                    },
                    diadiem: {
                        required: "Hãy nhập địa điểm"
                    },
                    sodienthoai: {
                        required: "Hãy nhập só điện thoại"
                    },
                    email: {
                        required: "Hãy nhập email"
                    },
                    time: {
                        required: "Hãy nhập thời gian"
                    },
                    noidung: {
                        required: "Hãy nhập nội dung"
                    },
                    chutri: {
                        required: "Hãy nhập người chủ trì"
                    },
                    thanhphan: {
                        required: "Hãy  nhập thành phần tham gia"
                    }
                },
                submitHandler: function(form) {
                    loading_show();
                    form.submit();
                }
            });

            // format ngày đã chọn theo kiểu mm/dd/yyyy
            function formattedDate(string) {
                var dateString = string;
                var parts = dateString.split("-");
                var formattedDate = parts[1] + "/" + parts[0] + "/" + parts[2];

                return formattedDate
            }

            //format ngày hiện tại theo kiểu mm//dd/yyyy
            function currentDateFormat() {
                data = new Date()
                var day = data.getDate().toString().padStart(2, '0');
                var month = (data.getMonth() + 1).toString().padStart(2, '0');
                var year = data.getFullYear();
                var formattedDate = month + '/' + day + '/' + year;

                return formattedDate
            }
            $.validator.addMethod("currentDate", function(value, element) {
                var currentDate = currentDateFormat();
                var startDate = formattedDate(value);

                // Kiểm tra ngày bắt đầu không được nhỏ hơn ngày hiện tại
                return startDate >= currentDate;
            }, "Không thể chọn ngày quá khứ");
        });

        $('.date-picker').datetimepicker({
            format: 'DD-MM-YYYY',
            useCurrent: false
        });
        $('.date-picker-gio').datetimepicker({
            format: 'HH:mm',
            useCurrent: false
        });

        $('select').on('change', function() {
            var other = $("select.phonghop_id").val();
            if (other === 'other') {
                $('input[name="diadiem"]').attr('disabled', false).closest('div').removeClass('hidden')
            } else {
                $('input[name="diadiem"]').attr('disabled', false).closest('div').addClass('hidden')
            }

        });
        $('select.chutriId').on('change', function() {
            var khac = $("select.chutriId").val();

            if (khac === 'khac') {
                $('input[name="chutri"]').attr('disabled', false).closest('div').removeClass('hidden')
            } else {
                $('input[name="chutri"]').attr('disabled', false).closest('div').addClass('hidden')
            }

        });
    </script>

@endsection
