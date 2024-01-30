@extends('layout.layout')

@section('head')
    <title>Show Profile</title>
@endsection

@section('content')
    <div>
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="container-xxl flex-grow-1 container-p-y mx-24">
        <div class="flex justify-end mt-3 mr-24">
            <a href="{{ route('profile.edit') }}" class="my-4 btn btn-warning waves-effect waves-light">Edit Profile
                <i class="tf-icons mdi mdi-pencil ml-2"></i>
            </a>
        </div>
        <div class="card mb-4 mx-24">
            <h4 class="card-header">Profile Details</h4> <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-4 ml-2"> <img
                        src="{{ URL::asset('assets/img/avatars/1.png') }}" alt="user-avatar"
                        class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />

                </div>
            </div>

            <div class="card-body pt-2 mt-1">
                <form id="" method="POST" action="#">
                    @csrf
                    <div class="menu-header small text-uppercase mb-2">
                        <span class="menu-header-text">Account Information</span>
                    </div>

                    <div class="row row-cols-4 row-cols-lg-4 mb-8 gy-4">
                        <div class="col">
                            <div>
                                <label for="defaultFormControlInput" class="form-label">Full Name</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon41"><i
                                            class="mdi mdi-account-outline"></i></span>
                                    <input value="{{ $user->name }}" readonly type="text" class="form-control"
                                        placeholder="John Doe" aria-label="Name" />
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div>
                                <label for="defaultFormControlInput" class="form-label">Email</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon41"><i
                                            class="mdi mdi-email-outline"></i></span>
                                    <input value="{{ $user->email }}" readonly type="text" class="form-control"
                                        placeholder="John Doe" aria-label="Name" />
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <label class="form-label" for="basic-default-password32">Username</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" id="basic-addon41">@</span>
                                <input value="{{ $user->username }}" readonly type="text" class="form-control"
                                    placeholder="Username" aria-label="Username" aria-describedby="basic-addon41" />
                            </div>
                        </div>

                        <div class="col">
                            <label class="form-label" for="basic-default-password32">Phone Number</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" id="basic-addon41">PHIL +63</span>
                                <input value="{{ $user->contact_number }}" readonly type="text" class="form-control"
                                    placeholder="9123456789" aria-label="Username" aria-describedby="basic-addon41" />
                            </div>
                        </div>
                    </div>

                    <div class="menu-header small text-uppercase mb-2">
                        <span class="menu-header-text">Other Information</span>
                    </div>

                    <div class="row row-cols-4 row-cols-lg-3 mb-24 gy-4">
                        <div class="col">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" class="form-select" disabled>
                                @if ($user->gender)
                                    <option value="{{ $user->gender }}" selected>{{ $user->gender }}</option>
                                @else
                                    <option value="" selected disabled>Select Gender</option>
                                @endif
                                <option value="brother" {{ $user->gender === 'brother' ? 'disabled' : '' }}>Brother
                                </option>
                                <option value="sister" {{ $user->gender === 'sister' ? 'disabled' : '' }}>Sister</option>
                                <option value="others" {{ $user->gender === 'others' ? 'disabled' : '' }}>Others</option>
                            </select>
                        </div>


                        <div class="col">
                            <label for="area">Area</label>
                            <select id="area" name="area" class="form-select" disabled>
                                @if ($user->area)
                                    <option value="{{ $user->area }}" selected>{{ $user->area }}</option>
                                @else
                                    <option value="" selected disabled>Select Area</option>
                                @endif
                                <option value="north" {{ $user->area === 'north' ? 'disabled' : '' }}>North</option>
                                <option value="central" {{ $user->area === 'central' ? 'disabled' : '' }}>Central</option>
                                <option value="south" {{ $user->area === 'south' ? 'disabled' : '' }}>South</option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="chapter">Chapter</label>
                            <select id="chapter" name="chapter" class="form-select" disabled>
                                @if ($user->chapter)
                                    <option value="{{ $user->chapter }}" selected>{{ $user->chapter }}</option>
                                @else
                                    <option value="" selected disabled>Select Chapter</option>
                                @endif
                                <option value="1" {{ $user->chapter === '1' ? 'disabled' : '' }}>Chapter 1</option>
                                <option value="2" {{ $user->chapter === '2' ? 'disabled' : '' }}>Chapter 2</option>
                                <option value="3" {{ $user->chapter === '3' ? 'disabled' : '' }}>Chapter 3</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>

@endsection
