@props([
    'title',
    'value',
    'icon',
    'color' => 'blue',
    'link' => null,
    'description' => null
])

<div class="bg-gradient-to-r from-{{ $color }}-500 to-{{ $color }}-600 overflow-hidden shadow rounded-lg">
    <div class="p-5">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                {!! $icon !!}
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-{{ $color }}-100 truncate">{{ $title }}</dt>
                    <dd class="text-lg font-medium text-white">{{ $value }}</dd>
                </dl>
            </div>
        </div>
    </div>
    @if($link || $description)
    <div class="bg-{{ $color }}-700 px-5 py-3">
        <div class="text-sm">
            @if($link)
                <a href="{{ $link }}" class="font-medium text-{{ $color }}-200 hover:text-white">
                    {{ $description ?? 'View details' }}
                </a>
            @else
                <span class="font-medium text-{{ $color }}-200">
                    {{ $description }}
                </span>
            @endif
        </div>
    </div>
    @endif
</div>