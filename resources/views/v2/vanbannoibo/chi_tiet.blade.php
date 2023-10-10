@extends(config('app.interface') . 'templates.layout')
@section('title', 'Chi tiết văn bản')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/v2/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/custom.css') }}">
@endsection
@section('content')
    <div class="container-fluid detail-page">
        <!-- Link and search bar -->
        <div class="row group-function mx-0">
            <div class="col-md-8 offset-sx-12 breadcrumbs mx-0 px-0">
                <div class="breadcrumbs-link">
                    <div><a href="" class="txt-link">Điều hành tác nghiệp</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">Văn bản nội bộ</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">Xem chi tiết văn bản nội bộ</a></div>
                </div>
            </div>
        </div>
        <div class="row header-detail">
            <h4>Chi tiết văn bản nội bộ</h4>
            <ul class="nav nav-tabs tab-details" id="nav-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="infor-tab" data-bs-toggle="tab" data-bs-target="#infor"
                        type="button" role="tab" aria-controls="home" aria-selected="true">Thông tin về văn bản
                        đến</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="branch-tab" data-bs-toggle="tab" data-bs-target="#branch" type="button"
                        role="tab" aria-controls="profile" aria-selected="false">Thông tin luân chuyển</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                        role="tab" aria-controls="contact" aria-selected="false">Trao đổi văn bản</button>
                </li>
            </ul>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="infor" role="tabpanel" aria-labelledby="infor-tab">
                    <div class="row body-content">
                        <table class="table-main">
                            <tbody>
                                <tr>
                                    <th class="title-field">Trích yếu</th>
                                    <td class="content-field" data-name="Trích yếu">{{ $vanbanden->title }}</td>
                                    <th class="title-field">Độ khẩn</th>
                                    <td class="content-field" data-name="Độ khẩn">
                                        <?php if($combobox[$vanbanden->urgency] =='Bình Thường') { ?>
                                        <span class="normal-urgency">{{ $combobox[$vanbanden->urgency] }}</span>
                                        <?php } elseif($combobox[$vanbanden->urgency] =='Khẩn') {?>
                                        <span class="urgent">{{ $combobox[$vanbanden->urgency] }}</span>
                                        <?php } elseif($combobox[$vanbanden->urgency] =='Thượng Khẩn') {?>
                                        <span class="urgency">{{ $combobox[$vanbanden->urgency] }}</span>
                                        <?php } elseif($combobox[$vanbanden->urgency] =='Hỏa Tốc') {?>
                                        <span class="express-urgency">{{ $combobox[$vanbanden->urgency] }}</span>
                                        <?php }?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="title-field">Ngày ban hành</th>
                                    <td class="content-field" data-name="Ngày ban hành">
                                        {{ formatdmYY($vanbanden->ngayden) }}</td>
                                    <th class="title-field">Loại văn bản</th>
                                    <td class="content-field" data-name="Loại văn bản">
                                        <?php
                                        $loaivanban = App\Loaivanban::where('id', $vanbanden->loaivanban_id)
                                            ->get()
                                            ->toArray();
                                        ?>
                                        {{ $loaivanban['0']['name'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="title-field">Nơi ban hành</th>
                                    <td class="content-field" data-name="Nơi ban hành">{{ $vanbanden->cq_banhanh }}</td>
                                    <th class="title-field">Hạn xử lý</th>
                                    <td class="content-field" data-name="Hạn xử lý">{{ formatdmYY($vanbanden->hanxuly) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="title-field">Số ký hiệu</th>
                                    <td class="content-field" data-name="Số ký hiệu">{{ $vanbanden->kyhieu }}</td>
                                    <th class="title-field">Trạng thái</th>
                                    <td class="content-field" data-name="Trạng thái">
                                        <?php if($vanbanden->trangthai === 1){?>
                                        <span class="doNotAction">Chưa xử lý</span>
                                        <?php } elseif($vanbanden->trangthai === 2){?>
                                        <span class="doingAction">Đang xử lý</span>
                                        <?php } elseif($vanbanden->trangthai === 3){?>
                                        <span class="doneAction">Đã xử lý</span>
                                        <?php }?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="title-field">Ngày ký</th>
                                    <td class="content-field" data-name="Ngày ký">{{ formatdmYY($vanbanden->ngayky) }}</td>
                                    <th class="title-field">Người ký</th>
                                    <td class="content-field" data-name="Người ký">{{ $vanbanden->nguoiky }}</td>
                                </tr>
                                <tr>
                                    <th class="title-field">Ghi chú</th>
                                    <td class="content-field" data-name="Ghi chú">{{ $vanbanden->note }}</td>
                                    <th class="title-field">File văn bản</th>
                                    <td class="content-field" data-name="File văn bản">
                                        <div class="content-file-field">
                                            @php
                                                $files = explode(';', $vanbanden->file_dinhkem);
                                                foreach ($files as $key => $file) {
                                                    echo sprintf('<a href="%s" target="_blank" title="%s">%s</a>', route('dowload.file', [$file, 'vanban_id' => $id, 'numberFile' => $key]), $file, $key + 1 . ' - ' . $file);
                                                }
                                            @endphp
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="title-field">Đơn vị chủ trì</th>
                                    <td class="content-field" data-name="Đơn vị chủ trì">
                                        {{ $vanbanden->donviChuTriName }}</td>
                                    <th class="title-field">Người chủ trì</th>
                                    <td class="content-field" data-name="Người chủ trì">
                                        <div>
                                            @foreach ($userChuTris as $user)
                                                <div class="item-user"><b>{{ $user->fullname }}</b> -
                                                    {{ $user->donvi->name }} - <span
                                                        class="email-user">{{ $user->email }}</span></div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="title-field">Đơn vị phối hợp</th>
                                    <td class="content-field" data-name="Đơn vị phối hợp">
                                        <div>
                                            @foreach ($donviPhoihops as $donvi)
                                                <div class="item-donvi">{{ $donvi->name }}</div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <th class="title-field">Người phối hợp</th>
                                    <td class="content-field" data-name="Người phối hợp">
                                        <div>
                                            @foreach ($userPhoihops as $user)
                                                <div class="item-user"><b>{{ $user->fullname }}</b> -
                                                    {{ $user->donvi->name }} - <span
                                                        class="email-user">{{ $user->email }}</span></div>
                                            @endforeach
                                        </div>
                                    </td>
                                <tr>
                                    <th class="title-field td-review">Nội dung bút phê</th>
                                    <td colspan="3" class="content-field" data-name="Nội dung bút phê">
                                        @if (sizeof($vbxuly->butphes))
                                            <div>
                                                <table class="table border sub-table-field">
                                                    <thead>
                                                        <tr>
                                                            <th style="max-width: 120px;">Ngày giờ</th>
                                                            <th style="max-width: 180px;">Người gửi</th>
                                                            <th style="max-width: 320px;">Người nhận</th>
                                                            <th>Nội dung</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($vbxuly->butphes as $butphe)
                                                            <tr>
                                                                <td class="subcontent-field" data-name="Ngày giờ">
                                                                    {{ $butphe->created_at_text }}</td>
                                                                <td class="subcontent-field" data-name="Người gửi">
                                                                    {{ $butphe->userTao->fullname }}</td>
                                                                <td class="subcontent-field" data-name="Người nhận">
                                                                    {{ implode(', ', $butphe->userNhans) }}</td>
                                                                <td class="subcontent-field" data-name="Nội dung">
                                                                    {!! nl2br($butphe->noidung) !!}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row btn-function-group">
                        <div>
                            @if ($vanbanden->user_id == session('user')['id'])
                                <a href="{{ url('vanbannoibo/sua', $vanbanden->id) }}" title="Sửa văn bản"
                                    class="btn btn-default btn-primary"><i class="fa-solid fa-pen-to-square fa-icon"></i>
                                    <span>Sửa
                                        văn bản</span></a>
                                <a href="javascript:;" onclick="showModalGuiLaiMail()" title="Gửi lại mail"
                                    class="btn  btn-default btn-primary"><i
                                        class="fa-regular fa-envelope fa-icon"></i><span>Gửi lại
                                        mail</span></a>
                            @endif
                            <a href="{{ url('vanbannoibo/chuyen-xu-ly', $vanbanden->id) }}" title="Chuyển xử lý văn bản"
                                class="btn  btn-default btn-primary"><i
                                    class="fa-solid fa-share-from-square fa-icon"></i><span>Chuyển
                                    xử lý văn bản</span></a>
                            <a onclick="showModalChuyenTrangThaiVanBan({{ $vanbanden->idVBUser }})"
                                title="Đã nhận thông tin văn bản" class="btn  btn-default btn-primary"><i
                                    class="fa-solid fa-file-circle-check fa-icon"></i><span>Xử lý văn bản</span></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="branch" role="tabpanel" aria-labelledby="branch-tab">
                    <div class="body-content">
                        <table class="table branch-table table-bordered">
                            <thead>
                                <tr>
                                    <th class="title-tranfer" style="min-width: 80px">Người gửi</th>
                                    <th class="title-tranfer" style="min-width: 140px">Đơn vị/Cá nhân nhận</th>
                                    <th class="title-tranfer" style="min-width: 150px">Thời gian gửi/nhận</th>
                                    <th class="title-tranfer">Trạng thái</th>
                                    <th class="title-tranfer">Minh chứng</th>
                                    <th class="title-tranfer">File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vb_child as $vanbanxuly)
                                    <tr>
                                        <td class="sub-field" data-name="Người gửi">{{ $vanbanxuly->nameUserGui }}</td>
                                        <td class="sub-field" data-name="Đơn vị/Cá nhân nhận">
                                            {{ $vanbanxuly->nameUserNhan }} <br>
                                            {{ $vanbanxuly->tenDonVi }}</td>
                                        <td class="sub-field" data-name="Thời gian gửi/nhận">
                                            <div class="d-flex flex-column">
                                                <i>{{ formatDMY($vanbanxuly->ngaygui) }}</i>
                                                <i><b>{{ isset($vanbanxuly->ngayxem) ? formatDMY($vanbanxuly->ngayxem) : '' }}</b></i>
                                            </div>
                                        </td>
                                        <td class="sub-field" data-name="Trạng thái">
                                            <div class="d-flex flex-column">
                                                <?php if($vanbanxuly->status == 1){?>
                                                <span class="doNotAction">Chưa xử lý</span>
                                                <?php } elseif($vanbanxuly->status == 2){?>
                                                <span class="doNotAction">Chưa xử lý</span>
                                                <?php } elseif($vanbanxuly->status == 3){?>
                                                <span class="doneAction">Đã xử lý</span>
                                                <i>{{ formatDateTimeToDisplay($vanbanxuly->ngayxuly) }}</i>
                                                <?php }?>
                                            </div>
                                        </td>
                                        @if ($vanbanxuly->status == 3)
                                            <td class="sub-field" data-name="Minh chứng">{!! nl2br($vanbanxuly->minhchung) !!}</td>
                                            <td class="sub-field" data-name="File">
                                                @if ($vanbanxuly->file_minhchung)
                                                    <a href="{{ route('dowload.file', [$vanbanxuly->file_minhchung]) }}"
                                                        target="_blank" title="{{ $vanbanxuly->file_minhchung }}">
                                                        <i class="fa fa-paperclip"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        @else
                                            <td class="sub-field" data-name="Minh chứng"></td>
                                            <td class="sub-field" data-name="File"></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row btn-function-group">
                            <div>
                                <button onclick="quyTrinhChuyenTiep('{{ $id }}','{{ $parentId->id_nhan }}')"
                                    class="btn btn-default btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#process-thread"><i class="fa-solid fa-code-branch fa-icon"></i>
                                    Luồng luân chuyển</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="body-content">
                        @include(config('app.interface') . 'vanban.chi_tiet_van_ban_den_tab_y_kiens', [
                            'vbxuly' => $vbxuly,
                        ])
                    </div>
                </div>
            </div>
        </div>

        <div id="XuLyVanBan" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        </div>

        <div id="ModalGuiLaiMail" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content status-modal">
                    <div class="modal-header">
                        <h1 class="modal-title d-flex fs-5">
                            <div class="tag"
                                style="width: 12px; height: 32px; position: relative; background: #1668C7; border-radius: 4px">
                            </div>
                            <div class="text-title-cal">Gửi lại mail</div>
                        </h1>
                        <div class="icon-background" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark fa-lg"></i>
                        </div>
                    </div>
                    <div class="modal-body" style="min-width: 100%;max-width: 100%;overflow: auto;">
                        <div class="d-flex flex-column justify-content-center">
                            <h6>Bạn có muốn gửi lại những mail sau:</h6>
                            <div>
                                @foreach ($userChuTris as $user)
                                    <p>- <b>{{ $user->fullname }} </b>
                                        {{ ' - ' . $user->donvi->name . ' - ' . $user->email }}</p>
                                @endforeach
                                @foreach ($userPhoihops as $user)
                                    <p>- <b>{{ $user->fullname }} </b>
                                        {{ ' - ' . $user->donvi->name . ' - ' . $user->email }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger me-1" style="font-size: 13px"
                            data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-default btn-primary" onclick="guiLaiMail()">Đồng ý</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include(config('app.interface') . 'components.modal_luong')
@stop
@section('scripts')
    <script>
        function showModalGuiLaiMail() {
            $('#ModalGuiLaiMail').modal('show');
        }

        function guiLaiMail() {
            // loading_show();
            $('#ModalGuiLaiMail').modal('hide');

            $.post("{{ route('gui_lai_mail', [$vbxuly->vanbanUser_id]) }}", {
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function(res) {
                // loading_hide();
                if (!res.error) {
                    jAlert('Mail đã được gửi', 'Thông báo');
                } else {
                    jAlert('Không thể gửi mail', 'Thông báo');
                }
            });
        }

        function sendInfo($id, $type) {
            alert($type);
            var url = "{{ url('vanban/' . $vanbanden->idVBUser . '/sendInfo') }}";
            var id = $id;
            var type = $type;
            var token = '{{ csrf_token() }}';

            loading_show();
            $.post(url, {
                'id': id,
                'type': type,
                '_token': token
            }, function(data) {
                loading_hide();
                if (data.error == 0) {
                    location.reload(true);
                    jAlert('{!! trans('Cập nhật tình trạng thành công') !!}', '{!! trans('Thông báo') !!}');
                } else {
                    jAlert('{!! trans('Cập nhật thất bại') !!}', '{!! trans('Thông báo') !!}');
                }
            }, 'json');
        }

        function showModalChuyenTrangThaiVanBan(vanbanxulyId) {
            let $modal = $('#XuLyVanBan');
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            // loading_show();
            $.post("{{ route('vanban.check_xu_ly_vanban') }}", {
                vanbanxuly_id: vanbanxulyId,
                _token: CSRF_TOKEN
            }, function(html) {
                // loading_hide();
                $modal.html(html);
                $modal.modal('show');
            });
        }

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
    </script>
@endsection
