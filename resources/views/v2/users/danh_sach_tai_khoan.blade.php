@extends(config('app.interface') . 'templates.lanhdao')
@section('title', 'Danh sách tài khoản')
@section('style')
<link rel="stylesheet" href="{{asset('css/v2/list_doc.css')}}">   
<link rel="stylesheet" href="{{ asset('css/v2/dang_ky_lich_tuan.css') }}">
<link rel="stylesheet" href="{{asset('css/v2/danh_sach_tai_khoan.css')}}">   
@endsection
@section('content')
    <div class="container-flud income-pages mx-0  col-md-12">
        {{-- @include('flash::message') --}}
        <div class="row group-function mx-0 col-md-12">
            <div class="col-md-12 offset-sx-12 breadcrumbs mx-0 px-0">
                <div class="breadcrumbs-link">
                    <div><a href="" class="txt-link">Quản trị hệ thống</a></div>
                    <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                    <div><a href="" class="txt-link">Danh sách tài khoản</a></div>
                </div>
                <div class="row"> 
                        <div class="title-page col-md-8">Danh sách tài khoản</div>
                        <div class="col-md-4 d-flex justify-content-end" >
                            <div>
                                <a class="btn btn-primary pr-4" style="margin-right: 5px;"
                                href="{{ route('them_tai_khoan') }}"><i class=" fa-solid fa-user"></i> Thêm tài
                                khoản</a>
                            </div>
                            <div>
                                <form id="form-search" method="GET" action="{{ base_url() }}" accept-charset="UTF-8">
                                    {{ csrf_field() }}
                                    <input type="text" placeholder="Tìm kiếm" name="keySearch" class="form-control ml-2"
                                        value="<?php echo $keySearch; ?>" />
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="row table-list-documents mx-0">
            <table class="table-content">
                <thead >
                    <tr class="field-title">
                        <th scope="col" class="num-docs">STT</th>
                        <th scope="col" class="ma-cb">Mã cán bộ</th>
                        <th scope="col" class="content-docs">Họ và tên</th>
                        <th scope="col" class="content-docs">Đơn vị</th>
                        <th scope="col" class="content-docs">Email</th>
                        <th scope="col" class="content-docs">Vai trò</th>
                        <th style="width: 60px;">Chỉnh sửa</th>
                    </tr>
                </thead>
                <tbody>
                    @if (sizeof($users))
                        @php $stt = ($users->currentPage() - 1) * $users->perPage() + 1 @endphp
                        @foreach ($users as $user)
                            <tr class="item item-container">
                                <td class="" style="text-align: center">{{ $stt++ }}</td>
                                <td class="ma-cb" style="text-align: center">{{ $user->macanbo }}</td>
                                <td style="text-align: center">{{ $user->fullname }}</td>
                                <td style="text-align: center">{{ $user->donvi ? $user->donvi->name : '' }}</td>
                                <td class="s-email" style="text-align: center">{{ $user->email }}</td>
                                <td class="s-role" style="text-align: center">{{ $user->role_text }}</td>
                                <td style="text-align: center">
                                    <a href="{{ route('sua_tai_khoan', $user->id) }}" title="Sửa tài khoản"><i
                                            class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" align="center"><i> Không có dữ liệu</i></td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="pull-right">
                {!! $users->render() !!}
            </div>
        </div>
    </div>

@endsection
