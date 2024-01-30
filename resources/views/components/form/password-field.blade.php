@props([
'name' => '',
'error' => '',
])

<div {{ $attributes->class(['form-password-toggle']) }}>
    <label class="form-label" for="{{ $name }}">{{ $slot }}<i class="text-danger">*</i></label>
    <div class="input-group input-group-merge ">
        <input type="password" name="{{ $name }}" id="{{ $name }}" class="form-control .alert-danger"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
        <span class="input-group-text cursor-pointer toggle-password" onclick="togglePassword('{{ $name }}')"><i
                class="mdi mdi-eye-off-outline"></i></span>
    </div>
    @if($error)
    <span class="text-danger">{{ $error }}</span>
    @endif
</div>