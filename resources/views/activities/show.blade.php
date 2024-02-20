@extends('layout.layout')

@section('head')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-datepicker.css') }}">
@endsection

@section('content')
    <x-layout>
        <div class="flex justify-end mb-2 mt-3">
            <button class="my-4 btn btn-success reg-btn" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#regField" aria-controls="regField">Register!<i class="tf-icons mdi mdi-arrow-right ml-2"></i>
            </button>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>
                    {{ $activity->title }}
                </h4>
            </div>
            <form action="{{ route('calendar.update', ['id' => $id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="col mb-4 mt-2">
                        <div class="form-floating form-floating-outline">
                            <textarea type="text" style="height: auto;" type="longtext" id="showDescription" class="form-control"
                                name="description" placeholder="Enter Description" rows="8" @if (auth()->check() &&
                                        (auth()->user()->hasRole('Area Servant') ||
                                            auth()->user()->hasRole('Chapter Servant') ||
                                            auth()->user()->hasRole('Unit Servant') ||
                                            auth()->user()->hasRole('Household Servant') ||
                                            auth()->user()->hasRole('Member'))) readonly @endif>{{ $activity->description }}</textarea>
                            <label for="showDescription">Description</label>
                        </div>
                    </div>

                    <div class="col mb-4 mt-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="showLocation" class="form-control" name="location"
                                value="{{ $activity->location }}" placeholder="Enter Title"
                                @if (auth()->check() &&
                                        (auth()->user()->hasRole('Area Servant') ||
                                            auth()->user()->hasRole('Chapter Servant') ||
                                            auth()->user()->hasRole('Unit Servant') ||
                                            auth()->user()->hasRole('Household Servant') ||
                                            auth()->user()->hasRole('Member'))) readonly @endif />
                            <label for="showLocation">Location</label>
                        </div>
                    </div>

                    <div class="col mb-4 mt-2">
                        <div class="input-group input-group-merge mb-3">
                            <span class="input-group-text">₱</span>
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="showReg_fee" name="reg_fee"
                                    style="border-left: none;" placeholder="₱0000" value="{{ $activity->reg_fee }}"
                                    @if (auth()->check() &&
                                            (auth()->user()->hasRole('Area Servant') ||
                                                auth()->user()->hasRole('Chapter Servant') ||
                                                auth()->user()->hasRole('Unit Servant') ||
                                                auth()->user()->hasRole('Household Servant') ||
                                                auth()->user()->hasRole('Member'))) readonly @endif />
                                <label for="showReg_fee">Registration Fee</label>
                            </div>
                            @error('amount')
                                <span class="mt-2 ml-2 text-danger text-xs">{{ $message }}.</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="showStart_date" class="datepicker form-control" name="start_date"
                                    value="{{ $start_date }}"
                                    @if (auth()->check() &&
                                            (auth()->user()->hasRole('Area Servant') ||
                                                auth()->user()->hasRole('Chapter Servant') ||
                                                auth()->user()->hasRole('Unit Servant') ||
                                                auth()->user()->hasRole('Household Servant') ||
                                                auth()->user()->hasRole('Member'))) disabled {{ auth()->user()->role }} @endif>
                                <label for="showStart_date">Start Date</label>
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="showEnd_date" class="datepicker form-control" name="end_date"
                                    value="{{ $end_date }}" @if (auth()->check() &&
                                            (auth()->user()->hasRole('Area Servant') ||
                                                auth()->user()->hasRole('Chapter Servant') ||
                                                auth()->user()->hasRole('Unit Servant') ||
                                                auth()->user()->hasRole('Household Servant') ||
                                                auth()->user()->hasRole('Member'))) disabled @endif>
                                <label for="showEnd_date">End Date</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @if (auth()->check() && (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin')))
                        <div class="flex justify-end gap-2">
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            <a href="#" class="btn btn-danger remove-btn" data-id="{{ $id }}">Delete</a>
                            <button type="submit" id="saveBtn" class="btn btn-success">Save</button>
                        </div>

                        {{-- REGISTRATION --}}
                        {{-- @elseif ($activity->id != 13)
                        <div class="flex justify-end gap-2">
                            <button class="btn btn-success reg-btn" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#regField" aria-controls="regField">Register!</button>
                        </div> --}}
                    @endif
                </div>
            </form>

            <div class="offcanvas offcanvas-end" style="min-width: 550px;" tabindex="-1" id="regField"
                aria-labelledby="regFieldLabel">
                <div class="offcanvas-header mt-12">
                    <h5 id="regFieldLabel" class="offcanvas-title uppercase font-bold">
                        {{ $activity->title }} Registration</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mx-0 flex-grow-0">
                    <form action="{{ route('initiate.checkout') }}" method="POST">
                        @csrf
                        <x-form.input-group class="row-cols-1">
                            <input type="hidden" name="id" value="{{ $activity->id }}">
                            <x-form.input-field name="name" type="text" icon="account" placeholder="Juan A. Dela Cruz"
                                value="{{ $user->name }}" error="{{ $errors->first('name') }}">
                                Full Name
                            </x-form.input-field>
                            <x-form.input-field name="email" type="email" icon="email"
                                placeholder="juandelacruz@sample.com" value="{{ $user->email }}"
                                error="{{ $errors->first('email') }}">
                                Email Address
                            </x-form.input-field>
                            <x-form.input-field name="contact_number" type="tel" icon="phone"
                                placeholder="09123456789" value="{{ $user->contact_number }}"
                                error="{{ $errors->first('contact_number') }}">
                                Contact Number
                            </x-form.input-field>
                            <x-form.input-field name="reg_fee" type="text" icon="cash"
                                value="{{ $activity->reg_fee }}" error="{{ $errors->first('reg_fee') }}"
                                param="readonly">
                                Registration Fee
                            </x-form.input-field>
                        </x-form.input-group>

                        <x-form.btn-grp class="my-8" submit="Register Now!" reset="RESET">
                        </x-form.btn-grp>
                    </form>
                </div>
            </div>
    </x-layout>

    <style>
        div.swal2-container.swal2-top-right.swal2-backdrop-show {
            z-index: 9999 !important;
        }
    </style>

    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                animation: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
            });
        </script>
    @elseif (session('error'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                animation: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}',
            });
        </script>
    @endif
@endsection

@push('scripts')
    <script>
        var formattedStartDate = "{!! \Carbon\Carbon::parse($start_date)->format('Y-m-d H:iA') !!}";
        var formattedEndDate = "{!! \Carbon\Carbon::parse($end_date)->format('Y-m-d H:iA') !!}";

        $(document).ready(function() {
            var showStartDatePicker = $('#showStart_date').flatpickr({
                enableTime: true,
                altInput: true,
                altFormat: "F j, Y @ h:i K",
                dateFormat: "Y-m-d h:i K",
                defaultDate: formattedStartDate,
                allowInput: true,
                autoclose: true,
            });

            var test = showStartDatePicker.selectedDates[0];

            var showEndDatePicker = $('#showEnd_date').flatpickr({
                enableTime: true,
                altInput: true,
                altFormat: "F j, Y @ h:i K",
                dateFormat: "Y-m-d h:i K",
                defaultDate: formattedEndDate,
                minDate: test,
                allowInput: true,
                autoclose: true,
            });

            showStartDatePicker.config.onChange.push(function(selectedDates, dateStr, instance) {
                showEndDatePicker.set('minDate', selectedDates[0] || '');
            });


            $('.remove-btn').on('click', function(e) {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Remove activity from list",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('calendar.delete', '') }}/` + id,
                            method: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire('Removed!', response.message, 'success')
                                        .then(
                                            result => {
                                                if (result.isConfirmed) {
                                                    toastr.success(response.message,
                                                        'Success');
                                                    window.location.href = response
                                                        .redirect;
                                                }
                                            })
                                }
                            }
                        })
                    }
                })
            });
        });
    </script>
@endpush
