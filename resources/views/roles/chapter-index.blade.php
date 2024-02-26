@extends('layout.layout')

@section('head')
    <title>Roles</title>
    <!-- Add your styles here -->
    <style>
        td:nth-child(2) {
            width: 80%;
        }

        thead {
            background: #58D68D;
        }

        th {
            color: #ECF0F1 !important;
            font-size: 15px !important;
        }

        #addRoleForm,
        #showRoleForm {
            position: absolute;
            width: 33%;
            height: 100%;
            background: #fff;
            right: -80%;
            top: 0;
            transition: 0.4s ease-out;
        }

        #addRoleForm.active,
        #showRoleForm.active {
            right: 0;
        }

        #addRoleForm.disabled,
        #showRoleForm.disabled {
            right: -80%;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            /* Adjust opacity as needed */
            backdrop-filter: blur(5px);
            /* Apply the blur effect */
            z-index: 1200;
            /* Ensure it's above other content */
            display: none;
            /* Initially hide it */
        }

        .overlay2 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            /* Adjust opacity as needed */
            backdrop-filter: blur(5px);
            /* Apply the blur effect */
            z-index: 1200;
            /* Ensure it's above other content */
            display: none;
            /* Initially hide it */
        }

        i.fa.fa-xmark.fa {
            color: #ECF0F1;
        }

        h2 {
            margin-bottom: 0 !important;
        }
    </style>
@endsection

@section('content')
    @if ($errors->any())
        <style>
            .toast-container {
                z-index: 9999;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            const error = Swal.mixin({
                toast: true,
                animation: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            // Iterate over each error message and display it using SweetAlert2
            @foreach ($errors->all() as $error)
                error.fire({
                    icon: 'error',
                    title: '{{ $error }}',
                });
            @endforeach
        </script>
    @endif

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold">Chapter Servant Management</h2>
        </div>

        <style>
            button#offcanvasbtn {
                width: max-content;
            }

            @media (max-width: 768px) {
                button#offcanvasbtn {
                    width: 100% !important;
                    right: 0 !important;
                    font-size: 0.75rem !important;
                    margin-top: 1rem !important;
                }

                h2.fw-bold {
                    font-size: 1.25rem !important;
                }

                div#createCanvas,
                div#showCanvas {
                    width: 80% !important;
                }
            }
        </style>

        <div class="flex justify-end">
            <x-off-canvas class="mb-2" title="Create a new Chapter Servant" btn_name="create chapter servant"
                id="createCanvas">
                <div class="card-body">
                    <form id="createForm" action="{{ route('chapter.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                @php
                                    $users = \App\Models\User::where('role_id', '<>', 4)->pluck('name', 'id')->toArray();
                                @endphp

                                <x-form.select-field name="name" selected="old('name')"
                                    error="{{ $errors->first('name') }}" :options="$users" placeholder="Select a User">
                                    Name
                                </x-form.select-field>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 ml-4">
                            <div class="form-group">
                                <strong class="mb-4">Permission:</strong>
                                <br />
                                <div class="row">
                                    <div class="col-md-6">
                                        @foreach ($permission->slice(0, $permission->count() / 2) as $value)
                                            <div class="form-check form-switch mb-2">
                                                <input name="permission[]" value="{{ $value->id }}"
                                                    class="form-check-input" type="checkbox"
                                                    id="apermission_{{ $loop->index }}" disabled />
                                                <label class="form-check-label"
                                                    for="apermission_{{ $loop->index }}">{{ $value->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-6">
                                        @foreach ($permission->slice($permission->count() / 2) as $value)
                                            <div class="form-check form-switch mb-2">
                                                <input name="permission[]" value="{{ $value->id }}"
                                                    class="form-check-input" type="checkbox"
                                                    id="bpermission_{{ $value->id }}" disabled />
                                                <label class="form-check-label"
                                                    for="bpermission_{{ $value->id }}">{{ $value->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center flex justify-end gap-2 mt-12 pb-4">
                            <button type="submit" id="create_btn" class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div>
            </x-off-canvas>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="mt-3">
                <div class="offcanvas offcanvas-end" tabindex="-1" id="showCanvas" aria-labelledby="showCanvasLabel">
                    <div class="offcanvas-header">
                        <h5 id="showCanvasLabel" class="offcanvas-title">Chapter Servant Details</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>

                    <div class="offcanvas-body">
                        <form id="editForm" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-floating form-floating-outline mt-3">
                                        <input name="name" type="text" class="form-control" id="name"
                                            placeholder="Admin" readonly>
                                        <label for="">Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 ml-4">
                                <div class="form-group">
                                    <strong class="mb-4">Permission:</strong>
                                    <br />
                                    <div class="row">
                                        <div class="col-md-6">
                                            @foreach ($permission->slice(0, $permission->count() / 2) as $value)
                                                <div class="form-check form-switch mb-2">
                                                    <input name="permission[]" value="{{ $value->id }}"
                                                        class="form-check-input" type="checkbox"
                                                        id="permission_{{ $loop->index }}"
                                                        @cannot('edit-role')
                                                            disabled
                                                        @endcannot />
                                                    <label class="form-check-label"
                                                        for="permission_{{ $loop->index }}">{{ $value->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-6">
                                            @foreach ($permission->slice($permission->count() / 2) as $value)
                                                <div class="form-check form-switch mb-2">
                                                    <input name="permission[]" value="{{ $value->id }}"
                                                        class="form-check-input" type="checkbox"
                                                        id="epermission_{{ $value->id }}"
                                                        @cannot('edit-role')
                                                            disabled
                                                        @endcannot />
                                                    <label class="form-check-label"
                                                        for="epermission_{{ $value->id }}">{{ $value->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @can('edit-role')
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center flex justify-end gap-2 mt-12 pb-4">
                                    <button type="reset" class="btn btn-outline-info">Reset</button>
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </div>
                            @endcan
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-body">
                <table class="table table-striped data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <!-- Add other columns here -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @if (session('success'))
        <style>
            .toast-container {
                z-index: 99999;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                animation: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });


            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}",

            });
        </script>
    @elseif (session('delete'))
        <style>
            .toast-container {
                z-index: 9999;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            const x = Swal.mixin({
                toast: true,
                animation: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            x.fire({
                icon: 'success',
                title: "{{ session('delete') }}",

            });
        </script>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on("click", ".remove-btn", function(e) {
                let id = $(this).attr("id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Demote to a Member?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, demote it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('roles.destroy', ['role' => ':id']) }}"
                                .replace(':id', id),
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
                                                    location.reload();
                                                }
                                            })
                                }
                            }
                        })
                    }
                })
            });

            var createCanvas = document.getElementById('createCanvas');
            createCanvas.addEventListener('show.bs.offcanvas', function() {
                var id = 4;

                $.ajax({
                    url: '{{ route('roles.show', ['role' => ':id']) }}'.replace(':id', id),
                    type: 'GET',

                    success: function(response) {
                        var permissions = response.permissions;
                        var role = response.role;
                        // Populate form fields in the edit modal with permission details
                        if (role && role.name) {

                            $(document).ready(function() {
                                // Sample condition: preselect checkboxes for roles with IDs 1 and 3
                                permissions.forEach(function(permission) {
                                    var data = permission.permissions;

                                    data.forEach(function(permissionId) {
                                        var checkboxId =
                                            'apermission_' + (
                                                permissionId.id - 1
                                            ); // Adjust the ID to match checkbox IDs
                                        $('#' + checkboxId).prop(
                                            'checked', true);
                                        $('#bpermission_' + permissionId
                                            .id).prop('checked',
                                            true);
                                    });
                                });
                            });
                        } else {
                            console.log('Role Not Found');
                        }
                    },
                    error: function(error, xhr) {
                        console.log(error);
                        console.log("Failed to fetch permission details for editing.");
                    }
                });
            });

            var createCanvas = document.getElementById('createCanvas');
            createCanvas.addEventListener('hidden.bs.offcanvas', function() {
                var createForm = document.getElementById('createForm');
                createForm.reset();
            });

            // show Canvas
            $(document).on('click', '.show-btn', function(e) {
                var id = $(this).attr('id');
                $('#editForm').attr('action', '{{ route('roles.update', [':id']) }}'.replace(':id', id));

                $.ajax({
                    url: '{{ route('roles.edit', [':id']) }}'.replace(':id', id),
                    type: 'GET',

                    success: function(response) {
                        var permissions = response.permissions;
                        var name = response.user.name;
                        // Populate form fields in the edit modal with permission details
                        if (name && permissions) {
                            // Populate form fields in the edit modal with permission details
                            $('#editForm input[name="name"]').val(name);

                            $(document).ready(function() {
                                // Sample condition: preselect checkboxes for roles with IDs 1 and 3
                                permissions.forEach(function(permission) {
                                    var id = permission.permission_id;

                                    var checkboxId = 'permission_' +
                                        (
                                            id - 1
                                        );
                                    $('#' + checkboxId).prop(
                                        'checked', true);
                                    $('#epermission_' + id).prop('checked',
                                        true);
                                });
                            });
                        } else {
                            console.log('Role Not Found');
                        }
                    },
                    error: function(error, xhr) {
                        console.log(error);
                        console.log("Failed to fetch permission details for editing.");
                    }
                });
            });

            var showCanvas = document.getElementById('showCanvas')
            showCanvas.addEventListener('hidden.bs.offcanvas', function() {
                var editForm = document.getElementById('editForm');
                editForm.reset();
            });

            function loadTable() {
                let columns = [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                    },
                ];

                let table = $('.data-table').DataTable({
                    processing: true,
                    pageLength: 25,
                    responsive: true,
                    serverSide: true,
                    scrollX: false,
                    scrollY: 550,
                    ajax: {
                        url: "{{ route('chapter.index') }}"
                    },
                    columns: columns,
                    order: [
                        [0, 'asc'] // Sort by the first column (index 0) in descending order
                    ]
                });
            }

            loadTable();
        });
    </script>
@endpush
