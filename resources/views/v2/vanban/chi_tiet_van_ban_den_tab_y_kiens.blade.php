@php
    $loggedUser = (object) session('user');
@endphp

<!-- button Thêm trao đổi -->
<div class="d-flex justify-content-end mb-2">
    <button type="button" class="btn-contact btn" onclick="showModalFormAddYKien({{ $vbxuly->id }})"
        {{-- data-bs-toggle="modal" data-bs-target="#add-contact" --}}>
        <i class="fa-solid fa-plus"></i> Thêm trao đổi</button>
</div>
<!-- danh sách trình lãnh đạo và ý kiến của mỗi trình lãnh đạo -->
<table class="table contact-table table-bordered">
    <thead>
        <tr>
            <th class="title-tranfer">STT</th>
            <th class="title-tranfer">Thời gian</th>
            <th class="title-tranfer">Người tạo</th>
            <th class="title-tranfer">Người nhận</th>
            <th class="title-tranfer" style="min-width: 150px">Nội dung</th>
            <th class="title-tranfer">Tập tin</th>
            <th class="title-tranfer">Trả lời</th>
        </tr>
    </thead>
    <tbody>
        @if (count($ykiens) > 0)
            @php
                // dd($ykiens)
            @endphp
            <!-- danh sách ý kiến của vanbanxuly -->
            @foreach ($ykiens as $key => $ykien)
                <tr>
                    <td class="sub-field" data-name="STT">{{ $key + 1 }}</td>
                    <td class="sub-field" data-name="Thời gian">{{ $ykien->created_at }}</td>
                    <td class="sub-field" data-name="Người tạo">{{ $ykien->userTao->fullname }}</td>
                    <td class="sub-field" data-name="Người nhận">
                        <div class="pe-1 pt-1">
                            @php
                                foreach ($ykien->userNhans as $key => $value) {
                                    if ($key > 2) {
                                        break;
                                    }
                                    echo sprintf('<div class="item-user">' . $value->fullname . '</div>');
                                }
                                if (count($ykien->userNhans) > 3) {
                                    $newArr = [];
                                    foreach ($ykien->userNhans as $item) {
                                        $newArr[] = ['fullname' => $item['fullname'], 'chucdanh' => $item['chucdanh'], 'email' => $item['email']];
                                    }
                                    $newArr = json_encode($newArr);
                                    echo sprintf('<div class="full-item-user item-usnhan hover-effect" data-content="' . htmlspecialchars($newArr) . '" >+' . (count($ykien->userNhans) - 3) . '</div>');
                                }
                            @endphp
                        </div>
                    </td>
                    <td class="sub-field" data-name="Nội dung">{!! nl2br($ykien->noidung) !!}</td>
                    <td class="sub-field" data-name="Tập tin">
                        @php $files = @unserialize($ykien->file); @endphp
                        @if (is_array($files))
                            @foreach ($files as $key => $file)
                                <a class="text-break" download=""
                                    href="{{ url('local/files', $file) }}">{{ $file }}</a>
                            @endforeach
                        @else
                            <a class="text-break" download=""
                                href="{{ url('local/files', $ykien->file) }}">{{ $ykien->file }}</a>
                        @endif
                    </td>
                    <td>
                        <div class="full-item-user btn-reply" data-users="{{ json_encode($userIdsTrongLuong) }}">
                            <i class="fa-solid fa-reply-all"></i>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" align="center"><i>Chưa có nội dung trao đổi văn bản.</i></td>
            </tr>
        @endif
    </tbody>
</table>

<div class="show-list-users">
    <!-- Modal hien thi nguoi nhan -->
    <div class="modal fade" id="show-list-users" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content contact-modal">
                <div class="modal-header">
                    <h1 class="modal-title d-flex fs-5">
                        <div class="tag"
                            style="width: 12px; height: 32px; position: relative; background: #1668C7; border-radius: 4px">
                        </div>
                        <div class="text-title-cal">Danh sách người nhận</div>
                    </h1>
                    <div class="icon-background" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-lg"></i>
                    </div>
                </div>
                <div class="modal-body" style="min-width: 100%;max-width: 100%;overflow: auto;">
                    <div class="d-flex flex-column justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="add-contact">
    <!-- Modal Them trao doi van ban -->
    <div class="modal fade" id="add-contact" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content thread-modal">
                <div class="modal-header">
                    <h1 class="modal-title d-flex fs-5">
                        <div class="tag"
                            style="width: 12px; height: 32px; position: relative; background: #1668C7; border-radius: 4px">
                        </div>
                        <div class="text-title-cal">Thêm trao đổi văn bản</div>
                    </h1>
                    <div class="icon-background" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-lg"></i>
                    </div>
                </div>
                <div class="modal-body" style="min-width: 100%;max-width: 100%;overflow: auto;">
                    <div class="d-flex flex-column justify-content-center">
                        <form class="form-contact" action="{{ route('trinh_lanh_dao.save_ykien') }}" method="POST"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="">
                            <input type="hidden" name="vanban_id" value="{{ $vbxuly->vanbanUser_id }}">
                            <input type="hidden" name="vanbanxuly_id" value="">
                            <div class="mb-3">
                                <label for="list-user" class="form-label">Người nhận</label>
                                <select name="receiver_ids[]" id="list-user" class="form-control chosen" multiple>
                                    @foreach ($userReceivers as $val)
                                        <option value="{{ $val->id }}">
                                            {{ $val->fullname . ($val->chucdanh ? ' - ' . $val->chucdanh . ' - ' : '') . $val->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Nội dung</label>
                                <textarea class="form-control" id="content" name="noidung" cols="30" rows="5"
                                    placeholder="Nhập nội dung ý kiến"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="inputFile" class="form-label">Chọn tệp</label>
                                <input class="form-control" name="file[]" type="file"
                                    accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" id="inputFile" multiple="">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn-contact btn">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="reply-contact">
    <!-- Modal Tra loi trao doi van ban -->
    <div class="modal fade" id="reply-contact" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content thread-modal">
                <div class="modal-header">
                    <h1 class="modal-title d-flex fs-5">
                        <div class="tag"
                            style="width: 12px; height: 32px; position: relative; background: #1668C7; border-radius: 4px">
                        </div>
                        <div class="text-title-cal">Phản hồi</div>
                    </h1>
                    <div class="icon-background" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-lg"></i>
                    </div>
                </div>
                <div class="modal-body" style="min-width: 100%;max-width: 100%;overflow: auto;">
                    <div class="d-flex flex-column justify-content-center">
                        <form class="form-contact" action="{{ route('trinh_lanh_dao.save_ykien') }}" method="POST"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="">
                            <input type="hidden" name="vanban_id" value="{{ $vbxuly->vanbanUser_id }}">
                            <input type="hidden" name="vanbanxuly_id" value="">
                            <div class="mb-3">
                                <label for="list-user" class="form-label">Người nhận</label>
                                <select name="receiver_ids[]" id="list-user" class="form-control chosen" multiple>
                                    @foreach ($userReceivers as $val)
                                        <option value="{{ $val->id }}">
                                            {{ $val->fullname . ($val->chucdanh ? ' - ' . $val->chucdanh . ' - ' : '') . $val->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Nội dung</label>
                                <textarea class="form-control" id="content" name="noidung" cols="30" rows="5"
                                    placeholder="Nhập nội dung ý kiến"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="inputFile" class="form-label">Chọn tệp
                                </label>
                                <input class="form-control" name="file[]" type="file"
                                    accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" id="inputFile" multiple="">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn-contact btn">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

    /* .usernhands-read {
        float: right;
        font-size: 12px;
        font-style: italic;
    } */

    .chosen-container-multi .chosen-choices li.search-field input[type="text"].default {
        width: 190px !important;
    }
</style>
<script>
    $('.chosen').chosen({
        no_results_text: 'Không tìm thấy kết quả',
        'placeholder_text_multiple': 'Chọn một hoặc nhiều người',
        width: '100%',
        search_contains: true
    });

    $('.item-usnhan').click(function() {
        let arr = JSON.parse($(this).attr('data-content'));
        let $modalDSUserNhan = $('#show-list-users');

        var content = "";
        arr.map((val) => {
            content += `<div class="modal-item">
                            <b>${val.fullname}</b>&nbsp- &nbsp
                            <b>${val.chucdanh}</b>&nbsp- &nbsp
                            <div class="text-primary">${val.email}</div>
                        </div>`
        })
        $modalDSUserNhan.find('.modal-body .flex-column').html(content);
        $modalDSUserNhan.modal('show');
    });

    $('.btn-reply').click(function() {
        let $modalFormYKien = $('#reply-contact');
        let $selectUserNhans = $modalFormYKien.find('select[name="receiver_ids[]"]');

        $modalFormYKien.find('form')[0].reset();

        $selectUserNhans.val($(this).data('users'));
        $selectUserNhans.trigger("chosen:updated");

        $modalFormYKien.modal('show');
    });

    function showModalFormAddYKien(vanbanxulyId) {
        let $modal = $('#add-contact');

        $modal.find('form')[0].reset();

        $modal.find('select[name="receiver_ids[]"]').trigger("chosen:updated");

        $modal.find('input[name="vanbanxuly_id"]').val(vanbanxulyId);

        $modal.modal('show');
    }
</script>
