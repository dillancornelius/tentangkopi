@foreach (['success', 'error'] as $type)
    @if (session($type))
        <div class="flash flash--{{ $type }}" role="{{ $type === 'error' ? 'alert' : 'status' }}">
            <x-icon :name="$type === 'error' ? 'info' : 'check'" />
            <span>{{ session($type) }}</span>
        </div>
    @endif
@endforeach
