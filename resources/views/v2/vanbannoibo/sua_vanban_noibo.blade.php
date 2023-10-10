@extends(config('app.interface') . 'templates.layout')
@section('title', 'Sửa văn bản nội bộ')
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
                <div><a href="" class="txt-link">Sửa văn bản nội bộ</a></div>
            </div>
        </div>
        <!-- Content form -->
        <div class="row content-decree-document mx-0">
            <h4>Sửa văn bản nội bộ</h4>
            <form id="FormEditVBDen" class="form-input" action="{{ url('vanbannoibo/luu-sua') }}" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="vanban_id" value="{{ $vanban->id }}">
                <input type="hidden" name="loai" value="Đến">
                <input type="hidden" name="book_id" value="4">
                <div class="row">
                    <div class="col-md-12 col-sx-12 form-item-c">
                        <label class="label">Tiêu đề <em class="required">*</em></label>
                        <textarea class="form-control mx-0" name="title" id="name" rows="3"
                            placeholder="Nhập tiêu đề văn bản ban hành">{!! nl2br($vanban->title) !!}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Loại văn bản <em class="required" class="required">*</em></label>
                        <select class="form-control chosen" name="loaivanban_id" id="loaivanban">
                            <option value="">Chọn loại văn bản</option>
                            @foreach ($loaivanbans as $loaivanban)
                                <option
                                    value="{{ $loaivanban->id }}"{{ $vanban->loaivanban_id == $loaivanban->id ? 'selected' : '' }}>
                                    {{ $loaivanban->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Số ký hiệu <em class="required">*</em></label>
                        <input type="text" class="form-control" name="kyhieu" id="kyhieu"
                            placeholder="Nhập số ký hiệu" value="{{ $vanban->kyhieu }}">
                    </div>
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Ngày ban hành <em class="required">*</em></label>
                        <input type="text" name="ngayden" id="startngayden" autocomplete="off" class="form-control"
                            value="{{ date('d-m-Y', strtotime($vanban->ngayden)) }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Cơ quan ban hành</label>
                        <input type="text" class="form-control" name="cq_banhanh" placeholder="Nhập cơ quan ban hành"
                            value="{{ $vanban->cq_banhanh }}">
                    </div>
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Lĩnh vực</label>
                        <select class="form-control chosen" name="linhvuc_id">
                            <option value="">Chọn lĩnh vực</option>
                            @foreach ($linhvucs as $linhvuc)
                                <option value="{{ $linhvuc->id }}"
                                    {{ $vanban->linhvuc_id == $linhvuc->id ? 'selected' : '' }}>{{ $linhvuc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Hạn xử lý</label>
                        <input type="text" name="hanxuly" id="hanxuly" autocomplete="off" class="form-control"
                            value="{{ $vanban->hanxulyVal ? date('d-m-Y', strtotime($vanban->hanxulyVal)) : '' }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Độ khẩn</label>
                        <select class="form-control chosen" name="urgency" id="urgency">
                            @for ($i = 1; $i <= $countcombo; $i++)
                                <option value="{{ $i }}" {{ $vanban->urgency == $i ? 'selected' : '' }}>
                                    {{ $combobox[$i] }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Ngày ký</label>
                        <input type="text" name="ngayky" id="ngayky" autocomplete="off" class="form-control"
                            a="{{ $vanban->ngayky }}" value="{{ date('d-m-Y', strtotime($vanban->ngaykyVal)) }}">
                    </div>
                    <div class="col-md-4 col-sx-12">
                        <label class="label">Người ký</label>
                        <input type="text" class="form-control" name="nguoiky" placeholder="Nhập tên người ký"
                            value="{{ $vanban->nguoiky }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sx-12">
                        <label class="label">Ghi chú</label>
                        <textarea class="form-control mx-0" name="note" id="note" cols="30" rows="5"
                            placeholder="Nhập ghi chú văn bản ban hành">{!! nl2br($vanban->note) !!}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="label">File đính kèm đã có<em class="required">*</em></label>
                    </div>
                    <div class="form-item-c">
                        @php
                            $files = explode(';', $vanban->file_dinhkem);
                        @endphp
                        @foreach ($files as $file)
                            <a href="{{ route('dowload.file', [$file]) }}" target="_blank"
                                title="{{ $file }}">{{ $file }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label class="label">File đính kèm (Nhấn Ctrl để chọn nhiều file)<em
                                class="required">*</em></label>
                    </div>
                    <div class="form-item-c">
                        <div class="row">
                            <div data-maxsize="20" id="multi-file-upload"></div>
                            <span style="color: red;">Đính kèm file mới sẽ thay các file đính kèm cũ.</span>
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
                                    <label class="label"><input type="checkbox" value="1" name="not_have_chutri"
                                            {{ $vanban->not_have_chutri ? 'checked' : '' }}
                                            {{ sizeof($userChuTriDaXemVanBanIds) ? 'disabled' : '' }}>
                                        Không có người chủ trì</label>
                                </div>
                                <div class="form-item-c" style="display: flex; flex-direction: column-reverse;">
                                    <select class="form-control chosen" name="donvi_id"
                                        {{ sizeof($userChuTriDaXemVanBanIds) || $vanban->not_have_chutri ? 'disabled' : '' }}>
                                        <option value="">Chọn đơn vị chủ trì</option>
                                        @foreach ($bookDetails as $val)
                                            <option value="{{ $val->donvi->id }}"
                                                {{ $vanban->donvi_id == $val->donvi->id ? 'selected' : '' }}>
                                                {{ $val->donvi->name }}</option>
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
                                    <div id="UserChutriContainer">
                                        <style>
                                            .checkbox-group {
                                                margin-bottom: 5px;
                                            }

                                            .checkbox-l {
                                                font-weight: bold;
                                            }

                                            .checkbox-c {
                                                padding: 0 0 0 15px;
                                            }

                                            .checkbox-c label {
                                                font-weight: normal;
                                            }

                                            .checkbox-c input {
                                                margin-right: 5px;
                                            }
                                        </style>
                                        @if (sizeof($userChuTris))
                                            @foreach ($userChuTris as $donviName => $users)
                                                <div class="checkbox-group">
                                                    <div class="checkbox-l">
                                                        <label><input type="checkbox" class="check-all"> <span>
                                                                {{ $donviName }}</span></label>
                                                    </div>
                                                    <div class="checkbox-c">
                                                        @foreach ($users as $user)
                                                            <div><label><input type="checkbox"
                                                                        value="{{ $user->id }}"
                                                                        name="user_chutri_ids[]" checked
                                                                        {{ in_array($user->id, $userChuTriDaXemVanBanIds) ? 'disabled' : '' }}>
                                                                    <span>{{ $user->fullname . ' - ' . $user->chucdanh . ' - ' . $user->email }}</span></label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            Không có dữ liệu
                                        @endif
                                    </div>
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
                                            <option value="{{ $val->donvi->id }}"
                                                {{ in_array($val->donvi->id, $vanban->donViPhoiHopIdsVal) ? 'selected' : '' }}
                                                {{ in_array($val->donvi->id, $donviPhoiHopDaXemVanBanIds) ? 'disabled' : '' }}>
                                                {{ $val->donvi->name }}</option>
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
                                    <style>
                                        .checkbox-group {
                                            margin-bottom: 5px;
                                        }

                                        .checkbox-l {
                                            font-weight: bold;
                                        }

                                        .checkbox-c {
                                            padding: 0 0 0 15px;
                                        }

                                        .checkbox-c label {
                                            font-weight: normal;
                                        }

                                        .checkbox-c input {
                                            margin-right: 5px;
                                        }
                                    </style>
                                    <div id="UserPhoihopDaXemContainer">
                                        @foreach ($userTrongDonViPhoiHops as $donviId => $val)
                                            @if (in_array($donviId, $donviPhoiHopDaXemVanBanIds))
                                                <div class="checkbox-group">
                                                    <div class="checkbox-l">
                                                        <label><input type="checkbox" class="check-all"> <span>
                                                                {{ $val->name }}</span></label>
                                                    </div>
                                                    <div class="checkbox-c">
                                                        @foreach ($val->users as $user)
                                                            <div><label><input type="checkbox"
                                                                        value="{{ $user->id }}"
                                                                        name="user_phoihop_ids[]"
                                                                        {{ in_array($user->id, $vanban->userPhoiHopIdsVal) ? 'checked' : '' }}
                                                                        {{ in_array($user->id, $userPhoiHopDaXemVanBanIds) ? 'disabled' : '' }}>
                                                                    <span>{{ $user->fullname . ' - ' . $user->chucdanh . ' - ' . $user->email }}</span></label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div id="UserPhoihopContainer">
                                        @if (sizeof($userTrongDonViPhoiHops))
                                            @foreach ($userTrongDonViPhoiHops as $donviId => $val)
                                                @if (!in_array($donviId, $donviPhoiHopDaXemVanBanIds))
                                                    <div class="checkbox-group">
                                                        <div class="checkbox-l">
                                                            <label><input type="checkbox" class="check-all"> <span>
                                                                    {{ $val->name }}</span></label>
                                                        </div>
                                                        <div class="checkbox-c">
                                                            @foreach ($val->users as $user)
                                                                <div><label><input type="checkbox"
                                                                            value="{{ $user->id }}"
                                                                            name="user_phoihop_ids[]"
                                                                            {{ in_array($user->id, $vanban->userPhoiHopIdsVal) ? 'checked' : '' }}
                                                                            {{ in_array($user->id, $userPhoiHopDaXemVanBanIds) ? 'disabled' : '' }}>
                                                                        <span>{{ $user->fullname . ' - ' . $user->chucdanh . ' - ' . $user->email }}</span></label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            Không có dữ liệu
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 d-flex justify-content-center mt-3">
                    <button type="submit" name="type_submit" value="notsendmail" class="btn btn-default btn-primary"
                        style="margin-top:10px; margin-right: 8px;">Cập nhật văn bản</button>
                    <button type="submit" name="type_submit" value="sendmail" class="btn btn-default btn-primary"
                        style="margin-top:10px; margin-left: 8px;">Cập nhật và gửi mail</button>
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
        $(function() {
            $('#startngayden').datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $('#hanxuly').datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $('#ngayky').datepicker({
                dateFormat: 'dd-mm-yy'
            });
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

        var numberUserPhoiHopDaXemVanBan = @php echo json_encode(sizeof($userPhoiHopDaXemVanBanIds));@endphp;
        var numberUserChuTriDaXemVanBan = @php echo json_encode(sizeof($userChuTriDaXemVanBanIds));@endphp;

        // form validate
        $('#FormEditVBDen').validate({
            ignore: [],
            rules: {
                title: {
                    required: true
                },
                loaivanban_id: {
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
                            },
                            vanban_id: "{{ $vanban->id }}"
                        }
                    }
                },
                donvi_id: {
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
                soden: {
                    required: "Hãy nhập số đến"
                },
                donvi_id: {
                    required: "Hãy chọn đơn vị chủ trì"
                }
            },
            submitHandler: function(form) {
                let formData = $('#FormEditVBDen').serializeObject();

                if ($('input[name="not_have_chutri"]').is(':checked')) {
                    if (!numberUserPhoiHopDaXemVanBan) {
                        if (!formData['user_phoihop_ids[]'] || !formData['user_phoihop_ids[]'].length) {
                            jAlert('Hãy chọn người phối hợp', 'Thông báo');
                            return false;
                        }
                    }
                } else {
                    if (!numberUserChuTriDaXemVanBan) {
                        if (!formData['user_chutri_ids[]'] || !formData['user_chutri_ids[]'].length) {
                            jAlert('Hãy chọn người chủ trì', 'Thông báo');
                            return false;
                        }
                    }
                }

                // loading_show();
                form.submit();
            }
        });

        $('input[name="ngayden"]').change(function() {
            $("#FormEditVBDen").valid();
        });

        $('.chosen').chosen({
            no_results_text: 'Không tìm thấy kết quả',
            width: '100%',
            search_contains: true
        });

        $('select[name="donvi_id"]').change(function() {
            let donviId = $(this).val();
            loadUserDonViDenCheckBox([donviId], '#UserChutriContainer', {
                checkbox_name: 'user_chutri_ids[]'
            });
        });

        $('select[name="donvi_phoihop_ids[]"]').change(function(evt, params) {
            let donviIds = $(this).val();
            let selectedValues = $('#FormEditVBDen').serializeObject()["user_phoihop_ids[]"];

            loadUserDonViDenCheckBox(donviIds, '#UserPhoihopContainer', {
                checkbox_name: 'user_phoihop_ids[]',
                selected_values: selectedValues
            });
        });

        $('input[name="not_have_chutri"]').click(function() {
            if ($(this).is(':checked')) {
                $('input[name="user_chutri_ids[]"]').attr('checked', false).attr('disabled', true);
            } else {
                $('input[name="user_chutri_ids[]"]').attr('disabled', false);
            }
        });

        function loadUserDonViDenCheckBox(donviIds, target, options) {
            options = options || {};

            let url = '{{ url('load_user_donviden_checkbox') }}';
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            let params = {
                _token: CSRF_TOKEN,
                selected_values: options.selected_values || [],
                donvi_ids: donviIds,
                checkbox_name: options.checkbox_name || ''
            };

            // loading_show();
            $.post(url, params, (res) => {
                loading_hide();
                $(target).html(res);
            });
        }
    </script>
@endsection
