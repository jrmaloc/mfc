<!-- resources/views/components/select-field.blade.php -->

@props([
    'name' => '',
    'options' => [], // Default to an empty array
    'selected' => '',
    'placeholder' => '',
    'param' => '',
    'error' => '',
    'opParam' => '',
])

<div {{ $attributes->class(['col']) }}>
    <label for="{{ $name }}" class="form-label">{{ $slot }}<i class="text-danger">*</i></label>
    <select id="{{ $name }}" name="{{ $name }}"
        class="form-select form-control @if ($error) select-is-invalid @endif" {{ $param }}>
        <option {{ $opParam }} disabled selected>{{ $placeholder }}</option>
        @foreach ($options as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ $selected == $optionKey ? 'selected' : '' }}>
                {{ $optionValue }}
            </option>
        @endforeach
    </select>
    @if ($error)
        <span class="text-danger">{{ $error }}</span>
    @endif
</div>
