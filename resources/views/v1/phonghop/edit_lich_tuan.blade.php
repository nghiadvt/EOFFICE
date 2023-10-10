@extends(config('app.interface').'templates.lanhdao')
@section('main')

<div style="padding: 20px;">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="title-text">Sửa đăng ký lịch tuần</h3>
		</div>
		<div class="col-sm-12 table-bordered" style="margin-top: 20px">
			<div style="text-align: center; margin-top: 20px">
				<i><label>Lưu ý:</label> Các trường có dấu <em class="flag-require">*</em> bắt buộc nhập thông tin</i>
			</div>
			<form id="FormEdit" class="form" action="{{ route('phonghop.savedangkylichtuan') }}" method="POST" style="margin-top: 20px">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="id" value="{{ $lichtuan->id }}">

				<!-- thông tin lịch -->
				<div class="form-row">
					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:10px; text-align: right;">Loại</label>
								</div>
								<div class="col-md-10">
									<div class="radio">
										<label><input type="radio" name="type" value="1" {{ $lichtuan->type == 1? 'checked' : '' }}>Lịch tuần Đại học Đà Nẵng</label>
									</div>
									<div class="radio">
										<label><input type="radio" name="type" value="2" {{ $lichtuan->type == 2? 'checked' : '' }}>Lịch tuần Cơ quan</label>
									</div>
								</div>
							</div>
						</div>
					</div>
						
					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Thời gian</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-10" >
									<input type="text" class="form-control date-picker" name="time" value="{{ date('d-m-Y H:i', strtotime($lichtuan->time)) }}" id="tungay">
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px; text-align: right;">Địa điểm</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-10">
									<div style="display: flex; flex-direction: column-reverse;">
										<select class="chosen form-control phonghop_id"  name="phonghop_id">
											<option value="">Hãy chọn phòng họp</option>
											@foreach ($phonghopcoquan as $val)
												<option value="{{ $val->id }}" {{ $lichtuan->phonghop_id == $val->id? 'selected' : '' }}>{{ $val->tenphonghop }}</option>
											@endforeach
											<option {{ $lichtuan->phonghop_id == null? 'selected' : '' }} value="other">Khác</option>
										</select>
									</div>
									<div class="{{$lichtuan->phonghop_id == null ?  '' : 'hidden' }}" style="margin-top: 10px">
										<input placeholder="Nhập địa điểm khác" type="text" class="form-control" name="diadiem" value="{{$lichtuan->diadiem}}"/>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Nội dung</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-10" >
									<textarea class="form-control" name="noidung" id="noidung" cols="30" rows="5" placeholder="Nội dung cuộc họp">{{ $lichtuan->noidung }}</textarea>
								</div>
							</div> 
						</div>
					</div>

					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Thành phần</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-10" >
									<textarea class="form-control" name="thanhphan" id="thanhphan" cols="30" rows="5" placeholder="Nhập thành phần tham gia">{{ $lichtuan->thanhphan }}</textarea>
								</div>
							</div> 
						</div>
					</div>

					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Chủ trì</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-4">
									<select class="chosen form-control chutriId" name="chutriId" id="chutriId">
										<option value="">Chọn</option>
										@foreach ($banGD as $data)
											<option {{ $data['id'] == $lichtuan->chutriId? 'selected' : '' }} value="{{ $data['id'] }}">{{ $data->chucdanh == 'Giám đốc' ? 'Giám đốc ĐHĐN': 'PGĐ ĐHĐN '.$data->fullname }}</option>
										@endforeach
										<option value="khac">Khác</option>
									</select>
									<div class="{{$lichtuan->chutriId == '' ?  '' : 'hidden' }}"  style="margin-top: 10px">
										<input placeholder="Nhập tên người chủ trì" type="text" class="form-control f" name="chutri"  value="{{$lichtuan->chutri}}"/>
									</div>
								</div>
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Số người tham gia</label>
								</div>
								<div class="col-md-4">
									<input type="number" class="form-control" name="songuoithamgia" value="{{ $lichtuan->songuoithamgia == 0 ? '' : $lichtuan->songuoithamgia}}" id="songuoithamgia" placeholder="Nhập số người tham gia">
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- thông tin người đăng ký -->
				<div class="form-row">
					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px; text-align: right;">Người đăng ký</label>
								</div>
								<div class="col-md-4">
									<input type="text" class="form-control" name="nguoidangky" id="nguoidangky" value="{{ $lichtuan->nguoidangky }}" placeholder="Nhập tên người đăng ký">
								</div>
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Đơn vị</label>
								</div>
								<div class="col-md-4">
									<input type="text" class="form-control" name="donvi" id="donvi" value="{{ $lichtuan->donvi }}" placeholder="Nhập đơn vị">
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Số điện thoại</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-4" >
									<input type="digits" class="form-control" name="sodienthoai" id="sodienthoai" value="{{ $lichtuan->sodienthoai }}" placeholder="Nhập số điện thoại">
								</div>
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Email</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-4" >
									<input type="email" class="form-control" name="email" id="email" value="{{ $lichtuan->email }}" placeholder="Nhập Email">
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 vanban" style="text-align: right; margin-top: 25px;">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary" style="margin-bottom: 15px" href="{{ route('phonghop.dangkylichtuan') }}">
								<span class="glyphicon glyphicon-floppy-saved"></span> Lưu thay đổi
							</button>
							<a class="btn btn-danger" style="margin-bottom: 15px;" href="{{ route('phonghop.danhsachphonghop') }}"><i class="glyphicon glyphicon glyphicon-remove"></i> Thoát</a>
						</div>
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
				phonghop_id: {
					required: true
				},
				diadiem: {
					required: true
				},
	 			sodienthoai: {
	 				required: true
	 			},
	 			email: {
	 				required: true
	 			},
	 			time: {
	 				required: true
	 			},
	 			noidung: {
	 				required: true
	 			},
	 			chutri: {
	 				required: true
	 			},
	 			thanhphan: {
	 				required: true
	 			}
	 		},
	 		messages: {
				phonghop_id: {
					required: "Hãy chọn phòng họp"
				},
				diadiem: {
	 				required: "Hãy nhập địa điểm"
	 			},
	 			sodienthoai: {
	 				required: "Hãy nhập só điện thoại"
	 			},
	 			email: {
	 				required: "Hãy nhập email"
	 			},
	 			time: {
	 				required: "Hãy nhập thời gian"
	 			},
	 			noidung: {
	 				required: "Hãy nhập nội dung"
	 			},
	 			chutri: {
	 				required: "Hãy nhập người chủ trì"
	 			},
	 			thanhphan: {
	 				required: "Hãy  nhập thành phần tham gia"
	 			}
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

	// $('input[name="type"]').click(function () {
	// 	if ($(this).val() == 1) {
	// 		$('select[name="phonghop_id"]').attr('disabled', true).closest('div').addClass('hidden');
	// 		$('select[name="diadiem"]').attr('disabled', false).closest('div').removeClass('hidden');
	// 	}
	// 	else {
	// 		$('select[name="diadiem"]').attr('disabled', true).closest('div').addClass('hidden');
	// 		$('select[name="phonghop_id"]').attr('disabled', false).closest('div').removeClass('hidden');
	// 	}
	//
	// 	$('select[name="diadiem"]').trigger("chosen:updated");
	// 	$('select[name="phonghop_id"]').trigger("chosen:updated");
	// });
	 $('select').on('change', function() {
		 var other = $( "select.phonghop_id" ).val();
		 if(other === 'other'){
			 $('input[name="diadiem"]').attr('disabled', false).closest('div').removeClass('hidden')
		 }else {
			 $('input[name="diadiem"]').attr('disabled', false).closest('div').addClass('hidden')
		 }

	 });
	 $('select.chutriId').on('change', function() {
		 var khac = $( "select.chutriId" ).val();

		 if(khac === 'khac'){
			 $('input[name="chutri"]').attr('disabled', false).closest('div').removeClass('hidden')
		 }else {
			 $('input[name="chutri"]').attr('disabled', false).closest('div').addClass('hidden')
		 }

	 });
</script>
@endsection
