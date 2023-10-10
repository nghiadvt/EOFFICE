@extends(config('app.interface').'templates.lanhdao')
@section('main')
    <div class="container container-list">
        @if (isset($_GET['keySearch']))
            <script type="text/javascript" src="js/highlight.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    highlight();
                });
            </script>
        @endif
        @include('flash::message')
        <div class="row">
            <div class="row">
                <h3 class="col-md-9 text-left">Danh sách đơn vị</h3>
                <div class="col-md-3 text-right" style="margin-top: 15px;display: flex">
                    <a class="btn btn-primary pr-4" style="margin-bottom: 15px;" href="{{ route('them_don_vi') }}"><i
                            class="fa fa-pencil-square-o"></i> Thêm đơn vị</a>
                    <form id="form-search" method="GET" action="{{ base_url() }}" accept-charset="UTF-8">
                        {{ csrf_field() }}
                        <input type="text" placeholder="Tìm kiếm" name="keySearch" class="form-control ml-2"
                            value="<?php echo $keySearch; ?>" />
                    </form>
                </div>
            </div>

            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th class="col-stt">STT</th>
                        <th>Name</th>
                        <th>Viết tắt</th>
                        <th>Địa chỉ</th>
                        <th>Mã đơn vị</th>
                        <th class="text-center col-fit-content">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if (sizeof($donvis))
                        @php $stt = ($donvis->currentPage() - 1) * $donvis->perPage() + 1 @endphp
                        @foreach ($donvis as $donvi)
                            <tr>
                                <td class="col-stt">{{ $stt++ }}</td>
                                <td>{{ $donvi->name }}</td>
                                <td>{{ $donvi->viettat }}</td>
                                <td>{{ $donvi->diachi }}</td>
                                <td>{{ $donvi->madonvi }}</td>
                                <td class="text-center col-fit-content" style="padding-top: 15px;">
                                   
                                    
                                    
                                    <span class="btn-table">
                                        <li class="dropdown" style="position: relative"> 
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                                                <span class="username username-hide-on-mobile hidden-sm" aria-hidden="true" ><i class="fa fa-file-text"></i></span>
                                            </a>
                                            <ul class="dropdown-menu" style="left: -170px;">
                                                <li><a href="{{route('xemdanhsach_cb',["1", $donvi->id ] )}}" title=""><i class="fa fa-caret-square-o-left" style="padding: 3px"  aria-hidden="true"></i>Văn bản đến</a></li>
                                                <li><a href="{{route('xemdanhsach_cb',["2", $donvi->id ] )}}"  title=""><i class="fa fa-caret-square-o-right"  style="padding: 3px"  aria-hidden="true"></i> Văn bản đi</a></li>
                                                <li><a href="{{route('xemdanhsach_cb',["3", $donvi->id ] )}}"  title=""><i class="fa fa-hourglass-end" style="padding: 3px"  aria-hidden="true"></i> Công việc</a></li>
                                                <li><a href="{{route('xemdanhsach_cb',["4", $donvi->id ] )}}"  title=""><i class="fa fa-dot-circle-o" style="padding: 3px"  aria-hidden="true"></i> Văn bản nội bộ</a></li>
                                            </ul>
                                            </li>
                                    </span>
                                    <span class="btn-table">
                                        <a href="{{ route('sua_don_vi', [$donvi->id]) }}" title="Sửa đơn vị"><i
                                                class="fa fa-edit"></i></a>
                                    </span>
                                    <span class="btn-table">
                                        <a href="javascript:;" onclick="deleteDonVi({{ $donvi->id }})"
                                            title="Xóa cơ quan"><i class="fa fa-trash red"></i></a>
                                    </span>
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


    <script>
        function deleteDonVi(id) {
            jConfirm('Bạn có muốn xóa?', 'Thông báo', function(r) {
                if (r) {
                    loading_show();

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
