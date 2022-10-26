<div>
    <a class="d-flex align-items-center nav-link active dropdown-toggle" href="" data-bs-toggle="dropdown"
        aria-expanded="false">
        <div class="">
            @foreach (Auth::user()->unreadNotifications as $notif)
                @if (!$notif->read_at)
                    @php
                        $unreads++
                    @endphp
                @endif
                @if ($loop->last)
                    @if ($unreads >= 1)
                        <p class="float-end fs-6 rounded-circle bg-danger px-2 text-white">
                            {{ $unreads }}
                        </p>
                    @endif
                @endif
            @endforeach
            <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end overflow-auto" aria-labelledby="dropdownMenuButton"
        style="max-height: 500px;">
        <li>
            <h6 class="dropdown-header">Notifications</h6>
        </li>
        @forelse (Auth::user()->notifications as $notification)
            @if (isset($notification->data['remarks']))
                <li>
                    <button wire:click="read('{{ $notification->id }}')" class="dropdown-item">
                        <div class="d-flex align-items-center">
                            <div style="width: 90%;">
                                <div class="text-truncate fw-bold">
                                    <span>Marked as Done:</span>
                                </div>
                                <div class="text-truncate">
                                    {{ $notification->data['subject'] }} - {{ $notification->data['output'] }}
                                </div>
                                <div>
                                    <span
                                        class="text-muted fst-italic">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="text-primary hstack" style="width: 10%;">
                                @if (empty($notification->read_at))
                                    <span class="ms-auto">
                                        <i class="bi bi-circle-fill"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </button>
                </li>
            @else
                <li>
                    <button wire:click="read('{{ $notification->id }}')" class="dropdown-item">
                        <div class="d-flex align-items-center">
                            <div style="width: 90%;">
                                <div class="text-truncate fw-bold">
                                    <span>Assigned Task:</span>
                                </div>
                                <div class="text-truncate">
                                    {{ $notification->data['subject'] }} - {{ $notification->data['output'] }}
                                </div>
                                <div>
                                    <span
                                        class="text-muted fst-italic">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="text-primary hstack" style="width: 10%;">
                                @if (empty($notification->read_at))
                                    <span class="ms-auto">
                                        <i class="bi bi-circle-fill"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </button>
                </li>
            @endif
        @empty
            <li><a class="dropdown-item">No notification available</a></li>
        @endforelse
    </ul>
</div>
