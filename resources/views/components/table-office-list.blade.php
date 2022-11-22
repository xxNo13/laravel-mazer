<div class="table-responsive">
    <table class="table table-lg text-center">
        <thead>
            <tr>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>ACCOUNT TYPE</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                @if ($user->office_id == Auth::user()->office_id)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach ($user->account_types as $account_type)
                                @if ($loop->last)
                                    {{ $account_type->account_type }}
                                    @break
                                @endif
                                {{ $account_type->account_type }}, 
                            @endforeach
                        </td>
                        <td>
                            <div class="d-md-flex gap-3 justify-content-center">
                                @if (isset($duration))
                                    @if ($user->account_types->contains(1) || $user->account_types->contains(6))
                                        <button type="button" class="btn icon icon-left btn-secondary" wire:click="viewed({{ $user->id }}, '{{ 'officemates' }}', '{{ 'faculty' }}')">
                                            <i class="bi bi-eye"></i> 
                                            IPCR (Faculty)
                                        </button>
                                    @endif
                                    
                                    @if ($user->account_types->contains(2))
                                        <button type="button" class="btn icon icon-left btn-secondary" wire:click="viewed({{ $user->id }}, '{{ 'officemates' }}', '{{ 'staff' }}')">
                                            <i class="bi bi-eye"></i> 
                                            IPCR (Staff)
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="5">No record available!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>