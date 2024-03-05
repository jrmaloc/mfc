<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <meta name="description" content="" />

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <link href="{{ URL::asset('assets/src/output.css') }}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">


    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/fonts/materialdesignicons.css') }}" />
    <!-- Menu waves for no-customizer fix
    -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/node-waves/node-waves.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('assets/css/butterup.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" />


    <!-- Helpers -->
    <script src="{{ URL::asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ URL::asset('assets/js/config.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <title>Contact Us</title>

    <style>
        html,
        body {
            background: #8870FF;
            margin: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Montserrat', sans-serif;
        }

        .container {
            background: #fff;
            width: 800px;
            height: 450px;
            border-radius: 24px;
            box-shadow: 16px 16px 8px rgba(0, 0, 0, .1);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .picture-container {
            /*   border: 1px solid blue; */
            width: 50%;
            height: 100%;
            align-self: flex-start;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .contact-form-container {
            height: 90%;
            width: 300px;
        }

        .contact-form {
            height: 100%;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            align-content: space-around;
        }

        .form-header {
            font-size: 2em;
            font-weight: 700;
            align-self: flex-start;
        }

        .email-input {
            border: none;
            outline: none;
            background: #eee;
            padding: 20px;
            border-radius: 6px;
            width: 100%;
            font-size: 100%;
        }

        .message {
            border: none;
            outline: none;
            resize: none;
            background: #eee;
            padding: 20px;
            border-radius: 6px;
            width: 100%;
            font-size: 100%;
        }

        .submit {
            border: none;
            outline: none;
            color: #fff;
            width: 100%;
            padding: 20px;
            background: #8870FF;
            font-size: 100%;
            font-weight: 600;
            border-radius: 6px;
            transition: transform 300ms 0s cubic-bezier(0, 0.23, 0.29, 2.45);
        }

        .submit:hover {
            cursor: pointer;
            background: #7F69EE;
            transform: translateY(-2px);
        }

        .relative.left-8 {
            left: -25px;
            top: -185px;
        }
    </style>

    <script src="{{ URL::asset('assets/vendor/js/bootstrap.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/fonts/materialdesignicons.css') }}" />

</head>

<body>
    <div class="container">
        <div class="relative left-8">
            <a href="/" id="back" class="mdi mdi-arrow-left mdi-36px btn-link"></a>
        </div>
        <div class="picture-container">
            <div class="picture">
                <img src="{{ URL::asset('assets/img/illustrations/girl-doing-yoga-light.png') }}" alt=""
                    style="width: 700px;">
            </div>
        </div>
        <div class="contact-form-container" style="padding-left: 30px;">
            <form class="contact-form">
                <span class="form-header">Contact us</span>
                <input type="email" class="email-input" placeholder="Email" />
                <textarea name="feedback" cols="30" rows="5" class="message" placeholder="Message..."></textarea>
                <button class="submit" id="submit" type="button">Submit</button>
            </form>
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
</body>

<script>
    $(document).ready(function() {
        $('#submit').on('click', function() {
            window.location.href = "/";
        });
    });
</script>

</html>
