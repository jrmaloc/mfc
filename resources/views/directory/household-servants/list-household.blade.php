@extends('layout.layout')

@section('head')
<title>Household Servants</title>
<style>
    p.alert-warning {
        padding-top: 0.15rem;
        padding-bottom: 0.15rem;
        margin-top: 1rem;
        text-align: center;

    }

    thead {
        background: #58D68D;
    }

    th {
        color: #ECF0F1 !important;
        font-size: 15px !important;
    }

    p.alert-success {
        border-color: #56ca00;
        padding-top: 0.15rem;
        padding-bottom: 0.15rem;
        margin-top: 1rem;
        align-self: center;
        text-align: center;
    }

    td.dataTables_empty {
        display: block;
        width: 590%;
    }

    th.sorting {
        width: 100px;
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
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-4">Household Servants List</h4>
        <a href="{{route('household.create')}}" class="btn btn-success">Add Servant<i
                class="tf-icons mdi mdi-plus ml-1"></i></a>
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
                            <!-- <th>Area Servant</th> -->
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
        let table = $('.data-table').DataTable({
            processing: true,
            pageLength: 25,
            responsive: true,
            serverSide: true,
            scrollX: true,
            scrollY: 700,
            ajax: {
                url: "{{ route('household.list') }}"
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
                data: 'area',
                name: 'area'
            },
            {
                data: 'chapter',
                name: 'chapter'
            },
            // {
            //     data: 'area_servant',
            //     name: 'area_servant'
            // },
            {
                data: 'gender',
                name: 'gender'
            },
            {
                data: 'status',
                name: 'status',
                render: function (data) {
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
            ],
            columnDefs: [{
                targets: 8, // Index of the column you want to disable sorting for
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
                    url: `{{ route('household.destroy') }}`,
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