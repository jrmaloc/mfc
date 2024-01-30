@extends('layout.layout')

@section('head')
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

<x-edit-form passwordRoute="couples.updatePassword" :parameters="['couple' => $couple]" back="couples.index" action="couples.update"
    :model="$couple" :status="$couple->status">

</x-edit-form>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const errorInputs = document.querySelectorAll('span.text-danger');
        if (errorInputs.length > 0) {
            const firstErrorInput = errorInputs[0].closest('.col').querySelector('.form-control');
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