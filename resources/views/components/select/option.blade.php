@props([
    'value' => null,
    'disabled' => false,
])

<option value="{{ $value }}" @if($disabled) disabled @endif {{ $attributes }}>{{ $slot }}</option>
