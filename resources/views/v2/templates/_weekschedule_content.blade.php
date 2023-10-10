@if (count($dataDHDN) > 0)
    @foreach ($dataDHDN as $val)
        <div class="event-item">
            <div class="time-event">
                {{ $val->time->format('H:i') }}
            </div>
            <div class="content-event">
                <div class="row">
                    <div class="col-3">Nội dung</div>
                    <div class="col-9">{{ $val->noidung }}</div>
                    <div class="w-100"></div>
                    <div class="col-3">Địa điểm</div>
                    <div class="col-9">{{ $val->phonghop->tenphonghop }}</div>
                </div>
            </div>
        </div>
    @endforeach
@elseif (count($dataCoquan) > 0)
    @foreach ($dataCoquan as $val)
        <div class="event-item">
            <div class="time-event">
                {{ $val->time->format('H:i') }}
            </div>
            <div class="content-event">
                <div class="row">
                    <div class="col-3">Nội dung</div>
                    <div class="col-9">{{ $val->noidung }}</div>
                    <div class="w-100"></div>
                    <div class="col-3">Địa điểm</div>
                    <div class="col-9">{{ $val->phonghop->tenphonghop }}</div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="no-event">Chưa có sự kiện nào vào ngày này.</div>
@endif
