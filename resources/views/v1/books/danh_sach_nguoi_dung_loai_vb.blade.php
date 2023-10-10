@extends(config('app.interface') . 'templates.lanhdao')
@section('main')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <div class="container container-list">
        @include('flash::message')

        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center">Danh sách cán bộ cơ quan
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

            <div class="col-md-3 " style="margin-top: 15px;margin-left:-15px ;display: flex ; margin-bottom: 15px;" >

                <select style="width: 300px; margin-left:-10px ; display: flex" id="select2">
                <option value="" style="display: flex ;text-align: left;">Tìm kiếm</option>
                </select>
            </div>

            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th class="col-stt">STT</th>
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
                                <td class="col-stt">{{ $stt++ }}</td>
                                <td><strong>{{ $uservb->fullname }}</strong></td>
                                <td>{{ $uservb->chucdanh }}</td>
                                <td class="email_color">{{ $uservb->email }}</td>
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

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    loading_show();
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
