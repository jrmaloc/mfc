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
        #editRoleForm {
            position: absolute;
            width: 33%;
            height: 100%;
            background: #fff;
            right: -80%;
            top: 0;
            transition: 0.4s ease-out;
        }

        #addRoleForm.active,
        #editRoleForm.active {
            right: 0;
        }

        #addRoleForm.disabled,
        #editRoleForm.disabled {
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

        i.fa.fa-xmark.fa-2x {
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

        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-4">Role Management</h4>
        </div>

        <div id="editRoleForm" class="card">
            <div class="flex justify-between px-12 py-6" style="background: #1b661b;">
                <h2 class="fw-bold pt-4 text-white">
                    Role Details
                </h2>
                <a href="javascript:void(0);" onclick="hideForm()" class="btn"><i class=" fa fa-xmark fa-2x"></i></a>
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
        function show() {
            const addRoleForm = document.getElementById('addRoleForm');
            const overlay = document.querySelector('.overlay');
            addRoleForm.classList.add('active');
            overlay.style.display = 'block'; // Show the overlay
            addRoleForm.style.zIndex = '1500'; // Set a high z-index for the form
            document.body.style.overflowY = 'hidden';
        }

        function hide() {
            const addRoleForm = document.getElementById('addRoleForm');
            const overlay = document.querySelector('.overlay');
            addRoleForm.classList.remove('active');
            overlay.style.display = 'none'; // Hide the overlay
            addRoleForm.style.zIndex = '1100'; // Set a default z-index for the form
            document.body.classList.remove('no-scroll');
        }

        function close(event) {
            const addRoleForm = document.getElementById('addRoleForm');
            const editRoleForm = document.getElementById('editRoleForm');
            if (editRoleForm.classList.contains('active') && !editRoleForm.contains(event.target)) {
                hideForm();
            }
        }

        document.addEventListener('mouseup', close);


        function showForm(id) {
            $('#editForm').attr('action', `/roles/${id}`);
            $.ajax({
                url: `roles/` + id + `/edit`,
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

                            // permissions.forEach(function(permissionId) {
                            //     var checkboxId = 'permission_' + (permissionId -
                            //         1); // Adjust the ID to match checkbox IDs
                            //     $('#' + checkboxId).prop('checked', true);
                            //     $('#epermission_' + permissionId).prop('checked', true);
                            // });
                        });
                        // Show the edit modal
                        const addRoleForm = document.getElementById('editRoleForm');
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

        function hideForm() {
            const addRoleForm = document.getElementById('editRoleForm');
            const overlay = document.querySelector('.overlay');
            addRoleForm.classList.remove('active');
            overlay.style.display = 'none'; // Hide the overlay
            addRoleForm.style.zIndex = '1100'; // Set a default z-index for the form
            document.body.classList.remove('no-scroll');
            $('input[id^="epermission_"]').prop('checked', false);
            $('input[id^="permission_"]').prop('checked', false);
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
                    url: "{{ route('roles.index') }}"
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
