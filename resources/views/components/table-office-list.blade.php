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
                            <button type="button" class="btn icon btn-secondary" wire:click="viewed({{ $user->id }}, '{{ 'officemates' }}')">
                                <i class="bi bi-eye"></i>
                            </button>
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