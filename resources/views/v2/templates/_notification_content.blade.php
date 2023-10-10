@php
    $tyles = App\Models\Notification::$types;
@endphp

@if (!$notifications)
    <li>
        <div class="noti-child">
            <div style="display: flex; align-items: center ">
                <div class="dropdown-item">
                    Bạn chưa có thông báo mới.
                </div>
            </div>
        </div>
    </li>
@else
    @foreach ($notifications as $val)
        <li>
            <a class="text-decoration-none" href="{{ route('notification.view_notification', [$val->id]) }}">
                <div class="noti-child {{ $val->read_at ? 'on-view' : '' }}">
                    <div style="display: flex; align-items: center ">
                        <div class="dropdown-item text-wrap">@php echo $val->content; @endphp</div>
                        @if (in_array($val->type, [$tyles['nhanvanbanmoi'], $tyles['nhanvanbanchuyenxuly'], $tyles['capnhattrangthaivanban']]))
                            <i class="fas fa-circle" style="font-size: 14px; color: #1668C7"></i>
                        @elseif (in_array($val->type, [$tyles['nhancongviecmoi'], $tyles['nhanbaocaocongviec']]))
                            <i class="fas fa-circle" style="font-size: 14px; color: rgb(229, 233, 16)"></i>
                        @elseif (in_array($val->type, [
                                $tyles['nhandangkylichtuan'],
                                $tyles['dangkylichtuandaduocduyet'],
                                $tyles['dangkylichtuandabituchoi'],
                            ]))
                            <i class="fas fa-circle" style="font-size: 14px; color: rgb(29, 250, 40)"></i>
                        @endif
                    </div>
                    <div class="noti-time">{{ convertCarbonToVN($val->created_at) }}</div>
                </div>
            </a>
        </li>
    @endforeach
    <script>
        noUnReadNotification = parseInt(@php echo $noUnReadNotification; @endphp);
        if (noUnReadNotification) {
            $('#noti-dot').attr("hidden", true);
        } else {
            $('#noti-dot').removeAttr('hidden');
        }
    </script>
@endif
