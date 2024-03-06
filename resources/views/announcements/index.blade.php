@extends('layout.layout')

@section('head')
    <title>Announcements</title>
    <style>
        th {
            color: #ECF0F1 !important;
            font-size: 15px !important;
        }

        td:nth-child(2) {
            width: 60%;
            max-width: 60%;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        td:nth-child(3) {
            width: 20%;
            max-width: 20%;
        }

        #addForm,
        #show,
        #edit {
            position: absolute;
            width: 33%;
            height: 100%;
            background: #fff;
            right: -80%;
            top: 0;
            transition: 0.4s ease-out;
        }

        #addForm.active,
        #show.active,
        #edit.active {
            right: 0;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Adjust opacity as needed */
            backdrop-filter: blur(5px);
            /* Apply the blur effect */
            z-index: 1100;
            /* Ensure it's above other content */
            display: none;
            /* Initially hide it */
        }

        div.swal2-container.swal2-top-right.swal2-backdrop-show {
            z-index: 9999 !important;
        }

        .textarea-input {
            display: block;
            width: 100%;
            height: 200%;
            padding: 8px;
            box-sizing: border-box;
            resize: both;
            /* Allow vertical resizing */
        }

        input[type=checkbox] {
            display: none;
        }

        .activity-checkbox+label {
            font-size: 1.2rem;
            width: 2rem;
            height: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            border: .1rem solid var(--blue);
            border-radius: 50%;
            background: var(--darkblue);
            transition: .1s all;
            cursor: pointer;
            z-index: 999 !important;
        }

        .admin {
            pointer-events: none !important;
        }

        .activity-checkbox+label:hover {
            transform: scale(.95);
        }

        .activity-checkbox+label:after {
            content: "⚪";
        }

        .activity-checkbox:checked+label {
            background: var(--blue);
            transform: scale(1.1);
        }

        .activity-checkbox:checked+label:hover {
            background: var(--blue);
            transform: scale(1.05);
        }

        .activity-checkbox:checked+label:after {
            content: "✔️";
        }
    </style>
@endsection

@section('content')
    @if ($errors->any())
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
                title: 'Update Failed',
            });
        </script>
    @endif


    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-start align-items-center">
            <style>
                @media(max-width:780px) {
                    h4#nb {
                        font-size: 1.50rem;
                    }

                    button.btn.btn-primary.mt-4,
                    button.btn.btn-primary.mt-4~span {
                        font-size: 0.75rem;
                    }

                    div#DataTables_Table_0_length {
                        display: flex;
                        justify-content: flex-start;
                        margin-bottom: 20px;
                    }

                    div#DataTables_Table_0_filter {
                        display: flex;
                        justify-content: flex-end;
                    }

                    ul.pagination {
                        margin-bottom: 20px !important;
                    }
                }
            </style>
            <h4 id="nb" class="fw-bold pt-3 ml-2">Notice Board</h4>
        </div>
        <div class="d-flex justify-end mb-2">
            @can('view-member')
                <button class="btn btn-primary mt-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd"
                    aria-controls="offcanvasEnd">
                    Create an Announcement <span class="mdi mdi-plus ml-1"></span>
                </button>
            @endcan
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive-lg text-nowrap">
                    <table class="table table-striped data-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create -->
        <div class="col-lg-3 col-md-2" id="createForm">
            <div class="mt-3">
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
                    <style>
                        .offcanvas-header {
                            align-items: flex-start;
                        }

                        @media(max-width: 768px) {
                            div#offcanvasEnd {
                                width: 80%;
                            }

                            button.btn.btn-success {
                                font-size: xx-small;
                            }

                            button.btn.btn-outline-info {
                                font-size: x-small;
                            }
                        }
                    </style>
                    <div class="offcanvas-header">
                        <h5 id="offcanvasEndLabel" class="offcanvas-title fw-bold text-2xl pt-4">Create Announcement</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body mx-0 flex-grow-0">
                        <form id="createForm" action="{{ route('announcements.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-floating form-floating-outline mt-3">
                                        <input name="title" type="text" class="form-control addInput" id="title"
                                            placeholder="Title of your Announcement" required>
                                        <label for="title">Title<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <textarea id="details" name="description" class="form-control addTextArea" placeholder="Details of your Announcement"
                                            style="height: 300px" required></textarea>
                                        <label for="details">Details<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <p>
                                        <span>Send To:<span class="text-danger">*</span></span>
                                    </p>
                                    <div class="flex">
                                        <input type="checkbox" class="activity-checkbox" value="3" id="areaCheckbox"
                                            name="areaCheckbox">
                                        <label for="areaCheckbox"></label>
                                        <p class="mb-0 flex align-items-center">Area Servants</p>
                                    </div>
                                    <div class="flex">
                                        <input type="checkbox" class="activity-checkbox" value="4" id="chapterCheckbox"
                                            name="chapterCheckbox">
                                        <label for="chapterCheckbox"></label>
                                        <p class="mb-0 flex align-items-center">Chapter Servants</p>
                                    </div>
                                    <div class="flex">
                                        <input type="checkbox" class="activity-checkbox" value="5" id="unitCheckbox"
                                            name="unitCheckbox">
                                        <label for="unitCheckbox"></label>
                                        <p class="mb-0 flex align-items-center">Unit Servants</p>
                                    </div>
                                    <div class="flex">
                                        <input type="checkbox" class="activity-checkbox" value="6"
                                            id="householdCheckbox" name="householdCheckbox">
                                        <label for="householdCheckbox"></label>
                                        <p class="mb-0 flex align-items-center">Household Servants</p>
                                    </div>
                                    <div class="flex">
                                        <input type="checkbox" class="activity-checkbox" value="7" id="memberCheckbox"
                                            name="memberCheckbox">
                                        <label for="memberCheckbox"></label>
                                        <p class="mb-0 flex align-items-center">Members</p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12 col-sm-12 col-md-12 text-center flex justify-end gap-2 my-4 pb-4">
                                <button type="reset" class="btn btn-outline-info">Reset</button>
                                <button type="button" id="create_btn" class="btn btn-success createBtn">Create
                                    Announcement</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit -->
        <div class="col-lg-3 col-md-6">
            <div class="mt-3">
                <div class="offcanvas offcanvas-end" tabindex="-1" id="editForm" aria-labelledby="offcanvasEndLabel"
                    style="width: 25%;">
                    <div class="offcanvas-header">
                        <h5 id="offcanvasEndLabel" class="offcanvas-title fw-bold text-2xl pt-4">Edit Announcement</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>

                    <div class="offcanvas-body mx-0 flex-grow-0">
                        <form id="editForm" action="" method="PUT">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-floating form-floating-outline mt-3">
                                        <input name="title" type="text" class="form-control" value=""
                                            id="edittitle" value="" placeholder="Title of your Announcement"
                                            required>
                                        <label for="edittitle">Title<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <textarea id="editdescription" name="description" class="form-control" placeholder="Details of your Announcement"
                                            style="height: 300px" required></textarea>
                                        <label for="editdescription">Details<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 text-center flex justify-end gap-2 my-4 pb-4">
                                <button type="reset" class="btn btn-outline-info">Reset</button>
                                <button type="submit" class="save-btn btn btn-success">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                icon: 'success',
                title: '{{ session('success') }}',
            });
        </script>
    @endif
@endsection

@push('scripts')
    <script>
        function clearInputFields() {
            var inputFields = document.querySelector('.addInput');
            inputFields.value = '';
        }

        function clearTextAreaFields() {
            var textAreas = document.querySelectorAll('.addTextArea');
            textAreas.value = '';
        }

        $(document).on("click", ".edit-btn", function(e) {
            var id = $(this).attr('id');

            $.ajax({
                url: '{{ route('announcements.edit', ['announcement' => ':id']) }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    // Update the form fields with fetched data
                    $('#edittitle').attr('value', response.title);
                    var textarea = document.getElementById('editdescription');
                    textarea.defaultValue = response.description;
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });

            $('.save-btn').click(function(e) {
                $.ajax({
                    url: '{{ route('announcements.update', ['announcement' => ':id']) }}'.replace(
                        ':id', id),
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        request: 'index',
                        title: $('#edittitle').val(),
                        description: $('#editdescription').val()
                    },
                    success: function(response) {

                        // $('#editForm').offcanvas('hide');
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
                            title: response.success,
                        });

                        setTimeout(function(e){
                            location.reload();
                        },2000);
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                })
            });
        });

        var Toast = Swal.mixin({
            toast: true,
            title: 'General Title',
            animation: true,
            position: 'top-right',
            showConfirmButton: false,
        });

        $(document).ready(function() {
            $('#create_btn').click(function() {

                var selectedValues = $('.activity-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                $.ajax({
                    url: "{{ route('announcements.store') }}",
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "title": $('#title').val(),
                        "description": $('#details').val(),
                        "user_ids": selectedValues,
                    },
                    success: function(data) {
                        Toast.fire({
                            icon: "success",
                            timer: 3000,
                            title: "Announcement Created Successfully. Reloading...",
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        Toast.fire({
                            icon: "error",
                            timer: 200000,
                            title: "Failed to create announcement",
                        });
                    }
                });
            });
        });

        function loadTable() {
            let columns = [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title',
                    width: '70%'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        // Format the 'created_at' date using moment.js or any other library
                        if (type === 'display' && data !== null) {
                            return moment(data).format('MM-DD-YYYY'); // Replace with your desired format
                        }
                        return data; // Return the original data for sorting and other types
                    }
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
                scrollX: 460,
                scrollY: 460,
                ajax: {
                    url: "{{ route('announcements.index') }}"
                },
                columns: columns,
                order: [
                    [0, 'asc'] // Sort by the first column (index 0) in descending order
                ]
            });



            $(document).on("click", ".remove-btn", function(e) {
                let id = $(this).attr("id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Remove announcement from list",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'announcements/' + id, // Update the URL to match your route
                            method: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire('Removed!', response.message, 'success').then(
                                        result => {
                                            if (result.isConfirmed) {
                                                toastr.success(response.message, 'Success');
                                                location.reload();
                                            }
                                        });
                                }
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    }
                });
            });
        }

        loadTable();
    </script>
@endpush
