@extends(config('app.interface') . 'templates.lanhdao')
@section('title', 'Cập nhật phòng họp')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/v2/list_doc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/dang_ky_lich_tuan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/quan_ly_don_vi.css') }}">
@endsection
@section('content')
    <div class="container-flud income-pages mx-0 col-md-12">
        <div class="row group-function mx-0 col-md-12">
            <div class="col-md-12 offset-sx-12 breadcrumbs mx-0 px-0">
                <div class="row group-function mx-0 col-md-12">
                    <div class="breadcrumbs-link links">
                        <div><a href="" class="txt-link">Điều hành tác nghiệp</a></div>
                        <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                        <div><a href="{{ route('phonghop.danhsachphonghop') }}" class="txt-link">Danh sách phòng họp</a>
                        </div>
                        <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                        <div><a href="" class="txt-link">Cập nhật thông tin phòng họp</a></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="title-text"
                        style="text-align: center; font-size: 24px; color: var(--website-dark-mode-4284-d-2, #4284D2); ">Cập
                        nhật thông tin phòng họp</h3>
                </div>
                <div class="col-sm-12 table-bordered" style="margin-top: 5px; border-radius: 7px ">
                    <div style="text-align: center; margin-top: 20px">
                        <i><label>Lưu ý:</label> Các trường có dấu <em class="flag-require" style="color: red">*</em> bắt
                            buộc nhập thông
                            tin</i>
                    </div>

                    <form id="FormEditPhongHop" class="form" action="{{ route('phonghop.capNhatPhongHop') }}"
                        method="POST" style="margin-top: 20px">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ $idPhongHop }}">
                        <div class="container">
                            <div class="col-md-12" id="clor" style="margin-top: 7px">
                                <div class="row" style="text-align: left;">

                                    <div class="form-row">
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">
                                                <div class="col-md-2 label-content" style="text-align: right;">
                                                    <label style="padding-top:7px;" class="label-content">Tên phòng
                                                        họp:</label>(<em class="flag-require" style="color: red">*</em> )
                                                </div>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"
                                                    style="margin-top: 8px;
                                            margin-left: -40px"
                                                    name="tenphonghop" id="tenphonghop" placeholder="Nhập tên phòng họp"
                                                    value="{{ $phonghop['tenphonghop'] }}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">
                                                <div class="col-md-2 label-content" style="text-align: right;">
                                                    <label style="padding-top:7px;" class="label-content">Địa
                                                        điểm:</label>(<em class="flag-require" style="color: red">*</em> )
                                                </div>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"
                                                    style="margin-left: -39px;
                                            margin-top: 6px"
                                                    name="diadiem" id="diadiem" placeholder="Nhập địa điểm"
                                                    value="{{ $phonghop['diadiem'] }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">
                                                <div class="col-md-2 label-content" style="text-align: right;">
                                                    <label style="padding-top:7px;" class="label-content">Thiết bị:</label>
                                                </div>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"
                                                    style="margin-left: -39px;
                                            margin-top: 10px;"
                                                    name="thietbi" id="thietbi" placeholder="Loa, máy chiếu, tivi,..."
                                                    value="{{ $phonghop['thietbi'] }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">
                                                <div class="col-md-2 label-content" style="text-align: right;">
                                                    <label style="padding-top:7px;" class="label-content">Sức chứa (Số
                                                        người):</label>
                                                </div>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control"
                                                    style="margin-left: -37px;
                                            margin-top: 7px"
                                                    name="succhua" min="1" id="succhua" placeholder="Ví dụ: 20"
                                                    value="{{ $phonghop['succhua'] == 0 ? '' : $phonghop['succhua'] }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">
                                                <div class="col-md-2 label-content" style="text-align: right;">
                                                    <label style="padding-top:7px;" class="label-content">Diện
                                                        tích:</label>
                                                </div>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control"
                                                    style="margin-left: -36px;
                                            margin-top: 6px;"
                                                    min="1" name="dientich" id="dientich"
                                                    placeholder="Ví dụ: 300" value="{{ $phonghop['dientich'] }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="mb-3 row">
                                            <label for="" class="col-sm-2 col-form-label">
                                                <div class="col-md-2 label-content" style="text-align: right;">
                                                    <label style="padding-top:7px;" class="label-content">Số thứ
                                                        tự:</label>(<em class="flag-require" style="color: red">*</em> )
                                                </div>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control"
                                                    style="margin-left: -35px;
                                            margin-top: 8px;"
                                                    min="1" name="sothutu" id="sothutu"
                                                    placeholder="Nhập số thú tự" value="{{ $phonghop['sothutu'] }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8" style="padding-bottom: 7px;margin-left: 500px;">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Cập
                                            nhật
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
