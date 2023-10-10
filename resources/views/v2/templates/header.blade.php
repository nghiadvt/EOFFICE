<nav class="navbar navbar-expand-lg navbar-light bg-white shadow border-bottom bg-white">
    <input type="checkbox" hidden id="nav-check" class="nav-mb-input">
    <div class="container-fluid navbar-custom">
        <div class="nav-logo">
            <a class="navbar-brand" href="{{ url('dashboard') }}">
                <img src="{{ asset('img/logo-dhdn.png') }}" alt="Logo DHDN" height="50">
            </a>
        </div>
        <label class="toggle-nav" for="nav-check">
            <div>
                <i class="fa-solid fa-bars fa-lg hover-effect2"></i>
            </div>
        </label>
        <div class="d-flex">
            <div class="avatar-btn dropdown">
                <?php
                $username_explode = explode(' ', $user->fullname);
                $username_login = $username_explode[count($username_explode) - 1];
                ?>
                <div class="nav-link hover-effect2" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="name-item">
                        @php
                            echo $user->fullname;
                        @endphp
                    </div>
                    <i class="fa-solid fa-angle-down"></i>
                </div>
                <ul class="user-action dropdown-menu">
                    <li class="action-li"><a class="user-drop-item dropdown-item"
                            href="https://portal.office.com/account/#personalinfo"><i
                                class="action-icon fa-solid fa-user"></i>Cập nhật thông tin</a></li>
                    <hr class="dropdown-divider">
                    </li>
                    <li class="action-li">
                        <div class="user-drop-item action-theme dropdown-item">
                            <a class="text-decoration-none text-dark" href="javascript:;">Giao diện tối</a>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="flexSwitchCheckDefault">
                            </div>
                        </div>
                    </li>
                    <li class="action-li"><a class="user-drop-item dropdown-item" href="javascript:;"><i
                                class="action-icon fa-solid fa-gear"></i>Cài đặt</a></li>
                    <li class="action-li"><a class="user-drop-item dropdown-item" target="_blank"
                            href="https://drive.google.com/file/d/14Aoy4w7lE89OIKpWLXGVaqN4GALWkQEV/view"><i
                                class="action-icon fa-solid fa-book"></i>Hướng dẫn sử dụng</a></li>
                    <li class="action-li"><a class="user-drop-item dropdown-item" href="javascript:;"
                            onclick="logout()"><i class="action-icon fa-solid fa-right-from-bracket"></i>Đăng xuất</a>
                    </li>
                </ul>
            </div>
            <input type="checkbox" hidden name="checkbox" id="noti-mobi-check" class="noti-check">
            <label class="nav-overlay-2" for="noti-mobi-check"></label>
            <div class="dropdown notification-btn">
                <label class="noti-icon" for="noti-mobi-check" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false" style="width: 100%;padding: 0.3em; height: 100%;color: #3D3D3D;">
                    <i class="fa-sharp fa-regular fa-bell fa-lg position-relative hover-effect">
                        <span
                            class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-2 border-light rounded-circle"
                            id="noti-dot" hidden>
                        </span>
                    </i>
                </label>
                <ul class="dropdown-menu noti-dropdown dropdown-menu-end" style="margin-top: 1em;">
                    <div class="noti-header">
                        <div><b>Thông báo</b></div>
                        <div class="icon-background">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </div>
                    <div class="notification-wrap">
                        {{-- Content notfication --}}
                        <li>
                            <div class="noti-child" id="spinner-child">
                                <div class="d-flex justify-content-center" style="min-width: 360px">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-see-all" onclick="xemTatca()">Xem tất
                            cả</button>
                    </div>
                </ul>
            </div>
            <div class="noti-mobile">
                <div class="noti-header border-bottom">
                    <div class="noti-title-mb">
                        <div class="tag"
                            style="width: 12px; height: 32px; position: relative; background: #1668C7; border-radius: 4px">
                        </div><b>Thông báo</b>
                    </div>
                    <label for="noti-mobi-check">
                        <div class="icon-background">
                            <i class="fa-solid fa-xmark fa-lg"></i>
                        </div>
                    </label>
                </div>
                <ul class="list-unstyled noti-dropdown notification-wrap-mb">
                    {{-- Content notification mobile --}}
                    <li>
                        <div class="noti-child" id="spinner-child">
                            <div class="d-flex justify-content-center" style="min-width: 100%">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="navbar fixed-bottom noti-end">
                    <button type="button" class="btn btn-primary btn-see-all" onclick="xemTatca()">Xem tất
                        cả</button>
                </div>
            </div>
        </div>
    </div>
    <label class="nav-overlay" for="nav-check"></label>
    <div class="nav-mobile">
        <div class="side-content" data-bs-spy="scroll">
            <div class="d-flex align-items-center p-2 m-1 text-decoration-none border-bottom">
                <div class="nav-logo-2">
                    <a class="navbar-brand me-auto mb-2 mb-lg-" href="{{ url('dashboard') }}">
                        <img src="{{ asset('img/logo-dhdn.png') }}" alt="..." height="36">
                    </a>
                </div>
                <label class="close-icon" for="nav-check">
                    <div class="nav-mb-close">
                        <div class="icon-background">
                            <i class="fa-solid fa-xmark fa-lg"></i>
                        </div>
                    </div>
                </label>
            </div>
            <ul class="list-unstyled menu-mb ps-0">
                <li class="mb-1 mobile-li selected">
                    <div class="menu-item title-menu" data-bs-toggle="collapse" data-bs-target="#manage-collapse"
                        aria-expanded="false">
                        <div class="title-menu-first align-items-center rounded collapsed">
                            Điều hành tác nghiệp
                        </div>
                        <i class="fa-solid fa-caret-down fa-lg" style="color: white"></i>
                    </div>
                    <div class="collapse collapse-mb" id="manage-collapse" style="">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            @if (in_array($user->role, [$userRoles['chuyenvien'], $userRoles['lanhdao'], $userRoles['vanthu']]))
                                <li class="mb-1" data-bs-toggle="collapse" role="button"
                                    data-bs-auto-close="false" data-bs-target="#van-ban-den" aria-expanded="false">
                                    <div class="title-menu">
                                        <div class="title-menu-second align-items-center">
                                            Văn bản đến
                                        </div>
                                        <i class="icon-sidebar fa-solid fa-caret-down fa-lg"></i>
                                    </div>

                                    <div class="collapse-sub" id="van-ban-den" style="">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                            @if ($user->role == $userRoles['vanthu'])
                                                <a class="title-menu" href="{{ route('add.van.ban.den') }}">
                                                    <div class="title-menu-third">Nhập văn bản đến
                                                    </div>
                                                </a>
                                            @endif
                                            <a class="title-menu" href="{{ route('danhsach.vanbanden') }}">
                                                <div class="title-menu-third">Danh sách văn bản đến
                                                </div>
                                            </a>
                                            @if (in_array($user->role, [$userRoles['vanthu'], $userRoles['lanhdao']]))
                                                <a class="title-menu"
                                                    href="{{ route('baocao.thong_ke_theo_don_vi') }}">
                                                    <div class="title-menu-third">Báo cáo thống kê theo đơn vị
                                                    </div>
                                                </a>
                                                <a class="title-menu"
                                                    href="{{ route('baocao.thong_ke_theo_ca_nhan') }}">
                                                    <div class="title-menu-third">Báo cáo thống kê theo cá nhân
                                                    </div>
                                                </a>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                                @if ($user->role == $userRoles['vanthu'])
                                    <li class="mb-1" data-bs-toggle="collapse" role="button"
                                        data-bs-auto-close="false" data-bs-target="#van-ban-di"
                                        aria-expanded="false">
                                        <div class="title-menu">
                                            <div class="title-menu-second align-items-center">
                                                Văn bản đi
                                            </div>
                                            <i class="icon-sidebar fa-solid fa-caret-down fa-lg"></i>
                                        </div>

                                        <div class="collapse-sub" id="van-ban-di" style="">
                                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                                <a class="title-menu" href="{{ route('add.van.ban.di') }}">
                                                    <div class="title-menu-third">Nhập văn bản đi
                                                    </div>
                                                </a>
                                                <a class="title-menu" href="{{ route('danhsach.vanbandi') }}">
                                                    <div class="title-menu-third">Danh sách văn bản đi
                                                    </div>
                                                </a>
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                            @endif
                            <li class="mb-1" data-bs-toggle="collapse" role="button" data-bs-auto-close="false"
                                data-bs-target="#van-ban-noibo" aria-expanded="false">
                                <div class="title-menu">
                                    <div class="title-menu-second align-items-center">
                                        Văn bản nội bộ
                                    </div>
                                    <i class="icon-sidebar fa-solid fa-caret-down fa-lg"></i>
                                </div>

                                <div class="collapse-sub" id="van-ban-noibo" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <a class="title-menu" href="{{ url('vanbannoibo/nhap') }}">
                                            <div class="title-menu-third">Ban hành văn bản nội bộ
                                            </div>
                                        </a>
                                        <a class="title-menu" href="{{ url('vanbannoibo/danh-sach-gui') }}">
                                            <div class="title-menu-third">Văn bản nội bộ đã gửi
                                            </div>
                                        </a>
                                        <a class="title-menu" href="{{ url('vanbannoibo/danh-sach-nhan') }}">
                                            <div class="title-menu-third">Văn bản nội bộ đã nhận
                                            </div>
                                        </a>
                                    </ul>
                                </div>
                            </li>
                            <a style="text-decoration: none;" href="{{ route('danhsachcongviec') }}">
                                <li class="mb-1" aria-expanded="false">
                                    <div class="title-menu">
                                        <div class="title-menu-second align-items-center">
                                            Quản lý công việc
                                        </div>
                                    </div>
                                </li>
                            </a>
                            <a style="text-decoration: none;" href="{{ route('phonghop.danhsachdangkylichtuan') }}">
                                <li class="mb-1" aria-expanded="false">
                                    <div class="title-menu">
                                        <div class="title-menu-second align-items-center">
                                            Đăng lý lịch tuần
                                        </div>
                                    </div>
                                </li>
                            </a>
                            @if ($user->role == $userRoles['admin'])
                                <a style="text-decoration: none;" href="{{ route('phonghop.danhsachphonghop') }}">
                                    <li class="mb-1" aria-expanded="false">
                                        <div class="title-menu">
                                            <div class="title-menu-second align-items-center">
                                                Danh sách phòng họp
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @endif
                            <a style="text-decoration: none;" href="{{ route('quanlytiendo.danhsach') }}">
                                <li class="mb-1" aria-expanded="false">
                                    <div class="title-menu">
                                        <div class="title-menu-second align-items-center">
                                            Quản lý tiến dộ
                                        </div>
                                    </div>
                                </li>
                            </a>
                            <a style="text-decoration: none;" href="{{ route('quanlytiendo.thongke_tiendo') }}">
                                <li class="mb-1" aria-expanded="false">
                                    <div class="title-menu">
                                        <div class="title-menu-second align-items-center">
                                            Thống kê tiến độ công việc
                                        </div>
                                    </div>
                                </li>
                            </a>
                            <li class="mb-1" data-bs-toggle="collapse" role="button" data-bs-auto-close="false"
                                data-bs-target="#thong-ke-vanban" aria-expanded="false">
                                <div class="title-menu">
                                    <div class="title-menu-second align-items-center">
                                        Thống kê văn bản
                                    </div>
                                    <i class="icon-sidebar fa-solid fa-caret-down fa-lg"></i>
                                </div>

                                <div class="collapse-sub" id="thong-ke-vanban" style="">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <a class="title-menu" href="{{ route('thongke.vanbanden') }}">
                                            <div class="title-menu-third">Văn bản đến
                                            </div>
                                        </a>
                                        <a class="title-menu" href="{{ route('thongke.vanbandi') }} }}">
                                            <div class="title-menu-third">Văn bản đi
                                            </div>
                                        </a>
                                        @if (isset($user->view_thongke) && $user->view_thongke === 1)
                                            <a class="title-menu" href="{{ route('thongke.vanbannoibo') }} }}">
                                                <div class="title-menu-third">Văn bản nội bộ
                                                </div>
                                            </a>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        @if ($donviuser && $donviuser->isDonvi)
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li class="mb-1" data-bs-toggle="collapse" role="button"
                                    data-bs-auto-close="false" data-bs-target="#van-ban-den" aria-expanded="false">
                                    <div class="title-menu">
                                        <div class="title-menu-second align-items-center">
                                            Văn bản đến
                                        </div>
                                        <i class="icon-sidebar fa-solid fa-caret-down fa-lg"></i>
                                    </div>

                                    <div class="collapse-sub" id="van-ban-den" style="">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                            @if (isset($user->vanthudonvi) && $user->vanthudonvi == 1)
                                                <a class="title-menu" href="{{ route('add.van.ban.den_donvi') }} }}">
                                                    <div class="title-menu-third">Nhập văn bản đến
                                                    </div>
                                                </a>
                                            @endif
                                            <a class="title-menu" href="{{ route('danhsach.vanbanden_donvi') }}">
                                                <div class="title-menu-third">Danh sách văn bản đến
                                                </div>
                                            </a>
                                        </ul>
                                    </div>
                                </li>
                                @if (isset($user->vanthudonvi) && $user->vanthudonvi == 1)
                                    <li class="mb-1" data-bs-toggle="collapse" role="button"
                                        data-bs-auto-close="false" data-bs-target="#van-ban-di"
                                        aria-expanded="false">
                                        <div class="title-menu">
                                            <div class="title-menu-second align-items-center">
                                                Văn bản đi
                                            </div>
                                            <i class="icon-sidebar fa-solid fa-caret-down fa-lg"></i>
                                        </div>

                                        <div class="collapse-sub" id="van-ban-di" style="">
                                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                                <a class="title-menu" href="{{ route('add.van.ban.di_donvi') }}">
                                                    <div class="title-menu-third">Nhập văn bản đi
                                                    </div>
                                                </a>
                                                <a class="title-menu" href="{{ route('danhsach.vanbandi_donvi') }}">
                                                    <div class="title-menu-third">Danh sách văn bản đi
                                                    </div>
                                                </a>
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </li>
                @if ($user->role == $userRoles['admin'])
                    <li class="mb-1 mobile-li">
                        <div class="menu-item title-menu" data-bs-toggle="collapse" data-bs-target="#admin-collapse"
                            aria-expanded="false">
                            <div class="title-menu-first align-items-center rounded collapsed">
                                Quản trị hệ thống
                            </div>
                            <i class="fa-solid fa-caret-down fa-lg" style="color: white"></i>
                        </div>
                        <div class="collapse collapse-mb" id="admin-collapse" style="">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li class="mb-1" data-bs-toggle="collapse" role="button"
                                    data-bs-auto-close="false" data-bs-target="#van-ban-den" aria-expanded="false">
                                    <div class="title-menu">
                                        <div class="title-menu-second align-items-center">
                                            Danh mục
                                        </div>
                                        <i class="icon-sidebar fa-solid fa-caret-down fa-lg"></i>
                                    </div>

                                    <div class="collapse-sub" id="van-ban-den" style="">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                            <a class="title-menu" href="{{ route('co_quan.list') }}">
                                                <div class="title-menu-third">Cơ quản gửi, nhận
                                                </div>
                                            </a>
                                        </ul>
                                    </div>
                                </li>
                                <a style="text-decoration: none;" href="{{ route('danh_sach_tai_khoan') }}">
                                    <li class="mb-1" aria-expanded="false">
                                        <div class="title-menu">
                                            <div class="title-menu-second align-items-center">
                                                Quản lý tài khoản
                                            </div>
                                        </div>
                                    </li>
                                </a>
                                <a style="text-decoration: none;" href="{{ route('quan_ly_don_vi') }}">
                                    <li class="mb-1" aria-expanded="false">
                                        <div class="title-menu">
                                            <div class="title-menu-second align-items-center">
                                               Quản lý đơn vị
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            </ul>
                        </div>
                    </li>
                @endif
                <li class="mb-1 mobile-li">
                    <div class="menu-item title-menu" data-bs-toggle="collapse" data-bs-target="#tax-collapse"
                        aria-expanded="false">
                        <div class="title-menu-first align-items-center rounded collapsed">
                            Tra cứu Lương - Thuế
                        </div>
                        <i class="fa-solid fa-caret-down fa-lg" style="color: white"></i>
                    </div>
                    <div class="collapse collapse-mb" id="tax-collapse" style="">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            @if (isset($user->qlluong) && $user->qlluong === 1)
                                <a style="text-decoration: none;" href="{{ route('import_luong') }}">
                                    <li class="mb-1" aria-expanded="false">
                                        <div class="title-menu">
                                            <div class="title-menu-second align-items-center">
                                                Quản lý nhập lương - thuế
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @endif
                            <a style="text-decoration: none;" href="{{ route('xem_luong_thue') }}">
                                <li class="mb-1" aria-expanded="false">
                                    <div class="title-menu">
                                        <div class="title-menu-second align-items-center">
                                            Xem lương - thuế cá nhân
                                        </div>
                                    </div>
                                </li>
                            </a>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="second-nav navbar-expand-lg">
    <div class="container-fluid navbar-custom">
        <ul class="navbar-nav me-auto  mb-lg-0">
            <div style="height: 100%">
                <li class="nav-item nav-item-header dropdown-center">
                    <div class="nav-link nav-second-link" data-bs-auto-close="true" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="title-nav-item">Điều hành tác nghiệp</div>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                    <ul class="dropdown-menu custom-menu mt-1 rounded-0">
                        @if (in_array($user->role, [$userRoles['chuyenvien'], $userRoles['lanhdao'], $userRoles['vanthu']]))
                            <li
                                class="dropdown-item dropend dropdown-second-nav border border-primary border-bottom-0 border-opacity-75 pt-2 pb-2">
                                <div class="dropdown-link" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <div>Văn bản đến</div>
                                    <i class="fa-solid fa-caret-right"></i>
                                </div>
                                <ul class="dropdown-menu rounded-0">
                                    @if ($user->role == $userRoles['vanthu'])
                                        <a class="dropdown-item border border-primary border-opacity-75 pt-2 pb-2"
                                            role="button" href="{{ route('add.van.ban.den') }}">
                                            <li class="dropsub-item">
                                                Nhập văn bản đến
                                            </li>
                                        </a>
                                    @endif
                                    <a class="dropdown-item border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                                        role="button" href="{{ route('danhsach.vanbanden') }}">
                                        <li class="dropsub-item">
                                            Danh sách văn bản đến
                                        </li>
                                    </a>
                                    @if (in_array($user->role, [$userRoles['vanthu'], $userRoles['lanhdao']]))
                                        <a class="dropdown-item border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                                            role="button" href="{{ route('baocao.thong_ke_theo_don_vi') }}">
                                            <li class="dropsub-item">
                                                Thống kê theo đơn vị
                                            </li>
                                        </a>
                                        <a class="dropdown-item border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                                            role="button" href="{{ route('baocao.thong_ke_theo_ca_nhan') }}">
                                            <li class="dropsub-item">
                                                Thống kê theo cá nhân
                                            </li>
                                        </a>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        @if ($user->role == $userRoles['vanthu'])
                            <li
                                class="dropdown-item dropend dropdown-second-nav border border-primary border-opacity-75 pt-2 pb-2">
                                <div class="dropdown-link" role="button" data-bs-auto-close="true"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div>Văn bản đi</div>
                                    <i class="fa-solid fa-caret-right"></i>
                                </div>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item border border-primary border-opacity-75 pt-2 pb-2"
                                        role="button" href="{{ route('add.van.ban.di') }}">
                                        <li class="dropsub-item">
                                            Nhập văn bản đi
                                        </li>
                                    </a>
                                    <a class="dropdown-item border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                                        role="button" href="{{ route('danhsach.vanbandi') }}">
                                        <li class="dropsub-item">
                                            Danh sách văn bản đi
                                        </li>
                                    </a>
                                </ul>
                            </li>
                        @endif
                        <li
                            class="dropdown-item dropend dropdown-second-nav border border-primary border-opacity-75 pt-2 pb-2">
                            <div class="dropdown-link" role="button" data-bs-auto-close="true"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div>Văn bản nội bộ</div>
                                <i class="fa-solid fa-caret-right"></i>
                            </div>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item border border-primary border-opacity-75 pt-2 pb-2"
                                    role="button" href="{{ url('vanbannoibo/nhap') }}">
                                    <li class="dropsub-item">
                                        Ban hành văn bản nội bộ
                                    </li>
                                </a>
                                <a class="dropdown-item border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                                    role="button" href="{{ url('vanbannoibo/danh-sach-gui') }}">
                                    <li class="dropsub-item">
                                        Văn bản nội bộ đã gửi
                                    </li>
                                </a>
                                <a class="dropdown-item border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                                    role="button" href="{{ url('vanbannoibo/danh-sach-nhan') }}">
                                    <li class="dropsub-item">
                                        Văn bản nội bộ đã nhận
                                    </li>
                                </a>
                            </ul>
                        </li>
                        <a class="dropdown-item dropdown-second-nav border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                            role="button" href="{{ route('danhsachcongviec') }}">
                            <div class="dropdown-link">
                                Quản lý công việc
                            </div>
                        </a>
                        <a class="dropdown-item dropdown-second-nav border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                            role="button" href="{{ route('phonghop.danhsachdangkylichtuan') }}">
                            <div class="dropdown-link">
                                Đăng ký lịch tuần
                            </div>
                        </a>
                        @if ($user->role == $userRoles['admin'])
                            <a class="dropdown-item dropdown-second-nav border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                                role="button" href="{{ route('phonghop.danhsachphonghop') }}">
                                <div class="dropdown-link">
                                    Danh sách phòng họp
                                </div>
                            </a>
                        @endif
                        <a class="dropdown-item dropdown-second-nav border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                            role="button" href="{{ route('quanlytiendo.danhsach') }}">
                            <div class="dropdown-link">
                                Quản lý tiến độ
                            </div>
                        </a>
                        <a class="dropdown-item dropdown-second-nav border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                            role="button" href="{{ route('quanlytiendo.thongke_tiendo') }}">
                            <div class="dropdown-link">
                                Thống kê tiến độ công việc
                            </div>
                        </a>
                        <li
                            class="dropdown-item dropend dropdown-second-nav border border-primary border-top-0 border-opacity-75 pt-2 pb-2">
                            <div class="dropdown-link" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <div>Thống kê văn bản</div>
                                <i class="fa-solid fa-caret-right"></i>
                            </div>
                            <ul class="dropdown-menu rounded-0">
                                <a class="dropdown-item border border-primary border-opacity-75 pt-2 pb-2"
                                    role="button" href="{{ route('thongke.vanbanden') }}">
                                    <li class="dropsub-item">
                                        Văn bản đến
                                    </li>
                                </a>
                                <a class="dropdown-item border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                                    role="button" href="{{ route('thongke.vanbandi') }}">
                                    <li class="dropsub-item">
                                        Văn bản đi
                                    </li>
                                </a>
                                @if (isset($user->view_thongke) && $user->view_thongke === 1)
                                    <a class="dropdown-item border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                                        role="button" href="{{ route('thongke.vanbannoibo') }}">
                                        <li class="dropsub-item">
                                            Văn bản nội bộ
                                        </li>
                                    </a>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    @if ($donviuser && $donviuser->isDonvi)
                        <ul class="dropdown-menu custom-menu rounded-0">
                            <li
                                class="dropdown-item dropend dropdown-second-nav border border-primary border-top-0 border-opacity-75 pt-2 pb-2">
                                <div class="dropdown-link" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <div>Văn bản đến</div>
                                    <i class="fa-solid fa-caret-right"></i>
                                </div>
                                <ul class="dropdown-menu rounded-0">
                                    @if (isset($user->vanthudonvi) && $user->vanthudonvi == 1)
                                        <a class="dropdown-item border border-primary border-opacity-75 pt-2 pb-2"
                                            role="button" href="{{ route('add.van.ban.den_donvi') }}">
                                            <li class="dropsub-item">
                                                Nhập văn bản đến
                                            </li>
                                        </a>
                                    @endif
                                    <a class="dropdown-item border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                                        role="button" href="{{ route('danhsach.vanbanden_donvi') }}">
                                        <li class="dropsub-item">
                                            Danh sách văn bản đến
                                        </li>
                                    </a>
                                </ul>
                            </li>
                            @if (isset($user->vanthudonvi) && $user->vanthudonvi == 1)
                                <li
                                    class="dropdown-item dropend dropdown-second-nav border border-primary border-top-0 border-opacity-75 pt-2 pb-2">
                                    <div class="dropdown-link" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <div>Văn bản đi</div>
                                        <i class="fa-solid fa-caret-right"></i>
                                    </div>
                                    <ul class="dropdown-menu rounded-0">
                                        <a class="dropdown-item border border-primary border-opacity-75 pt-2 pb-2"
                                            role="button" href="{{ route('add.van.ban.di_donvi') }}">
                                            <li class="dropsub-item">
                                                Nhập văn bản đi
                                            </li>
                                        </a>
                                        <a class="dropdown-item border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                                            role="button" href="{{ route('danhsach.vanbandi_donvi') }}">
                                            <li class="dropsub-item">
                                                Danh sách văn bản đi
                                            </li>
                                        </a>

                                    </ul>
                                </li>
                            @endif
                        </ul>
                    @endif
                </li>
            </div>
            @if ($user->role == $userRoles['admin'])
                <div style="height: 100%">
                    <li class="nav-item nav-item-header dropdown-center">
                        <div class="nav-link nav-second-link" data-bs-auto-close="true" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="title-nav-item">Quản trị hệ thống</div>
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                        <ul class="dropdown-menu custom-menu mt-1 rounded-0">
                            <li
                                class="dropdown-item dropend dropdown-second-nav border border-primary border-opacity-75 pt-2 pb-2">
                                <div class="dropdown-link" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <div>Danh mục</div>
                                    <i class="fa-solid fa-caret-right"></i>
                                </div>
                                <ul class="dropdown-menu rounded-0">
                                    <a class="dropdown-item border border-primary border-opacity-75 pt-2 pb-2"
                                        role="button" href="{{ route('co_quan.list') }}">
                                        <li class="dropsub-item">
                                            Cơ quan gửi, nhận
                                        </li>
                                    </a>
                                </ul>
                            </li>
                            <a class="dropdown-item dropdown-second-nav border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                                role="button" href="{{ route('danh_sach_tai_khoan') }}">
                                <div class="dropdown-link">
                                    Quản lý tài khoản
                                </div>
                            </a>
                            <a class="dropdown-item dropdown-second-nav border border-primary border-top-0 border-opacity-75 pt-2 pb-2"
                            role="button" href="{{ route('quan_ly_don_vi') }}">
                            <div class="dropdown-link">
                                Quản lý đơn vị
                            </div>
                        </a>
                        </ul>
                    </li>
                </div>
            @endif
            <div style="height: 100%">
                <li class="nav-item nav-item-header dropdown-center">
                    <div class="nav-link nav-second-link" data-bs-auto-close="true" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="title-nav-item">Tra cứu lương - thuế</div>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                    <ul class="dropdown-menu custom-menu mt-1 rounded-0">
                        @if (isset($user->qlluong) && $user->qlluong === 1)
                            <a class="dropdown-item dropdown-second-nav border border-primary border-opacity-75 pt-2 pb-2"
                                role="button" href="{{ route('import_luong') }}">
                                <div class="dropdown-link">
                                    Quản lý nhập lương - thuế
                                </div>
                            </a>
                        @endif
                        <a class="dropdown-item dropdown-second-nav border border-primary border-top-0 border-top-0 border-opacity-75 pt-2 pb-2"
                            role="button" href="{{ route('import_luong') }}">
                            <div class="dropdown-link">
                                Xem lương - thuế cá nhân
                            </div>
                        </a>
                    </ul>
                </li>
            </div>
        </ul>
        <input type="checkbox" class="calender-check" id="calender-check" hidden>
        <label class="overlay-calender" for="calender-check"></label>
        <div class="d-flex">
            <label for="calender-check">
                <div class="calender-btn hover-effect">
                    <div class="calender-text">
                        Lịch tuần</div>
                    <div class="calender">
                        <img src="{{ asset('img/assets/icon/Iconlich.png') }}" alt="Lịch tuần" style="padding-bottom: 4px;">
                    </div>
                </div>
            </label>
        </div>
        <div class="calender-sidebar">
            <div class="cal-header">
                <div class="cal-title">
                    <div class="div-title">
                        <div class="tag"
                            style="width: 12px; height: 32px; position: relative; background: #1668C7; border-radius: 4px">
                        </div>
                        <div class="text-title-cal">Lịch tuần</div>
                    </div>
                    <div class="icon-title">
                        <label for="calender-check">
                            <div class="icon-background">
                                <i class="fa-solid fa-xmark fa-lg"></i>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="choose-week">
                    <div class="title-choose">
                        <b>Tuần 01: </b>
                    </div>
                    <select class="custom-select select-choose" name="date-schedule" id="date-schedule">
                    </select>
                </div>
            </div>
            <div class="show-week">
                <ul class="nav nav-pills pt-2 pb-2 cal-week" id="pills-tab" role="tablist">
                    <li class="nav-item date-li" role="presentation">
                        <div class="show-day">T2</div>
                        <div class="nav-link rounded-circle active" id="tab-0" data-bs-toggle="pill"
                            data-bs-target="#monday" type="button" role="tab" aria-controls="monday"
                            aria-selected="true">01</div>
                    </li>
                    <li class="nav-item date-li" role="presentation">
                        <div class="show-day">T3</div>
                        <div class="nav-link rounded-circle" id="tab-1" data-bs-toggle="pill"
                            data-bs-target="#tueday" type="button" role="tab" aria-controls="tueday"
                            aria-selected="false">02</button>
                    </li>
                    <li class="nav-item date-li" role="presentation">
                        <div class="show-day">T4</div>
                        <div class="nav-link rounded-circle" id="tab-2" data-bs-toggle="pill"
                            data-bs-target="#wednesday" type="button" role="tab" aria-controls="wednesday"
                            aria-selected="false">03</div>
                    </li>
                    <li class="nav-item date-li" role="presentation">
                        <div class="show-day">T5</div>
                        <div class="nav-link rounded-circle" id="tab-3" data-bs-toggle="pill"
                            data-bs-target="#thusday" type="button" role="tab" aria-controls="thusday"
                            aria-selected="false">04</div>
                    </li>
                    <li class="nav-item date-li" role="presentation">
                        <div class="show-day">T6</div>
                        <div class="nav-link rounded-circle" id="tab-4" data-bs-toggle="pill"
                            data-bs-target="#friday" type="button" role="tab" aria-controls="friday"
                            aria-selected="false">05</div>
                    </li>
                    <li class="nav-item date-li" role="presentation">
                        <div class="show-day-weekend">T7</div>
                        <div class="nav-link rounded-circle" id="tab-5" data-bs-toggle="pill"
                            data-bs-target="#saturday" type="button" role="tab" aria-controls="saturday"
                            aria-selected="false">06</div>
                    </li>
                    <li class="nav-item date-li" role="presentation">
                        <div class="show-day-weekend">CN</div>
                        <div class="nav-link rounded-circle" id="tab-6" data-bs-toggle="pill"
                            data-bs-target="#sunday" type="button" role="tab" aria-controls="sunday"
                            aria-selected="false">07</div>
                    </li>
                </ul>
            </div>
            <div class="tab-content tab-body" id="pills-tabContent">
                <div class="tab-pane tab-list fade show active" id="monday" role="tabpanel"
                    aria-labelledby="tab-0">
                    <div class="cal-content">
                        <div class="event-item">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane tab-list fade" id="tueday" role="tabpanel" aria-labelledby="tab-1">
                    <div class="cal-content">
                        <div class="event-item">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane tab-list fade" id="wednesday" role="tabpanel" aria-labelledby="tab-2">
                    <div class="cal-content">
                        <div class="event-item">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane tab-list fade" id="thusday" role="tabpanel" aria-labelledby="tab-3">
                    <div class="cal-content">
                        <div class="event-item">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane tab-list fade" id="friday" role="tabpanel" aria-labelledby="tab-4">
                    <div class="cal-content">
                        <div class="event-item">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane tab-list fade" id="saturday" role="tabpanel" aria-labelledby="tab-5">
                    <div class="cal-content">
                        <div class="event-item">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane tab-list fade" id="sunday" role="tabpanel" aria-labelledby="tab-6">
                    <div class="cal-content">
                        <div class="event-item">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('header-scripts')
    <script>
        let noUnReadNotification;

        function getNotifications() {
            $.get("{{ route('notification.list_notifications') }}", (res) => {
                $('.header-app .navbar-custom .notification-btn .notification-wrap').html(res);
                $('.header-app .navbar-custom .noti-mobile .notification-wrap-mb').html(res);
            })
        }

        function xemTatca() {
            $.post("{{ route('notification.view_all') }}", {
                _token: $('meta[name="csrf-token"]').attr('content')
            }, (res) => {
                getNotifications()
            }, 'json')
        }

        getNotifications();
        setInterval(getNotifications, 60000);

        function logout() {
            window.location.href = '{{ url('logout') }}';
        }

        function getDateW(date, i = 0, type = "default") {
            const dayNextW = new Date(date.getTime() + (i * 7 * 24 * 60 * 60 * 1000));
            const yyyy = dayNextW.getFullYear();
            const mm = String(dayNextW.getMonth() + 1).padStart(2, '0');
            const dd = String(dayNextW.getDate()).padStart(2, '0');

            switch (type) {
                case "day":
                    return dd.toString();
                case "style":
                    return `${yyyy}-${mm}-${dd}`;
                default:
                    return `${dd}/${mm}/${yyyy}`;
            }
        }

        function selectWeek(date, type = "day") {
            var week = new Array();
            Array(7).fill(new Date(date)).map((el, idx) => {
                week.push(
                    getDateW(new Date(el.setDate(el.getDate() - (el.getDay() - 1) + idx)), 0, type)
                );
            });
            return week;
        }

        const today = new Date();

        function getLichTuan(day, selector) {
            $.get(`{{ route('api.get_lich_tuan') }}?date=${day}`, function(data) {
                $(`#${selector} > .cal-content`).html(data);
            });
        }

        function getWeekNumber(date) {
            const onejan = new Date(date.getFullYear(), 0, 1);
            const daysOffset = Math.floor((date - onejan) / (24 * 60 * 60 * 1000));
            const week = Math.ceil((daysOffset + onejan.getDay() + 1) / 7);
            return week;
        }

        function getWeekRange(d) {
            const date = new Date(d);
            const day = date.getDay();
            const firstDay = new Date(date);
            firstDay.setDate(date.getDate() - day + (day === 0 ? -6 : 1));
            const lastDay = new Date(firstDay);
            lastDay.setDate(firstDay.getDate() + 6);
            return {
                firstDay,
                lastDay
            };
        }
        const {
            firstDay,
            lastDay
        } = getWeekRange(today);

        // Load select
        for (i = 0; i < 4; i++) {
            $("#date-schedule").append($('<option>', {
                value: getDateW(firstDay, i, 'style'),
                text: `(${getDateW(firstDay, i)} - ${getDateW(lastDay, i)})`,
            }));
        }
        getLichTuan(getDateW(today, 0, 'style'), 'monday');

        function populateTabs(weekArray, targetProperty) {
            $.each(weekArray, function(i, v) {
                $(`#tab-${i}`)[targetProperty](v);
            });
        }

        $("#date-schedule").on('change', function() {
            var dateSelected = new Date(this.value);
            $('.title-choose b').html(`Tuần ${getWeekNumber(dateSelected)}:`);
            const weekDates = selectWeek(dateSelected);
            populateTabs(weekDates, 'html');
            const weekStyleDates = selectWeek(dateSelected, "style");
            populateTabs(weekStyleDates, 'val');
        });

        $('.title-choose b').html(`Tuần ${getWeekNumber(today)}:`);

        const weekDates = selectWeek(today);
        populateTabs(weekDates, 'html');

        const weekStyleDates = selectWeek(today, "style");
        populateTabs(weekStyleDates, 'val');


        $('.date-li .nav-link').click(function() {
            var day_text = $(this).val();
            getLichTuan(day_text, $(this).attr('aria-controls'));
        });
    </script>
@endsection
