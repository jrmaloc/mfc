@props([
'reset' => '',
'submit' => '',
])

<div {{ $attributes->merge([ 'class' => 'my-4 flex justify-end']) }}>
    <button type="reset" class="btn btn-outline-info">{{ $reset }}</button>
    <button type="submit" class="btn btn-success ml-2">{{ $submit }}</button>
    {{ $slot }}
</div>
