@extends('layout.layout')

@section('head')
    <title>Permissions</title>

    <style>
        .btn-primary:hover {
            color: #fff !important;
            background-color: #56ca00 !important;
            border-color: #56ca00 !important;
        }

        td {
            padding: 30px !important;
        }

        thead {
            background: #58D68D;
        }

        th {
            color: #ECF0F1 !important;
            font-size: 15px !important;
        }

        td span.superadmin,
        .admin,
        .area,
        .household,
        .member {
            pointer-events: none;
            text-transform: capitalize !important;
        }

        button.btn.btn-primary.waves-effect.waves-light{
            border-color: #fff !important;
        }

        @media (max-width: 768px) {
            div.modal-footer {
                width: 110% !important;
                margin-top: 45px;
            }

            button.btn.btn-primary.waves-effect.waves-light,
            button.btn.btn-secondary.waves-effect.waves-light {
                font-size: x-small;
            }
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

    <!-- Modal for adding permission -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="permissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-sidebar" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionModalLabel">Add Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="closeAddModal()" aria-label="Close">
                        <span class="text-xl" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-4">
                            <input name="name" type="text" class="form-control" id="name" placeholder="" />
                            <label for="name">Permission Name<i class="text-danger">*</i></label>
                        </div>
                        <p for="">Assign Permission To:</p>
                        @foreach ($roles as $role)
                            <div class="form-check form-switch mb-2">
                                <input value="{{ $role->id }}" class="form-check-input form-control" name="roles[]"
                                    type="checkbox" id="role_{{ $role->id }}" />
                                <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        @endforeach
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Close</button>
                            <button type="submit" class="btn btn-primary" style="background: #1b661b;">Save
                                changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing permission -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="permissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionModalLabel">Edit Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="closeEditModal()"
                        aria-label="Close">
                        <span class="text-xl" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updatePermissionForm" action="">
                        @csrf
                        @method('PUT')
                        <div class="form-floating form-floating-outline mb-4">
                            <input name="name" type="text" class="form-control" id="name" placeholder="" />
                            <label for="name">Permission Name<i class="text-danger">*</i></label>
                        </div>
                        <p for="">Assign Permission To:</p>
                        @foreach ($roles as $role)
                            <div class="form-check form-switch mb-2">
                                <input value="{{ $role->id }}" class="form-check-input form-control" name="roles[]"
                                    type="checkbox" id="erole_{{ $role->id }}" />
                                <label class="form-check-label" for="erole_{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        @endforeach
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Close</button>
                            <button type="submit" class="btn btn-primary editPermissionBtn" style="background: #1b661b;"
                                {{-- data-permission-id="{{ $id }}"> --}}>
                                Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Permissions List</h4>
        </div>
        <div class="flex justify-end mb-4">
            <a href="#" id="addPermissionBtn" class="btn btn-success">Add Permissions<i
                    class="tf-icons mdi mdi-plus ml-1"></i></a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive-lg text-nowrap">
                    <table class="table table-striped data-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Permissions</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function closeAddModal() {
            $('#addModal').modal('hide');
        }

        $('#addModal').on('hidden.bs.modal', function() {
            $(this).find('input[type="checkbox"]').prop('checked', false); // Uncheck all checkboxes
            $(this).find('input[type="text"]').val('');
        });
        // Add a function to show the modal for adding/editing permissions
        function openAddModal(permissionId = null) {
            // Logic to fetch data for editing if permissionId is provided

            // Show the modal
            $('#addModal').modal('show');
        }

        // Call the function to open the modal when clicking the "Add Role" button
        $('#addPermissionBtn').on('click', function() {
            openAddModal();
        });

        $('#addModal').on('show.bs.modal', function(e) {
            $(this).addClass('show');
        });



        //-------------------edit permissions--------------------------------

        function closeEditModal() {
            $('#editModal').modal('hide');
        }

        $('#editModal').on('hidden.bs.modal', function() {
            $(this).find('input[type="checkbox"]').prop('checked', false); // Uncheck all checkboxes
            $(this).find('input[type="text"]').val('');
        });

        // Add a function to show the modal for adding/editing permissions
        function editPermission(id) {
            $('#updatePermissionForm').attr('action', `/permissions/${id}`);
            $.ajax({
                url: 'permissions/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    var permission = response.permission;
                    var roles = response.roles;
                    // Populate form fields in the edit modal with permission details
                    $('#editModal input[name="name"]').val(permission.name);

                    $(document).ready(function() {
                        // Sample condition: preselect checkboxes for roles with IDs 1 and 3
                        var roles = response.roles;

                        roles.forEach(function(roleId) {
                            $('#erole_' + roleId).prop('checked', true);
                        });
                    });
                    // Show the edit modal
                    $('#editModal').modal('show');
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
                    name: 'id',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'roles',
                    name: 'roles',
                },
                {
                    data: 'actions',
                    name: 'actions'
                },
            ];

            let table = $('.data-table').DataTable({
                processing: true,
                pageLength: 25,
                responsive: true,
                serverSide: true,
                searchable: true,
                scrollY: 600,
                ajax: {
                    url: "{{ route('permissions.index') }}"
                },
                columns: columns,
                columnDefs: [{
                    targets: 3, // Index of the column you want to disable sorting for
                    orderable: false
                }],
                order: [
                    [0, 'asc'] // Sort by the first column (index 0) in descending order
                ]
            });


            $(document).on("click", ".remove-btn", function(e) {
                let id = $(this).attr("id");

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
                            url: "{{ route('permissions.destroy', ['permission' => 'id']) }}",
                            method: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire('Removed!', response.message, 'success').then(
                                        result => {
                                            if (result.isConfirmed) {
                                                toastr.success(response.message, 'Success');
                                                location.reload();
                                            }
                                        })
                                }
                            }
                        })
                    }
                })
            });
        }

        loadTable();
    </script>
@endpush
