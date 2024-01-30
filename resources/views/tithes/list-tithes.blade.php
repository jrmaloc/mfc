@extends('layout.layout')

@section('head')
<title>Tithes and Offerings</title>

<style>
    td.dataTables_empty {
        display: block;
        width: 590%;
    }

    th.sorting {
        width: 100px;
    }

    thead {
        background: #58D68D;
    }

    th {
        color: #ECF0F1 !important;
        font-size: 15px !important;
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-4">Tithes and Offerings List</h4>
        <a href="{{route('tithes.create')}}" class="btn btn-success">
            Give Tithes
            <i class="tf-icons mdi mdi-plus ml-1"></i>
        </a>
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
                            <th>Transaction Number</th>
                            <th>Amount</th>
                            <!-- <th>Household Servant</th> -->
                            <th>Mode of Payment</th>
                            <th>Date/Time</th>
                            <!-- <th>Actions</th> -->
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
        let table = $('.data-table').DataTable({
            processing: true,
            pageLength: 25,
            responsive: true,
            serverSide: true,
            scrollX: true,
            scrollY: 700,
            ajax: {
                url: "{{ route('tithes.list') }}"
            },
            columns: [{
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
                data: 'transaction_number',
                name: 'transaction_number'
            },
            {
                data: 'amount',
                name: 'amount',
                render: function (data, type, row) {
                    return '₱' + parseFloat(data).toLocaleString(
                        'en-US'); // Add the pesos sign to the amount
                }
            },
            // {
            //     data: 'household_servant',
            //     name: 'household_servant'
            // },
            {
                data: 'mop',
                name: 'mop'
            },
            {
                data: 'created_at',
                name: 'created_at',
                render: function (data, type, row) {
                    // Parse the MySQL datetime format using Moment.js
                    var formattedDate = moment(data).format('YYYY-MM-DD HH:mm:ss');
                    return formattedDate;
                }
            },
                // {
                //     data: 'actions',
                //     name: 'actions'
                // },
            ],
            columnDefs: [{
                targets: 7, // Index of the column you want to disable sorting for
                orderable: false
            }],
            order: [
                [0, 'desc'] // Sort by the first column (index 0) in descending order
            ]
        });
    }

    $(document).on("click", ".remove-btn", function (e) {
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
                    url: `{{ route('member.destroy') }}`,
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function (response) {
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

    loadTable();
</script>
@endpush