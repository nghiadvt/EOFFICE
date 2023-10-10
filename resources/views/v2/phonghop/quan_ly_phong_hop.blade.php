@extends(config('app.interface') . 'templates.lanhdao')
@section('title', 'Quản lý phòng họp')
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
                        <div><a href="" class="txt-link">Danh sách phòng họp</a></div>
                    </div>
                </div>
                <div class="row titles">
                    <div class="title-page col-md-8">Quản lý phòng họp</div>
                    <div class="col-md-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"><i
                                class="fa-solid fa-pencil"></i> Thêm mới phòng họp
                        </button>

                    </div>
                </div>

            </div>
        </div>
        <div class="row table-list-documents mx-0 tbs" style="margin-bottom: 30px">
            <table lass="table-content">
                <thead>
                    <tr class="field-title">
                        <th class="num-docs">STT</th>
                        <th scope="col" class="name">Tên phòng họp</th>
                        <th scope="col" class="name">Địa điểm</th>
                        <th scope="col" class="name_dc">Sức chứa(Số người)</th>
                        <th scope="col" class="name_dc">Diện tích(m²)</th>
                        <th scope="col" class="name">Thiết bị</th>
                        <th scope="col" class="name_dc">Thứ tự</th>
                        <th scope="col" class="name_dc">Sử dụng</th>
                        <th style="text-align: center">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    @if (sizeof($phonghop))
                        @php $stt = 1; @endphp
                        @foreach ($phonghop as $p)
                            <tr class="item item-container">
                                <td class="num-docs">{{ $stt++ }}</td>
                                <td class="name" style="width: 700px">{{ $p->tenphonghop }}</td>
                                <td class="name" style="width: 550px">{{ $p->diadiem }}</td>
                                <td class="name_dc" style="width: 200px">{{ $p->succhua }}</td>
                                <td class="name_dc" style="width: 200px">{{ $p->dientich }}</td>
                                <td class="name" style="width: 550px">{{ $p->thietbi }}</td>
                                <td class="name_dc" style="width: 200px">{{ $p->sothutu }}</td>
                                <td class="name_dc" style="width: 200px">
                                    @if ($p->status == 1)
                                        <span class="badge text-bg-success" style="font-size: 11px;">Có</span>
                                    @elseif ($p->status == 0)
                                        <span class="badge text-bg-warning" style="font-size: 11px;">Không</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('phonghop.suaPhongHop', $p->id) }}" title="Chỉnh sửa"><i
                                            class="fa fa-edit"></i></a>
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
                {!! $phonghop->links() !!}
            </nav>

        </div>
    </div>
    <form id="FormThemMoi" class="form" method="POST" action="{{ route('phonghop.themphonghop') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="container">
            <div class="modal" tabindex="-1" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" style="text-align: center">Thêm mới phòng họp</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close" >&times;</button>
                        </div>
                        <div class="col-md-12" id="clor" style="margin-top: 7px">
                            <div class="row" style="margin-left: 10px;">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Tên phòng họp:</label><em class="flag-require" style="color: red">*:</em>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="tenphonghop" id="tenphonghop"
                                            placeholder="Nhập tên phòng họp">
                                    </div>

                                </div>
                                <div class="col-md-12" style="padding-top: 7px">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Địa điểm:</label><em class="flag-require" style="color: red">*</em>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="diadiem" id="diadiem"
                                            placeholder="Nhập địa điểm">
                                    </div>
                                </div>

                                <div class="col-md-12" style="padding-top: 7px">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Thiết bị:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="thietbi" id="thietbi"
                                            placeholder="Loa, máy chiếu, tivi,...">
                                    </div>
                                </div>

                                <div class="col-md-12" style="padding-top: 7px">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Sức chứa (số
                                            người):</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="succhua" min="1"
                                            id="succhua" placeholder="Ví dụ: 20">
                                    </div>
                                </div>

                                <div class="col-md-12" style="padding-top: 7px">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Diện tích:</label>
                                    </div>
                                    <div class="col-md-8" style="padding-bottom: 7px">
                                        <input type="number" class="form-control" min="1" name="dientich"
                                            id="dientich" placeholder="Ví dụ: 300">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <label style="padding-top:7px;">Số thứ tự</label><em class="flag-require" style="color: red">*:</em>
                                    </div>
                                    <div class="col-md-8" style="padding-bottom: 7px">
                                        <input type="number" class="form-control" min="1" name="sothutu"
                                            id="sothutu" placeholder="Nhập số thú tự">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8" style="padding-bottom: 7px;">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                            Thêm mới
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
        $(document).ready(function() {
            $('#FormThemMoi').submit(function(e) {
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
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
        });
    </script>
@endsection
