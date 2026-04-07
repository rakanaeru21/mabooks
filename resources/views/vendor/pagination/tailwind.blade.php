@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        {{-- Mobile view --}}
        <div class="flex gap-2 items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 cursor-not-allowed rounded-xl">
                    <i class="fas fa-chevron-left text-xs mr-1"></i> Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-orange-50 hover:text-orange-600 hover:border-orange-200 transition-colors">
                    <i class="fas fa-chevron-left text-xs mr-1"></i> Sebelumnya
                </a>
            @endif

            <span class="text-sm text-gray-500">{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-orange-50 hover:text-orange-600 hover:border-orange-200 transition-colors">
                    Berikutnya <i class="fas fa-chevron-right text-xs ml-1"></i>
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 cursor-not-allowed rounded-xl">
                    Berikutnya <i class="fas fa-chevron-right text-xs ml-1"></i>
                </span>
            @endif
        </div>

        {{-- Desktop view --}}
        <div class="hidden sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-500">
                    Menampilkan
                    @if ($paginator->firstItem())
                        <span class="font-semibold text-gray-700">{{ $paginator->firstItem() }}</span>
                        sampai
                        <span class="font-semibold text-gray-700">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    dari
                    <span class="font-semibold text-gray-700">{{ $paginator->total() }}</span>
                    data
                </p>
            </div>

            <div>
                <span class="inline-flex items-center gap-1">
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="w-9 h-9 inline-flex items-center justify-center text-gray-300 bg-gray-100 border border-gray-200 cursor-not-allowed rounded-lg" aria-hidden="true">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="w-9 h-9 inline-flex items-center justify-center text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-orange-50 hover:text-orange-600 hover:border-orange-200 transition-colors" aria-label="{{ __('pagination.previous') }}">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </a>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="w-9 h-9 inline-flex items-center justify-center text-sm text-gray-400 cursor-default">{{ $element }}</span>
                            </span>
                        @endif
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="w-9 h-9 inline-flex items-center justify-center text-sm font-semibold text-white bg-orange-500 border border-orange-500 rounded-lg cursor-default shadow-sm">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="w-9 h-9 inline-flex items-center justify-center text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-orange-50 hover:text-orange-600 hover:border-orange-200 transition-colors" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="w-9 h-9 inline-flex items-center justify-center text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-orange-50 hover:text-orange-600 hover:border-orange-200 transition-colors" aria-label="{{ __('pagination.next') }}">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="w-9 h-9 inline-flex items-center justify-center text-gray-300 bg-gray-100 border border-gray-200 cursor-not-allowed rounded-lg" aria-hidden="true">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
