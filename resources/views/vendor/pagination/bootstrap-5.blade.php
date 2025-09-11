@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">

        {{-- الكليشة أسفل الأزرار --}}
        <p class="text-center mb-3">
            عرض نتيجة
            {{ $paginator->firstItem() }} إلى {{ $paginator->lastItem() }} من أصل {{ $paginator->total() }}
        </p>
        <ul class="pagination justify-content-center mb-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">« السابق</span></li>
            @else
                <li class="page-item"><a class="page-link mx-4" href="{{ $paginator->previousPageUrl() }}" rel="prev">«
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
