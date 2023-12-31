@extends(config('app.interface').'templates.lanhdao')
@section('main')

<div class="container" style="padding-bottom: 50px;">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="title-text">Thêm tài khoản</h4>
        </div>
        <div class="col-sm-12">
            <form id="TaikhoanForm" action="{{ route('save_tai_khoan') }}" class="form-input" method="POST">
                <div class="form-row">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" >

                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>Họ và tên</b></p>
                            </div>
                            <div class="form-item-c">
                                <input type="text" name="fullname" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>Mã cán bộ</b></p>
                            </div>
                            <div class="form-item-c">
                                <input type="text" name="macanbo" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>Đơn vị</b></p>
                            </div>
                            <div class="form-item-c">
                                <select name="donvi_id" class="form-control chosen">
                                    @foreach ($donvis as $donvi)
                                        <option value="{{ $donvi->id }}">{{ $donvi->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>Email</b></p>
                            </div>
                            <div class="form-item-c">
                                <input type="text" name="email" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>Email đăng nhập</b></p>
                            </div>
                            <div class="form-item-c">
                                <input type="text" name="azure_id" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>Chức danh</b></p>
                            </div>
                            <div class="form-item-c">
                                <input type="text" name="chucdanh" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>Vai trò</b></p>
                            </div>
                            <div class="form-item-c">
                                <select name="role" id="role" class="form-control" onchange="Role()">
                                    <option value="1">Văn thư</option>
                                    <option value="2">Chuyên viên</option>
                                    <option value="3">Lãnh đạo</option>
                                    <option value="4">Admin</option>
                                    <option value="5">Manager</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 vanban" style="display: none" id="lichtuan_lanhdao">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>Duyệt lịch tuần Đơn vị</b></p>
                            </div>
                            <div class="form-item-c">
                                {{-- <input type="checkbox" name="lanhdao" style="margin-top: 10px;"> --}}
                                <input type="checkbox" name="duyetlichtuan" style="margin-top: 10px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>Quyền truy cập</b></p>
                            </div>
                            <div class="row form-item-c" style="display: flex ; margin-top: -9px">
                                <div class="col-md-12 vanban">
                                  
                                    <div class="form-item">
                                        <div class="form-item-c">
                                            <input type="checkbox" name="vanbandi" style="margin-top: 10px;  ">
                                        </div>
                                        <div class="form-item-l">
                                            <p style="padding-top:7px;margin-left: -38px"><b>Văn bản đi </b></p>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-md-12 vanban">
                                    <div class="form-item">
                                        <div class="form-item-c">
                                            <input  type="checkbox" name="vanbanden" style="margin-top: 10px;">
                                        </div>
                                        <div class="form-item-l">
                                            <p style="padding-top:7px; margin-left: -38px"><b>Văn bản đến</b></p>
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="col-md-12 vanban">
                                    <div class="form-item">
                                        <div class="form-item-c">
                                            <input type="checkbox" name="vanbannoibo" style="margin-top: 10px;">
                                        </div>
                                        <div class="form-item-l">
                                            <p style="padding-top:7px; margin-left: -38px"><b>Văn bản nội bộ</b></p>
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="col-md-12 vanban">
                                    <div class="form-item">
                                        <div class="form-item-c">
                                            <input type="checkbox" name="congviec" style="margin-top: 10px; ">
                                        </div>
                                        <div class="form-item-l">
                                            <p style="padding-top:7px; margin-left: -38px"><b> Công việc</b></p>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

{{-- 
                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>Duyệt lịch tuần VP</b></p>
                            </div>
                            <div class="form-item-c">
                                <input type="checkbox" name="duyetlichtuan" style="margin-top: 10px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>Xem thống kê</b></p>
                            </div>
                            <div class="form-item-c">
                                <input type="checkbox" name="view_thongke" style="margin-top: 10px;">
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-12 vanban" style="text-align: center">
                        <button type="submit" class="btn btn-primary" style="margin-top:10px">Lưu</button>
                    </div>
                </div>
            </form>
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
            loading_show();
            form.submit();
        }
    });

    $('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', width: '100%', search_contains:true});

    function Role(){
        let role = $('#role').val();
        if (role == 3 || role == 2){
            $('#lichtuan_lanhdao').css('display', 'block')
        }else {
            $('#lichtuan_lanhdao').css('display', 'none')
        }
    }
</script>
@endsection
