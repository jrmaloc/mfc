@extends('layout.layout')

@section('head')
    <style>
        div.swal2-container.swal2-top-right.swal2-backdrop-show {
            z-index: 9999 !important;
        }
    </style>
@endsection

@section('content')
    <x-edit-form passwordRoute="kids.updatePassword" :parameters="['kid' => $kid]" back="kids.index" action="kids.update" :model="$kid"
        :status="$kid->status">
    </x-edit-form>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

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

            $(document).on("click", "#back", function(e) {
                window.history.back();
            })
        });
    </script>
@endpush
