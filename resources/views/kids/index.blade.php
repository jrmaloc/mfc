@extends('layout.layout')

@section('head')
    <title>Members</title>

    <style>
        p.alert-warning {
            padding-top: 0.15rem;
            padding-bottom: 0.15rem;
            margin-top: 1rem;
            text-align: center;
        }

        p.alert-success {
            padding-top: 0.15rem;
            padding-bottom: 0.15rem;
            margin-top: 1rem;
            text-align: center;
        }

        .dataTables_scrollHead {
            margin-top: 10px;
            background-color: #9056fcff
        }

        td.dataTables_empty {
            display: block;
            width: 590%;
        }

        th.sorting {
            width: 100px;
            color: #fafafa;
        }

        th {
            font-size: 15px !important;
        }

        .dot {
            height: 10px;
            width: 10px;
            background-color: #44c179;
            border-radius: 50%;
            display: inline-block;
        }

        .wdot {
            height: 10px;
            width: 10px;
            background-color: #ecb534;
            border-radius: 50%;
            display: inline-block;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="align-items-center">
            <h4 id="nb" class="fw-bold pt-3">Kids Members List</h4>
        </div>
        <div class="flex justify-end mb-4">
            @can('view-role')
                <a href="{{ route('kids.create') }}" class="btn btn-primary">
                    Add a User
                    <i class="tf-icons mdi mdi-plus ml-1"></i>
                </a>
            @endcan
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive-lg text-nowrap">
                    <table class="table table-striped data-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Area</th>
                                <th>Chapter</th>
                                <!-- <th>Household Servant</th> -->
                                <th>Gender</th>
                                <th>Status</th>
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
        function loadTable() {
            let columns = [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'contact_number',
                    name: 'contact_number'
                },
                {
                    data: 'area',
                    name: 'area'
                },
                {
                    data: 'chapter',
                    name: 'chapter'
                },
                // {
                //     data: 'household_servant',
                //     name: 'household_servant'
                // },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        var btn = '';
                        if (data == 'Active') {
                            btn += '<div><span class="dot mt-1 mr-2"></span>' + data + '</div>'
                        } else {
                            btn += '<div><span class="wdot mt-1 mr-2"></span>' + data + '</div>'
                        }

                        return btn;
                    }
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
                scrollX: 460,
                scrollY: 500,
                ajax: {
                    url: "{{ route('kids.index') }}"
                },
                columns: columns,
                columnDefs: [{
                    targets: 8, // Index of the column you want to disable sorting for
                    orderable: false
                }],
                order: [
                    [0, 'desc'] // Sort by the first column (index 0) in descending order
                ]
            });


            $(document).on("click", ".remove-btn", function(e) {
                let id = $(this).attr("id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Remove user from list",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('kids.destroy', ['kid' => ':id']) }}".replace(':id', id),
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
