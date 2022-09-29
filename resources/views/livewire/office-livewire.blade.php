<div>
    <option value="">Select Office</option>
    @foreach ($offices as $office)
        @if (old('office_id') && old('office_id') == $office->id)
            <option value="{{ $office->id }}" selected>{{ $office->office }}</option>
        @else
            <option value="{{ $office->id }}">{{ $office->office }}</option>
        @endif
    @endforeach
</div>