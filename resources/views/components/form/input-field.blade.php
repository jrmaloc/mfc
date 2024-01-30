@props([
    'name' => '',
    'type' => '',
    'placeholder' => '',
    'value' => '',
    'error' => '',
    'icon' => '',
    'param' => '',
])

<div {{ $attributes->class(['col']) }}>
    <label for="{{ $name }}" class="form-label">{{ $slot }}<i class="text-danger">*</i></label>
    <div class="input-group input-group-merge">
        <span class="input-group-text @if ($error) is-invalid @endif"><i
                class="mdi mdi-{{ $icon }}"></i></span>
        <input name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" type="{{ $type }}"
            class="form-control @if ($error) is-invalid @endif" placeholder="{{ $placeholder }}"
            required {{ $param }} />
    </div>
    @if ($error)
        <span class="text-danger">{{ $error }}</span>
    @endif
</div>
