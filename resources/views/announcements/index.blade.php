@extends('layout.layout')

@section('head')
    <title>Announcements</title>
    <style>
        thead {
            background: #58D68D;
        }

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
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="fw-bold py-3 mb-4 ml-2">Notice Board</h3>
            @can('view-member')
                <a href="#" onclick="add()" class="toggle-btn btn btn-primary mt-4">Create an Announcement
                    <span class="mdi mdi-plus"></span></a>
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
        <div id="addForm" class="card">
            <div class="flex justify-between align-items-center px-12 py-6">
                <h3 class="fw-bold pt-4">
                    Create Announcement
                </h3>
                <a href="javascript:void(0);" onclick="hide()" class="btn"><i class=" fa fa-xmark"
                        style="font-size: 23px;"></i></a>
            </div>

            <div class="card-body">
                <form id="createForm" action="{{ route('announcements.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                            <div class="form-floating form-floating-outline mt-3">
                                <input name="title" type="text" class="form-control addInput" id="title"
                                    placeholder="Title of your Announcement">
                                <label for="title">Title</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <textarea id="details" name="description" class="form-control addTextArea" placeholder="Details of your Announcement"
                                    style="height: 300px"></textarea>
                                <label for="details">Details</label>
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

        <!-- Show -->
        <div id="show" class="card">
            <div class="flex justify-between align-items-center px-12 py-6">
                <h3 class="fw-bold pt-4">
                    Announcement Details
                </h3>
                <a href="javascript:void(0);" onclick="hide()" class="btn"><i class=" fa fa-xmark"
                        style="font-size: 23px;"></i></a>
            </div>

            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                            <div class="form-floating form-floating-outline mt-3">
                                <input name="title" type="text" class="form-control" id="showtitle" readonly
                                    placeholder="Title of your Announcement" style="border: none;">
                                <label for="showtitle">Title</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input id="showdescription" name="description" class="form-control"
                                    placeholder="Details of your Announcement" readonly style="border: none;"></input>
                                <label for="showdescription">Details</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit -->
        <div id="edit" class="card">
            <div class="flex justify-between align-items-center px-12 py-6">
                <h3 class="fw-bold pt-4">
                    Edit Announcement
                </h3>
                <a href="javascript:void(0);" onclick="hide()" class="btn"><i class=" fa fa-xmark"
                        style="font-size: 23px;"></i></a>
            </div>

            <div class="card-body">
                <form id="editForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                            <div class="form-floating form-floating-outline mt-3">
                                <input name="title" type="text" class="form-control" value="" id="edittitle"
                                    placeholder="Title of your Announcement">
                                <label for="edittitle">Title</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <textarea id="editdescription" name="description" class="form-control" placeholder="Details of your Announcement"
                                    style="height: 300px"></textarea>
                                <label for="editdescription">Details</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center flex justify-end gap-2 my-4 pb-4">
                        <button type="reset" class="btn btn-outline-info">Reset</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
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
            inputFields.forEach(function(input) {
                input.value = '';
            });
        }

        function clearTextAreaFields() {
            var textAreas = document.querySelectorAll('.addTextArea');
            textAreas.forEach(function(textarea) {
                textarea.value = '';
            });
        }

        function add() {
            const addRoleForm = document.getElementById('addForm');
            const overlay = document.querySelector('.overlay');
            addForm.classList.add('active');
            overlay.style.display = 'block'; // Show the overlay
            addForm.style.zIndex = '1500'; // Set a high z-index for the form
            document.body.style.overflowY = 'hidden';
            clearInputFields();
            clearTextAreaFields();
        }

        function close(event) {
            const overlay = document.querySelector('.overlay');
            const show = document.getElementById('show');
            const edit = document.getElementById('edit');
            const addForm = document.getElementById('addForm');
            if (show.classList.contains('active') && !show.contains(event.target)) {
                hide();
            }
            if (edit.classList.contains('active') && !edit.contains(event.target)) {
                hide();
            }
            if (addForm.classList.contains('active') && !addForm.contains(event.target)) {
                hide();
            }
        }

        document.addEventListener('mouseup', close);

        function hide() {
            const addForm = document.getElementById('addForm');
            const show = document.getElementById('show');
            const edit = document.getElementById('edit');
            const overlay = document.querySelector('.overlay');
            show.classList.remove('active');
            edit.classList.remove('active');
            addForm.classList.remove('active');
            overlay.style.display = 'none'; // Hide the overlay
            addForm.style.zIndex = '1500'; // Set a default z-index for the form
            edit.style.zIndex = '1500'; // Set a default z-index for the
            show.style.zIndex = '1500'; // Show the overlay
            document.body.classList.remove('no-scroll');
        }

        function show(id) {
            const show = document.getElementById('show');
            const overlay = document.querySelector('.overlay');
            show.classList.add('active');
            overlay.style.display = 'block'; // Show the overlay
            show.style.zIndex = '1500'; // Set a high z-index for the form
            document.body.style.overflowY = 'hidden';

            $.ajax({
                url: "/announcements/" + id, // Replace with your route for fetching announcement by ID
                type: "GET",
                success: function(response) {
                    // Update the form fields with fetched data
                    document.getElementById('showtitle').value = response.title;
                    document.getElementById('showdescription').value = response.description;
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        function edit(id) {
            const edit = document.getElementById('edit');
            const overlay = document.querySelector('.overlay');
            edit.classList.add('active');
            overlay.style.display = 'block'; // Show the overlay
            edit.style.zIndex = '1500'; // Set a high z-index for the form
            document.body.style.overflowY = 'hidden';

            $('#editForm').attr('action', `/announcements/${id}`);
            $.ajax({
                url: "/announcements/" + id + "/edit", // Replace with your route for fetching announcement by ID
                type: "GET",
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
        }

        var Toast = Swal.mixin({
            toast: true,
            title: 'General Title',
            animation: true,
            position: 'top-right',
            showConfirmButton: false,
        });

        $(document).ready(function() {
            $('#create_btn').click(function() {
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
                    },
                    success: function(data) {
                        hide();
                        Toast.fire({
                            icon: "success",
                            timer: 3000,
                            title: "Event Created Successfully. Reloading...",
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
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
                scrollX: false,
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

                console.log(id);

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
