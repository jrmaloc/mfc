<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Register!</title>

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

    <link rel="stylesheet" href="../assets/vendor/fonts/materialdesignicons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/css/butterup.css') }}">

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>

    @vite('resources/css/app.css')

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
    </style>
</head>

<body>
    <!-- Content -->

    @if ($errors->any())
        <script src="{{ URL::asset('assets/js/butterup.min.js') }}"></script>
        @foreach ($errors->all() as $error)
            <li class="hidden">{{ $error }}</li>
        @endforeach

        <script>
            const errorMessages = document.querySelectorAll('li');
            errorMessages.forEach(messageElement => {
                const message = messageElement.textContent;
                butterup.toast({
                    title: 'Heads Up!',
                    message: message,
                    location: 'top-right',
                    icon: true,
                    theme: 'glass',
                    dismissable: true,
                    type: 'warning',
                });
            });
        </script>
    @endif

    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y" style="background: #E8F8F5;">
            <div class="authentication-inner py-4">
                <!-- Register Card -->
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-2">
                        <a href="/dashboard" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <span style="color: #1b661b">
                                    <img class="mr-1" src="/favicon-96x96.png" alt="">
                                </span>
                            </span>
                            <span class="app-brand-text demo text-heading fw-semibold">Register Here!</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <div class="card-body mt-2">
                        <h4 class="mb-2">Adventure starts here 🚀</h4>
                        <p class="mb-4">Make your life easy and fun!</p>

                        <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input value="{{ old('name') }}" type="text" id="name"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            name="name" placeholder="Juan A. Dela Cruz" aria-describedby="name"
                                            autofocus />
                                        <label for="name">Full Name<i class="text-danger not-italic">*</i></label>
                                    </div>
                                    <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input value="{{ old('username') }}" type="text" id="username"
                                            class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                                            name="username" placeholder="Your Username" aria-describedby="username" />
                                        <label for="username">Username<i class="text-danger not-italic">*</i></label>
                                    </div>
                                    <span class="input-group-text"><i class="mr-1 font-bold">@</i></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input value="{{ old('email') }}" type="email" id="email"
                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                            name="email" placeholder="example@email.com"
                                            aria-describedby="email" />
                                        <label for="email">Email<i class="text-danger not-italic">*</i></label>
                                    </div>
                                    <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password"
                                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                            name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" />
                                        <label for="password" required>Password<i
                                                class="text-danger not-italic">*</i></label>
                                    </div>
                                    <span class="input-group-text"><i
                                            class="mdi mdi-eye-off cursor-pointer"></i></span>
                                </div>
                            </div>

                            <div class="mb-4 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password_confirmation"
                                            class="form-control {{ $errors->has('confirm') ? 'is-invalid' : '' }}"
                                            name="password_confirmation" placeholder="Confirm Password"
                                            aria-describedby="password_confirmation" />
                                        <label for="password_confirmation">Confirm Password<i
                                                class="not-italic text-danger">*</i></label>
                                    </div>
                                    <span class="input-group-text"><i
                                            class="mdi mdi-eye-off cursor-pointer"></i></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions"
                                        name="terms" checked required />
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to
                                        <a href="javascript:void(0);">privacy policy & terms</a>
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-success d-grid w-100">Sign up</button>
                        </form>

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="/login">
                                <span class="text-success">Sign in instead</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>

    <!-- / Content -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- ... Existing HTML ... -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const errorInputs = document.querySelectorAll('.is-invalid');
            if (errorInputs.length > 0) {
                const firstErrorInput = errorInputs[0];
                firstErrorInput.focus();
            }

            const eyeIcons = document.querySelectorAll('span .mdi-eye-off');
            // const passwordInput = document.querySelector('#password');
            // const passwordConfirmationInput = document.querySelector('#password_confirmation');

            eyeIcons.forEach(icon => {

                icon.addEventListener('click', function() {
                    if (icon.classList.contains('mdi-eye-off')) {
                        icon.classList.remove('mdi-eye-off');
                        icon.classList.add('mdi-eye');
                    } else {
                        icon.classList.remove('mdi-eye');
                        icon.classList.add('mdi-eye-off');
                    }
                });
            });
        });
    </script>
</body>

</html>
