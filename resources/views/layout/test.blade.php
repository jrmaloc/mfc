<li class="nav-item dropdown-notifications navbar-dropdown dropdown">
    <a class="nav-link btn rounded-pill btn-icon dropdown-toggle hide-arrow" href="javascript:void(0);"
        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true" style="background-color: #EBEDEF;">
        <i class="mdi mdi-bell-outline mdi-24px"></i>
        @if ($unreadNotificationsCount)
            <span class="notification-badge"></span>
        @endif
    </a>
    {{-- Notifications --}}
    <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
        style="border-radius: 10px 0px 10px 0px; max-height: 500px;">
        <li class="dropdown-menu-header border-bottom" id="markAllAsRead">
            <div class="dropdown-header d-flex align-items-center py-3 flex justify-around">
                <h6 class="fw-normal mb-0 me-auto">Notifications</h6>
                @if ($unreadNotificationsCount)
                    <a href="javascript:void(0);" id="mark-all"
                        class="text-slate-400 hover:underline hover:text-slate-500">
                        Mark all as read
                    </a>
                @endif
            </div>
        </li>

        @forelse ($unreadNotifications as $notification)
            <li id="notification">
                <ul class="list-group list-group-flush" style="width: 500px; ">
                    <li class="notify list-group-item list-group-item-action dropdown-notifications-item" sty>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ $notification->data['url'] }}" data-id="{{ $notification->id }}"
                                class="d-flex admin_notification flex-column flex-grow-1 overflow-hidden w-px-250">
                                <h6 class="mb-1 text-truncate">
                                    @if ($notification->type === 'App\Notifications\TitheNotification')
                                        <strong><span>₱ </span></strong>
                                    @endif
                                    <strong>{{ $notification->data['name'] }}</strong>
                                    <p class="mt-2 overflow-hidden overflow-ellipsis">
                                        {{ $notification->data['message'] }}</p>
                                </h6>
                                <!-- You can access other notification data similarly -->
                                <small
                                    class="text-truncate text-body">{{ $notification->created_at->diffForHumans() }}</small>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
        @empty
            <li class="dropdown-notifications-list scrollable-container">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action dropdown-notifications-item waves-effect"
                        style="pointer-events: none;">
                        <div class="d-flex align-items-center gap-2">
                            <div class=" overflow-hidden w-px-250 flex flex-col align-items-center text-center">
                                <i class="fa-solid fa-bell-slash fa-3x text-slate-300 my-3"></i>
                                <span class="text-sm font-bold my-1">No new
                                    notifications
                                    yet.</span>
                                <span class="text-sm font-normal">When you get new
                                    notifications, they'll show up here</span>
                            </div>
                        </div>
                    </li>
                    <div class="dropdown-menu-footer border-top p-3">
                        <a href="javascript:void(0);"
                            class="btn btn-primary d-flex justify-content-center waves-effect waves-divght"
                            id="refresh-btn">
                            Refresh
                        </a>
                    </div>
                </ul>
            </li>
        @endforelse
    </ul>
    {{-- /Notifications --}}
</li>
