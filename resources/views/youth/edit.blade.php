@extends('layout.layout')

@section('head')
    <style>
        div.swal2-container.swal2-top-right.swal2-backdrop-show {
            z-index: 9999 !important;
        }
    </style>
@endsection

@section('content')
    <x-edit-form passwordRoute="youth.updatePassword" :parameters="['youth' => $youth]" back="youth.index" action="youth.update"
        :model="$youth" :status="$youth->status">

    </x-edit-form>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const errorInputs = document.querySelectorAll('span.text-danger');
            if (errorInputs.length > 0) {
                const firstErrorInput = errorInputs[0].closest('.col').querySelector('.form-control');
                if (firstErrorInput) {
                    firstErrorInput.focus();
                }
            }

            $('#upload').change(function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $('#uploadedAvatar').attr('src', event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
