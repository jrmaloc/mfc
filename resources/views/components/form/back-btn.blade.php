@props([
'route' => ''
])

<div class="flex justify-end">
    <a href="{{ route($route) }}" class="my-4 btn btn-dark">
        {{ $slot }} <i class="tf-icons mdi mdi-arrow-u-left-top ml-2"></i>
    </a>
</div>