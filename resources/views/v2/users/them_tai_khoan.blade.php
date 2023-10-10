@extends(config('app.interface') . 'templates.lanhdao')
@section('title', 'Thêm tài khoản')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/v2/dang_ky_lich_tuan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/them-tai-khoan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/enter.css') }}">
@endsection
@section('content')

    <div class="container-flud income-pages mx-0">
        <div class="row group-function mx-0">
            <div class="col-md-10 offset-sx-12 breadcrumbs mx-0 px-0">
                <div class="breadcrumbs-link">
                    <div><a href="" class="txt-link">Quản trị hệ thống</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="{{ route('danh_sach_tai_khoan') }}" class="txt-link">Quản lý tài khoản</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">Thêm tài khoản</a></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-sm-12 table-bordered" style="margin-top: 20px">
                    <form id="TaikhoanForm" action="{{ route('save_tai_khoan') }}" class="form-input" method="POST">
                        <div class="form-row">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-row">
                                <div style="text-align: center; margin-top: 20px; font-size : 25px !important; color: var(--website-dark-mode-4284-d-2, #4284D2); ">Thêm tài
                                    khoản</div>

                                <div class="form-item " style="padding-top : 10px">
                                    <div class="form-item-l" style="margin-top: 16px">
                                        <p><b>Họ và tên:</b></p>
                                    </div>
                                    <div class="form-item-checkbox">
                                        <input type="text" name="fullname" class="form-control" style="width: 498px; margin-left: 19px" placeholder="Nhập họ và tên">
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12 vanban">
                                <div class="form-item ">
                                    <div class="form-item-l" style="margin-top:16px">
                                        <p><b>Mã cán bộ:</b></p>
                                    </div>
                                    <div class="form-item-checkbox">
                                        <input type="text" name="macanbo" class="form-control" style="width: 498px; margin-left: 15px" placeholder="Nhập mã cán bộ">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 vanban">
                                <div class="form-item ">
                                    <div class="form-item-l" style="margin-top:16px">
                                        <p><b>Đơn vị:</b></p>
                                    </div>
                                    <div class="form-item-checkbox">
                                        <select name="donvi_id" class="form-control chosen"
                                            style="margin-left: 45px;width: 497px;">
                                            @foreach ($donvis as $donvi)
                                                <option value="{{ $donvi->id }}">{{ $donvi->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 vanban">
                                <div class="form-item ">
                                    <div class="form-item-l" style="margin-top:16px">
                                        <p><b>Email:</b></p>
                                    </div>
                                    <div class="form-item-checkbox"  >
                                        <input type="text" name="email" class="form-control" style=" margin-left: 50px; width: 497px " placeholder="Nhập email cho tài khoản"> 
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 vanban">
                                <div class="form-item ">
                                    <div class="form-item-l" style="margin-top:16px">
                                        <p><b>Email đăng nhập:</b></p>
                                    </div>
                                    <div class="form-item-checkbox">
                                        <input type="text" name="azure_id" class="form-control" style="margin-left: -22px;
                                        width: 495px;" placeholder="Nhập email đăng nhập">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 vanban">
                                <div class="form-item ">
                                    <div class="form-item-l" style="margin-top:16px">
                                        <p><b>Chức danh:</b></p>
                                    </div>
                                    <div class="form-item-checkbox">
                                        <input type="text" name="chucdanh" class="form-control" style="width: 499px;
                                        margin-left: 17px" placeholder="Nhập vào chức danh ">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 vanban">
                                <div class="form-item ">
                                    <div class="form-item-l" style="margin-top:16px">
                                        <p><b>Vai trò:</b></p>
                                    </div>
                                    <div class="form-item-c" >
                                        <select name="role" id="role" class="form-control" onchange="Role()" style="margin-left: 125px;
                                        width: 497px">
                                            <option value="1">Văn thư</option>
                                            <option value="2">Chuyên viên</option>
                                            <option value="3">Lãnh đạo</option>
                                            <option value="4">Admin</option>
                                            <option value="5">Manager</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 vanban" style="display: none; padding-top: 18px" id="lichtuan_lanhdao">
                                <div class="form-item ">
                                    <div class="form-item-l" style="padding: 8px">
                                        <p style="margin-left: -10px"><b>Duyệt lịch tuần Đơn vị:</b></p>
                                    </div>
                                    <div class="form-item-c">
                                       
                                        <input style=" display: flex !important;  margin-left: 30px; margin-top: -12px"
                                            type="checkbox" name="lanhdao">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 vanban">
                                <div class="form-item name">
                                    <div class="form-item-name" style=" width: 113px">
                                        <p><b>Quyền truy cập:</b></p>
                                    </div>
                                    <div class="form-item-checkbox" style="display: flex !important; ">
                                        <div class=" vanban">

                                            <div class="form-item ">
                                                <div class="form-item-c">
                                                    <input type="checkbox" name="vanbandi" style="margin-top: -12px;display: flex !important;">
                                                </div>
                                                <div class="form-item-l">
                                                    <p style="display: flex ;margin-left: 20px"><b>Văn bản đi </b></p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class=" vanban">
                                            <div class="form-item" style="margin-left: 40px">
                                                <div class="form-item-c">
                                                    <input type="checkbox" name="vanbanden"style="margin-top: -12px;display: flex !important;   ">
                                                </div>
                                                <div class="form-item-l">
                                                    <p style="display: flex ;margin-left: 20px"><b>Văn bản đến</b></p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class=" vanban">
                                            <div class="form-item" style="margin-left: 40px">
                                                <div class="form-item-c">
                                                    <input type="checkbox" name="vanbannoibo" style="margin-top: -12px;display: flex !important;">
                                                </div>
                                                <div class="form-item-l">
                                                    <p style="display: flex ;margin-left: 20px"><b>Văn bản nội bộ</b>
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class=" vanban">
                                            <div class="form-item" style="margin-left: 40px">
                                                <div class="form-item-c">
                                                    <input type="checkbox" name="congviec" style="margin-top: -12px;display: flex !important;">
                                                </div>
                                                <div class="form-item-l">
                                                    <p style="display: flex ;margin-left: 20px"><b> Công việc</b></p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class=" vanban">
                                <div class="form-item">
                                    <div class="form-item-l" style="padding-top:17px">
                                        <p><b>Duyệt lịch tuần VP:</b></p>
                                    </div>
                                    <div class="form-item-c">
                                        <input type="checkbox" name="duyetlichtuan" style="margin-top: -15x;display: flex !important; margin-left:58px">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 vanban" style="text-align: center">
                                <button type="submit" class="btn btn-primary" style="margin:20px">Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('#TaikhoanForm').validate({
            ignore: [],
            rules: {
                'fullname': 'required',
                'donvi_id': 'required',
                'email': {
                    required: true,
                    email: true
                },
                'azure_id': {
                    required: true,
                    email: true
                }
            },
            messages: {
                'fullname': 'Hãy nhập họ và tên',
                'donvi_id': 'Hãy chọn đơn vị',
                'email': {
                    required: 'Hãy nhập email',
                    email: 'Email không đúng định dạng'
                },
                'azure_id': {
                    required: 'Hãy nhập đăng nhập',
                    email: 'Email không đúng định dạng'
                }
            },
            submitHandler: function(form) {
                // loading_show();
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
