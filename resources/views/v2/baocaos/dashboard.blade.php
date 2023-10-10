@extends(config('app.interface') . 'templates.lanhdao')
@section('title', 'Dashboard')
@section('content')
    <div class="dashboard">
        <div class="row row-cols-auto">
            <div class="col shortcut">
                <div class="shortcut-cover">
                    <img class="shortcut-img img-fluid" src="{{ asset('img/soanthaovanban.png') }}" />
                </div>
                <div class="shortcut-main">
                    <a style="text-decoration: none;" href="{{route('danhsach.vanbanden')}}">
                        <div class="shortcut-title">
                            Các văn bản</div>
                    </a>
                    <div class="shortcut-content">
                        <p>
                            Soạn thảo và gửi văn bản đến các đơn vị. Đồng thời quản lý bút phê, các văn bản gửi đến, gửi đi
                            và ủy quyền gửi văn bản.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col shortcut">
                <div class="shortcut-cover">
                    <img class="shortcut-img" src="{{ asset('img/quanlybaocao.png') }}" />
                </div>
                <div class="shortcut-main">
                    <a style="text-decoration: none;" href="http://">
                        <div class="shortcut-title">
                            Quản lý báo cáo</div>
                    </a>
                    <div class="shortcut-content">
                        <p>
                            Soạn thảo và gửi các báo cáo cho các đơn vị cấp trên và các ban, văn phòng. Đồng thời quản lý
                            các báo cáo gửi đến, gửi đi.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col shortcut">
                <div class="shortcut-cover">
                    <img class="shortcut-img" src="{{ asset('img/quanlytotrinh.png') }}" />
                </div>
                <div class="shortcut-main">
                    <a style="text-decoration: none;" href="http://">
                        <div class="shortcut-title">
                            Quản lý tờ trình</div>
                    </a>
                    <div class="shortcut-content">
                        <p style="text-align: justify">
                            Soạn thảo và gửi tờ trình cho cấp trên. Đồng thời quản lý các tờ trình đã gửi và các tờ trình đã
                            nhận được.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col shortcut">
                <div class="shortcut-cover">
                    <img class="shortcut-img" src="{{ asset('img/quanlycongviec.png') }}" />
                </div>
                <div class="shortcut-main">
                    <a style="text-decoration: none;" href="http://">
                        <div class="shortcut-title">
                            Quản lý công việc</div>
                    </a>
                    <div class="shortcut-content">
                        <p>
                            Khởi tạo và quản lý các công việc đã giao, được giao.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
