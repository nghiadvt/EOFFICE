@extends(config('app.interface') . 'templates.lanhdao')
@section('title', 'Danh sách đơn vị')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/v2/list_doc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/dang_ky_lich_tuan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/quan_ly_don_vi.css') }}">
@endsection
@section('content')
    <div class="container-flud income-pages mx-0 col-md-12">
        @if (isset($_GET['keySearch']))
            <script type="text/javascript" src="js/highlight.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    highlight();
                });
            </script>
        @endif
        <div class="row group-function mx-0 col-md-12">
            <div class="col-md-12 offset-sx-12 breadcrumbs mx-0 px-0">
                <div class="row group-function mx-0 col-md-12">
                    <div class="breadcrumbs-link links">
                        <div><a href="" class="txt-link">Quản trị hệ thống</a></div>
                        <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                        <div><a href="" class="txt-link">Danh sách đơn vị</a></div>
                    </div>
                </div>
                <div class="row titles">
                    <div class="title-page col-md-8">Danh sách đơn vị</div>
                    <div class="col-md-4 d-flex justify-content-end">
                        <div>
                            <a class="btn btn-primary pr-4" style="margin-right: 5px;" href="{{ route('them_don_vi') }}"><i
                                    class=" fa-solid fa-pencil"></i> Thêm đơn vị</a>
                        </div>
                        <div>
                            <form id="form-search" method="GET" action="{{ base_url() }}" accept-charset="UTF-8">
                                {{ csrf_field() }}
                                <input type="text" placeholder="Tìm kiếm" name="keySearch" class="form-control ml-2"
                                    value="<?php echo $keySearch; ?>" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row table-list-documents mx-0 tbs">
            <table class="table-content">
                <thead>
                    <tr class="field-title">
                        <th class="num-docs">STT</th>
                        <th scope="col" class="name">Name</th>
                        <th scope="col" class="name_dv">Viết tắt</th>
                        <th scope="col" class="name_dchi">Địa chỉ</th>
                        <th scope="col" class="name_dc">Mã đơn vị</th>
                        <th class="text-center hd">Hành động</th>

                    </tr>
                </thead>
                <tbody>
                    @if (sizeof($donvis))
                        @php $stt = ($donvis->currentPage() - 1) * $donvis->perPage() + 1 @endphp
                        @foreach ($donvis as $donvi)
                            <tr class="item item-container">
                                <td class="num-docs">{{ $stt++ }}</td>
                                <td class="name" style="width: 400px">{{ $donvi->name }}</td>
                                <td class="name_dv" style="width:400px">{{ $donvi->viettat }}</td>
                                <td class="name_dchi" style="text-align: center;  width: 500px;">{{ $donvi->diachi }}</td>
                                <td class="name_dc">{{ $donvi->madonvi }}</td>
                                <td class="text-center ">
                                    <div class="hd">
                                        <span class="btn-table">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown"
                                                    data-bs-hover="dropdown" data-bs-close-others="true"
                                                    aria-expanded="false">
                                                    <span class="username username-hide-on-mobile hidden-sm"
                                                        aria-hidden="true"><i class="fa fa-file-text"></i></span>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end vbdv"
                                                    style=" border-radius: 15px !important;">
                                                    <li style="margin-left: 15px"><a
                                                            href="{{ route('xemdanhsach_cb', ['1', $donvi->id]) }}"
                                                            title=""><i class=" fa-solid fa-arrow-circle-left"
                                                                style="padding: 3px" aria-hidden="true"></i>Văn bản đến</a>
                                                    </li>
                                                    <li style="margin-left: 15px"><a
                                                            href="{{ route('xemdanhsach_cb', ['2', $donvi->id]) }}"
                                                            title=""><i class="fa-solid fa-arrow-circle-right"
                                                                style="padding: 3px" aria-hidden="true"></i> Văn bản đi</a>
                                                    </li>
                                                    <li style="margin-left: 15px"><a
                                                            href="{{ route('xemdanhsach_cb', ['3', $donvi->id]) }}"
                                                            title=""><i class="fa-solid fa-hourglass-end"
                                                                style="padding: 3px" aria-hidden="true"></i> Công việc</a>
                                                    </li>
                                                    <li style="margin-left: 15px"><a
                                                            href="{{ route('xemdanhsach_cb', ['4', $donvi->id]) }}"
                                                            title=""><i class="fa-solid fa-stop-circle"
                                                                style="padding: 3px" aria-hidden="true"></i> Văn bản nội
                                                            bộ</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </span>
                                        <span class="btn-table">
                                            <a href="{{ route('sua_don_vi', [$donvi->id]) }}" title="Sửa đơn vị"><i
                                                    class="fa fa-edit"></i></a>
                                        </span>
                                        <span class="btn-table">
                                            <a href="javascript:;" onclick="deleteDonVi({{ $donvi->id }})"
                                                title="Xóa cơ quan"><i class="fa fa-trash red"></i></a>
                                        </span>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" align="center"><i> Không có dữ liệu</i></td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="pull-right">
                {!! $donvis->render() !!}
            </div>
        </div>

    </div>

    <script src="{{ asset('js/alert.js') }}"></script>
    <script>
        function deleteDonVi(id) {
            jConfirm('Bạn có muốn xóa?', 'Thông báo', function(r) {
                if (r) {
                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.post("{{ route('xoa_don_vi') }}", {
                        ids: [id],
                        _token: CSRF_TOKEN
                    }, () => {
                        location.reload();
                    });
                }
            });
        }
    </script>
@endsection
