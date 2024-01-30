<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ URL:: asset('assets') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Verify Email</title>

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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/fonts/materialdesignicons.css') }}" />
    
    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
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

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <style>
        .authentication-wrapper.authentication-basic .authentication-inner{
            max-width: 700px !important;
        }
    </style>

    @yield('head')
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
                    <h5>
                        Email Verification
                    </h5>
                    <div class="card-body">
                        <div class="mb-10 text-gray-600 text-md">
                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we
                            just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }} <strong>If you already confirmed your email, just refresh this page.</strong>
                        </div>
                        
                        @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                        @endif
                        
                        <div class="mt-4 flex items-center justify-between">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                        
                                <div>
                                    <p style="cursor:pointer;" class="text-sm mb-0">Didn't recieve any emails?</p>
                                    <x-primary-button>
                                        {{ __('Resend Verification Email') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                        
                                <button type="submit"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
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