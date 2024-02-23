@extends('layout.layout')

@section('head')
    <title>Tithes</title>

    <style>
        div.swal2-container.swal2-top-right.swal2-backdrop-show {
            z-index: 9999 !important;
        }
    </style>
@endsection

@section('content')
    @if ($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
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
                icon: 'error',
                title: 'Transaction Failed',
            });
        </script>
    @endif

    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Register Card -->
                <style>
                    @media (max-width: 768px) {
                        .card.p-2.max-w-xl.m-auto {
                            margin-left: 30px !important;
                            margin-right: 30px !important;
                        }
                    }
                </style>
                <div class="card p-2 max-w-xl m-auto">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href="" class="app-brand-link gap-2 mr-2">
                            <span class="app-brand-logo demo">
                                <span style="color: #1b661b">
                                    <img src="/favicon.ico" alt="">
                                </span>
                            </span>
                            <span class="app-brand-text demo text-heading fw-semibold">MFC Portal</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <div class="card-body mt-2">
                        <h4 class="mb-4">Tithe Registration Form</h4>
                        <form id="formAuthentication" class="mb-3" action="{{ route('tithes.store') }}" method="POST">
                            @csrf
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
                                <input type="tel" class="form-control" id="contact_number" name="contact_number"
                                    value="{{ $user->contact_number ?: old('contact_number') }}"
                                    placeholder=" 09123456789" />
                                <label for="contact_number" required>Contact Number</label>
                                @error('contact_number')
                                    <span class="mt-2 ml-2 text-danger text-xs">{{ $message }}.</span>
                                @enderror
                            </div>

                            {{-- <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="₱0000"
                                value="{{old('amount')}}" />
                            <label for="amount" required>Amount</label>
                            @error('amount')
                            <span class="mt-2 ml-2 text-danger text-xs">{{ $message }}.</span>
                            @enderror
                        </div> --}}

                            <div class=" mt-8 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms"
                                        checked required />
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to
                                        <a href="javascript:void(0);" class="hover:underline" style="color: #1b661b">privacy
                                            policy & terms</a>
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-success d-grid w-100">Give!</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .toast-container {
            z-index: 9999;
        }
    </style>

    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast',
                    container: 'toast-container',
                },
                showConfirmButton: false,
                timer: 3000,
                showCloseButton: true,
            });

            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}",
            });

            console.log("{{ session('success') }}");
        </script>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Listen for changes in the selected option
            $('#mop').change(function() {
                // Get the selected value
                var selectedMop = $(this).val();

                // Toggle the visibility of the additional input field based on the selected option
                if (selectedMop === 'others') {
                    $('#otherOption').show();
                } else {
                    $('#otherOption').hide();
                }
            });

            const errorInputs = document.querySelectorAll('.danger');
            if (errorInputs.length > 0) {
                const firstErrorInput = errorInputs[0].closest('.card-body').querySelector('.form-control');
                if (firstErrorInput) {
                    firstErrorInput.focus();
                }
            }
        });
    </script>
@endpush
