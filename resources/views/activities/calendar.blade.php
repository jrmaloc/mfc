@extends('layout.layout')

@section('head')
    <title>Calendar</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta charset="utf-8" />

    <style>
        div.swal2-container.swal2-top-right.swal2-backdrop-show {
            z-index: 9999 !important;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background-color: #94ECB9 !important;
            color: whitesmoke;
        }

        .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #44c179;
        }

        .fc-daygrid-day-number {
            display: flex;
            justify-content: center;
            margin: 10px;
        }

        .fc .fc-day-today:hover .fc-daygrid-day-number {
            background-color: #44c179 !important;
        }

        .fc .fc-daygrid-day:hover {
            background-color: #EAFAF1;
            cursor: pointer;
        }

        .fc .fc-daygrid-day:hover .fc-daygrid-day-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #44c179;
            color: whitesmoke;
            cursor: pointer;
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active {
            background-color: #44c179 !important;
        }

        .fc .fc-button-primary {
            background-color: #1b661b !important;
        }

        #showActivityModal {
            z-index: 9999999 !important;
        }

        h2#fc-dom-1 {
            font-size: 3em !important;
        }

        .fc .fc-button-primary:focus {
            box-shadow: none !important;
        }
    </style>
@endsection

@section('content')
    <!-- Registration Modal -->
    {{-- <div class="modal fade" id="registrationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content px-4 py-2">
                <div class="modal-header">
                    <h2 class="flex justify-center">
                        Register Here!
                    </h2>
                </div>
                <div class="modal-body">
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter your name" value="{{ $user->name ?: old('name') }}" autofocus
                            autocomplete="name" />
                        <label for="name" required>Name</label>
                        @error('name')
                            <span class="mt-2 ml-2 text-danger text-xs">{{ $message }}.</span>
                        @enderror
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="email" name="email"
                            value="{{ $user->email ?: old('email') }}" placeholder=" Enter your email"
                            autocomplete="email" />
                        <label for="email" required>Email</label>
                        @error('email')
                            <span class="mt-2 ml-2 text-danger text-xs">{{ $message }}.</span>
                        @enderror
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <input type="phone" class="form-control" id="number" name="number"
                            value="{{ $user->contact_number ?: old('contact_number') }}"
                            placeholder=" Enter your contact number" />
                        <label for="number">Contact Number</label>
                        @error('number')
                            <span class="mt-2 ml-2 text-danger text-xs">{{ $message }}.</span>
                        @enderror
                    </div>

                    <div class="row row-cols-4 row-cols-lg-2 gy-4 mb-3">
                        <div class="col">
                            <label for="area">Area<i class="text-danger">*</i></label>
                            <select id="area" name="area" class="form-select">
                                <option value="" disabled selected class="capitalize">Select Area</option>
                                <option value="North" {{ $user->area == 'North' ? 'selected' : '' }}>North</option>
                                <option value="Central" {{ $user->area == 'Central' ? 'selected' : '' }}>Central
                                </option>
                                <option value="East" {{ $user->area == 'East' ? 'selected' : '' }}>East</option>
                                <option value="South" {{ $user->area == 'South' ? 'selected' : '' }}>South</option>
                            </select>
                            @error('area')
                                <span class="text-xs text-danger lowercase">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col">
                            <label for="chapter">Chapter<i class="text-danger">*</i></label>
                            <select id="chapter" name="chapter" class="form-select">
                                <option value="" disabled selected>Select Chapter</option>
                                <option value="Chapter 1" {{ $user->chapter == 'Chapter 1' ? 'selected' : '' }}>Chapter
                                    1
                                </option>
                                <option value="Chapter 2" {{ $user->chapter == 'Chapter 2' ? 'selected' : '' }}>Chapter
                                    2
                                </option>
                                <option value="Chapter 3" {{ $user->chapter == 'Chapter 3' ? 'selected' : '' }}>Chapter
                                    3
                                </option>
                            </select>
                            @error('chapter')
                                <span class="text-xs text-danger lowercase">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="amount" name="amount" placeholder="₱0000"
                            value="{{ old('amount') }}" readonly />
                        <label for="amount">Registration Fee</label>
                        @error('amount')
                            <span class="mt-2 ml-2 text-danger text-xs">{{ $message }}.</span>
                        @enderror
                    </div>

                    <div class="mt-12 flex justify-end gap-2">
                        <a href="javascript:void(0)" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</a>
                        <a href="javascript:void(0)" id="submitBtn" class="btn btn-success">Register!</a>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div> --}}

    <!-- Create Modal -->

    @if (auth()->check() &&
            (auth()->user()->hasRole('Super Admin') ||
                auth()->user()->hasRole('Admin')))
        <div class="modal fade" id="activityModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content px-4 py-2">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCenterTitle">Create Event</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-4 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="title" class="form-control" name="title"
                                        placeholder="Enter Title" />
                                    <label for="title">Title</label>
                                    <span id="titleError" class="text-danger"></span>
                                </div>
                            </div>
                        </div>


                        <div class="col mb-4 mt-2">
                            <div class="form-floating form-floating-outline">
                                <textarea style="height: auto;" type="longtext" id="description" class="form-control" name="title"
                                    placeholder="Enter Description" rows="8"></textarea>
                                <label for="description">Description</label>
                                <span id="descriptionError" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="col mb-4 mt-2">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="location" class="form-control" name="location"
                                    placeholder="Enter Location" />
                                <label for="location">Location</label>
                                <span id="locationError" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="col mb-4 mt-2">
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="number" class="form-control" id="reg_fee" name="reg_fee"
                                    placeholder="₱0000" />
                                <label for="reg_fee">Registration Fee</label>
                                <span id="reg_feeError" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="datetime-local" id="start_date" class="form-control" />
                                    <label for="start_date">Start Date</label>
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="datetime-local" id="end_date" class="form-control" />
                                    <label for="end_date">End Date</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closeBtn" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" id="createBtn" class="btn btn-success">Add Event</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div id='wrap' class=" w-70 mx-16 ">
        <!-- Set data attribute on an HTML element -->


        <div class="flex justify-end mb-2 mt-3"> <a href="{{ route('activity.list') }}" class="my-4 btn btn-dark">See
                List of Events
                <i class="tf-icons mdi mdi-arrow-u-left-top ml-2"></i></a>
        </div>
        <div class="content mx-15">
            <div class="card px-16 py-10 mb-20">
                <div id='calendar' class=""></div>
            </div>
        </div>


        <div style='clear:both'></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endsection

@push('scripts')
    <script>
        var Toast = Swal.mixin({
            toast: true,
            title: 'General Title',
            animation: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });


        document.addEventListener('DOMContentLoaded', function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });
            var events = @json($events);
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,today,next', // will normally be on the left. if RTL, will be on the right
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,dayGridDay,listWeek,multiMonthYear',
                },

                editable: true,
                selectable: true,
                events: events,
                dayMaxEventRows: true,
                eventColor: "#00D057",

                eventDrop: function(data) {
                    var event = data.event;
                    var eventId = event.id;
                    let newStartDate = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                    let newEndDate = moment(event.end).format('YYYY-MM-DD HH:mm:ss');

                    alert(event.title + " is moved to a new date");

                    if (!confirm("is this okay?")) {
                        info.revert();
                    }

                    $.ajax({
                        method: 'PUT',
                        url: `calendar/drag/${eventId}`,
                        data: {
                            start_date: newStartDate,
                            end_date: newEndDate
                        },
                        success: function() {
                            Toast.fire({
                                icon: "success",
                                title: "Event updated Successfully.",
                            });
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                },

                select: function(start_date, end_date) {
                    $('#activityModal').modal('toggle');

                    $('#activityModal').on('hidden.bs.modal', function() {
                        $(this).find(
                            'input[type="text"], input[type="number"], input[type="datetime-local"], textarea'
                        ).val('');
                    });


                    var startDate = moment(start_date.start).format('YYYY-MM-DD HH:mm:ss');
                    $('#start_date').val(startDate);
                    var endDate = moment(start_date.end).subtract(1, 'day').add(1, 'hour').format(
                        'YYYY-MM-DD HH:mm:ss');
                    $('#end_date').val(endDate);

                    $('#createBtn').off('click').on('click', function() {
                        var title = $('#title').val();
                        var description = $('#description').val();
                        var location = $('#location').val();
                        var start_date = $('#start_date').val();
                        var end_date = $('#end_date').val();
                        var reg_fee = $('#reg_fee').val();

                        $.ajax({
                            url: "{{ route('calendar.store') }}",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                title,
                                description,
                                location,
                                start_date,
                                end_date,
                                reg_fee
                            },

                            success: function(response) {
                                $('#activityModal').modal('hide');
                                calendar.addEvent('event', {
                                    'title': response.title,
                                    'description': response.description,
                                    'location': response.location,
                                    'reg_fee': response.reg_fee,
                                    'start': response.start_date,
                                    'end': response.end_date,
                                });

                                var Toast = Swal.mixin({
                                    toast: true,
                                    title: 'General Title',
                                    animation: true,
                                    position: 'top-right',
                                    showConfirmButton: false,
                                    timer: 1000,
                                    timerProgressBar: true,
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Event Created Successfully. Reloading...",
                                });

                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            },

                            error: function(error) {
                                if (error.responseJSON.errors) {
                                    console.log(error.responseJSON.errors);
                                } else {
                                    console.log("Unexpected error response:", error
                                        .responseJSON);
                                }
                            },
                        });
                    });
                },

                eventClick: function(data) {
                    window.location.href = "{{ route('calendar.show', '') }}/" + data.event.id;
                },

            });
            calendar.render();
        });
    </script>
@endpush