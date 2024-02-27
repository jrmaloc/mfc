<button class="ml-4 mr-2 my-auto" id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch"
    data-dropdown-offset-distance="-5" data-dropdown-placement="bottom" data-dropdown-offset-skidding="-250"
    class="btn-link" type="button">
    <div class="flex align-items-start">
        <span id="bell" class="fa-stack" data-count="{{ $unreadNotificationsCount }}">
            <i class="fa-regular fa-bell"></i>
        </span>
    </div>
</button>

<!-- Dropdown menu -->
<div id="dropdownUsers" class="z-10 hidden bg-white rounded-lg shadow w-60 dark:bg-gray-700">
    <div id="dropdownSearch" onShow="bellColor()"
        class="row-col-xs-1 z-10 hidden border border-gray-500 bg-gray-50 shadow" style="width: 500px;">
        <div class="col-xs-1 bg-violet-300">
            <div class="p-3">
                <div id="noticon" class="relative flex justify-between">
                    <h5 class="">
                        <span id="noti" class="">Notifications</span>
                    </h5>
                    @if ($unreadNotificationsCount)
                        <a href="javascript:void(0);" id="mark-all" class="text-slate-400 text-xs mt-0.5 h-0">
                            Mark all as read
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <ul class="p-0 overflow-y-auto overflow-x-hidden text-sm border border-gray-100 left-8 text-gray-700 dark:text-slate-200"
            aria-labelledby="dropdownSearchButton" id="style-15"
            @if ($unreadNotificationsCount > 0) style="max-height: 600px;" @endif>

            @forelse ($unreadNotifications as $notification)
                <div class="hover:bg-green-100">
                    <li class="px-3 pt-3 notify list-group-item list-group-item-action dropdown-notifications-item">
                        <div class="divide-y divide-blue-200 ">
                            <div class="d-flex justify-center align-items-center gap-2 pb-2">
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
                        </div>
                    </li>
                </div>
            @empty
                <li class="dropdown-notifications-list scrollable-container">
                    <ul class="list-group list-group-flush bg-white">
                        <li class="list-group-item list-group-item-action dropdown-notifications-item waves-effect"
                            style="pointer-events: none;">
                            <div class="d-flex justify-center align-items-center gap-2">
                                <div class="pb-4 overflow-hidden w-px-250 flex flex-col align-items-center text-center">
                                    <i class="fa-solid fa-bell-slash fa-3x text-slate-300 my-3"></i>
                                    <span class="text-sm font-bold my-1">No new
                                        notifications
                                        yet.</span>
                                    <span class="text-sm font-normal">When you get new
                                        notifications, they'll show up here</span>
                                </div>
                            </div>
                        </li>
                        <div class="dropdown-menu-footer border-top p-3 bg-gray-100">
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

        @if ($unreadNotificationsCount > 0)
            <div class="bg-gray-100">
                <a href="#"
                    class="hover:text-slate-400 pointer-events-none flex justify-center p-3 text-sm font-medium text-slate-400 border border-gray-200 bg-gray-100">
                    <span class="pointer-events-auto hover:bg-gray-100 hover:text-green-700 hover:underline">See
                        all notification</span>
                </a>
            </div>
        @endif
    </div>
