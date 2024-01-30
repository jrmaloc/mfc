@props([
    'passwordRoute' => '',
    'parameters' => '',
    'back' => '',
    'action' => '',
    'model' => '',
    'message' => '',
    'status' => '',
])

<!-- Modal -->
<div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- 'area.update.password', ['areaservant' => $areaservant] -->
            <form method="POST" action="{{ route($passwordRoute, $parameters) }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Change Password</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-password-toggle mb-4">
                        <label class="form-label" for="password">Current Password<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <input name="current_pass" type="password" class="form-control" id="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                            <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-outline"></i></span>
                        </div>
                    </div>

                    <div class="form-password-toggle mb-4">
                        <label class="form-label" for="new_pass">New Password<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <input name="new_pass" type="password" class="form-control" id="new_pass"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                            <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-outline"></i></span>
                        </div>
                    </div>

                    <div class="form-password-toggle mb-4">
                        <label class="form-label" for="con_pass">Confirm New Password<i
                                class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <input name="confirm_pass" type="password" class="form-control" id="con_pass"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
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

<!-- Main Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="flex justify-end"> <a href="{{ route($back) }}" class="my-4 btn
  btn-dark">Back to List<i
                class="tf-icons mdi mdi-arrow-u-left-top ml-2"></i></a> </div>
    <div class="card mb-4">
        <h4 class="card-header mt-2">Account Editing</h4> <!-- Account -->

        <div class="card-body">
            <form id="" method="POST" action="{{ route($action, $parameters) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        @if (isset($model->avatar))
                            <img src="{{ asset($model->avatar) }}" class="d-block w-px-120 h-px-120 rounded"
                                id="uploadedAvatar" />
                        @else
                            <img src="{{ URL::asset('/assets/img/avatars/2.png') }}"
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
                </div>

                <div class="menu-header small text-uppercase mb-2">
                    <span class="menu-header-text">Basic Information</span>
                </div>

                <div class="row row-cols-4 row-cols-lg-3 mb-8 gy-4">
                    <div class="col">
                        <div>
                            <label for="name" class="form-label">Full Name<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" id="basic-addon41"><i
                                        class="mdi mdi-account-edit-outline"></i></span>
                                <input value="{{ $model->name }}" name="name" id="name" type="text"
                                    class="form-control" placeholder="John Doe" autocomplete="name" />
                            </div>
                            @error('name')
                                <span class="text-xs text-danger lowercase">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <div>
                            <label for="email" class="form-label">Email<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" id="basic-addon41"><i
                                        class="mdi mdi-email-outline"></i></span>
                                <input name="email" id="email" value="{{ $model->email }}" type="text"
                                    class="form-control" placeholder="John Doe" aria-label="Name"
                                    autocomplete="email" />
                            </div>
                            @error('email')
                                <span class="text-xs text-danger lowercase">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <label class="form-label" for="username">Username<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon41">@</span>
                            <input name="username" id="username" value="{{ $model->username }}" type="text"
                                class="form-control" placeholder="Username" aria-label="Username"
                                aria-describedby="basic-addon41" autocomplete="username" />
                        </div>
                        @error('username')
                            <span class="text-xs text-danger lowercase">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label class="form-label" for="contact_number">Phone Number<i
                                class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon41">PHIL +63</span>
                            <input name="contact_number" id="contact_number" value="{{ $model->contact_number }}"
                                type="tel" class="form-control" placeholder="9123456789" aria-label="Username"
                                aria-describedby="basic-addon41" />
                        </div>
                        @error('contact_number')
                            <span class="text-xs text-danger lowercase">{{ $message }}</span>
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
                            <option value="Brother" {{ $model->gender == 'Brother' ? 'selected' : '' }}>Brother
                            </option>
                            <option value="Sister" {{ $model->gender == 'Sister' ? 'selected' : '' }}>Sister
                            </option>
                        </select>
                        @error('gender')
                            <span class="text-xs text-danger lowercase">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="area">Area<i class="text-danger">*</i></label>
                        <select id="area" name="area" class="form-select">
                            <option value="" disabled selected class="capitalize">Select Area</option>
                            <option value="North" {{ $model->area == 'North' ? 'selected' : '' }}>North</option>
                            <option value="Central" {{ $model->area == 'Central' ? 'selected' : '' }}>Central
                            </option>
                            <option value="East" {{ $model->area == 'East' ? 'selected' : '' }}>East</option>
                            <option value="South" {{ $model->area == 'South' ? 'selected' : '' }}>South</option>
                        </select>
                        @error('area')
                            <span class="text-xs text-danger lowercase">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="chapter">Chapter<i class="text-danger">*</i></label>
                        <select id="chapter" name="chapter" class="form-select">
                            <option value="" disabled selected>Select Chapter</option>
                            <option value="Chapter 1" {{ $model->chapter == 'Chapter 1' ? 'selected' : '' }}>
                                Chapter 1
                            </option>
                            <option value="Chapter 2" {{ $model->chapter == 'Chapter 2' ? 'selected' : '' }}>
                                Chapter 2
                            </option>
                            <option value="Chapter 3" {{ $model->chapter == 'Chapter 3' ? 'selected' : '' }}>
                                Chapter 3
                            </option>
                        </select>
                        @error('chapter')
                            <span class="text-xs text-danger lowercase">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-form.switch-field class="ml-4" style="margin-top: 5rem;" name="status"
                        value="{{ $status }}">
                        is Active
                    </x-form.switch-field>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($errors->any())
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            animation: true,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    </script>
    @foreach ($errors->all() as $error)
        <script>
            Toast.fire({
                icon: 'error',
                title: '{{ $error }}',
            });
        </script>
    @endforeach
@endif


@if (session('success'))
    {
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
    }
@endif
