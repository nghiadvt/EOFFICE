@extends(config('app.interface') . 'templates.lanhdao')
@section('title', 'Chỉnh sửa đơn vị')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/v2/list_doc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/enter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/dang_ky_lich_tuan.css') }}">
@endsection
@section('content')
    <div class="container-flud income-pages mx-0">
        <div class="row group-function mx-0" style="padding-left:43px">
            <div class="col-md-10 offset-sx-12 breadcrumbs mx-0 px-0">
                <div class="breadcrumbs-link">
                    <div><a href="" class="txt-link">Quản trị hệ thống</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="{{ route('quan_ly_don_vi') }}" class="txt-link">Quản lý đơn vị</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">Chỉnh sửa đơn vị</a></div>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-sm-12 table-bordered" style="margin-top: 10px">
                    <form id="DonViForm" action="{{ route('cap_nhat_don_vi') }}" class="form-input" method="POST">
                        <input type="hidden" name="donvi_id" value="{{ $donvi->id }}">
                        <div class="form-row">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-row">
                                <div
                                    style="text-align: center; margin-top: 20px; font-size : 20px !important; color: var(--website-dark-mode-4284-d-2, #4284D2); ">
                                    Chỉnh sửa đơn vị</div>
                                <div class="col-md-12 vanban" style="margin: 15px;">
                                    <div class="form-item">
                                        <div class="form-item-l">
                                            <p style="padding-top:7px"><b>Tên đơn vị (<span
                                                        style="color: red">*</span>)</b>:</p>
                                        </div>
                                        <div class="form-item-c"
                                            style="width: 650px;
                                    margin-left: 50px;">
                                            <input type="text" name="name" placeholder="Nhập vào tên đơn vị."
                                                class="form-control" value="{{ $donvi->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 vanban" style="margin: 15px;">
                                    <div class="form-item">
                                        <div class="form-item-l">
                                            <p style="padding-top:7px"><b>Viết tắt:</b></p>
                                        </div>
                                        <div class="form-item-c" style="width: 650px;">
                                            <input style="margin-left: 91px;" type="text" name="viettat"
                                                value="{{ $donvi->viettat }}" placeholder="Nhập tên viết tắt của đơn vị."
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 vanban" style="margin: 15px;">
                                    <div class="form-item">
                                        <div class="form-item-l">
                                            <p style="padding-top:7px"><b>Trực thuộc đơn vị: </b></p>
                                        </div>
                                        <div class="form-item-c">
                                            <select name="isDonvi" id="isDonvi" class="form-control"
                                                style="margin-left: 25px; width:647px; ">
                                                <option value="0">Không</option>
                                                <option value="1" @if ($donvi->isDonvi) selected @endif>Có
                                                </option>
                                            </select>
                                            <div id="don_vi" style="display: none; margin: 10px 25px;">
                                                <label for="don_vi" style="margin: 10px 2px">Chọn đơn vị trực
                                                    thuộc:</label>
                                                <select name="parent_id" id="parent_id" class="form-control"
                                                    style="width: 647px;">
                                                    @if ($donvi->isDonvi == 1)
                                                        {
                                                        <option value="{{ $donvi->id }}">{{ $parent_donvi }}</option>
                                                        }
                                                    @endif
                                                    @foreach ($donvis as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    var isDonvi = parseInt($("#isDonvi").val());

                                                    if (isDonvi == 1) {
                                                        $("#don_vi").show();
                                                    }
                                                    $("#isDonvi").change(function() {
                                                        var selectedOption = $(this).val();
                                                        if (selectedOption === "1") {
                                                            $("#don_vi").show();
                                                        } else {
                                                            $("#don_vi").hide();
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 vanban" style="margin: 15px;">
                                    <div class="form-item">
                                        <div class="form-item-l">
                                            <p style="padding-top:7px"><b>Chức năng:</b></p>
                                        </div>
                                        <div class="form-item-c">
                                            <input type="text" name="chucnang" value="{{ $donvi->chucnang }}"
                                                class="form-control" style="margin-left: 69px;  width: 647px"
                                                placeholder="Nhập vào chức năng của đơn vị.">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 vanban" style="margin: 15px;">
                                    <div class="form-item">
                                        <div class="form-item-l">
                                            <p style="padding-top:7px"><b>Địa chỉ:</b></p>
                                        </div>
                                        <div class="form-item-c">
                                            <input type="text" name="diachi" value="{{ $donvi->diachi }}"
                                                class="form-control" style="margin-left: 95px;  width: 647px"
                                                placeholder="Nhập vào địa chỉ của đơn vị.">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 vanban" style="margin: 15px;">
                                    <div class="form-item">
                                        <div class="form-item-l">
                                            <p style="padding-top:7px"><b>Điện thoại:</b></p>
                                        </div>
                                        <div class="form-item-c">
                                            <input type="text" name="dienthoai" value="{{ $donvi->dienthoai }}"
                                                class="form-control" style="margin-left: 75px;  width: 647px"
                                                placeholder="Nhập vào số điện thoại của đơn vị.">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 vanban" style="margin: 15px;">
                                    <div class="form-item">
                                        <div class="form-item-l">
                                            <p style="padding-top:7px"><b>Mô tả:</b></p>
                                        </div>
                                        <div class="form-item-c">
                                            <input type="text" name="description" value="{{ $donvi->description }}"
                                                class="form-control" style="margin-left: 105px;  width: 647px"
                                                placeholder="Nhập vào mô tả cho đơn vị.">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 vanban" style="margin: 15px;">
                                    <div class="form-item">
                                        <div class="form-item-l">
                                            <p style="padding-top:7px"><b>Trạng thái (<span
                                                        style="color: red">*</span>)</b>:</p>
                                        </div>
                                        <div class="form-item-c">
                                            <select name="actived" id="actived" class="form-control" onchange="Role()"
                                                style="margin-left: 55px;  width: 647px">
                                                <option value="0">Không hoạt động</option>
                                                <option @if ($donvi->isDonvi) selected @endif value="1">
                                                    Hoạt động
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 vanban" style="margin: 15px;">
                                    <div class="form-item">
                                        <div class="form-item-l">
                                            <p style="padding-top:7px"><b>Mã đơn vị:</b></p>
                                        </div>
                                        <div class="form-item-c">
                                            <input type="text" name="madonvi" value="{{ $donvi->madonvi }}"
                                                class="form-control" style="margin-left: 78px;  width: 647px"
                                                placeholder="Nhập vào mã đơn vị.">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 vanban" style="text-align: center">
                                    <button type="submit" class="btn btn-primary" style="margin:17px">Lưu</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#DonViForm').validate({
            ignore: [],
            rules: {
                'name': {
                    required: true
                },
                'ordering': {
                    required: true
                },
                'actived': {
                    required: true,
                }
            },
            messages: {
                'name': 'Hãy nhập tên đơn vị',
                'ordering': 'Hãy nhập ordering',
                'actived': {
                    required: 'Hãy chọn trạng thái',
                }
            },
            submitHandler: function(form) {
                loading_show();
                form.submit();
            }
        });

        $('.chosen').chosen({
            no_results_text: 'Không tìm thấy kết quả',
            width: '100%',
            search_contains: true
        });

        function Role() {
            let role = $('#role').val();
            if (role == 3) {
                $('#lichtuan_lanhdao').css('display', 'block')
            } else {
                $('#lichtuan_lanhdao').css('display', 'none')
            }
        }
    </script>
@endsection
