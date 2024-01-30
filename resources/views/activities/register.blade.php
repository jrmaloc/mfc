@extends('layout.layout')

@section('head')
@endsection

@section('content')
    <x-layout>
        <div class="card mx-60 my-28">
            <div class="card-header flex justify-center uppercase mt-4">
                <h3>
                    {{ $activity->title }}
                </h3>
            </div>
            <div class="card-body">
                <h5>
                    REGISTRATION
                </h5>
                <form action="{{ route('calendar.registration', ['id' => $id]) }}" method="PUT">
                    @csrf
                    @method('PUT')
                    <x-form.input-group class="row-cols-1">
                        <x-form.input-field name="name" type="text" icon="account" placeholder="Juan A. Dela Cruz"
                            value="{{ $user->name }}" error="{{ $errors->first('name') }}">
                            Full Name
                        </x-form.input-field>
                        <x-form.input-field name="contact_number" type="tel" icon="phone" placeholder="09123456789"
                            value="{{ $user->contact_number }}" error="{{ $errors->first('contact_number') }}">
                            Contact Number
                        </x-form.input-field>
                        <x-form.input-field name="reg_fee" type="text" icon="cash" value="{{ $activity->reg_fee }}"
                            error="{{ $errors->first('reg_fee') }}" param="readonly">
                            Registration Fee
                        </x-form.input-field>
                    </x-form.input-group>

                    <x-form.btn-grp submit="Register Now!" reset="RESET">
                    </x-form.btn-grp>
                </form>
            </div>
        </div>
    </x-layout>
@endsection
