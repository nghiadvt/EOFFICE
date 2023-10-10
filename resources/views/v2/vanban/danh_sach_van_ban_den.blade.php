@extends(config('app.interface') . 'templates.layout')
@section('title', 'Danh sách văn bản đến')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/v2/list_doc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/custom.css') }}">
@endsection
@section('content')
    <div class="container-flud income-pages mx-0">
        <!-- Link and search bar -->
        <div class="row group-function mx-0">
            <div class="col-md-8 offset-sx-12 breadcrumbs mx-0 px-0">
                <div class="breadcrumbs-link">
                    <div><a href="" class="txt-link">Điều hành tác nghiệp</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">Văn bản đến</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">Danh sách văn bản đến</a></div>
                </div>
                <div class="title-page">Danh sách văn bản đến</div>
            </div>
            @php
                $tukhoa = isset($_GET['tukhoa']) ? $_GET['tukhoa'] : '';
                $trangthai = isset($_GET['trangthai']) ? $_GET['trangthai'] : '';
                $linhvucId = isset($_GET['linhvuc']) ? $_GET['linhvuc'] : '';
                $loaivanbanId = isset($_GET['loaivanban']) ? $_GET['loaivanban'] : '';
                $ngaybanhanhtu = isset($_GET['ngaybanhanhtu']) ? $_GET['ngaybanhanhtu'] : '';
                $ngaybanhanhden = isset($_GET['ngaybanhanhden']) ? $_GET['ngaybanhanhden'] : '';
                $ngayguitu = isset($_GET['ngayguitu']) ? $_GET['ngayguitu'] : '';
                $ngayguiden = isset($_GET['ngayguiden']) ? $_GET['ngayguiden'] : '';
            @endphp
            <div class="col-md-4 col-sx-12 btn-search mx-0 px-0">
                <div class="search-bar">
                    <form method="get" action="{{ route('danhsach.vanbanden') }}">
                        <i class="fa-solid fa-magnifying-glass icon"></i>
                        @php $tukhoa = isset($_GET['tukhoa'])? $_GET['tukhoa'] : '' @endphp
                        <input  type="text" name="tukhoa" placeholder="Tìm kiếm số ký hiệu hoặc trích yếu"
                            value="{{ $tukhoa }}" >

                    </form>
                </div>
                <div class="btn btn-primary" id="btn-filter-form">
                    <img src="{{ asset('img/assets/icon/Iconfitler.png') }}" alt="hình ảnh">
                    <span
                        class="txt-hidden">Lọc</span></div>
            </div>
        </div>
        <!-- table list document -->
        <div class="row table-list-documents mx-0">
            <table class="table-content">
                <thead>
                    <tr class="field-title">
                        <th class="num-doc">STT</th>
                        <th class="no-doc">Số đến</th>
                        <th class="type-doc">Loại văn bản</th>
                        <th class="chairman-doc">Đơn vị chủ trì</th>
                        <th class="code-doc">Số ký hiệu</th>
                        <th class="date-doc">Ngày ban hành</th>
                        <th class="content-doc">Trích yếu</th>
                        <th class="exp-doc">Hạn xử lý</th>
                        <th class="status-doc">Trạng thái</th>
                        <th class="action-doc"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (sizeof($vanbans))
                        @php $stt = ($vanbans->currentPage() - 1) * $vanbans->perPage() + 1 @endphp
                        @foreach ($vanbans as $stt => $val)
                            <tr class="item item-container">
                                <td class="attribute field-num" data-name="STT">{{ $stt + 1 }}</td>
                                <td class="attribute field-no" data-name="Số đến"><a
                                        href="{{ route('chitiet_vanban', $val->vanbanUser_id) }}">{{ $val->vanban->soden }}{!! !$val->ngayxem ? '<div style="font-size:11px;color:red;">Chưa đọc</div>' : '' !!}</a>
                                </td>
                                <td class="attribute field-type" data-name="Loại văn bản">
                                    {{ $val->vanban->loaivanban ? $val->vanban->loaivanban->name : '' }}</td>
                                <td class="attribute field-chairman" data-name="Đơn vị chủ trì">
                                    {{ $val->vanban->donviChuTri ? $val->vanban->donviChuTri->name : '' }}</td>
                                <td class="attribute field-code" data-name="Số ký hiệu"><a
                                        href="{{ route('chitiet_vanban', $val->vanbanUser_id) }}"
                                        title="{{ $val->vanban->kyhieu }}">{{ $val->vanban->kyhieu }}</a></td>
                                <td class="attribute field-date" data-name="Ngày ban hành">{{ $val->vanban->ngayky }}</td>
                                <td class="attribute field-content" data-name="Trích yếu">{{ $val->vanban->title }}</td>
                                <td class="attribute field-exp" data-name="Hạn xử lý">
                                    {{ $val->vanban->hanxuly }}<br>
                                    @if ($status == 'ganhethan')
                                        <?php
                                        $date1 = new DateTime(formatYMD($val->vanban->hanxuly));
                                        $date2 = new DateTime(date('Y-m-d'));
                                        $interval = $date1->diff($date2);
                                        $tgquahan = $interval->m > 0 ? $interval->m . ' tháng, ' . $interval->d . ' ngày' : $interval->d . ' ngày'; ?>
                                        @if ($interval->m > 0 || $interval->format('%R%d') > 0)
                                            <span class="text-quahanxuly"> (Quá hạn <?php echo $tgquahan; ?>)</span>
                                        @else
                                            <span class="text-conhanxuly"> (Còn <?php echo $tgquahan; ?>)</span>
                                        @endif
                                    @endif
                                </td>
                                </td>
                                <td class="attribute field-status" data-name="Trạng thái">
                                    @if ($val->vanban->publish_id != 5)
                                        @if ($val->status == 1)
                                            <a href="javascript:;"
                                                onclick="showModalChuyenTrangThaiVanBan({{ $val->id }})"
                                                class="<?php echo $status == 'ganhethan' ? 'disabled' : ''; ?> doNotAction lh36">Chưa xử lý</a>
                                        @elseif ($val->status == 2)
                                            <a href="javascript:;"
                                                onclick="showModalChuyenTrangThaiVanBan({{ $val->id }})"
                                                class="<?php echo $status == 'ganhethan' ? 'disabled' : ''; ?> doingAction lh36">Đang xử lý</a>
                                        @elseif ($val->status == 3)
                                            <a href="javascript:;"
                                                onclick="showModalChuyenTrangThaiVanBan({{ $val->id }})"
                                                class="<?php echo $status == 'ganhethan' ? 'disabled' : ''; ?> doneAction lh36">Đã xử lý</a>
                                        @endif
                                    @else
                                        <a href="javascript:;" class="doNotAction lh36">Chỉ xem</a>
                                    @endif
                                </td>
                                <!-- <td class="attribute field-status" data-name="Trạng thái">
                                                                                                                                                            <select class="form-select" id="select-status">
                                                                                                                                                                <option value="1" selected>Đã xử lý</option>
                                                                                                                                                                <option value="2">Đang xử lý</option>
                                                                                                                                                                <option value="3">Chưa xử lý</option>
                                                                                                                                                            </select>
                                                                                                                                                        </td> -->
                                <td class="attribute field-action" data-name="">
                                    <div class="dropdown">
                                        <button class="btn btn-menu" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical img-action"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if ($val->vanban->file_dinhkem)
                                                <li>
                                                    @php
                                                        $files = explode(';', $val->vanban->file_dinhkem);
                                                        foreach ($files as $key => $file) {
                                                            echo sprintf('<a class="dropdown-item more-option" href="%s" target="_blank" title="%s"><i class="fa-solid fa-landmark"></i>Mở file</a>', route('dowload.file', [$file, 'vanban_id' => $val->vanbanUser_id, 'numberFile' => $key]), $file, $file);
                                                        }
                                                    @endphp
                                                </li>
                                            @endif
                                            @if ($val->vanban->publish_id != 5)
                                                <li><a class="dropdown-item more-option" href="javascript:;"
                                                        onclick="quyTrinhChuyenTiep('{{ $val->vanbanUser_id }}')"
                                                        title="Xem quy trình chuyển xử lý" data-bs-toggle="modal"
                                                        data-bs-target="#process-thread"><i
                                                            class="fa-solid fa-code-branch fa-icon"></i>Xem luồng</a></li>
                                            @endif
                                            @if ($val->vanban->publish_id != 5)
                                                <li>
                                                    @if ($status == 'ganhethan')
                                                        <a class="disabled" href="javascript:;"><i
                                                                class="fa fa-paper-plane"></i></a>
                                                    @else
                                                        <a class="dropdown-item more-option"
                                                            href="{{ route('chuyen_xu_ly_van_ban', $val->vanbanUser_id) }}"
                                                            title="Chuyển xử lý văn bản"><i
                                                                class="fa-solid fa-share-from-square"></i>Chuyển tiếp</a>
                                                    @endif
                                                </li>
                                            @endif
                                            <li><a class="dropdown-item more-option"
                                                    href="{{ route('chitiet_vanban', $val->vanbanUser_id) }}"
                                                    title="Xem chi tiết"><i class="fa-solid fa-eye"></i>Xem chi tiết</a>
                                            </li>
                                            @if ($val->vanban->user_id == session('user')['user_id_login'])
                                                <li><a class="dropdown-item more-option"
                                                        onclick="thuHoiVanBan({{ $val->vanbanUser_id }})"
                                                        title="Xem chi tiết"><i class="fa-solid fa-rotate-left"></i>Thu
                                                        hồi</a></span>
                                            @endif
                                            <li><a class="dropdown-item del-item" title="Xóa"><i
                                                        class="fa-solid fa-trash-can"></i>Xóa</a></span>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="14" align="center"><i> Không có văn bản đến cần xử lý</i></td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="row pagination-page mx-0">
                <div class="pagination" max-visible="5">
                    {{ $vanbans->links() }}
                </div>
            </div>
        </div>
        <div id="XuLyVanBan" class="modal fade" role="dialog">

        </div>
        <!-- Advanced Filtering -->
        <div class="toggle-body"></div>
        <div class="search-filter-form" id="filter-form" >
            <div class="group-title-filter">
                <div class="group-title">
                    <div class="icon-title-filter"></div>
                    <div class="title-filter" style="font-size: 18px">Bộ lọc nâng cao</div>
                </div>
                <div class="btn btn-close" aria-label="Close"></div>
            </div>
            
            <form action="{{ route('danhsach.vanbanden') }}" method="get" >
                <div class="form-chinh advanced-search">
                <input type="hidden" name="status" value="{{ $status }}">
                <div class="label-search">Lĩnh vực</div>
                @php $linhvucId = isset($_GET['linhvuc'])? $_GET['linhvuc'] : '' @endphp
                <select name="linhvuc" id="linhvuc_search" class="select chosen">
                    <option value=""> Tất cả </option>
                    @foreach ($linhvucs as $linhvuc)
                        <option value="{{ $linhvuc->id }}" {{ $linhvucId == $linhvuc->id ? 'selected' : '' }}>
                            {{ $linhvuc->name }}</option>
                    @endforeach
                </select>
                <div class="label-search">Loại văn bản</div>
                @php $loaivanbanId = isset($_GET['loaivanban'])? $_GET['loaivanban'] : '' @endphp
                <select class="select chosen" name="loaivanban" id="loaivanban_search">
                    <option value=""> Tất cả </option>
                    @foreach ($loaivanbans as $loaivanban)
                        <option value="{{ $loaivanban->id }}" {{ $loaivanbanId == $loaivanban->id ? 'selected' : '' }}>
                            {{ $loaivanban->name }}</option>
                    @endforeach
                </select>
                <div class="under-line"></div>
                <div class="label-search">Trạng thái</div>
                <div>
                    @php $trangthai = isset($_GET['trangthai'])? $_GET['trangthai'] : '' @endphp
                    <label class="checkbox-label">
                        <div class="txt-status">Chưa xử lý</div>
                        <input type="checkbox" {{ $trangthai == 'chuaxuly' ? 'selected' : '' }} name="trangthai"
                            value="chuaxuly">
                        <div class="checkbox"></div>
                    </label>
                </div>
                <div>
                    <label class="checkbox-label">
                        <div class="txt-status">Đang xử lý</div>
                        <input type="checkbox" {{ $trangthai == 'dangxuly' ? 'selected' : '' }} name="trangthai"
                            value="dangxuly">
                        <div class="checkbox"></div>
                    </label>
                </div>
                <div>
                    <label class="checkbox-label">
                        <div class="txt-status">Đã xử lý</div>
                        <input type="checkbox" {{ $trangthai == 'daxuly' ? 'selected' : '' }} name="trangthai"
                            value="daxuly">
                        <div class="checkbox"></div>
                    </label>
                </div>
                <div class="under-line"></div>
                <div class="label-search">Ngày ban hành</div>
                <div class="search-date-decree">
                    @php $ngaybanhanhtu = isset($_GET['ngaybanhanhtu'])? $_GET['ngaybanhanhtu'] : '' @endphp
                    <input type="text" autocomplete="off" id="startDate" placeholder="dd/mm/yyyy" value="" name="ngaybanhanhtu" data-date-format="DD MM YYYY">
                    <span style="padding-right:7px">đến</span>
                    @php $ngaybanhanhden = isset($_GET['ngaybanhanhden'])? $_GET['ngaybanhanhden'] : '' @endphp
                    <input type="text" autocomplete="off" id="endDate" placeholder="dd/mm/yyyy" value="" name="ngaybanhanhden" data-date-format="DD MM YYYY">
                </div>
                <div class="label-search">Hạn xử lý</div>
                <div class="search-date-decree">
                    @php $ngayguitu = isset($_GET['ngayguitu'])? $_GET['ngayguitu'] : '' @endphp
                    <input type="text" autocomplete="off" id="startDateExp" placeholder="dd/mm/yyyy" name="ngayguitu" value="" data-date-format="DD MM YYYY">
                    <span style="padding-right:7px">đến</span>
                    @php $ngayguiden = isset($_GET['ngayguiden'])? $_GET['ngayguiden'] : '' @endphp
                    <input type="text" autocomplete="off" id="endDateExp" placeholder="dd/mm/yyyy" name="ngayguiden" value="" data-date-format="DD MM YYYY">
                </div>
                <div class="footer "> <button class="btn btn-primary btn-submit" style="position: fixed; bottom: 10px;  width: 350px" id="search" type="submit">Tìm kiếm</button></div>
            </div>
                {{-- <button class="btn btn-primary btn-submit" id="search" type="submit">Tìm kiếm</button> --}}
            </form>
        </div>
    </div>
    @include(config('app.interface') . 'components.modal_luong')
@stop
@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('js/v2/enter.js')}}"></script>
    <script src="{{ asset('js/v2/list_doc.js') }}"></script>
    <script>
        
 $(function () {
            $('#startDate').datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $('#endDate').datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $('#startDateExp').datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $('#endDateExp').datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });

          
        $('#search').click(function() {
            var tukhoa = $('#tukhoa').val();
            var timtheo = $('#timtheo').val();
            var linhvuc = $('#linhvuc_search').val();
            var loaivanban = $('#loaivanban_search').val();
            var ngaybh_tu = $('#ngaybh_tu').val();
            var ngaybh_den = $('#ngaybh_den').val();
            var hienthi = $('#hienthi_search').val();
            var status = $('#status_search').val();
            var token = '{{ csrf_token() }}';
            var url = '{{ route('ajax_dsvanban') }}';
            $.post(url, {
                'tukhoa': tukhoa,
                'timtheo': timtheo,
                'linhvuc': linhvuc,
                'loaivanban': loaivanban,
                'ngaybh_tu': ngaybh_tu,
                'ngaybh_den': ngaybh_den,
                'hienthi': hienthi,
                'status': status,
                '_token': token
            }, function(data) {

            });
        });
        //   $('div.alert').not('.alert-important').delay(2000).fadeOut(350);

        function quyTrinhChuyenTiep(Id, userId) {
            url = '{{ url('vanban/quy_trinh_chuyen_tiep') }}';
            //   loading_show();
            $.get(url, {
                'Id': Id,
                'userId': userId
            }, function(data) {
                // loading_hide();
                $('.process-thread .thread-modal .modal-body').html(data);
            });
        }
        function showModalChuyenTrangThaiVanBan(vanbanxulyId) {
            let $modal = $('#XuLyVanBan');
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            //   loading_show();
            $.post("{{ route('vanban.check_xu_ly_vanban') }}", {
                vanbanxuly_id: vanbanxulyId,
                _token: CSRF_TOKEN
            }, function(html) {
                loading_hide();
                $modal.html(html);
                $modal.modal('show');
            });
        }

        function thuHoiVanBan(id) {
            jConfirm('Bạn có muốn thu hồi văn bản này?', 'Thông báo', function(r) {
                if (r) {
                    //   loading_show();

                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.post("{{ route('vanban.thuhoivanban') }}", {
                        id: [id],
                        _token: CSRF_TOKEN
                    }, () => {
                        location.reload();
                    }, 'json');
                }
            });
        }
    </script>
@endsection
