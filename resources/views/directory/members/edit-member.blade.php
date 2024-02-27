@extends('layout.layout')

@section('head')
<title>Edit Profile</title>
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
        title: 'Update Failed',
    });

</script>
@endif

<!-- Modal -->
<div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('member.update.password', ['member' => $member]) }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Change Password</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Your form inputs -->
                    <div class="form-password-toggle mb-4">
                        <label class="form-label" for="password">Current Password<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <input name="current_pass" type="password" class="form-control" id="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="basic-default-password32" />
                            <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-outline"></i></span>
                        </div>
                    </div>

                    <div class="form-password-toggle mb-4">
                        <label class="form-label" for="password">New Password<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <input name="new_pass" type="password" class="form-control" id="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="basic-default-password32" />
                            <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-outline"></i></span>
                        </div>
                    </div>

                    <div class="form-password-toggle mb-4">
                        <label class="form-label" for="password">Confirm New Password<i
                                class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <input name="confirm_pass" type="password" class="form-control" id="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="basic-default-password32" />
                            <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-outline"></i></span>
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

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="flex justify-end"> <a href="{{route('member.list')}}" class="my-4 btn
  btn-dark">Go Back<i class="tf-icons mdi mdi-arrow-u-left-top ml-2"></i></a> </div>

    <div class="card mb-8">
        <div class="card-body m-8">
            <h4>Member Profile Edit</h4>
            <form method="POST" id="updateForm" action="{{route('member.update', ['member' => $member] )}}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="d-flex align-items-start align-items-sm-center gap-4 mb-8">
                    @if (isset($member->avatar))
                    <img src="{{ asset($member->avatar)}}" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded"
                        id="uploadedAvatar" />
                    @else
                    <img src="{{ URL:: asset('/assets/img/avatars/2.png') }}" alt="user-avatar"
                        class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />
                    @endif
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-success me-2 mb-3" tabindex="0">
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

                <div class="row row-cols-4 row-cols-lg-3 mb-8 gy-4">
                    <div class="col">
                        <div>
                            <label for="name" class="form-label">Full Name</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="mdi mdi-account-edit-outline"></i></span>
                                <input id="name" name="name" value="{{ $member->name }}" type="text"
                                    class="form-control" placeholder="John Doe" aria-label="Name" />
                            </div>
                            @error('name')
                            <p class="text-xs text-danger lowercase">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <div>
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                <input id="email" name="email" value="{{ $member->email }}" type="text"
                                    class="form-control" placeholder="jdoe@gmail.com" aria-label="Name" />
                            </div>
                            @error('email')
                            <p class="text-xs text-danger lowercase">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <label class="form-label" for="username">Username</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">@</span>
                            <input id="username" name="username" value="{{ $member->username }}" type="text"
                                class="form-control" placeholder="Username" aria-label="Username"
                                aria-describedby="basic-addon41" />
                        </div>
                    </div>

                    <div class="col">
                        <label class="form-label" for="contact_number">Phone Number</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">PHIL +63</span>
                            <input id="contact_number" name="contact_number" value="{{ $member->contact_number }}"
                                type="text" class="form-control" placeholder="9123456789" aria-label="Username"
                                aria-describedby="basic-addon41" />
                        </div>
                        @error('contact_number')
                        <span class="ml-2 tex-xs text-danger">{{$message}}</span>
                        @enderror
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

                <div class="menu-header small text-uppercase mb-2">
                    <span class="menu-header-text">Other Information</span>
                </div>

                <div class="row row-cols-4 row-cols-lg-3 mb-24 gy-4">
                    <div class="col">
                        <label for="gender">Gender<i class="text-danger">*</i></label>
                        <select id="gender" name="gender" class="form-select">
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Brother" {{ $member->gender == 'Brother' ? 'selected' : '' }}>Brother
                            </option>
                            <option value="Sister" {{ $member->gender == 'Sister' ? 'selected' : '' }}>Sister</option>
                            <option value="Others" {{ $member->gender == 'Others' ? 'selected' : '' }}>Others</option>
                        </select>
                        @error('gender')
                        <span class="text-xs text-danger lowercase">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="area">Area<i class="text-danger">*</i></label>
                        <select id="area" name="area" class="form-select">
                            <option value="" disabled selected class="capitalize">Select Area</option>
                            <option value="North" {{ $member->area == 'North' ? 'selected' : '' }}>North</option>
                            <option value="Central" {{ $member->area == 'Central' ? 'selected' : '' }}>Central</option>
                            <option value="East" {{ $member->area == 'East' ? 'selected' : '' }}>East</option>
                            <option value="South" {{ $member->area == 'South' ? 'selected' : '' }}>South</option>
                        </select>
                        @error('area')
                        <span class="text-xs text-danger lowercase">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="chapter">Chapter<i class="text-danger">*</i></label>
                        <select id="chapter" name="chapter" class="form-select">
                            <option value="" disabled selected>Select Chapter</option>
                            <option value="Chapter 1" {{ $member->chapter == 'Chapter 1' ? 'selected' : '' }}>Chapter 1
                            </option>
                            <option value="Chapter 2" {{ $member->chapter == 'Chapter 2' ? 'selected' : '' }}>Chapter 2
                            </option>
                            <option value="Chapter 3" {{ $member->chapter == 'Chapter 3' ? 'selected' : '' }}>Chapter 3
                            </option>
                        </select>
                        @error('chapter')
                        <span class="text-xs text-danger lowercase">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-24 ml-2">
                    <div class="form-check form-switch mb-2">
                        <input id="status" value="{{$member->status}}" class="form-check-input" name="status"
                            type="checkbox" />
                        <label class="form-check-label" for="status">Active</label>
                    </div>


                    <div class="form-check form-switch mb-2">
                        <input id="emailToggle" class="form-check-input" name="emailToggle" type="checkbox" />
                        <label class="form-check-label" for="emailToggle">Email Verified</label>
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

@if (session('success'))
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
        ogressBar: true,
    });

    Toast.fire({
        animation: true,
        title: "{{ session('success') }}",
    });
</script>

@elseif (session('error'))
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
        // didOpen: (toast) => {
        //     toast.addEventListener('mouseenter', Swal.stopTimer)
        //     toast.addEventListener('mouseleave', Swal.resumeTimer)
        // }
    });

    Toast.fire({
        icon: 'error',
        title: "{{ session('error') }}",
    });

    console.log("{{ session('error') }}");
</script>
@endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const status = "{{ $member->status }}";
        const checkbox = document.getElementById('status');

        // Check the status and set the checkbox state accordingly
        if (status === 'Active') {
            checkbox.checked = true;
        } else {
            checkbox.checked = false;
        }

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
