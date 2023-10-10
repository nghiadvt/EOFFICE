@extends(config('app.interface') . 'templates.layout')
@section('title', 'Chuyển xử lý văn bản')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/v2/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('js/treeview/dx.common.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('js/treeview/dx.light.css') }}" />
    <script src="{{ asset('js/treeview/dx.all.js') }}"></script>
@endsection
@section('content')
    <div class="process-content container-fluid">
        <div class="row group-function mx-0">
            <div class="col-md-8 offset-sx-12 breadcrumbs mx-0 px-0">
                <div class="breadcrumbs-link">
                    <div><a href="" class="txt-link">Điều hành tác nghiệp</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">Văn bản nội bộ</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">Chuyển xử lý văn bản nội bộ</a></div>
                </div>
            </div>
        </div>
        <div class="row header-detail">
            <h4>Chuyển xử lý văn bản nội bộ</h4>
        </div>
        <div class="process-body">
            <form action="{{ url('vanbannoibo/luu-chuyen-xu-ly') }}" id="xulyvanban" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" value="{{ $vanbanden->id }}" name="id">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-sm-12">
                    <table class="table-main w-100">
                        <tbody>
                            <tr>
                                <th class="title-field">Số đến</th>
                                <td class="content-field" data-name="Số đến">{{ $vanbanden->soden }}</td>
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
                                <td class="content-field" data-name="Loại văn bản">{{ $vanbanden->tenLoaiVanBan }}</td>
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
                                <th class="title-field">Ngày VB</th>
                                <td class="content-field" data-name="Ngày VB">{{ formatdmYY($vanbanden->ngayky) }}</td>
                                <th class="title-field">Người ký</th>
                                <td class="content-field" data-name="Người ký">{{ $vanbanden->nguoiky }}</td>
                            </tr>
                            <tr>
                                <th class="title-field" rowspan="2">Trích yếu</th>
                                <td class="content-field" rowspan="2" data-name="Trích yếu">{{ $vanbanden->title }}</td>
                                <th class="title-field">File văn bản</th>
                                <td class="content-field" data-name="File văn bản">
                                    <div class="content-file-field">
                                        @php
                                            $files = explode(';', $vanbanden->file_dinhkem);
                                            foreach ($files as $key => $file) {
                                                echo sprintf('<a href="%s" target="_blank">%s</a>', route('dowload.file', $file[$key]), $file[$key]);
                                            }
                                        @endphp
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="title-field">Ghi chú</th>
                                <td class="content-field" data-name="Ghi chú">{{ $vanbanden->note }}</td>
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
                                    <textarea class="form-control mt-1 mb-1" style="font-size: 12px" name="conten_butphe" id="conten_butphe" autofocus
                                        rows="5"></textarea>
                                </td>
                            </tr>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mt-2 mb-1">
                        <a href="{{ url('vanbannoibo/chi-tiet', [$vanbanden->id]) . '?tab=2' }}"
                            class="btn btn-default btn-primary me-1"><i class="fa fa-envelope-open"></i>
                            Trao đổi văn bản</a>
                        <div onclick="quyTrinhChuyenTiep('{{ $vanbanden->id }}')" class="btn btn-default btn-primary"
                            data-bs-toggle="modal" data-bs-target="#process-thread"><i
                                class="fa-solid fa-code-branch fa-icon"></i> Luồng luân chuyển</div>
                    </div>

                    <div class="col-md-12 treeview d-flex justify-content-center" style="margin-top: 20px">
                        <div class="row form-tree justify-content-center">
                            <div class="col-md-5 select-view border rounded">
                                <p class="title-tree">Phòng, Ban, Khoa,... được chọn</p>
                                <div id="checked-items"></div>
                            </div>
                            <div class="col-md-5 select-view border rounded">
                                <p class="title-tree">Tên Phòng, Ban, Khoa,...</p>
                                <div id="selection-treeview">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 vanban" style="text-align: center">
                        <button type="submit" class="btn btn-default btn-primary" id="btn-add">Xử lý văn bản
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include(config('app.interface') . 'components.modal_luong')
@endsection
@section('scripts')
    <script>
        $('.btn-add').click(function() {
            if ($('#conten_butphe').val() == '') {
                jAlert("{!! trans('Vui lòng nhập nội dung bút phê') !!}", "{!! trans('Thông báo') !!}");
                return false;
            }

            $('#xulyvanban').submit();
        });

        // tree view
        $(function() {
            var phongban = @php echo json_encode($dataTreeview); @endphp;
            var checkedItems = [];

            var checkedItemsList = $("#checked-items").dxList({
                width: '100%',
                items: checkedItems,
                itemTemplate: function(data) {
                    let id = data.key.split('_')[1];
                    return `<div class='text-wrap'><input type="hidden" checked="true" name="users[]" value="${id}" /><span>${data.text}</span></div>`;
                }
            }).dxList("instance");

            $("#selection-treeview").dxTreeView({
                items: phongban,
                width: '100%',
                searchEnabled: true,
                showCheckBoxesMode: "normal",
                onItemSelectionChanged: function(e) {
                    var item = e.node;

                    if (isPhongban(item)) {
                        processPhongban($.extend({
                            category: item.parent.text
                        }, item));
                    } else {
                        $.each(item.items, function(index, phongban) {
                            processPhongban($.extend({
                                category: item.text
                            }, phongban));
                        });
                    }
                    checkedItemsList.option("items", checkedItems);
                },
                itemTemplate: function(data) {
                    return "<div class='text-wrap'>" + data.text + "</div>";
                },
                onItemRendered: function(e) {
                    if (e.itemData.has_selected) {
                        e.itemElement.addClass('has-selected');
                    }
                }
            });

            function isPhongban(data) {
                return data.key.toString().includes('_');
            }

            function processPhongban(phongban) {
                var itemIndex = -1;

                $.each(checkedItems, function(index, item) {
                    if (item.key === phongban.key) {
                        itemIndex = index;
                        return false;
                    }
                });

                if (phongban.selected && itemIndex === -1) {
                    checkedItems.push(phongban);
                } else if (!phongban.selected) {
                    checkedItems.splice(itemIndex, 1);
                }
            }
        })

        function quyTrinhChuyenTiep(Id) {
            url = '{{ url('vanban/quy_trinh_chuyen_tiep') }}';
            //   loading_show();
            $.get(url, {
                'Id': Id
            }, function(data) {
                // loading_hide();
                $('.process-thread .thread-modal .modal-body').html(data);
            });
        }
    </script>
@endsection
