@extends('layout.layout')

@section('head')
@endsection

@section('content')
    <x-layout>
        <div class="flex justify-end mb-2 mt-3"> <a href="{{ route('calendar.list') }}" class="my-4 btn btn-dark">See
                Calendar of Events
                <i class="tf-icons mdi mdi-arrow-u-left-top ml-2"></i></a>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>
                    {{ $activity->title }}
                </h4>
            </div>
            <form action="{{ route('calendar.update', ['id' => $id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="col mb-4 mt-2">
                        <div class="form-floating form-floating-outline">
                            <textarea type="text" style="height: auto;" type="longtext" id="showDescription" class="form-control"
                                name="description" placeholder="Enter Description" rows="8" @if (auth()->check() &&
                                        (auth()->user()->hasRole('Area Servant') ||
                                            auth()->user()->hasRole('Chapter Servant') ||
                                            auth()->user()->hasRole('Unit Servant') ||
                                            auth()->user()->hasRole('Household Servant') ||
                                            auth()->user()->hasRole('Member'))) readonly @endif>{{ $activity->description }}</textarea>
                            <label for="showDescription">Description</label>
                        </div>
                    </div>

                    <div class="col mb-4 mt-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="showLocation" class="form-control" name="location"
                                value="{{ $activity->location }}" placeholder="Enter Title"
                                @if (auth()->check() &&
                                        (auth()->user()->hasRole('Area Servant') ||
                                            auth()->user()->hasRole('Chapter Servant') ||
                                            auth()->user()->hasRole('Unit Servant') ||
                                            auth()->user()->hasRole('Household Servant') ||
                                            auth()->user()->hasRole('Member'))) readonly @endif />
                            <label for="showLocation">Location</label>
                        </div>
                    </div>

                    <div class="col mb-4 mt-2">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="showReg_fee" name="reg_fee" placeholder="₱0000"
                                value="{{ $activity->reg_fee }}" @if (auth()->check() &&
                                        (auth()->user()->hasRole('Area Servant') ||
                                            auth()->user()->hasRole('Chapter Servant') ||
                                            auth()->user()->hasRole('Unit Servant') ||
                                            auth()->user()->hasRole('Household Servant') ||
                                            auth()->user()->hasRole('Member'))) readonly @endif />
                            <label for="showReg_fee">Registration Fee</label>
                            @error('amount')
                                <span class="mt-2 ml-2 text-danger text-xs">{{ $message }}.</span>
                            @enderror
                        </div>
                    </div>


                    <div class="row">
                        <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                                <input type="datetime-local" id="showStart_date" class="form-control" name="start_date"
                                    value="{{ $activity->start_date }}" @if (auth()->check() &&
                                            (auth()->user()->hasRole('Area Servant') ||
                                                auth()->user()->hasRole('Chapter Servant') ||
                                                auth()->user()->hasRole('Unit Servant') ||
                                                auth()->user()->hasRole('Household Servant') ||
                                                auth()->user()->hasRole('Member'))) readonly @endif />
                                <label for="showStart_date">Start Date</label>
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="form-floating form-floating-outline">
                                <input type="datetime-local" id="showEnd_date" class="form-control" name="end_date"
                                    value="{{ $activity->end_date }}" @if (auth()->check() &&
                                            (auth()->user()->hasRole('Area Servant') ||
                                                auth()->user()->hasRole('Chapter Servant') ||
                                                auth()->user()->hasRole('Unit Servant') ||
                                                auth()->user()->hasRole('Household Servant') ||
                                                auth()->user()->hasRole('Member'))) readonly @endif />
                                <label for="showEnd_date">End Date</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @if (auth()->check() &&
                            (auth()->user()->hasRole('Super Admin') ||
                                auth()->user()->hasRole('Admin')))
                        <div class="flex justify-end gap-2">
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            <a href="#" class="btn btn-danger remove-btn" data-id="{{ $id }}">Delete</a>
                            <button type="submit" id="saveBtn" class="btn btn-success">Save</button>
                        </div>
                    @endif
                </div>
            </form>
    </x-layout>

    <style>
        div.swal2-container.swal2-top-right.swal2-backdrop-show {
            z-index: 9999 !important;
        }
    </style>

    @if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                icon:'success',
                title: 'General Title',
                animation: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon:'success',
                title: '{{ session('success') }}',
            });
        </script>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.remove-btn').on('click', function(e) {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Remove servant from list",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('calendar.delete', '') }}/` + id,
                            method: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire('Removed!', response.message, 'success')
                                        .then(
                                            result => {
                                                if (result.isConfirmed) {
                                                    toastr.success(response.message,
                                                        'Success');
                                                    window.location.href = response
                                                        .redirect;
                                                }
                                            })
                                }
                            }
                        })
                    }
                })
            });
        });
    </script>
@endpush
