@if ($vanbanxuly)
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content status-modal">
            <div class="modal-header">
                <h1 class="modal-title d-flex fs-5">
                    <div class="tag"
                        style="width: 12px; height: 32px; position: relative; background: #1668C7; border-radius: 4px">
                    </div>
                    <div class="text-title-cal">Xử lý văn bản</div>
                </h1>
                <div class="icon-background" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-lg"></i>
                </div>
            </div>
            <div class="modal-body" style="min-width: 100%;max-width: 100%;overflow: auto;">
                <div class="d-flex flex-column justify-content-center">
                    <form class="form-status" id="FormChangeVBStatus"
                        action="{{ route('vanban.cap_nhat_trang_thai_xu_ly') }}" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="vanbanxuly_id" value="{{ $vanbanxuly->id }}">
                        <div class="mb-3">
                            <label for="list-user" class="form-label">Tình trạng <span
                                    style="color: red">(*)</span></label>
                            <select class="browser-default custom-select select-vanban-status" id="status"
                                name="status">
                                <option value="">Chọn tình trạng</option>
                                <option value="1" {{ $vanbanxuly->status == 1 ? 'selected' : '' }}>Chưa xử lý
                                </option>
                                <option value="2" {{ $vanbanxuly->status == 2 ? 'selected' : '' }}>Đang xử lý
                                </option>
                                <option value="3" {{ $vanbanxuly->status == 3 ? 'selected' : '' }}>Đã xử lý
                                </option>
                            </select>
                        </div>
                        @if ($vanbanxuly->parent_id)
                            <div class="mb-3 choose-completed">
                                <label for="content" class="form-label">Minh chứng <span style="color: red">(*)</label>
                                <textarea class="form-control choose-completed-item" id="content" {{ $vanbanxuly->status != 3 ? 'disabled' : '' }} name="minhchung"
                                    cols="30" rows="5" placeholder="Nhập nội dung minh chứng">{{ $vanbanxuly->minhchung }}</textarea>
                            </div>

                            @if ($vanbanxuly->file_minhchung)
                                <div class="mb-3 choose-completed {{ $vanbanxuly->status != 3 ? 'hidden' : '' }}">
                                    <label for="inputFile" class="form-label">File đính kèm đã có</label>
                                    <div class="from-control choose-completed-item">
                                        <a href="{{ route('dowload.file', [$vanbanxuly->file_minhchung]) }}"
                                            target="_blank" title="{{ $vanbanxuly->file_minhchung }}">
                                            {{ $vanbanxuly->file_minhchung }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="mb-3 choose-completed {{ $vanbanxuly->status != 3 ? 'hidden' : '' }}">
                                <label for="inputFile" class="form-label">File đính kèm</label>
                                <input class="form-control choose-completed-item" name="file"
                                    {{ $vanbanxuly->status != 3 ? 'disabled' : '' }} type="file"
                                    accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" id="inputFile" multiple="">
                            </div>
                            @if ($check)
                                <div class="mb-3 choose-completed {{ $vanbanxuly->status != 3 ? 'hidden' : '' }}">
                                    <label style="color: red;font-style: italic;font-weight: normal;">Không thể cập
                                        nhật trạng thái đã xử lý! Có văn bản chuyển tiếp trong luồng chưa xử lý
                                        xong. <br>Hãy chọn "Cập nhật trạng thái xử lý văn bản cấp dưới" để có thể
                                        chuyển sang đã xử lý.</label>
                                    <label><input class="choose-completed-item"
                                            {{ $vanbanxuly->status != 3 ? 'disabled' : '' }} type="checkbox"
                                            style="display: inline-block" name="force_change"
                                            class="choose-completed-item" value="1"> Cập nhật trạng thái xử
                                        lý văn bản cấp dưới</label>
                                </div>
                            @endif

                        @endif

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-danger me-1" data-bs-dismiss="modal">Quay lại</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('.select-vanban-status').change(function() {
                    const status = $(this).val();
                    if (status == 3) {
                        $('.choose-completed .choose-completed-item').attr('disabled', false);
                        $('.choose-completed').removeClass('hidden');
                    } else {
                        $('.choose-completed .choose-completed-item').attr('disabled', true);
                        $('.choose-completed').addClass('hidden');
                    }
                })

                $('#FormChangeVBStatus').validate({
                    rules: {
                        minhchung: 'required',
                        status: 'required',
                        force_change: 'required'
                    },
                    messages: {
                        minhchung: 'Hãy nhập minh chứng đã xử lý văn bản',
                        status: 'Hãy chọn trạng thái',
                        force_change: ''
                    },
                    submitHandler: function(form) {
                        // loading_show();
                        form.submit();
                    }
                })
            })
        </script>
    </div>
@else
    <div style="color: red;">
        Có lỗi! Dũ liệu không tồn tại
    </div>
@endif
