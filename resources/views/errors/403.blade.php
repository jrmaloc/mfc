<!DOCTYPE html>

<html lang="en" class="light-style layout-wide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Error - 403</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

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
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/pages/page-misc.css') }}" />

    <!-- Helpers -->
    <script src="{{ URL::asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ URL::asset('assets/js/config.js') }}"></script>

    <style>
        @media(max-width: 425px) {
            h1.mb-2.mx-2 {
                font-size: 8rem !important;
            }

            div#buttons {
                display: flex;
                flex-direction: column;
                gap: 0 !important;
            }

            div#buttons a {
                margin: 4px 0px;
            }

            p.mb-4 {
                font-size: 10px;
            }
        }

        div#buttons {
            display: flex !important;
            gap: 20px;
        }
    </style>
</head>

<body>
    <!-- Content -->

    <!--Under Maintenance -->
    <div class="misc-wrapper">
        <h1 class="mb-2 mx-2" style="font-size: 15rem">403</h1>
        <h4 class="mb-1">You do not have the right permission to view this page. ⚠️</h4>
        <div class="d-flex justify-content-center mt-5">
            <img src="{{ URL::asset('assets/img/illustrations/tree-3.png') }}" alt="misc-tree"
                class="img-fluid misc-object d-none d-lg-inline-block" width="80" />
            <img src="{{ URL::asset('assets/img/illustrations/misc-mask-light.png') }}" alt="misc-error"
                class="scaleX-n1-rtl misc-bg d-none d-lg-inline-block"
                data-app-light-img="illustrations/misc-mask-light.png"
                data-app-dark-img="illustrations/misc-mask-dark.png" />
            <div class="d-flex flex-column align-items-center" style="width: 450px;">
                <img src="{{ URL::asset('assets/img/illustrations/man-with-laptop-light.png') }}" alt="misc-error"
                    class="misc-model img-fluid z-1" width="780"
                    style="margin-top: 4.25rem;
                    margin-bottom: 4.26rem;
                    width: 400px;" />
                <div class="flex" id="buttons">
                    <a href="javascript:void(0);" id="home" class="btn btn-primary text-center">Go Back</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Under Maintenance -->
    <!-- / Content -->

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
</body>

<script>
    $(document).ready(function() {
        $('#home').click(function() {
            window.history.back();
        });
    });
</script>
</html>
