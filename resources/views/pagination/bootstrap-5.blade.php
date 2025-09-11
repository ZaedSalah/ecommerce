@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="d-flex justify-content-between align-items-center">
        <div>
            <p class="text-sm text-gray-700 leading-5">
                عرض {{ $paginator->firstItem() }} إلى {{ $paginator->lastItem() }} من أصل {{ $paginator->total() }}
                نتيجة
            </p>
        </div>
        <ul class="pagination mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">« السابق</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">«
                        السابق</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">التالي
                        »</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">التالي »</span></li>
            @endif
        </ul>
    </nav>
@endif
