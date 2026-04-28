@if ($paginator->hasPages())
<nav class="flex items-center">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
    <span class="px-3 py-1 text-gray-400 border">&lt;</span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 border hover:bg-gray-100">&lt;</a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
    @if (is_string($element))
    <span class="px-3 py-1 text-gray-400">{{ $element }}</span>
    @endif

    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <span class="px-3 py-1 text-white bg-[#8B7E74]">
        {{ $page }}
    </span>
    @else
    <a href="{{ $url }}" class="px-3 py-1 border hover:bg-gray-100">
        {{ $page }}
    </a>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 border hover:bg-gray-100">&gt;</a>
    @else
    <span class="px-3 py-1 text-gray-400 border">&gt;</span>
    @endif

</nav>
@endif