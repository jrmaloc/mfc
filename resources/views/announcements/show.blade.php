@extends('layout.layout')

@section('head')
    <style>
        .btn-link:hover {
            color: #4c9913;
        }

        .btn-link {
            height: fit-content;
        }

        .form-control:focus,
        .form-select:focus,
        .input-group-text:focus {
            border-color: #58b61200 !important;
        }

        div.swal2-container.swal2-top-right.swal2-backdrop-show {
            z-index: 9999 !important;
        }
    </style>
@endsection

@section('content')
    <x-layout>
        <div class="card h-100">
            <div class="card-header mt-4 ml-4 uppercase flex">
                <div class="w-100">
                    <h2>
                        <span class="content" id="title">
                            {{ $data->title }}
                        </span>

                        <div class="input-group input-group-lg d-none" id="editTitle">
                            <input type="text" name="title" id="titleInput" class="form-control title"
                                value="{{ $data->title }}"
                                style="
                                font-size: 2rem;
                                font-weight: 500;
                                text-transform: uppercase;
                                border: none;
                                ">
                        </div>
                    </h2>
                </div>
            </div>
            <div class="card-body" style="padding: 0 75px;">
                <div class="flex justify-end mb-2">
                    <button class="btn btn-success" id="edit">Edit<span
                            class="fa fa-pencil fa-xs ml-2"></span></button>
                </div>
                <div class="rounded-lg border" style="height: 83%;">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 mt-3 ml-3">
                            <span class="uppercase">Details:</span>
                        </h6>
                        <span id="content" class="ml-7 mt-4">{{ $data->description }}</span>
                        <textarea name="description" class="form-control d-none w-100"
                            style="resize: horizontal; border:none; margin-right:150px;" id="editArea" rows="4">{{ $data->description }} </textarea>
                    </div>
                </div>

                <div class="d-none mt-2 flex justify-end gap-1" id="saveCancelButtons">
                    <button class="btn btn-success" id="save">Save</button>
                    <button class="btn btn-secondary" id="cancel">Cancel</button>
                </div>
            </div>
        </div>
    </x-layout>
@endsection

@push('scripts')
    <script>
        const content = document.getElementById('content');
        const title = document.getElementById('title');
        const titleInput = document.getElementById('titleInput');
        const editTextArea = document.getElementById('editArea');
        const editTitle = document.getElementById('editTitle');
        const editButton = document.getElementById('edit');
        const save = document.getElementById('save');
        const cancel = document.getElementById('cancel');
        const saveCancelButtons = document.getElementById('saveCancelButtons');

        editButton.addEventListener('click', function() {
            editTitle.classList.toggle('d-none');
            title.classList.toggle('d-none');
            content.classList.toggle('d-none');
            editTextArea.classList.toggle('d-none');
            editButton.classList.toggle('d-none');
            saveCancelButtons.classList.toggle('d-none');
            if (!editTextArea.classList.contains('d-none')) {
                editTextArea.focus();
            }
        });

        save.addEventListener('click', function() {
            $.ajax({
                url: `{{ route('announcements.update', ['announcement' => $data->id]) }}`,
                method: "PUT",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: {{ $data->id }},
                    description: editTextArea.value,
                    title: titleInput.value,
                },
                success: function(response) {
                    content.classList.toggle('d-none');
                    title.classList.toggle('d-none');
                    editTitle.classList.toggle('d-none');
                    editTextArea.classList.toggle('d-none');
                    saveCancelButtons.classList.toggle('d-none');
                    editButton.classList.toggle('d-none');
                    content.innerText = response.bio;

                    title.innerText = response.data.title;
                    content.innerText = response.data.description;

                    // //Fire Toast
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
                        icon: 'success',
                        title: response.message,
                    });
                },
                error: function(error) {
                    // Handle the error, e.g., show an error message
                    console.error('Error updating bio:', error);
                }
            });
        });

        cancel.addEventListener('click', function() {
            // Toggle back to read-only mode without saving changes
            title.classList.toggle('d-none');
            editTitle.classList.toggle('d-none');
            content.classList.toggle('d-none');
            editTextArea.classList.toggle('d-none');
            editButton.classList.toggle('d-none');
            saveCancelButtons.classList.toggle('d-none');
        });
    </script>
@endpush
