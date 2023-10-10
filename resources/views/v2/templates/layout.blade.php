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
    <!-- Thư viện CSS của Choices -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <!-- Thư viện JavaScript của Choices -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <link href="{{asset('css/v2/chosen.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/v2/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
    <script src="{{asset('js/formValidation.min.js')}}"></script>
    <script src="{{asset('js/validate/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/validate/bootstrapValidator.min.js')}}"></script>
    <script src="{{asset('js/jquery.form.min.js')}}"></script>
    <script src="{{asset('js/jquery.dlmenu.js')}}"></script>
    <script src="{{asset('js/jquery.bootpag.min.js')}}"></script>

    <!-- Lib datetimepicker -->
    <script src="{{asset('js/datetimepicker/moment-with-locales.js')}}"></script>
    <script src="{{asset('js/datetimepicker/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{asset('js/dragscroll.js')}}"></script>
    <script src="{{asset('js/backend/custom.js')}}"></script>
    <script src="{{asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.js') }}"></script>
    <script src="{{asset('js/backend/custom.min.js')}}"></script>
    <!-- Lib select2 -->
    <script src="{{asset('js/backend/chosen.jquery.js')}}"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>


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
    </div>
    @yield('header-scripts')
    @yield('scripts')
</body>

</html>
