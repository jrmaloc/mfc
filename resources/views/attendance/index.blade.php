@extends('layout.layout')

@section('head')
    <title>Attendance</title>
    <style>
        th {
            color: #ECF0F1 !important;
            font-size: 15px !important;
        }

        label {
            margin: 10px 0 !important;
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

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:focus:not(:placeholder-shown)~label,
        .form-floating>.form-select:focus~label,
        .form-floating>.form-select:focus:not(:placeholder-shown)~label {
            color: #1b661bff;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-4">Attendance</h4>
            @if (auth()->check() &&
                    (auth()->user()->hasRole('Area Servant') ||
                        auth()->user()->hasRole('Chapter Servant') ||
                        auth()->user()->hasRole('Unit Servant') ||
                        auth()->user()->hasRole('Household Servant')))
                <button type="button" class="btn btn-success mt-20 mb-2" data-bs-toggle="modal" data-bs-target="#modalCenter">
                    Add a User
                    <i class="tf-icons mdi mdi-plus ml-1"></i>
                </button>
            @endif
        </div>

        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Members</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('attendance.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-4 mt-2">
                                    <label for="floatingSelect" class="h-0 ml-1">Name<span
                                            class="text-danger">*</span></label>
                                    <div class="form-floating form-floating-outline">
                                        <select name="id" class="form-select" id="floatingSelect" required>
                                            <option disabled selected>Choose one</option>

                                            @foreach ($options as $info)
                                                @if (auth()->check() && (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin')))
                                                    <option value="{{ $info->id }}">{{ $info->name }}</option>
                                                @else
                                                    <option value="{{ $info->id }}">{{ $info->user->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Add User!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive-lg text-nowrap">
                    <table class="table table-striped data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Member</th>
                                @foreach ($attendance as $data)
                                    <th>
                                        {{ $data->activity->title }}
                                    </th>
                                @endforeach
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
                width: '100%',
                scrollX: 700,
                scrollY: 700,
                ajax: "{{ route('attendance.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    // Add other common columns here
                    @foreach ($attendance as $data)
                        {
                            data: null,
                            name: '{{ $data->activity->title }}',
                            render: function(data, type, full, meta) {
                                let attendee_ids = '{!! html_entity_decode($data->attendee_ids) !!}' != "" ? JSON.parse(
                                    '{!! html_entity_decode($data->attendee_ids) !!}') : [];
                                let rowIndex = meta.row;
                                let colIndex = meta.col;

                                if ('{!! $roleId == 1 || $roleId == 2 !!}') {
                                    let isChecked = attendee_ids.includes(data.id.toString()) ?
                                        'checked' :
                                        '';
                                    let uniqueId = 'checkbox_' + rowIndex + '_' + colIndex + '_' + data.id;
                                    let checkbox = '<div class="flex justify-center">';
                                    checkbox += '<input type="checkbox" id="' + uniqueId +
                                        '" value="' + data.id +
                                        '" class="activity-checkbox admin" activity-id="' +
                                        {{ $data->activity->id }} + '" ' + isChecked +
                                        ' style="pointer-events: none;">' +
                                        '<label class="admin" for="' + uniqueId + '" disabled></label>';
                                    checkbox += '</div>';

                                    return checkbox;
                                } else {
                                    let isChecked = attendee_ids.includes(data.user.id.toString()) ?
                                        'checked' :
                                        '';
                                    let uniqueId = 'checkbox_' + rowIndex + '_' + colIndex + '_' + data.user
                                        .id;
                                    let checkbox = '<div class="flex justify-center">';
                                    checkbox += '<input type="checkbox" id="' + uniqueId +
                                        '" value="' + data.user.id +
                                        '" class="activity-checkbox" activity-id="' +
                                        {{ $data->activity->id }} + '" ' + isChecked +
                                        ' style="pointer-events: ;">' +
                                        '<label for="' + uniqueId + '"></label>';
                                    checkbox += '</div>';

                                    return checkbox;
                                }
                            }
                        },
                    @endforeach
                ],
            });

            $('.data-table').on('change', '.activity-checkbox', function() {
                let status = this.checked;
                let user_id = $(this).val();
                let activity_id = $(this).attr('activity-id');

                $.ajax({
                    url: "attendance/" + activity_id,
                    method: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        attendee_id: user_id,
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
                            title: 'Attendance Saved!',
                        });
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });
        }


        $(document).ready(function() {
            loadTable();
        });
    </script>
@endpush
