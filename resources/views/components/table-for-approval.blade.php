<div class="table-responsive">
    <table class="table table-lg text-center">
        <thead>
            <tr>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>ACCOUNT TYPE</th>
                <th>OFFICE</th>
                <th>PURPOSE</th>
                <th>TYPE</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($approvals as $approval)
                @if ((Auth::user()->id == $approval->superior1_id || Auth::user()->id == $approval->superior2_id) &&
                    ($duration && $approval->duration_id == $duration->id))
                    <tr>
                        <td>{{ $approval->user->name }}</td>
                        <td>{{ $approval->user->email }}</td>
                        <td>
                            @foreach ($approval->user->account_types as $account_type)
                                @if ($loop->last)
                                    {{ $account_type->account_type }}
                                @break
                            @endif
                            {{ $account_type->account_type }},
                        @endforeach
                    </td>
                    <td>{{ $approval->user->office->office }}, {{ $approval->user->office->building }}</td>
                    <td>{{ $approval->name }}</td>
                    <td>{{ strtoupper($approval->type) }}
                        @if ($approval->type != 'opcr')
                            - {{ strtoupper($approval->user_type) }}
                        @endif
                    </td>
                    <td>
                        @if (Auth::user()->id == $approval->superior1_id)
                            @if ($approval->superior1_status == 1)
                                Approved
                            @elseif ($approval->superior1_status == 2)
                                Disapproved
                            @else
                                @if ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d'))
                                    <div class="hstack gap-2 justify-content-center">
                                        <button type="button" class="btn icon btn-info"
                                            wire:click="approved({{ $approval->id }})">
                                            <i class="bi bi-check"></i>
                                        </button>
                                        <button type="button" class="btn icon btn-danger"
                                            wire:click="disapproved({{ $approval->id }})">
                                            <i class="bi bi-x"></i>
                                        </button>
                                        <button type="button" class="btn icon btn-secondary"
                                            wire:click="viewed({{ $approval->user_id }}, '{{ $approval->type }}', '{{ 'for-approval' }}', '{{ $approval->user_type }}')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                @endif
                            @endif
                        @elseif (Auth::user()->id == $approval->superior2_id)
                            @if ($approval->superior2_status == 1)
                                Approved
                            @elseif ($approval->superior2_status == 2)
                                Disapproved
                            @else
                                @if ($duration && $duration->start_date <= date('Y-m-d') && $duration->end_date >= date('Y-m-d'))
                                    <div class="hstack gap-2 justify-content-center">
                                        <button type="button" class="btn icon btn-info"
                                            wire:click="approved({{ $approval->id }})">
                                            <i class="bi bi-check"></i>
                                        </button>
                                        <button type="button" class="btn icon btn-danger"
                                            wire:click="disapproved({{ $approval->id }})">
                                            <i class="bi bi-x"></i>
                                        </button>
                                        <button type="button" class="btn icon btn-secondary"
                                            wire:click="viewed({{ $approval->user_id }}, '{{ $approval->type }}', '{{ 'for-approval' }}', '{{ $approval->user_type }}')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                @endif
                            @endif
                        @endif
                    </td>
                </tr>
                @endif
            @empty
                <tr>
                    <td colspan="6">No record available!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
