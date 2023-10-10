@extends(config('app.interface') . 'templates.layout')
@section('title', 'Nhập văn bản nội bộ')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/v2/enter.css') }}">
@endsection
@section('content')
    <div class="container-flud body-content mx-0">
        <div class="col-md-8 offset-sx-12 breadcrumbs mx-0 px-0">
            <div class="breadcrumbs-link">
                <div><a href="" class="txt-link">Điều hành tác nghiệp</a></div>
                <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                <div><a href="" class="txt-link">Văn bản nội bộ</a></div>
                <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                <div><a href="" class="txt-link">Ban hành văn bản nội bộ</a></div>
            </div>
        </div>
        <!-- Content form -->
        <div class="row content-decree-document mx-0">
            <h4>Ban hành văn bản nội bộ</h4>
            <form action="{{ url('vanbannoibo/luu-nhap') }}" method="POST" enctype="multipart/form-data"
                id="FormNhapVBDen">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="book_id" value="4">
                <div class="row">
                    <div class="col-md-12 col-sx-12 form-item-c">
                        <label class="label">Tiêu đề <em class="required">*</em></label>
                        <textarea class="form-control mx-0" name="title" id="name" rows="3"
                            placeholder="Nhập tiêu đề văn bản ban hành"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sx-12" style="display: flex; flex-direction: column;">
                        <label class="label">Loại văn bản <em class="required">*</em></label>
                        <select  name="loaivanban_id" id="loaivanban" style="height: 39px;  border-radius: 7px; border-color: gainsboro; ">
                            <option value="" style="color: gray;">Chọn loại văn bản</option>
                            @foreach ($loaivanbans as $loaivanban)
                                <option value="{{ $loaivanban->id }}" {{ $loaivanban->id == 18 ? 'selected' : '' }}>
                                    {{ $loaivanban->name }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Số ký hiệu <em class="required">*</em></label>
                        <input type="text" class="form-control" name="kyhieu" id="kyhieu"
                            placeholder="Nhập số ký hiệu">
                    </div>
                    <div class="col-md-4 col-sx-12">
                        <label class="label ">Ngày ban hành <em class="required">*</em></label>
                        <input type="text" name="ngayden" id="startngayden" autocomplete="off" class="form-control" placeholder="Ngày - Tháng - Năm">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Cơ quan ban hành</label>
                        <input type="text" class="form-control" name="cq_banhanh" placeholder="Nhập cơ quan ban hành">
                    </div>
                    <div class="col-md-4 col-sx-12" style="display: flex; flex-direction: column;">
                        <label class="label">Lĩnh vực</label>
                        <select  name="linhvuc_id" style="height: 39px;  border-radius: 7px; border-color: gainsboro;">
                            <option value=""  style="color: gray;">Chọn lĩnh vực</option>
                            @foreach ($linhvucs as $linhvuc)
                                <option value="{{ $linhvuc->id }}">{{ $linhvuc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Hạn xử lý</label>
                        <input type="text" name="hanxuly" id="hanxuly" autocomplete="off" class="form-control"  placeholder="Ngày - Tháng - Năm">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sx-12" style="display: flex; flex-direction: column;">
                        <label class="label">Độ khẩn</label>
                        <select  name="urgency" id="urgency" style="height: 39px;  border-radius: 7px; border-color: gainsboro;">
                            @for ($i=1;$i <= $countcombo; $i++)
                                <option value="{{$i}}">{{$combobox[$i]}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Ngày ký</label>
                        <input type="text" name="ngayky" id="ngayky" autocomplete="off" class="form-control" placeholder="Ngày - Tháng - Năm">
                    </div>
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Người ký</label>
                        <input type="text" class="form-control" name="nguoiky" placeholder="Nhập tên người ký">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sx-12">
                        <label class="label">Ghi chú</label>
                        <textarea class="form-control mx-0" name="note" id="note" cols="30" rows="5"
                            placeholder="Nhập ghi chú văn bản ban hành"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="label">File đính kèm (Nhấn Ctrl để chọn nhiều file) <em
                                class="required">*</em></label>
                    </div>
                    <div class="form-item-c">
                        <div class="row">
                            <div data-maxsize="20" id="multi-file-upload"></div>
                        </div>
                    </div>
                </div>

                <!-- Related to document -->
                <div class="row">
                    <div class="col-md-6 col-sx-12">
                        <!-- đơn vị chủ trì -->
                        <div style="margin-bottom: 15px;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <label class="label">Đơn vị chủ trì <em class="required">*</em></label>
                                    <label class="label"><input type="checkbox" value="1" name="not_have_chutri">
                                        Không có người chủ trì</label>
                                </div>
                                <div class="form-item-c" style="display: flex; flex-direction: column-reverse;">
                                    <select  name="donvi_id" style="height: 39px;  border-radius: 7px; border-color: gainsboro; ">
                                        <option value="">Chọn đơn vị chủ trì</option>
                                        @foreach ($bookDetails as $val)
                                            <option value="{{ $val->donvi->id }}">{{ $val->donvi->name }}</option>
                                        @endforeach
                                    </select>
                                </div>                            
                            </div>
                        </div>

                        <!-- Người chủ trì -->
                        <div>
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p><b>Người chủ trì:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <div id="UserChutriContainer">Không có dữ liệu</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sx-12">
                        <!-- đơn vị phối hợp -->
                        <div style="margin-bottom: 15px;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <label class="label">Đơn vị phối hợp</label>
                                </div>
                                <div class="form-item-c" style="display: flex; flex-direction: column-reverse;">
                                    <select class="form-control chosen" name="donvi_phoihop_ids[]" multiple>
                                        @foreach ($bookDetails as $val)
                                            <option value="{{ $val->donvi->id }}">{{ $val->donvi->name }}</option>
                                        @endforeach
                                    </select>                                  
                                </div>
                            </div>
                        </div>

                        <!-- Người phối hợp -->
                        <div>
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p><b>Người phối hợp:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <div id="UserPhoihopContainer">Không có dữ liệu</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-default btn-primary">Gửi văn bản</button>
                </div>
            </form>
        </div>
    </div>
@stop
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/v2/enter.js') }}"></script>
    <script>
        $(function () {
            $.datepicker.regional['vi'] = {
        closeText: 'Đóng',
        prevText: '&#x3C;Trước',
        nextText: 'Tiếp&#x3E;',
        currentText: 'Hôm nay',
        monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
        monthNamesShort: ['Thg 1', 'Thg 2', 'Thg 3', 'Thg 4', 'Thg 5', 'Thg 6', 'Thg 7', 'Thg 8', 'Thg 9', 'Thg 10', 'Thg 11', 'Thg 12'],
        dayNames: ['Chủ Nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
        dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        weekHeader: 'Tuần',
        dateFormat: 'dd-mm-yy',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $('#startngayden').datepicker($.datepicker.regional['vi']);
    $('#hanxuly').datepicker($.datepicker.regional['vi']);
    $('#ngayky').datepicker($.datepicker.regional['vi']);
        });
        // Check all checkbox unit
        $(document).on('click', '.check-all', function() {
            $group = $(this).closest('.checkbox-group');

            if ($(this).is(':checked')) {
                $group.find('.checkbox-c input:enabled').prop('checked', true);
            } else {
                $group.find('.checkbox-c input:enabled').prop('checked', false);
            }
        });
        $.fn.serializeObject = function() {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function() {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
        // form validate
        $('#FormNhapVBDen').validate({
            ignore: [],
            rules: {
                title: {
                    required: true
                },
                loaivanban_id: {
                    required: true
                },
                kyhieu: {
                    required: true
                },
                ngayden: {
                    required: true
                },
                soden: {
                    required: true,
                    remote: {
                        url: "{{ url('check_number_van_ban_trong_ngay') }}",
                        type: "post",
                        data: {
                            _token: function() {
                                return $('meta[name="csrf-token"]').attr('content');
                            },
                            number: function() {
                                return $('input[name="soden"]').val();
                            },
                            date: function() {
                                return $('input[name="ngayden"]').val();
                            }
                        }
                    }
                },
                donvi_id: {
                    required: true
                },
                'files[]': {
                    required: true
                }
            },
            messages: {
                title: {
                    required: "Hãy nhập tiêu đề văn bản"
                },
                loaivanban_id: {
                    required: "Hãy chọn loại văn bản"
                },
                ngayden: {
                    required: "Hãy chọn ngày ban hành"
                },
                kyhieu: {
                    required: "Hãy nhập số ký hiệu"
                },
                soden: {
                    required: "Hãy nhập số đến"
                },
                donvi_id: {
                    required: "Hãy chọn đơn vị chủ trì"
                },
                'files[]': {
                    required: "Hãy chọn file đính kèm"
                }
            },
            submitHandler: function(form) {
                let formData = $('#FormNhapVBDen').serializeObject();

                if ($('input[name="not_have_chutri"]').is(':checked')) {
                    if (!formData['user_phoihop_ids[]'] || !formData['user_phoihop_ids[]'].length) {
                        jAlert('Hãy chọn người phối hợp', 'Thông báo');
                        return false;
                    }
                } else {
                    if (!formData['user_chutri_ids[]'] || !formData['user_chutri_ids[]'].length) {
                        jAlert('Hãy chọn người chủ trì', 'Thông báo');
                        return false;
                    }
                }

                loading_show();
                form.submit();
            }
        });

        $('input[name="ngayden"]').change(function() {
            $("#FormNhapVBDen").valid();
        });

        $('.chosen').chosen({
            no_results_text: 'Không tìm thấy kết quả',
            width: '100%',
            search_contains: true
        });

        $('select[name="donvi_id"]').change(function() {
            let donviId = $(this).val();
            loadUserDonViNoiBoCheckBox([donviId], '#UserChutriContainer', {
                checkbox_name: 'user_chutri_ids[]'
            });
        });

        $('select[name="donvi_phoihop_ids[]"]').change(function() {
            let donviIds = $(this).val();
            let selectedValues = $('#FormNhapVBDen').serializeObject()["user_phoihop_ids[]"];

            loadUserDonViNoiBoCheckBox(donviIds, '#UserPhoihopContainer', {
                checkbox_name: 'user_phoihop_ids[]',
                selected_values: selectedValues
            });
        });

        $('input[name="not_have_chutri"]').click(function() {
            if ($(this).is(':checked')) {
                $('select[name="donvi_id"]').val('').attr('disabled', true).trigger('chosen:updated');
                $('#UserChutriContainer').html('');
            } else {
                $('select[name="donvi_id"]').attr('disabled', false).trigger('chosen:updated');
            }
        });

        function loadUserDonViNoiBoCheckBox(donviIds, target, options) {
            options = options || {};

            let url = '{{ url('load_user_donvinoibo_checkbox') }}';
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            let params = {
                _token: CSRF_TOKEN,
                selected_values: options.selected_values || [],
                donvi_ids: donviIds,
                checkbox_name: options.checkbox_name || ''
            };

            loading_show();
            $.post(url, params, (res) => {
                loading_hide();
                $(target).html(res);
            });
        }
    </script>
@endsection
