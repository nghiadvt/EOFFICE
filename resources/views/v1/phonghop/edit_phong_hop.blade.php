@extends(config('app.interface').'templates.lanhdao')
@section('main')
    <div style="padding: 20px;">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="title-text">Cập nhật thông tin phòng họp</h3>
            </div>
            <div class="col-sm-12 table-bordered" style="margin-top: 20px">
                <div style="text-align: center; margin-top: 20px">
                    <i><label>Lưu ý:</label> Các trường có dấu <em class="flag-require">*</em> bắt buộc nhập thông
                        tin</i>
                </div>

                    <form id="FormEditPhongHop" class="form" action="{{ route('phonghop.capNhatPhongHop') }}" method="POST" style="margin-top: 20px">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ $idPhongHop }}">
                    <div class="container">
                        <div class="col-md-12" id="clor" style="margin-top: 7px">
                            <div class="row" style="text-align: left;">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Tên phòng họp</label><em
                                                class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control"
                                               name="tenphonghop" id="tenphonghop"
                                               placeholder="Nhập tên phòng họp" value="{{$phonghop['tenphonghop']}}">
                                    </div>

                                </div>
                                <div class="col-md-12" style="padding-top: 7px">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Địa điểm</label><em
                                                class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="diadiem"
                                               id="diadiem" placeholder="Nhập địa điểm" value="{{$phonghop['diadiem']}}">
                                    </div>
                                </div>

                                <div class="col-md-12" style="padding-top: 7px">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Thiết bị</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="thietbi"
                                               id="thietbi"
                                               placeholder="Loa, máy chiếu, tivi,..." value="{{$phonghop['thietbi']}}">
                                    </div>
                                </div>

                                <div class="col-md-12" style="padding-top: 7px">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Sức chứa (số
                                            người)</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="succhua"
                                               min="1" id="succhua" placeholder="Ví dụ: 20" value="{{$phonghop['succhua'] == 0 ? '' : $phonghop['succhua']}}">
                                    </div>
                                </div>

                                <div class="col-md-12" style="padding-top: 7px">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Diện tích</label>
                                    </div>
                                    <div class="col-md-8" style="padding-bottom: 7px">
                                        <input type="number" class="form-control" min="1"
                                               name="dientich" id="dientich"
                                               placeholder="Ví dụ: 300"  value="{{$phonghop['dientich']}}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Số thứ tự</label><em
                                                class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-8" style="padding-bottom: 7px">
                                        <input type="number" class="form-control" min="1"
                                               name="sothutu" id="sothutu"
                                               placeholder="Nhập số thú tự" value="{{$phonghop['sothutu']}}">
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4"></div>
                                <div class="col-md-8" style="padding-bottom: 7px;    padding-left: 10px;">
                                    <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-floppy-o"></i> Cập nhật
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection