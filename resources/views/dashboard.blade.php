@extends('layout.layout')

@section('head')
    <title>Dashboard</title>
    <link href="{{ URL::asset('assets/dashboard/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/dashboard/css/nucleo-svg.css') }}" rel="stylesheet" />

    <style>
        .gy-4 {
            --bs-gutter-y: 0;
        }

        .icon {
            fill: currentColor;
            stroke: none;
            display: inline-block;
            color: #111111;
        }

        .icon-shape {
            width: 48px;
            height: 48px;
            background-position: center;
            border-radius: 0.75rem;
        }

        .icon-shape i {
            color: #fff;
            opacity: 0.8;
            top: 14px;
            position: relative;
        }

        .bg-gradient-primary {
            background-image: linear-gradient(310deg, #0025f9 0%, #d87df5 100%);
        }

        .bg-gradient-danger {
            background-image: linear-gradient(310deg, #f5365c 0%, #f56036 100%);
        }

        .bg-gradient-success {
            background-image: linear-gradient(310deg, #2dce89 0%, #2dcecc 100%);
        }

        .bg-gradient-warning {
            background-image: linear-gradient(310deg, #fb6340 0%, #fbb140 100%);
        }

        .text-center {
            text-align: center !important;
        }

        .rounded-circle,
        .avatar.rounded-circle img {
            border-radius: 50% !important;
        }

        .font-weight-bolder {
            margin-top: 10px;
        }

        .bg-green-300 {
            --tw-bg-opacity: 1;
            background-color: rgb(134 239 172 / var(--tw-bg-opacity));
        }

        div.swal2-container.swal2-top-right.swal2-backdrop-show {
            z-index: 9999 !important;
        }

        .bg-green-300 {
            --tw-bg-opacity: 0.3;
            background-color: rgb(134 239 172 / var(--tw-bg-opacity));
        }

        div.row.row-cols-1.row-cols-md-2.row-cols-lg-4.g-4 {
            padding-right: 0 !important;
            padding-left: 0 !important;
            margin-left: 0 !important;
        }

        /* @media (min-width: 768px) {
            .col-md-6 {
                flex: 0 0 auto;
                width: 50%;
                margin-top: 1.50rem;
                margin-left: auto;
                margin-right: auto;
            }

            .row.row-cols-1.row-cols-md-2.row-cols-lg-4,
            .col-lg-8.mb-4 {
                margin: 0 auto !important;
            }
        } */
    </style>
@endsection


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row gy-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4">Dashboard</h4>
            </div>
            <div class="row mx-auto row-cols-1 row-cols-md-2 row-cols-lg-4">
                <div class="col mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">
                                            <span>Users</span>
                                        </p>
                                        <h5 class="font-weight-bolder">{{ $userCount }}</h5>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">0%</span>
                                            Lorem ipsum dolor sit
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary text-center rounded-circle">
                                        <i class="mdi mdi-account text-lg opacity-100 pb-2" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card h-100">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">
                                            Events
                                        </p>
                                        <h5 class="font-weight-bolder">{{ $events }}</h5>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+3%</span>
                                            Lorem Ipsum
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                        <i class="ni ni-world text-lg opacity-100" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-4" style="pointer-events: auto !important;">
                    <div class="card h-100" id="tithes">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">
                                            Tithes
                                        </p>
                                        <h5 class="font-weight-bolder">₱{{ $amount }}</h5>
                                        <p class="mb-0">
                                            <span class="text-danger text-sm font-weight-bolder">10%</span>
                                            Lorem ipsum dolor sit amet.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="ni ni-paper-diploma text-lg opacity-100" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card h-100">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">
                                            Announcements
                                        </p>
                                        <h5 class="font-weight-bolder">{{ $announcementCount }}</h5>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+5%</span>
                                            Lorem, ipsum dolor.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                        <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ministry Activities -->
            <div class="col-lg-8 col-md-8 mb-4">
                <div class="card h-100">
                    <div class="card-body row g-2">
                        <div class="col-12 pe-0 pe-md-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                                <h5 class="m-0 me-2">Ministry Activities {{ now()->subYear()->year }}</h5>
                                <a class="fw-medium" href="javascript:void(0);">View all</a>
                            </div>
                        </div>
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Profile Dashboard --}}
            <div class="col-lg-4 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="flex flex-wrap justify-center">
                            <div class="border" style="width:98%;"></div>
                        </div>
                        <strong>
                            <h5 class="mt-2 font-bold">Hi! {{ $user->name }}</h5>
                        </strong>
                        <div class="mt-8 flex justify-center">
                            <img src="http://127.0.0.1:8000/assets/img/avatars/1.png" alt="user-avatar"
                                class="d-block w-px-120 h-px-120 rounded-full">
                        </div>

                        <div class="mt-2 flex justify-center">
                            <p class="opacity-50">{{ $role->name }}</p>
                        </div>

                        <div class="mb-3 flex justify-center">
                            <div class="d-flex flex-col">
                                <div class="flex-grow-1">
                                    <span id="bioContent" style="text-align:center">{{ $bio }}</span>
                                    <button id="editBio" class="btn-link ml-0.5"><i id="pencil"
                                            class="fa fa-pencil fa-sm"></i></button>
                                    <textarea name="bio" class="form-control d-none w-100" style="resize: horizontal; margin-right:150px;"
                                        id="bio" name="bio" rows="4">{{ $bio }} </textarea>
                                </div>
                                <div class="d-none mt-2 flex justify-center gap-1" id="saveCancelButtons">
                                    <button class="btn btn-success" id="saveBio">Save</button>
                                    <button class="btn btn-secondary" id="cancelEditBio">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center ">
                            <div class="d-flex align-items-center">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="border: none;"><i
                                            class="mdi mdi-email-outline"></i></span>
                                    <input value="{{ $user->email }}" readonly type="text" class="form-control"
                                        id="email" style="border: none;" autocomplete="email" />
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-between align-items-center ">
                            <div class="d-flex align-items-center">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="border: none;">@</span>
                                    <input value="{{ $user->username }}" readonly type="text" class="form-control"
                                        id="username" style="border: none;" autocomplete="username" />
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-between align-items-center ">
                            <div class="d-flex align-items-center">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="border: none;"><i
                                            class="mdi mdi-phone-outline"></i></span>
                                    <input value="{{ $user->contact_number }}" readonly type="text"
                                        class="form-control" id="contact_number" style="border: none;" />
                                </div>
                            </div>
                        </div>

                        <div class="p-2 bg-green-100 rounded-md drop-shadow-md overflow-y-auto"
                            style="width: 100%; background-color: #e2cafcff;">
                            <strong class="text-slate-800">
                                Upcoming Events
                            </strong>
                            @foreach ($upcomingEvents as $upcomingEvent)
                                <div class="mt-1 ml-4 mr-2 py-1 flex justify-between">
                                    <li class="text-slate-600" style="max-width: max-content;">
                                        <span>{{ $eventTitle = $upcomingEvent->title }}</span>
                                    </li>

                                    <span>
                                        <button id="{{ $upcomingEvent->id }}" class="btn-link">
                                            <i class="fa fa-ellipsis text-slate-500"></i>
                                        </button>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Sales by Countries -->
    </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ URL::asset('assets/dashboard/js/plugins/chartjs.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $(document).on('click', '.btn-link', function(e) {
                var id = $(this).attr('id');

                $.ajax({
                    url: '{{ route('calendar.show', [':id']) }}'.replace(':id', id),
                    type: "GET",
                    success: function(data) {
                        console.log(data);
                        // Check if the response contains a redirect property
                        if (data.redirect) {
                            // Redirect to the specified URL
                            window.location.href = data.redirect;
                        } else {
                            // Handle other responses as needed
                            console.log('Unexpected response:', data);
                        }
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });

            const bioContent = document.getElementById('bioContent');
            const bioTextarea = document.getElementById('bio');
            const editBioButton = document.getElementById('editBio');
            const saveBioButton = document.getElementById('saveBio');
            const cancelEditBioButton = document.getElementById('cancelEditBio');
            const saveCancelButtons = document.getElementById('saveCancelButtons');

            editBioButton.addEventListener('click', function() {
                bioContent.classList.toggle('d-none');
                bioTextarea.classList.toggle('d-none');
                editBioButton.classList.toggle('d-none');
                saveCancelButtons.classList.toggle('d-none');
                if (!bioTextarea.classList.contains('d-none')) {
                    bioTextarea.focus();
                }
            });

            saveBioButton.addEventListener('click', function() {
                // Perform the save action, for example, submit the form
                // You may use AJAX to save the data to the server
                var id = {{ $user->id }};
                $.ajax({
                    url: `{{ route('dashboard.bio', ['id' => $user->id]) }}`,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        bio: bioTextarea.value,
                    },
                    success: function(response) {
                        // // Toggle back to read-only mode
                        bioContent.classList.toggle('d-none');
                        bioTextarea.classList.toggle('d-none');
                        saveCancelButtons.classList.toggle('d-none');
                        editBioButton.classList.toggle('d-none');
                        bioContent.innerText = response.bio;

                        // //Fire Toast
                        var Toast = Swal.mixin({
                            toast: true,
                            icon: 'success',
                            title: 'General Title',
                            animation: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });

                        Toast.fire({
                            icon: 'success',
                            title: 'Bio Update Successfully',
                        });
                    },
                    error: function(error) {
                        // Handle the error, e.g., show an error message
                        console.error('Error updating bio:', error);
                    }
                });
            });

            cancelEditBioButton.addEventListener('click', function() {
                // Toggle back to read-only mode without saving changes
                bioContent.classList.toggle('d-none');
                bioTextarea.classList.toggle('d-none');
                editBioButton.classList.toggle('d-none');
                saveCancelButtons.classList.toggle('d-none');
            });
        });

        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, "rgba(0,166,61,0.4)");
        gradientStroke1.addColorStop(0, "rgba(134,240,173,0.0)");
        gradientStroke1.addColorStop(0, "rgba(134,240,173,0)");

        new Chart(ctx1, {
            type: "line",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                datasets: [{
                    label: "Active Members",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#1b8262ff",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500, 420, 480, 500],
                    maxBarThickness: 6,
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                interaction: {
                    intersect: false,
                    mode: "index",
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: "#ccc",
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: "normal",
                                lineHeight: 2,
                            },
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5],
                        },
                        ticks: {
                            display: true,
                            color: "#ccc",
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: "normal",
                                lineHeight: 2,
                            },
                        },
                    },
                },
            },
        });
    </script>
@endpush
