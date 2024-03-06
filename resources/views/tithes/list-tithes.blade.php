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

    th {
        color: #ECF0F1 !important;
        font-size: 15px !important;
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center">
        <h2 id="nb" class="fw-bold py-3">Tithes and Offerings List</h2>
    </div>
    <div class="flex justify-end mb-4">
        <a href="{{route('tithes.create')}}" class="btn btn-primary">
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
                            <th>Date/Time</th>
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
            scrollY: 460,
            ajax: {
                url: "{{ route('tithes.list') }}"
            },
            columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'users',
                name: 'name',
                render: function(data, type, full, meta) {
                    return data ? data.name : '';
                }
            },
            {
                data: 'users',
                name: 'email',
                render: function(data, type, full, meta) {
                    return data ? data.email : '';
                }
            },
            {
                data: 'users',
                name: 'contact_number',
                render: function(data, type, full, meta) {
                    return data ? data.contact_number : '';
                }
            },
            {
                data: 'transaction_id',
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
            {
                data: 'created_at',
                name: 'created_at',
                render: function (data, type, row) {
                    // Parse the MySQL datetime format using Moment.js
                    var formattedDate = moment(data).format('YYYY-MM-DD HH:mm:ss');
                    return formattedDate;
                }
            }],

            order: [
                [0, 'desc'] // Sort by the first column (index 0) in descending order
            ]
        });
    }

    loadTable();
</script>
@endpush
