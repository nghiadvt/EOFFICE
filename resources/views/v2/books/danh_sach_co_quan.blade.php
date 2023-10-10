@extends(config('app.interface') . 'templates.lanhdao')
@section('title', 'Danh sách đơn vị')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/v2/list_doc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/dang_ky_lich_tuan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v2/quan_ly_don_vi.css') }}">
@endsection
@section('content')
        <div class="container-flud income-pages mx-0 col-md-12" >
              <div class="row group-function mx-0 col-md-12">
            <div class="col-md-12 offset-sx-12 breadcrumbs mx-0 px-0">
                <div class="row group-function mx-0 col-md-12">
                    <div class="breadcrumbs-link links">
                        <div><a href="" class="txt-link">Quản trị hệ thống</a></div>
                        <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                        <div><a href="" class="txt-link">Danh mục</a></div>
                         <div><img src="{{ asset('img/assets/icon/expand_right.png') }}" class="img-expand"></div>
                        <div><a href="" class="txt-link">Cơ quan gửi, nhận</a></div>
                    </div>
                </div>
              
            </div>
                    <h1>SẼ CẬP NHẬT VÀ BỔ SUNG SAU</h1>
        </div>
        </div>
@endsection