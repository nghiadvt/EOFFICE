@extends(config('app.interface').'templates.lanhdao')
@section('main')
    <style>
        .dropdown-item {
            display: block;
            width: 100%;
            padding: .25rem 1.5rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
            cursor: pointer;
        }

        .dropdown-item:focus, .dropdown-item:hover {
            color: #16181b;
            text-decoration: none;
            background-color: #f0f0f0;
        }

        .dropdown-menu {
            min-width: 124px !important;
        }

        .noidungbutphe::after {
            content: '-------------------------------------------------------';
            margin-bottom: 15px;
            display: block;
        }
    </style>
    <div class="container-fuild pdt20 text-center">
        <h3>Truy cập bị từ chối</h3>
        <p>Bạn không có quyền truy cập vào văn bản này.</p>
    </div>
@endsection