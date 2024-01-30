<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ URL:: asset('assets') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>MFC - Directory</title>

    @vite('resources/css/app.css')

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#019233">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/fonts/materialdesignicons.css') }}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/node-waves/node-waves.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ URL:: asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ URL:: asset('assets/js/config.js') }}"></script>

    <style>
        .form-floating-outline .form-control:focus,
        .form-floating-outline .form-select:focus {
            border-color: #1b661b !important;
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:focus:not(:placeholder-shown)~label,
        .form-floating>.form-select:focus~label,
        .form-floating>.form-select:focus:not(:placeholder-shown)~label {
            color: #1b661b;
        }

        .form-check-input:checked {
            background-color: #56ca00;
            border-color: #1b661b;
        }

        .input-group:not(.input-group-floating):focus-within .form-control,
        .input-group:not(.input-group-floating):focus-within .input-group-text {
            border-color: #1b661b;
        }
    </style>
</head>

<body>
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y" style="background: #E8F8F5;">
            <div class="authentication-inner py-4">
                <div class="card px-4">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center my-4">
                        <a href="/login" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <span style="color: #1b661b">
                                    <img class="mr-1" src="/favicon.ico" alt="">
                                </span>
                            </span>
                            <span class="app-brand-text demo text-heading fw-semibold">MFC Portal</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <div class="card-body">
                        <h4 class="mb-2">{{ __('Reset Password 🔒') }}</h4>
                        <p class="mb-4">Enter your new password. Make sure to remember it!</p>

                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" placeholder="Enter your email" value="{{ $email ?? old('email') }}"
                                    autofocus required autocomplete="email" readonly />
                                <label for="email">{{ __('Email Address') }}</label>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    id="password" name="password" placeholder="********" required
                                    autocomplete="new-password" />
                                <label for="password">{{ __('Password') }}</label>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input class="form-control" type="password" id="password-confirm"
                                    name="password-confirm" placeholder="********" required autocomplete="password" />
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>

                                @error('password-confirm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-dark d-grid w-100 mb-10">
                                Reset Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<!-- Core JS -->
<script src="{{ URL:: asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ URL:: asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ URL:: asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ URL:: asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ URL:: asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ URL:: asset('assets/vendor/js/menu.js') }}"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ URL:: asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ URL:: asset('assets/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ URL:: asset('assets/js/dashboards-analytics.js') }}"></script>

<!-- Datatables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Calendar -->
@stack('scripts')

</html>