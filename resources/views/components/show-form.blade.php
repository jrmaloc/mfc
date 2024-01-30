@props([
    'back' => '',
    'edit' => '',
    'parameters' => '',
    'model' => '',
])
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="flex justify-end">
        <a href="{{ route($back) }}" class="my-4 btn btn-dark">
            Back To List
            <i class="tf-icons mdi mdi-arrow-u-left-top ml-2"></i>
        </a>
    </div>
    <div class="card">
        <h4 class="card-header capitalize">Profile Details</h4> <!-- Account -->
        <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-10 ml-6">
                @if ($model && isset($model->avatar))
                    <img src="{{ asset($model->avatar) }}" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded"
                        id="uploadedAvatar" />
                @else
                    <img src="{{ URL::asset('/assets/img/avatars/2.png') }}" alt="default-avatar"
                        class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />
                @endif
                <div class="flex justify-end">
                    <a href="{{ route($edit, $parameters) }}" class="py-auto btn btn-primary btn-sm flex justify-end">
                        Edit Profile
                        <i class="tf-icons mdi mdi-pencil"></i>
                    </a>
                </div>

            </div>
        </div>

        <div class="card-body pt-2 mt-1">
            <div class="menu-header small text-uppercase mb-2">
                <span class="menu-header-text">Account Information</span>
            </div>

            <div class="row row-cols-4 row-cols-lg-2 mb-8 gy-4">
                <div class="col">
                    <div>
                        <label for="name" class="form-label">Full Name</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="border: none;"><i
                                    class="mdi mdi-account-outline"></i></span>
                            <input value="{{ $model->name }}" readonly type="text" class="form-control"
                                id="name" style="border: none;" autocomplete="name" />
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="border: none;"><i
                                    class="mdi mdi-email-outline"></i></span>
                            <input value="{{ $model->email }}" readonly type="text" class="form-control"
                                id="email" style="border: none;" autocomplete="email" />
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div>
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="border: none;">@</span>
                            <input value="{{ $model->username }}" readonly type="text" class="form-control"
                                id="username" style="border: none;" autocomplete="username" />
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div>
                        <label for="contact_number" class="form-label">Phone Number</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="border: none;"><i
                                    class="mdi mdi-phone-outline"></i></span>
                            <input value="{{ $model->contact_number }}" readonly type="text" class="form-control"
                                id="contact_number" style="border: none;" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="menu-header small text-uppercase mb-2">
                <span class="menu-header-text">Other Information</span>
            </div>

            <div class="row row-cols-4 row-cols-lg-3 mb-24 gy-4">
                <div class="col">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" class="form-select" disabled
                        style="border: none; background: #fff;">
                        @if ($model->gender)
                            <option value="{{ $model->gender }}" selected>{{ $model->gender }}</option>
                        @else
                            <option value="" selected disabled>Select Gender</option>
                        @endif
                        <option value="brother" {{ $model->gender === 'brother' ? 'disabled' : '' }}>Brother
                        </option>
                        <option value="sister" {{ $model->gender === 'sister' ? 'disabled' : '' }}>Sister</option>
                        <option value="others" {{ $model->gender === 'others' ? 'disabled' : '' }}>Others</option>
                    </select>
                </div>


                <div class="col">
                    <label for="area">Area</label>
                    <select id="area" name="area" class="form-select" disabled
                        style="border: none; background: #fff;">
                        @if ($model->area)
                            <option value="{{ $model->area }}" selected>{{ $model->area }}</option>
                        @else
                            <option value="" selected disabled>Select Area</option>
                        @endif
                        <option value="north" {{ $model->area === 'north' ? 'disabled' : '' }}>North</option>
                        <option value="central" {{ $model->area === 'central' ? 'disabled' : '' }}>Central</option>
                        <option value="south" {{ $model->area === 'south' ? 'disabled' : '' }}>South</option>
                    </select>
                </div>

                <div class="col">
                    <label for="chapter">Chapter</label>
                    <select id="chapter" name="chapter" class="form-select" disabled
                        style="border: none; background: #fff;">
                        @if ($model->chapter)
                            <option value="{{ $model->chapter }}" selected>{{ $model->chapter }}</option>
                        @else
                            <option value="" selected disabled>Select Chapter</option>
                        @endif
                        <option value="1" {{ $model->chapter === '1' ? 'disabled' : '' }}>Chapter 1</option>
                        <option value="2" {{ $model->chapter === '2' ? 'disabled' : '' }}>Chapter 2</option>
                        <option value="3" {{ $model->chapter === '3' ? 'disabled' : '' }}>Chapter 3</option>
                    </select>
                </div>
            </div>

            <div class="mb-24 ml-2">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="status" disabled
                        {{ $model->status === 'Active' ? 'checked' : '' }} />
                    <label class="form-check-label" for="status">Active</label>
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="email_verify"
                        @if ($model->email_verified_at) checked @endif disabled />
                    <label class="form-check-label" for="email_verify">Email Verified</label>
                </div>
            </div>
        </div>
        <!-- /Account -->
    </div>
</div>
