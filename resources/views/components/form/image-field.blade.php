@props([
'name' =>'',
'id' =>'',
'uploaded' => '',
'src' => '',
])

<div class="d-flex align-items-start align-items-sm-center gap-4 mb-8">
    <img src="{{ $src }}" class="d-block w-px-120 h-px-120 rounded" id="{{ $uploaded }}" />
    <div class="button-wrapper">
        <label for="{{ $id }}" class="btn btn-success me-2 mb-3" tabindex="0">
            <span class="d-none d-sm-block">{{ $slot }}</span>
            <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
            <input type="file" id="{{ $id }}" name="{{ $name }}" class="account-file-input" hidden
                accept="image/png, image/jpeg" />
        </label>
        <div class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K</div>
    </div>
</div>