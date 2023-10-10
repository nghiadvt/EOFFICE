<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/sass/auth.scss', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocumentLog in to UDN Centraliezd Authentication</title>
</head>
<body>
    <div class="container-fuild mx-0 text-responsive login-panel">
        <div class="row d-flex justify-content-center align-items-center mx-0">
            <div class="col-md-6 col-sx-12 login-form-panel">
                <div class="txt-title">
                    <div>Đăng nhập</div>
                    <div>Chứng thực tập trung UDN</div>
                </div>
                <a href="" class="btn-login-form second-bg py-4">
                    <img src="{{asset('assests/icon/logo-google.png')}}" class="img-logo py-2">
                    <div class="txt-btn-form"><b>Đăng nhập bằng Google</b></div>
                </a>
                <a href="" class="btn-login-form primary-bg py-4">
                    <img src="{{asset('assests/icon/logo-microsoft.png')}}" class="img-logo py-2">
                    <div class="txt-btn-form"><b>Đăng nhập bằng Microsoft</b></div>
                </a>
                <a href="" class="link-support-form">Cần sự trợ giúp?</a>
            </div>
            <div class="col-md-6 qr-download-panel mx-0 py-5 px-5">
                <div class="row txt-title white-cl pt-5 pb-3 px-5">
                    <div>Mã QR-Code</div>
                    <div>Quét để tải ứng dụng</div>
                </div>
                <div class="row d-flex align-content-center mx-0 px-0">
                    <div class="d-flex justify-content-center mobile-app col-md-8 pb-5">
                        <img class="img-device" src="{{asset('assests/icon/devices.png')}}" alt="mobile-device">
                    </div>
                    <div class="col-md-4 px-5 float-end mt-0 qr-code-download">
                        <div class="row qr-code-android col-sx-6 mb-4">
                            <div class="d-flex justify-content-center">
                                <img class="pb-3" src="{{asset('assests/icon/qr-code-android.svg')}}">
                            </div>
                            <div class="d-flex justify-content-center">
                                <img class="img-qr-download pb-3" src="{{asset('assests/icon/download-android.png')}}">
                            </div>
                        </div>
                        <div class="row qr-code-ios col-sx-6">
                            <div class="d-flex justify-content-center">
                                <img class="pb-3" src="{{asset('assests/icon/qr-code-ios.svg')}}">
                            </div>
                            <div class="d-flex justify-content-center">
                                <img class="img-qr-download pb-3" src="{{asset('assests/icon/download-ios.png')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>