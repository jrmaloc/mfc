@extends('layout.layout')

@section('head')
<title>Show Profile</title>
@endsection

@section('content')
<div>
  @if($errors->any())
  <ul>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
  </ul>


  @endif
</div>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="flex justify-end"> <a href="{{route('member.list')}}" class="my-4 btn
  btn-dark">Go Back<i class="tf-icons mdi mdi-arrow-u-left-top ml-2"></i></a> </div>
  <div class="card">
    <h4 class="card-header">Member Profile Details</h4> <!-- Account -->
    <div class="card-body">
      <div class="d-flex align-items-start align-items-sm-center gap-4">
        @if ($member && isset($member->avatar))
        <img src="{{ asset($member->avatar)}}" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />
        @else
        <img src="{{ URL::asset('/assets/img/avatars/2.png') }}" alt="default-avatar" class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />
        @endif
        <div class="flex justify-end">
          <a href="{{route ('members.edit', ['member' => $member])}}" class="py-auto btn btn-primary btn-sm flex justify-end">Edit
            Profile<i class="tf-icons mdi mdi-pencil"></i></a>
        </div>

      </div>
    </div>

    <div class="card-body pt-2 mt-1">
      <form id="" method="POST">
        @csrf
        <div class="menu-header small text-uppercase mb-2">
          <span class="menu-header-text">Account Information</span>
        </div>

        <div class="row row-cols-4 row-cols-lg-2 mb-8 gy-4">
          <div class="col">
            <div>
              <label for="defaultFormControlInput" class="form-label">Full Name</label>
              <div class="input-group input-group-merge">
                <span class="input-group-text" id="basic-addon41" style="border: none;"><i class="mdi mdi-account-outline"></i></span>
                <input value="{{ $member->name }}" readonly type="text" class="form-control" placeholder="John Doe" aria-label="Name" style="border: none;" />
              </div>
            </div>
          </div>

          <div class="col">
            <div>
              <label for="defaultFormControlInput" class="form-label">Email</label>
              <div class="input-group input-group-merge">
                <span class="input-group-text" id="basic-addon41" style="border: none;"><i class="mdi mdi-email-outline"></i></span>
                <input value="{{ $member->email }}" readonly type="text" class="form-control" placeholder="John Doe" aria-label="Name" style="border: none;" />
              </div>
            </div>
          </div>

          <div class="col">
            <label class="form-label" for="basic-default-password32">Username</label>
            <div class="input-group input-group-merge">
              <span class="input-group-text" id="basic-addon41" style="border: none;">@</span>
              <input value="{{ $member->email }}" readonly type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon41" style="border: none;" />
            </div>
          </div>

          <div class="col">
            <label class="form-label" for="basic-default-password32">Phone Number</label>
            <div class="input-group input-group-merge">
              <span class="input-group-text" id="basic-addon41" style="border: none;">PHIL +63</span>
              <input value="{{ $member->contact_number }}" readonly type="text" class="form-control" placeholder="9123456789" aria-label="Username" aria-describedby="basic-addon41" style="border: none;" />
            </div>
          </div>
        </div>

        <div class="menu-header small text-uppercase mb-2">
          <span class="menu-header-text">Other Information</span>
        </div>

        <div class="row row-cols-4 row-cols-lg-3 mb-24 gy-4">
          <div class="col">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" class="form-select" disabled style="border: none; background: #fff;">
              @if($member->gender)
              <option value="{{$member->gender}}" selected>{{$member->gender}}</option>
              @else
              <option value="" selected disabled>Select Gender</option>
              @endif
              <option value="brother" {{ $member->gender === 'brother' ? 'disabled' : '' }}>Brother</option>
              <option value="sister" {{ $member->gender === 'sister' ? 'disabled' : '' }}>Sister</option>
              <option value="others" {{ $member->gender === 'others' ? 'disabled' : '' }}>Others</option>
            </select>
          </div>


          <div class="col">
            <label for="area">Area</label>
            <select id="area" name="area" class="form-select" disabled style="border: none; background: #fff;">
              @if($member->area)
              <option value="{{$member->area}}" selected>{{$member->area}}</option>
              @else
              <option value="" selected disabled>Select Area</option>
              @endif
              <option value="north" {{ $member->area === 'north' ? 'disabled' : '' }}>North</option>
              <option value="central" {{ $member->area === 'central' ? 'disabled' : '' }}>Central</option>
              <option value="south" {{ $member->area === 'south' ? 'disabled' : '' }}>South</option>
            </select>
          </div>

          <div class="col">
            <label for="chapter">Chapter</label>
            <select id="chapter" name="chapter" class="form-select" disabled style="border: none; background: #fff;">
              @if($member->chapter)
              <option value="{{$member->chapter}}" selected>{{$member->chapter}}</option>
              @else
              <option value="" selected disabled>Select Chapter</option>
              @endif
              <option value="1" {{ $member->chapter === '1' ? 'disabled' : '' }}>Chapter 1</option>
              <option value="2" {{ $member->chapter === '2' ? 'disabled' : '' }}>Chapter 2</option>
              <option value="3" {{ $member->chapter === '3' ? 'disabled' : '' }}>Chapter 3</option>
            </select>
          </div>
        </div>

        <div class="mb-24 ml-2">
          <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" id="status" disabled {{ $member->status === 'Active' ?
            'checked' : '' }} />
            <label class="form-check-label" for="status">Active</label>
          </div>

          <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" disabled />
            <label class="form-check-label" for="flexSwitchCheckDefault">Email Verified</label>
          </div>
        </div>
      </form>
    </div>
    <!-- /Account -->
  </div>
</div>

@endsection