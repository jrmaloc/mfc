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
    <!-- Attendee Modal -->
    <div class="offcanvas offcanvas-end w-75" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
        <div class="flex justify-between px-12 py-6" style="background: #1b661b;">
            <h2 class="fw-bold pt-4 text-white" id="title">
                Attendees
            </h2>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <div class="table-responsive-lg text-nowrap">
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
            {{ auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Area Servant') ? 'true' : 'false' }};

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

        document.addEventListener("DOMContentLoaded", function() {
            var attendeesTable;

            $(document).on('click', '.attendees', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                // Trigger the AJAX call to fetch attendees
                $.ajax({
                    url: `/attendees/${id}`,
                    method: 'GET',
                    success: function(response) {
                        if (response && response.data) {
                            if (response.data.length > 0) {
                                response.data.forEach(activity => {
                                    $('#title').text(activity.title);
                                    populateAttendeesTable(activity.registrations);
                                });
                            } else {
                                populateAttendeesTable(response.data);
                                $('#title').text('No Attendees Yet');
                            }
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


                if (!attendeesTable) {
                    attendeesTable = $('#attendeesTable').DataTable({
                        processing: true,
                        serverSide: false,
                        scrollX: 700,
                        scrollY: 550,
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
                                name: 'paid',
                                width: '20%',
                                render: function(data, type, full, meta) {
                                    let rowIndex = meta.row;
                                    let colIndex = meta.col;

                                    let uniqueId = 'checkbox_' + rowIndex + '_' + colIndex;
                                    let value = full.number;

                                    if (data == 'Pending') {
                                        let checkbox = '<div class="flex justify-center">';
                                        checkbox += '<input type="checkbox" id="' + uniqueId +
                                            '" value="' + value +
                                            '" class="activity-checkbox"' +
                                            ' style="pointer-events: pointer;">' +
                                            '<label for="' + uniqueId +
                                            '"></label>';
                                        checkbox += '</div>';

                                        return checkbox;
                                    } else {
                                        let checkbox = '<div class="flex justify-center">';
                                        checkbox += '<input type="checkbox" id="' + uniqueId +
                                            '" value="' + value +
                                            '" class="activity-checkbox"' +
                                            ' style="pointer-events: pointer;" checked>' +
                                            '<label for="' + uniqueId +
                                            '"></label>';
                                        checkbox += '</div>';

                                        return checkbox;
                                    }

                                }
                            }
                            // Define other columns as needed
                        ],
                        order: [
                            [0, 'desc'] // Sort by the first column (index 0) in descending order
                        ]
                    });
                } else {
                    attendeesTable.clear().rows.add(dataTableData).draw();
                }
            }
        });

        $('#attendeesTable').on('change', '.activity-checkbox', function() {
            let status = this.checked;
            let id = $(this).attr('value');

            $.ajax({
                url: "{{ route('registration.update', ['registration' =>" + id + " ]) }}",
                method: "PUT",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                },
                success: function(data) {
                    var Toast = Swal.mixin({
                        toast: true,
                        animation: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });

                    Toast.fire({
                        icon: 'success',
                        title: data.message,
                    });
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            })
        })


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
