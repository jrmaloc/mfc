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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

<div {{ $attributes->class(['col']) }}>
    <label for="{{ $name }}" class="form-label">{{ $slot }}<i class="text-danger">*</i></label>
    <select id="{{ $name }}" name="{{ $name }}"
        class="select2 form-select form-control @if ($error) select-is-invalid @endif"
        {{ $param }}>
        <option {{ $opParam }}>{{ $placeholder }}</option>
        @foreach ($options as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ $selected === $optionKey ? 'selected' : '' }}>
                {{ $optionValue }}
            </option>
        @endforeach
    </select>
    @if ($error)
        <span class="text-danger">{{ $error }}</span>
    @endif
</div>


<script>
    $(document).ready(function() {
        var item = $('.select2').select2();

        console.log(item);

    });
</script>
