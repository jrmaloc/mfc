@props([
    'back' => '',
    'action' => '',
])

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="flex justify-end"> <a href="{{ route($back) }}" class="my-4 btn btn-dark">Back to List<i
                class="tf-icons mdi mdi-arrow-u-left-top ml-2"></i></a> </div>
    <div class="card mb-4">
        <h4 class="card-header font-semibold mt-4 ml-2">{{ $slot }}</h4> <!-- Account -->

        <div class="card-body pt-2 mt-1">
            <form id="" method="POST" action="{{ route($action) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4"> <img
                            src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar"
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
                    <span class="menu-header-text">Primary Information</span>
                </div>

                <div class="row row-cols-4 row-cols-lg-4 mb-8 gy-4">
                    <div class="col">
                        <label for="name" class="form-label">Full Name<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
                            <input value="{{ old('name') }}" id="name" name="name" type="text"
                                class="form-control" placeholder="John Doe" autofocus autocomplete="name" />
                        </div>
                        @error('name')
                            <span class="text-xs text-danger lowercase">Please input a proper Name</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label class="form-label" for="email">Email<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                            <input value="{{ old('email') }}" id="email" name="email" type="email"
                                class="form-control" placeholder="johndoe@example.com" aria-label="Email"
                                aria-describedby="basic-addon41" autocomplete="email" />
                        </div>
                        @error('email')
                            <span class="text-xs text-danger lowercase">Please input a proper Email</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label class="form-label" for="username">Username<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon41">@</span>
                            <input value="{{ old('username') }}" name="username" id="username" type="text"
                                class="form-control" placeholder="Username" aria-label="Username"
                                aria-describedby="basic-addon41" autocomplete="username" />
                        </div>
                        @error('username')
                            <span class="text-xs text-danger lowercase">please provide a username</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label class="form-label" for="contact_number">Phone Number<i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon41">PHIL +63</span>
                            <input value="{{ old('contact_number') }}" name="contact_number" id="contact_number"
                                type="tel" class="form-control" placeholder="9123456789" aria-label="Username"
                                aria-describedby="basic-addon41" />
                        </div>
                        @error('contact_number')
                            <span class="text-xs text-danger lowercase">how can we contact you?</span>
                        @enderror
                    </div>
                </div>

                <div class="menu-header small text-uppercase mb-2">
                    <span class="menu-header-text">Other Information</span>
                </div>

                <div class="row row-cols-3 row-cols-lg-3 mb-8 gy-4">
                    <div class="col">
                        <label for="gender" class="form-label">Gender<i class="text-danger">*</i></label>
                        <select id="gender" name="gender" class="select2 form-select form-control">
                            <option value="">Select Gender</option>
                            <option value="brother" {{ old('gender') === 'brother' ? 'selected' : '' }}>Brother
                            </option>
                            <option value="sister" {{ old('gender') === 'sister' ? 'selected' : '' }}>Sister</option>
                        </select>
                        @error('gender')
                            <span class="text-danger text-xs lowercase">please choose one</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="area" class="form-label">Area<i class="text-danger">*</i></label>
                        <select id="area" name="area" class="select2 form-select form-control">
                            <option value="">Select Area</option>
                            <option value="north" {{ old('area') === 'north' ? 'selected' : '' }}>North</option>
                            <option value="central" {{ old('area') === 'central' ? 'selected' : '' }}>Central</option>
                            <option value="south" {{ old('area') === 'south' ? 'selected' : '' }}>South</option>
                            <option value="east" {{ old('area') === 'east' ? 'selected' : '' }}>East</option>
                        </select>
                        @error('area')
                            <span class="text-danger text-xs lowercase">please choose one</span>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="chapter" class="form-label">Chapter<i class="text-danger">*</i></label>
                        <select id="chapter" name="chapter" class="select2 form-select form-control">
                            <option value="">Select Chapter</option>
                            <option value="Chapter 1" {{ old('chapter') === 'Chapter 1' ? 'selected' : '' }}>Chapter 1
                            </option>
                            <option value="Chapter 2" {{ old('chapter') === 'Chapter 2' ? 'selected' : '' }}>Chapter 2
                            </option>
                            <option value="Chapter 3" {{ old('chapter') === 'Chapter 3' ? 'selected' : '' }}>Chapter 3
                            </option>
                        </select>
                        @error('chapter')
                            <span class="text-danger text-xs lowercase">please choose one</span>
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
                            <span class="text-danger text-xs lowercase">please provide a password. minimum of 8
                                characters</span>
                        @enderror
                    </div>

                    <div class="form-password-toggle">
                        <label class="form-label" for="confirm_password"> Confirm Password<i
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
                            <span class="text-danger text-xs lowercase">please confirm your password</span>
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
