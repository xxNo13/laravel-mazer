<div class="table-responsive">
    <table class="table table-lg text-center">
        <thead>
            <tr>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>ACCOUNT TYPE</th>
                <th>OFFICE</th>
                <th>TYPE</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($approvals as $approval)
                @if ((Auth::user()->id == $approval->superior1_id && !$approval->superior1_status) || (Auth::user()->id == $approval->superior2_id && !$approval->superior2_status))
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
                        <td>{{ strtoupper($approval->type) }}</td>
                        <td>
                            <div class="hstack gap-2 justify-content-center">
                                <button type="button" class="btn icon btn-info" wire:click="approved({{ $approval->id }})">
                                    <i class="bi bi-check"></i>
                                </button>
                                <button type="button" class="btn icon btn-danger" wire:click="disapproved({{ $approval->id }})">
                                    <i class="bi bi-x"></i>
                                </button>
                                <button type="button" class="btn icon btn-secondary" wire:click="viewed({{ $approval->user_id }}, '{{ $approval->type }}', '{{ 'for-approval' }}')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
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
