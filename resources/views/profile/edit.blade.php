@extends('layout.layout')

@section('head')
    <title>Edit Profile</title>
@endsection

@section('content')
    @if ($errors->any())
        <ul class="alert alert-danger mr-2 mt-4">
            @foreach ($errors->all() as $error)
                <li class="mb-2 text-sm">
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    @endif

    {{--  Modaaal --}}
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.updatePassword', ['user' => $user]) }}">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCenterTitle">Change Password</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Your form inputs -->
                        <div class="form-password-toggle mb-4">
                            <label class="form-label" for="oldPassword">Current Password<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge">
                                <input name="current_pass" type="password" class="form-control" id="oldPassword"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="basic-default-password32" />
                                <span class="input-group-text cursor-pointer eye1"><i class="fa-solid fa-eye"></i></span>
                            </div>
                        </div>

                        <div class="form-password-toggle mb-4">
                            <label class="form-label" for="password">New Password<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge">
                                <input name="new_pass" type="password" class="form-control" id="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="basic-default-password32" />
                                <span class="input-group-text cursor-pointer eye2"><i class="fa-solid fa-eye"></i></span>
                            </div>
                        </div>

                        <div class="form-password-toggle mb-4">
                            <label class="form-label" for="confirmPassword">Confirm New Password<i
                                    class="text-danger">*</i></label>
                            <div class="input-group input-group-merge">
                                <input name="confirm_pass" type="password" class="form-control" id="confirmPassword"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="basic-default-password32" />
                                <span class="input-group-text cursor-pointer eye3"><i class="fa-solid fa-eye"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- End Modal --}}

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="flex justify-end">
        </div>
        <div class="card mt-20">
            <h4 class="card-header">Profile Edit</h4>
            <!-- Account -->
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update', ['user' => $user]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        @if (isset($user->avatar))
                            <img src="{{ asset($user->avatar) }}" class="d-block w-px-120 h-px-120 rounded"
                                id="uploadedAvatar" />
                        @else
                            <img src="{{ URL::asset('assets/img/avatars/1.png') }}" alt="user-avatar"
                                class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />
                        @endif
                        <div class="button-wrapper">
                            <label for="upload" class=" btn btn-success me-2 mb-3" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                <input type="file" id="upload" name="avatar" class="account-file-input" hidden
                                    accept="image/png, image/jpeg" />
                            </label>
                            <div class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K</div>
                        </div>
                    </div>
                    <div class="menu-header small text-uppercase mb-2">
                        <span class="menu-header-text">Account Information</span>
                    </div>

                    <div class="row row-cols-4 row-cols-lg-5 mb-8 gy-4">
                        <div class="col">
                            <div>
                                <label for="name" class="form-label">Full Name<i
                                        class="text-danger text-md not-italic">*</i></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-account-edit-outline"></i></span>
                                    <input id="name" name="name" value="{{ $user->name }}" type="text"
                                        class="form-control" placeholder="John Doe" aria-label="Name" />
                                </div>
                                @error('name')
                                    <span class="text-xs text-danger lowercase">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div>
                                <label for="email" class="form-label">Email<i
                                        class="text-danger text-md not-italic">*</i></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                    <input id="email" name="email" value="{{ $user->email }}" type="text"
                                        class="form-control" placeholder="jdoe@gmail.com" aria-label="Name" />
                                </div>
                                @error('email')
                                    <p class="text-sm text-danger lowercase">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <label class="form-label" for="username">Username<i
                                    class="text-danger text-md not-italic">*</i></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">@</span>
                                <input id="username" name="username" value="{{ $user->username }}" type="text"
                                    class="form-control" placeholder="Username" aria-label="Username"
                                    aria-describedby="basic-addon41" />
                            </div>
                            @error('username')
                                <span class="text-danger text-xs lowercase">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col">
                            <label class="form-label" for="contact_number">Phone Number<i
                                    class="text-danger text-md not-italic">*</i></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">PHIL +63</span>
                                <input id="contact_number" name="contact_number" value="{{ $user->contact_number }}"
                                    type="text" class="form-control" placeholder="9123456789" aria-label="Username"
                                    aria-describedby="basic-addon41" />
                            </div>
                            @error('contact_number')
                                <span class="text-danger text-xs lowercase">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col">
                            <label class="form-label" for="section">Section<i class="text-danger">*</i></label>
                            <select id="section" name="section" class="form-select">
                                <option value="" disabled selected>Select Section</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}"
                                        {{ $user->section_id == $section->id ? 'selected' : '' }}>{{ $section->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('section')
                                <span class="text-xs text-danger lowercase">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="menu-header small text-uppercase mb-2">
                        <span class="menu-header-text">Other Information</span>
                    </div>

                    <div class="row row-cols-4 row-cols-lg-4 mb-12 gy-4">
                        <div class="col">
                            <label class="form-label" for="gender">Gender<i class="text-danger">*</i></label>
                            <select id="gender" name="gender" class="form-select">
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Brother" {{ $user->gender == 'Brother' ? 'selected' : '' }}>Brother
                                </option>
                                <option value="Sister" {{ $user->gender == 'Sister' ? 'selected' : '' }}>Sister</option>
                                <option value="Others" {{ $user->gender == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('gender')
                                <span class="text-xs text-danger lowercase">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col">
                            <label class="form-label" for="area">Area<i class="text-danger">*</i></label>
                            <select id="area" name="area" class="form-select">
                                <option value="" disabled selected class="capitalize">Select Area</option>
                                <option value="North" {{ $user->area == 'North' ? 'selected' : '' }}>North</option>
                                <option value="Central" {{ $user->area == 'Central' ? 'selected' : '' }}>Central</option>
                                <option value="East" {{ $user->area == 'East' ? 'selected' : '' }}>East</option>
                                <option value="South" {{ $user->area == 'South' ? 'selected' : '' }}>South</option>
                            </select>
                            @error('area')
                                <span class="text-xs text-danger lowercase">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col">
                            <label class="form-label" for="chapter">Chapter<i class="text-danger">*</i></label>
                            <select id="chapter" name="chapter" class="form-select">
                                <option value="{{ old('chapter') }}" disabled selected>Select Chapter</option>
                                <option value="Chapter 1" {{ $user->chapter == 'Chapter 1' ? 'selected' : '' }}>Chapter 1
                                </option>
                                <option value="Chapter 2" {{ $user->chapter == 'Chapter 2' ? 'selected' : '' }}>Chapter 2
                                </option>
                                <option value="Chapter 3" {{ $user->chapter == 'Chapter 3' ? 'selected' : '' }}>Chapter 3
                                </option>
                            </select>
                            @error('chapter')
                                <span class="text-xs text-danger lowercase">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col">
                            <label class="form-label" for="service">Service<i
                                    class="text-danger text-md not-italic">*</i></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="mdi mdi-fire"></i></span>
                                <input id="service" name="service" value="{{ $role->name }}" type="text"
                                    class="form-control" readonly />
                            </div>
                            @error('service')
                                <span class="text-danger text-xs lowercase">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row row-cols-4 row-cols-lg-2 mb-24 gy-4">
                        <div class=col>
                            <div class="form-password-toggle">
                                <label class="form-label" for="current_password">Current Password<i
                                        class="text-danger text-md not-italic">*</i></label>
                                <div class="input-group input-group-merge">
                                    <input name="current_password" value="{{ old('password') }}" type="password"
                                        class="form-control" id="current_password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer eye">
                                        <i class="fa-solid fa-eye"></i>
                                    </span>
                                </div>
                                @error('current_password')
                                    <span class="text-danger text-xs lowercase">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col grid content-center">
                            <div class=" w-full justify-items-stretch grid mt-4">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#modalCenter">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class=" flex justify-end">
                        <button type="submit" class="btn btn-success me-2">Save Changes</button>
                        <button type="reset" class="btn btn-outline-info">Reset</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>

    <style>
        .swal2-container.swal2-top-right.swal2-backdrop-show {
            z-index: 10000;
        }
    </style>

    @if (session('status') || session('success') || session('error'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const toastType = @json(session('status') ? 'success' : (session('success') ? 'success' : 'error'));

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                animation: true,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: toastType,
                title: "{{ session('status') ?? (session('success') ?? session('error')) }}",
            });

            @if (session('success'))
                console.log("{{ session('success') }}");
            @endif
        </script>
    @endif


@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $('#upload').change(function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $('#uploadedAvatar').attr('src', event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            const errorInputs = document.querySelectorAll('span.text-danger');

            if (errorInputs.length > 0) {
                const firstErrorInput = errorInputs[0].closest('.col').querySelector('.form-control');
                if (firstErrorInput) {
                    firstErrorInput.focus();
                }
            }

            const passwordField = document.getElementById("password");
            const oldPasswordField = document.getElementById("oldPassword");
            const confirmPasswordField = document.getElementById("confirmPassword");
            const togglePassword = document.querySelector(".eye i");
            const toggleOldPassword = document.querySelector(".eye1 i");
            const toggleNewPassword = document.querySelector(".eye2 i");
            const toggleConfirmPassword = document.querySelector(".eye3 i");

            const togglePasswordVisibility = (field, toggleElement) => {
                if (field.type === "password") {
                    field.type = "text";
                    toggleElement.classList.remove("fa-eye");
                    toggleElement.classList.add("fa-eye-slash");
                } else {
                    field.type = "password";
                    toggleElement.classList.remove("fa-eye-slash");
                    toggleElement.classList.add("fa-eye");
                }
            };

            $(document).ready(function() {
                $('.eye').click(function() {
                    togglePasswordVisibility(passwordField, togglePassword);
                });

                $('.eye1, .eye1 i').click(function() {
                    togglePasswordVisibility(oldPasswordField, toggleOldPassword);
                });

                $('.eye2, .eye2 i').click(function() {
                    togglePasswordVisibility(passwordField, toggleNewPassword);
                });

                $('.eye3, .eye3 i').click(function() {
                    togglePasswordVisibility(confirmPasswordField, toggleConfirmPassword);
                });
            });

        });
    </script>
@endpush
