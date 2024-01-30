@extends('layout.layout')

@section('head')
    <title>Notifications</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .mark-as-read,
        .mark-as-unread {
            display: flex !important;
            align-items: center !important;
        }

        a.member:hover,
        a.event:hover,
        a.announcement:hover,
        a.tithe:hover {
            cursor: pointer;
            transform: scale(1.015);
        }

        a.member:hover,
        a.mem:hover {
            color: #56ca00;
        }

        a.announcement:hover {
            color: #02A8FD;
        }

        a.tithe:hover {
            color: #ecb534;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="fw-bold py-3 mb-4 ml-2">My Notifications</h3>
        </div>

        <div class="card">
            <div class="card-body">
                <h5>Unread Notifications</h5>
                @forelse($unreadNotifications as $notification)
                    @if ($notification->type === 'App\Notifications\AnnouncementNotification')
                        <a href="/announcements" data-id="{{ $notification->id }}"
                            class="unread announcement alert alert-info flex justify-between">
                            <div class="text-info">
                                <strong>{{ $notification->data['name'] }}</strong> <br>
                                <small>A new Announcement is up!</small>
                            </div>
                            <div class="hover:underline mark-as-read" data-id="{{ $notification->id }}"
                                style="cursor: pointer;">
                                Mark as read
                            </div>
                        </a>
                    @elseif ($notification->type === 'App\Notifications\MemberNotification')
                        @if (auth()->check() &&
                                (auth()->user()->hasRole('Super Admin') ||
                                    auth()->user()->hasRole('Admin') ||
                                    auth()->user()->hasRole('Area Servant') ||
                                    auth()->user()->hasRole('Household Servant')))
                            <a href="/member/" class="unread alert alert-success member flex justify-between">
                                <div class="text-success">
                                    <strong>{{ $notification->data['name'] }}</strong> <br>
                                    <small>{{ $notification->data['message'] }}</small>
                                </div>
                                <div class="hover:underline mark-as-read" data-id="{{ $notification->id }}"
                                    style="cursor: pointer;">
                                    Mark as read
                                </div>
                            </a>
                        @endif

                        @if (auth()->check() &&
                                auth()->user()->hasRole('Member'))
                            <a href="/profile" class="unread alert alert-success mem flex justify-between">
                                <div class="text-success">
                                    <strong>{{ $notification->data['name'] }}</strong> <br>
                                    <small>{{ $notification->data['message'] }}</small>
                                </div>
                                <div class="hover:underline mark-as-read" data-id="{{ $notification->id }}"
                                    style="cursor: pointer;">
                                    Mark as read
                                </div>
                            </a>
                        @endif
                    @elseif ($notification->type === 'App\Notifications\EventNotification')
                        <a href="/calendar" data-id="{{ $notification->id }}"
                            class="unread alert event alert-primary flex justify-between">
                            <div class="text-primary">
                                <strong>{{ $notification->data['name'] }}</strong> <br>
                                <small>New Upcoming Event</small>
                            </div>
                            <div class="hover:underline mark-as-read" data-id="{{ $notification->id }}"
                                style="cursor: pointer;">
                                Mark as read
                            </div>
                        </a>
                    @elseif ($notification->type === 'App\Notifications\TitheNotification')
                        <a href="/tithes/list" data-id="{{ $notification->id }}"
                            class="unread alert tithe alert-warning flex justify-between">
                            <div class="text-warning">
                                <strong><span>₱</span>{{ $notification->data['name'] }}</strong> <br>
                                <small>New Tithe was registered!</small>
                            </div>
                            <div class="hover:underline mark-as-read" data-id="{{ $notification->id }}"
                                style="cursor: pointer;">
                                Mark as read
                            </div>
                        </a>
                    @elseif ($notification->type === 'App\Notifications\KidsNotification')
                        <a href="/tithes/list" data-id="{{ $notification->id }}"
                            class="unread alert tithe alert-warning flex justify-between">
                            <div class="text-warning">
                                <strong>{{ $notification->data['name'] }}</strong> <br>
                                <small>New Profile was registered!</small>
                            </div>
                            <div class="hover:underline mark-as-read" data-id="{{ $notification->id }}"
                                style="cursor: pointer;">
                                Mark as read
                            </div>
                        </a>
                    @endif

                    @if ($loop->last)
                        <span class="hover:underline mark-all" style="cursor: pointer;">
                            Mark all as read
                        </span>
                    @endif
                @empty
                    <p>No new notifications at the moment</p>
                @endforelse

            </div>
        </div>

        <div class=" card mt-4">
            <div class="card-body">
                <h5>Read Notifications</h5>
                @forelse($readNotifications as $notification)
                    <!-- Display read notifications here -->
                    <div class="alert alert-secondary flex justify-between">
                        <div>
                            <strong>{{ $notification->data['name'] }}</strong> <br>
                            <small>New Tithe was registered!</small>
                        </div>
                        <div class="hover:underline mark-as-unread flex align-center" data-id="{{ $notification->id }}"
                            style="cursor: pointer;">
                            Mark as unread
                        </div>
                    </div>
                @empty
                    <p>No read notifications</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function sendMarkRequest(id = null) {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            return $.ajax("{{ route('mark.notification') }}", {
                method: 'POST',
                data: {
                    _token: csrfToken,
                    id
                }
            });
        }

        function sendUnmarkRequest(id = null) {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            return $.ajax("{{ route('unmark.notification') }}", {
                method: 'POST',
                data: {
                    _token: csrfToken,
                    id
                }
            });
        }

        $(function() {
            $('.mark-as-read').click(function() {
                let request = sendMarkRequest($(this).data('id'));

                request.done(() => {
                    $(this).parents('div.alert').remove();
                    location.reload();
                });
            });

            $('.unread').click(function() {
                let request = sendMarkRequest($(this).data('id'));
            });

            $('.mark-as-unread').click(function() {
                let request = sendUnmarkRequest($(this).data('id'));

                request.done(() => {
                    $(this).parents('div.alert').remove();
                    location.reload();
                });
            });

            $('.mark-all').click(function() {
                let request = sendMarkRequest();

                request.done(() => {
                    $('div.alert').remove();
                    window.location.reload();
                })
            });
        });
    </script>
@endpush
