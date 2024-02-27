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
        icon: 'error', // Change the icon to 'error'
        title: 'General Title',
        animation: true,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    Toast.fire({
        title: 'Registration Failed', // Update the title
    });

</script>
@endif

<x-show-form back="handmaids.index" edit="handmaids.edit" :parameters="['handmaid' => $handmaid]" :model="$handmaid"></x-show-form>
@endsection
