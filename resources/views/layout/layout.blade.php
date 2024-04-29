<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact scroll-smooth" dir="ltr"
    data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

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
    <title>MFC Portal</title>

    <style>
        button#offcanvasbtn,
        div.offcanvas.offcanvas-end {
            width: max-content;
        }

        @media (min-width: 768px) {
            div.offcanvas.offcanvas-end {
                width: max-content;
            }
        }

        .menu-item {
            padding-right: 5px;
        }

        .menu-vertical .menu-item .menu-link,
        .menu-vertical .menu-header,
        .menu-vertical .menu-block {
            margin-inline: 0.6rem;
        }

        .menu-vertical .menu-item .menu-link,
        .menu-vertical .menu-header,
        .menu-vertical .menu-block {
            margin-inline: 0.6px !important;
        }

        aside.bg-menu-theme {
            background-color: #ffff !important;
        }

        .colored-toast {
            margin-top: 25px;
        }

        .colored-toast.swal2-icon-success {
            background-color: #56ca00 !important;
        }

        .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
        }

        .colored-toast.swal2-icon-warning {
            background-color: #f8bb86 !important;
        }

        .colored-toast.swal2-icon-info {
            background-color: #3fc3ee !important;
        }

        .colored-toast.swal2-icon-question {
            background-color: #87adbd !important;
        }

        .colored-toast .swal2-title {
            color: white;
        }

        .colored-toast .swal2-close {
            color: white;
        }

        .colored-toast .swal2-html-container {
            color: white;
        }

        .btn .btn-primary:hover {
            background: #9055fd;
        }

        .btn-outline-primary:hover {
            background-color: #945cfd !important;
            color: white !important;
        }

        .btn-outline-info:hover {
            background-color: #16b1ff !important;
            color: white !important;
        }

        .btn-outline-danger:hover {
            background-color: #ff4c51 !important;
            color: white !important;
        }

        .btn.btn-success {
            background: #1b661b;
            border-color: #1b661b;
        }

        .form-control:focus,
        .form-select:focus,
        .input-group-text:focus {
            border-color: #58b612 !important;
        }

        .input-group:not(.input-group-floating):focus-within .form-control,
        .input-group:not(.input-group-floating):focus-within .input-group-text {
            border-color: #58b612 !important;
        }

        .dropdown-item:not(.disabled).active,
        .dropdown-item:not(.disabled):active {
            background-color: #D5F5E3;
            color: #5D6D7E !important;
        }

        .dropdown-item.pb-2.mb-1 {
            pointer-events: none !important;
        }

        .form-floating-outline .form-control:focus,
        .form-floating-outline .form-select:focus {
            border-color: #1b661b !important;
        }

        .form-floating-outline :not(select):focus+label,
        .form-floating-outline :not(select):focus+span {
            color: #1b661b !important;
        }

        li.menu-header.small.text-uppercase {
            margin-left: 20px !important;
        }

        ul.pagination {
            padding-top: 20px;
        }

        div.col-md-5.col-sm-12 {
            padding-top: 15px;
        }

        body {
            overflow-x: hidden;
            overflow-y: auto;
        }

        .input-group-text.is-invalid {
            border-color: var(--bs-form-invalid-border-color) !important;
        }

        .select-is-invalid {
            border-color: var(--bs-form-invalid-border-color) !important;
        }

        div.z-10.bg-white.block {
            margin-right: 200px !important;
            border-top-right-radius: 0px;
            overflow-x: hidden;
            word-wrap: break-word;
            text-overflow: ellipsis;
        }

        #style-15::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #F5F5F5;
            border-radius: 10px;
        }

        #style-15::-webkit-scrollbar {
            width: 5px;
            background-color: #F5F5F5;
        }

        #style-15::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #FFF;
            background-image: -webkit-gradient(linear,
                    40% 0%,
                    75% 84%,
                    from(#8b8e94ff),
                    to(rgb(171, 175, 182)),
                    color-stop(.6, rgb(181, 186, 197)))
        }

        h4.fw-bold.py-3.mb-4 {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .btn-info {
            color: #fff;
            background-color: #16b1ff !important;
            border-color: #16b1ff;
        }

        .fa-stack {
            font-size: 140%;
        }

        .fa-stack[data-count]:after {
            position: absolute;
            left: 50%;
            top: 10%;
            content: attr(data-count);
            font-size: 38%;
            padding: .6em;
            border-radius: 999px;
            line-height: .75em;
            color: white;
            background: rgba(255, 0, 0, .85);
            text-align: center;
            min-width: 2em;
            font-weight: bold;
        }

        div.swal2-container.swal2-top-right.swal2-backdrop-show {
            z-index: 9999 !important;
        }

        h4#nb {
            font-size: 2rem;
        }

        .offcanvas-body {
            overflow-x: hidden;
        }

        @media(max-width:780px) {
            a.nav-item.nav-link.px-0.me-xl-4 {
                margin-top: 16px;
            }

            ul.dropdown-menu.dropdown-menu-end.mt-3.py-2.show {
                position: absolute;
                top: 51px;
                left: 64px;
                min-width: auto;
                width: 70%;
            }

            h4#nb {
                font-size: 1.25rem;
            }

            a.btn,
            a.btn~i {
                font-size: 0.75rem;
            }

            div#DataTables_Table_0_length {
                display: flex;
                justify-content: flex-start;
                margin-bottom: 20px;
            }

            div#DataTables_Table_0_filter {
                display: flex;
                justify-content: flex-end;
            }

            ul.pagination {
                margin-bottom: 20px !important;
            }

            ul.menu-inner.overflow-auto {
                overflow-x: hidden !important;
            }
        }

        ul.menu-inner {
            scroll-behavior: smooth;
        }
        .btn-primary{
            background-color: #9055fd !important;
        }

        .dataTables_scrollHead {
            margin-top: 10px !important;
            background-color: #9056fcff !important;
        }

        th.sorting,
        th.sorting_disabled {
            width: 100px;
            color: #fafafa !important;
        }

        .card-profile-image img {
            position: absolute;
            left: 50%;
            min-height: 200px;
            max-height: 200px;
            min-width: 200px;
            max-width: 200px;
            overflow: hidden;
            transition: all .15s ease;
            transform: translate(-50%, -30%);
            border-radius: .375rem;
        }

        .form-check-input:checked {
            background-color: #9055fd !important;
            border-color: #9055fd !important;
        }
    </style>

    <!-- jQuery Include -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('head')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo mt-8 flex-col mb-2" style="pointer-events: none; height: 150px;">
                    <a href="javascript:void(0)" class="flex flex-col align-items-center">
                        <span class=" flex justify-center">
                            <span style="color: #1b661b">
                                <img src="/favicon-96x96.png" alt="">
                            </span>
                        </span>
                        <span class="app-brand-text demo menu-text"
                            style="
                                font-family: 'Roboto', sans-serif;
                                font-weight: 900;
                                font-size: 1.5rem;">
                            MFC
                        </span>
                        <span class="app-brand-text demo menu-text"
                            style="font-family: 'Roboto', sans-serif;">Portal</span>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
                    </a>
                </div>

                <ul class="menu-inner py-1 overflow-x-hidden">
                    <div class="menu-inner-shadow"></div>
                    <!-- Dashboard -->
                    @can('view-role')
                        <li class="menu-item {{ preg_match('/dashboard/', Request::path()) ? 'active' : null }}">
                            <a href="/dashboard" class="menu-link">
                                <i class="menu-icon tf-icons mdi mdi-view-dashboard"></i>
                                <div data-i18n="Dashboards">Dashboard</div>
                                <div class="badge bg-danger rounded-pill" style="margin-left: 4rem;">5</div>
                            </a>
                        </li>
                    @endcan

                    <!--Notice Board -->

                    <li class="menu-item {{ preg_match('/announcements/', Request::path()) ? 'active' : null }}">
                        <a href="/announcements" class="menu-link">
                            <i class="menu-icon tf-icon mdi mdi-clipboard-outline"></i>
                            <div data-i18n="Icons">Announcements</div>
                        </a>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Management</span>
                    </li>

                    <!-- Management-->
                    <li
                        class="menu-item {{ str_contains(Request::path(), 'kids') ||
                        str_contains(Request::path(), 'youth') ||
                        str_contains(Request::path(), 'singles') ||
                        str_contains(Request::path(), 'servants') ||
                        str_contains(Request::path(), 'handmaids') ||
                        str_contains(Request::path(), 'couples')
                            ? 'active open'
                            : '' }}">

                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons mdi mdi-folder-account-outline"></i>
                            <div data-i18n="Directory">Directory</div>
                        </a>
                        <ul class="menu-sub">
                            <x-menu-link routeName="{{ route('kids.index') }}" title="Kids"
                                class="{{ str_contains(Request::path(), 'kids') ? 'active' : '' }}" />
                            <x-menu-link routeName="{{ route('youth.index') }}" title="Youth"
                                class="{{ str_contains(Request::path(), 'youth') ? 'active' : '' }}" />
                            <x-menu-link routeName="{{ route('singles.index') }}" title="Singles"
                                class="{{ str_contains(Request::path(), 'singles') ? 'active' : '' }}" />
                            <x-menu-link routeName="{{ route('servants.index') }}" title="Servants"
                                class="{{ str_contains(Request::path(), 'servants') ? 'active' : '' }}" />
                            <x-menu-link routeName="{{ route('handmaids.index') }}" title="Handmaids"
                                class="{{ str_contains(Request::path(), 'handmaids') ? 'active' : '' }}" />
                            <x-menu-link routeName="{{ route('couples.index') }}" title="Couples"
                                class="{{ str_contains(Request::path(), 'couples') ? 'active' : '' }}" />
                        </ul>
                    </li>

                    <!-- Activities -->
                    <li
                        class="menu-item {{ str_contains(Request::path(), 'activity/list') || str_contains(Request::path(), 'calendar')
                            ? 'active open'
                            : null }}">

                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <span class="menu-icon tf-icons mdi mdi-calendar-heart-outline"></span>
                            <div>Events</div>
                        </a>
                        <ul class="menu-sub">
                            <li
                                class="menu-item {{ preg_match('/activity\/list/', Request::path()) ? 'active' : '' }}">
                                <a href="{{ route('activity.list') }}" class="menu-link">
                                    <div class="ml-4">List</div>
                                </a>
                            </li>
                            <li class="menu-item {{ preg_match('/calendar/', Request::path()) ? 'active' : null }}">
                                <a href="{{ route('calendar.list') }}" class="menu-link">
                                    <div class="ml-4">Calendar</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Tithes -->
                    <li
                        class="menu-item {{ preg_match('/tithes\/create/', Request::path()) ? 'active open' : null }}
                                            {{ preg_match('/tithes\/list/', Request::path()) ? 'active open' : null }}">

                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons mdi mdi-cash-multiple"></i>
                            <div>Tithes</div>
                        </a>

                        <ul class="menu-sub">
                            <li
                                class="menu-item {{ preg_match('/tithes\/list/', Request::path()) ? 'active' : null }}">
                                @can('view-tithes')
                                    <a href="{{ route('tithes.list') }}" class=" menu-link">
                                        <div data-i18n="Icons" class="ml-2">List</div>
                                    </a>
                                @endcan

                            </li>
                            <li
                                class="menu-item {{ preg_match('/tithes\/create/', Request::path()) ? 'active' : null }}">
                                <a href="{{ route('tithes.create') }}" class=" menu-link">
                                    <div data-i18n="Icons" class="ml-2">Registration</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Notifications -->
                    @php
                        $unreadNotificationsCount = \App\Models\User::find(Auth::id())->unreadNotifications->count();
                    @endphp

                    <!-- Attendance -->

                    @can('view-member')
                        <li class="menu-item {{ preg_match('/attendance/', Request::path()) ? 'active' : null }}">
                            <a href="/attendance" class="menu-link">
                                <i class="menu-icon tf-icon mdi mdi-account-check-outline"></i>
                                <div data-i18n="Icons">Attendance</div>
                            </a>
                        </li>
                    @endcan

                    @can('view-roles')
                        <!-- Roles/Permission -->
                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">Roles & Permission</span>
                        </li>

                        <!-- Roles -->
                        <li
                            class="menu-item {{ str_contains(Request::path(), 'roles') ||
                            str_contains(Request::path(), 'admin') ||
                            str_contains(Request::path(), 'area') ||
                            str_contains(Request::path(), 'chapter') ||
                            str_contains(Request::path(), 'unit') ||
                            str_contains(Request::path(), 'household')
                                ? 'open'
                                : null }}">

                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icon mdi mdi-account-file-outline"></i>
                                <div data-i18n="Roles">Roles</div>
                            </a>
                            <ul class="menu-sub">
                                <x-menu-link routeName="{{ route('roles.index') }}" title="Super Admin"
                                    class="{{ str_contains(Request::path(), 'roles') ? 'active' : '' }}" />
                                <x-menu-link routeName="{{ route('admin.index') }}" title="Admin"
                                    class="{{ str_contains(Request::path(), 'admin') ? 'active' : '' }}" />
                                <x-menu-link routeName="{{ route('area.index') }}" title="Area Servants"
                                    class="{{ str_contains(Request::path(), 'area') ? 'active' : '' }}" />
                                <x-menu-link routeName="{{ route('chapter.index') }}" title="Chapter Servants"
                                    class="{{ str_contains(Request::path(), 'chapter') ? 'active' : '' }}" />
                                <x-menu-link routeName="{{ route('unit.index') }}" title="Unit Servants"
                                    class="{{ str_contains(Request::path(), 'unit') ? 'active' : '' }}" />
                                <x-menu-link routeName="{{ route('household.index') }}" title="Household Servants"
                                    class="{{ str_contains(Request::path(), 'household') ? 'active' : '' }}" />
                            </ul>
                        </li>
                    @endcan

                    @can('view-permissions')
                        <!-- Permission -->
                        <li class="menu-item {{ preg_match('/permissions/', Request::path()) ? 'active' : null }}">
                            <a href="/permissions" class="menu-link" style="margin-bottom: 130px;">
                                <i class="menu-icon tf-icon mdi mdi-key-outline"></i>
                                <div data-i18n="Icons">Permission</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="my-2 layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="mdi mdi-menu mdi-24px"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex py-2 px-4 mt-6" id="navbar-collapse">

                        <!-- Search -->
                        <div class="navbar-nav align-items-center w-100 hidden">
                            <div class="nav-item d-flex align-items-center input-group-merge w-100">
                                <i class="mdi mdi-magnify mdi-24px lh-0 mr-2"></i>
                                <input type="text" class="form-control border-0 shadow-none"
                                    style="background: #f5f6faff;" id="search" name="search"
                                    placeholder="Search..." aria-label="Search..." />
                            </div>
                        </div>
                        <!-- /Search -->


                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            {{-- notification --}}
                            <li class="w-50">
                                <style>
                                    @media (max-width: 440px) {
                                        #noti {
                                            font-size: 1.2rem;
                                        }

                                        #mark-all {
                                            font-size: 0.7rem;
                                            margin-top: 0.25rem;
                                        }
                                    }
                                </style>

                                <button id="dropdownUsersButton" data-dropdown-toggle="dropdownUsers"
                                    data-dropdown-toggle="arrow" data-dropdown-placement="bottom"
                                    data-dropdown-offset-distance="-5" class="hover:text-green-700">
                                    <div class="flex align-items-start">
                                        <span id="bell" class="fa-stack"
                                            data-count="{{ $unreadNotificationsCount }}">
                                            <i class="fa-regular fa-bell"></i>
                                        </span>
                                    </div>
                                </button>
                                <style>
                                    .arrow-up {
                                        width: 0;
                                        height: 0;
                                        border-left: 12px solid transparent;
                                        border-right: 12px solid transparent;
                                        border-bottom: 12px solid black;
                                        position: absolute;
                                        right: 86px;
                                        top: 55px;
                                    }

                                    @media (min-width: 600px) {
                                        div#dropdownUsers {
                                            border-radius: 0.7rem;
                                            width: 40% !important;
                                            position: absolute;
                                            inset: 7px auto auto -109px !important;
                                            margin: 0px;
                                            transform: translate(791px, 60px);
                                        }

                                        p.mt-2.text-truncate {
                                            font-size: 0.75rem !important;
                                        }

                                        h6.mb-1.text-truncate strong {
                                            font-size: 1rem;
                                        }
                                    }

                                    @media (max-width: 599px) {
                                        div#dropdownUsers {
                                            width: 70% !important;
                                            border-radius: 0.7rem;
                                            position: absolute;
                                            inset: 0px auto auto -110px !important;
                                            margin: 0px;
                                            transform: translate(791px, 60px);
                                        }

                                        div#dropdownUsers ul {
                                            max-height: 275px !important;
                                        }

                                        div.flex a.text-xl.uppercase {
                                            font-size: 1rem !important;
                                        }

                                        i.fa-3x {
                                            font-size: 1.5rem;
                                        }

                                        .pb-4.overflow-hidden.w-px-250.flex.flex-col.align-items-center.text-center {
                                            padding-bottom: 0px !important;
                                        }

                                        p.mt-2.text-truncate.text-slate-400 {
                                            font-size: 0.8rem;
                                        }

                                        li.list-group-item.list-group-item-action.dropdown-notifications-item.waves-effect {
                                            padding-top: 0px !important;
                                        }

                                        span.text-sm {
                                            font-size: 0.675rem;
                                        }

                                        a div.flex {
                                            flex-direction: column;
                                            padding-bottom: 10px;
                                        }
                                    }
                                </style>

                                <div class="arrow-up hidden"></div>
                                <script></script>
                                <div id="dropdownUsers" class="z-10 hidden bg-white shadow w-40"
                                    style="border: 1px solid #8080802e;">
                                    <div class="flex justify-center items-center p-3 font-medium border-t border-gray-50"
                                        style="border-bottom: 1px groove #8080802e;">
                                        <a href="#"
                                            class="text-xl uppercase font-bold text-slate-500 pointer-events-none">
                                            Notifications
                                        </a>
                                    </div>
                                    <ul class="pt-2 overflow-y-auto text-white dark:text-gray-200"
                                        aria-labelledby="dropdownUsersButton" id="style-15"
                                        style="padding-left: 0; max-height:450px;"
                                        @if ($unreadNotificationsCount > 0) style="max-height: 600px;" @endif>

                                        @forelse ($unreadNotifications as $notification)
                                            <div class="hover:bg-gray-100"
                                                style="border-bottom: 1px groove #8080802e;">
                                                <li
                                                    class="px-3 pt-3 notify list-group-item list-group-item-action dropdown-notifications-item">
                                                    <div class="divide-dashed divide-y-2">
                                                        <div class="d-flex justify-center align-items-center gap-2">
                                                            <a href="{{ $notification->data['url'] }}"
                                                                data-id="{{ $notification->id }}"
                                                                class="d-flex admin_notification flex-column flex-grow-1 overflow-hidden w-px-250">
                                                                <div class="flex justify-between">
                                                                    <div style="max-width: 80%;">
                                                                        <h6 class="mb-1 text-truncate">
                                                                            @if ($notification->type === 'App\Notifications\TitheNotification')
                                                                                <strong><span>₱ </span></strong>
                                                                            @endif
                                                                            <strong
                                                                                class="text-gray-500">{{ $notification->data['name'] }}</strong>
                                                                        </h6>
                                                                        <p class="mt-2 text-truncate text-slate-400">
                                                                            {{ $notification->data['message'] }}
                                                                        </p>
                                                                    </div>

                                                                    <small class="text-body"
                                                                        style="font-size: 0.7rem; line-height: 1rem;">{{ $notification->created_at->diffForHumans() }}</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </div>
                                        @empty
                                            <li class="dropdown-notifications-list scrollable-container">
                                                <ul class="list-group list-group-flush bg-white">
                                                    <li class="list-group-item list-group-item-action dropdown-notifications-item waves-effect"
                                                        style="pointer-events: none;">
                                                        <div class="d-flex justify-center align-items-center gap-2">
                                                            <div
                                                                class="pb-4 overflow-hidden w-px-250 flex flex-col align-items-center text-center">
                                                                <i
                                                                    class="fa-solid fa-bell-slash fa-3x text-slate-300 my-3"></i>
                                                                <span class="text-sm font-bold my-1">No new
                                                                    notifications
                                                                    yet.</span>
                                                                <span class="text-sm font-normal">When you get new
                                                                    notifications, they'll show up here</span>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <div class="p-3 text-sm font-medium text-blue-600 border-t border-gray-200 rounded-b-lg bg-gray-50"
                                                        style="border-bottom: 9px solid #9055fdad;">
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-primary d-flex justify-content-center waves-effect waves-divght"
                                                            id="refresh-btn">
                                                            Refresh
                                                        </a>
                                                    </div>
                                                </ul>
                                            </li>
                                        @endforelse
                                    </ul>
                                    @if ($unreadNotificationsCount)
                                        <div class="flex justify-center items-center p-3 text-sm font-medium border-t border-gray-200 rounded-b-lg dark:border-gray-600  dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-blue-500"
                                            style="border-bottom: 9px solid #9359ffff; border-top: 1px groove #8080802e;">
                                            <a href="javascript:void(0);" id="mark-all" class="hover:text-green-100 text-white">
                                                Mark all as read
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </li>

                            {{-- User --}}

                            <li class="nav-item navbar-dropdown dropdown-user dropdown ml-2">
                                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ URL::asset('assets/img/avatars/1.png') }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end mt-3 py-2"
                                    style="border-radius: 10px 0px 10px 0px;">
                                    <li>
                                        <a class="dropdown-item pb-2 mb-1">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2 pe-1">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ URL::asset('assets/img/avatars/1.png') }}" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1" style="max-width: 150px; overflow: hidden;">
                                                    <h6 class="mb-0 py-1 text-sm-right"
                                                        style="word-wrap: break-word; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $user->name }}
                                                    </h6>
                                                    <small
                                                        class="text-muted">{{ $user->roles->first()->name }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ preg_match('/profile/', Request::path()) ? 'active' : null }}"
                                            href="{{ route('profile.edit', ['id' => $user->id]) }}">
                                            <i class="mdi mdi-account-outline me-1 mdi-24px text-success"></i>
                                            <span class="align-middle ml-2">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}">
                                            <i class="mdi mdi-power me-1 mdi-24px text-danger"></i>
                                            <span class="align-middle ml-2">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme mt-8">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-center py-3 flex-md-row flex-column">
                                <div class="text-body mb-2 mb-md-0 flex">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>, made with <span class="text-danger"><i
                                            class="tf-icons mdi mdi-heart"></i></span> by
                                    <a href="https://themeselection.com" target="_blank"
                                        class="footer-link fw-medium">GodesQ Team</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="{{ URL::asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ URL::asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/js/butterup.js') }}"></script>

    <!-- endbuild -->
    <script src="https://kit.fontawesome.com/b49bde7a10.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@floating-ui/core@1.6.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/@floating-ui/dom@1.6.1"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

    <!-- Vendors JS -->
    <script src="{{ URL::asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ URL::asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ URL::asset('assets/js/dashboards-analytics.js') }}"></script>

    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <!-- Calendar -->
    @stack('scripts')

    <script>
        $(document).ready(function() {

            var dropdown = document.getElementById('dropdownSearch');

            function addColor() {
                // Add a class to the dropdown element
                dropdown.classList.toggle('text-green-600');
            }

            $(document).on('click', '#back', function(e) {
                window.history.back();
            });

            var Toast = Swal.mixin({
                toast: true,
                animation: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            function sendMarkRequest(id = null) {
                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                return $.ajax("{{ route('mark.notification') }}", {
                    method: 'POST',
                    data: {
                        _token: csrfToken,
                        id
                    }
                });
            }

            $(function() {
                $('#mark-all').click(function() {
                    let request = sendMarkRequest();

                    request.done(() => {
                        $('li.notify').remove(); // Remove all notification list items
                        window.location.reload();
                    });
                });

                $('.user_notification').click(function() {
                    let request = sendMarkRequest($(this).data('id'));

                    request.done(() => {
                        $('a.user_notification')
                            .remove(); // Remove all notification list items

                    });
                });

                $('.admin_notification').click(function() {
                    let request = sendMarkRequest($(this).data('id'));

                    request.done(() => {
                        $('a.admin_notification')
                            .remove(); // Remove all notification list items
                    });
                });
            });

            $(function() {
                $('#refresh-btn').click(function() {
                    $.ajax({
                        url: window.location.href, // The current page URL
                        type: 'GET', // HTTP method
                        success: function(response) {
                            var updatedContent = $(response).find('#container').html();
                            $('#container').html(updatedContent);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
