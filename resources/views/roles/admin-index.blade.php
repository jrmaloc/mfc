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
    </style>
@endsection

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Modal --}}
        <div id="showRoleForm" class="card">
            <div class="flex justify-between px-12 py-6" style="background: #1b661b;">
                <h2 class="fw-bold pt-4 text-white">
                    Role Details
                </h2>
                <a href="javascript:void(0);" onclick="hideForm()" class="btn"><i class=" fa fa-xmark fa"></i></a>
            </div>
            <div class="card-body">
                <form id="editForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                            <div class="form-floating form-floating-outline mt-3">
                                <input name="name" type="text" class="form-control" id="" placeholder="Admin"
                                    readonly>
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
                                            <input name="permission[]" value="{{ $value->id }}" class="form-check-input"
                                                type="checkbox" id="permission_{{ $loop->index }}" disabled />
                                            <label class="form-check-label"
                                                for="permission_{{ $loop->index }}">{{ $value->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    @foreach ($permission->slice($permission->count() / 2) as $value)
                                        <div class="form-check form-switch mb-2">
                                            <input name="permission[]" value="{{ $value->id }}" class="form-check-input"
                                                type="checkbox" id="epermission_{{ $value->id }}" disabled />
                                            <label class="form-check-label"
                                                for="epermission_{{ $value->id }}">{{ $value->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-xs-12 col-sm-12 col-md-12 text-center flex justify-end gap-2 mt-12 pb-4">
                        <button type="reset" class="btn btn-outline-info">Reset</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div> --}}
                </form>
            </div>
        </div>

        <div id="addRoleForm" class="card">
            <div class="flex justify-between px-12 py-6" style="background: #1b661b;">
                <h2 class="fw-bold pt-4 text-white">
                    Role Details
                </h2>
                <a href="javascript:void(0);" onclick="hide()" class="btn"><i class=" fa fa-xmark fa"></i></a>
            </div>
            <div class="card-body">
                <form id="createForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                            @php
                                $users = \App\Models\User::where('role_id', '<>', 2)
                                    ->pluck('name', 'id')
                                    ->toArray();
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
                        <button type="button" id="create_btn" class="btn btn-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- /Modal --}}

        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-4">Role Management</h4>
        </div>

        <div class="text-sm flex justify-end">
            <a href="javascript:void(0);" id="admin_create" class="btn btn-success capitalized text-sm"
                style="font-size: small;">
                Add an Admin
                <i class="mdi mdi-plus ml-1"></i>
            </a>
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
                position: 'top-end',
                iconColor: 'white',
                showConfirmButton: false,
                timer: 3000,
                showCloseButton: true,
                customClass: {
                    popup: 'colored-toast',
                    container: 'toast-container',
                },
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
                position: 'top-end',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast',
                    container: 'toast-container',
                },
                showConfirmButton: false,
                timer: 3000,
                showCloseButton: true,
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
                    text: "Remove admin from list",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
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

            $('#admin_create').click(function() {
                show();
                createForm(2);
            });

            $('#create_btn').click(function() {
                $.ajax({
                    url: "{{ route('admin.store') }}",
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "name": $('#name').val()
                    },
                    success: function(data) {
                        console.log(data);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        function show() {
            const addRoleForm = document.getElementById('addRoleForm');
            const overlay = document.querySelector('.overlay');
            addRoleForm.classList.add('active');
            overlay.style.display = 'block'; // Show the overlay
            addRoleForm.style.zIndex = '1700'; // Set a high z-index for the form
            document.body.style.overflowY = 'hidden';
        }

        function hide() {
            const addRoleForm = document.getElementById('addRoleForm');
            const overlay = document.querySelector('.overlay');
            addRoleForm.classList.remove('active');
            overlay.style.display = 'none'; // Hide the overlay
            addRoleForm.style.zIndex = '1700'; // Set a default z-index for the form
            document.body.style.overflowY = 'auto'; // Re-enable vertical scrolling
        }


        function hideForm() {
            const showRoleForm = document.getElementById('showRoleForm');
            const overlay = document.querySelector('.overlay');
            showRoleForm.classList.remove('active');
            overlay.style.display = 'none'; // Hide the overlay
            showRoleForm.style.zIndex = '1100'; // Set a default z-index for the form
            document.body.classList.remove('no-scroll');
            $('input[id^="epermission_"]').prop('checked', false);
            $('input[id^="permission_"]').prop('checked', false);
        }

        function close(event) {
            const showRoleForm = document.getElementById('showRoleForm');
            if (showRoleForm.classList.contains('active') && !showRoleForm.contains(event.target)) {
                hideForm();
            }

            const addRoleForm = document.getElementById('addRoleForm');
            if (addRoleForm.classList.contains('active') && !addRoleForm.contains(event.target)) {
                hide();
            }
        }

        document.addEventListener('mouseup', close);



        function showForm(id) {
            $('#editForm').attr('action', `/admin/${id}`);
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
                                    var checkboxId = 'permission_' + (
                                        permissionId.id - 1
                                    ); // Adjust the ID to match checkbox IDs
                                    $('#' + checkboxId).prop('checked', true);
                                    $('#epermission_' + permissionId.id).prop('checked',
                                        true);
                                });
                            });
                        });
                        // Show the edit modal
                        const addRoleForm = document.getElementById('showRoleForm');
                        const overlay = document.querySelector('.overlay');
                        addRoleForm.classList.add('active');
                        overlay.style.display = 'block'; // Show the overlay
                        addRoleForm.style.zIndex = '1500'; // Set a high z-index for the form
                        document.body.style.overflow = 'hidden';
                    } else {
                        console.log('Role Not Found');
                    }
                },
                error: function(error, xhr) {
                    console.log(error);
                    console.log("Failed to fetch permission details for editing.");
                }
            });
        }

        function createForm(id) {
            $('#createForm').attr('action', `/admin/${id}`);
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
                                    var checkboxId = 'apermission_' + (
                                        permissionId.id - 1
                                    ); // Adjust the ID to match checkbox IDs
                                    $('#' + checkboxId).prop('checked', true);
                                    $('#bpermission_' + permissionId.id).prop('checked',
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
        }

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
