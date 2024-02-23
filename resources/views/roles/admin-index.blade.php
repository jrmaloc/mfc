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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" />
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
            <h2 class="fw-bold">Admin Management</h2>
        </div>

        <div class="flex justify-end">
            <x-off-canvas title="Create a new Admin" btn_name="create admin" id="createCanvas">
                <form id="createForm" action="{{ route('admin.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                            @php
                                $users = \App\Models\User::where('role_id', '<>', 2)->pluck('name', 'id')->toArray();
                            @endphp

                            <x-form.select-field name="name" selected="old('name')" error="{{ $errors->first('name') }}"
                                :options="$users" placeholder="Select a User">
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
                                            <input name="permission[]" value="{{ $value->id }}" class="form-check-input"
                                                type="checkbox" id="apermission_{{ $loop->index }}" disabled />
                                            <label class="form-check-label"
                                                for="apermission_{{ $loop->index }}">{{ $value->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    @foreach ($permission->slice($permission->count() / 2) as $value)
                                        <div class="form-check form-switch mb-2">
                                            <input name="permission[]" value="{{ $value->id }}" class="form-check-input"
                                                type="checkbox" id="bpermission_{{ $value->id }}" disabled />
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
            </x-off-canvas>
        </div>

        <!-- End Offcanvas -->
        <div class="col-lg-3 col-md-6">
            <div class="mt-3">
                <div class="offcanvas offcanvas-end" tabindex="-1" id="showCanvas" aria-labelledby="showCanvasLabel"
                    style="width: 26% !important;">
                    <div class="offcanvas-header">
                        <h5 id="showCanvasLabel" class="offcanvas-title">Admin Details</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>

                    <div class="offcanvas-body">
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-floating form-floating-outline mt-3">
                                        <input name="name" type="text" class="form-control" id="name"
                                            placeholder="Area Servant" readonly>
                                        <label for="name">Name</label>
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
                                                        @cannot('edit-role') disabled @endcannot disabled />
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
                                                        @cannot('edit-role') disabled @endcannot disabled />
                                                    <label class="form-check-label"
                                                        for="epermission_{{ $value->id }}">{{ $value->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- @can('edit-role')
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center flex justify-end gap-2 mt-12 pb-4">
                                    <button type="reset" class="btn btn-outline-info">Reset</button>
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </div>
                            @endcan --}}
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
            console.log("{{ session('success') }}");
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
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
                var id = 2;

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
                                        $('#epermission_' + permissionId
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

            var showCanvas = document.getElementById('showCanvas');
            showCanvas.addEventListener('show.bs.offcanvas', function() {
                var id = $('.show-btn').attr('id');

                $.ajax({
                    url: '{{ route('roles.edit', ['role' => ':id']) }}'.replace(':id', id),
                    type: 'GET',

                    success: function(response) {
                        var permissions = response.permissions;
                        var role = response.role;
                        // Populate form fields in the edit modal with permission details
                        if (role && role.name) {
                            // Populate form fields in the edit modal with permission details
                            $('#editForm input[name="name"]').val(role.name);

                            $(document).ready(function() {
                                // Sample condition: preselect checkboxes for roles with IDs 1 and 3
                                permissions.forEach(function(permission) {
                                    var data = permission.permissions;

                                    data.forEach(function(permissionId) {
                                        var checkboxId = 'permission_' +
                                            (
                                                permissionId.id - 1
                                            ); // Adjust the ID to match checkbox IDs
                                        $('#' + checkboxId).prop(
                                            'checked', true);
                                        $('#epermission_' + permissionId
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

            var showCanvas = document.getElementById('showCanvas');
            showCanvas.addEventListener('hidden.bs.offcanvas', function() {
                var createForm = document.getElementById('createForm');
                createForm.reset();
            });
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
                    url: "{{ route('admin.index') }}"
                },
                columns: columns,
                order: [
                    [0, 'asc'] // Sort by the first column (index 0) in descending order
                ]
            });
        }

        loadTable();
    </script>
@endpush
