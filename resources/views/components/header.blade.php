<header class="relative flex justify-center items-center bg-white border-b border-gray-200 py-5">
    <h1 class="text-4xl text-[#82776b] font-serif">
        FashionablyLate
    </h1>

    @if (isset($right) && $right->isNotEmpty())
        <div class="absolute right-0 mr-5 bg-[#faf8f6] border border-[#ebdccb] w-20 h-8 mr-24 text-[#d4c6b6]">
            {{ $right }}
        </div>
    @endif
</header>