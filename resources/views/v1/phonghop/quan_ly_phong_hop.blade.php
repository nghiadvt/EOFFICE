@extends(config('app.interface').'templates.lanhdao')
@section('main')
    <div class="container container-list">
        <div class="row">
                <div class="col-md-9">
                    <h3 style="text-align: left;">Quản lý phòng họp</h3>
                </div>
                <div class="pull-right" style="margin-top: 10px">
{{--                    <a class="btn btn-primary"--}}
{{--                       href="{{ route('phonghop.dangkylichtuan') }}"><i class="fa fa-pencil-square-o"></i> Đăng--}}
{{--                        ký lịch tuần</a>--}}
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#myModal"><i class="fa fa-plus"></i> Thêm mới phòng
                    </button>

                </div>
        </div>
        <table class="table table-bordered">
            <thead class="head-table" style="margin-top: 20px">
            <tr>
                <th style="text-align: center">STT</th>
                <th style="text-align: center">Tên phòng họp</th>
                <th style="text-align: center">Địa điểm</th>
                <th style="text-align: center">Sức chứa(Số người)</th>
                <th style="text-align: center">Diện tích(m²)</th>
                <th style="text-align: center">Thiết bị</th>
                <th style="text-align: center">Thứ tự</th>
                <th style="text-align: center">Sử dụng</th>
                <th style="text-align: center">Chức năng</th>
            </tr>
            </thead>
            <tbody>
            @if(sizeof($phonghop))
                @php $stt = 1; @endphp
                @foreach ($phonghop as $p)
                    <tr>
                        <td class="col-stt">{{$stt++}}</td>
                        <td>{{$p->tenphonghop}}</td>
                        <td>{{$p->diadiem}}</td>
                        <td>{{$p->succhua}}</td>
                        <td>{{$p->dientich}}</td>
                        <td>{{$p->thietbi}}</td>
                        <td>{{$p->sothutu}}</td>
                        <td>
                            @if ($p->status == 1)
                                <span class="label label-success">Có</span>
                            @elseif ($p->status == 0)
                                <span class="label label-warning">Không</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('phonghop.suaPhongHop', $p->id) }}" title="Chỉnh sửa"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="12" align="center"><i> Không có dữ liệu</i></td>
                </tr>
            @endif
            </tbody>
        </table>
        <nav>
            {!!$phonghop->links()!!}
        </nav>
    </div>
    <form id="FormThemMoi" class="form" method="post"
          action="{{ route ('phonghop.themphonghop') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="container">
            <!-- Trigger the modal with a button -->

            <!-- Modal -->
            <div class="modal fade modal-fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;
                            </button>
                            <h4 class="modal-title">Thêm mới phòng họp</h4>
                        </div>
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
                                               placeholder="Nhập tên phòng họp">
                                    </div>

                                </div>
                                <div class="col-md-12" style="padding-top: 7px">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Địa điểm</label><em
                                                class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="diadiem"
                                               id="diadiem" placeholder="Nhập địa điểm">
                                    </div>
                                </div>

                                <div class="col-md-12" style="padding-top: 7px">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Thiết bị</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="thietbi"
                                               id="thietbi"
                                               placeholder="Loa, máy chiếu, tivi,...">
                                    </div>
                                </div>

                                <div class="col-md-12" style="padding-top: 7px">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Sức chứa (số
                                            người)</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="succhua"
                                               min="1" id="succhua" placeholder="Ví dụ: 20">
                                    </div>
                                </div>

                                <div class="col-md-12" style="padding-top: 7px">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Diện tích</label>
                                    </div>
                                    <div class="col-md-8" style="padding-bottom: 7px">
                                        <input type="number" class="form-control" min="1"
                                               name="dientich" id="dientich"
                                               placeholder="Ví dụ: 300">
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
                                               placeholder="Nhập số thú tự">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8" style="padding-bottom: 7px;">
                                        <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-floppy-o"></i> Thêm mới
                                        </button>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        // form validate
        $(document).ready(function () {
            $('#FormThemMoi').submit(function (e) {
                e.preventDefault();
            })
                .validate({
                    rules: {
                        tenphonghop: {
                            required: true
                        },
                        diadiem: {
                            required: true
                        },

                        sothutu: {
                            required: true
                        }
                    },
                    messages: {
                        tenphonghop: {
                            required: "Hãy nhập tên phòng họp"
                        },
                        diadiem: {
                            required: "Hãy nhập địa điểm"
                        },

                        sothutu: {
                            required: "Hãy nhập số thứ tự"
                        }
                    },
                    submitHandler: function (form) {
                        loading_show();
                        form.submit();
                    }
                });
        });


    </script>
@endsection
