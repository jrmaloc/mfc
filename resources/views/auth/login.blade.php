<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

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
    <script src="{{ URL::asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ URL::asset('assets/js/config.js') }}"></script>
</head>

<body class="h-full" style="background-image: linear-gradient(to top, #dfe9f3 0%, white 100%); min-height: 100vh;">
    <!-- Content -->
    @if ($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                customClass: {
                    popup: 'colored-toast',
                },
                showConfirmButton: false,
                timer: 3000,
            })

            Toast.fire({
                icon: 'error',
                title: "Invalid Credentials",
            });
        </script>
    @endif

    <div class="overflow-x-hidden h-[100vh]">
        <div class="lg:p-[100px] p-[50px] w-full lg:flex lg:justify-center items-center mt-10 lg:mt-0">
            <div class="lg:w-[50%] w-full relative">
                <div class="lg:w-[500px] w-full">
                    <h1 class="text-[#7090e6] italic lg:text-[56px] text-[36px] w-[100%] font-bold">Welcome to our community</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                </div>
                <img src="{{ URL::asset('assets/img/backgrounds/login image.png') }}"
                    class="lg:w-[400px] absolute lg:right-[250px] lg:top-20 w-[300px] top-[450px] -z-10 lg:z-0" alt="">
            </div>
            <div class="lg:mt-[200px] mt-10 lg:w-[20%]">
                <form class="mb-3" action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control mb-1 bg-transparent" id="email_or_username" name="email_or_username"
                            placeholder="Enter your email or username" autofocus :value="old('email_or_username')" />
                        <label for="email_or_username" class="flex ">Email or Username<span
                                class="text-danger ml-1">*</span></label>
                        @error('email')
                            <span class="text-danger text-xs">This email doesn't exist in our records.</span>
                        @enderror
                        @error('username')
                            <span class="text-danger text-xs">This username doesn't exist in our records.</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="mb-3 form-password-toggle">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input type="password" id="password" class="form-control bg-transparent !border-r-0" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <label for="password" class="flex bg-transparent">Password<span class="text-danger ml-1">*
                                        </span></label>
                                </div>
                                <span class="input-group-text cursor-pointer eye bg-transparent">
                                    <i class="fa-solid fa-eye"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember-me" />
                            <label class="form-check-label" for="remember-me"> Remember Me </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="float-end mb-1">
                            <span class="text-primary">Forgot Password?</span>
                        </a>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                    </div>
                </form>

                <p class="text-center">
                    <span>Doesn't have an account yet?</span>
                    <a href="/register">
                        <span class="text-primary">Create an account</span>
                    </a>
                </p>
            </div>
        </div>
    </div>


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ URL::asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ URL::asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    @if (session('status'))
        <!-- <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div> -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                icon: 'success',
                title: 'General Title',
                animation: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 5000,
                progressBar: false,
            });

            Toast.fire({
                animation: true,
                title: "{{ session('status') }}",
            });
        </script>
    @endif
</body>

<script>
    const passwordField = document.getElementById("password");
    const togglePassword = document.querySelector(".eye i");

    $(document).ready(function() {
        $('.eye, .eye i').click(function() {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                togglePassword.classList.remove("fa-eye");
                togglePassword.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password"; // Change this line to set the type to "password"
                togglePassword.classList.remove("fa-eye-slash");
                togglePassword.classList.add("fa-eye");
            }
        });

        $('#closeButton').click(function() {
            $('#errorMessage').addClass("hidden");
        })
    });
</script>


</html>


