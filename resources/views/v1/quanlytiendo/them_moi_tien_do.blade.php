@extends(config('app.interface').'templates.lanhdao')
@section('main')

    @php
        $user = (object) session('user');
        $quy = select_Quy_Nam();
    @endphp
    <div style="padding: 20px;">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="title-text">Thêm mới Tiến độ công việc</h3>
            </div>
            <div class="col-sm-12 table-bordered" style="margin-top: 20px">
                <div style="text-align: center; margin-top: 20px">
                    <i><label>Lưu ý:</label> Các trường có dấu <em class="flag-require">*</em> bắt buộc nhập thông tin</i>
                </div>
                <form id="FormEdit" class="form" action="{{ route('quanlytiendo.luuthemmoi') }}" method="POST" style="margin-top: 20px">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-row">
                        @if($user->donvi_id == 136)
                            <div class="col-md-12 vanban">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-2" style="text-align: right;">
                                            <label style="padding-top:10px; text-align: right;">Đơn vị</label><em class="flag-require">*</em>
                                        </div>
                                        <div class="col-md-10">
                                            @if($user->donvi_id == 136)
                                                <select name="donvichutri" id="donvi_id" class="chosen form-control">
                                                    <option value="">Chọn đơn vị</option>
                                                    @foreach($donvis as $donvi)
                                                        <option value="{{ $donvi->id }}" {{old('donvichutri') == $donvi->id ? 'selected' : ''}}>{{ $donvi->name }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select disabled name="donvichutris" id="donvi_id" class="chosen form-control">
                                                    @foreach($donvis as $donvi)
                                                        <option value="{{ $user->donvi_id }}" {{$user->donvi_id == $donvi->id ? 'selected' : ''}}>{{ $donvi->name }}</option>
                                                        @endforeach
                                                </select>
                                            @endif
                                            <label id="donvi_id-error" class="error" for="donvi_id"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;">Căn cứ</label><em class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="note" value="{{old('note')}}" autocomplete="off" id="cancu" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;">Nội dung</label><em class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea name="noidung" id="noidung" class="form-control text-area" rows="3">{{old('noidung')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;">Minh chứng</label><em class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea name="minhchung" id="minhchung" class="form-control text-area" rows="3">{{old('minhchung')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;">Tiến độ</label><em class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-10">
                                        <select name="tiendo" id="tiendo" class="form-control">
                                            <option value="0" {{old('tiendo') == '0' ? 'selected' : ''}}>Chưa triển khai</option>
                                            <option value="1" {{old('tiendo') == 1 ? 'selected' : ''}}>Đang triển khai</option>
                                            <option value="2" {{old('tiendo') == 2 ? 'selected' : ''}}>Hoàn thành</option>
                                            <option value="3" {{old('tiendo') == 3 ? 'selected' : ''}}>Đang tạm hoãn</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;">Thời hạn</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="thoihan" autocomplete="off" class="form-control input-thoihan" id="thoihan" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban" id="chon_loai">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;">Chọn loại</label><em class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-10">
                                        <select name="loai" id="loai" class="form-control">
                                            <option value="">-- Chọn loại --</option>
                                            <option value="quy" {{old('quy') == 'quy' ? 'selected' : ''}}>Theo quý</option>
                                            <option value="thang" {{old('quy') == 'thang' ? 'selected' : ''}}>Theo tháng</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban" style="display: none" id="chon_quy">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;">Chọn quý</label><em class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-10">
                                        <select name="quy" id="quy" class="form-control">
                                            <option value="1" {{$quy == 1 ? 'selected' : ''}}>Quý 1</option>
                                            <option value="2" {{$quy == 2 ? 'selected' : ''}}>Quý 2</option>
                                            <option value="3" {{$quy == 3 ? 'selected' : ''}}>Quý 3</option>
                                            <option value="4" {{$quy == 4 ? 'selected' : ''}}>Quý 4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;">Chọn năm</label><em class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="nam" class="form-control input-nam" id="nam" value="{{date('Y')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban" style="display: none" id="chon_thang">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;">Chọn tháng</label><em class="flag-require">*</em>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="date" class="form-control input-date" id="date" value="{{date('m/Y')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 vanban" style="text-align: right; margin-top: 25px;">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" style="margin-bottom: 15px">
                                <span class="glyphicon glyphicon-floppy-saved"></span> Lưu thay đổi
                            </button>
                            <a class="btn btn-danger" style="margin-bottom: 15px;" href="{{ route('quanlytiendo.danhsach') }}"><i class="glyphicon glyphicon glyphicon-remove"></i> Thoát</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function() {
            $('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', width: '100%', search_contains:true});

            $('#FormEdit').validate({
                rules: {
                    donvichutri: {
                        required: true
                    },
                    note: {
                        required: true
                    },
                    noidung: {
                        required: true
                    },
                    minhchung: {
                        required: true
                    },
                    tiendo: {
                        required: true
                    },
                    date: {
                        required: true
                    },
                    loai: {
                        required: true
                    },
                },
                messages: {
                    donvichutri: {
                        required: "Hãy chọn đơn vị"
                    },
                    note: {
                        required: "Hãy nhập căn cứ"
                    },
                    noidung: {
                        required: "Hãy nhập nội dung"
                    },
                    minhchung: {
                        required: "Hãy nhập minh chứng"
                    },
                    tiendo: {
                        required: "Hãy chọn tiến độ"
                    },
                    date: {
                        required: "Hãy chọn tháng"
                    },
                    loai: {
                        required: "Hãy chọn loại"
                    },
                },
                submitHandler: function(form) {
                    loading_show();
                    form.submit();
                }
            });
        });

        $('.date-picker').datetimepicker({
            format: 'DD-MM-YYYY HH:mm',
            useCurrent: false
        });

        $('.input-thoihan').datetimepicker({
            format: 'DD-MM-YYYY',
            useCurrent: false
        });

        $('.input-date').datetimepicker({
            format: 'MM-YYYY',
            useCurrent: false,
            maxDate : 'now'
        });

        $('.input-nam').datetimepicker({
            format: 'YYYY',
            useCurrent: false,
            maxDate : 'now'
        });

        $('#chon_loai').on('change', function (){
            let loai = $('#loai').val();
            if (loai == 'quy'){
                $('#chon_quy').css('display', 'block')
                $('#chon_thang').css('display', 'none')
            }else if(loai == 'thang'){
                $('#chon_thang').css('display', 'block')
                $('#chon_quy').css('display', 'none')
            }else {
                $('#chon_thang').css('display', 'none')
                $('#chon_quy').css('display', 'none')
            }
        })
    </script>
@endsection
