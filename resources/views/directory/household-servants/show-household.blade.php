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
  <div class="flex justify-end"> <a href="{{route('household.list')}}" class="my-4 btn
  btn-dark">Go Back<i class="tf-icons mdi mdi-arrow-u-left-top ml-2"></i></a> </div>
  <div class="card mb-4">
    <h4 class="card-header">Household Servant Profile Details</h4> <!-- Account -->
    <div class="card-body">
      <div class="d-flex align-items-start align-items-sm-center gap-4"> 
        @if ($householdservant && isset($householdservant->avatar))
        <img src="{{ asset($householdservant->avatar)}}" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded"
          id="uploadedAvatar" />
        @else
    <img src="{{ URL::asset('/assets/img/avatars/2.png') }}" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded"
          id="uploadedAvatar" />
        @endif
        <div class="button-wrapper"> <label for="upload" class=" btn btn-success me-2 mb-3" tabindex="0"> <span class="d-none
        d-sm-block">Upload new photo</span> <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i> <input type="file"
              id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" /> </label>
          <div class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K</div>
        </div>
      </div>
    </div>

    <div class="card-body pt-2 mt-1">
      <form id="" method="POST" action="{{route('household.store')}}">
        @csrf
        <div class="menu-header small text-uppercase mb-2">
          <div class="flex justify-end">
            <a href="{{route ('household.edit', ['householdservant' => $householdservant])}}"
              class="py-auto btn btn-primary btn-sm">Edit Profile<i class="tf-icons mdi mdi-pencil"></i></a>
          </div>
          <span class="menu-header-text">Account Information</span>
        </div>

        <div class="row row-cols-4 row-cols-lg-2 mb-8 gy-4">
          <div class="col">
            <div>
              <label for="defaultFormControlInput" class="form-label">Full Name</label>
              <div class="input-group input-group-merge">
                <span class="input-group-text" id="basic-addon41" ><i class="mdi mdi-account-outline" style="border: none;"></i></span>
                <input value="{{ $householdservant->name }}" readonly type="text" class="form-control"
                  placeholder="John Doe" aria-label="Name" style="border: none;"/>
              </div>
            </div>
          </div>

          <div class="col">
            <div>
              <label for="defaultFormControlInput" class="form-label">Email</label>
              <div class="input-group input-group-merge">
                <span class="input-group-text" id="basic-addon41" style="border: none;"><i class="mdi mdi-email-outline"></i></span>
                <input value="{{ $householdservant->email }}" readonly type="text" class="form-control"
                  placeholder="John Doe" aria-label="Name" style="border: none;"/>
              </div>
            </div>
          </div>

          <div class="col">
            <label class="form-label" for="basic-default-password32">Username</label>
            <div class="input-group input-group-merge">
              <span class="input-group-text" id="basic-addon41" style="border: none;">@</span>
              <input value="{{ $householdservant->email }}" readonly type="text" class="form-control"
                placeholder="Username" aria-label="Username" aria-describedby="basic-addon41" style="border: none;"/>
            </div>
          </div>

          <div class="col">
            <label class="form-label" for="basic-default-password32">Phone Number</label>
            <div class="input-group input-group-merge">
              <span class="input-group-text" id="basic-addon41" style="border: none;">PHIL +63</span>
              <input value="{{ $householdservant->contact_number }}" readonly type="text" class="form-control"
                placeholder="9123456789" aria-label="Username" aria-describedby="basic-addon41" style="border: none;"/>
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
              @if($householdservant->gender)
              <option value="{{$householdservant->gender}}" selected>{{$householdservant->gender}}</option>
              @else
              <option value="" selected disabled>Select Gender</option>
              @endif
              <option value="brother" {{ $householdservant->gender === 'brother' ? 'disabled' : '' }}>Brother</option>
              <option value="sister" {{ $householdservant->gender === 'sister' ? 'disabled' : '' }}>Sister</option>
              <option value="others" {{ $householdservant->gender === 'others' ? 'disabled' : '' }}>Others</option>
            </select>
          </div>


          <div class="col">
            <label for="area">Area</label>
            <select id="area" name="area" class="form-select" disabled>
              @if($householdservant->area)
              <option value="{{$householdservant->area}}" selected>{{$householdservant->area}}</option>
              @else
              <option value="" selected disabled>Select Area</option>
              @endif
              <option value="north" {{ $householdservant->area === 'north' ? 'disabled' : '' }}>North</option>
              <option value="central" {{ $householdservant->area === 'central' ? 'disabled' : '' }}>Central</option>
              <option value="south" {{ $householdservant->area === 'south' ? 'disabled' : '' }}>South</option>
            </select>
          </div>

          <div class="col">
            <label for="chapter">Chapter</label>
            <select id="chapter" name="chapter" class="form-select" disabled>
              @if($householdservant->chapter)
              <option value="{{$householdservant->chapter}}" selected>{{$householdservant->chapter}}</option>
              @else
              <option value="" selected disabled>Select Chapter</option>
              @endif
              <option value="1" {{ $householdservant->chapter === '1' ? 'disabled' : '' }}>Chapter 1</option>
              <option value="2" {{ $householdservant->chapter === '2' ? 'disabled' : '' }}>Chapter 2</option>
              <option value="3" {{ $householdservant->chapter === '3' ? 'disabled' : '' }}>Chapter 3</option>
            </select>
          </div>
        </div>

        <div class="mb-12 ml-2">
          <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" id="status" disabled {{ $householdservant->status ===
            'Active' ? 'checked' : '' }}/>
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