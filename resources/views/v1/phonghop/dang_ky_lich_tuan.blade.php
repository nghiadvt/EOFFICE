@extends(config('app.interface').'templates.lanhdao')
@section('main')

    @php
        $user = (object) session('user');
        $donvi = App\Models\Donvi::find($user->donvi_id);
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="title-text">Đăng ký lịch tuần</h3>
            </div>
            <div class="col-sm-12 table-bordered" style="margin-top: 20px">
                <div style="text-align: center; margin-top: 20px">
                    <i><label>Lưu ý:</label> Các trường có dấu <em class="flag-require">*</em> bắt buộc nhập thông
                        tin</i>
                </div>
                <form id="FormDangKy" class="form" action="{{ route('phonghop.savedangkylichtuan') }}" method="POST"
                      style="margin-top: 20px">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <!-- thông tin lịch -->
                    <div class="form-row">
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;">Loại</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="radio">
                                            <label><input type="radio" name="type" value="1" checked>Lịch công tác của lãnh đạo
                                                ĐHĐN</label>
                                        </div>
                                        <div class="radio">
                                            <label><input type="radio" name="type" value="2">Lịch tuần ĐHĐN</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:7px;">Thời gian</label><em class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control date-picker" autocomplete="off" name="time" id="tungay">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:7px; text-align: right;">Địa điểm</label><em
                                                class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-10">

                                        <div style="display: flex; flex-direction: column-reverse;">
                                            <select class="chosen form-control phonghop_id" name="phonghop_id">

                                                @foreach ($phonghopcoquan as $cq)
                                                    <option value="{{ $cq->id }}">{{ $cq->tenphonghop }}</option>
                                                @endforeach
                                                <option value="other">Khác</option>
                                            </select>

                                        </div>
                                        <div class="hidden" style="margin-top: 10px">
                                            <input placeholder="Nhập địa điểm khác" type="text" class="form-control" name="diadiem"/>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:7px;">Nội dung</label><em class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="noidung" id="noidung" cols="30" rows="5"
                                                  placeholder="Nội dung cuộc họp"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:7px;">Thành phần</label><em
                                                class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="thanhphan" id="thanhphan" cols="30"
                                                  rows="5" placeholder="Nhập thành phần tham gia"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:7px;">Chủ trì</label><em class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-4">

                                        <select class="chosen form-control chutriId" name="chutriId" id="chutriId">
                                            <option value="">Chọn</option>
                                            @foreach ($banGD as $data)
                                                <option value="{{ $data->id }}">{{ $data->chucdanh == 'Giám đốc' ? 'Giám đốc ĐHĐN': 'PGĐ ĐHĐN '. $data->fullname }}</option>
                                            @endforeach
                                            <option value="khac">Khác</option>
                                        </select>
                                        <div class="hidden" style="margin-top: 10px">
                                            <input placeholder="Nhập tên người chủ trì" type="text" class="form-control" name="chutri"/>
                                        </div>
                                    </div>

                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:7px;">Số người tham gia</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" name="songuoithamgia"
                                               id="songuoithamgia" min="1" placeholder="Nhập số người tham gia">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- thông tin người đăng ký -->
                    <div class="form-row">
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:7px; text-align: right;">Người đăng ký</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="nguoidangky" id="nguoidangky"
                                               value="{{ $user->fullname }}" placeholder="Nhập tên người đăng ký">
                                    </div>
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:7px;">Đơn vị</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="donvi" id="donvi"
                                               value="{{ $donvi->name }}" placeholder="Nhập đơn vị">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:7px;">Số điện thoại</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="digits" class="form-control" name="sodienthoai" id="sodienthoai"
                                               value="{{ $user->phone }}" autocomplete="off" placeholder="Nhập số điện thoại">
                                    </div>
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:7px;">Email</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="email" class="form-control" name="email" id="email"
                                               value="{{ $user->email }}" placeholder="Nhập Email" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 vanban" style="text-align: right; margin-top: 25px;">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" style="margin-bottom: 15px"
                                        href="{{ route('phonghop.dangkylichtuan') }}">
                                    <span class="glyphicon glyphicon-floppy-saved"></span> Thêm mới
                                </button>
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
    <script>
        $(document).ready(function () {
            $('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', width: '100%', search_contains: true});

            $('#FormDangKy').validate({
                rules: {
                    phonghop_id: {
                        required: true
                    },
                    diadiem: {
                        required: true
                    },

                    // sodienthoai: {
                    //     required: true
                    // },
                    // email: {
                    //     required: true
                    // },
                    time: {
                        required: true,
                        currentDate:true
                    },
                    noidung: {
                        required: true
                    },
                    chutri: {
                        required: true
                    },
                    chutriId: {
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
                        required: "Hãy chọn phòng họp"
                    },

                    // sodienthoai: {
                    //     required: "Hãy nhập só điện thoại"
                    // },
                    // email: {
                    //     required: "Hãy nhập email"
                    // },
                    time: {
                        required: "Hãy nhập thời gian",
                        currentDate:"Không thể chọn ngày quá khứ"
                    },
                    noidung: {
                        required: "Hãy nhập nội dung"
                    },
                    chutri: {
                        required: "Hãy nhập người chủ trì"
                    }, chutriId: {
                        required: "Chọn người chủ trì"
                    },
                    thanhphan: {
                        required: "Hãy  nhập thành phần tham gia"
                    }
                },
                submitHandler: function (form) {
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
            format: 'DD-MM-YYYY HH:mm',
            useCurrent: false
        });

        // $('input[name="type"]').click(function () {
        //     if ($(this).val() == 1) {
        //         $('select[name="phonghop_id"]').attr('disabled', true).closest('div').addClass('hidden');
        //
        //     } else {
        //         $('select[name="diadiem"]').attr('disabled', true).closest('div').addClass('hidden');
        //        $('select[name="phonghop_id"]').attr('disabled', false).closest('div').removeClass('hidden');
        //     }
        //
        //     $('select[name="phonghop_id"]').trigger("chosen:updated");
        // });
        $('select').on('change', function() {
            var other = $( "select.phonghop_id" ).val();

            if(other === 'other'){
                $('input[name="diadiem"]').attr('disabled', false).closest('div').removeClass('hidden')
            }else {
                $('input[name="diadiem"]').attr('disabled', false).closest('div').addClass('hidden')
            }

        });
        $('select.chutriId').on('change', function() {
            var khac = $( "select.chutriId" ).val();

            if(khac === 'khac'){
                $('input[name="chutri"]').attr('disabled', false).closest('div').removeClass('hidden')
            }else {
                $('input[name="chutri"]').attr('disabled', false).closest('div').addClass('hidden')
            }

        });
    </script>
@endsection
