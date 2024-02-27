@extends('layout.layout')

@section('head')
<title>Area Servant Registration</title>

<style>
    div.swal2-container.swal2-top-right.swal2-backdrop-show {
        z-index: 9999 !important;
    }
</style>
@endsection

@section('content')
@if($errors->any())
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
        title: 'Registration Failed',
    });

</script>
@endif

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="flex justify-end"> <a href="{{route('area.list')}}" class="my-4 btn btn-dark">Go Back<i
                class="tf-icons mdi mdi-arrow-u-left-top ml-2"></i></a> </div>
    <div class="card mb-4">
        <h4 class="card-header">Area Servant Registration</h4> <!-- Account -->

        <div class="card-body pt-2 mt-1">
            <form id="" method="POST" action="{{route('area.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4"> <img
                            src="../assets/img/avatars/4.png" alt="user-avatar"
                            class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />
                        <div class="button-wrapper">
                            <label for="upload" class=" btn btn-success me-2 mb-3" tabindex="0">
                                <span class="d-none d-sm-block">
                                    Upload new photo
                                </span>
                                <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                <input type="file" id="upload" name="avatar" class="account-file-input" hidden
                                    accept="image/png, image/jpeg" />
                            </label>

                            <div class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K</div>

                        </div>
                    </div>
                </div>
                <div class="menu-header small text-uppercase mb-2">
                    <span class="menu-header-text">Account Information</span>
                </div>

                <div class="row row-cols-4 row-cols-lg-4 mb-8 gy-4">
                    <div class="col">
                        <label for="name" class="form-label">Full Name<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="name"><i class="mdi mdi-account-outline"></i></span>
                            <input value="{{old('name')}}" id="name" name="name" type="text" class="form-control"
                                placeholder="John Doe" aria-label="Name" aria-describedby="basic-addon41" />
                        </div>
                        @error('name')
                        <span class="text-xs text-danger lowercase">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label class="form-label" for="email">Email<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                            <input value="{{old('email')}}" id="email" name="email" type="email" class="form-control"
                                placeholder="johndoe@example.com" aria-label="Email" aria-describedby="basic-addon41" />
                        </div>
                        @error('email')
                        <span class="text-xs text-danger lowercase">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label class="form-label" for="username">Username<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon41">@</span>
                            <input value="{{old('username')}}" name="username" id="username" type="text"
                                class="form-control" placeholder="Username" aria-label="Username"
                                aria-describedby="basic-addon41" />
                        </div>
                        @error('username')
                        <span class="text-xs text-danger lowercase">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label class="form-label" for="contact_number">Phone Number<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon41">PHIL +63</span>
                            <input value="{{old('contact_number')}}" name="contact_number" id="contact_number"
                                type="tel" class="form-control" placeholder="9123456789" aria-label="Username"
                                aria-describedby="basic-addon41" />
                        </div>
                        @error('contact_number')
                        <span class="text-xs text-danger lowercase">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="menu-header small text-uppercase mb-2">
                    <span class="menu-header-text">Other Information</span>
                </div>

                <div class="row row-cols-4 row-cols-lg-3 mb-8 gy-4">
                    <div class="col">
                        <label for="gender" class="form-label">Gender<i class="text-danger">*</i></label>
                        <select id="gender" name="gender" class="select2 form-select form-control">
                            <option value="">Select Gender</option>
                            <option value="brother" {{ old('gender')==='brother' ? 'selected' : '' }}>Brother</option>
                            <option value="sister" {{ old('gender')==='sister' ? 'selected' : '' }}>Sister</option>
                        </select>
                        @error('gender')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="area" class="form-label">Area<i class="text-danger">*</i></label>
                        <select id="area" name="area" class="select2 form-select form-control">
                            <option value="">Select Area</option>
                            <option value="north" {{ old('area')==='
                                                ' ? 'selected' : '' }}>North</option>
                            <option value="central" {{ old('area')==='central' ? 'selected' : '' }}>Central</option>
                            <option value="south" {{ old('area')==='south' ? 'selected' : '' }}>South</option>
                            <option value="east" {{ old('area')==='east' ? 'selected' : '' }}>East</option>
                        </select>
                        @error('area')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="chapter" class="form-label">Chapter<i class="text-danger">*</i></label>
                        <select id="chapter" name="chapter" class="select2 form-select form-control">
                            <option value="">Select Chapter</option>
                            <option value="Chapter 1" {{ old('chapter')==='Chapter 1' ? 'selected' : '' }}>Chapter 1
                            </option>
                            <option value="Chapter 2" {{ old('chapter')==='Chapter 2' ? 'selected' : '' }}>Chapter 2
                            </option>
                            <option value="Chapter 3" {{ old('chapter')==='Chapter 3' ? 'selected' : '' }}>Chapter 3
                            </option>
                        </select>
                        @error('chapter')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="menu-header small text-uppercase mb-2">
                    <span class="menu-header-text">Security</span>
                </div>

                <div class="row row-cols-4 row-cols-lg-2 mb-8 gy-4">
                    <div class="form-password-toggle">
                        <label class="form-label" for="password">Password<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <input type="password" name="password" id="password" class="form-control .alert-danger"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="basic-default-password32" />
                            <span class="input-group-text cursor-pointer toggle-password"
                                onclick="togglePassword('password')"><i class="mdi mdi-eye-off-outline"></i></span>
                        </div>
                        @error('password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-password-toggle">
                        <label class="form-label" for="basic-default-password32"> Confirm Password<i
                                class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <input type="password" name="confirm_password" id="confirm_password"
                                class="form-control .alert-danger"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="basic-default-password32" />
                            <span class="input-group-text cursor-pointer toggle-password"
                                onclick="togglePassword('confirm_password')"><i
                                    class="mdi mdi-eye-off-outline"></i></span>
                        </div>
                        @error('confirm_password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="my-4 flex justify-end">
                    <button type="submit" class="btn btn-success me-2">Register</button>
                    <button type="reset" class="btn btn-outline-info">Reset</button>
                </div>
            </form>
        </div>
        <!-- /Account -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const errorInputs = document.querySelectorAll('span.text-danger');
        if (errorInputs.length > 0) {
            const firstErrorInput = errorInputs[0].closest('.col');
            if (firstErrorInput) {
                firstErrorInput.focus();
            }
        }

        $('#upload').change(function (e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    $('#uploadedAvatar').attr('src', event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
