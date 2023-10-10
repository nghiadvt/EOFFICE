@extends(config('app.interface').'templates.lanhdao')
@section('main')
    <div class="container" style="padding-bottom: 50px;">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="title-text">Thêm đơn vị</h4>
            </div>
            <div class="col-sm-12">
                <form id="DonViForm" action="{{ route('luu_don_vi') }}" class="form-input" method="POST">
                    <div class="form-row">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Tên đơn vị (<span style="color: red">*</span>)</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" name="name" placeholder="vd:Ban Công tác Học sinh - Sinh viên"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Viết tắt</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" name="viettat" placeholder="vd:Ban CT HS-SV" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Trực thuộc đơn vị </b></p>
                                </div>
                                <div class="form-item-c">
                                    <select name="isDonvi" id="isDonvi" class="form-control">
                                        <option value="0">Không</option>
                                        <option value="1">Có</option>
                                    </select>
                                    <div id="don_vi" style="display: none;">
                                        <label for="don_vi">Chọn đơn vị trực thuộc:</label>
                                        <select name="parent_id" id="parent_id" class="form-control">
                                            @foreach ($donvis as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $("#isDonvi").change(function() {
                                                var selectedOption = $(this).val();
                                                if (selectedOption === "1") {
                                                    $("#don_vi").show();
                                                } else {
                                                    $("#don_vi").hide();
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Chức năng</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" name="chucnang" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Địa chỉ</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" name="diachi" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Điện thoại</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" name="dienthoai" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Mô tả</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" name="description" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Trạng thái (<span style="color: red">*</span>)</b></p>
                                </div>
                                <div class="form-item-c">
                                    <select name="actived" id="actived" class="form-control" onchange="Role()">
                                        <option value="1">Hoạt động</option>
                                        <option value="0">Không hoạt động</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Mã đơn vị</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" name="madonvi" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban" style="text-align: center">
                            <button type="submit" class="btn btn-primary" style="margin-top:10px">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#DonViForm').validate({
            ignore: [],
            rules: {
                'name': {
                    required: true
                },
                'ordering': {
                    required: true
                },
                'actived': {
                    required: true,
                }
            },
            messages: {
                'name': 'Hãy nhập tên đơn vị',
                'ordering': 'Hãy nhập ordering',
                'actived': {
                    required: 'Hãy chọn trạng thái',
                }
            },
            submitHandler: function(form) {
                loading_show();
                form.submit();
            }
        });

        $('.chosen').chosen({
            no_results_text: 'Không tìm thấy kết quả',
            width: '100%',
            search_contains: true
        });

        function Role() {
            let role = $('#role').val();
            if (role == 3) {
                $('#lichtuan_lanhdao').css('display', 'block')
            } else {
                $('#lichtuan_lanhdao').css('display', 'none')
            }
        }
    </script>
@endsection
