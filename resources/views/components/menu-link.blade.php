@props(['routeName', 'title' => ''])

<li {{ $attributes->merge(['class' => 'menu-item']) }}>
    <a href="{{ $routeName }}" class="menu-link">
        <div data-i18n="{{ $title }}" class="ml-4">{{ $title }}</div>
    </a>
    {{ $slot }}
</li>
