<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/v2/app.css') }}" />
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    {{-- moment --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    
    {{-- datetimepicker --}}
    <link href="{{ asset('js/datetimepicker/bootstrap-datetimepicker.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/datetimepicker/moment-with-locales.js') }}"></script>
    <script src="{{ asset('js/datetimepicker/bootstrap-datetimepicker.js') }}"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Thư viện CSS của Choices -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <!-- Thư viện JavaScript của Choices -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <!-- {{-- Jquery UI lib --}} -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"
        integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            var baseUrl = '{{config('app.url')}}';
        </script>
    
        @yield('style')
</head>

<body>
    <?php
    $user = \Illuminate\Support\Facades\Session::get('user');
    use App\Models\CheckUser;
    use App\Models\VanbanUser;
    use App\Models\VanbanXuLy;
    $combobox = [
        '1' => 'Bình Thường',
        '2' => 'Khẩn',
        '3' => 'Thượng Khẩn',
        '4' => 'Hỏa Tốc',
    ];
    $countcombo = count($combobox);
    $curUrl = Request::path();
    $user = (object) $user;
    $userRoles = App\Models\User::$roles;
    $donviuser = App\Models\Donvi::find($user->donvi_id);
    ?>
    <div class="app">
        <div class="header-app">
            @include(config('app.interface') . 'templates.header')
        </div>
        <div class="content-app">
            @yield('content')
        </div>
        <div class="footer-app">
            @include(config('app.interface') . 'templates.footer')
        </div>
        @include(config('app.interface') . 'templates.hotline')
    </div>
    <script src="{{ asset('js/v2/app.js') }}"></script>
    @yield('header-scripts')
    @yield('scripts')
</body>

</html>
