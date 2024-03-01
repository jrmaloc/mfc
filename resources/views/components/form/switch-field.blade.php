@props([
'name' => '',
'value' => '',
'param' => '',
])

<div {{ $attributes->merge([ 'class' => 'form-check form-switch mb-2',]) }}>
    <input value="Active" class="form-check-input form-control" name="{{ $name }}" type="checkbox" id="{{ $name }}" {{ $param }} @if ( $value  == 'Active') checked @endif/>
    <label class="form-check-label" for="{{ $name }}">{{ $slot }}</label>
</div>
