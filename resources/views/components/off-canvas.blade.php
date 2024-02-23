@props([
    'btn_name' => '',
    'title' => '',
    'id' => '',
    'class' => '',
])

<!-- End Offcanvas -->
<div class="col-xl-2 col-lg-2 col-md-6 flex justify-end">
    <div class="mt-3">
        <button id="offcanvasbtn" class="btn btn-primary {{ $class }}" type="button" data-bs-toggle="offcanvas" data-bs-target="#{{ $id }}"
            aria-controls="{{ $id }}">
            {{ $btn_name }} <span class="ml-1 mdi mdi-plus"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="{{ $id }}" aria-labelledby="{{ $id }}Label" style="width: 27% !important;">
            <div class="offcanvas-header">
                <h5 id="{{ $id }}Label" class="offcanvas-title">{{ $title }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
