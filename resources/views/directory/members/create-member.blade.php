@extends('layout.layout')

@section('head')
<title>Household Registration</title>
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

<x-layout>
    <x-form.back-btn route="household.list" />
    <div class="card mb-4">
        <h4 class="card-header">Household Registration </h4>
        <!-- Account -->
        <div class="card-body pt-2 mt-1">
            <form id="myForm" method="POST" action="{{route('member.store')}}" enctype="multipart/form-data">
                @csrf
                <x-form.image-field name="avatar" id="upload" uploaded="uploadedAvatar" img="2">
                    Upload Picture.
                </x-form.image-field>

                <div class="menu-header small text-uppercase mb-2">
                    <span class="menu-header-text">Account Information</span>
                </div>

                <x-form.input-group rows="4">
                    <x-form.input-field name="name" type="text" placeholder="John Doe" value="{{ old('name') }}"
                        error="{{ $errors->first('name') }}" icon="account-outline">
                        Full Name
                    </x-form.input-field>

                    <x-form.input-field name="email" type="email" placeholder="JohnDoe@example.com"
                        value="{{ old('email') }}" error="{{ $errors->first('email') }}" icon="email-outline">
                        Valid Email Address
                    </x-form.input-field>

                    <x-form.input-field name="username" type="text" placeholder="john_doe12!"
                        value="{{ old('username') }}" error="{{ $errors->first('username') }}" icon="email-outline">
                        Username
                    </x-form.input-field>

                    <x-form.input-field name="contact_number" type="tel" placeholder="09123456789"
                        value="{{ old('contact_number') }}" error="{{ $errors->first('contact_number') }}"
                        icon="phone-outline">
                        Contact Number
                    </x-form.input-field>
                </x-form.input-group>

                <x-form.input-header>
                    Other Information
                </x-form.input-header>

                <x-form.input-group rows="3">
                    @php
                    $genderOptions = [
                    'Brother' => 'Brother',
                    'Sister' => 'Sister',
                    ];

                    $areaOptions = [
                    'North' => 'North',
                    'East' => 'East',
                    'Central' => 'Central',
                    'West' => 'West',
                    'South' => 'South',
                    ];

                    $chapterOptions = [
                    'Chapter 1' => 'Chapter 1',
                    'Chapter 2' => 'Chapter 2',
                    'Chapter 3' => 'Chapter 3',
                    'Chapter 4' => 'Chapter 4',
                    ];
                    @endphp

                    <x-form.select-field name="gender" selected="old('gender')" placeholder="Select Gender"
                        error="{{ $errors->first('gender') }}" :options="$genderOptions">
                        Gender
                    </x-form.select-field>

                    <x-form.select-field name="area" selected="old('area')" placeholder="Select Area"
                        error="{{ $errors->first('area') }}" :options="$areaOptions">
                        Area
                    </x-form.select-field>

                    <x-form.select-field name="area" selected="old('area')" placeholder="Select Area"
                        error="{{ $errors->first('area') }}" :options="$chapterOptions">
                        Chapter
                    </x-form.select-field>
                </x-form.input-group>

                <x-form.input-header>
                    security
                </x-form.input-header>

                <x-form.input-group rows="2">
                    <x-form.password-field name="password">
                        Password
                    </x-form.password-field>

                    <x-form.password-field name="confirm_password">
                        Confirm Password
                    </x-form.password-field>
                </x-form.input-group>

                <x-form.btn-grp/>
            </form>
        </div>
        <!-- /Account -->
    </div>
</x-layout>
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
