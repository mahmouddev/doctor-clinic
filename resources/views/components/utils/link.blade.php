@props(['active' => '', 'text' => '', 'hide' => false, 'icon' => false, 'permission' => false])

<li>
    <div class="row align-items-center">
        @if ($permission)
            @if ($logged_in_user->can($permission))
                @if (!$hide)
                    <a {{ $attributes->merge(['href' => '#', 'class' => $active]) }}>
                        @if ($icon)<span class="{{ $icon }}"></span> @endif
                        <span class="align-items-center">{{ strlen($text) ? $text : $slot }}</span>
                    </a>
                @endif
            @endif
        @else
            @if (!$hide)
                <a {{ $attributes->merge(['href' => '#', 'class' => $active]) }}>
                    @if ($icon)<span class="{{ $icon }}"></span> @endif
                    <span class="align-items-center">{{ strlen($text) ? $text : $slot }}</span>
                </a>
            @endif
        @endif
    </div>
</li>
