@extends(config('app.interface') . 'templates.lanhdao')
@section('title', $book->name)
@section('style')
    <link rel="stylesheet" href="{{ asset('css/v2/list_doc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/dang_ky_lich_tuan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/quan_ly_don_vi.css') }}">
@endsection
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <div class="container-flud income-pages mx-0 col-md-12">
        <div class="row group-function mx-0 col-md-12">
            <div class="row group-function mx-0 col-md-12">
                <div class="breadcrumbs-link links">
                    <div><a href="" class="txt-link">Quản trị hệ thống</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="{{ route('quan_ly_don_vi') }}" class="txt-link">Danh sách đơn vị</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">{{ $book->name }}</a></div>
                </div>
            </div>
        </div>

        <div class="container container-list">
            {{-- @include('flash::message') --}}
            <div class="row">
                <div class="col-md-12">
                    <h4 style=" font-size: 25px; margin-left:31px  ;color: var(--website-dark-mode-4284-d-2, #4284D2);">
                        Danh sách cán bộ cơ quan
                        <?php
                        switch ($book->id) {
                            case '1':
                                echo 'nhận văn bản đến';
                                break;
                        
                            case '2':
                                echo 'gửi văn bản đi';
                                break;
                            case '3':
                                echo 'nhận công việc';
                                break;
                        
                            case '4':
                                echo 'công văn nội bộ';
                                break;
                        }
                        
                        ?>
                        {{ $donvi->name }}</h4>
                </div>

                <div class="col-md-3 " style="margin-top: 15px;margin-left:30px ;display: flex ; margin-bottom: 15px;">

                    <select style="width: 300px; margin-left:3px; height: 35px ; display: flex; border-radius:9px"
                        id="select2">
                        <option value="" style="display: flex ;text-align: left;">Tìm kiếm</option>
                    </select>
                </div>
                <div class="row table-list-documents mx-0 tbs" style="padding-bottom:50px">
                    <table class="table-content">
                        <thead >
                            <tr class="field-title">
                                <th class="num-docs">STT</th>
                                <th>Tên cán bộ</th>
                                <th>Chức danh</th>
                                <th>Email</th>
                                <th class="text-center col-fit-content">Xoá</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-list">
                            @if (sizeof($newUsers) > 0)
                                @php $stt = 1 @endphp
                                @foreach ($newUsers as $uservb)
                                    <tr id="{{ $uservb->id }}">
                                        <td class="num-docs">{{ $stt++ }}</td>
                                        <td style="text-align: center;"><strong>{{ $uservb->fullname }}</strong></td>
                                        <td style="text-align: center;">{{ $uservb->chucdanh }}</td>
                                        <td class="email_color" style="text-align: center;">{{ $uservb->email }}</td>
                                        <td class="text-center col-fit-content">
                                            <span class="btn-table">
                                                <a href="javascript:;" onclick="deleteCanbo({{ $uservb->id }})"
                                                    title="Xóa cán bộ"><i class="fa fa-trash red"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" align="center"><i>Không có dữ liệu</i></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('js/alert.js')}}"></script>

    <script>
        $("#select2").select2({
            ajax: {
                url: baseUrl + "/quanlydonvi/don-vi/list-user",
                dataType: 'json'
            }
        });
        $("#select2").on('change', function() {
            let value = $(this).val();
            add_canbo_save(value);
        });

        function add_canbo_save(id) {
            let token = '{{ csrf_token() }}';
            $("#select2").text('');
            $.ajax({
                type: "POST",
                url: "{{ route('them_can_bo_vao_book') }}",
                data: {
                    donvi_id: "{{ $donvi_id }}",
                    book: "{{ $book->id }}",
                    user: id,
                    _token: token
                },
                success: (data) => {
                    let stt = $('#sortable-list tr').length + 1;
                    document.getElementById('sortable-list').innerHTML += `
                        <tr id="${data.id}">
                                <td class="col-stt">` + stt + `</td>
                                <td><strong>${data.fullname}</strong></td>
                                <td>${data.chucdanh}</td>
                                <td class="email_color">${data.email}</td>
                                <td class="text-center col-fit-content">
                                    <span class="btn-table">
                                        <a href="javascript:;" onclick="deleteCanbo(${data.id})"
                                            title="Xóa đơn vị"><i class="fa fa-trash red"></i></a>
                                    </span>
                                </td>
                            </tr>
                        `
                },
                fail: (data) => {
                    console.log("not ok");
                }
            })
        }

        function deleteCanbo(id) {
            jConfirm('Bạn có muốn xóa cán bộ này không?', 'Thông báo', function(r) {
                if (r) {
                    // loading_show();
                    const result = []
                    for (let i = 0; i < list.children.length; i++) {
                        result.push(list.children[i].id)
                    }
                    const userIds = result.filter(user => user != id)

                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.post("{{ route('xoa_can_bo') }}", {
                        user_ids: userIds.join(";"),
                        donvi_id: "{{ $donvi_id }}",
                        book: "{{ $book->id }}",
                        _token: CSRF_TOKEN
                    }, () => {
                        location.reload();
                    });
                }
            });
        }

        const list = document.getElementById('sortable-list')
        new Sortable(list, {
            animation: 150,
            chosenClass: "sortable-chosen",
            dragClass: "sortable-drag",

            onUpdate: function(evt) {

                const result = []
                for (let i = 0; i < list.children.length; i++) {
                    result.push(list.children[i].id)
                }

                for (let i = 0; i < list.children.length; i++) {
                    list.children[i].children[0].innerText = i + 1
                }

                saveOrder(result.join(';'));
            },
        });

        let token = '{{ csrf_token() }}';

        function saveOrder(result) {
            $.ajax({
                type: "POST",
                url: "{{ route('cap_nhat_vi_tri_can_bo') }}",
                data: {
                    donvi_id: "{{ $donvi_id }}",
                    book: "{{ $book->id }}",
                    odered: result,
                    _token: token
                },
            })
        }
    </script>
@endsection
