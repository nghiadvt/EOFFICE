@extends(config('app.interface').'templates.lanhdao')
@section('main')
    @php
        $user = (object) session('user');
    @endphp
    <div style="padding: 20px;">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="title-text">Sửa thông tin Tiến độ công việc</h3>
            </div>
            <div class="col-sm-12 table-bordered" style="margin-top: 20px">
                <div style="text-align: center; margin-top: 20px">
                    <i><label>Lưu ý:</label> Các trường có dấu <em class="flag-require">*</em> bắt buộc nhập thông tin</i>
                </div>
                <form id="FormEdit" class="form" action="{{ route('quanlytiendo.savechinhsua') }}" method="POST" style="margin-top: 20px">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $tiendo->id }}">

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
                                                    @foreach($donvis as $donvi)
                                                        <option {{ $donvi->id == $donvi_id ? 'selected' : '' }} value="{{ $donvi->id }}">{{ $donvi->name }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select disabled id="donvi_id" class="chosen form-control">
                                                    @foreach($donvis as $donvi)
                                                        <option {{ $donvi->id == $donvi_id ? 'selected' : '' }} value="{{ $donvi->id }}">{{ $donvi->name }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
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
                                        <input type="text" name="note" value="{{$tiendo->note}}" id="cancu" class="form-control">
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
                                        <textarea name="noidung" id="noidung" class="form-control text-area" rows="3">{{$tiendo->content}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="text-align: right;">
                                        <label style="padding-top:10px; text-align: right;">Minh chứng</label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea name="minhchung" id="minhchung" class="form-control text-area" rows="3">{{$tiendo->minhchung}}</textarea>
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
                },
                messages: {
                    donvichutri: {
                        required: "Đơn vị không được để trống"
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

    </script>
@endsection
