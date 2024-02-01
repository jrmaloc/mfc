@extends('layout.layout')

@section('head')
    <title>Activities</title>

    <style>
        /* Add similar styles for other columns as needed */

        td {
            max-width: 500px;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #attendeesForm {
            position: absolute;
            width: 85%;
            height: 100%;
            background: #fff;
            right: -100%;
            top: 0;
            transition: 0.4s ease-out;
        }

        #attendeesForm.active {
            right: 0;
        }

        #attendeesForm.disabled {
            right: -100%;
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

        .bg-label-success {
            background-color: #1aa142 !important;
            color: #ffffff !important;
        }
    </style>
@endsection

@section('content')
    <!-- Attendee Modal -->
    <div id="attendeesForm" class="card">
        <div class="flex justify-between px-12 py-6" style="background: #1b661b;">
            <h2 class="fw-bold pt-4 text-white">
                Attendees
            </h2>
            <a href="javascript:void(0);" onclick="hide()" class="btn text-white"><i class="fa fa-xmark fa-2x"></i></a>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="attendeesTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Area</th>
                        <th>Chapter</th>
                        <th>Status</th>
                        <!-- Add other columns as needed -->
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- -------------------------------------------------------------------------------------------------------------------- -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-4">Activity/Events List</h4>
            <a href="{{ route('calendar.list') }}" class="btn btn-success">Go To Calendar<i
                    class="tf-icons mdi mdi-calendar ml-2"></i></a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive-lg text-nowrap">
                    <table class="table table-striped data-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th class="description-column">Description</th>
                                <th>Location</th>
                                <th>Event Start</th>
                                <th>Event End</th>
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
        const isVisible =
            {{ auth()->user()->hasRole('Admin') ||auth()->user()->hasRole('Super Admin') ||auth()->user()->hasRole('Area Servant')? 'true': 'false' }};

        function loadTable() {
            let table = $('.data-table').DataTable({
                processing: true,
                pageLength: 25,
                responsive: true,
                serverSide: true,
                scrollX: 200,
                scrollY: 500,
                ajax: {
                    url: "{{ route('activity.list') }}"
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title',
                    },
                    {
                        data: 'description',
                        name: 'description',
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        visible: isVisible,
                    },
                ],
                columnDefs: [{
                    targets: [2, 3], // Index of the column you want to disable sorting for
                    width: '30%',

                }],
                order: [
                    [0, 'desc'] // Sort by the first column (index 0) in descending order
                ]
            });
        }

        function show() {
            const showForm = document.getElementById('attendeesForm');
            const overlay = document.querySelector('.overlay');
            showForm.classList.add('active');
            overlay.style.display = 'block'; // Show the overlay
            showForm.style.zIndex = '1500'; // Set a high z-index for the form
            document.body.style.overflowY = 'hidden';
        }

        function hide() {
            const hideForm = document.getElementById('attendeesForm');
            const overlay = document.querySelector('.overlay');
            hideForm.classList.remove('active');
            overlay.style.display = 'none'; // Hide the overlay
            hideForm.style.zIndex = '1100'; // Set a default z-index for the form
            document.body.classList.remove('no-scroll');
            $('#attendeesTable').DataTable().destroy();
        }

        function remove(event) {
            const addRoleForm = document.getElementById('attendeesForm');
            if (addRoleForm.classList.contains('active') && !addRoleForm.contains(event.target)) {
                hide();
            }
        }

        document.addEventListener('mouseup', remove);

        document.addEventListener("DOMContentLoaded", function() {
            $(document).on('click', '.attendees', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                // Trigger the AJAX call to fetch attendees
                $.ajax({
                    url: `/attendees/${id}`,
                    method: 'GET',
                    success: function(response) {
                        if (response && response.data) {
                            populateAttendeesTable(response.data); // Assuming 'data' is the property containing the attendee information
                        } else {
                            console.error('Unexpected response format:', response);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching attendees:', error);
                    }
                });
            });



            // Function to populate DataTable with attendee data
            function populateAttendeesTable(data) {
                const dataTableData = data.map(item => {
                    return {
                        name: item.user.name,
                        email: item.user.email,
                        contact_number: item.user.contact_number,
                        area: item.user.area,
                        chapter: item.user.chapter,
                        paid: item.paid,
                        number: item.id
                        // Add other fields as needed
                    };
                });

                $('#attendeesTable').DataTable({
                    processing: true,
                    serverSide: false,
                    scrollX: 700,
                    scrollY: 800,
                    data: dataTableData,
                    columns: [{
                            data: 'number',
                            name: 'No.',
                            width: '5%',
                        },
                        {
                            data: 'name',
                            name: 'name',
                            width: '25%'
                        },
                        {
                            data: 'email',
                            name: 'email',
                            width: '25%'
                        },
                        {
                            data: 'contact_number',
                            name: 'contact_number',
                            width: '15%',
                        },
                        {
                            data: 'area',
                            name: 'area',
                            width: '20%',
                        },
                        {
                            data: 'chapter',
                            name: 'chapter',
                            width: '20%',
                        },
                        {
                            data: 'paid',
                            name: 'status',
                            width: '20%',
                            render: function(data, type, row) {
                                let badgeHTML = '';

                                if (data === 'Paid') {
                                    badgeHTML =
                                        '<div class= "flex justify-center"><span class="badge rounded-pill bg-label-success px-4 py-2">' +
                                        data + '</span></div>';
                                } else {
                                    badgeHTML =
                                        '<div class= "flex justify-center"><span class="badge rounded-pill bg-label-warning px-4 py-2">' +
                                        data + '</span></div>';
                                }

                                return badgeHTML;
                            },
                        }
                        // Define other columns as needed
                    ],
                    order: [
                        [0, 'desc'] // Sort by the first column (index 0) in descending order
                    ]
                });
            }
        });


        $(document).on("click", ".remove-btn", function(e) {
            let id = $(this).attr("id");

            Swal.fire({
                title: 'Are you sure?',
                text: "Remove event from list",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/calendar/destroy` + '/' + id,
                        method: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status) {
                                Swal.fire('Event Removed!', response.message, 'success').then(
                                    result => {
                                        if (result.isConfirmed) {
                                            toastr.success(response.message, 'Success');
                                            window.location.reload();
                                        }
                                    })
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                }
            })
        });



        loadTable();
    </script>
@endpush
