<div>
    @forelse ($assignments as $assignment)
        <li>
            <a href="{{ route('ttma') }}" class="dropdown-item">
            @if (isset($assignment->remarks))
                <i class="bi bi-check"></i>
            @endif
            {{ $assignment->output }} <br>
                <span class="text-muted fst-italic">{{ $assignment->created_at->diffForHumans() }}</span>
            </a>
        </li>
    @empty
        <li><a class="dropdown-item">No notification available</a></li>
    @endforelse
</div>
